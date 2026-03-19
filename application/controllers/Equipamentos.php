<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Equipamentos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('equipamentos_model');
        $this->data['menuCadastros'] = 'Cadastros';
        $this->data['menuEquipamentos'] = 'Equipamentos';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar equipamentos.');
            redirect(base_url());
        }

        $this->load->library('pagination');

        $this->data['configuration']['base_url'] = site_url('equipamentos/gerenciar/');
        $this->data['configuration']['total_rows'] = $this->equipamentos_model->count('equipamentos');

        $this->pagination->initialize($this->data['configuration']);

        $this->data['results'] = $this->equipamentos_model->get(
            'equipamentos',
            'equipamentos.*',
            '',
            $this->data['configuration']['per_page'],
            $this->uri->segment(3)
        );

        $this->data['view'] = 'equipamentos/equipamentos';

        return $this->layout();
    }

    public function adicionar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar equipamentos.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('equipamentos') == false) {
            $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {
            $data_fabricacao = $this->input->post('data_fabricacao');
            
            if ($data_fabricacao) {
                $data_fabricacao = explode('/', $data_fabricacao);
                $data_fabricacao = $data_fabricacao[2] . '-' . $data_fabricacao[1] . '-' . $data_fabricacao[0];
            } else {
                $data_fabricacao = null;
            }

            $data = [
                'equipamento' => $this->input->post('equipamento'),
                'num_serie' => $this->input->post('num_serie'),
                'modelo' => $this->input->post('modelo'),
                'cor' => $this->input->post('cor'),
                'descricao' => $this->input->post('descricao'),
                'tensao' => $this->input->post('tensao'),
                'potencia' => $this->input->post('potencia'),
                'voltagem' => $this->input->post('voltagem'),
                'data_fabricacao' => $data_fabricacao,
                'marcas_id' => $this->input->post('marcas_id') ?: null,
                'clientes_id' => $this->input->post('clientes_id'),
            ];

            if ($this->equipamentos_model->add('equipamentos', $data)) {
                $this->session->set_flashdata('success', 'Equipamento adicionado com sucesso!');
                log_info('Adicionou um equipamento.');
                redirect(site_url('equipamentos'));
            } else {
                $this->data['custom_error'] = '<div class="alert">Ocorreu um erro.</div>';
            }
        }

        $this->data['marcas'] = $this->equipamentos_model->getMarcas();
        $this->data['view'] = 'equipamentos/adicionarEquipamento';

        return $this->layout();
    }

    public function editar()
    {
        if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('equipamentos');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar equipamentos.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('equipamentos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $data_fabricacao = $this->input->post('data_fabricacao');
            
            if ($data_fabricacao) {
                $data_fabricacao = explode('/', $data_fabricacao);
                $data_fabricacao = $data_fabricacao[2] . '-' . $data_fabricacao[1] . '-' . $data_fabricacao[0];
            } else {
                $data_fabricacao = null;
            }

            $data = [
                'equipamento' => $this->input->post('equipamento'),
                'num_serie' => $this->input->post('num_serie'),
                'modelo' => $this->input->post('modelo'),
                'cor' => $this->input->post('cor'),
                'descricao' => $this->input->post('descricao'),
                'tensao' => $this->input->post('tensao'),
                'potencia' => $this->input->post('potencia'),
                'voltagem' => $this->input->post('voltagem'),
                'data_fabricacao' => $data_fabricacao,
                'marcas_id' => $this->input->post('marcas_id') ?: null,
                'clientes_id' => $this->input->post('clientes_id'),
            ];

            if ($this->equipamentos_model->edit('equipamentos', $data, 'idEquipamentos', $this->input->post('idEquipamentos')) == true) {
                $this->session->set_flashdata('success', 'Equipamento editado com sucesso!');
                log_info('Alterou um equipamento. ID: ' . $this->input->post('idEquipamentos'));
                redirect(site_url('equipamentos'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

        $this->data['result'] = $this->equipamentos_model->getById($this->uri->segment(3));
        $this->data['marcas'] = $this->equipamentos_model->getMarcas();
        $this->data['view'] = 'equipamentos/editarEquipamento';

        return $this->layout();
    }

    public function visualizar()
    {
        if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('equipamentos');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar equipamentos.');
            redirect(base_url());
        }

        $this->data['result'] = $this->equipamentos_model->getById($this->uri->segment(3));
        $this->data['view'] = 'equipamentos/visualizarEquipamento';

        return $this->layout();
    }

    public function excluir()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir equipamentos.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        
        if ($id == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir equipamento.');
            redirect(site_url('equipamentos'));
        }

        // Check if equipment is linked to any OS
        $this->db->where('equipamentos_id', $id);
        $linked_os = $this->db->get('equipamentos_os')->num_rows();

        if ($linked_os > 0) {
            $this->session->set_flashdata('error', 'Não é possível excluir este equipamento pois está vinculado a ' . $linked_os . ' ordem(ns) de serviço.');
            redirect(site_url('equipamentos'));
        }

        $this->equipamentos_model->delete('equipamentos', 'idEquipamentos', $id);

        log_info('Removeu um equipamento. ID: ' . $id);
        $this->session->set_flashdata('success', 'Equipamento excluído com sucesso!');
        redirect(site_url('equipamentos'));
    }

    public function autoCompleteEquipamento()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $cliente_id = isset($_GET['cliente_id']) ? $_GET['cliente_id'] : null;
            $this->equipamentos_model->autoCompleteEquipamento($q, $cliente_id);
        }
    }

    public function getEquipamentosByCliente()
    {
        $cliente_id = $this->input->get('cliente_id');
        
        if (!$cliente_id) {
            echo json_encode([]);
            return;
        }

        $equipamentos = $this->equipamentos_model->getByCliente($cliente_id);
        echo json_encode($equipamentos);
    }
}
