<?php

class Checklist_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Templates
    public function getTemplates($where = '', $perpage = 0, $start = 0)
    {
        $this->db->select('*');
        $this->db->from('checklist_templates');
        
        if ($where) {
            $this->db->where($where);
        }
        
        $this->db->order_by('nome', 'asc');
        
        if ($perpage > 0) {
            $this->db->limit($perpage, $start);
        }

        return $this->db->get()->result();
    }

    public function getTemplateById($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('checklist_templates')->row();
    }

    public function addTemplate($data)
    {
        $this->db->insert('checklist_templates', $data);
        return $this->db->insert_id();
    }

    public function editTemplate($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('checklist_templates', $data);
    }

    public function deleteTemplate($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('checklist_templates');
    }

    public function countTemplates()
    {
        return $this->db->count_all('checklist_templates');
    }

    // Items
    public function getItemsByTemplate($template_id)
    {
        $this->db->where('template_id', $template_id);
        $this->db->order_by('ordem', 'asc');
        return $this->db->get('checklist_items')->result();
    }

    public function addItem($data)
    {
        $this->db->insert('checklist_items', $data);
        return $this->db->insert_id();
    }

    public function editItem($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('checklist_items', $data);
    }

    public function deleteItem($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('checklist_items');
    }

    public function deleteItemsByTemplate($template_id)
    {
        $this->db->where('template_id', $template_id);
        return $this->db->delete('checklist_items');
    }

    // Checklist OS
    public function getChecklistByOS($os_id)
    {
        $this->db->select('checklist_os.*, checklist_templates.nome as template_nome, usuarios.nome as usuario_nome');
        $this->db->from('checklist_os');
        $this->db->join('checklist_templates', 'checklist_templates.id = checklist_os.template_id');
        $this->db->join('usuarios', 'usuarios.idUsuarios = checklist_os.usuario_id', 'left');
        $this->db->where('checklist_os.os_id', $os_id);
        return $this->db->get()->result();
    }

    public function getChecklistOSById($id)
    {
        $this->db->select('checklist_os.*, checklist_templates.nome as template_nome');
        $this->db->from('checklist_os');
        $this->db->join('checklist_templates', 'checklist_templates.id = checklist_os.template_id');
        $this->db->where('checklist_os.id', $id);
        return $this->db->get()->row();
    }

    public function addChecklistOS($data)
    {
        $this->db->insert('checklist_os', $data);
        return $this->db->insert_id();
    }

    public function deleteChecklistOS($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('checklist_os');
    }

    // Respostas
    public function getRespostasByChecklistOS($checklist_os_id)
    {
        $this->db->select('checklist_respostas.*, checklist_items.item, checklist_items.permite_foto');
        $this->db->from('checklist_respostas');
        $this->db->join('checklist_items', 'checklist_items.id = checklist_respostas.item_id');
        $this->db->where('checklist_respostas.checklist_os_id', $checklist_os_id);
        $this->db->order_by('checklist_items.ordem', 'asc');
        return $this->db->get()->result();
    }

    public function addResposta($data)
    {
        $this->db->insert('checklist_respostas', $data);
        return $this->db->insert_id();
    }

    public function editResposta($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('checklist_respostas', $data);
    }

    public function getRespostaById($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('checklist_respostas')->row();
    }

    public function deleteRespostasByChecklistOS($checklist_os_id)
    {
        $this->db->where('checklist_os_id', $checklist_os_id);
        return $this->db->delete('checklist_respostas');
    }

    // Verificações
    public function checkTemplateInUse($template_id)
    {
        $this->db->where('template_id', $template_id);
        return $this->db->count_all_results('checklist_os') > 0;
    }
}
