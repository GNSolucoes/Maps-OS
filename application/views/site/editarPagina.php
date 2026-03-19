<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon"><i class="fas fa-file-alt"></i></span>
                <h5>Editar Página</h5>
            </div>
            <form action="<?php echo current_url(); ?>" method="post" class="form-horizontal">
                <div class="widget-content nopadding tab-content">
                    <div class="control-group">
                        <label class="control-label">Título<span class="required">*</span></label>
                        <div class="controls">
                            <input type="text" name="titulo" value="<?php echo $pagina->titulo; ?>" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Conteúdo</label>
                        <div class="controls">
                            <textarea name="conteudo" rows="10"><?php echo $pagina->conteudo; ?></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Palavras-chave (SEO)</label>
                        <div class="controls">
                            <input type="text" name="meta_keywords" class="span8" value="<?php echo $pagina->meta_keywords ?? ''; ?>" placeholder="ex: assistencia, conserto, redes">
                            <span class="help-block">Separadas por vírgula.</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Descrição Breve (SEO)</label>
                        <div class="controls">
                            <input type="text" name="meta_description" class="span8" value="<?php echo $pagina->meta_description ?? ''; ?>" placeholder="Resumo do conteúdo desta página...">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">URL da Imagem de Capa</label>
                        <div class="controls">
                            <input type="text" name="imagem_capa" class="span8" value="<?php echo $pagina->imagem_capa ?? ''; ?>" placeholder="URL de uma imagem ilustrativa (Opcional)">
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
                            <a href="<?php echo base_url('index.php/site/paginas'); ?>" class="button btn btn-warning">
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

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('textarea[name="conteudo"]').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
        </div>
    </div>
</div>
