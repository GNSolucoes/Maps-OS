<div class="row-fluid" style="margin-top: 0">
    <div class="span4">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="fas fa-clipboard-list"></i>
                </span>
                <h5>Relatórios Rápidos</h5>
            </div>
            <div class="widget-content">
                <ul class="site-stats">
                    <li><a href="<?php echo base_url() ?>index.php/relatorios/checklistsRapid" target="_blank"><i class="fas fa-clipboard-list"></i> <small>Todos os Checklists</small></a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="span8">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="fas fa-clipboard-list"></i>
                </span>
                <h5>Relatório Customizado</h5>
            </div>
            <div class="widget-content">
                <form target="_blank" action="<?php echo base_url() ?>index.php/relatorios/checklistsCustom" method="get" class="form-horizontal">
                    <div class="control-group">
                        <label for="dataInicial" class="control-label">Data Inicial:</label>
                        <div class="controls">
                            <input type="date" name="dataInicial" class="span12" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="dataFinal" class="control-label">Data Final:</label>
                        <div class="controls">
                            <input type="date" name="dataFinal" class="span12" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="responsavel" class="control-label">Responsável:</label>
                        <div class="controls">
                            <select name="responsavel" id="responsavel" class="span12">
                                <option value="">Todos</option>
                                <?php foreach ($usuarios as $u) {
                                    echo '<option value="' . $u->idUsuarios . '">' . $u->nome . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="template" class="control-label">Template:</label>
                        <div class="controls">
                            <select name="template" id="template" class="span12">
                                <option value="">Todos</option>
                                <?php foreach ($templates as $t) {
                                    echo '<option value="' . $t->id . '">' . $t->nome . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3" style="display:flex;justify-content: center">
                                <button type="submit" class="button btn btn-mini btn-inverse"><span class="button__icon"><i class="bx bx-printer"></i></span> <span class="button__text2">Imprimir</span></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
