<?php

class Equipamentos_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        $this->db->select($fields . ', clientes.nomeCliente, marcas.marca');
        $this->db->from($table);
        $this->db->join('clientes', 'clientes.idClientes = equipamentos.clientes_id', 'left');
        $this->db->join('marcas', 'marcas.idMarcas = equipamentos.marcas_id', 'left');
        $this->db->limit($perpage, $start);
        $this->db->order_by('idEquipamentos', 'desc');
        
        if ($where) {
            $this->db->where($where);
        }

        $query = $this->db->get();
        $result = !$one ? $query->result() : $query->row();

        return $result;
    }

    public function getById($id)
    {
        $this->db->select('equipamentos.*, clientes.nomeCliente, marcas.marca');
        $this->db->from('equipamentos');
        $this->db->join('clientes', 'clientes.idClientes = equipamentos.clientes_id', 'left');
        $this->db->join('marcas', 'marcas.idMarcas = equipamentos.marcas_id', 'left');
        $this->db->where('equipamentos.idEquipamentos', $id);
        $this->db->limit(1);

        return $this->db->get()->row();
    }

    public function getByCliente($cliente_id)
    {
        $this->db->select('equipamentos.*, marcas.marca');
        $this->db->from('equipamentos');
        $this->db->join('marcas', 'marcas.idMarcas = equipamentos.marcas_id', 'left');
        $this->db->where('equipamentos.clientes_id', $cliente_id);
        $this->db->order_by('equipamentos.idEquipamentos', 'desc');

        return $this->db->get()->result();
    }

    public function add($table, $data)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
            return $this->db->insert_id();
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

    public function autoCompleteEquipamento($q, $cliente_id = null)
    {
        $this->db->select('equipamentos.*, marcas.marca');
        $this->db->from('equipamentos');
        $this->db->join('marcas', 'marcas.idMarcas = equipamentos.marcas_id', 'left');
        $this->db->limit(25);
        $this->db->group_start();
        $this->db->like('equipamento', $q);
        $this->db->or_like('num_serie', $q);
        $this->db->or_like('modelo', $q);
        $this->db->group_end();
        
        if ($cliente_id) {
            $this->db->where('clientes_id', $cliente_id);
        }
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $row_set = [];
            foreach ($query->result_array() as $row) {
                $label = $row['equipamento'];
                if ($row['num_serie']) {
                    $label .= ' | S/N: ' . $row['num_serie'];
                }
                if ($row['modelo']) {
                    $label .= ' | Modelo: ' . $row['modelo'];
                }
                if ($row['marca']) {
                    $label .= ' | Marca: ' . $row['marca'];
                }
                
                $row_set[] = [
                    'label' => $label,
                    'id' => $row['idEquipamentos'],
                    'equipamento' => $row['equipamento'],
                    'num_serie' => $row['num_serie'],
                    'modelo' => $row['modelo']
                ];
            }
            echo json_encode($row_set);
        }
    }

    public function getMarcas()
    {
        $this->db->select('*');
        $this->db->from('marcas');
        $this->db->where('situacao', 1);
        $this->db->order_by('marca', 'asc');

        return $this->db->get()->result();
    }
}
