<?php
class Seed_site extends CI_Controller {
    public function index() {
        $this->load->database();
        
        // Seed Servicos se estiver vazio
        $q_servicos = $this->db->get('site_servicos');
        if ($q_servicos->num_rows() == 0) {
            $servicos = [
                ['titulo' => 'Manutenção de Hardware', 'descricao' => 'Reparo especializado em placas, troca de componentes e limpeza avançada.', 'icone' => 'bx-chip', 'ordem' => 1, 'ativo' => 1],
                ['titulo' => 'Soluções em Software', 'descricao' => 'Melhoria de desempenho, formatação e instalação de sistemas corporativos.', 'icone' => 'bx-code-alt', 'ordem' => 2, 'ativo' => 1],
                ['titulo' => 'Redes Corporativas', 'descricao' => 'Estruturação, cabeamento e configuração de servidores seguros.', 'icone' => 'bx-network-chart', 'ordem' => 3, 'ativo' => 1],
            ];
            $this->db->insert_batch('site_servicos', $servicos);
            echo "Servicos adicionados.\n";
        }

        // Seed Depoimentos se estiver vazio
        $q_depoimentos = $this->db->get('site_depoimentos');
        if ($q_depoimentos->num_rows() == 0) {
            $depoimentos = [
                ['nome' => 'João Silva', 'empresa' => 'Empresa XYZ', 'depoimento' => 'Excelente trabalho! O reparo foi rápido e meus equipamentos voltaram a funcionar perfeitamente.', 'foto' => '', 'ordem' => 1, 'ativo' => 1],
                ['nome' => 'Maria Souza', 'empresa' => 'Comércio Local', 'depoimento' => 'A melhor assistência técnica da região. Resolveram meu problema de rede em poucas horas.', 'foto' => '', 'ordem' => 2, 'ativo' => 1],
            ];
            $this->db->insert_batch('site_depoimentos', $depoimentos);
            echo "Depoimentos adicionados.\n";
        }
        
        // Seed Páginas se estiver vazio
        $q_paginas = $this->db->get('site_paginas');
        if ($q_paginas->num_rows() == 0) {
            $paginas = [
                ['titulo' => 'Sobre Nós', 'slug' => 'sobre-nos', 'conteudo' => '<h2>Quem Somos</h2><p>Somos uma empresa dedicada a entregar a melhor solução para você. Nossa missão é otimizar seu tempo e melhorar o seu dia a dia.</p>', 'ordem' => 1, 'ativo' => 1],
                ['titulo' => 'Política de Privacidade', 'slug' => 'politica-de-privacidade', 'conteudo' => '<h2>Sua Privacidade</h2><p>Garantimos sigilo absoluto sobre os dados aqui trafegados, de acordo com as diretrizes e leis de proteção vigentes.</p>', 'ordem' => 2, 'ativo' => 1],
                ['titulo' => 'Termos de Serviço', 'slug' => 'termos-de-servico', 'conteudo' => '<h2>Nossos Termos</h2><p>Ao utilizar os serviços de nossa empresa, você concorda com os termos e regras expostos aqui.</p>', 'ordem' => 3, 'ativo' => 1],
            ];
            $this->db->insert_batch('site_paginas', $paginas);
            echo "Paginas adicionadas.\n";
        }
        
        echo "Done.";
    }
}
