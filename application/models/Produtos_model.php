<?php

class Produtos_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idProdutos', 'desc');
        $this->db->limit($perpage, $start);
        if ($where) {
            $this->db->like('codDeBarra', $where);
            $this->db->or_like('descricao', $where);
        }

        $query = $this->db->get();

        $result = ! $one ? $query->result() : $query->row();

        return $result;
    }

    public function getById($id)
    {
        $this->db->where('idProdutos', $id);
        $this->db->limit(1);

        return $this->db->get('produtos')->row();
    }

    public function add($table, $data)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
            return true;
        }

        return false;
    }

    public function edit($table, $data, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0) {
            return true;
        }

        return false;
    }

    public function delete($table, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1') {
            return true;
        }

        return false;
    }

    public function count($table)
    {
        return $this->db->count_all($table);
    }

    public function updateEstoque($produto, $quantidade, $operacao = '-')
    {
        $sql = "UPDATE produtos set estoque = estoque $operacao ? WHERE idProdutos = ?";

        return $this->db->query($sql, [$quantidade, $produto]);
    }

    public function autoCompleteProduto($q)
    {
        $this->db->select('idProdutos as id, descricao as label, precoVenda as preco, estoque');
        $this->db->from('produtos');
        $this->db->like('descricao', $q);
        $this->db->or_like('codDeBarra', $q);
        $this->db->limit(25);
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            echo json_encode($query->result_array());
        } else {
            echo json_encode([]);
        }
    }

    public function getHistoricoCompras($idProdutos)
    {
        $this->db->select('compras_itens.*, compras.data_compra, clientes.nomeCliente as fornecedor');
        $this->db->from('compras_itens');
        $this->db->join('compras', 'compras.id = compras_itens.compra_id');
        $this->db->join('clientes', 'clientes.idClientes = compras.fornecedor_id');
        $this->db->where('compras_itens.produto_id', $idProdutos);
        $this->db->order_by('compras.data_compra', 'desc');
        
        return $this->db->get()->result();
    }

    public function getHistoricoVendas($idProdutos)
    {
        $this->db->select('itens_de_vendas.*, vendas.dataVenda, clientes.nomeCliente as cliente');
        $this->db->from('itens_de_vendas');
        $this->db->join('vendas', 'vendas.idVendas = itens_de_vendas.vendas_id');
        $this->db->join('clientes', 'clientes.idClientes = vendas.clientes_id', 'left');
        $this->db->where('itens_de_vendas.produtos_id', $idProdutos);
        $this->db->order_by('vendas.dataVenda', 'desc');
        
        return $this->db->get()->result();
    }

    public function getHistoricoOs($idProdutos)
    {
        $this->db->select('produtos_os.*, os.dataInicial, clientes.nomeCliente as cliente');
        $this->db->from('produtos_os');
        $this->db->join('os', 'os.idOs = produtos_os.os_id');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id', 'left');
        $this->db->where('produtos_os.produtos_id', $idProdutos);
        $this->db->order_by('os.dataInicial', 'desc');
        
        return $this->db->get()->result();
    }
}
