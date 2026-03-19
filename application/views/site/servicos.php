<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-wrench"></i>
                </span>
                <h5>Gerenciar Serviços do Site</h5>
                <div class="buttons">
                    <a href="<?php echo base_url('index.php/site/adicionarServico'); ?>" class="button btn btn-mini btn-success">
                        <span class="button__icon"><i class='bx bx-plus-circle'></i></span>
                        <span class="button__text">Adicionar Serviço</span>
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
                        <a href="<?php echo base_url('index.php/site/servicos'); ?>" class="btn btn-primary btn-block"><i class="fas fa-wrench"></i> Serviços</a>
                    </div>
                    <div class="span2">
                        <a href="<?php echo base_url('index.php/site/depoimentos'); ?>" class="btn btn-info btn-block"><i class="fas fa-comments"></i> Depoimentos</a>
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
                            <th>#</th>
                            <th>Título</th>
                            <th>Descrição</th>
                            <th>Ícone</th>
                            <th>Ativo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$servicos) { ?>
                            <tr>
                                <td colspan="6">Nenhum serviço cadastrado</td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach ($servicos as $r) { ?>
                                <tr>
                                    <td><?php echo $r->ordem; ?></td>
                                    <td><?php echo $r->titulo; ?></td>
                                    <td><?php echo character_limiter($r->descricao, 50); ?></td>
                                    <td><i class="<?php echo $r->icone; ?>"></i> (<?php echo $r->icone; ?>)</td>
                                    <td><?php echo $r->ativo ? 'Sim' : 'Não'; ?></td>
                                    <td>
                                        <a href="<?php echo base_url('index.php/site/editarServico/' . $r->id) ?>" class="btn-nwe3" title="Editar Serviço"><i class="bx bx-edit bx-xs"></i></a>
                                        <a href="#modal-excluir" role="button" data-toggle="modal" servico_id="<?php echo $r->id; ?>" class="btn-nwe4" title="Excluir Serviço"><i class="bx bx-trash-alt bx-xs"></i></a>
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
    <form action="<?php echo base_url() ?>index.php/site/excluirServico" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Serviço</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idExcluir" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente excluir este serviço?</h5>
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
            var servico_id = $(this).attr('servico_id');
            $('#idExcluir').val(servico_id);
        });
    });
</script>
