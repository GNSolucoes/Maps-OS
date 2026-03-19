<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Relatorios_parceiros_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getComissoes($dataInicial, $dataFinal, $parceiroId = null)
    {
        $this->db->select('v.*, c.nomeCliente, p.nome as nomeParceiro, p.comissao');
        $this->db->from('vendas v');
        $this->db->join('clientes c', 'c.idClientes = v.clientes_id');
        $this->db->join('parceiros p', 'p.idParceiros = c.parceiros_id');
        $this->db->where('v.dataVenda >=', $dataInicial);
        $this->db->where('v.dataVenda <=', $dataFinal);
        
        if ($parceiroId) {
            $this->db->where('c.parceiros_id', $parceiroId);
        } else {
             $this->db->where('c.parceiros_id IS NOT NULL');
        }
        
        // Pode adicionar status de faturado se quiser pagar comissão só no recebimento
        // $this->db->where('v.faturado', 1);

        return $this->db->get()->result();
    }
}
