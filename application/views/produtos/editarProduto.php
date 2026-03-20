<style>
    /* Hiding the checkbox, but allowing it to be focused */
    .badgebox {
        opacity: 0;
    }

    .badgebox+.badge {
        /* Move the check mark away when unchecked */
        text-indent: -999999px;
        /* Makes the badge's width stay the same checked and unchecked */
        width: 27px;
    }

    .badgebox:focus+.badge {
        /* Set something to make the badge looks focused */
        /* This really depends on the application, in my case it was: */

        /* Adding a light border */
        box-shadow: inset 0px 0px 5px;
        /* Taking the difference out of the padding */
    }

    .badgebox:checked+.badge {
        /* Move the check mark back when checked */
        text-indent: 0;
    }
</style>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-shopping-bag"></i>
                </span>
                <h5>Editar Produto</h5>
            </div>
            <div class="widget-content nopadding tab-content">
                <?php echo $custom_error; ?>
                <form action="<?php echo current_url(); ?>" id="formProduto" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <div class="control-group">
                        <label for="foto" class="control-label">Foto do Produto</label>
                        <div class="controls">
                            <input type="file" name="userfile" accept="image/*" />
                            <?php if ($result->foto): ?>
                                <div style="margin-top: 5px;">
                                    <img src="<?php echo base_url('assets/anexos/' . $result->foto); ?>" style="max-height: 80px;" alt="Foto do Produto">
                                </div>
                            <?php endif; ?>
                            <span class="help-block">Tamanho máx: 2MB | Formatos: JPG, PNG (Selecione para alterar)</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo form_hidden('idProdutos', $result->idProdutos) ?>
                        <label for="codDeBarra" class="control-label">Código de Barra<span class=""></span></label>
                        <div class="controls">
                            <input id="codDeBarra" type="text" name="codDeBarra" value="<?php echo $result->codDeBarra; ?>" />
                            <button type="button" class="btn btn-success btn-mini" style="margin-left: 10px;" onclick="gerarCodigoDeBarras()"><i class="fas fa-barcode"></i> Gerar Código</button>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label">Descrição<span class="required">*</span></label>
                        <div class="controls">
                            <input id="descricao" type="text" name="descricao" value="<?php echo $result->descricao; ?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="marca" class="control-label">Marca</label>
                        <div class="controls">
                            <select id="marca" name="marca">
                                <option value="">Selecione uma marca...</option>
                                <?php foreach ($marcas as $marca) {
                                    $selected = ($marca->marca == $result->marca) ? 'selected' : '';
                                    echo '<option value="' . $marca->marca . '" ' . $selected . '>' . $marca->marca . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="modelo" class="control-label">Modelo</label>
                        <div class="controls">
                            <input id="modelo" type="text" name="modelo" value="<?php echo $result->modelo ?? ''; ?>" placeholder="Ex: Galaxy S20, iPhone 13" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Tipo de Movimento</label>
                        <div class="controls">
                            <label for="entrada" class="btn btn-default" style="margin-top: 5px;">Entrada
                                <input type="checkbox" id="entrada" name="entrada" class="badgebox" value="1" <?= ($result->entrada == 1) ? 'checked' : '' ?>>
                                <span class="badge">&check;</span>
                            </label>
                            <label for="saida" class="btn btn-default" style="margin-top: 5px;">Saída
                                <input type="checkbox" id="saida" name="saida" class="badgebox" value="1" <?= ($result->saida == 1) ? 'checked' : '' ?>>
                                <span class="badge">&check;</span>
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="precoCompra" class="control-label">Preço de Compra<span class="required">*</span></label>
                        <div class="controls">
                            <input id="precoCompra" class="money" data-affixes-stay="true" data-thousands="" data-decimal="." type="text" name="precoCompra" value="<?php echo $result->precoCompra; ?>" />
                            Margem <input style="width: 3em;" id="margemLucro" name="margemLucro" type="text" placeholder="%" maxlength="3" size="2" />
                            <strong><span style="color: red" id="errorAlert"></span><strong>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="Lucro" class="control-label">Lucro</label>
                        <div class="controls">
                            <select id="selectLucro" name="selectLucro" style="width: 10.5em;">
                              <option value="markup">Markup</option>
                              <option value="margemLucro">Margem de Lucro</option>
                            </select>
                            <input style="width: 4em;" id="Lucro" name="Lucro" type="text" placeholder="%" maxlength="3" size="2" />
                            <i class="icon-info-sign tip-left" title="Markup: Porcentagem aplicada ao valor de compra | Margem de Lucro: Porcentagem aplicada ao valor de venda"></i>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="precoVenda" class="control-label">Preço de Venda<span class="required">*</span></label>
                        <div class="controls">
                            <input id="precoVenda" class="money" data-affixes-stay="true" data-thousands="" data-decimal="." type="text" name="precoVenda" value="<?php echo $result->precoVenda; ?>" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="unidade" class="control-label">Unidade<span class="required">*</span></label>
                        <div class="controls">
                            <select id="unidade" name="unidade" style="width: 15em;">
                                <?php 
                                $medidasJson = @file_get_contents(FCPATH . 'assets/json/tabela_medidas.json');
                                if ($medidasJson) {
                                    $medidas = json_decode($medidasJson)->medidas;
                                    foreach ($medidas as $medida) {
                                        $selected = ($result->unidade == $medida->sigla) ? 'selected' : '';
                                        echo "<option value=\"{$medida->sigla}\" {$selected}>{$medida->descricao}</option>";
                                    }
                                } else {
                                    echo "<option value=\"UN\"" . ($result->unidade == 'UN' ? ' selected' : '') . ">UNIDADE</option>";
                                    echo "<option value=\"CX\"" . ($result->unidade == 'CX' ? ' selected' : '') . ">CAIXA</option>";
                                    echo "<option value=\"KG\"" . ($result->unidade == 'KG' ? ' selected' : '') . ">QUILOGRAMA</option>";
                                    echo "<option value=\"M\"" . ($result->unidade == 'M' ? ' selected' : '') . ">METRO</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="estoque" class="control-label">Estoque<span class="required">*</span></label>
                        <div class="controls">
                            <input id="estoque" type="text" name="estoque" value="<?php echo $result->estoque; ?>" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="estoqueMinimo" class="control-label">Estoque Mínimo</label>
                        <div class="controls">
                            <input id="estoqueMinimo" type="text" name="estoqueMinimo" value="<?php echo $result->estoqueMinimo; ?>" />
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3" style="display: flex;justify-content: center">
                                <button type="submit" class="button btn btn-primary" style="max-width: 160px">
                                  <span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Atualizar</span></button>
                                <a href="<?php echo base_url() ?>index.php/produtos" id="" class="button btn btn-mini btn-warning">
                                  <span class="button__icon"><i class="bx bx-undo"></i></span><span class="button__text2">Voltar</span></a>
                            </div>
                        </div>
                    </div>


                </form>
            </div>

        </div>
    </div>
</div>


<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
    function gerarCodigoDeBarras() {
        var tempoSegundos = Math.floor(Date.now() / 1000).toString();
        // Adiciona 789 (Brasil) + timestamp (13 dígitos)
        $('#codDeBarra').val('789' + tempoSegundos);
    }

    function calcLucro(precoCompra, Lucro) {
        var lucroTipo = $('#selectLucro').val();
        var precoVenda;
        
        if (lucroTipo === 'markup') {
            precoVenda = (precoCompra * (1 + Lucro / 100)).toFixed(2);
        } else if (lucroTipo === 'margemLucro') {
            precoVenda = (precoCompra / (1 - (Lucro / 100))).toFixed(2);
        }
        
        return precoVenda;
    }
    
    function atualizarPrecoVenda() {
        var precoCompra = Number($("#precoCompra").val());
        var lucro = Number($("#Lucro").val());
        
        if (precoCompra > 0 && lucro >= 0) {
            $('#precoVenda').val(calcLucro(precoCompra, lucro));
        }
    }
    
    $("#precoCompra, #Lucro, #selectLucro").on('input change', atualizarPrecoVenda);

    $("#precoCompra, #Lucro").on('input change', function() {
        if ($("#precoCompra").val() == '0.00' && $('#precoVenda').val() != '') {
            $('#errorAlert').text('Você não pode preencher valor de compra e depois apagar.').css("display", "inline").fadeOut(6000);
            $('#precoVenda').val('');
            $("#precoCompra").focus();
        } else if ($("#precoCompra").val() != '' && $("#Lucro").val() != '') {
            atualizarPrecoVenda();
        }
    });

    $("#Lucro").keyup(function() {
        this.value = this.value.replace(/[^0-9.]/g, '');
        if ($("#precoCompra").val() == null || $("#precoCompra").val() == '') {
            $('#errorAlert').text('Preencher valor da compra primeiro.').css("display", "inline").fadeOut(5000);
            $('#Lucro').val('');
            $('#precoVenda').val('');
            $("#precoCompra").focus();

        } else if (Number($("#Lucro").val()) >= 0) {
            $('#precoVenda').val(calcLucro(Number($("#precoCompra").val()), Number($("#Lucro").val())));
        } else {
            $('#errorAlert').text('Não é permitido número negativo.').css("display", "inline").fadeOut(5000);
            $('#Lucro').val('');
            $('#precoVenda').val('');
        }
    });

    $('#precoVenda').focusout(function () {
        if (Number($('#precoVenda').val()) < Number($("#precoCompra").val())) {
            $('#errorAlert').text('Preço de venda não pode ser menor que o preço de compra.').css("display", "inline").fadeOut(6000);
            $('#precoVenda').val('');
            if($("#margemLucro").val() != "" || $("#margemLucro").val() != null){
                $('#precoVenda').val(calcLucro(Number($("#precoCompra").val()), Number($("#margemLucro").val())));
            }
        }
    });

    $(document).ready(function() {
        $(".money").maskMoney();
        $('#formProduto').validate({
            rules: {
                descricao: {
                    required: true
                },
                unidade: {
                    required: true
                },
                precoCompra: {
                    required: true
                },
                precoVenda: {
                    required: true
                },
                estoque: {
                    required: true
                }
            },
            messages: {
                descricao: {
                    required: 'Campo Requerido.'
                },
                unidade: {
                    required: 'Campo Requerido.'
                },
                precoCompra: {
                    required: 'Campo Requerido.'
                },
                precoVenda: {
                    required: 'Campo Requerido.'
                },
                estoque: {
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
