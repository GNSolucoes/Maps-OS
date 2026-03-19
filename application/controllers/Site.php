<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Site extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['form', 'file']);
        $this->load->model('site_model');
        $this->data['menuCadastros'] = 'Cadastros';
        $this->data['menuSite'] = 'Site';
    }

    public function index()
    {
        redirect(site_url('site/configuracoes'));
    }

    // ========== CONFIGURAÇÕES ==========
    public function configuracoes()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        $this->load->library('form_validation');

        if ($this->input->post()) {
            $data = [
                'nome_empresa' => $this->input->post('nome_empresa'),
                'slogan' => $this->input->post('slogan'),
                'texto_inicio' => $this->input->post('texto_inicio'),
                'sobre' => $this->input->post('sobre'),
                'telefone' => $this->input->post('telefone'),
                'email' => $this->input->post('email'),
                'endereco' => $this->input->post('endereco'),
                'mapa_iframe' => $this->input->post('mapa_iframe'),
                'horario_atendimento' => $this->input->post('horario_atendimento'),
                'cor_primaria' => $this->input->post('cor_primaria'),
                'cor_secundaria' => $this->input->post('cor_secundaria'),
                'facebook' => $this->input->post('facebook'),
                'instagram' => $this->input->post('instagram'),
                'whatsapp' => $this->input->post('whatsapp'),
                'google_analytics' => $this->input->post('google_analytics'),
                'meta_description' => $this->input->post('meta_description'),
                'meta_keywords' => $this->input->post('meta_keywords'),
            ];

            $uploadConfig['upload_path'] = './uploads/site/';
            $uploadConfig['allowed_types'] = 'jpg|jpeg|png|gif|webp|svg|ico';
            $uploadConfig['max_size'] = 5048;
            $this->load->library('upload');

            // Upload logo
            if (!empty($_FILES['logo']['name'])) {
                $this->upload->initialize($uploadConfig);
                if ($this->upload->do_upload('logo')) {
                    $data['logo'] = $this->upload->data('file_name');
                }
            }

            // Upload Imagem Início
            if (!empty($_FILES['imagem_inicio']['name'])) {
                $this->upload->initialize($uploadConfig);
                if ($this->upload->do_upload('imagem_inicio')) {
                    $data['imagem_inicio'] = $this->upload->data('file_name');
                }
            }

            // Upload Imagem Sobre
            if (!empty($_FILES['imagem_sobre']['name'])) {
                $this->upload->initialize($uploadConfig);
                if ($this->upload->do_upload('imagem_sobre')) {
                    $data['imagem_sobre'] = $this->upload->data('file_name');
                }
            }

            // Upload favicon
            if (!empty($_FILES['favicon']['name'])) {
                $this->upload->initialize($uploadConfig);
                if ($this->upload->do_upload('favicon')) {
                    $data['favicon'] = $this->upload->data('file_name');
                }
            }

            // Upload Imagem Login
            if (!empty($_FILES['imagem_login']['name'])) {
                $this->upload->initialize($uploadConfig);
                if ($this->upload->do_upload('imagem_login')) {
                    $data['imagem_login'] = $this->upload->data('file_name');
                }
            }

            // Upload Imagem Cliente
            if (!empty($_FILES['imagem_cliente']['name'])) {
                $config['upload_path'] = './uploads/site/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 2048;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('imagem_cliente')) {
                    $data['imagem_cliente'] = $this->upload->data('file_name');
                }
            }

            // Upload Imagem Tecnico
            if (!empty($_FILES['imagem_tecnico']['name'])) {
                $config['upload_path'] = './uploads/site/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 2048;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('imagem_tecnico')) {
                    $data['imagem_tecnico'] = $this->upload->data('file_name');
                }
            }

            if ($this->site_model->updateConfig($data)) {
                $this->session->set_flashdata('success', 'Configurações atualizadas!');
            }
            redirect(site_url('site/configuracoes'));
        }

        $config = $this->site_model->getConfig();
        $this->load->model('mapos_model');
        $emitente = $this->mapos_model->getEmitente();

        if (!$config) {
            $config = new stdClass();
        }

        // Se estiver vazio, tenta puxar do Emitente (configurações do sistema já preenchidas)
        if (empty($config->nome_empresa) && $emitente) { $config->nome_empresa = $emitente->nome; }
        if (empty($config->telefone) && $emitente) { $config->telefone = $emitente->telefone; }
        if (empty($config->email) && $emitente) { $config->email = $emitente->email; }
        if (empty($config->endereco) && $emitente) { 
            $config->endereco = trim("{$emitente->rua}, {$emitente->numero} - {$emitente->bairro}, {$emitente->cidade} - {$emitente->uf}"); 
        }

        $this->data['config'] = $config;
        $this->data['view'] = 'site/configuracoes';
        return $this->layout();
    }

    // ========== PÁGINAS ==========
    public function paginas()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        $this->data['paginas'] = $this->site_model->getPaginas();
        $this->data['view'] = 'site/paginas';
        return $this->layout();
    }

    public function adicionarPagina()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        if ($this->input->post()) {
            $slug = url_title($this->input->post('titulo'), '-', true);
            
            if ($this->site_model->checkSlugExists($slug)) {
                $this->session->set_flashdata('error', 'Já existe uma página com este título.');
                redirect(site_url('site/adicionarPagina'));
            }

            $data = [
                'titulo' => $this->input->post('titulo'),
                'slug' => $slug,
                'conteudo' => $this->input->post('conteudo'),
                'ordem' => $this->input->post('ordem') ?: 0,
                'ativo' => $this->input->post('ativo') ? 1 : 0,
                'meta_description' => $this->input->post('meta_description'),
                'meta_keywords' => $this->input->post('meta_keywords'),
                'imagem_capa' => $this->input->post('imagem_capa'),
            ];

            if ($this->site_model->addPagina($data)) {
                $this->session->set_flashdata('success', 'Página adicionada!');
                redirect(site_url('site/paginas'));
            }
        }

        $this->data['view'] = 'site/adicionarPagina';
        return $this->layout();
    }

    public function editarPagina($id)
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        if ($this->input->post()) {
            $slug = url_title($this->input->post('titulo'), '-', true);
            
            if ($this->site_model->checkSlugExists($slug, $id)) {
                $this->session->set_flashdata('error', 'Já existe uma página com este título.');
                redirect(site_url('site/editarPagina/' . $id));
            }

            $data = [
                'titulo' => $this->input->post('titulo'),
                'slug' => $slug,
                'conteudo' => $this->input->post('conteudo'),
                'ordem' => $this->input->post('ordem') ?: 0,
                'ativo' => $this->input->post('ativo') ? 1 : 0,
                'meta_description' => $this->input->post('meta_description'),
                'meta_keywords' => $this->input->post('meta_keywords'),
                'imagem_capa' => $this->input->post('imagem_capa'),
            ];

            if ($this->site_model->editPagina($id, $data)) {
                $this->session->set_flashdata('success', 'Página atualizada!');
                redirect(site_url('site/paginas'));
            }
        }

        $this->data['pagina'] = $this->site_model->getPaginaById($id);
        $this->data['view'] = 'site/editarPagina';
        return $this->layout();
    }

    public function excluirPagina()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($this->site_model->deletePagina($id)) {
            $this->session->set_flashdata('success', 'Página excluída!');
        }
        redirect(site_url('site/paginas'));
    }

    // ========== CONTATOS ==========
    public function contatos()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        $this->data['contatos'] = $this->site_model->getContatos();
        $this->data['view'] = 'site/contatos';
        return $this->layout();
    }

    public function visualizarContato($id)
    {
        $this->site_model->marcarComoLido($id);
        $this->data['contato'] = $this->site_model->getContatoById($id);
        $this->data['view'] = 'site/visualizarContato';
        return $this->layout();
    }

    // ========== ORÇAMENTOS ==========
    public function orcamentos()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        $this->data['orcamentos'] = $this->site_model->getOrcamentos();
        $this->data['view'] = 'site/orcamentos';
        return $this->layout();
    }

    public function atualizarOrcamentoStatus()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            $json = ['result' => false, 'message' => 'Sem permissão'];
            echo json_encode($json);
            return;
        }

        $id = $this->input->post('id');
        $status = $this->input->post('status');

        if($this->site_model->updateOrcamentoStatus($id, $status)){
             echo json_encode(['result' => true]);
        } else {
             echo json_encode(['result' => false]);
        }
    }

    public function excluirOrcamento()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($this->site_model->deleteOrcamento($id)) {
            $this->session->set_flashdata('success', 'Orçamento excluído!');
        }
        redirect(site_url('site/orcamentos'));
    }

    // ========== SERVIÇOS ==========
    public function servicos()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        $this->data['servicos'] = $this->site_model->getServicos();
        $this->data['view'] = 'site/servicos';
        return $this->layout();
    }

    public function adicionarServico()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        if ($this->input->post()) {
            $data = [
                'titulo' => $this->input->post('titulo'),
                'descricao' => $this->input->post('descricao'),
                'icone' => $this->input->post('icone'),
                'ordem' => $this->input->post('ordem') ?: 0,
                'ativo' => $this->input->post('ativo') ? 1 : 0,
            ];

            if ($this->site_model->addServico($data)) {
                $this->session->set_flashdata('success', 'Serviço adicionado!');
                redirect(site_url('site/servicos'));
            }
        }

        $this->data['view'] = 'site/adicionarServico';
        return $this->layout();
    }

    public function editarServico($id)
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        if ($this->input->post()) {
            $data = [
                'titulo' => $this->input->post('titulo'),
                'descricao' => $this->input->post('descricao'),
                'icone' => $this->input->post('icone'),
                'ordem' => $this->input->post('ordem') ?: 0,
                'ativo' => $this->input->post('ativo') ? 1 : 0,
            ];

            if ($this->site_model->editServico($id, $data)) {
                $this->session->set_flashdata('success', 'Serviço atualizado!');
                redirect(site_url('site/servicos'));
            }
        }

        $this->data['servico'] = $this->site_model->getServicoById($id);
        $this->data['view'] = 'site/editarServico';
        return $this->layout();
    }

    public function excluirServico()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($this->site_model->deleteServico($id)) {
            $this->session->set_flashdata('success', 'Serviço excluído!');
        }
        redirect(site_url('site/servicos'));
    }

    // ========== DEPOIMENTOS ==========
    public function depoimentos()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        $this->data['depoimentos'] = $this->site_model->getDepoimentos();
        $this->data['view'] = 'site/depoimentos';
        return $this->layout();
    }

    public function adicionarDepoimento()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        if ($this->input->post()) {
            $data = [
                'nome' => $this->input->post('nome'),
                'cargo' => $this->input->post('cargo'),
                'depoimento' => $this->input->post('depoimento'),
                'avaliacao' => $this->input->post('avaliacao') ?: 5,
                'ativo' => $this->input->post('ativo') ? 1 : 0,
            ];

            if ($this->site_model->addDepoimento($data)) {
                $this->session->set_flashdata('success', 'Depoimento adicionado!');
                redirect(site_url('site/depoimentos'));
            }
        }

        $this->data['view'] = 'site/adicionarDepoimento';
        return $this->layout();
    }

    public function editarDepoimento($id)
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        if ($this->input->post()) {
            $data = [
                'nome' => $this->input->post('nome'),
                'cargo' => $this->input->post('cargo'),
                'depoimento' => $this->input->post('depoimento'),
                'avaliacao' => $this->input->post('avaliacao') ?: 5,
                'ativo' => $this->input->post('ativo') ? 1 : 0,
            ];

            if ($this->site_model->editDepoimento($id, $data)) {
                $this->session->set_flashdata('success', 'Depoimento atualizado!');
                redirect(site_url('site/depoimentos'));
            }
        }

        $this->data['depoimento'] = $this->site_model->getDepoimentoById($id);
        $this->data['view'] = 'site/editarDepoimento';
        return $this->layout();
    }

    public function excluirDepoimento()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($this->site_model->deleteDepoimento($id)) {
            $this->session->set_flashdata('success', 'Depoimento excluído!');
        }
        redirect(site_url('site/depoimentos'));
    }
}
