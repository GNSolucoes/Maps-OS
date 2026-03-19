<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $config = (isset($config) && is_array($config)) ? (object)$config : ($config ?? new stdClass()); ?>
    <title>Solicitar Orçamento - <?php echo $config->nome_empresa ?? 'Map-OS'; ?></title>
    <meta name="description" content="<?php echo $config->meta_description ?? ''; ?>">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png" type="image/png">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="<?php echo base_url('assets/css/site-custom.css'); ?>" rel="stylesheet">

    <style>
        :root {
            --primary-color: <?php echo $config->cor_primaria ?? '#ff9f43'; ?>;
            --primary-hover: <?php echo $config->cor_secundaria ?? '#e67e22'; ?>;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .hero-page {
            background: linear-gradient(135deg, <?php echo $config->cor_secundaria ?? '#222f3e'; ?> 0%, <?php echo $config->cor_primaria ?? '#1e272e'; ?> 100%);
            padding: 120px 0 60px;
            color: white;
            text-align: center;
        }

        .contact-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 40px;
            margin-top: -50px;
        }

        .form-control {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(255, 159, 67, 0.2);
            border-color: var(--primary-color);
        }

        .btn-primary-custom {
            background: var(--primary-color);
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary-custom:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo base_url(); ?>">
                <?php if (isset($config->logo) && $config->logo): ?>
                    <img src="<?php echo base_url('uploads/site/' . $config->logo); ?>" alt="Map-OS" height="40">
                <?php else: ?>
                    <span class="fw-bold text-dark fs-4"><?php echo $config->nome_empresa ?? 'Map-OS'; ?></span>
                <?php endif; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#modalAbout">Sobre o Projeto</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>">Voltar ao Início</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-page">
        <div class="container">
            <h1 class="fw-bold">Solicitar Orçamento Gratuito</h1>
            <p class="lead opacity-75">Preencha o formulário abaixo e receba uma proposta personalizada</p>
        </div>
    </header>

    <section class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-card">
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success text-center mb-4">
                            <i class='bx bx-check-circle fs-4 align-middle me-2'></i>
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger text-center mb-4">
                            <i class='bx bx-error-circle fs-4 align-middle me-2'></i>
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo current_url(); ?>" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Seu Nome *</label>
                                <input type="text" name="nome" class="form-control" required placeholder="João da Silva">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nome da Empresa</label>
                                <input type="text" name="empresa" class="form-control" placeholder="Minha Empresa Ltda">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">WhatsApp *</label>
                                <input type="text" name="whatsapp" class="form-control" required placeholder="(11) 99999-9999">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">E-mail *</label>
                                <input type="email" name="email" class="form-control" required placeholder="email@exemplo.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Endereço Completo *</label>
                                <input type="text" name="endereco" class="form-control" required placeholder="Rua, Número, Bairro, Cidade - UF">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Equipamentos / Serviços *</label>
                                <input type="text" name="equipamentos" class="form-control" required placeholder="Ex: 5 Notebooks Dell, Instalação de Redes">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Descrição Detalhada do Problema/Necessidade *</label>
                                <textarea name="descricao" class="form-control" rows="5" required placeholder="Descreva o que precisa ser feito..."></textarea>
                            </div>
                            <div class="col-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary-custom w-100 py-3 fs-5">
                                    <i class='bx bx-paper-plane me-2'></i> Enviar Solicitação
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5 text-center">
        <div class="container">
            <p class="mb-0 opacity-75">&copy; <?php echo date('Y'); ?> <?php echo $config->nome_empresa ?? 'Map-OS'; ?>. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- Modal About -->
    <div class="modal fade" id="modalAbout" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title fw-bold">Sobre o Projeto Map-OS</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="text-center mb-4">
               <?php if (isset($config->logo) && $config->logo): ?>
                    <img src="<?php echo base_url('uploads/site/' . $config->logo); ?>" alt="Map-OS" style="max-height: 60px;">
               <?php else: ?>
                    <h3 class="fw-bold"><?php echo $config->nome_empresa ?? 'Map-OS'; ?></h3>
               <?php endif; ?>
               <p class="text-muted small mt-2">Sistema de Controle e Gestão de Ordens de Serviço</p>
            </div>
            
            <div class="row g-3">
                 <div class="col-12 p-3 bg-light rounded">
                    <h6 class="fw-bold"><i class='bx bx-code-alt'></i> Criador Original</h6>
                    <p class="mb-1 text-muted small"><strong>Desenvolvedor:</strong> Ramon Silva</p>
                    <a href="https://github.com/RamonSilva20/mapos" target="_blank" class="btn btn-sm btn-dark w-100"><i class='bx bxl-github'></i> GitHub Oficial</a>
                 </div>
                 
                 <div class="col-12 p-3 bg-light rounded mt-2">
                    <h6 class="fw-bold"><i class='bx bx-edit'></i> Customização / Versão GNSOLUCOES</h6>
                    <p class="mb-1 text-muted small"><strong>Responsável:</strong> GNSOLUCOES</p>
                    <div class="d-grid gap-2 d-md-block">
                        <a href="https://wa.me/5548996046486" target="_blank" class="btn btn-sm btn-success"><i class='bx bxl-whatsapp'></i> WhatsApp</a>
                        <a href="https://www.gnsolucoesinfo.com" target="_blank" class="btn btn-sm btn-info text-white"><i class='bx bx-globe'></i> Site</a>
                        <a href="https://github.com/GNSolucoes/Map-OS" target="_blank" class="btn btn-sm btn-dark"><i class='bx bxl-github'></i> GitHub</a>
                    </div>
                    <p class="mt-2 mb-0 text-muted small" style="font-size: 0.8rem">Esta versão contém modificações exclusivas e melhorias visuais desenvolvidas pela GNSOLUCOES.</p>
                 </div>
            </div>
            
            <div class="text-center mt-4">
                <p class="fst-italic text-muted small mb-0">"A tecnologia move o mundo."</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php
    // Optional: Tawk.to embed code if configured
    $ci =& get_instance();
    $ci->load->database();
    $conf = $ci->db->get_where('configuracoes', ['config' => 'tawk_to_embed'])->row();
    if($conf && !empty($conf->valor)){ echo $conf->valor; }
    ?>
</body>
</html>
