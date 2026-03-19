<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon"><i class="fas fa-shopping-cart"></i></span>
                <h5>Nova Compra</h5>
            </div>
            <form action="<?php echo base_url(); ?>index.php/compras/salvar" method="post" class="form-horizontal">
                <div class="widget-content nopadding tab-content">
                <div class="widget-content nopadding tab-content">
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Número da Compra<span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" name="numero_compra" value="<?php echo $numero_compra; ?>" readonly />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Fornecedor<span class="required">*</span></label>
                                <div class="controls">
                                    <select name="fornecedor_id" class="span12" required>
                                        <option value="">Selecione...</option>
                                        <?php foreach ($fornecedores as $f) {
                                            echo '<option value="' . $f->idClientes . '">' . $f->nomeCliente . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Data da Compra<span class="required">*</span></label>
                                <div class="controls">
                                    <input type="date" name="data_compra" value="<?php echo date('Y-m-d'); ?>" required />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Data de Entrega</label>
                                <div class="controls">
                                    <input type="date" name="data_entrega" />
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Status</label>
                                <div class="controls">
                                    <select name="status" class="span12">
                                        <option value="orcamento">Orçamento</option>
                                        <option value="aprovado">Aprovado</option>
                                        <option value="pedido" selected>Pedido</option>
                                        <option value="recebido">Recebido</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Situação Pagamento</label>
                                <div class="controls">
                                    <select name="situacao_pagamento" class="span12">
                                        <option value="pendente">A Pagar (Pendente)</option>
                                        <option value="pago">Pago</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Forma Pagamento</label>
                                <div class="controls">
                                    <select name="forma_pagamento" class="span12">
                                        <option value="Dinheiro">Dinheiro</option>
                                        <option value="Pix">Pix</option>
                                        <option value="Boleto">Boleto</option>
                                        <option value="Cartão Crédito">Cartão Crédito</option>
                                        <option value="Cartão Débito">Cartão Débito</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Desconto</label>
                                <div class="controls">
                                    <input type="number" step="0.01" name="desconto" value="0" id="desconto" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Frete</label>
                                <div class="controls">
                                    <input type="number" step="0.01" name="frete" value="0" id="frete" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Observações</label>
                                <div class="controls">
                                    <textarea name="observacoes" rows="3" class="span12"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row-fluid">
                        <div class="span12">
                        <hr>
                        <h4>Itens da Compra</h4>
                        <button type="button" class="btn btn-success btn-sm" id="addProduto"><i class="bx bx-plus"></i> Adicionar Produto</button>
                        <div id="produtosContainer" style="margin-top: 15px;"></div>
                        <div style="margin-top: 20px; text-align: right;">
                            <h4>Total: R$ <span id="valorTotal">0,00</span></h4>
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
                            <a href="<?php echo base_url() ?>index.php/compras" class="button btn btn-mini btn-warning" style="max-width: 160px">
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
    let produtoCount = 0;

    function addProdutoItem() {
        const html = `
            <div class="well well-sm" style="margin-bottom: 10px;" data-produto="${produtoCount}">
                <div class="row-fluid">
                    <div class="span5">
                        <input type="text" class="span12 produto-autocomplete" placeholder="Digite para buscar produto" data-index="${produtoCount}">
                        <input type="hidden" name="produtos[]" class="produto-id">
                    </div>
                    <div class="span2">
                        <input type="number" name="quantidades[]" class="span12 quantidade" placeholder="Qtd" min="1" value="1" required>
                    </div>
                    <div class="span3">
                        <input type="number" step="0.01" name="precos[]" class="span12 preco" placeholder="Preço Unit." min="0" required>
                    </div>
                    <div class="span1">
                        <button type="button" class="btn btn-danger btn-sm removeProduto"><i class="bx bx-trash"></i></button>
                    </div>
                </div>
            </div>
        `;
        $('#produtosContainer').append(html);
        
        // Autocomplete para o novo produto
        $(`.produto-autocomplete[data-index="${produtoCount}"]`).autocomplete({
            source: '<?php echo base_url(); ?>index.php/compras/autoCompleteProduto',
            minLength: 2,
            select: function(event, ui) {
                $(this).val(ui.item.label);
                $(this).siblings('.produto-id').val(ui.item.id);
                $(this).closest('.well').find('.preco').val(ui.item.preco || 0);
                calcularTotal();
                return false;
            }
        });
        
        produtoCount++;
    }

    function calcularTotal() {
        let total = 0;
        $('.well').each(function() {
            const qtd = parseFloat($(this).find('.quantidade').val()) || 0;
            const preco = parseFloat($(this).find('.preco').val()) || 0;
            total += qtd * preco;
        });
        
        const desconto = parseFloat($('#desconto').val()) || 0;
        const frete = parseFloat($('#frete').val()) || 0;
        total = total - desconto + frete;
        
        $('#valorTotal').text(total.toFixed(2).replace('.', ','));
    }

    $('#addProduto').click(function() {
        addProdutoItem();
    });

    $(document).on('click', '.removeProduto', function() {
        $(this).closest('.well').remove();
        calcularTotal();
    });

    $(document).on('input', '.quantidade, .preco', calcularTotal);
    $('#desconto, #frete').on('input', calcularTotal);

    // Adicionar primeiro produto
    addProdutoItem();
});
</script>
