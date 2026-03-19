<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Parceiros extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Parceiros_model');
        $this->data['menuParceiros'] = 'Parceiros';
    }

    public function index()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar parceiros.');
            redirect(base_url());
        }

        $this->load->library('pagination');

        $this->data['configuration']['base_url'] = site_url('parceiros/index/');
        $this->data['configuration']['total_rows'] = $this->Parceiros_model->count('parceiros');

        $this->pagination->initialize($this->data['configuration']);

        $this->data['results'] = $this->Parceiros_model->get('parceiros', '*', '', $this->data['configuration']['per_page'], $this->uri->segment(3));

        $this->data['view'] = 'parceiros/parceiros';

        return $this->layout();
    }

    public function adicionar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar parceiros.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
        $this->form_validation->set_rules('cpf_cnpj', 'CPF/CNPJ', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $data = [
                'nome' => set_value('nome'),
                'cpf_cnpj' => set_value('cpf_cnpj'),
                'telefone' => set_value('telefone'),
                'email' => set_value('email'),
                'comissao' => set_value('comissao'),
                'dataCadastro' => date('Y-m-d'),
                'situacao' => 1,
            ];

            if ($this->Parceiros_model->add('parceiros', $data) == true) {
                $this->session->set_flashdata('success', 'Parceiro adicionado com sucesso!');
                log_info('Adicionou um parceiro');
                redirect(site_url('parceiros/'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'parceiros/adicionarParceiro';

        return $this->layout();
    }

    public function editar()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar parceiros.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nome', 'Nome', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $data = [
                'nome' => $this->input->post('nome'),
                'cpf_cnpj' => $this->input->post('cpf_cnpj'),
                'telefone' => $this->input->post('telefone'),
                'email' => $this->input->post('email'),
                'comissao' => $this->input->post('comissao'),
                'situacao' => $this->input->post('situacao'),
            ];

            if ($this->Parceiros_model->edit('parceiros', $data, 'idParceiros', $this->input->post('idParceiros')) == true) {
                $this->session->set_flashdata('success', 'Parceiro editado com sucesso!');
                log_info('Alterou um parceiro. ID: ' . $this->input->post('idParceiros'));
                redirect(site_url('parceiros/editar/') . $this->input->post('idParceiros'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

        $this->data['result'] = $this->Parceiros_model->getById($this->uri->segment(3));
        $this->data['view'] = 'parceiros/editarParceiro';

        return $this->layout();
    }

    public function excluir()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir parceiros.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($id == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir parceiro.');
            redirect(site_url('parceiros/'));
        }

        $this->Parceiros_model->delete('parceiros', 'idParceiros', $id);
        log_info('Removeu um parceiro. ID: ' . $id);
        $this->session->set_flashdata('success', 'Parceiro excluído com sucesso!');
        redirect(site_url('parceiros/'));
    }
}
