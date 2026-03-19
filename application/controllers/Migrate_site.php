<?php
class Migrate_site extends CI_Controller {
    public function index() {
        $this->load->database();
        $this->load->dbforge();
        
        $fields = array();
        
        if (!$this->db->field_exists('imagem_inicio', 'site_config')) {
            $fields['imagem_inicio'] = array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE);
        }
        if (!$this->db->field_exists('imagem_sobre', 'site_config')) {
            $fields['imagem_sobre'] = array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE);
        }
        if (!$this->db->field_exists('texto_inicio', 'site_config')) {
            $fields['texto_inicio'] = array('type' => 'TEXT', 'null' => TRUE);
        }
        
        if (!empty($fields)) {
            $this->dbforge->add_column('site_config', $fields);
            echo "Columns added.\n";
        } else {
            echo "Columns already exist.\n";
        }
    }
}
