<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pdv extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pdv_model');
        $this->data['menuPdv'] = 'PDV';
    }

    public function index()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para acessar o PDV.');
            redirect(base_url());
        }
        
        $usuario_id = $this->session->userdata('id_admin');
        $caixa = $this->Pdv_model->getCaixaAberto($usuario_id);
        
        if(!$caixa) {
            redirect(site_url('pdv/abertura'));
        }

        $this->data['caixa'] = $caixa;
        $this->data['view'] = 'pdv/index'; // Interface do PDV
        // O PDV geralmente não usa o layout padrão com menu lateral e topo, 
        // mas vamos manter o layout por enquanto ou fazer uma view fullpage.
        return $this->layout(); 
    }

    public function abertura()
    {
        $this->data['view'] = 'pdv/abertura';
        return $this->layout();
    }
    
    public function abrirCaixa()
    {
        if(!$this->session->userdata('id_admin')){
            $this->session->set_flashdata('error', 'Sessão expirada. Faça login novamente.');
            redirect(base_url() . 'index.php/mapos/login');
        }

        $saldo_inicial = $this->input->post('saldo_inicial');
        // Converter formato BRL (1.000,00) para Float (1000.00)
        $saldo_inicial = str_replace('.', '', $saldo_inicial);
        $saldo_inicial = str_replace(',', '.', $saldo_inicial);
        $saldo_inicial = floatval($saldo_inicial);
        
        $data = [
            'usuario_id' => $this->session->userdata('id_admin'),
            'data_abertura' => date('Y-m-d H:i:s'),
            'saldo_inicial' => $saldo_inicial,
            'status' => 'aberto'
        ];
        
        // Debug
        // file_put_contents('application/logs/debug_caixa.txt', print_r($data, true));
        
        if($this->Pdv_model->abrirCaixa($data)) {
            redirect(site_url('pdv'));
        } else {
             $error_msg = 'Erro ao abrir caixa. Tente novamente.';
             $this->session->set_flashdata('error', $error_msg);
             redirect(site_url('pdv/abertura'));
        }
    }
    
    public function fecharCaixa()
    {
        if(!$this->session->userdata('id_admin')){
             echo json_encode(['result' => false, 'message' => 'Sessão expirada.']);
             return;
        }
        
        $caixa = $this->Pdv_model->getCaixaAberto($this->session->userdata('id_admin'));
        if(!$caixa) {
             echo json_encode(['result' => false, 'message' => 'Nenhum caixa aberto encontrado.']);
             return;
        }

        $saldo_final = $this->input->post('saldo_final');
        // Converter formato BRL se necessário
        $saldo_final = str_replace('.', '', $saldo_final);
        $saldo_final = str_replace(',', '.', $saldo_final);
        $saldo_final = floatval($saldo_final);
        
        $data = [
            'data_fechamento' => date('Y-m-d H:i:s'),
            'saldo_final' => $saldo_final,
            'status' => 'fechado'
        ];
        
        if($this->Pdv_model->fecharCaixa($caixa->idCaixa, $data)) {
             echo json_encode(['result' => true, 'message' => 'Caixa fechado com sucesso!']);
        } else {
             echo json_encode(['result' => false, 'message' => 'Erro ao fechar caixa.']);
        }
    }

    public function getResumoCaixa()
    {
        try {
            if(!$this->session->userdata('id_admin')){
                 echo json_encode(['result' => false, 'message' => 'Sessão expirada.']);
                 return;
            }
            
            $caixa = $this->Pdv_model->getCaixaAberto($this->session->userdata('id_admin'));
            if(!$caixa) {
                 echo json_encode(['result' => false, 'message' => 'Nenhum caixa aberto.']);
                 return;
            }
            
            // Auto-fix DB: Check if 'forma_pgto' column exists in 'vendas'
            if(!$this->db->field_exists('forma_pgto', 'vendas')){
                 $this->db->query("ALTER TABLE vendas ADD COLUMN forma_pgto VARCHAR(50) DEFAULT 'Dinheiro'");
            }
            
            // Vendas por forma de pagamento
            $vendas_result = $this->Pdv_model->getVendasPorFormaPagamento($caixa->idCaixa);
            $vendas = [];
            if($vendas_result) {
                foreach($vendas_result as $v) {
                    $vendas[] = [
                        'forma_pgto' => $v->forma_pgto,
                        'total' => (float) $v->total
                    ];
                }
            }
            
            // Calcular sangrias e suprimentos
            // Usando Query direta para evitar problemas com Query Builder
            $sql = "SELECT tipo, SUM(valor) as total FROM lancamentos 
                    WHERE usuarios_id = ? 
                    AND data_pagamento >= ? 
                    AND (descricao LIKE ? OR descricao LIKE ?) 
                    GROUP BY tipo";
            
            // Verifica data_abertura
            $data_abertura = isset($caixa->data_abertura) ? date('Y-m-d', strtotime($caixa->data_abertura)) : date('Y-m-d');
            
            $lancamentos = $this->db->query($sql, [
                $this->session->userdata('id_admin'), 
                $data_abertura,
                'Sangria PDV%', 
                'Suprimento PDV%'
            ])->result();
            
            $total_sangria = 0.0;
            $total_suprimento = 0.0;
            
            if($lancamentos){
                foreach($lancamentos as $l) {
                    if($l->tipo == 'despesa') $total_sangria = (float) $l->total;
                    if($l->tipo == 'receita') $total_suprimento = (float) $l->total;
                }
            }
            
            $total_vendas = 0.0;
            $total_vendas_dinheiro = 0.0;
            
            foreach($vendas as $v) {
                $total_vendas += $v['total'];
                if($v['forma_pgto'] == 'Dinheiro') $total_vendas_dinheiro += $v['total'];
            }
            
            $saldo_inicial = (float) $caixa->saldo_inicial;
            $saldo_atual = $saldo_inicial + $total_vendas_dinheiro + $total_suprimento - $total_sangria;
            
            echo json_encode([
                'result' => true,
                'vendas' => $vendas,
                'saldo_inicial' => $saldo_inicial,
                'total_sangria' => $total_sangria,
                'total_suprimento' => $total_suprimento,
                'saldo_atual' => $saldo_atual
            ]);
        } catch (Exception $e) {
            echo json_encode(['result' => false, 'message' => 'Erro interno: ' . $e->getMessage()]);
        }
    }
    
    public function get_produtos()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
             echo json_encode([]);
             return;
        }
        
        $term = $this->input->get('term');
        $produtos = $this->Pdv_model->getProdutos($term);
        echo json_encode($produtos);
    }
    
    public function finalizar_venda()
    {
        // Receber JSON da venda via POST
        $data = json_decode(file_get_contents('php://input'), true);
        
        if(!$data || empty($data['itens'])) {
            echo json_encode(['result' => false, 'message' => 'Nenhum item na venda.']);
            return;
        }
        
        $caixa = $this->Pdv_model->getCaixaAberto($this->session->userdata('id_admin'));
        if(!$caixa) {
             echo json_encode(['result' => false, 'message' => 'Caixa fechado.']);
             return;
        }

        $venda = [
            'dataVenda' => date('Y-m-d'),
            'clientes_id' => 1, // Cliente Padrão (Consumidor Final) - ID 1 deve existir
            'usuarios_id' => $this->session->userdata('id_admin'),
            'faturado' => 1, // PDV já sai faturado se pago
            'caixa_id' => $caixa->idCaixa,
            'valorTotal' => $data['total'],
            'forma_pgto' => isset($data['formaPgto']) ? $data['formaPgto'] : 'Dinheiro', // Salvar forma de pagamento
            'desconto' => 0,
            'produtos_id' => null
        ];
        
        $retorno = $this->Pdv_model->registrarVenda($venda, $data['itens']);

        if($retorno['result']) {
            echo json_encode(['result' => true, 'idVenda' => $retorno['idVenda']]);
        } else {
            echo json_encode(['result' => false, 'message' => isset($retorno['message']) ? $retorno['message'] : 'Erro ao salvar venda.']);
        }
    }

    public function imprimirA4($idVenda)
    {
         if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
              $this->session->set_flashdata('error', 'Você não tem permissão.');
              redirect(base_url());
         }

         $this->load->model('vendas_model');
         $this->data['result'] = $this->vendas_model->getById($idVenda);
         $this->data['produtos'] = $this->vendas_model->getProdutos($idVenda);
         $this->data['emitente'] = $this->Mapos_model->getEmitente();

         // Usar view de impressão térmica ou A4 simplificada
         $this->load->view('pdv/imprimirCupom', $this->data);
    }

    public function sangria()
    {
        if(!$this->session->userdata('id_admin')){
             echo json_encode(['result' => false, 'message' => 'Sessão expirada.']);
             return;
        }
        
        $valor = $this->input->post('valor');
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        $valor = floatval($valor);
        
        $obs = $this->input->post('observacao');
        
        $data = [
            'descricao' => 'Sangria PDV - ' . $obs,
            'valor' => $valor,
            'data_vencimento' => date('Y-m-d'),
            'data_pagamento' => date('Y-m-d'),
            'baixado' => 1,
            'cliente_fornecedor' => 'Sangria PDV',
            'forma_pgto' => 'Dinheiro',
            'tipo' => 'despesa',
            'usuarios_id' => $this->session->userdata('id_admin')
        ];
        
        if($this->Pdv_model->registrarSangria($data)) {
            echo json_encode(['result' => true, 'message' => 'Sangria realizada!']);
        } else {
            echo json_encode(['result' => false, 'message' => 'Erro ao registrar sangria.']);
        }
    }

    public function suprimento()
    {
        if(!$this->session->userdata('id_admin')){
             echo json_encode(['result' => false, 'message' => 'Sessão expirada.']);
             return;
        }
        
        $valor = $this->input->post('valor');
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        $valor = floatval($valor);
        
        $obs = $this->input->post('observacao');
        
        $data = [
            'descricao' => 'Suprimento PDV - ' . $obs,
            'valor' => $valor,
            'data_vencimento' => date('Y-m-d'),
            'data_pagamento' => date('Y-m-d'),
            'baixado' => 1,
            'cliente_fornecedor' => 'Suprimento PDV',
            'forma_pgto' => 'Dinheiro',
            'tipo' => 'receita',
            'usuarios_id' => $this->session->userdata('id_admin')
        ];
        
        if($this->Pdv_model->registrarSuprimento($data)) {
            echo json_encode(['result' => true, 'message' => 'Suprimento realizado!']);
        } else {
            echo json_encode(['result' => false, 'message' => 'Erro ao registrar suprimento.']);
        }
    }
}
