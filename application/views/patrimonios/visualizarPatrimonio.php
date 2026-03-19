<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon"><i class="fas fa-building"></i></span>
                <h5>Visualizar Patrimônio</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span6" style="padding: 20px;">
                    <h4><?php echo $result->nome; ?></h4>
                    <p><strong>Código:</strong> <?php echo $result->codigo; ?></p>
                    <p><strong>Categoria:</strong> <?php echo $result->categoria; ?></p>
                    <?php if ($result->marca): ?>
                    <p><strong>Marca:</strong> <?php echo $result->marca; ?></p>
                    <?php endif; ?>
                    <?php if ($result->modelo): ?>
                    <p><strong>Modelo:</strong> <?php echo $result->modelo; ?></p>
                    <?php endif; ?>
                    <?php if ($result->num_serie): ?>
                    <p><strong>Nº Série:</strong> <?php echo $result->num_serie; ?></p>
                    <?php endif; ?>
                    <p><strong>Localização:</strong> <?php echo $result->localizacao; ?></p>
                    <p><strong>Estado:</strong> <span class="badge"><?php echo ucfirst($result->estado); ?></span></p>
                    <p><strong>Status:</strong> <span class="badge <?php echo $result->status == 'ativo' ? 'badge-success' : 'badge-warning'; ?>"><?php echo ucfirst($result->status); ?></span></p>
                    
                    <?php if ($result->data_aquisicao): ?>
                    <p><strong>Data Aquisição:</strong> <?php echo date('d/m/Y', strtotime($result->data_aquisicao)); ?></p>
                    <?php endif; ?>
                    <?php if ($result->valor_aquisicao): ?>
                    <p><strong>Valor Aquisição:</strong> R$ <?php echo number_format($result->valor_aquisicao, 2, ',', '.'); ?></p>
                    <?php endif; ?>
                    
                    <?php if ($result->descricao): ?>
                    <p><strong>Descrição:</strong><br><?php echo nl2br($result->descricao); ?></p>
                    <?php endif; ?>
                </div>
                <div class="span6" style="padding: 20px;">
                    <?php if ($result->foto): ?>
                    <img src="<?php echo base_url('uploads/patrimonios/' . $result->foto); ?>" style="max-width: 100%; border-radius: 5px;">
                    <?php else: ?>
                    <div style="text-align: center; padding: 50px; background: #f5f5f5; border-radius: 5px;">
                        <i class="bx bx-image" style="font-size: 48px; color: #ccc;"></i>
                        <p>Sem foto</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Histórico de Manutenções -->
        <div class="widget-box" style="margin-top: 20px;">
            <div class="widget-title">
                <span class="icon"><i class="fas fa-tools"></i></span>
                <h5>Histórico de Manutenções</h5>
                <div class="buttons">
                    <button class="button btn btn-mini btn-success" data-toggle="modal" data-target="#modalManutencao">
                        <span class="button__icon"><i class='bx bx-plus-circle'></i></span>
                        <span class="button__text2">Nova Manutenção</span>
                    </button>
                </div>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Tipo</th>
                            <th>Descrição</th>
                            <th>Custo</th>
                            <th>Responsável</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$manutencoes || count($manutencoes) == 0): ?>
                        <tr><td colspan="5">Nenhuma manutenção registrada</td></tr>
                        <?php else: ?>
                        <?php foreach ($manutencoes as $m): ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($m->data_manutencao)); ?></td>
                            <td><span class="badge <?php echo $m->tipo == 'preventiva' ? 'badge-info' : 'badge-warning'; ?>"><?php echo ucfirst($m->tipo); ?></span></td>
                            <td><?php echo $m->descricao; ?></td>
                            <td><?php echo $m->custo ? 'R$ ' . number_format($m->custo, 2, ',', '.') : '-'; ?></td>
                            <td><?php echo $m->responsavel_nome ?: '-'; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="form-actions">
            <a href="<?php echo base_url() ?>index.php/patrimonios" class="button btn btn-warning">
                <span class="button__icon"><i class="bx bx-undo"></i></span>
                <span class="button__text2">Voltar</span>
            </a>
        </div>
    </div>
</div>

<!-- Modal Nova Manutenção -->
<div id="modalManutencao" class="modal hide fade" tabindex="-1">
    <form action="<?php echo base_url() ?>index.php/patrimonios/adicionarManutencao" method="post">
        <input type="hidden" name="patrimonio_id" value="<?php echo $result->id; ?>">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h5>Nova Manutenção</h5>
        </div>
        <div class="modal-body">
            <div class="control-group">
                <label>Data da Manutenção<span class="required">*</span></label>
                <input type="date" name="data_manutencao" required>
            </div>
            <div class="control-group">
                <label>Tipo<span class="required">*</span></label>
                <select name="tipo" required>
                    <option value="preventiva">Preventiva</option>
                    <option value="corretiva">Corretiva</option>
                </select>
            </div>
            <div class="control-group">
                <label>Descrição<span class="required">*</span></label>
                <textarea name="descricao" rows="3" required></textarea>
            </div>
            <div class="control-group">
                <label>Custo</label>
                <input type="number" step="0.01" name="custo" placeholder="0.00">
            </div>
        </div>
        <div class="modal-footer">
            <button class="button btn btn-warning" data-dismiss="modal">
                <span class="button__icon"><i class="bx bx-x"></i></span>
                <span class="button__text2">Cancelar</span>
            </button>
            <button type="submit" class="button btn btn-success">
                <span class="button__icon"><i class='bx bx-save'></i></span>
                <span class="button__text2">Salvar</span>
            </button>
        </div>
    </form>
</div>
