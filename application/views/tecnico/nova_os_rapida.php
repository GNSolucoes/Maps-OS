<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
             <div class="widget-title">
                <span class="icon"><i class="fas fa-plus"></i></span>
                <h5>Emissão de OS Rápida (Painel Técnico)</h5>
             </div>
             <div class="widget-content nopadding">
                 <form action="<?php echo site_url('os/adicionar_os_rapida'); ?>" method="post" class="form-horizontal" id="formOs">
                     
                     <div class="row-fluid">
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Cliente</label>
                                <div class="controls">
                                    <input type="hidden" name="clientes_id" id="clientes_id" value="">
                                    <input type="text" name="cliente" id="cliente" class="span12" placeholder="Digite o nome do cliente" required>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Técnico Responsável</label>
                                <div class="controls">
                                    <select name="usuarios_id" class="span12">
                                        <?php foreach($usuarios as $u) { 
                                            $selected = ($u->idUsuarios == $this->session->userdata('id_admin')) ? 'selected' : '';
                                            echo "<option value='{$u->idUsuarios}' {$selected}>{$u->nome}</option>";
                                        } ?>
                                    </select>
                                </div>
                            </div>
                             <div class="control-group">
                                 <label class="control-label">Status</label>
                                 <div class="controls">
                                     <select name="status" class="span12">
                                         <option value="Orçamento">Orçamento</option>
                                         <option value="Aberto">Aberto</option>
                                         <option value="Em Andamento">Em Andamento</option>
                                         <option value="Finalizado">Finalizado</option>
                                     </select>
                                 </div>
                             </div>
                        </div>
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Defeito/Observação</label>
                                <div class="controls">
                                    <textarea name="defeito" class="span12" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Laudo Técnico</label>
                                <div class="controls">
                                    <textarea name="laudo" class="span12" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                     </div>
                     
                     <hr>
                     
                     <div class="row-fluid">
                        <div class="span6">
                            <h5>Serviços</h5>
                            <div class="input-append span12">
                                <input type="text" class="span9" id="busca_servico" placeholder="Buscar serviço cadastrado...">
                                <button class="btn btn-primary" type="button" id="btn-add-servico"><i class="fas fa-plus"></i></button>
                            </div>
                            <div style="margin-top: 5px;">
                                <label><input type="checkbox" id="check_servico_avulso"> Adicionar Serviço Avulso (Não cadastrado)</label>
                                <div id="div_servico_avulso" style="display:none; margin-top:5px;">
                                    <input type="text" id="nome_servico_avulso" class="span8" placeholder="Descrição do serviço">
                                    <input type="text" id="preco_servico_avulso" class="span3 money" placeholder="Preço">
                                    <button class="btn btn-success" type="button" id="btn-add-servico-avulso"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <table class="table table-bordered" id="tabela_servicos" style="margin-top:10px;">
                                <thead>
                                    <tr>
                                        <th>Serviço</th>
                                        <th width="80">Preço</th>
                                        <th width="30">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="sem_servicos"><td colspan="3">Nenhum serviço adicionado.</td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="span6">
                            <h5>Produtos</h5>
                            <div class="input-append span12">
                                <input type="text" class="span9" id="busca_produto" placeholder="Buscar produto...">
                                <button class="btn btn-primary" type="button" id="btn-add-produto"><i class="fas fa-plus"></i></button>
                            </div>
                            <table class="table table-bordered" id="tabela_produtos" style="margin-top:45px;">
                                <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th width="50">Qtd</th>
                                        <th width="80">Preço</th>
                                        <th width="30">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="sem_produtos"><td colspan="4">Nenhum produto adicionado.</td></tr>
                                </tbody>
                            </table>
                        </div>
                     </div>
                     
                     <div class="row-fluid" style="margin-top: 20px; text-align: right;">
                         <h3>Total Geral: R$ <span id="valorTotal">0,00</span></h3>
                     </div>

                     <div class="form-actions" style="background:none; border-top: 1px solid #ddd; text-align: center">
                         <button type="submit" class="btn btn-success btn-large"><i class="fas fa-check"></i> Salvar OS Rápida</button>
                     </div>
                     
                     <!-- Hidden Inputs para envio -->
                     <div id="hidden_inputs"></div>
                 </form>
             </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $(".money").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});

    // Cliente Autocomplete
    $("#cliente").autocomplete({
        source: "<?php echo base_url(); ?>index.php/os/autoCompleteCliente",
        minLength: 1,
        select: function( event, ui ) {
             $("#clientes_id").val(ui.item.id);
        }
    });

    // --- Serviços ---
    $("#busca_servico").autocomplete({
        source: "<?php echo base_url(); ?>index.php/os/autoCompleteServico",
        minLength: 1,
        select: function( event, ui ) {
             addServico(ui.item.id, ui.item.label, ui.item.preco);
             $(this).val('');
             return false;
        }
    });

    $('#check_servico_avulso').change(function() {
        if($(this).is(':checked')) {
            $('#div_servico_avulso').slideDown();
        } else {
            $('#div_servico_avulso').slideUp();
        }
    });

    $('#btn-add-servico-avulso').click(function() {
        var nome = $('#nome_servico_avulso').val();
        var preco = $('#preco_servico_avulso').val();
        
        if(nome && preco) {
            addServico(null, nome, preco, true); // null ID for avulso
            $('#nome_servico_avulso').val('');
            $('#preco_servico_avulso').val('');
        }
    });

    function addServico(id, nome, preco, isAvulso = false) {
        if(!isAvulso) preco = parseFloat(preco).toFixed(2).replace('.', ',');

        var tr = `
            <tr>
                <td>${nome} <input type="hidden" name="servicos_id[]" value="${id || ''}"> <input type="hidden" name="servicos_nome[]" value="${nome}"></td>
                <td>R$ ${preco} <input type="hidden" class="preco_item" name="servicos_preco[]" value="${preco}"></td>
                <td><button type="button" class="btn btn-mini btn-danger remove_item"><i class="fas fa-trash"></i></button></td>
            </tr>
        `;
        $('#tabela_servicos tbody').append(tr);
        $('#sem_servicos').hide();
        calcTotal();
    }

    // --- Produtos ---
    $("#busca_produto").autocomplete({
        source: "<?php echo base_url(); ?>index.php/os/autoCompleteProduto",
        minLength: 1,
        select: function( event, ui ) {
             addProduto(ui.item.id, ui.item.label, ui.item.preco);
             $(this).val('');
             return false;
        }
    });

    function addProduto(id, nome, preco) {
        var tr = `
            <tr>
                <td>${nome} <input type="hidden" name="produtos_id[]" value="${id}"></td>
                <td><input type="number" min="1" value="1" class="span12 qtd_produto" name="produtos_qtd[]" style="margin:0"></td>
                <td>R$ ${preco} <input type="hidden" class="preco_unitario" value="${preco}"> <span class="preco_total_prod">R$ ${preco}</span></td>
                <td><button type="button" class="btn btn-mini btn-danger remove_item"><i class="fas fa-trash"></i></button></td>
            </tr>
        `;
        $('#tabela_produtos tbody').append(tr);
        $('#sem_produtos').hide();
        calcTotal();
    }

    // --- Geral ---
    $(document).on('click', '.remove_item', function(){
        $(this).closest('tr').remove();
        calcTotal();
    });

    $(document).on('change keyup', '.qtd_produto', function(){
        var qtd = $(this).val();
        var tr = $(this).closest('tr');
        var preco = parseFloat(tr.find('.preco_unitario').val().replace(',', '.'));
        var total = qtd * preco;
        tr.find('.preco_total_prod').text('R$ ' + total.toFixed(2).replace('.', ','));
        calcTotal();
    });

    function calcTotal() {
        var total = 0;
        
        // Serviços
        $('.preco_item').each(function(){
            var val = $(this).val().replace('R$ ', '').replace('.', '').replace(',', '.');
            total += parseFloat(val);
        });

        // Produtos
        $('.qtd_produto').each(function(){
            var tr = $(this).closest('tr');
            var qtd = parseFloat($(this).val());
            var preco = parseFloat(tr.find('.preco_unitario').val().replace(',', '.'));
            total += (qtd * preco);
        });

        $('#valorTotal').text(total.toFixed(2).replace('.', ','));
    }

    // Validação antes do submit
    $('#formOs').submit(function(){
        if($('#clientes_id').val() == '' && $('#cliente').val() == '') {
            alert('Selecione um cliente.');
            return false;
        }
        return true;
    });
});
</script>
