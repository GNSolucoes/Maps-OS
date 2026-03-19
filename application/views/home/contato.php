<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $config = (isset($config) && is_array($config)) ? (object)$config : ($config ?? new stdClass()); ?>
    <title>Contato - <?php echo $config->nome_empresa ?? 'Map-OS'; ?></title>
    <meta name="description" content="<?php echo $config->meta_description ?? ''; ?>">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png" type="image/png">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Custom CSS -->
    <link href="<?php echo base_url('assets/css/site-custom.css'); ?>" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo base_url(); ?>">
                <?php if ($config->logo): ?>
                    <img src="<?php echo base_url('uploads/site/' . $config->logo); ?>" alt="Map-OS">
                <?php else: ?>
                    <span class="fw-bold text-white fs-4">MAP<span style="color: #ff9f43">-OS</span></span>
                <?php endif; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="bx bx-menu fs-1 text-white"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>">Início</a></li>
                    <?php if ($paginas): foreach ($paginas as $p): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('index.php/home/pagina/' . $p->slug); ?>"><?php echo $p->titulo; ?></a></li>
                    <?php endforeach; endif; ?>
                    <li class="nav-item"><a class="nav-link active" href="<?php echo base_url('index.php/home/contato'); ?>">Fale Conosco</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url('index.php/mine'); ?>">Área do Cliente</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 data-aos="fade-down">Entre em Contato</h1>
            <p data-aos="fade-up" data-aos-delay="100">Estamos aqui para ajudar você. Preencha o formulário ou use nossos canais diretos.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section py-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-4">
                    <div class="card h-100 text-center p-4">
                        <div class="card-body">
                            <i class='bx bx-phone bx-lg text-primary mb-3'></i>
                            <h5>Telefone</h5>
                            <p class="text-muted mb-0"><?php echo $config->telefone ?? 'Não informado'; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card h-100 text-center p-4">
                        <div class="card-body">
                            <i class='bx bx-envelope bx-lg text-primary mb-3'></i>
                            <h5>Email</h5>
                            <p class="text-muted mb-0"><?php echo $config->email ?? 'Não informado'; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card h-100 text-center p-4">
                        <div class="card-body">
                            <i class='bx bx-map bx-lg text-primary mb-3'></i>
                            <h5>Endereço</h5>
                            <p class="text-muted mb-0"><?php echo $config->endereco ?? 'Não informado'; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card shadow-lg">
                        <div class="card-body p-5">
                            <h3 class="mb-4 text-center">Envie sua Mensagem</h3>
                            
                            <?php if (isset($success)): ?>
                                <div class="alert alert-success d-flex align-items-center"><i class='bx bx-check-circle me-2'></i> <?php echo $success; ?></div>
                            <?php endif; ?>
                            
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger d-flex align-items-center"><i class='bx bx-error me-2'></i> <?php echo $error; ?></div>
                            <?php endif; ?>
                            
                            <form method="post" action="<?php echo base_url('index.php/home/contato'); ?>">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nome *</label>
                                        <input type="text" name="nome" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email *</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Telefone</label>
                                        <input type="text" name="telefone" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Assunto</label>
                                        <input type="text" name="assunto" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Mensagem *</label>
                                        <textarea name="mensagem" class="form-control" rows="5" required></textarea>
                                    </div>
                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-primary-custom px-5">
                                            <i class='bx bx-send me-2'></i> Enviar Mensagem
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="custom-footer">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4 col-md-6">
                    <h5 class="h4 mb-4 text-white d-flex align-items-center">
                        <?php if ($config->logo): ?>
                            <img src="<?php echo base_url('uploads/site/' . $config->logo); ?>" alt="" style="height: 30px; margin-right: 10px;">
                        <?php else: ?>
                            <span class="fw-bold text-white fs-4">MAP<span style="color: #ff9f43">-OS</span></span>
                        <?php endif; ?>
                    </h5>
                    <p class="mb-4 opacity-75"><?php echo $config->sobre ? substr($config->sobre, 0, 150) . '...' : 'Soluções completas para gerenciamento e assistência técnica.'; ?></p>
                    <div class="social-links d-flex gap-2">
                        <?php if ($config->facebook): ?>
                            <a href="<?php echo $config->facebook; ?>" target="_blank" title="Facebook"><i class='bx bxl-facebook'></i></a>
                        <?php endif; ?>
                        <?php if ($config->instagram): ?>
                            <a href="<?php echo $config->instagram; ?>" target="_blank" title="Instagram"><i class='bx bxl-instagram'></i></a>
                        <?php endif; ?>
                        <?php if ($config->whatsapp): ?>
                            <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $config->whatsapp); ?>" target="_blank" title="WhatsApp"><i class='bx bxl-whatsapp'></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5>Links Rápidos</h5>
                    <ul class="list-unstyled footer-links" style="padding-left: 0;">
                        <li style="margin-bottom: 10px;"><a href="<?php echo base_url(); ?>"><i class='bx bx-chevron-right text-primary'></i> Início</a></li>
                        <li style="margin-bottom: 10px;"><a href="<?php echo base_url('index.php/home/contato'); ?>"><i class='bx bx-chevron-right text-primary'></i> Contato</a></li>
                        <li style="margin-bottom: 10px;"><a href="<?php echo base_url('index.php/mine'); ?>"><i class='bx bx-chevron-right text-primary'></i> Área do Cliente</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5>Localização</h5>
                    <?php if (isset($config->mapa_iframe) && $config->mapa_iframe): ?>
                        <div class="map-container rounded-3 overflow-hidden shadow-sm border border-secondary" style="height: 150px;">
                            <?php echo $config->mapa_iframe; ?>
                        </div>
                    <?php else: ?>
                        <div class="p-3 bg-dark bg-opacity-50 rounded text-center text-muted">
                            <i class='bx bx-map-alt fs-1 mb-2'></i>
                            <p class="small mb-0">Mapa não configurado</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5>Contato</h5>
                    <ul class="list-unstyled contact-info" style="padding-left: 0;">
                        <?php if ($config->endereco): ?>
                        <li class="d-flex mb-3">
                            <i class='bx bx-map me-3 text-primary mt-1'></i>
                            <span><?php echo $config->endereco; ?></span>
                        </li>
                        <?php endif; ?>
                        <?php if ($config->telefone): ?>
                        <li class="d-flex mb-3">
                            <i class='bx bx-phone me-3 text-primary mt-1'></i>
                            <span><?php echo $config->telefone; ?></span>
                        </li>
                        <?php endif; ?>
                        <?php if ($config->email): ?>
                        <li class="d-flex mb-3">
                            <i class='bx bx-envelope me-3 text-primary mt-1'></i>
                            <span><?php echo $config->email; ?></span>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            
            <hr class="my-5" style="border-color: rgba(255,255,255,0.05);">
            
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 small opacity-50">&copy; <?php echo date('Y'); ?> <?php echo $config->nome_empresa ?? 'Map-OS'; ?>. Todos os direitos reservados.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="<?php echo base_url('index.php/tecnico'); ?>" class="admin-badge me-2">
                        <i class='bx bxs-wrench me-2'></i> Painel do Técnico
                    </a>
                    <a href="<?php echo base_url('index.php/login'); ?>" class="admin-badge">
                        <i class='bx bxs-lock-alt me-2'></i> Área Administrativa
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar change styling on scroll
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('scrolled');
            } else {
                document.querySelector('.navbar').classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
