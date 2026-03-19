<div class="row-fluid">
    <div id="footer" class="span12">
        <a class="pecolor" href="https://github.com/RamonSilva20/mapos" target="_blank">
            <?= date('Y') ?> &copy; Ramon Silva - Map-OS - Versão: <?= $this->config->item('app_version') ?>
        </a>
        | <a href="#modalSobre" data-toggle="modal" class="pecolor" style="cursor: pointer;">Sobre o Projeto</a>
    </div>

    <!-- Modal Sobre -->
    <div id="modalSobre" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Sobre o Projeto Map-OS</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <div class="span12" style="text-align: center;">
                    <img src="<?php echo base_url('assets/img/logo-mapos.png'); ?>" alt="Logo" style="max-height: 80px; margin-bottom: 20px;">
                    <h4>Sistema de Controle e Gestão de Ordens de Serviço</h4>
                </div>
            </div>
            <hr>
            <div class="row-fluid">
                <div class="span6">
                    <h5><i class="fas fa-code"></i> Criador Original</h5>
                    <p><strong>Desenvolvedor:</strong> Ramon Silva</p>
                    <p><a href="https://github.com/RamonSilva20/mapos" target="_blank" class="btn btn-mini btn-inverse"><i class="fab fa-github"></i> GitHub Oficial</a></p>
                    <p>O Map-OS é um sistema open source desenvolvido para facilitar a gestão de ordens de serviço.</p>
                </div>
                <div class="span6">
                    <h5><i class="fas fa-edit"></i> Customização / Versão GNSOLUCOES</h5>
                    <p><strong>Responsável:</strong> GNSOLUCOES</p>
                    <p><strong>Contato:</strong></p>
                    <p>
                        <a href="https://wa.me/5548996046486" target="_blank" class="btn btn-mini btn-success"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                        <a href="https://t.me/+_Zht4nhws0UzNTMx" target="_blank" class="btn btn-mini btn-info"><i class="fab fa-telegram"></i> Telegram</a>
                        <a href="https://www.gnsolucoesinfo.com" target="_blank" class="btn btn-mini btn-info"><i class="fas fa-globe"></i> Site</a>
                    </p>
                    <p>Esta versão contém modificações exclusivas e melhorias visuais desenvolvidas pela GNSOLUCOES.</p>
                </div>
            </div>
            <hr>
            <div class="row-fluid">
                <div class="span12">
                     <p><i>"A tecnologia move o mundo."</i></p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
        </div>
    </div>
</div>
<!--end-Footer-part-->
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/matrix.js"></script>
<?php if(isset($configuration['tawk_to_embed'])){ echo $configuration['tawk_to_embed']; } ?>
</body>
<script type="text/javascript">
    $(document).ready(function() {
        var dataTableEnabled = '<?= $configuration['control_datatable'] ?>';
        if(dataTableEnabled == '1') {
            $('#tabela').dataTable( {
                "ordering": false,
                "info": false,
                "language": {
                    "url": "<?= base_url() ?>assets/js/dataTable_pt-br.json",
                },
                "oLanguage": {
                    "sSearch": "Pesquisa rápida na tabela abaixo:"
                }
            } );
        }
    } );
</script>
</html>
