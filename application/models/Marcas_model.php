<?php

class Marcas_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->limit($perpage, $start);
        $this->db->order_by('idMarcas', 'desc');
        
        if ($where) {
            $this->db->where($where);
        }

        $query = $this->db->get();
        $result = !$one ? $query->result() : $query->row();

        return $result;
    }

    public function getById($id)
    {
        $this->db->select('*');
        $this->db->from('marcas');
        $this->db->where('idMarcas', $id);
        $this->db->limit(1);

        return $this->db->get()->row();
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

    public function countEquipamentosByMarca($marca_id)
    {
        $this->db->where('marcas_id', $marca_id);
        return $this->db->count_all_results('equipamentos');
    }

    public function checkDuplicate($marca, $id = null)
    {
        $this->db->where('marca', $marca);
        if ($id) {
            $this->db->where('idMarcas !=', $id);
        }
        $query = $this->db->get('marcas');
        return $query->num_rows() > 0;
    }
}
