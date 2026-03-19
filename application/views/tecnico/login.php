<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Técnico - Map-OS</title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, <?= $configuration_site->cor_secundaria ?? '#222f3e' ?> 0%, <?= $configuration_site->cor_primaria ?? '#1e272e' ?> 100%);
            color: #fff;
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header img {
            max-height: 80px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        
        .login-header h3 {
            font-weight: 700;
            color: #fff;
            margin-bottom: 5px;
        }
        
        .login-header p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }
        
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: <?= $configuration_site->cor_primaria ?? '#ff9f43' ?>;
            color: #fff;
            box-shadow: none;
        }
        
        .btn-login {
            background: <?= $configuration_site->cor_primaria ?? '#ff9f43' ?>;
            color: #fff;
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            border: none;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            filter: brightness(0.9);
            transform: translateY(-2px);
        }
        
        .alert {
            background: rgba(231, 76, 60, 0.2);
            border: 1px solid rgba(231, 76, 60, 0.5);
            color: #ff6b6b;
            border-radius: 10px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <?php if(isset($configuration_site->imagem_tecnico) && !empty($configuration_site->imagem_tecnico)): ?>
                <img src="<?= base_url('uploads/site/' . $configuration_site->imagem_tecnico) ?>" alt="Logo">
            <?php else: ?>
                <i class='bx bxs-wrench' style="font-size: 50px; color: <?= $configuration_site->cor_primaria ?? '#ff9f43' ?>; margin-bottom: 10px;"></i>
            <?php endif; ?>
            
            <h3>Painel do Técnico</h3>
            <p>Acesso exclusivo para colaboradores</p>
        </div>
        
        <form action="<?php echo base_url() ?>index.php/tecnico/verificarLogin" method="post">
            <?php if ($this->session->flashdata('error') != null) { ?>
                <div class="alert text-center">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php } ?>
            
            <div class="form-group mb-3">
                <label class="form-label small text-muted text-uppercase fw-bold">Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-0 ps-0 text-white"><i class='bx bx-user'></i></span>
                    <input type="email" class="form-control" name="email" placeholder="Seu email" required autofocus>
                </div>
            </div>
            
            <div class="form-group mb-4">
                <label class="form-label small text-muted text-uppercase fw-bold">Senha</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-0 ps-0 text-white"><i class='bx bx-lock-alt'></i></span>
                    <input type="password" class="form-control" name="senha" placeholder="Sua senha" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-login">
                Entrar no Painel <i class='bx bx-right-arrow-alt'></i>
            </button>
            
            <div class="text-center mt-4">
                <a href="<?php echo base_url(); ?>" class="text-decoration-none small" style="color: rgba(255,255,255,0.5);">
                    <i class='bx bx-arrow-back'></i> Voltar para o Site
                </a>
            </div>
        </form>
    </div>

</body>
</html>
