<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="fas fa-list"></i></span>
                <h5>Ordens de Serviço Rápidas Emitidas (Painel Admin)</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Técnico</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$results) {
                            echo '<tr><td colspan="8">Nenhuma OS Rápida encontrada.</td></tr>';
                        }
                        foreach ($results as $r) {
                            $data = date('d/m/Y', strtotime($r->dataInicial));
                            echo '<tr>';
                            echo '<td>' . $r->idOs . '</td>';
                            echo '<td>' . $data . '</td>';
                            echo '<td>' . $r->nomeCliente . '</td>';
                            echo '<td>' . $r->nomeTecnico . '</td>';
                            echo '<td>' . $r->descricaoProduto . '</td>';
                            echo '<td>R$ ' . number_format($r->valorTotal, 2, ',', '.') . '</td>';
                            echo '<td><span class="badge badge-success">' . $r->status . '</span></td>';
                            echo '<td>';
                            echo '<a href="' . base_url() . 'index.php/os/visualizar/' . $r->idOs . '" class="btn btn-mini btn-info" title="Visualizar"><i class="fas fa-eye"></i></a>';
                            echo '</td>';
                            echo '</tr>';
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
