<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Comissões</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/blue.css" class="skin-color" />
</head>
<body style="background-color: #fff;">
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <h4 style="text-align: center">Relatório de Comissões de Parceiros</h4>
                        <h6 style="text-align: center">Período: <?php echo date('d/m/Y', strtotime($dataInicial)) . ' a ' . date('d/m/Y', strtotime($dataFinal)); ?></h6>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Parceiro</th>
                                    <th>Cliente</th>
                                    <th>Data Venda</th>
                                    <th>Total Venda</th>
                                    <th>Comissão (%)</th>
                                    <th>Valor Comissão</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalVendas = 0;
                                $totalComissao = 0;
                                foreach ($results as $r) {
                                    $vlrVenda = floatval($r->valorTotal);
                                    $percComissao = floatval($r->comissao);
                                    $vlrComissao = ($vlrVenda * $percComissao) / 100;
                                    
                                    $totalVendas += $vlrVenda;
                                    $totalComissao += $vlrComissao;
                                    
                                    echo '<tr>';
                                    echo '<td>' . $r->nomeParceiro . '</td>';
                                    echo '<td>' . $r->nomeCliente . '</td>';
                                    echo '<td>' . date('d/m/Y', strtotime($r->dataVenda)) . '</td>';
                                    echo '<td>R$ ' . number_format($vlrVenda, 2, ',', '.') . '</td>';
                                    echo '<td>' . number_format($percComissao, 2, ',', '.') . '%</td>';
                                    echo '<td>R$ ' . number_format($vlrComissao, 2, ',', '.') . '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="text-align: right"><strong>Total:</strong></td>
                                    <td><strong>R$ <?php echo number_format($totalVendas, 2, ',', '.'); ?></strong></td>
                                    <td></td>
                                    <td><strong>R$ <?php echo number_format($totalComissao, 2, ',', '.'); ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="text-align: right; padding-top: 10px">Powered by Map-OS</div>
</body>
</html>
