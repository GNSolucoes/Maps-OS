<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon"><i class="fas fa-building"></i></span>
                <h5>Patrimônios</h5>
                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) { ?>
                <div class="buttons">
                    <a class="button btn btn-mini btn-success" href="<?php echo base_url(); ?>index.php/patrimonios/adicionar" style="max-width: 180px">
                        <span class="button__icon"><i class='bx bx-plus-circle'></i></span>
                        <span class="button__text2">Adicionar Patrimônio</span>
                    </a>
                </div>
                <?php } ?>
            </div>
            <div class="widget-content nopadding tab-content">
                <table id="tabela" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="8%">Código</th>
                            <th>Nome</th>
                            <th width="12%">Categoria</th>
                            <th width="10%">Localização</th>
                            <th width="8%">Status</th>
                            <th width="12%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!$results) {
                            echo '<tr><td colspan="6">Nenhum Patrimônio Cadastrado</td></tr>';
                        }
                        foreach ($results as $r) {
                            $status_class = $r->status == 'ativo' ? 'badge-success' : ($r->status == 'manutencao' ? 'badge-warning' : 'badge-important');
                            echo '<tr>';
                            echo '<td>' . $r->codigo . '</td>';
                            echo '<td>' . $r->nome . '</td>';
                            echo '<td>' . ($r->categoria ?: '-') . '</td>';
                            echo '<td>' . ($r->localizacao ?: '-') . '</td>';
                            echo '<td><span class="badge ' . $status_class . '">' . ucfirst($r->status) . '</span></td>';
                            echo '<td>';
                            echo '<a href="' . base_url() . 'index.php/patrimonios/visualizar/' . $r->id . '" style="margin-right: 1%" class="btn-nwe1" title="Visualizar"><i class="bx bx-show bx-xs"></i></a>';
                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
                                echo '<a href="' . base_url() . 'index.php/patrimonios/editar/' . $r->id . '" style="margin-right: 1%" class="btn-nwe3" title="Editar"><i class="bx bx-edit bx-xs"></i></a>';
                            }
                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')) {
                                echo '<a href="#modal-excluir" role="button" data-toggle="modal" patrimonio="' . $r->id . '" class="btn-nwe4" title="Excluir"><i class="bx bx-trash-alt bx-xs"></i></a>';
                            }
                            echo '</td>';
                            echo '</tr>';
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>

<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog">
    <form action="<?php echo base_url() ?>index.php/patrimonios/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h5>Excluir Patrimônio</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idPatrimonio" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente excluir este patrimônio?</h5>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button class="button btn btn-warning" data-dismiss="modal"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Excluir</span></button>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    $(document).on('click', 'a', function(event) {
        var patrimonio = $(this).attr('patrimonio');
        $('#idPatrimonio').val(patrimonio);
    });
});
</script>
