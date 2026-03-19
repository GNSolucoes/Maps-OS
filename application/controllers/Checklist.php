<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Checklist extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['form', 'file']);
        $this->load->model('checklist_model');
        $this->data['menuCadastros'] = 'Cadastros';
        $this->data['menuChecklist'] = 'Checklist';
    }

    // ========== TEMPLATES ==========
    
    public function index()
    {
        $this->templates();
    }

    public function templates()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar checklists.');
            redirect(base_url());
        }

        $this->load->library('pagination');

        $this->data['configuration']['base_url'] = site_url('checklist/templates/');
        $this->data['configuration']['total_rows'] = $this->checklist_model->countTemplates();

        $this->pagination->initialize($this->data['configuration']);

        $this->data['results'] = $this->checklist_model->getTemplates(
            '',
            $this->data['configuration']['per_page'],
            $this->uri->segment(3)
        );

        $this->data['view'] = 'checklist/templates';
        return $this->layout();
    }

    public function adicionarTemplate()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar templates.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('checklist_template') == false) {
            $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {
            $data = [
                'nome' => $this->input->post('nome'),
                'descricao' => $this->input->post('descricao'),
                'ativo' => $this->input->post('ativo') ? 1 : 0,
            ];

            // Upload de imagem de referência
            if (!empty($_FILES['imagem_referencia']['name'])) {
                $config['upload_path'] = './uploads/checklist/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 5120;
                $config['encrypt_name'] = true;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('imagem_referencia')) {
                    $upload_data = $this->upload->data();
                    $data['imagem_referencia'] = $upload_data['file_name'];
                }
            }

            $template_id = $this->checklist_model->addTemplate($data);
            
            if ($template_id) {
                // Adicionar itens
                $itens = $this->input->post('itens');
                if ($itens && is_array($itens)) {
                    foreach ($itens as $index => $item_text) {
                        if (!empty($item_text)) {
                            $item_data = [
                                'template_id' => $template_id,
                                'item' => $item_text,
                                'ordem' => $index + 1,
                                'obrigatorio' => isset($_POST['obrigatorio'][$index]) ? 1 : 0,
                                'permite_foto' => isset($_POST['permite_foto'][$index]) ? 1 : 0,
                            ];
                            $this->checklist_model->addItem($item_data);
                        }
                    }
                }

                $this->session->set_flashdata('success', 'Template de checklist adicionado com sucesso!');
                log_info('Adicionou um template de checklist.');
                redirect(site_url('checklist'));
            } else {
                $this->data['custom_error'] = '<div class="alert">Ocorreu um erro.</div>';
            }
        }

        $this->data['view'] = 'checklist/adicionarTemplate';
        return $this->layout();
    }

    public function editarTemplate()
    {
        if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não encontrado.');
            redirect('checklist');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar templates.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('checklist_template') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $id = $this->input->post('id');
            
            $data = [
                'nome' => $this->input->post('nome'),
                'descricao' => $this->input->post('descricao'),
                'ativo' => $this->input->post('ativo') ? 1 : 0,
            ];

            // Upload de imagem de referência
            if (!empty($_FILES['imagem_referencia']['name'])) {
                $config['upload_path'] = './uploads/checklist/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 5120;
                $config['encrypt_name'] = true;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('imagem_referencia')) {
                    $upload_data = $this->upload->data();
                    $data['imagem_referencia'] = $upload_data['file_name'];
                    
                    // Remover imagem antiga
                    $template_antigo = $this->checklist_model->getTemplateById($id);
                    if ($template_antigo && $template_antigo->imagem_referencia) {
                        @unlink('./uploads/checklist/' . $template_antigo->imagem_referencia);
                    }
                }
            }

            if ($this->checklist_model->editTemplate($id, $data)) {
                // Remover itens antigos e adicionar novos
                $this->checklist_model->deleteItemsByTemplate($id);
                
                $itens = $this->input->post('itens');
                if ($itens && is_array($itens)) {
                    foreach ($itens as $index => $item_text) {
                        if (!empty($item_text)) {
                            $item_data = [
                                'template_id' => $id,
                                'item' => $item_text,
                                'ordem' => $index + 1,
                                'obrigatorio' => isset($_POST['obrigatorio'][$index]) ? 1 : 0,
                                'permite_foto' => isset($_POST['permite_foto'][$index]) ? 1 : 0,
                            ];
                            $this->checklist_model->addItem($item_data);
                        }
                    }
                }

                $this->session->set_flashdata('success', 'Template editado com sucesso!');
                log_info('Editou um template de checklist. ID: ' . $id);
                redirect(site_url('checklist'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

        $this->data['result'] = $this->checklist_model->getTemplateById($this->uri->segment(3));
        $this->data['itens'] = $this->checklist_model->getItemsByTemplate($this->uri->segment(3));
        $this->data['view'] = 'checklist/editarTemplate';

        return $this->layout();
    }

    public function excluirTemplate()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir templates.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        
        if ($id == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir template.');
            redirect(site_url('checklist'));
        }

        // Verificar se está em uso
        if ($this->checklist_model->checkTemplateInUse($id)) {
            $this->session->set_flashdata('error', 'Não é possível excluir este template pois está sendo utilizado em ordens de serviço.');
            redirect(site_url('checklist'));
        }

        $this->checklist_model->deleteTemplate($id);
        log_info('Removeu um template de checklist. ID: ' . $id);
        
        $this->session->set_flashdata('success', 'Template excluído com sucesso!');
        redirect(site_url('checklist'));
    }

    // ========== APLICAR CHECKLIST EM OS ==========
    
    public function aplicar($os_id)
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        
        if ($this->input->post('template_id')) {
            $template_id = $this->input->post('template_id');
            $usuario_id = $this->session->userdata('id');

            // Criar checklist_os
            $checklist_os_data = [
                'os_id' => $os_id,
                'template_id' => $template_id,
                'usuario_id' => $usuario_id,
            ];

            $checklist_os_id = $this->checklist_model->addChecklistOS($checklist_os_data);

            if ($checklist_os_id) {
                // Criar respostas vazias para cada item
                $itens = $this->checklist_model->getItemsByTemplate($template_id);
                
                foreach ($itens as $item) {
                    $resposta_data = [
                        'checklist_os_id' => $checklist_os_id,
                        'item_id' => $item->id,
                        'status' => 'na',
                    ];
                    $this->checklist_model->addResposta($resposta_data);
                }

                $this->session->set_flashdata('success', 'Checklist aplicado com sucesso!');
                redirect(site_url('checklist/preencher/' . $checklist_os_id));
            }
        }

        $this->data['os_id'] = $os_id;
        $this->data['templates'] = $this->checklist_model->getTemplates('ativo = 1');
        $this->data['view'] = 'checklist/aplicar';
        
        return $this->layout();
    }

    public function preencher($checklist_os_id)
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        $this->data['checklist'] = $this->checklist_model->getChecklistOSById($checklist_os_id);
        
        if (!$this->data['checklist']) {
            $this->session->set_flashdata('error', 'Checklist não encontrado.');
            redirect(base_url());
        }

        // Buscar imagem de referência do template
        $template = $this->checklist_model->getTemplateById($this->data['checklist']->template_id);
        $this->data['template_imagem'] = $template ? $template->imagem_referencia : null;

        $this->data['respostas'] = $this->checklist_model->getRespostasByChecklistOS($checklist_os_id);
        $this->data['view'] = 'checklist/preencher';
        
        return $this->layout();
    }

    public function salvarResposta()
    {
        $resposta_id = $this->input->post('resposta_id');
        $status = $this->input->post('status');
        $observacao = $this->input->post('observacao');

        $data = [
            'status' => $status,
            'observacao' => $observacao,
        ];

        // Upload de foto se houver
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path'] = './uploads/checklist/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 5120; // 5MB
            $config['encrypt_name'] = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $data['foto'] = $upload_data['file_name'];
                
                // Remover foto antiga se existir
                $resposta_antiga = $this->checklist_model->getRespostaById($resposta_id);
                if ($resposta_antiga && $resposta_antiga->foto) {
                    @unlink('./uploads/checklist/' . $resposta_antiga->foto);
                }
            }
        }

        if ($this->checklist_model->editResposta($resposta_id, $data)) {
            echo json_encode(['result' => true]);
        } else {
            echo json_encode(['result' => false]);
        }
    }

    public function visualizar($checklist_os_id)
    {
        $this->data['checklist'] = $this->checklist_model->getChecklistOSById($checklist_os_id);
        
        if (!$this->data['checklist']) {
            $this->session->set_flashdata('error', 'Checklist não encontrado.');
            redirect(base_url());
        }

        $this->data['respostas'] = $this->checklist_model->getRespostasByChecklistOS($checklist_os_id);
        $this->data['view'] = 'checklist/visualizar';
        
        return $this->layout();
    }

    public function excluirChecklistOS()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        $os_id = $this->input->post('os_id');
        
        if ($this->checklist_model->deleteChecklistOS($id)) {
            log_info('Removeu checklist de uma OS. ID: ' . $id);
            $this->session->set_flashdata('success', 'Checklist removido com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Erro ao remover checklist.');
        }

        redirect(site_url('os/editar/' . $os_id));
    }
}
