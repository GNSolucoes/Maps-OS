<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon"><i class="fas fa-shopping-cart"></i></span>
                <h5>Compras</h5>
                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) { ?>
                <div class="buttons">
                    <a class="button btn btn-mini btn-success" href="<?php echo base_url(); ?>index.php/compras/adicionar" style="max-width: 160px">
                        <span class="button__icon"><i class='bx bx-plus-circle'></i></span>
                        <span class="button__text2">Nova Compra</span>
                    </a>
                </div>
                <?php } ?>
            </div>
            <div class="widget-content nopadding tab-content">
                <table id="tabela" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="10%">Número</th>
                            <th>Fornecedor</th>
                            <th width="12%">Data</th>
                            <th width="12%">Valor Total</th>
                            <th width="10%">Fatura</th>
                            <th width="10%">Status</th>
                            <th width="12%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!$results) {
                            echo '<tr><td colspan="7">Nenhuma Compra Cadastrada</td></tr>';
                        }
                        foreach ($results as $r) {
                            $status_class = $r->status == 'recebido' ? 'badge-success' : ($r->status == 'pedido' ? 'badge-info' : 'badge-warning');
                            $fatura_status = '<span class="badge">N/A</span>';
                            if(isset($r->financeiro_status)) {
                                $fatura_status = $r->financeiro_status == 'pago' ? '<span class="badge badge-success tip-top" title="Pago"><i class="bx bx-check"></i></span>' : '<span class="badge badge-important tip-top" title="Pendente"><i class="bx bx-time"></i></span>';
                            }
                            
                            echo '<tr>';
                            echo '<td>' . $r->numero_compra . '</td>';
                            echo '<td>' . $r->fornecedor . '</td>';
                            echo '<td>' . date('d/m/Y', strtotime($r->data_compra)) . '</td>';
                            echo '<td>R$ ' . number_format($r->valor_total, 2, ',', '.') . '</td>';
                            echo '<td>' . $fatura_status . '</td>';
                            echo '<td><span class="badge ' . $status_class . '">' . ucfirst($r->status) . '</span></td>';
                            echo '<td>';
                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
                                echo '<a href="' . base_url() . 'index.php/compras/editar/' . $r->id . '" style="margin-right: 1%" class="btn-nwe3" title="Editar"><i class="bx bx-edit bx-xs"></i></a>';
                            }
                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')) {
                                echo '<a href="#modal-excluir" role="button" data-toggle="modal" compra="' . $r->id . '" class="btn-nwe4" title="Excluir"><i class="bx bx-trash-alt bx-xs"></i></a>';
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
    <form action="<?php echo base_url() ?>index.php/compras/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h5>Excluir Compra</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idCompra" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente excluir esta compra?</h5>
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
        var compra = $(this).attr('compra');
        $('#idCompra').val(compra);
    });
});
</script>
