<?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) { ?>
    <a href="<?php echo base_url(); ?>index.php/parceiros/adicionar" class="btn btn-success"><i class="fas fa-plus"></i> Adicionar Parceiro</a>
<?php } ?>

<div class="widget-box">
    <div class="widget-title">
        <span class="icon">
            <i class="fas fa-handshake"></i>
        </span>
        <h5>Parceiros</h5>
    </div>
    <div class="widget-content nopadding">
        <table class="table table-bordered ">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>CPF/CNPJ</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Comissão (%)</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $r) {
                    echo '<tr>';
                    echo '<td>' . $r->idParceiros . '</td>';
                    echo '<td>' . $r->nome . '</td>';
                    echo '<td>' . $r->cpf_cnpj . '</td>';
                    echo '<td>' . $r->telefone . '</td>';
                    echo '<td>' . $r->email . '</td>';
                    echo '<td>' . number_format($r->comissao, 2, ',', '.') . '</td>';
                    echo '<td>' . ($r->situacao == 1 ? 'Ativo' : 'Inativo') . '</td>';
                    echo '<td>';
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
                        echo '<a href="' . base_url() . 'index.php/parceiros/editar/' . $r->idParceiros . '" class="btn btn-info tip-top" title="Editar Parceiro"><i class="fas fa-edit"></i></a>';
                    }
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')) {
                        echo '<a href="#modal-excluir" role="button" data-toggle="modal" parceiro="' . $r->idParceiros . '" class="btn btn-danger tip-top" title="Excluir Parceiro"><i class="fas fa-trash-alt"></i></a>';
                    }
                    echo '</td>';
                    echo '</tr>';
                } ?>
                <tr>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php echo $this->pagination->create_links(); ?>

<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/parceiros/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Parceiro</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idParceiro" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente excluir este parceiro?</h5>
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
            var parceiro = $(this).attr('parceiro');
            $('#idParceiro').val(parceiro);
        });
    });
</script>
