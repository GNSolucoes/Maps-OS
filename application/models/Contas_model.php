<?php
class Contas_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getAll() {
        $this->db->order_by('conta', 'asc');
        return $this->db->get('contas_bancarias')->result();
    }
    
    public function getById($id) {
        $this->db->where('idConta', $id);
        return $this->db->get('contas_bancarias')->row();
    }
    
    public function add($data) {
        $this->db->insert('contas_bancarias', $data);
        if ($this->db->affected_rows() == '1') {
            return true;
        }
        return false;
    }
    
    public function edit($data, $id) {
        $this->db->where('idConta', $id);
        $this->db->update('contas_bancarias', $data);
        if ($this->db->affected_rows() >= 0) {
            return true;
        }
        return false;
    }
    
    public function delete($id) {
        $this->db->where('idConta', $id);
        $this->db->delete('contas_bancarias');
        if ($this->db->affected_rows() == '1') {
            return true;
        }
        return false;
    }
    
    public function getSaldoAtual($idConta) {
        // Receitas (Entradas) baixadas da conta
        $this->db->select_sum('valor_desconto', 'total_receita');
        $this->db->where('tipo', 'receita');
        $this->db->where('baixado', 1);
        $this->db->where('contas_bancaria_id', $idConta);
        $receita = $this->db->get('lancamentos')->row()->total_receita;
        
        // Despesas (Saídas) baixadas da conta
        $this->db->select_sum('valor_desconto', 'total_despesa');
        $this->db->where('tipo', 'despesa');
        $this->db->where('baixado', 1);
        $this->db->where('contas_bancaria_id', $idConta);
        $despesa = $this->db->get('lancamentos')->row()->total_despesa;
        
        // Saldo Inicial da Conta
        $this->db->select('saldo_inicial');
        $this->db->where('idConta', $idConta);
        $saldo_inicial = $this->db->get('contas_bancarias')->row()->saldo_inicial;
        
        return $saldo_inicial + ($receita - $despesa);
    }
}
