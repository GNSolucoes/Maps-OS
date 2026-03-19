<div class="row-fluid" style="margin-top: 0">
    <div class="span4">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="fas fa-handshake"></i>
                </span>
                <h5>Relatório de Comissões - Parceiros</h5>
            </div>
            <div class="widget-content">
                <form target="_blank" action="<?php echo base_url() ?>index.php/relatorios/parceirosRapid" method="get">
                    <div class="row-fluid">
                        <label>Data Inicial:</label>
                        <input type="date" name="dataInicial" class="span12" required />
                    </div>
                    <div class="row-fluid">
                        <label>Data Final:</label>
                        <input type="date" name="dataFinal" class="span12" required />
                    </div>
                    <div class="row-fluid">
                        <label>Parceiro (Opcional):</label>
                        <select name="parceiro_id" class="span12">
                            <option value="">Todos</option>
                            <?php foreach ($parceiros as $p) {
                                echo '<option value="' . $p->idParceiros . '">' . $p->nome . '</option>';
                            } ?>
                        </select>
                    </div>
                    
                    <div class="row-fluid" style="margin-top: 15px">
                         <label class="checkbox">
                             <input type="checkbox" name="gerar_lancamento" value="1"> Gerar Lançamento de Despesa (Contas a Pagar)?
                         </label>
                         <span class="help-block" style="font-size: 0.8em; color: red">Atenção: Isso criará um lançamento de despesa no financeiro com o valor total das comissões do período/parceiro selecionado. Recomenda-se selecionar UM parceiro específico.</span>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-inverse span12"><i class="fas fa-print"></i> Gerar Relatório</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
