<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="fas fa-handshake"></i>
                </span>
                <h5>Editar Parceiro</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formParceiro" method="post" class="form-horizontal">
                    <?php echo form_hidden('idParceiros', $result->idParceiros) ?>
                    <div class="control-group">
                        <label for="nome" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nome" type="text" name="nome" value="<?php echo $result->nome; ?>" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="cpf_cnpj" class="control-label">CPF/CNPJ<span class="required">*</span></label>
                        <div class="controls">
                            <input id="cpf_cnpj" type="text" name="cpf_cnpj" value="<?php echo $result->cpf_cnpj; ?>" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="telefone" class="control-label">Telefone</label>
                        <div class="controls">
                            <input id="telefone" type="text" name="telefone" value="<?php echo $result->telefone; ?>" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="email" class="control-label">Email</label>
                        <div class="controls">
                            <input id="email" type="text" name="email" value="<?php echo $result->email; ?>" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="comissao" class="control-label">Comissão Padrão (%)</label>
                        <div class="controls">
                            <input id="comissao" type="text" name="comissao" value="<?php echo $result->comissao; ?>" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="situacao" class="control-label">Situação</label>
                        <div class="controls">
                            <select name="situacao" id="situacao">
                                <option value="1" <?php echo ($result->situacao == 1) ? 'selected' : ''; ?>>Ativo</option>
                                <option value="0" <?php echo ($result->situacao == 0) ? 'selected' : ''; ?>>Inativo</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-sync-alt"></i> Atualizar</button>
                                <a href="<?php echo base_url() ?>index.php/parceiros" class="btn"><i class="fas fa-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#formParceiro').validate({
            rules: {
                nome: {
                    required: true
                },
                cpf_cnpj: {
                    required: true
                }
            },
            messages: {
                nome: {
                    required: 'Campo Requerido.'
                },
                cpf_cnpj: {
                    required: 'Campo Requerido.'
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
