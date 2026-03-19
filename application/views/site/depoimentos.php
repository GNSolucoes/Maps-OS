<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-comment"></i>
                </span>
                <h5>Gerenciar Depoimentos</h5>
                <div class="buttons">
                    <a href="<?php echo base_url('index.php/site/adicionarDepoimento'); ?>" class="button btn btn-mini btn-success">
                        <span class="button__icon"><i class='bx bx-plus-circle'></i></span>
                        <span class="button__text">Adicionar Depoimento</span>
                    </a>
                </div>
            </div>
            
            <div style="padding: 10px">
                <div class="row-fluid">
                    <div class="span2">
                        <a href="<?php echo base_url('index.php/site/configuracoes'); ?>" class="btn btn-info btn-block"><i class="fas fa-cog"></i> Configurações</a>
                    </div>
                    <div class="span2">
                        <a href="<?php echo base_url('index.php/site/paginas'); ?>" class="btn btn-info btn-block"><i class="fas fa-file-alt"></i> Páginas</a>
                    </div>
                    <div class="span2">
                        <a href="<?php echo base_url('index.php/site/servicos'); ?>" class="btn btn-info btn-block"><i class="fas fa-wrench"></i> Serviços</a>
                    </div>
                    <div class="span2">
                        <a href="<?php echo base_url('index.php/site/depoimentos'); ?>" class="btn btn-primary btn-block"><i class="fas fa-comments"></i> Depoimentos</a>
                    </div>
                    <div class="span2">
                        <a href="<?php echo base_url('index.php/site/contatos'); ?>" class="btn btn-warning btn-block"><i class="fas fa-envelope"></i> Mensagens</a>
                    </div>
                    <div class="span2">
                        <a href="<?php echo base_url('index.php/site/orcamentos'); ?>" class="btn btn-success btn-block"><i class="fas fa-file-invoice-dollar"></i> Orçamentos</a>
                    </div>
                </div>
            </div>

            <div class="widget-content nopadding tab-content">
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Cargo</th>
                            <th>Avaliação</th>
                            <th>Depoimento</th>
                            <th>Ativo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$depoimentos) { ?>
                            <tr>
                                <td colspan="6">Nenhum depoimento cadastrado</td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach ($depoimentos as $r) { ?>
                                <tr>
                                    <td><?php echo $r->nome; ?></td>
                                    <td><?php echo $r->cargo; ?></td>
                                    <td><?php echo $r->avaliacao; ?>/5</td>
                                    <td><?php echo mb_strimwidth(strip_tags($r->depoimento), 0, 50, "..."); ?></td>
                                    <td><?php echo $r->ativo ? 'Sim' : 'Não'; ?></td>
                                    <td>
                                        <a href="<?php echo base_url('index.php/site/editarDepoimento/' . $r->id) ?>" class="btn-nwe3" title="Editar Depoimento"><i class="bx bx-edit bx-xs"></i></a>
                                        <a href="#modal-excluir" role="button" data-toggle="modal" depoimento_id="<?php echo $r->id; ?>" class="btn-nwe4" title="Excluir Depoimento"><i class="bx bx-trash-alt bx-xs"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Excluir -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/site/excluirDepoimento" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Depoimento</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idExcluir" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente excluir este depoimento?</h5>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger">Excluir</button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', 'a', function(event) {
            var depoimento_id = $(this).attr('depoimento_id');
            $('#idExcluir').val(depoimento_id);
        });
    });
</script>
