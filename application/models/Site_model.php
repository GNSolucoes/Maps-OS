<?php

class Site_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // ========== CONFIGURAÇÕES ==========
    public function getConfig()
    {
        return $this->db->get('site_config')->row();
    }

    public function updateConfig($data)
    {
        $this->db->where('id', 1);
        return $this->db->update('site_config', $data);
    }

    // ========== PÁGINAS ==========
    public function getPaginas($where = '')
    {
        if ($where) {
            $this->db->where($where);
        }
        $this->db->order_by('ordem', 'asc');
        return $this->db->get('site_paginas')->result();
    }

    public function getPaginaById($id)
    {
        return $this->db->get_where('site_paginas', ['id' => $id])->row();
    }

    public function getPaginaBySlug($slug)
    {
        return $this->db->get_where('site_paginas', ['slug' => $slug, 'ativo' => 1])->row();
    }

    public function addPagina($data)
    {
        $this->db->insert('site_paginas', $data);
        return $this->db->insert_id();
    }

    public function editPagina($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('site_paginas', $data);
    }

    public function deletePagina($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('site_paginas');
    }

    public function checkSlugExists($slug, $id = null)
    {
        $this->db->where('slug', $slug);
        if ($id) {
            $this->db->where('id !=', $id);
        }
        return $this->db->get('site_paginas')->num_rows() > 0;
    }

    // ========== SERVIÇOS ==========
    public function getServicos($where = '')
    {
        if ($where) {
            $this->db->where($where);
        }
        $this->db->order_by('ordem', 'asc');
        return $this->db->get('site_servicos')->result();
    }

    public function getServicoById($id)
    {
        return $this->db->get_where('site_servicos', ['id' => $id])->row();
    }

    public function addServico($data)
    {
        $this->db->insert('site_servicos', $data);
        return $this->db->insert_id();
    }

    public function editServico($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('site_servicos', $data);
    }

    public function deleteServico($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('site_servicos');
    }

    // ========== DEPOIMENTOS ==========
    public function getDepoimentos($where = '')
    {
        if ($where) {
            $this->db->where($where);
        }
        $this->db->order_by('created_at', 'desc');
        return $this->db->get('site_depoimentos')->result();
    }

    public function getDepoimentoById($id)
    {
        return $this->db->get_where('site_depoimentos', ['id' => $id])->row();
    }

    public function addDepoimento($data)
    {
        $this->db->insert('site_depoimentos', $data);
        return $this->db->insert_id();
    }

    public function editDepoimento($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('site_depoimentos', $data);
    }

    public function deleteDepoimento($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('site_depoimentos');
    }

    // ========== CONTATOS ==========
    public function getContatos($where = '')
    {
        if ($where) {
            $this->db->where($where);
        }
        $this->db->order_by('created_at', 'desc');
        return $this->db->get('site_contatos')->result();
    }

    public function getContatoById($id)
    {
        return $this->db->get_where('site_contatos', ['id' => $id])->row();
    }

    public function addContato($data)
    {
        $this->db->insert('site_contatos', $data);
        return $this->db->insert_id();
    }

    public function marcarComoLido($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('site_contatos', ['lido' => 1]);
    }

    public function marcarComoRespondido($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('site_contatos', ['respondido' => 1]);
    }

    public function deleteContato($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('site_contatos');
    }

    public function countContatosNaoLidos()
    {
        return $this->db->where('lido', 0)->count_all_results('site_contatos');
    }

    // ========== ORÇAMENTOS ==========
    public function getOrcamentos()
    {
        $this->db->order_by('created_at', 'desc');
        return $this->db->get('orcamentos')->result();
    }

    public function getOrcamentoById($id)
    {
        return $this->db->get_where('orcamentos', ['idOrcamento' => $id])->row();
    }

    public function addOrcamento($data)
    {
        return $this->db->insert('orcamentos', $data);
    }
    
    public function updateOrcamentoStatus($id, $status)
    {
        $this->db->where('idOrcamento', $id);
        return $this->db->update('orcamentos', ['status' => $status]);
    }

    public function deleteOrcamento($id)
    {
        $this->db->where('idOrcamento', $id);
        return $this->db->delete('orcamentos');
    }

    public function countOrcamentosPendentes()
    {
        return $this->db->where('status', 'Pendente')->count_all_results('orcamentos');
    }
}
