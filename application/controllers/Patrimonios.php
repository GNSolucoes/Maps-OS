<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Patrimonios extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['form', 'file']);
        $this->load->model('patrimonios_model');
        $this->load->model('marcas_model');
        $this->data['menuCadastros'] = 'Cadastros';
        $this->data['menuPatrimonios'] = 'Patrimonios';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar patrimônios.');
            redirect(base_url());
        }

        $this->load->library('pagination');

        $this->data['configuration']['base_url'] = site_url('patrimonios/gerenciar/');
        $this->data['configuration']['total_rows'] = $this->patrimonios_model->count();

        $this->pagination->initialize($this->data['configuration']);

        $this->data['results'] = $this->patrimonios_model->get(
            '',
            $this->data['configuration']['per_page'],
            $this->uri->segment(3)
        );

        $this->data['view'] = 'patrimonios/patrimonios';
        return $this->layout();
    }

    public function adicionar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar patrimônios.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('patrimonios') == false) {
            $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {
            $codigo = $this->input->post('codigo');
            
            if ($this->patrimonios_model->checkCodigoExists($codigo)) {
                $this->session->set_flashdata('error', 'Este código já está cadastrado.');
                redirect(site_url('patrimonios/adicionar'));
            }

            $data = [
                'codigo' => $codigo,
                'nome' => $this->input->post('nome'),
                'descricao' => $this->input->post('descricao'),
                'categoria' => $this->input->post('categoria'),
                'marca_id' => $this->input->post('marca_id') ?: null,
                'modelo' => $this->input->post('modelo'),
                'num_serie' => $this->input->post('num_serie'),
                'data_aquisicao' => $this->input->post('data_aquisicao') ?: null,
                'valor_aquisicao' => $this->input->post('valor_aquisicao') ?: null,
                'fornecedor_id' => $this->input->post('fornecedor_id') ?: null,
                'localizacao' => $this->input->post('localizacao'),
                'estado' => $this->input->post('estado'),
                'status' => $this->input->post('status'),
                'observacoes' => $this->input->post('observacoes'),
            ];

            // Upload de foto
            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = './uploads/patrimonios/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 5120;
                $config['encrypt_name'] = true;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')) {
                    $upload_data = $this->upload->data();
                    $data['foto'] = $upload_data['file_name'];
                }
            }

            if ($this->patrimonios_model->add($data)) {
                $this->session->set_flashdata('success', 'Patrimônio adicionado com sucesso!');
                log_info('Adicionou um patrimônio.');
                redirect(site_url('patrimonios'));
            } else {
                $this->data['custom_error'] = '<div class="alert">Ocorreu um erro.</div>';
            }
        }

        $this->data['marcas'] = $this->marcas_model->get('marcas', '*', 'situacao = 1');
        $this->load->model('clientes_model');
        $this->data['fornecedores'] = $this->clientes_model->get('clientes', '*', 'fornecedor = 1');
        $this->data['view'] = 'patrimonios/adicionarPatrimonio';

        return $this->layout();
    }

    public function editar()
    {
        if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não encontrado.');
            redirect('patrimonios');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar patrimônios.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('patrimonios') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $id = $this->input->post('id');
            $codigo = $this->input->post('codigo');
            
            if ($this->patrimonios_model->checkCodigoExists($codigo, $id)) {
                $this->session->set_flashdata('error', 'Este código já está cadastrado.');
                redirect(site_url('patrimonios/editar/' . $id));
            }

            $data = [
                'codigo' => $codigo,
                'nome' => $this->input->post('nome'),
                'descricao' => $this->input->post('descricao'),
                'categoria' => $this->input->post('categoria'),
                'marca_id' => $this->input->post('marca_id') ?: null,
                'modelo' => $this->input->post('modelo'),
                'num_serie' => $this->input->post('num_serie'),
                'data_aquisicao' => $this->input->post('data_aquisicao') ?: null,
                'valor_aquisicao' => $this->input->post('valor_aquisicao') ?: null,
                'fornecedor_id' => $this->input->post('fornecedor_id') ?: null,
                'localizacao' => $this->input->post('localizacao'),
                'estado' => $this->input->post('estado'),
                'status' => $this->input->post('status'),
                'observacoes' => $this->input->post('observacoes'),
            ];

            // Upload de foto
            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = './uploads/patrimonios/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 5120;
                $config['encrypt_name'] = true;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')) {
                    $upload_data = $this->upload->data();
                    $data['foto'] = $upload_data['file_name'];
                    
                    // Remover foto antiga
                    $patrimonio = $this->patrimonios_model->getById($id);
                    if ($patrimonio && $patrimonio->foto) {
                        @unlink('./uploads/patrimonios/' . $patrimonio->foto);
                    }
                }
            }

            if ($this->patrimonios_model->edit($id, $data)) {
                $this->session->set_flashdata('success', 'Patrimônio editado com sucesso!');
                log_info('Editou um patrimônio. ID: ' . $id);
                redirect(site_url('patrimonios'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

        $this->data['result'] = $this->patrimonios_model->getById($this->uri->segment(3));
        $this->data['marcas'] = $this->marcas_model->get('marcas', '*', 'situacao = 1');
        $this->load->model('clientes_model');
        $this->data['fornecedores'] = $this->clientes_model->get('clientes', '*', 'fornecedor = 1');
        $this->data['view'] = 'patrimonios/editarPatrimonio';

        return $this->layout();
    }

    public function visualizar()
    {
        if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não encontrado.');
            redirect('patrimonios');
        }

        $this->data['result'] = $this->patrimonios_model->getById($this->uri->segment(3));
        $this->data['manutencoes'] = $this->patrimonios_model->getManutencoes($this->uri->segment(3));
        $this->data['view'] = 'patrimonios/visualizarPatrimonio';

        return $this->layout();
    }

    public function excluir()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir patrimônios.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        
        if ($id == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir patrimônio.');
            redirect(site_url('patrimonios'));
        }

        // Remover foto se existir
        $patrimonio = $this->patrimonios_model->getById($id);
        if ($patrimonio && $patrimonio->foto) {
            @unlink('./uploads/patrimonios/' . $patrimonio->foto);
        }

        $this->patrimonios_model->delete($id);
        log_info('Removeu um patrimônio. ID: ' . $id);
        
        $this->session->set_flashdata('success', 'Patrimônio excluído com sucesso!');
        redirect(site_url('patrimonios'));
    }

    public function adicionarManutencao()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        $data = [
            'patrimonio_id' => $this->input->post('patrimonio_id'),
            'data_manutencao' => $this->input->post('data_manutencao'),
            'tipo' => $this->input->post('tipo'),
            'descricao' => $this->input->post('descricao'),
            'custo' => $this->input->post('custo') ?: null,
            'responsavel_id' => $this->session->userdata('id'),
        ];

        if ($this->patrimonios_model->addManutencao($data)) {
            $this->session->set_flashdata('success', 'Manutenção registrada com sucesso!');
            log_info('Adicionou manutenção de patrimônio.');
        } else {
            $this->session->set_flashdata('error', 'Erro ao registrar manutenção.');
        }

        redirect(site_url('patrimonios/visualizar/' . $data['patrimonio_id']));
    }
}
