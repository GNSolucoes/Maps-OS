<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon"><i class="fas fa-clipboard-list"></i></span>
                <h5>Editar Template de Checklist</h5>
            </div>
            <?php if ($custom_error != '') {
                echo '<div class="alert alert-danger">' . $custom_error . '</div>';
            } ?>
            <form action="<?php echo current_url(); ?>" id="formTemplate" method="post" enctype="multipart/form-data" class="form-horizontal">
                <input type="hidden" name="id" value="<?php echo $result->id; ?>">
                <div class="widget-content nopadding tab-content">
                    <div class="span6">
                        <div class="control-group">
                            <label for="nome" class="control-label">Nome do Template<span class="required">*</span></label>
                            <div class="controls">
                                <input id="nome" type="text" name="nome" value="<?php echo $result->nome; ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="descricao" class="control-label">Descrição</label>
                            <div class="controls">
                                <textarea id="descricao" name="descricao" rows="3"><?php echo $result->descricao; ?></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="imagem_referencia" class="control-label">Imagem de Referência</label>
                            <div class="controls">
                                <?php if ($result->imagem_referencia): ?>
                                    <img src="<?php echo base_url('uploads/checklist/' . $result->imagem_referencia); ?>" style="max-width: 200px; margin-bottom: 10px; display: block;">
                                <?php endif; ?>
                                <input type="file" id="imagem_referencia" name="imagem_referencia" accept="image/*" />
                                <span class="help-block">Diagrama/desenho do equipamento mostrando as partes que serão verificadas</span>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="control-group">
                            <label for="ativo" class="control-label">Status</label>
                            <div class="controls">
                                <label class="btn btn-default" style="margin-bottom: 0">
                                    <input type="checkbox" id="ativo" name="ativo" value="1" <?php echo ($result->ativo == 1) ? 'checked' : ''; ?>> Ativo
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="span12">
                        <hr>
                        <h4>Itens do Checklist</h4>
                        <button type="button" class="btn btn-success btn-sm" id="addItem"><i class="bx bx-plus"></i> Adicionar Item</button>
                        <div id="itemsContainer" style="margin-top: 15px;"></div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="span12">
                        <div class="span6 offset3" style="display:flex;justify-content: center">
                            <button type="submit" class="button btn btn-mini btn-success" style="max-width: 160px">
                                <span class="button__icon"><i class='bx bx-save'></i></span>
                                <span class="button__text2">Salvar</span>
                            </button>
                            <a href="<?php echo base_url() ?>index.php/checklist" class="button btn btn-mini btn-warning" style="max-width: 160px">
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

<script>
$(document).ready(function() {
    let itemCount = 0;
    const existingItems = <?php echo json_encode($itens); ?>;

    function addChecklistItem(text = '', obrigatorio = false, permite_foto = true) {
        const html = `
            <div class="well well-sm" style="margin-bottom: 10px;" data-item="${itemCount}">
                <div class="row-fluid">
                    <div class="span8">
                        <input type="text" name="itens[]" class="span12" placeholder="Descrição do item" value="${text}" required>
                    </div>
                    <div class="span2">
                        <label class="checkbox inline">
                            <input type="checkbox" name="obrigatorio[${itemCount}]" value="1" ${obrigatorio ? 'checked' : ''}> Obrigatório
                        </label>
                    </div>
                    <div class="span2">
                        <button type="button" class="btn btn-danger btn-sm removeItem"><i class="bx bx-trash"></i></button>
                    </div>
                </div>
            </div>
        `;
        $('#itemsContainer').append(html);
        itemCount++;
    }

    $('#addItem').click(function() {
        addChecklistItem();
    });

    $(document).on('click', '.removeItem', function() {
        $(this).closest('.well').remove();
    });

    // Carregar itens existentes
    if (existingItems && existingItems.length > 0) {
        existingItems.forEach(item => {
            addChecklistItem(item.item, item.obrigatorio == 1, item.permite_foto == 1);
        });
    } else {
        addChecklistItem();
    }
});
</script>
