<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tecnico extends CI_Controller {

    private $data = [];

    public function __construct() {
        parent::__construct();
        
        $this->load->model('os_model');
        $this->load->model('mapos_model');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        
        $this->data['menuTecnico'] = 'tecnico';
        
        $rota_atual = $this->router->fetch_method();
        $rotas_liberadas = ['login', 'verificarLogin', 'sair'];
        
        if (!in_array($rota_atual, $rotas_liberadas) && !$this->session->userdata('logado')) {
             redirect('tecnico/login');
        }

        $this->data['configuration'] = [
            'app_name' => 'Map-OS',
            'app_theme' => 'default',
            'os_notification' => 'cliente',
            'control_estoque' => '1',
            'notifica_whats' => '',
            'control_baixa' => '0',
            'control_editos' => '1',
            'control_datatable' => '1',
            'pix_key' => '',
        ];
        
        $configuracoes = $this->db->get('configuracoes')->result();
        foreach ($configuracoes as $c) {
            $this->data['configuration'][$c->config] = $c->valor;
        }
    }

    private function layout() {
        $this->load->view('tema/topo', $this->data);
        $this->load->view('tecnico/menu', $this->data);
        $this->load->view('tema/conteudo', $this->data);
        $this->load->view('tema/rodape', $this->data);
    }

    public function login() {
        if ($this->session->userdata('logado')) {
            redirect('tecnico');
        }
        $this->load->model('site_model');
        $this->data['configuration_site'] = $this->site_model->getConfig();
        $this->load->view('tecnico/login', $this->data);
    }

    public function sair() {
        $this->session->sess_destroy();
        redirect('tecnico/login');
    }

    public function verificarLogin() {
        $this->form_validation->set_rules('email', 'E-mail', 'valid_email|required|trim');
        $this->form_validation->set_rules('senha', 'Senha', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', 'Campos inválidos.');
            redirect('tecnico/login');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('senha');
            $user = $this->mapos_model->check_credentials($email);

            if ($user) {
                 if ($this->chk_date($user->dataExpiracao)) {
                    $this->session->set_flashdata('error', 'A conta do usuário está expirada.');
                    redirect('tecnico/login');
                 }

                if (password_verify($password, $user->senha)) {
                    $session_data = [
                        'nome_admin' => $user->nome, 
                        'email_admin' => $user->email, 
                        'url_image_user_admin' => $user->url_image_user, 
                        'id_admin' => $user->idUsuarios, 
                        'permissao' => $user->permissoes_id, 
                        'logado' => true
                    ];
                    $this->session->set_userdata($session_data);
                    redirect('tecnico');
                } else {
                    $this->session->set_flashdata('error', 'Senha incorreta.');
                    redirect('tecnico/login');
                }
            } else {
                $this->session->set_flashdata('error', 'Usuário não encontrado.');
                redirect('tecnico/login');
            }
        }
    }

    private function chk_date($data_banco) {
        $data_banco = new DateTime($data_banco);
        $data_hoje = new DateTime('now');
        return $data_banco < $data_hoje;
    }

    public function index() {
        $this->data['menuTecnico'] = 'dashboard';
        $this->data['view'] = 'tecnico/dashboard';
        
        $idUsuario = $this->session->userdata('id_admin');
        
        // Contadores
        $this->db->where('usuarios_id', $idUsuario);
        $this->db->where_in('status', ['Aberto', 'Orçamento', 'Em Andamento', 'Aguardando Peças']);
        $this->data['count_pendentes'] = $this->db->count_all_results('os');
        
        $this->db->where('usuarios_id', $idUsuario);
        $this->db->where('status', 'Finalizado');
        $this->data['count_finalizadas_mes'] = $this->db->where('MONTH(dataFinal)', date('m'))->where('YEAR(dataFinal)', date('Y'))->count_all_results('os');

        // Minhas OSs Pendentes
        $this->db->select('os.*, clientes.nomeCliente, clientes.celular as celular_cliente');
        $this->db->from('os');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->where('usuarios_id', $idUsuario);
        $this->db->where_in('status', ['Aberto', 'Orçamento', 'Em Andamento', 'Aguardando Peças']);
        $this->db->order_by('idOs', 'desc');
        $this->db->limit(10);
        $this->data['results'] = $this->db->get()->result();

        $this->layout();
    }

    public function minhas_os() {
        $this->data['menuTecnico'] = 'minhas_os';
        $this->data['view'] = 'tecnico/minhas_os';
        $idUsuario = $this->session->userdata('id_admin');
        
        $config['base_url'] = base_url() . 'index.php/tecnico/minhas_os/';
        $config['total_rows'] = $this->db->where('usuarios_id', $idUsuario)->count_all_results('os');
        $config['per_page'] = 20;
        $this->pagination->initialize($config);
        
        $this->db->select('os.*, clientes.nomeCliente, clientes.celular as celular_cliente');
        $this->db->from('os');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->where('usuarios_id', $idUsuario);
        $this->db->order_by('idOs', 'desc');
        $this->db->limit($config['per_page'], $this->uri->segment(3));
        
        $this->data['results'] = $this->db->get()->result();
        $this->layout();
    }

    public function visualizar($id = null) {
        if (!$id) redirect(base_url('index.php/tecnico'));
        
        $this->data['view'] = 'tecnico/visualizar_os';
        $this->data['result'] = $this->os_model->getById($id);
        
        if (!$this->data['result']) {
            redirect(base_url('index.php/tecnico'));
        }
        
        $this->layout();
    }

    public function rotas() {
        $this->data['menuTecnico'] = 'rotas';
        $this->data['view'] = 'tecnico/rotas';
        $idUsuario = $this->session->userdata('id_admin');
        
        $this->db->select('os.*, clientes.nomeCliente, clientes.rua, clientes.numero, clientes.bairro, clientes.cidade, usuarios.nome as nomeTecnico');
        $this->db->from('os');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->join('usuarios', 'usuarios.idUsuarios = os.usuarios_id', 'left');
        
        // Se não tiver permissão de gerenciar usuários (Admin), filtra apenas as suas
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vUsuarios')) {
            $this->db->where('os.usuarios_id', $idUsuario);
        }
        
        $this->db->where_in('os.status', ['Aberto', 'Em Andamento', 'Orçamento', 'Aguardando Peças']);
        $this->db->order_by('os.usuarios_id', 'asc'); // Agrupa por técnico
        $this->db->order_by('os.idOs', 'desc');
        $this->data['rotas'] = $this->db->get()->result();

        $this->layout();
    }

    public function nova_os_rapida() {
        $this->data['menuTecnico'] = 'nova_os';
        $this->data['view'] = 'tecnico/nova_os_rapida';
        $this->layout();
    }

    public function salvar_os_rapida() {
        if($this->input->post()){
             // Salvar OS
             // Simplificado para exemplo
        }
        redirect('tecnico');
    }

    public function produtos() 
    {
        $this->data['menuTecnico'] = 'produtos';
        $this->data['view'] = 'tecnico/produtos';
        
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'index.php/tecnico/produtos/';
        $config['total_rows'] = $this->db->count_all('produtos');
        $config['per_page'] = 10;
        $this->pagination->initialize($config);
        
        $this->db->limit($config['per_page'], $this->uri->segment(3));
        $this->db->order_by('idProdutos', 'desc');
        $this->data['results'] = $this->db->get('produtos')->result();
        
        $this->layout();
    }

    public function saida_produto_acao()
    {
        $id = $this->input->post('idProduto');
        $qtd = $this->input->post('quantidade');
        $obs = $this->input->post('observacao');

        if(!$id || !$qtd) redirect(base_url('index.php/tecnico/produtos'));

        // Busca produto para ver estoque atual
        $this->db->where('idProdutos', $id);
        $produto = $this->db->get('produtos')->row();

        if($produto){
            $novoEstoque = $produto->estoque - $qtd;
            
            // Atualiza estoque
            $this->db->set('estoque', $novoEstoque);
            $this->db->where('idProdutos', $id);
            $this->db->update('produtos');

            // Poderia registrar em uma tabela de movimentação aqui
            // ...

            $this->session->set_flashdata('success', 'Saída realizada com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Produto não encontrado.');
        }

        redirect(base_url('index.php/tecnico/produtos'));
    }
}
