<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Marcas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('marcas_model');
        $this->data['menuCadastros'] = 'Cadastros';
        $this->data['menuMarcas'] = 'Marcas';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar marcas.');
            redirect(base_url());
        }

        $this->load->library('pagination');

        $this->data['configuration']['base_url'] = site_url('marcas/gerenciar/');
        $this->data['configuration']['total_rows'] = $this->marcas_model->count('marcas');

        $this->pagination->initialize($this->data['configuration']);

        $this->data['results'] = $this->marcas_model->get(
            'marcas',
            'marcas.*',
            '',
            $this->data['configuration']['per_page'],
            $this->uri->segment(3)
        );

        $this->data['view'] = 'marcas/marcas';

        return $this->layout();
    }

    public function adicionar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar marcas.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('marcas') == false) {
            $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {
            $marca = $this->input->post('marca');
            
            // Check for duplicates
            if ($this->marcas_model->checkDuplicate($marca)) {
                $this->session->set_flashdata('error', 'Esta marca já está cadastrada.');
                redirect(site_url('marcas/adicionar'));
            }

            $data = [
                'marca' => $marca,
                'cadastro' => date('Y-m-d'),
                'situacao' => $this->input->post('situacao') ? 1 : 0,
            ];

            if ($this->marcas_model->add('marcas', $data)) {
                $this->session->set_flashdata('success', 'Marca adicionada com sucesso!');
                log_info('Adicionou uma marca.');
                redirect(site_url('marcas'));
            } else {
                $this->data['custom_error'] = '<div class="alert">Ocorreu um erro.</div>';
            }
        }

        $this->data['view'] = 'marcas/adicionarMarca';

        return $this->layout();
    }

    public function editar()
    {
        if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('marcas');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar marcas.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('marcas') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $marca = $this->input->post('marca');
            $id = $this->input->post('idMarcas');
            
            // Check for duplicates
            if ($this->marcas_model->checkDuplicate($marca, $id)) {
                $this->session->set_flashdata('error', 'Esta marca já está cadastrada.');
                redirect(site_url('marcas/editar/' . $id));
            }

            $data = [
                'marca' => $marca,
                'situacao' => $this->input->post('situacao') ? 1 : 0,
            ];

            if ($this->marcas_model->edit('marcas', $data, 'idMarcas', $id) == true) {
                $this->session->set_flashdata('success', 'Marca editada com sucesso!');
                log_info('Alterou uma marca. ID: ' . $id);
                redirect(site_url('marcas'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

        $this->data['result'] = $this->marcas_model->getById($this->uri->segment(3));
        $this->data['view'] = 'marcas/editarMarca';

        return $this->layout();
    }

    public function excluir()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir marcas.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        
        if ($id == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir marca.');
            redirect(site_url('marcas'));
        }

        // Check if brand is linked to any equipment
        $equipamentos_count = $this->marcas_model->countEquipamentosByMarca($id);

        if ($equipamentos_count > 0) {
            $this->session->set_flashdata('error', 'Não é possível excluir esta marca pois está vinculada a ' . $equipamentos_count . ' equipamento(s).');
            redirect(site_url('marcas'));
        }

        $this->marcas_model->delete('marcas', 'idMarcas', $id);

        log_info('Removeu uma marca. ID: ' . $id);
        $this->session->set_flashdata('success', 'Marca excluída com sucesso!');
        redirect(site_url('marcas'));
    }
}
