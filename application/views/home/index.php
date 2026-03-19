<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $config = (isset($config) && is_array($config)) ? (object)$config : ($config ?? new stdClass()); ?>
    <title><?php echo $config->nome_empresa ?? 'Map-OS'; ?> - Soluções em Assistência Técnica</title>
    <meta name="description" content="<?php echo $config->meta_description ?? ''; ?>">
    <meta name="keywords" content="<?php echo $config->meta_keywords ?? ''; ?>">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png" type="image/png">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/site-custom.css'); ?>" rel="stylesheet">
    
    <style>
        :root {
            /* Cores extraídas da imagem enviada */
            --primary-color: #ff9f43; /* Laranja Map-OS */
            --primary-hover: #e67e22;
            --dark-bg: #222f3e; /* Azul Escuro Fundo */
            --darker-bg: #182029;
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            color: #333;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.98); /* Branco padrão */
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            padding: 1rem 0;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98) !important;
            padding: 0.5rem 0 !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
        }

        @media (max-width: 991px) {
            .navbar-collapse {
                background: #ffffff;
                padding: 20px;
                border-radius: 10px;
                margin-top: 10px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            }
        }
        
        .navbar-brand img {
            max-height: 45px;
        }
        
        .navbar-brand span {
            color: #222f3e !important; /* Azul Escuro */
        }
        
        .navbar-toggler span {
            color: #222f3e; 
            filter: none;
        }
        
        .nav-link {
            color: #222f3e !important; /* Azul Escuro */
            font-weight: 500;
            margin-left: 20px;
            position: relative;
            transition: color 0.3s;
        }

        .navbar.scrolled .nav-link {
            color: #222f3e !important;
        }

        .navbar.scrolled .navbar-brand span {
            color: #222f3e !important;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--primary-color);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }

        /* Hero Section */
        .hero {
            position: relative;
            background: linear-gradient(135deg, #222f3e 0%, #1e272e 100%); /* Fundo Escuro */
            padding: 180px 0 120px;
            overflow: hidden;
            color: white; /* Texto Branco */
        }
        
        .hero::before {
            background: radial-gradient(circle, rgba(255, 159, 67, 0.1) 0%, rgba(255,255,255,0) 70%); /* Glow Laranja */
        }
        
        .hero h1 {
            background: none;
            -webkit-text-fill-color: initial;
            color: white;
            margin-bottom: 1.5rem;
        }
        
        .hero p {
            color: rgba(255,255,255,0.7);
        }
        
        .badge-hero {
            background: rgba(255, 159, 67, 0.15);
            color: #ff9f43;
            border: 1px solid rgba(255, 159, 67, 0.3);
        }
        
        .btn-custom {
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }
        
        .btn-primary-custom {
            background: var(--primary-color);
            border: 2px solid var(--primary-color);
            color: white;
            box-shadow: 0 10px 20px rgba(230, 126, 34, 0.2);
        }
        
        .btn-primary-custom:hover {
            background: transparent;
            color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(230, 126, 34, 0.3);
        }
        
        .btn-outline-light-custom {
            border: 2px solid rgba(255,255,255,0.2);
            color: white;
        }
        
        .btn-outline-light-custom:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }

        .hero-img {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        /* Stats Section */
        .stats-section {
            padding: 60px 0;
            background: var(--primary-color);
            color: white;
            margin-top: -50px;
            border-radius: 0;
            position: relative;
            z-index: 2;
        }
        
        .stat-item {
            text-align: center;
            padding: 20px;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Section Styling */
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-title span {
            color: var(--primary-color);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            display: block;
            margin-bottom: 10px;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a1a1a;
        }

        /* Services Cards */
        .service-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.4s ease;
            height: 100%;
            border: 1px solid #f0f0f0;
            position: relative;
            overflow: hidden;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border-color: var(--primary-color);
        }
        
        .service-icon {
            width: 70px;
            height: 70px;
            background: rgba(var(--primary-rgb), 0.1);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            font-size: 32px;
            color: var(--primary-color);
            transition: all 0.4s ease;
        }

        .service-card:hover .service-icon {
            background: var(--primary-color);
            color: white;
            transform: rotateY(180deg);
        }

        /* Features Section */
        .feature-box {
            display: flex;
            align-items: flex-start;
            margin-bottom: 30px;
        }
        
        .feature-icon {
            flex-shrink: 0;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(var(--primary-rgb), 0.1);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-right: 20px;
        }
        
        .feature-content h5 {
            font-weight: 600;
            margin-bottom: 10px;
        }

        /* Testimonials */
        .testimonial-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin: 15px;
            text-align: center;
            position: relative;
        }
        
        .testimonial-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: -70px auto 20px;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            background: #eee;
            object-fit: cover;
        }
        
        .testimonial-quote {
            font-style: italic;
            color: #666;
            margin-bottom: 20px;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #1a1a1a 0%, #2c3e50 100%);
            padding: 80px 0;
            color: white;
            text-align: center;
        }

        /* Footer */
        .custom-footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 70px 0 30px;
        }
        
        .custom-footer h5 {
            color: white;
            margin-bottom: 25px;
            font-weight: 600;
        }
        
        .custom-footer ul li {
            margin-bottom: 12px;
        }
        
        .custom-footer a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .custom-footer a:hover {
            color: white;
        }
        
        .social-links a {
            display: inline-flex;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            color: white;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            transition: all 0.3s;
        }
        
        .social-links a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }
        
        .admin-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 20px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 30px;
            color: #94a3b8;
            font-size: 0.9rem;
            margin-top: 20px;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .admin-badge:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
    </style>
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
                    <li class="nav-item"><a class="nav-link" href="#servicos">Serviços</a></li>
                    <li class="nav-item"><a class="nav-link" href="#sobre">Sobre</a></li>
                    <?php if ($paginas): foreach ($paginas as $p): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('index.php/home/pagina/' . $p->slug); ?>"><?php echo $p->titulo; ?></a></li>
                    <?php endforeach; endif; ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url('index.php/mine'); ?>">Área do Cliente</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-primary-custom" href="<?php echo base_url('index.php/home/contato'); ?>">Fale Conosco</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="hero-content">
                        <span class="badge badge-hero mb-3 px-3 py-2 rounded-pill">🚀 Sistema #1 de Gestão</span>
                        <h1><?php echo $config->nome_empresa ?? 'Soluções Tecnológicas Inteligentes'; ?></h1>
                        <p class="lead">Simplificamos a gestão do seu negócio com tecnologia de ponta. Controle, organização e eficiência em um só lugar.</p>
                        <div class="d-flex gap-3">
                            <a href="<?php echo base_url('index.php/home/orcamento'); ?>" class="btn btn-primary-custom btn-custom shadow">Solicitar Orçamento</a>
                            <a href="#servicos" class="btn btn-outline-light-custom btn-custom">Saiba Mais</a>
                        </div>
                        <div class="mt-4 d-flex align-items-center gap-3">
                            <div class="d-flex">
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                            </div>
                            <span class="text-white small opacity-75"><strong>4.9/5</strong> de satisfação de nossos clientes</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-left">
                    <!-- Imagem de Tecnologia/SaaS Clean -->
                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/web-development-2974925-2477356.png" alt="Tech Solutions" class="img-fluid hero-img d-block mx-auto" style="max-height: 500px; object-fit: contain; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3));">
                </div>
            </div>
        </div>
    </section>

    <!-- WhatsApp Floating Button -->
    <?php if ($config->whatsapp): ?>
    <a href="https://wa.me/<?php echo $config->whatsapp; ?>" class="whatsapp-float shadow-lg" target="_blank" title="Fale conosco no WhatsApp">
        <i class='bx bxl-whatsapp'></i>
    </a>
    <?php else: ?>
    <!-- Demo WhatsApp Button if not configured -->
    <a href="#" class="whatsapp-float shadow-lg" target="_blank" title="Fale conosco no WhatsApp (Demo)">
        <i class='bx bxl-whatsapp'></i>
    </a>
    <?php endif; ?>

    <style>
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 35px;
            box-shadow: 2px 2px 3px #999;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            animation: pulse-green 2s infinite;
        }

        .whatsapp-float:hover {
            background-color: #128c7e;
            color: #FFF;
            transform: scale(1.1);
        }

        @keyframes pulse-green {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(37, 211, 102, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }
    </style>

    <!-- Stats Counter -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-item">
                        <div class="stat-number">2.5k</div>
                        <div class="stat-label">Clientes Atendidos</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-item">
                        <div class="stat-number">4.8k</div>
                        <div class="stat-label">Reparos Feitos</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-item">
                        <div class="stat-number">150+</div>
                        <div class="stat-label">Empresas Parceiras</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Satisfação</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Serviços -->
    <section id="servicos" class="py-5" style="background-color: #fff;">
        <div class="container py-5">
            <div class="section-title" data-aos="fade-up">
                <span>O Que Fazemos</span>
                <h2>Nossos Serviços Premium</h2>
                <p class="text-muted mx-auto" style="max-width: 600px;">Oferecemos uma gama completa de soluções técnicas para manter seus equipamentos sempre funcionando com a máxima performance.</p>
            </div>
            
            <div class="row g-4">
                <?php 
                // Se não houver serviços, usar fictícios para demo
                $servicos_display = ($servicos && count($servicos) > 0) ? $servicos : [
                    (object)['titulo' => 'Manutenção de Hardware', 'descricao' => 'Reparo especializado em placas, troca de componentes e limpeza avançada.', 'icone' => 'bx-chip'],
                    (object)['titulo' => 'Soluções em Software', 'descricao' => 'Melhoria de desempenho, formatação e instalação de sistemas corporativos.', 'icone' => 'bx-code-alt'],
                    (object)['titulo' => 'Redes Corporativas', 'descricao' => 'Estruturação, cabeamento e configuração de servidores seguros.', 'icone' => 'bx-network-chart'],
                ];
                
                $delay = 100;
                foreach ($servicos_display as $s): 
                ?>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class='bx <?php echo $s->icone; ?>'></i>
                        </div>
                        <h4><?php echo $s->titulo; ?></h4>
                        <p class="text-muted"><?php echo $s->descricao; ?></p>
                        <a href="#" class="text-decoration-none fw-bold mt-2 d-inline-block">Saiba Mais <i class='bx bx-right-arrow-alt'></i></a>
                    </div>
                </div>
                <?php $delay += 100; endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Sobre Section -->
    <section id="sobre" class="py-5 bg-light">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <img src="https://images.unsplash.com/photo-1553877607-3365b9450979?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Sobre Nós" class="img-fluid rounded-3 shadow-lg">
                </div>
                <div class="col-lg-6 ps-lg-5" data-aos="fade-left">
                    <div class="section-title text-start mb-4">
                        <span>Quem Somos</span>
                        <h2>Experts em Tecnologia e Inovação</h2>
                    </div>
                    <?php if ($config->sobre): ?>
                        <p class="lead text-muted mb-4"><?php echo nl2br($config->sobre); ?></p>
                    <?php else: ?>
                        <p class="lead text-muted mb-4">Somos uma empresa líder em soluções de tecnologia, com mais de 10 anos de mercado. Nossa missão é entregar excelência em cada reparo e serviço prestado.</p>
                        <p class="text-muted mb-4">Contamos com uma equipe de especialistas certificados e um laboratório de última geração para garantir que seu equipamento receba o melhor tratamento possível.</p>
                    <?php endif; ?>
                    
                    <div class="row g-4 mb-4">
                        <div class="col-6">
                            <div class="feature-box">
                                <div class="feature-icon"><i class='bx bx-check-shield'></i></div>
                                <div class="feature-content">
                                    <h5>Garantia Total</h5>
                                    <p class="small text-muted mb-0">Serviços com garantia estendida</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="feature-box">
                                <div class="feature-icon"><i class='bx bx-time-five'></i></div>
                                <div class="feature-content">
                                    <h5>Agilidade</h5>
                                    <p class="small text-muted mb-0">Atendimento rápido e eficiente</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="<?php echo base_url('index.php/home/contato'); ?>" class="btn btn-primary-custom btn-custom">Fale com um Especialista</a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container" data-aos="zoom-in">
            <h2 class="mb-4 display-5 fw-bold">Pronto para transformar seu negócio?</h2>
            <p class="lead mb-5 opacity-75">Junte-se a centenas de empresas que confiam na nossa tecnologia.</p>
            <a href="<?php echo base_url('index.php/home/contato'); ?>" class="btn btn-light btn-lg px-5 py-3 rounded-pill fw-bold text-primary shadow">Começar Agora</a>
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
                    <p class="mb-4 opacity-75">Soluções completas para gerenciamento e assistência técnica. Inovação e confiança em cada serviço.</p>
                    <div class="social-links d-flex gap-2">
                        <?php if ($config->facebook): ?>
                            <a href="<?php echo $config->facebook; ?>" target="_blank" class="social-btn facebook" title="Facebook"><i class='bx bxl-facebook'></i></a>
                        <?php endif; ?>
                        <?php if ($config->instagram): ?>
                            <a href="<?php echo $config->instagram; ?>" target="_blank" class="social-btn instagram" title="Instagram"><i class='bx bxl-instagram'></i></a>
                        <?php endif; ?>
                        <?php if ($config->whatsapp): ?>
                            <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $config->whatsapp); ?>" target="_blank" class="social-btn whatsapp" title="WhatsApp"><i class='bx bxl-whatsapp'></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5>Links Rápidos</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="<?php echo base_url(); ?>"><i class='bx bx-chevron-right text-primary'></i> Início</a></li>
                        <li><a href="#sobre"><i class='bx bx-chevron-right text-primary'></i> Sobre Nós</a></li>
                        <li><a href="#servicos"><i class='bx bx-chevron-right text-primary'></i> Serviços</a></li>
                        <li><a href="<?php echo base_url('index.php/home/contato'); ?>"><i class='bx bx-chevron-right text-primary'></i> Contato</a></li>
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
                    <ul class="list-unstyled contact-info">
                        <?php if ($config->endereco): ?>
                        <li class="d-flex mb-3">
                            <div class="icon-box me-3"><i class='bx bx-map'></i></div>
                            <span><?php echo $config->endereco; ?></span>
                        </li>
                        <?php endif; ?>
                        <?php if ($config->telefone): ?>
                        <li class="d-flex mb-3">
                            <div class="icon-box me-3"><i class='bx bx-phone'></i></div>
                            <span><?php echo $config->telefone; ?></span>
                        </li>
                        <?php endif; ?>
                        <?php if ($config->email): ?>
                        <li class="d-flex mb-3">
                            <div class="icon-box me-3"><i class='bx bx-envelope'></i></div>
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

    <style>
        .social-btn {
            width: 45px;
            height: 45px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .social-btn:hover {
            transform: translateY(-5px);
            color: white;
        }
        
        .social-btn.facebook:hover { background: #1877f2; border-color: #1877f2; box-shadow: 0 5px 15px rgba(24, 119, 242, 0.3); }
        .social-btn.instagram:hover { background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); border-color: transparent; box-shadow: 0 5px 15px rgba(220, 39, 67, 0.3); }
        .social-btn.whatsapp:hover { background: #25d366; border-color: #25d366; box-shadow: 0 5px 15px rgba(37, 211, 102, 0.3); }

        .footer-links a {
            display: block;
            padding: 5px 0;
            transition: padding-left 0.3s;
        }
        
        .footer-links a:hover {
            padding-left: 10px;
            color: var(--primary-color);
        }
        
        .contact-info .icon-box {
            width: 35px;
            height: 35px;
            background: rgba(255,255,255,0.05);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            flex-shrink: 0;
        }
        
        .map-container iframe {
            width: 100%;
            height: 100%;
            border: 0;
            filter: grayscale(100%) invert(92%) contrast(83%);
        }
    </style>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
        
        // Navbar change styling on scroll
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('scrolled');
            } else {
                document.querySelector('.navbar').classList.remove('scrolled');
            }
        });
    </script>
    <?php
        $ci =& get_instance();
        $ci->load->database();
        $conf = $ci->db->get_where('configuracoes', ['config' => 'tawk_to_embed'])->row();
        if($conf && !empty($conf->valor)){ echo $conf->valor; }
    ?>
</body>
</html>
