<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon"><i class="fas fa-building"></i></span>
                <h5>Cadastro de Patrimônio</h5>
            </div>
            <?php if ($custom_error != '') {
                echo '<div class="alert alert-danger">' . $custom_error . '</div>';
            } ?>
            <form action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="widget-content nopadding tab-content">
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label">Código<span class="required">*</span></label>
                            <div class="controls">
                                <input type="text" name="codigo" value="<?php echo set_value('codigo'); ?>" required />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Nome<span class="required">*</span></label>
                            <div class="controls">
                                <input type="text" name="nome" value="<?php echo set_value('nome'); ?>" required />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Categoria</label>
                            <div class="controls">
                                <select name="categoria" class="span12">
                                    <option value="">Selecione...</option>
                                    <option value="Informática" <?php echo set_select('categoria', 'Informática'); ?>>Informática</option>
                                    <option value="Móveis" <?php echo set_select('categoria', 'Móveis'); ?>>Móveis</option>
                                    <option value="Ferramentas" <?php echo set_select('categoria', 'Ferramentas'); ?>>Ferramentas</option>
                                    <option value="Veículos" <?php echo set_select('categoria', 'Veículos'); ?>>Veículos</option>
                                    <option value="Outros" <?php echo set_select('categoria', 'Outros'); ?>>Outros</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Marca</label>
                            <div class="controls">
                                <select name="marca_id" class="span12">
                                    <option value="">Selecione...</option>
                                    <?php foreach ($marcas as $marca) {
                                        echo '<option value="' . $marca->idMarcas . '" ' . set_select('marca_id', $marca->idMarcas) . '>' . $marca->marca . '</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Modelo</label>
                            <div class="controls">
                                <input type="text" name="modelo" value="<?php echo set_value('modelo'); ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Nº Série</label>
                            <div class="controls">
                                <input type="text" name="num_serie" value="<?php echo set_value('num_serie'); ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Foto</label>
                            <div class="controls">
                                <input type="file" name="foto" accept="image/*" />
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label">Data Aquisição</label>
                            <div class="controls">
                                <input type="date" name="data_aquisicao" value="<?php echo set_value('data_aquisicao'); ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Valor Aquisição</label>
                            <div class="controls">
                                <input type="number" step="0.01" name="valor_aquisicao" value="<?php echo set_value('valor_aquisicao'); ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Fornecedor</label>
                            <div class="controls">
                                <select name="fornecedor_id" class="span12">
                                    <option value="">Selecione...</option>
                                    <?php foreach ($fornecedores as $fornecedor) {
                                        echo '<option value="' . $fornecedor->idClientes . '" ' . set_select('fornecedor_id', $fornecedor->idClientes) . '>' . $fornecedor->nomeCliente . '</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Localização</label>
                            <div class="controls">
                                <input type="text" name="localizacao" value="<?php echo set_value('localizacao'); ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Estado</label>
                            <div class="controls">
                                <select name="estado" class="span12">
                                    <option value="novo" <?php echo set_select('estado', 'novo'); ?>>Novo</option>
                                    <option value="bom" <?php echo set_select('estado', 'bom', true); ?>>Bom</option>
                                    <option value="regular" <?php echo set_select('estado', 'regular'); ?>>Regular</option>
                                    <option value="ruim" <?php echo set_select('estado', 'ruim'); ?>>Ruim</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Status</label>
                            <div class="controls">
                                <select name="status" class="span12">
                                    <option value="ativo" <?php echo set_select('status', 'ativo', true); ?>>Ativo</option>
                                    <option value="manutencao" <?php echo set_select('status', 'manutencao'); ?>>Em Manutenção</option>
                                    <option value="inativo" <?php echo set_select('status', 'inativo'); ?>>Inativo</option>
                                    <option value="baixado" <?php echo set_select('status', 'baixado'); ?>>Baixado</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Observações</label>
                            <div class="controls">
                                <textarea name="observacoes" rows="3"><?php echo set_value('observacoes'); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="control-group">
                            <label class="control-label">Descrição</label>
                            <div class="controls">
                                <textarea name="descricao" rows="2" class="span12"><?php echo set_value('descricao'); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="span12">
                        <div class="span6 offset3" style="display:flex;justify-content: center">
                            <button type="submit" class="button btn btn-mini btn-success" style="max-width: 160px">
                                <span class="button__icon"><i class='bx bx-save'></i></span>
                                <span class="button__text2">Salvar</span>
                            </button>
                            <a href="<?php echo base_url() ?>index.php/patrimonios" class="button btn btn-mini btn-warning" style="max-width: 160px">
                                <span class="button__icon"><i class="bx bx-undo"></i></span>
                                <span class="button__text2">Voltar</span>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
