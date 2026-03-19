<div class="widget-box">
    <div class="widget-title" style="margin: 0;font-size: 1.1em">
        <span class="icon">
            <i class="fas fa-wrench"></i>
        </span>
        <h5>Visualizar Equipamento</h5>
    </div>
    <div class="widget-content">
        <table class="table table-bordered" style="border: 1px solid #ddd">
            <tbody>
                <tr>
                    <td style="text-align: right; width: 30%"><strong>Código</strong></td>
                    <td><?php echo $result->idEquipamentos; ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Cliente</strong></td>
                    <td><?php echo $result->nomeCliente; ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Equipamento</strong></td>
                    <td><?php echo $result->equipamento; ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Número de Série</strong></td>
                    <td><?php echo $result->num_serie ?: '-'; ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Modelo</strong></td>
                    <td><?php echo $result->modelo ?: '-'; ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Marca</strong></td>
                    <td><?php echo $result->marca ?: '-'; ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Cor</strong></td>
                    <td><?php echo $result->cor ?: '-'; ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Voltagem</strong></td>
                    <td><?php echo $result->voltagem ?: '-'; ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Tensão</strong></td>
                    <td><?php echo $result->tensao ?: '-'; ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Potência</strong></td>
                    <td><?php echo $result->potencia ?: '-'; ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Data de Fabricação</strong></td>
                    <td><?php echo $result->data_fabricacao ? date('d/m/Y', strtotime($result->data_fabricacao)) : '-'; ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Descrição</strong></td>
                    <td><?php echo $result->descricao ?: '-'; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="modal-footer" style="display:flex;justify-content: center">
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            echo '<a title="Editar" class="button btn btn-mini btn-info" style="min-width: 140px; top:10px" href="' . base_url() . 'index.php/equipamentos/editar/' . $result->idEquipamentos . '">
<span class="button__icon"><i class="bx bx-edit"></i></span> <span class="button__text2"> Editar</span></a>';
        } ?>
        <a title="Voltar" class="button btn btn-mini btn-warning" style="min-width: 140px; top:10px" href="<?php echo site_url() ?>/equipamentos">
          <span class="button__icon"><i class="bx bx-undo"></i></span><span class="button__text2">Voltar</span></a>
    </div>
</div>
