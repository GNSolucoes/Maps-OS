<?php

class Compras_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Compras
    public function get($where = '', $perpage = 0, $start = 0)
    {
        $this->db->select('compras.*, clientes.nomeCliente as fornecedor, usuarios.nome as usuario_nome');
        $this->db->select('(SELECT status FROM compras_pagamentos WHERE compra_id = compras.id ORDER BY id DESC LIMIT 1) as financeiro_status');
        $this->db->from('compras');
        $this->db->join('clientes', 'clientes.idClientes = compras.fornecedor_id');
        $this->db->join('usuarios', 'usuarios.idUsuarios = compras.usuario_id', 'left');
        
        if ($where) {
            $this->db->where($where);
        }
        
        $this->db->order_by('compras.id', 'desc');
        
        if ($perpage > 0) {
            $this->db->limit($perpage, $start);
        }

        return $this->db->get()->result();
    }

    public function getById($id)
    {
        $this->db->select('compras.*, clientes.nomeCliente as fornecedor, usuarios.nome as usuario_nome');
        $this->db->from('compras');
        $this->db->join('clientes', 'clientes.idClientes = compras.fornecedor_id');
        $this->db->join('usuarios', 'usuarios.idUsuarios = compras.usuario_id', 'left');
        $this->db->where('compras.id', $id);
        
        return $this->db->get()->row();
    }

    public function add($data)
    {
        $this->db->insert('compras', $data);
        return $this->db->insert_id();
    }

    public function edit($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('compras', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('compras');
    }

    public function count()
    {
        return $this->db->count_all('compras');
    }

    public function generateNumeroCompra()
    {
        $year = date('Y');
        $this->db->like('numero_compra', 'CP' . $year, 'after');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $last = $this->db->get('compras')->row();
        
        if ($last) {
            $num = (int)substr($last->numero_compra, -4) + 1;
        } else {
            $num = 1;
        }
        
        return 'CP' . $year . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

    // Itens
    public function getItens($compra_id)
    {
        $this->db->select('compras_itens.*, produtos.descricao as produto_nome, produtos.unidade');
        $this->db->from('compras_itens');
        $this->db->join('produtos', 'produtos.idProdutos = compras_itens.produto_id');
        $this->db->where('compra_id', $compra_id);
        
        return $this->db->get()->result();
    }

    public function addItem($data)
    {
        $this->db->insert('compras_itens', $data);
        return $this->db->insert_id();
    }

    public function deleteItem($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('compras_itens');
    }

    public function deleteItensByCompra($compra_id)
    {
        $this->db->where('compra_id', $compra_id);
        return $this->db->delete('compras_itens');
    }

    // Pagamentos
    public function getPagamentos($compra_id)
    {
        $this->db->where('compra_id', $compra_id);
        $this->db->order_by('data_vencimento', 'asc');
        return $this->db->get('compras_pagamentos')->result();
    }

    public function addPagamento($data)
    {
        $this->db->insert('compras_pagamentos', $data);
        return $this->db->insert_id();
    }

    public function deletePagamento($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('compras_pagamentos');
    }

    public function deletePagamentosByCompra($compra_id)
    {
        $this->db->where('compra_id', $compra_id);
        return $this->db->delete('compras_pagamentos');
    }

    // Atualizar estoque
    public function atualizarEstoque($compra_id)
    {
        $itens = $this->getItens($compra_id);
        
        foreach ($itens as $item) {
            $this->db->set('estoque', 'estoque + ' . $item->quantidade, FALSE);
            $this->db->where('idProdutos', $item->produto_id);
            $this->db->update('produtos');
        }
        
        return true;
    }

    // Sincronizar com Financeiro Global
    public function sincronizarFinanceiro($compra_id)
    {
        $compra = $this->getById($compra_id);
        $pagamentos = $this->getPagamentos($compra_id);
        
        foreach ($pagamentos as $pag) {
            $dados = [
                'descricao' => 'Compra #' . $compra->numero_compra . ' - Status: ' . $compra->status,
                'valor' => $pag->valor,
                'data_vencimento' => $pag->data_vencimento,
                'data_pagamento' => $pag->data_pagamento, // Se null e status pendente, ok.
                'baixado' => ($pag->status == 'pago') ? 1 : 0,
                'cliente_fornecedor' => $compra->fornecedor,
                'tipo' => 'despesa',
                // 'categoria' => 'Compras', // Categoria pode nao existir na tabela lancamentos padrao do Mapos, verificar
                'forma_pgto' => $pag->forma_pagamento,
            ];

            if ($pag->lancamento_id) {
                // Atualizar existente
                $this->db->where('idLancamentos', $pag->lancamento_id); // Mapos usa idLancamentos
                $this->db->update('lancamentos', $dados);
            } else {
                // Criar novo
                $this->db->insert('lancamentos', $dados);
                $lancamento_id = $this->db->insert_id();
                
                // Vincular
                $this->db->where('id', $pag->id);
                $this->db->update('compras_pagamentos', ['lancamento_id' => $lancamento_id]);
            }
        }
        
        return true;
    }

    // Alias para manter compatibilidade
    public function criarLancamentos($compra_id) {
        return $this->sincronizarFinanceiro($compra_id);
    }
}
