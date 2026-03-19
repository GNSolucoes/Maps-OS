<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon"><i class="fas fa-clipboard-check"></i></span>
                <h5>Preencher Checklist - <?php echo $checklist->template_nome; ?></h5>
            </div>
            <div class="widget-content nopadding tab-content">
                <div class="span12" style="padding: 20px;">
                    <p><strong>OS:</strong> #<?php echo $checklist->os_id; ?></p>
                    <p><strong>Data:</strong> <?php echo date('d/m/Y H:i', strtotime($checklist->data_preenchimento)); ?></p>
                    
                    <?php if (isset($template_imagem) && $template_imagem): ?>
                    <div style="margin: 20px 0; text-align: center; background: #f5f5f5; padding: 15px; border-radius: 5px;">
                        <h5 style="margin-bottom: 10px;">Diagrama de Referência do Equipamento</h5>
                        <img src="<?php echo base_url('uploads/checklist/' . $template_imagem); ?>" style="max-width: 100%; max-height: 400px; border: 2px solid #ddd; border-radius: 5px;">
                        <p style="margin-top: 10px; color: #666; font-size: 12px;">Use este diagrama como referência para verificar as partes do equipamento</p>
                    </div>
                    <?php endif; ?>
                    
                    <hr>
                    
                    <?php foreach ($respostas as $resposta): ?>
                    <div class="well" style="margin-bottom: 15px;">
                        <h5><?php echo $resposta->item; ?></h5>
                        <form class="form-resposta" data-id="<?php echo $resposta->id; ?>">
                            <div class="row-fluid">
                                <div class="span3">
                                    <label>Status:</label>
                                    <select name="status" class="span12">
                                        <option value="na" <?php echo ($resposta->status == 'na') ? 'selected' : ''; ?>>N/A</option>
                                        <option value="ok" <?php echo ($resposta->status == 'ok') ? 'selected' : ''; ?>>✓ OK</option>
                                        <option value="nao_ok" <?php echo ($resposta->status == 'nao_ok') ? 'selected' : ''; ?>>✗ Não OK</option>
                                    </select>
                                </div>
                                <div class="span5">
                                    <label>Observação:</label>
                                    <textarea name="observacao" class="span12" rows="2"><?php echo $resposta->observacao; ?></textarea>
                                </div>
                                <div class="span4">
                                    <?php if ($resposta->permite_foto): ?>
                                    <label>Foto:</label>
                                    <?php if ($resposta->foto): ?>
                                        <img src="<?php echo base_url('uploads/checklist/' . $resposta->foto); ?>" style="max-width: 100px; max-height: 100px; margin-bottom: 5px;">
                                    <?php endif; ?>
                                    <input type="file" name="foto" accept="image/*" class="span12">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;">
                                <i class="bx bx-save"></i> Salvar Item
                            </button>
                        </form>
                    </div>
                    <?php endforeach; ?>
                    
                    <div class="form-actions">
                        <a href="<?php echo base_url('index.php/os/editar/' . $checklist->os_id); ?>" class="button btn btn-warning">
                            <span class="button__icon"><i class="bx bx-undo"></i></span>
                            <span class="button__text2">Voltar para OS</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.form-resposta').submit(function(e) {
        e.preventDefault();
        
        const form = $(this);
        const respostaId = form.data('id');
        const formData = new FormData(this);
        formData.append('resposta_id', respostaId);
        
        $.ajax({
            url: '<?php echo base_url('index.php/checklist/salvarResposta'); ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                const data = JSON.parse(response);
                if (data.result) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Item salvo com sucesso!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Erro ao salvar item.'
                    });
                }
            }
        });
    });
});
</script>
