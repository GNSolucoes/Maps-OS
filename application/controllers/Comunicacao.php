<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Comunicacao extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('clientes_model');
        $this->data['menuComunicacao'] = 'comunicacao';
    }

    public function index()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para acessar esta área.');
            redirect(base_url());
        }

        // Fetch all clients with phone numbers or emails
        $this->data['clientes'] = $this->db->get('clientes')->result();

        $this->data['view'] = 'comunicacao/comunicacao';
        return $this->layout();
    }

    public function enviarMensagem()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para acessar esta área.');
            redirect(base_url());
        }

        $tipo_envio = $this->input->post('tipo_envio'); // 'whatsapp', 'email', 'ambos'
        $destinatario_tipo = $this->input->post('destinatario_tipo'); // 'cliente', 'avulso'
        $id_cliente = $this->input->post('id_cliente');
        
        $email_avulso = $this->input->post('email_avulso');
        $telefone_avulso = $this->input->post('telefone_avulso');
        
        $mensagem = $this->input->post('mensagem');
        $assunto = $this->input->post('assunto') ?: 'Aviso - ' . (getenv('app_name') ?: 'Map-OS');

        if(empty($mensagem)) {
            $this->session->set_flashdata('error', 'A mensagem não pode estar vazia.');
            redirect(site_url('comunicacao'));
        }

        $email_destino = '';
        $telefone_destino = '';
        $nome_destino = 'Cliente';

        if ($destinatario_tipo == 'cliente') {
            if(empty($id_cliente)) {
                $this->session->set_flashdata('error', 'Selecione um cliente.');
                redirect(site_url('comunicacao'));
            }
            $cliente = $this->clientes_model->getById($id_cliente);
            if($cliente) {
                $email_destino = $cliente->email;
                $telefone_destino = preg_replace("/[^0-9]/", "", $cliente->celular);
                $nome_destino = $cliente->nomeCliente;
            }
        } else {
            $email_destino = $email_avulso;
            $telefone_destino = preg_replace("/[^0-9]/", "", $telefone_avulso);
        }

        $sucessos = [];
        $erros = [];

        $anexoPath = null;
        if (isset($_FILES['anexo']) && $_FILES['anexo']['error'] == 0) {
            $configUpload['upload_path'] = FCPATH . 'assets/uploads/';
            $configUpload['allowed_types'] = 'jpg|png|jpeg|pdf';
            $configUpload['max_size'] = 5120; // 5MB
            $configUpload['encrypt_name'] = true;

            $this->load->library('upload', $configUpload);

            if ($this->upload->do_upload('anexo')) {
                $uploadData = $this->upload->data();
                $anexoPath = $uploadData['full_path'];
            } else {
                $erros[] = 'Anexo (Aviso: ' . strip_tags($this->upload->display_errors('', '')) . ')';
            }
        }

        // Substituir variáveis se houver
        $mensagem_formatada = str_replace('{cliente_nome}', $nome_destino, $mensagem);

        // Disparo WhatsApp
        if ($tipo_envio == 'whatsapp' || $tipo_envio == 'ambos') {
            if(!empty($telefone_destino)) {
                $resWhat = $this->enviarViaWhaticket($telefone_destino, $mensagem_formatada, $anexoPath);
                if($resWhat === true) {
                    $sucessos[] = 'WhatsApp';
                } else {
                    $erros[] = 'WhatsApp (Erro: ' . json_encode($resWhat) . ')';
                }
            } else {
                $erros[] = 'WhatsApp (Nenhum número válido fornecido)';
            }
        }

        // Disparo E-mail
        if ($tipo_envio == 'email' || $tipo_envio == 'ambos') {
            if(!empty($email_destino) && filter_var($email_destino, FILTER_VALIDATE_EMAIL)) {
                // Adiciona assinatura se configurada
                $msg_email = nl2br($mensagem_formatada);
                $assinatura = isset($_ENV['EMAIL_SIGNATURE']) ? base64_decode($_ENV['EMAIL_SIGNATURE']) : '';
                if(!empty($assinatura)) {
                    $msg_email .= "<br><br>" . $assinatura;
                }

                $resEmail = $this->enviarViaEmail($email_destino, $assunto, $msg_email, $anexoPath);
                if($resEmail === true) {
                    $sucessos[] = 'E-mail';
                } else {
                    $erros[] = 'E-mail (Falha ao agendar/enviar)';
                }
            } else {
                $erros[] = 'E-mail (Endereço inválido ou vazio)';
            }
        }

        // Limpar anexo do servidor depois de enviar se houver
        if ($anexoPath && file_exists($anexoPath)) {
            unlink($anexoPath);
        }

        if(count($sucessos) > 0 && count($erros) == 0) {
            $this->session->set_flashdata('success', 'Mensagem enviada com sucesso via ' . implode(' e ', $sucessos) . '!');
        } elseif(count($sucessos) > 0 && count($erros) > 0) {
            $this->session->set_flashdata('success', 'Enviado parcialmente via ' . implode(', ', $sucessos) . '. Falhou: ' . implode(', ', $erros));
        } elseif(count($sucessos) == 0 && count($erros) > 0) {
            $this->session->set_flashdata('error', 'Falha ao enviar: ' . implode(', ', $erros));
        } else {
            $this->session->set_flashdata('error', 'Nenhum meio de envio válido selecionado ou configurado.');
        }

        redirect(site_url('comunicacao'));
    }

    private function enviarViaWhaticket($numero, $texto, $anexoPath = null)
    {
        $apiUrl = $_ENV['WHATICKET_API_URL'] ?? '';
        $apiToken = $_ENV['WHATICKET_API_TOKEN'] ?? '';
        
        if (empty($apiUrl) || empty($apiToken)) {
            return 'API Whaticket não configurada.';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, rtrim($apiUrl, '/') . '/api/messages/send');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        if ($anexoPath && file_exists($anexoPath)) {
            $mime = mime_content_type($anexoPath);
            $filename = basename($anexoPath);
            $postData = [
                'number' => '55' . $numero,
                'body' => $texto,
                'medias' => new CURLFile($anexoPath, $mime, $filename)
            ];
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $apiToken
            ]);
        } else {
            $payload = json_encode([
                'number' => '55' . $numero,
                'body' => $texto
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiToken
            ]);
        }

        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpcode == 200 || $httpcode == 201) {
            return true;
        }

        return $result;
    }

    private function enviarViaEmail($para, $assunto, $mensagem, $anexoPath = null)
    {
        // Se houver anexo, precisamos enviar no ato.
        // O queue não suporta anexos no Map-OS por padrão.
        if ($anexoPath && file_exists($anexoPath)) {
            $this->load->library('email');
            
            $config['protocol'] = getenv('EMAIL_PROTOCOL') ?: 'smtp';
            $config['smtp_host'] = getenv('EMAIL_SMTP_HOST');
            $config['smtp_user'] = getenv('EMAIL_SMTP_USER');
            $config['smtp_pass'] = getenv('EMAIL_SMTP_PASS');
            $config['smtp_port'] = getenv('EMAIL_SMTP_PORT');
            $config['smtp_crypto'] = getenv('EMAIL_SMTP_CRYPTO');
            $config['charset'] = 'utf-8';
            $config['mailtype'] = 'html';
            $config['newline'] = "\r\n";
            
            $this->email->initialize($config);
            $this->email->clear(TRUE);
            $this->email->from(getenv('EMAIL_SMTP_USER'), getenv('app_name') ?: 'Map-OS');
            $this->email->to($para);
            $this->email->subject($assunto);
            $this->email->message($mensagem);
            
            $this->email->attach($anexoPath);
            
            return $this->email->send();
        }

        // Sem anexo, pode ir pra fila
        $this->load->model('email_model');
        
        $data = [
            'to' => $para,
            'message' => $mensagem,
            'status' => 'pending',
            'date' => date('Y-m-d H:i:s'),
            'headers' => null,
            'subject' => $assunto
        ];

        if ($this->email_model->add('email_queue', $data) == true) {
            return true;
        } else {
            return false;
        }
    }
}
