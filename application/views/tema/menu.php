<!--sidebar-menu-->
<nav id="sidebar">
    <div id="newlog">
        <div class="icon2">
            <img src="<?php echo base_url() ?>assets/img/logo-two.png">
        </div>
        <div class="title1">
            <?= $configuration['app_theme'] == 'white' ||  $configuration['app_theme'] == 'whitegreen' ? '<a href="'. site_url('mapos') .'"><img src="' . base_url() . 'assets/img/logo-mapos.png"></a>' : '<a href="'. site_url('mapos') .'"><img src="' . base_url() . 'assets/img/logo-mapos-branco.png"></a>'; ?>
        </div>
    </div>
    <!--
    <a href="#" class="visible-phone">
        <div class="mode">
            <div class="moon-menu">
                <i class='bx bx-chevron-right iconX open-2'></i>
                <i class='bx bx-chevron-left iconX close-2'></i>
            </div>
        </div>
    </a>
    -->


    <div class="menu-bar">
        <div class="menu">

            <ul class="menu-links" style="position: relative;">
                <li class="<?php if (isset($menuPainel)) {
                    echo 'active';
                }; ?>">
                    <a class="tip-bottom" title="" href="<?= site_url('mapos') ?>"><i class='bx bx-home-alt iconX'></i>
                        <span class="title nav-title">Home</span>
                        <span class="title-tooltip">Início</span>
                    </a>
                </li>



                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) { ?>
                    <li class="<?php if (isset($menuClientes)) {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('clientes') ?>"><i class='bx bx-user iconX'></i>
                            <span class="title">Cliente / Fornecedor</span>
                            <span class="title-tooltip">Clientes</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) { ?>
                    <li class="<?php if (isset($menuParceiros)) {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('parceiros') ?>"><i class='bx bx-group iconX'></i>
                            <span class="title">Parceiros</span>
                            <span class="title-tooltip">Parceiros</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) { ?>
                    <li class="<?php if (isset($menuProdutos)) {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('produtos') ?>"><i class='bx bx-basket iconX'></i>
                            <span class="title">Produtos</span>
                            <span class="title-tooltip">Produtos</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vServico')) { ?>
                    <li class="<?php if (isset($menuServicos)) {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('servicos') ?>"><i class='bx bx-wrench iconX'></i>
                            <span class="title">Serviços</span>
                            <span class="title-tooltip">Serviços</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) { ?>
                    <li class="<?php if (isset($menuEquipamentos)) {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('equipamentos') ?>"><i class='bx bx-devices iconX'></i>
                            <span class="title">Equipamentos</span>
                            <span class="title-tooltip">Equipamentos</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) { ?>
                    <li class="<?php if (isset($menuMarcas)) {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('marcas') ?>"><i class='bx bx-purchase-tag iconX'></i>
                            <span class="title">Marcas</span>
                            <span class="title-tooltip">Marcas</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) { ?>
                    <li class="<?php if (isset($menuChecklist)) {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('checklist') ?>"><i class='bx bx-list-check iconX'></i>
                            <span class="title">Checklist</span>
                            <span class="title-tooltip">Checklist</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) { ?>
                    <li class="<?php if (isset($menuPatrimonios)) {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('patrimonios') ?>"><i class='bx bx-building iconX'></i>
                            <span class="title">Patrimônio</span>
                            <span class="title-tooltip">Patrimônio</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) { ?>
                    <li class="<?php if (isset($menuCompras)) {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('compras') ?>"><i class='bx bx-shopping-bag iconX'></i>
                            <span class="title">Compras</span>
                            <span class="title-tooltip">Compras</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) { ?>
                    <li class="<?php if (isset($menuVendas)) {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('vendas') ?>"><i class='bx bx-cart-alt iconX'></i></span>
                            <span class="title">Vendas</span>
                            <span class="title-tooltip">Vendas</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) { ?>
                    <li class="<?php if (isset($menuPdv)) {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('pdv') ?>"><i class='bx bx-store-alt iconX'></i></span>
                            <span class="title">PDV</span>
                            <span class="title-tooltip">PDV</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) { ?>
                    <li class="<?php if (isset($menuOs)) {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('os') ?>"><i class='bx bx-file iconX'></i>
                            <span class="title">Ordens de Serviço</span>
                            <span class="title-tooltip">Ordens</span>
                        </a>
                    </li>

                    <?php 
                    $isAdmin = $this->permission->checkPermission($this->session->userdata('permissao'), 'cUsuario');
                    ?>
                    <li class="<?php if (isset($menuRotas)) { echo 'active'; }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('os/rotas') ?>"><i class='bx bx-map-alt iconX'></i>
                            <span class="title"><?= $isAdmin ? 'Visualizar Rotas' : 'Minhas Rotas'; ?></span>
                            <span class="title-tooltip">Rotas</span>
                        </a>
                    </li>
                     <li class="<?php if (isset($menuOsRapida)) { echo 'active'; }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('os/nova_os_rapida') ?>"><i class='bx bx-timer iconX'></i>
                            <span class="title"><?= $isAdmin ? 'OS Rápidas Emitidas' : 'Emitir OS Rápida'; ?></span>
                            <span class="title-tooltip">OS Rápida</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vGarantia')) { ?>
                    <li class="<?php if (isset($menuGarantia)) {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('garantias') ?>"><i class='bx bx-receipt iconX'></i>
                            <span class="title">Termos de Garantias</span>
                            <span class="title-tooltip">Garantias</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vArquivo')) { ?>
                    <li class="<?php if (isset($menuArquivos)) {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('arquivos') ?>"><i class='bx bx-box iconX'></i>
                            <span class="title">Arquivos</span>
                            <span class="title-tooltip">Arquivos</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vLancamento')) { ?>
                    <li class="<?php if (isset($menuLancamentos) && !$this->input->get('tipo')) {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('financeiro/lancamentos') ?>"><i class="bx bx-bar-chart-alt-2 iconX"></i>
                            <span class="title">Lançamentos</span>
                            <span class="title-tooltip">Lançamentos</span>
                        </a>
                    </li>
                    <li class="<?php if (isset($menuLancamentos) && $this->input->get('tipo') == 'receita') {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('financeiro/lancamentos?periodo=todos&situacao=todos&tipo=receita') ?>"><i class='bx bx-trending-up iconX'></i>
                            <span class="title">Contas a Receber</span>
                            <span class="title-tooltip">Receber</span>
                        </a>
                    </li>
                    <li class="<?php if (isset($menuLancamentos) && $this->input->get('tipo') == 'despesa') {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('financeiro/lancamentos?periodo=todos&situacao=todos&tipo=despesa') ?>"><i class='bx bx-trending-down iconX'></i>
                            <span class="title">Contas a Pagar</span>
                            <span class="title-tooltip">Pagar</span>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) { ?>
                    <li class="<?php if (isset($menuComunicacao)) {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('comunicacao') ?>"><i class='bx bx-message-rounded-dots iconX'></i>
                            <span class="title">Comunicação</span>
                            <span class="title-tooltip">Comunicação</span>
                        </a>
                    </li>
                <?php } ?>
                
                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCobranca')) { ?>
                    <li class="<?php if (isset($menuCobrancas)) {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('cobrancas/cobrancas') ?>"><i class='bx bx-dollar-circle iconX'></i>
                            <span class="title">Cobranças</span>
                            <span class="title-tooltip">Cobranças</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) { ?>
                    <li class="<?php if (isset($menuSite)) {
                        echo 'active';
                    }; ?>">
                        <a class="tip-bottom" title="" href="<?= site_url('site/configuracoes') ?>"><i class='bx bx-world iconX'></i>
                            <span class="title">Site</span>
                            <span class="title-tooltip">Site</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="botton-content">
            <li class="">
                <a class="tip-bottom" title="" href="<?= site_url('login/sair'); ?>">
                    <i class='bx bx-log-out-circle iconX'></i>
                    <span class="title">Sair</span>
                    <span class="title-tooltip">Sair</span>
                </a>
            </li>
        </div>
    </div>

<style>
/* Scroll customization */
.menu-bar::-webkit-scrollbar {
    width: 6px;
}

.menu-bar::-webkit-scrollbar-track {
    background: transparent;
}

.menu-bar::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.2);
    border-radius: 10px;
}

.menu-bar::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,0.3);
}
</style>

</nav>
<!--End sidebar-menu-->
