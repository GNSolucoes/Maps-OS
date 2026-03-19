<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" />

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <h5>Cadastro de OS</h5>
            </div>
            <div class="widget-content nopadding tab-content">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">

                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes da OS</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="span12" id="divCadastrarOs">
                                <?php if ($custom_error == true) { ?>
                                    <div class="span12 alert alert-danger" id="divInfo" style="padding: 1%;">Dados incompletos, verifique os campos com asterisco ou se selecionou corretamente cliente, responsável e garantia.<br />Ou se tem um cliente e um termo de garantia cadastrado.</div>
                                <?php
                                } ?>
                                <form action="<?php echo current_url(); ?>" method="post" id="formOs">
                                    <div class="span12" style="padding: 1%">
                                        <div class="span4">
                                            <label for="cliente">Cliente<span class="required">*</span></label>
                                            <input id="cliente" class="span12" type="text" name="cliente" value="" />
                                            <input id="clientes_id" class="span12" type="hidden" name="clientes_id" value="" />
                                        </div>
                                        <div class="span4">
                                            <label for="usuarios_id">Técnico / Responsável<span class="required">*</span></label>
                                            <select class="span12" name="usuarios_id" id="usuarios_id">
                                                <option value="">Selecione o Técnico</option>
                                                <?php foreach($usuarios as $u) { 
                                                    $selected = ($u->idUsuarios == $this->session->userdata('id_admin')) ? 'selected' : '';
                                                    echo "<option value='{$u->idUsuarios}' {$selected}>{$u->nome}</option>";
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="span4">
                                            <label for="tipo">Tipo<span class="required">*</span></label>
                                            <select class="span12" name="tipo" id="tipo">
                                                <option value="Externo">Externo</option>
                                                <option value="Interno">Interno</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span3">
                                            <label for="status">Status<span class="required">*</span></label>
                                            <select class="span12" name="status" id="status" value="">
                                                <option value="Aberto">Aberto</option>
                                                <option value="Orçamento">Orçamento</option>
                                                <option value="Negociação">Negociação</option>
                                                <option value="Aprovado">Aprovado</option>
                                                <option value="Aguardando Peças">Aguardando Peças</option>
                                                <option value="Em Andamento">Em Andamento</option>
                                                <option value="Finalizado">Finalizado</option>
                                                <option value="Faturado">Faturado</option>
                                                <option value="Cancelado">Cancelado</option>
                                            </select>
                                        </div>
                                        <div class="span3">
                                            <label for="dataInicial">Data Inicial<span class="required">*</span></label>
                                            <input id="dataInicial" autocomplete="off" class="span12 datepicker" type="text" name="dataInicial" value="<?php echo date('d/m/Y'); ?>" />
                                        </div>
                                        <div class="span3">
                                            <label for="dataFinal">Data Final<span class="required">*</span></label>
                                            <input id="dataFinal" autocomplete="off" class="span12 datepicker" type="text" name="dataFinal" value="" />
                                        </div>
                                        <div class="span3">
                                            <label for="garantia">Garantia (dias)</label>
                                            <input id="garantia" type="number" placeholder="Status s/g inserir nº/0" min="0" max="9999" class="span12" name="garantia" value="" />
                                            <?php echo form_error('garantia'); ?>
                                            <label for="termoGarantia">Termo Garantia</label>
                                            <input id="termoGarantia" class="span12" type="text" name="termoGarantia" value="" />
                                            <input id="garantias_id" class="span12" type="hidden" name="garantias_id" value="" />
                                        </div>
                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span12">
                                            <label for="equipamento">Equipamento (Preencher via busca para adicionar à descrição)</label>
                                            <div class="input-prepend span12" style="display: flex;">
                                                <span class="add-on"><i class="bx bx-devices"></i></span>
                                                <input id="equipamento" class="span12" type="text" name="equipamento" placeholder="Digite o nome ou modelo do equipamento do cliente..." />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6" style="padding: 1%; margin-left: 0">
                                        <label for="descricaoProduto">
                                            <h4>Descrição Produto/Serviço</h4>
                                        </label>
                                        <textarea class="span12 editor" name="descricaoProduto" id="descricaoProduto" cols="30" rows="5"></textarea>
                                    </div>
                                    <div class="span6" style="padding: 1%; margin-left: 0">
                                        <label for="defeito">
                                            <h4>Defeito</h4>
                                        </label>
                                        <textarea class="span12 editor" name="defeito" id="defeito" cols="30" rows="5"></textarea>
                                    </div>
                                    <div class="span6" style="padding: 1%; margin-left: 0">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <label for="observacoes"><h4>Observações</h4></label>
                                            <a href="#modalChecklist" role="button" data-toggle="modal" class="btn btn-info btn-mini" style="margin-bottom: 5px;">
                                                <i class="bx bx-list-check"></i> Inserir Checklist
                                            </a>
                                        </div>
                                        <textarea class="span12 editor" name="observacoes" id="observacoes" cols="30" rows="5"></textarea>
                                    </div>
                                    <div class="span6" style="padding: 1%; margin-left: 0">
                                        <label for="laudoTecnico">
                                            <h4>Laudo Técnico</h4>
                                        </label>
                                        <textarea class="span12 editor" name="laudoTecnico" id="laudoTecnico" cols="30" rows="5"></textarea>
                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span6 offset3" style="display:flex">
                                            <button class="button btn btn-success" id="btnContinuar">
                                              <span class="button__icon"><i class='bx bx-chevrons-right'></i></span><span class="button__text2">Continuar</span></button>
                                            <a href="<?php echo base_url() ?>index.php/os" class="button btn btn-mini btn-warning" style="max-width: 160px">
                                              <span class="button__icon"><i class="bx bx-undo"></i></span><span class="button__text2">Voltar</span></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                .
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteCliente",
            minLength: 1,
            select: function(event, ui) {
                $("#clientes_id").val(ui.item.id);
            }
        });
        $("#termoGarantia").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteTermoGarantia",
            minLength: 1,
            select: function(event, ui) {
                $("#garantias_id").val(ui.item.id);
            }
        });

        $("#formOs").validate({
            rules: {
                cliente: {
                    required: true
                },
                usuarios_id: {
                    required: true
                },
                dataInicial: {
                    required: true
                },
                dataFinal: {
                    required: true
                }

            },
            messages: {
                cliente: {
                    required: 'Campo Requerido.'
                },
                usuarios_id: {
                    required: 'Campo Requerido.'
                },
                dataInicial: {
                    required: 'Campo Requerido.'
                },
                dataFinal: {
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
        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy'
        });
        $("#equipamento").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/os/autoCompleteEquipamento",
                    dataType: "json",
                    data: {
                        term: request.term,
                        cliente_id: $("#clientes_id").val()
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 1,
            select: function(event, ui) {
                var desc = $("#descricaoProduto").val();
                var equipInfo = "<b>Equipamento:</b> " + ui.item.equipamento;
                if(ui.item.modelo) equipInfo += " | <b>Modelo:</b> " + ui.item.modelo;
                if(ui.item.num_serie) equipInfo += " | <b>S/N:</b> " + ui.item.num_serie;
                
                if(desc !== "") {
                    $("#descricaoProduto").val(desc + "<br>" + equipInfo);
                } else {
                     $("#descricaoProduto").val(equipInfo);
                }
                $('#descricaoProduto').trumbowyg('html', $("#descricaoProduto").val());
                $(this).val('');
                return false;
            }
        });

        $("#btn-add-checklist").click(function(){
            var templateName = $("#select-template-os option:selected").text();
            var checklist = "<b>CHECKLIST (" + templateName + "):</b><br>";
            $(".chk-item").each(function(){
                checklist += $(this).is(":checked") ? "[x] " : "[ ] ";
                checklist += $(this).val() + "<br>";
            });
            
            var obs = $("#observacoes").val();
            $("#observacoes").val(obs + (obs !== "" ? "<br><br>" : "") + checklist);
            $('#observacoes').trumbowyg('html', $("#observacoes").val());
            
            $("#modalChecklist").modal('hide');
            $(".chk-item").prop('checked', false);
        });

        $("#select-template-os").change(function(){
            var template_id = $(this).val();
            if(!template_id) {
                $("#checklist-items-container").html('<p>Selecione um template para carregar os itens.</p>');
                return;
            }

            $("#checklist-items-container").html('<div class="progress progress-info progress-striped active"><div class="bar" style="width: 100%"></div></div>');

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/os/getChecklistItems",
                type: "GET",
                data: { template_id: template_id },
                dataType: "json",
                success: function(data){
                    var html = '';
                    if(data.length > 0) {
                        $.each(data, function(i, item){
                            html += '<label class="checkbox"><input type="checkbox" class="chk-item" value="'+item.item+'"> '+item.item+'</label>';
                        });
                    } else {
                        html = '<p>Nenhum item encontrado para este template.</p>';
                    }
                    $("#checklist-items-container").html(html);
                }
            });
        });
    });
</script>

<!-- Modal Checklist -->
<div id="modalChecklist" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Inserir Checklist</h3>
  </div>
  <div class="modal-body">
    <div class="span12" style="margin-left: 0">
        <label for="template">Template de Checklist</label>
        <select class="span12" id="select-template-os">
            <option value="">Selecione um Template</option>
            <?php foreach($templates as $t): ?>
                <option value="<?php echo $t->id; ?>"><?php echo $t->nome; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="span12" id="checklist-items-container" style="margin-left: 0; margin-top: 10px;">
        <p>Selecione um template para carregar os itens.</p>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-primary" id="btn-add-checklist">Adicionar às Observações</button>
  </div>
</div>
