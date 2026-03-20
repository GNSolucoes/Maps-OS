<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $config = (isset($config) && is_array($config)) ? (object)$config : ($config ?? new stdClass()); ?>
    <title><?php echo $pagina ? $pagina->titulo : 'Página'; ?> - <?php echo $config->nome_empresa ?? 'Map-OS'; ?></title>
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
                        <li class="nav-item"><a class="nav-link <?php echo ($pagina && $pagina->slug == $p->slug) ? 'active' : ''; ?>" href="<?php echo base_url('index.php/home/pagina/' . $p->slug); ?>"><?php echo $p->titulo; ?></a></li>
                    <?php endforeach; endif; ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url('index.php/home/contato'); ?>">Fale Conosco</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url('index.php/mine'); ?>">Área do Cliente</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1><?php echo $pagina ? $pagina->titulo : 'Página não encontrada'; ?></h1>
            <p>Confira os detalhes desta página abaixo.</p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="page-content py-5" style="min-height: 50vh;">
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 p-md-5 text-dark" style="line-height: 1.8; color: #333;">
                            <?php 
                            if ($pagina) {
                                echo $pagina->conteudo; 
                            } else {
                                echo '<p class="text-center text-muted">A página que você está procurando não existe ou foi removida.</p>';
                            }
                            ?>
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
                    <a href="<?php echo base_url('index.php/tecnico'); ?>" class="btn btn-outline-secondary btn-sm rounded-pill me-2 text-decoration-none admin-badge" style="color:white">
                        <i class='bx bxs-wrench me-1'></i> Painel do Técnico
                    </a>
                    <a href="<?php echo base_url('index.php/login'); ?>" class="btn btn-outline-secondary btn-sm rounded-pill text-decoration-none admin-badge" style="color:white">
                        <i class='bx bxs-lock-alt me-1'></i> Área Administrativa
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
                document.querySelector('.navbar').style.background = 'rgba(255, 255, 255, 0.98)';
                document.querySelector('.navbar').style.boxShadow = '0 10px 30px rgba(0,0,0,0.1)';
            } else {
                document.querySelector('.navbar').classList.remove('scrolled');
                document.querySelector('.navbar').style.background = 'transparent';
                document.querySelector('.navbar').style.boxShadow = 'none';
            }
        });
        
        // Garante que o menu receba o efeito de background após carregar
        setTimeout(function() {
            document.querySelector('.navbar').classList.add('scrolled');
            document.querySelector('.navbar').style.background = 'rgba(255, 255, 255, 0.98)';
        }, 100);
    </script>
</body>
</html>
