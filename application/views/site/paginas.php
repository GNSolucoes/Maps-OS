<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon"><i class="fas fa-file-alt"></i></span>
                <h5>Páginas do Site</h5>
                <div class="buttons">
                    <a class="button btn btn-mini btn-success" href="<?php echo base_url(); ?>index.php/site/adicionarPagina">
                        <span class="button__icon"><i class='bx bx-plus-circle'></i></span>
                        <span class="button__text2">Nova Página</span>
                    </a>
                </div>
            </div>
            
            <div style="padding: 10px">
                <div class="row-fluid">
                    <div class="span2">
                        <a href="<?php echo base_url('index.php/site/configuracoes'); ?>" class="btn btn-info btn-block"><i class="fas fa-cog"></i> Configurações</a>
                    </div>
                    <div class="span2">
                        <a href="<?php echo base_url('index.php/site/paginas'); ?>" class="btn btn-primary btn-block"><i class="fas fa-file-alt"></i> Páginas</a>
                    </div>
                    <div class="span2">
                        <a href="<?php echo base_url('index.php/site/servicos'); ?>" class="btn btn-info btn-block"><i class="fas fa-wrench"></i> Serviços</a>
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

            <div class="widget-content nopadding">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Slug</th>
                            <th>Ordem</th>
                            <th>Status</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$paginas || count($paginas) == 0): ?>
                        <tr><td colspan="5">Nenhuma página cadastrada</td></tr>
                        <?php else: ?>
                        <?php foreach ($paginas as $p): ?>
                        <tr>
                            <td><?php echo $p->titulo; ?></td>
                            <td><code><?php echo $p->slug; ?></code></td>
                            <td><?php echo $p->ordem; ?></td>
                            <td><span class="badge <?php echo $p->ativo ? 'badge-success' : 'badge-warning'; ?>"><?php echo $p->ativo ? 'Ativo' : 'Inativo'; ?></span></td>
                            <td>
                                <a href="<?php echo base_url('index.php/site/editarPagina/' . $p->id); ?>" class="btn-nwe3" title="Editar"><i class="bx bx-edit bx-xs"></i></a>
                                <a href="#modal-excluir" role="button" data-toggle="modal" pagina="<?php echo $p->id; ?>" class="btn-nwe4" title="Excluir"><i class="bx bx-trash-alt bx-xs"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="modal-excluir" class="modal hide fade" tabindex="-1">
    <form action="<?php echo base_url() ?>index.php/site/excluirPagina" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h5>Excluir Página</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idPagina" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente excluir esta página?</h5>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button class="button btn btn-warning" data-dismiss="modal"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Excluir</span></button>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    $(document).on('click', 'a[data-toggle="modal"]', function() {
        var pagina = $(this).attr('pagina');
        $('#idPagina').val(pagina);
    });
});
</script>
