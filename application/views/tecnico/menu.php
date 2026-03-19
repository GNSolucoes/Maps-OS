
<!--sidebar-menu-->
<nav id="sidebar">
    <div id="newlog">
        <div class="icon2">
            <img src="<?php echo base_url() ?>assets/img/logo-two.png">
        </div>
        <div class="title1">
            <?= $configuration['app_theme'] == 'white' ||  $configuration['app_theme'] == 'whitegreen' ? '<img src="' . base_url() . 'assets/img/logo-mapos.png">' : '<img src="' . base_url() . 'assets/img/logo-mapos-branco.png">'; ?>
        </div>
    </div>
    <a href="#" class="visible-phone">
        <div class="mode">
            <div class="moon-menu">
                <i class='bx bx-chevron-right iconX open-2'></i>
                <i class='bx bx-chevron-left iconX close-2'></i>
            </div>
        </div>
    </a>
    
    <div class="menu-bar" style="max-height: calc(100vh - 200px); overflow-y: auto; overflow-x: hidden;">
        <div class="menu">
            <ul class="menu-links" style="position: relative;">
                <li class="<?php if ((isset($menuTecnico) && $menuTecnico == 'dashboard') || isset($menuPainel)) { echo 'active'; }; ?>">
                    <a class="tip-bottom" title="" href="<?= site_url('mapos') ?>"><i class='bx bx-home-alt iconX'></i>
                        <span class="title nav-title">Home</span>
                        <span class="title-tooltip">Início</span>
                    </a>
                </li>

                <li class="<?php if (isset($menuTecnico) && $menuTecnico == 'rotas') { echo 'active'; }; ?>">
                    <a class="tip-bottom" title="" href="<?= site_url('tecnico/rotas') ?>"><i class='bx bx-map-alt iconX'></i>
                        <span class="title">Rotas de Hoje</span>
                        <span class="title-tooltip">Rotas</span>
                    </a>
                </li>

                <li class="<?php if (isset($menuTecnico) && $menuTecnico == 'minhas_os') { echo 'active'; }; ?>">
                    <a class="tip-bottom" title="" href="<?= site_url('tecnico/minhas_os') ?>"><i class='bx bx-file iconX'></i>
                        <span class="title">Minhas OS / Assinar</span>
                        <span class="title-tooltip">OSs</span>
                    </a>
                </li>

                <li class="<?php if (isset($menuTecnico) && $menuTecnico == 'nova_os') { echo 'active'; }; ?>">
                    <a class="tip-bottom" title="" href="<?= site_url('tecnico/nova_os_rapida') ?>"><i class='bx bx-plus-circle iconX'></i>
                        <span class="title">Nova OS Rápida</span>
                        <span class="title-tooltip">Nova OS</span>
                    </a>
                </li>
                
                <li>
                    <a class="tip-bottom" title="" href="<?= site_url('tecnico/produtos') ?>"><i class='bx bx-box iconX'></i>
                        <span class="title">Saída de Produtos</span>
                        <span class="title-tooltip">Produtos</span>
                    </a>
                </li>
                

            </ul>
        </div>

        <div class="botton-content">
            <li class="">
                <a class="tip-bottom" title="" href="<?= site_url('tecnico/sair'); ?>">
                    <i class='bx bx-log-out-circle iconX'></i>
                    <span class="title">Sair</span>
                    <span class="title-tooltip">Sair</span>
                </a>
            </li>
        </div>
    </div>
    
    <style>
    .menu-bar::-webkit-scrollbar { width: 6px; }
    .menu-bar::-webkit-scrollbar-track { background: transparent; }
    .menu-bar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
    .menu-bar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.3); }
    </style>
</nav>
