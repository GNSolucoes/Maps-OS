<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-comment"></i>
                </span>
                <h5>Adicionar Depoimento</h5>
            </div>
            <form action="<?php echo current_url(); ?>" method="post" class="form-horizontal">
                <div class="widget-content nopadding tab-content">
                    <div class="control-group">
                        <label class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
                            <input type="text" name="nome" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Cargo</label>
                        <div class="controls">
                            <input type="text" name="cargo">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Avaliação (1-5)</label>
                        <div class="controls">
                            <select name="avaliacao">
                                <option value="5">5 Estrelas</option>
                                <option value="4">4 Estrelas</option>
                                <option value="3">3 Estrelas</option>
                                <option value="2">2 Estrelas</option>
                                <option value="1">1 Estrela</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Depoimento<span class="required">*</span></label>
                        <div class="controls">
                            <textarea name="depoimento" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Ativo</label>
                        <div class="controls">
                            <input type="checkbox" name="ativo" value="1" checked>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="span12">
                        <div class="span6 offset3" style="display:flex;justify-content: center">
                            <button type="submit" class="button btn btn-success">
                                <span class="button__icon"><i class='bx bx-save'></i></span>
                                <span class="button__text2">Salvar</span>
                            </button>
                            <a href="<?php echo base_url('index.php/site/depoimentos'); ?>" class="button btn btn-warning">
                                <span class="button__icon"><i class="bx bx-undo"></i></span>
                                <span class="button__text2">Cancelar</span>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
