<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-bullhorn"></i>
                </span>
                <h5>Comunicação Direta (WhatsApp e E-mail)</h5>
            </div>
            <div class="widget-content">
                <form action="<?php echo site_url('comunicacao/enviarMensagem'); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                    
                    <div class="control-group">
                        <label for="tipo_envio" class="control-label">Canal de Envio<span class="required">*</span></label>
                        <div class="controls">
                            <select name="tipo_envio" id="tipo_envio" class="span4" required>
                                <option value="whatsapp">Apenas WhatsApp</option>
                                <option value="email">Apenas E-mail</option>
                                <option value="ambos">Ambos (WhatsApp + E-mail)</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="destinatario_tipo" class="control-label">Destinatário<span class="required">*</span></label>
                        <div class="controls">
                            <select name="destinatario_tipo" id="destinatario_tipo" class="span4" required>
                                <option value="cliente">Cliente Cadastrado no Sistema</option>
                                <option value="avulso">Contato Avulso (Não Cadastrado)</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group" id="div_cliente_cadastrado">
                        <label for="id_cliente" class="control-label">Selecione o Cliente</label>
                        <div class="controls">
                            <select id="id_cliente" name="id_cliente" class="span6">
                                <option value="">Escolha...</option>
                                <?php foreach ($clientes as $c) { ?>
                                    <option value="<?= $c->idClientes ?>"><?= $c->nomeCliente ?> (<?= $c->celular ?>) - <?= $c->email ?></option>
                                <?php } ?>
                            </select>
                            <span class="help-inline">O WhatsApp e Email anexados a este cadastro serão carregados automaticamente.</span>
                        </div>
                    </div>

                    <div id="div_cliente_avulso" style="display:none;">
                        <div class="control-group">
                            <label for="telefone_avulso" class="control-label">WhatsApp (Com DDD)</label>
                            <div class="controls">
                                <input id="telefone_avulso" type="text" name="telefone_avulso" class="span4" placeholder="Ex: 11999999999" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="email_avulso" class="control-label">E-mail</label>
                            <div class="controls">
                                <input id="email_avulso" type="email" name="email_avulso" class="span4" placeholder="Ex: cliente@email.com" />
                            </div>
                        </div>
                    </div>

                    <div class="control-group" id="div_assunto" style="display:none;">
                        <label for="assunto" class="control-label">Assunto do E-mail</label>
                        <div class="controls">
                            <input id="assunto" type="text" name="assunto" class="span8" placeholder="Digite o Assunto (Apenas para envios via E-mail)" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="mensagem" class="control-label">Mensagem<span class="required">*</span></label>
                        <div class="controls">
                            <textarea id="mensagem" name="mensagem" class="span8" rows="6" required placeholder="Digite o conteúdo da mensagem aqui... Dica: Se enviar para um cliente cadastrado, você pode escrever {cliente_nome} para falar o nome dele!"></textarea>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="anexo" class="control-label">Enviar Anexo / Imagem</label>
                        <div class="controls">
                            <input type="file" name="anexo" id="anexo" class="span8" accept="image/*,application/pdf" />
                            <span class="help-inline">Opcional. Você pode anexar uma imagem (JPG/PNG) ou PDF para enviar junto com a mensagem. (Max: 5MB)</span>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3" style="display:flex;justify-content: center">
                                <button type="submit" class="button btn btn-success" style="max-width:200px">
                                  <span class="button__icon"><i class='bx bx-send'></i></span><span class="button__text2">Disparar Mensagem</span>
                                </button>
                                <a href="<?php echo base_url() ?>" id="" class="button btn btn-warning" style="max-width:160px">
                                  <span class="button__icon"><i class="bx bx-undo"></i></span> <span class="button__text2">Voltar</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#id_cliente').select2({
            placeholder: "Pesquise por Nome ou Celular do cliente...",
            allowClear: true
        });

        // Alternar inputs baseando-se no tipo de destinatário
        $('#destinatario_tipo').change(function(){
            if($(this).val() == 'cliente') {
                $('#div_cliente_cadastrado').slideDown();
                $('#div_cliente_avulso').slideUp();
                $('#id_cliente').attr('required', true);
            } else {
                $('#div_cliente_cadastrado').slideUp();
                $('#div_cliente_avulso').slideDown();
                $('#id_cliente').removeAttr('required');
            }
        });

        // Mostrar/Esconder Assunto do Email dependendo do tipo
        $('#tipo_envio').change(function(){
            if($(this).val() == 'email' || $(this).val() == 'ambos') {
                $('#div_assunto').slideDown();
            } else {
                $('#div_assunto').slideUp();
            }
        });

        // Executar uma vez no loading
        $('#tipo_envio').trigger('change');
        $('#destinatario_tipo').trigger('change');
    });
</script>
