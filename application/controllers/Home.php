<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('site_model');
    }

    public function index()
    {
        $data['config'] = $this->site_model->getConfig();
        $data['paginas'] = $this->site_model->getPaginas('ativo = 1');
        $data['servicos'] = $this->site_model->getServicos('ativo = 1');
        $data['depoimentos'] = $this->site_model->getDepoimentos('ativo = 1');
        
        $this->load->view('home/index', $data);
    }

    public function pagina($slug)
    {
        $data['config'] = $this->site_model->getConfig();
        $data['paginas'] = $this->site_model->getPaginas('ativo = 1');
        $data['pagina'] = $this->site_model->getPaginaBySlug($slug);
        
        if (!$data['pagina']) {
            show_404();
        }
        
        $this->load->view('home/pagina', $data);
    }

    public function contato()
    {
        $data['config'] = $this->site_model->getConfig();
        $data['paginas'] = $this->site_model->getPaginas('ativo = 1');
        
        if ($this->input->post()) {
            $contato_data = [
                'nome' => $this->input->post('nome'),
                'email' => $this->input->post('email'),
                'telefone' => $this->input->post('telefone'),
                'assunto' => $this->input->post('assunto'),
                'mensagem' => $this->input->post('mensagem'),
            ];
            
            if ($this->site_model->addContato($contato_data)) {
                $data['success'] = 'Mensagem enviada com sucesso! Entraremos em contato em breve.';
            } else {
                $data['error'] = 'Erro ao enviar mensagem. Tente novamente.';
            }
        }
        
        $this->load->view('home/contato', $data);
    }

    public function orcamento()
    {
        $data['config'] = $this->site_model->getConfig();
        
        if ($this->input->post()) {
            $orcamento_data = [
                'nome' => $this->input->post('nome'),
                'email' => $this->input->post('email'),
                'whatsapp' => $this->input->post('whatsapp'),
                'empresa' => $this->input->post('empresa'),
                'endereco' => $this->input->post('endereco'),
                'equipamentos' => $this->input->post('equipamentos'),
                'descricao' => $this->input->post('descricao'),
                'status' => 'Pendente',
            ];
            
            if ($this->site_model->addOrcamento($orcamento_data)) {
                $data['success'] = 'Orçamento solicitado com sucesso! Em breve entraremos em contato.';
            } else {
                $data['error'] = 'Erro ao solicitar orçamento. Tente novamente.';
            }
        }
        
        $this->load->view('home/orcamento', $data);
    }
}
