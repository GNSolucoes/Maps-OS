<?php

class Patrimonios_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($where = '', $perpage = 0, $start = 0)
    {
        $this->db->select('patrimonios.*, marcas.marca, clientes.nomeCliente as fornecedor');
        $this->db->from('patrimonios');
        $this->db->join('marcas', 'marcas.idMarcas = patrimonios.marca_id', 'left');
        $this->db->join('clientes', 'clientes.idClientes = patrimonios.fornecedor_id', 'left');
        
        if ($where) {
            $this->db->where($where);
        }
        
        $this->db->order_by('patrimonios.id', 'desc');
        
        if ($perpage > 0) {
            $this->db->limit($perpage, $start);
        }

        return $this->db->get()->result();
    }

    public function getById($id)
    {
        $this->db->select('patrimonios.*, marcas.marca, clientes.nomeCliente as fornecedor');
        $this->db->from('patrimonios');
        $this->db->join('marcas', 'marcas.idMarcas = patrimonios.marca_id', 'left');
        $this->db->join('clientes', 'clientes.idClientes = patrimonios.fornecedor_id', 'left');
        $this->db->where('patrimonios.id', $id);
        
        return $this->db->get()->row();
    }

    public function add($data)
    {
        $this->db->insert('patrimonios', $data);
        return $this->db->insert_id();
    }

    public function edit($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('patrimonios', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('patrimonios');
    }

    public function count()
    {
        return $this->db->count_all('patrimonios');
    }

    public function checkCodigoExists($codigo, $id = null)
    {
        $this->db->where('codigo', $codigo);
        if ($id) {
            $this->db->where('id !=', $id);
        }
        return $this->db->get('patrimonios')->num_rows() > 0;
    }

    // Manutenções
    public function getManutencoes($patrimonio_id)
    {
        $this->db->select('patrimonio_manutencoes.*, usuarios.nome as responsavel_nome');
        $this->db->from('patrimonio_manutencoes');
        $this->db->join('usuarios', 'usuarios.idUsuarios = patrimonio_manutencoes.responsavel_id', 'left');
        $this->db->where('patrimonio_id', $patrimonio_id);
        $this->db->order_by('data_manutencao', 'desc');
        
        return $this->db->get()->result();
    }

    public function addManutencao($data)
    {
        $this->db->insert('patrimonio_manutencoes', $data);
        return $this->db->insert_id();
    }

    public function deleteManutencao($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('patrimonio_manutencoes');
    }
}
