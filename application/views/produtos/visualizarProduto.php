<div class="accordion" id="collapse-group">
    <div class="accordion-group widget-box">
        <div class="accordion-heading">
            <div class="widget-title" style="margin: -20px 0 0">
                <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                    <span class="icon"><i class="fas fa-shopping-bag"></i></span>
                    <h5>Dados do Produto</h5>
                </a>
            </div>
        </div>
        <div class="collapse in accordion-body">
            <div class="widget-content">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td style="text-align: center; width: 30%"><strong>Código de Barra</strong></td>
                            <td>
                                <?php echo $result->codDeBarra ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right; width: 30%"><strong>Descrição</strong></td>
                            <td>
                                <?php echo $result->descricao ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Unidade</strong></td>
                            <td>
                                <?php echo $result->unidade ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Preço de Compra</strong></td>
                            <td>R$
                                <?php echo $result->precoCompra; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Preço de Venda</strong></td>
                            <td>R$
                                <?php echo $result->precoVenda; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Estoque</strong></td>
                            <td>
                                <?php echo $result->estoque; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Estoque Mínimo</strong></td>
                            <td>
                                <?php echo $result->estoqueMinimo; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="accordion-group widget-box">
        <div class="accordion-heading">
            <div class="widget-title">
                <a data-parent="#collapse-group" href="#collapseGTwo" data-toggle="collapse">
                    <span class="icon"><i class="fas fa-history"></i></span>
                    <h5>Histórico de Compras</h5>
                </a>
            </div>
        </div>
        <div class="collapse in accordion-body" id="collapseGTwo">
            <div class="widget-content">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Fornecedor</th>
                            <th>Quantidade</th>
                            <th>Preço Unit.</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($historicoCompras) && !empty($historicoCompras)){
                            foreach($historicoCompras as $compra){
                                $dataCompra = date('d/m/Y', strtotime($compra->data_compra));
                                $total = $compra->quantidade * $compra->preco; // Assuming 'preco' is unit price
                                echo '<tr>';
                                echo '<td>'.$dataCompra.'</td>';
                                echo '<td>'.$compra->fornecedor.'</td>';
                                echo '<td>'.$compra->quantidade.'</td>';
                                echo '<td>R$ '.number_format($compra->preco, 2, ',', '.').'</td>';
                                echo '<td>R$ '.number_format($total, 2, ',', '.').'</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="5">Nenhuma compra encontrada para este produto.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="accordion-group widget-box">
        <div class="accordion-heading">
            <div class="widget-title">
                <a data-parent="#collapse-group" href="#collapseGThree" data-toggle="collapse">
                    <span class="icon"><i class="fas fa-shopping-cart"></i></span>
                    <h5>Histórico de Vendas</h5>
                </a>
            </div>
        </div>
        <div class="collapse in accordion-body" id="collapseGThree">
            <div class="widget-content">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Quantidade</th>
                            <th>Preço Unit.</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($historicoVendas) && !empty($historicoVendas)){
                            foreach($historicoVendas as $venda){
                                $dataVenda = date('d/m/Y', strtotime($venda->dataVenda));
                                $total = $venda->quantidade * $venda->preco;
                                echo '<tr>';
                                echo '<td>'.$dataVenda.'</td>';
                                echo '<td>'.$venda->cliente.'</td>';
                                echo '<td>'.$venda->quantidade.'</td>';
                                echo '<td>R$ '.number_format($venda->preco, 2, ',', '.').'</td>';
                                echo '<td>R$ '.number_format($total, 2, ',', '.').'</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="5">Nenhuma venda encontrada para este produto.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="accordion-group widget-box">
        <div class="accordion-heading">
            <div class="widget-title">
                <a data-parent="#collapse-group" href="#collapseGFour" data-toggle="collapse">
                    <span class="icon"><i class="fas fa-clipboard"></i></span>
                    <h5>Histórico de O.S.</h5>
                </a>
            </div>
        </div>
        <div class="collapse in accordion-body" id="collapseGFour">
            <div class="widget-content">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Quantidade</th>
                            <th>Preço Unit.</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($historicoOs) && !empty($historicoOs)){
                            foreach($historicoOs as $os){
                                $dataOs = date('d/m/Y', strtotime($os->dataInicial));
                                $total = $os->quantidade * $os->preco;
                                echo '<tr>';
                                echo '<td>'.$dataOs.'</td>';
                                echo '<td>'.$os->cliente.'</td>';
                                echo '<td>'.$os->quantidade.'</td>';
                                echo '<td>R$ '.number_format($os->preco, 2, ',', '.').'</td>';
                                echo '<td>R$ '.number_format($total, 2, ',', '.').'</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="5">Nenhuma O.S. encontrada para este produto.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
