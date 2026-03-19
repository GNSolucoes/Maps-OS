<?php
class Pdv_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCaixaAberto($usuario_id)
    {
        $this->db->where('usuario_id', $usuario_id);
        $this->db->where('status', 'aberto');
        $this->db->limit(1);
        return $this->db->get('caixas')->row();
    }

    public function abrirCaixa($data)
    {
        if($this->db->insert('caixas', $data)) {
            return $this->db->insert_id();
        }
        log_message('error', 'Erro ao abrir caixa PDV: ' . print_r($this->db->error(), true));
        return false;
    }

    public function fecharCaixa($id, $data)
    {
        $this->db->where('idCaixa', $id);
        $this->db->update('caixas', $data);
        return $this->db->affected_rows() > 0;
    }

    public function getProdutos($termo)
    {
        $this->db->select('idProdutos, descricao, precoVenda, estoque, foto');
        $this->db->like('descricao', $termo);
        $this->db->or_where('codDeBarra', $termo);
        $this->db->where('estoque >', 0);
        $this->db->limit(10);
        return $this->db->get('produtos')->result();
    }
    
    public function registrarVenda($venda, $itens)
    {
        $this->db->trans_start();

        // Verificar estoque primeiro
        foreach($itens as $item) {
            $produto = $this->db->select('estoque, descricao')->where('idProdutos', $item['idProduto'])->get('produtos')->row();
            if($produto->estoque < $item['quantidade']) {
                $this->db->trans_rollback(); // Garante rollback se já tivesse começado algo (embora aqui seja a primeira coisa)
                return ['result' => false, 'message' => 'Estoque insuficiente para: ' . $produto->descricao];
            }
        }
        
        // Inserir Venda
        $this->db->insert('vendas', $venda);
        $idVenda = $this->db->insert_id();
        
        // Inserir Itens
        foreach($itens as $item) {
            $dataItem = [
                'vendas_id' => $idVenda,
                'produtos_id' => $item['idProduto'],
                'quantidade' => $item['quantidade'],
                'preco' => $item['preco']
            ];
            $this->db->insert('itens_de_vendas', $dataItem);
            
            // Baixar Estoque
            $this->db->set('estoque', 'estoque - ' . $item['quantidade'], FALSE);
            $this->db->where('idProdutos', $item['idProduto']);
            $this->db->update('produtos');
        }
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return ['result' => false, 'message' => 'Erro ao processar venda no banco de dados.'];
        }
        
        return ['result' => true, 'idVenda' => $idVenda];
    }

    public function registrarSangria($data)
    {
        return $this->db->insert('lancamentos', $data);
    }

    public function registrarSuprimento($data)
    {
        return $this->db->insert('lancamentos', $data);
    }
    
    public function getVendasPorFormaPagamento($idCaixa)
    {
        $this->db->select('forma_pgto, SUM(valorTotal) as total');
        $this->db->where('caixa_id', $idCaixa);
        $this->db->group_by('forma_pgto');
        return $this->db->get('vendas')->result();
    }
}
