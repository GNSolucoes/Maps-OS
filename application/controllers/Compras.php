<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Compras extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('compras_model');
        $this->load->model('produtos_model');
        $this->load->model('clientes_model');
        $this->data['menuCompras'] = 'Compras';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar compras.');
            redirect(base_url());
        }

        $this->load->library('pagination');

        $this->data['configuration']['base_url'] = site_url('compras/gerenciar/');
        $this->data['configuration']['total_rows'] = $this->compras_model->count();

        $this->pagination->initialize($this->data['configuration']);

        $this->data['results'] = $this->compras_model->get(
            '',
            $this->data['configuration']['per_page'],
            $this->uri->segment(3)
        );

        $this->data['view'] = 'compras/compras';
        return $this->layout();
    }

    public function adicionar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar compras.');
            redirect(base_url());
        }

        $this->data['numero_compra'] = $this->compras_model->generateNumeroCompra();
        $this->data['fornecedores'] = $this->clientes_model->get('clientes', '*', 'fornecedor = 1');
        $this->data['view'] = 'compras/adicionarCompra';

        return $this->layout();
    }

    public function salvar()
    {
        $data = [
            'numero_compra' => $this->input->post('numero_compra'),
            'fornecedor_id' => $this->input->post('fornecedor_id'),
            'data_compra' => $this->input->post('data_compra'),
            'data_entrega' => $this->input->post('data_entrega') ?: null,
            'status' => $this->input->post('status'),
            'desconto' => $this->input->post('desconto') ?: 0,
            'frete' => $this->input->post('frete') ?: 0,
            'observacoes' => $this->input->post('observacoes'),
            'usuario_id' => $this->session->userdata('id'),
        ];

        $compra_id = $this->compras_model->add($data);

        if ($compra_id) {
            // Adicionar itens
            $produtos = $this->input->post('produtos');
            $quantidades = $this->input->post('quantidades');
            $precos = $this->input->post('precos');
            $valor_total = 0;

            if ($produtos && is_array($produtos)) {
                foreach ($produtos as $index => $produto_id) {
                    if ($produto_id && $quantidades[$index] && $precos[$index]) {
                        $subtotal = $quantidades[$index] * $precos[$index];
                        $valor_total += $subtotal;

                        $item_data = [
                            'compra_id' => $compra_id,
                            'produto_id' => $produto_id,
                            'quantidade' => $quantidades[$index],
                            'preco_unitario' => $precos[$index],
                            'subtotal' => $subtotal,
                        ];
                        $this->compras_model->addItem($item_data);
                    }
                }
            }

            // Atualizar valor total
            $valor_total = $valor_total - $data['desconto'] + $data['frete'];
            $this->compras_model->edit($compra_id, ['valor_total' => $valor_total]);

            // Capturar dados de pagamento do formulário
            $situacao_pagamento = $this->input->post('situacao_pagamento');
            $forma_pagamento = $this->input->post('forma_pagamento');

            // Criar registro de pagamento (Contas a Pagar associada à Compra)
            $pagamento = [
                'compra_id' => $compra_id,
                'valor' => $valor_total,
                'data_vencimento' => $data['data_compra'],
                'data_pagamento' => ($situacao_pagamento == 'pago') ? $data['data_compra'] : null,
                'status' => $situacao_pagamento, // pago ou pendente
                'forma_pagamento' => $forma_pagamento,
                'observacao' => 'Gerado na criação da compra.'
            ];
            $this->compras_model->addPagamento($pagamento);

            // Gerar Lançamento no Financeiro Global (tabela lancamentos)
            // Se estiver pago, cria como Despesa Realizada. Se pendente, Despesa Prevista.
            $this->compras_model->sincronizarFinanceiro($compra_id);

            // Se o status for recebido, processar estoque
            if ($data['status'] == 'recebido') {
                $this->compras_model->atualizarEstoque($compra_id);
                $this->session->set_flashdata('success', 'Compra cadastrada, recebida e estoque atualizado!');
            } else {
                $this->session->set_flashdata('success', 'Compra cadastrada e financeiro gerado!');
            }
            
            log_info('Adicionou uma compra.');
            redirect(site_url('compras/editar/' . $compra_id));
        } else {
            $this->session->set_flashdata('error', 'Erro ao cadastrar compra.');
            redirect(site_url('compras'));
        }
    }

    public function editar()
    {
        if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não encontrado.');
            redirect('compras');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar compras.');
            redirect(base_url());
        }

        $this->data['result'] = $this->compras_model->getById($this->uri->segment(3));
        $this->data['itens'] = $this->compras_model->getItens($this->uri->segment(3));
        $this->data['pagamentos'] = $this->compras_model->getPagamentos($this->uri->segment(3));
        $this->data['fornecedores'] = $this->clientes_model->get('clientes', '*', 'fornecedor = 1');
        $this->data['view'] = 'compras/editarCompra';

        return $this->layout();
    }

    public function receberCompra()
    {
        $compra_id = $this->input->post('compra_id');

        // Atualizar status
        $this->compras_model->edit($compra_id, ['status' => 'recebido']);

        // Atualizar estoque
        $this->compras_model->atualizarEstoque($compra_id);

        // Criar lançamentos
        $this->compras_model->criarLancamentos($compra_id);

        $this->session->set_flashdata('success', 'Compra recebida! Estoque atualizado e contas a pagar geradas.');
        redirect(site_url('compras/editar/' . $compra_id));
    }

    public function excluir()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir compras.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        
        if ($id == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir compra.');
            redirect(site_url('compras'));
        }

        $this->compras_model->delete($id);
        log_info('Removeu uma compra. ID: ' . $id);
        
        $this->session->set_flashdata('success', 'Compra excluída com sucesso!');
        redirect(site_url('compras'));
    }

    public function autoCompleteProduto()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->produtos_model->autoCompleteProduto($q);
        }
    }
}
