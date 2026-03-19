<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-tags"></i>
                </span>
                <h5>Cadastro de Marca</h5>
            </div>
            <?php if ($custom_error != '') {
                echo '<div class="alert alert-danger">' . $custom_error . '</div>';
            } ?>
            <form action="<?php echo current_url(); ?>" id="formMarca" method="post" class="form-horizontal">
                <div class="widget-content nopadding tab-content">
                    <div class="span6">
                        <div class="control-group">
                            <label for="marca" class="control-label">Nome da Marca<span class="required">*</span></label>
                            <div class="controls">
                                <input id="marca" type="text" name="marca" value="<?php echo set_value('marca'); ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="control-group">
                            <label for="situacao" class="control-label">Situação</label>
                            <div class="controls">
                                <label class="btn btn-default" style="margin-bottom: 0">
                                    <input type="checkbox" id="situacao" name="situacao" value="1" <?php echo set_checkbox('situacao', '1', true); ?>> Ativa
                                </label>
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
                            <a href="<?php echo base_url() ?>index.php/marcas" class="button btn btn-mini btn-warning" style="max-width: 160px">
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

<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#formMarca').validate({
            rules: {
                marca: {
                    required: true
                }
            },
            messages: {
                marca: {
                    required: 'Campo obrigatório'
                }
            },
            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });
    });
</script>
