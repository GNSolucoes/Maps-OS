<style>
    .pdv-container { margin-top: 0; }
    .total-box { background: #2c3e50; color: #fff; padding: 20px; text-align: right; font-size: 3em; border-radius: 5px; margin-bottom: 20px; }
    .product-search { margin-bottom: 20px; position: relative; }
    .product-search input { height: 40px; font-size: 1.5em; width: 100%; box-sizing: border-box; }
    .table-pdv { font-size: 1.2em; background: #fff; width: 100%; }
    .table-pdv th { background: #f0f0f0; }
    .actions-box button { width: 100%; margin-bottom: 10px; height: 50px; font-size: 1.2em; }
    #resultado-busca { 
        position: absolute; 
        z-index: 1000; 
        background: #fff; 
        border: 1px solid #ccc; 
        width: 100%; 
        max-height: 300px; 
        overflow-y: auto; 
        display: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .resultado-item { padding: 10px; cursor: pointer; border-bottom: 1px solid #eee; }
    .resultado-item:hover { background-color: #f9f9f9; }
    .resultado-item.active { background-color: #e0f7fa; }
    .remove-item { color: red; cursor: pointer; }
</style>

<div class="row-fluid pdv-container">
    <div class="span8">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="fas fa-shopping-cart"></i></span>
                <h5>Itens da Venda</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered table-pdv">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="10%">Imagem</th>
                            <th>Produto</th>
                            <th width="10%">Qtd</th>
                            <th width="15%">Preço Unit.</th>
                            <th width="15%">Total</th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                    <tbody id="lista-produtos">
                        <!-- Itens serão adicionados aqui via JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="span4">
        <div class="total-box">
            R$ <span id="valor-total">0,00</span>
        </div>
        
        <div class="product-search">
            <input type="text" id="buscar-produto" placeholder="Código de barras ou Nome (F1)" autocomplete="off">
            <div id="resultado-busca"></div>
        </div>
        
        <div class="actions-box">
            <button class="btn btn-success" id="btn-finalizar" onclick="finalizarVenda()"><i class="fas fa-check"></i> Finalizar Venda (F2)</button>
            <button class="btn btn-danger" onclick="cancelarVenda()"><i class="fas fa-times"></i> Cancelar (F4)</button>
            <button class="btn btn-primary" onclick="abrirOpcoes()"><i class="fas fa-cog"></i> Opções (F10)</button>
        </div>
        
        <div class="alert alert-info">
            <strong>Caixa Aberto</strong><br>
            Operador: <?php echo $this->session->userdata('nome'); ?><br>
            Abertura: <?php echo date('d/m/Y H:i', strtotime($caixa->data_abertura)); ?>
        </div>
    </div>
</div>

<script src="<?php echo base_url() ?>assets/js/jquery.hotkeys.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<script>
    let produtosCarrinho = [];
    let produtosBusca = [];
    let indiceSelecionado = -1;
    let quantidadeTemp = 1;
    
    $(document).ready(function() {
         $('#buscar-produto').focus();
         
         // Atalhos
         $(document).bind('keydown', 'f1', function() { $('#buscar-produto').focus(); return false; });
         $(document).bind('keydown', 'f2', function() { finalizarVenda(); return false; });
         $(document).bind('keydown', 'f4', function() { cancelarVenda(); return false; });
         $(document).bind('keydown', 'f10', function() { abrirOpcoes(); return false; });
         
         // Busca e Adição Automática (Leitor)
         $('#buscar-produto').on('keypress', function(e) {
             if(e.which == 13) { // Enter pressionado
                 e.preventDefault();
                 let termo = $(this).val();
                 if(termo.length > 0) {
                     buscarProdutoExact(termo);
                 }
                 return;
             }
             
             if(e.key === '*') {
                 let val = $(this).val();
                 if(!isNaN(val) && val > 0) {
                     quantidadeTemp = parseInt(val);
                     $(this).val('');
                     e.preventDefault();
                     Swal.fire({
                         toast: true,
                         position: 'top-end',
                         icon: 'info',
                         title: `Quantidade definida: ${quantidadeTemp}x`,
                         showConfirmButton: false,
                         timer: 1500
                     });
                 }
             }
         });

         // Busca de Sugestões (Digitação manual)
         $('#buscar-produto').on('keyup', function(e) {
             // Ignorar teclas de controle e Enter (já tratado no keypress)
             if(e.which == 38 || e.which == 40 || e.which == 13 || e.key === '*') return;

             let termo = $(this).val();
             if(termo.length > 2) {
                 $.ajax({
                     url: '<?php echo site_url('pdv/get_produtos'); ?>',
                     type: 'GET',
                     dataType: 'json',
                     data: { term: termo },
                     success: function(data) {
                         produtosBusca = data;
                         indiceSelecionado = -1;
                         renderizarResultados(data);
                     }
                 });
             } else {
                 $('#resultado-busca').hide();
             }
         });
    });
    
    function buscarProdutoExact(termo) {
        $.ajax({
            url: '<?php echo site_url('pdv/get_produtos'); ?>',
            type: 'GET',
            dataType: 'json',
            data: { term: termo },
            success: function(data) {
                // Se encontrar apenas 1 ou se encontrar exato pelo cod barra
                let exato = data.find(p => p.codDeBarra == termo);
                if(exato) {
                     adicionarAoCarrinho(exato);
                } else if (data.length == 1) {
                     adicionarAoCarrinho(data[0]);
                } else if (data.length > 1) {
                     // Muitos resultados, focar na lista
                     produtosBusca = data;
                     renderizarResultados(data);
                     $('#buscar-produto').blur(); // Tira foco para navegar na lista? Não, mantém foco mas mostra lista. 
                     // Na verdade, se deu enter e tem varios, o usuario vai ter que selecionar.
                } else {
                     Swal.fire({
                         toast: true,
                         position: 'top-end',
                         icon: 'error',
                         title: 'Produto não encontrado',
                         showConfirmButton: false,
                         timer: 1500
                     });
                     $('#buscar-produto').val('');
                }
            }
        });
    }
    
    function destacarItem(itens) {
        itens.removeClass('active');
        $(itens[indiceSelecionado]).addClass('active');
    }
    
    function renderizarResultados(produtos) {
        let html = '';
        if(produtos.length > 0) {
            produtos.forEach((p, index) => {
                let img = p.foto ? '<?php echo base_url(); ?>assets/anexos/' + p.foto : '<?php echo base_url(); ?>assets/img/sem_foto.png';
                html += `<div class="resultado-item" onclick='adicionarAoCarrinho(${JSON.stringify(p)})' style="display:flex; align-items:center;">
                            <img src="${img}" style="width:40px; height:40px; margin-right:10px; object-fit:cover;">
                            <div>
                                <strong>${p.descricao}</strong><br>
                                <small>R$ ${parseFloat(p.precoVenda).toFixed(2)} | Estoque: ${p.estoque}</small>
                            </div>
                         </div>`;
            });
            $('#resultado-busca').html(html).show();
        } else {
             $('#resultado-busca').hide();
        }
    }
    
    function adicionarAoCarrinho(produto) {
        // Verificar se já existe
        let existente = produtosCarrinho.find(p => p.idProduto == produto.idProdutos);
        let qtd = quantidadeTemp;
        
        if(existente) {
            existente.quantidade += qtd;
            existente.total = existente.quantidade * parseFloat(produto.precoVenda);
        } else {
            produtosCarrinho.push({
                idProduto: produto.idProdutos,
                descricao: produto.descricao,
                foto: produto.foto,
                quantidade: qtd,
                preco: parseFloat(produto.precoVenda),
                total: qtd * parseFloat(produto.precoVenda)
            });
        }
        
        // Resetar quantidade
        quantidadeTemp = 1;
        
        renderizarCarrinho();
        $('#buscar-produto').val('');
        $('#resultado-busca').hide();
        $('#buscar-produto').focus();
    }
    
    function removerDoCarrinho(index) {
        produtosCarrinho.splice(index, 1);
        renderizarCarrinho();
    }
    
    function renderizarCarrinho() {
        let html = '';
        let totalGeral = 0;
        
        produtosCarrinho.slice().reverse().forEach((p, index) => { // Mostrar último item no topo visualmente se quiser, ou manter ordem
            // Vamos manter a ordem de array mas exibir invertido ou normal? Normal é melhor para cupom.
        });
        
        // Renderizar normal
        produtosCarrinho.forEach((p, index) => {
            totalGeral += p.total;
            let img = p.foto ? '<?php echo base_url(); ?>assets/anexos/' + p.foto : '<?php echo base_url(); ?>assets/img/sem_foto.png';
            html += `<tr>
                        <td>${index + 1}</td>
                        <td><img src="${img}" style="width:30px; height:30px; object-fit:cover;"></td>
                        <td>${p.descricao}</td>
                        <td>${p.quantidade}</td>
                        <td>R$ ${p.preco.toFixed(2)}</td>
                        <td>R$ ${p.total.toFixed(2)}</td>
                        <td><i class="fas fa-trash remove-item" onclick="removerDoCarrinho(${index})"></i></td>
                     </tr>`;
        });
        
        $('#lista-produtos').html(html);
        $('#valor-total').text(totalGeral.toFixed(2).replace('.', ','));
    }
    
    function finalizarVenda() {
        if(produtosCarrinho.length == 0) {
            Swal.fire('Atenção', 'Adicione produtos antes de finalizar.', 'warning');
            return;
        }
        
        let total = 0;
        produtosCarrinho.forEach(p => total += p.total);
        
        Swal.fire({
            title: 'Finalizar Venda',
            html: `<h3>Total: R$ ${total.toFixed(2)}</h3>`,
            input: 'select',
            inputOptions: {
                'Dinheiro': 'Dinheiro',
                'Cartão de Crédito': 'Cartão de Crédito',
                'Cartão de Débito': 'Cartão de Débito',
                'Pix': 'Pix'
            },
            inputPlaceholder: 'Selecione a forma de pagamento',
            showCancelButton: true,
            confirmButtonText: 'Finalizar',
            confirmButtonColor: '#4caf50',
            cancelButtonText: 'Cancelar',
            cancelButtonColor: '#d33',
            showLoaderOnConfirm: true,
            preConfirm: (value) => {
                if (!value) {
                    Swal.showValidationMessage('Selecione uma forma de pagamento')
                }
                return value;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                enviarVenda(total, result.value);
            }
        });
    }
    
    function enviarVenda(total, formaPgto) {
        $.ajax({
            url: '<?php echo site_url('pdv/finalizar_venda'); ?>',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({
                itens: produtosCarrinho,
                total: total,
                formaPgto: formaPgto
            }),
            success: function(response) {
                if(response.result) {
                    Swal.fire('Sucesso', 'Venda realizada com sucesso!', 'success').then(() => {
                         produtosCarrinho = [];
                         renderizarCarrinho();
                         window.open('<?php echo site_url('pdv/imprimirA4/'); ?>'+response.idVenda, '_blank');
                    });
                } else {
                    Swal.fire('Erro', response.message, 'error');
                }
            },
            error: function() {
                 Swal.fire('Erro', 'Erro de comunicação com o servidor.', 'error');
            }
        });
    }
    
    function cancelarVenda() {
        if(produtosCarrinho.length > 0) {
            Swal.fire({
                title: 'Cancelar?',
                text: "Todos os itens serão removidos.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sim, limpar'
            }).then((result) => {
                if (result.isConfirmed) {
                    produtosCarrinho = [];
                    renderizarCarrinho();
                    $('#buscar-produto').focus();
                }
            })
        }
    }

    function fecharCaixa() {
        // Obter resumo do caixa antes de fechar
        $.ajax({
             url: '<?php echo site_url('pdv/getResumoCaixa'); ?>',
             type: 'GET',
             dataType: 'json',
             success: function(resp) {
                  if(resp.result) {
                      let htmlResumo = '<table class="table table-bordered table-condensed" style="font-size: 0.9em; text-align: left;">';
                      htmlResumo += `<tr><td>Saldo Inicial:</td><td style="text-align:right">R$ ${parseFloat(resp.saldo_inicial).toFixed(2)}</td></tr>`;
                      htmlResumo += `<tr><td>Suprimentos:</td><td style="text-align:right">R$ ${parseFloat(resp.total_suprimento).toFixed(2)}</td></tr>`;
                      htmlResumo += `<tr><td>Sangrias:</td><td style="text-align:right">R$ ${parseFloat(resp.total_sangria).toFixed(2)}</td></tr>`;
                      
                      let totalVendas = 0;
                      if(resp.vendas.length > 0) {
                          htmlResumo += '<tr><td colspan="2" style="background:#f9f9f9; font-weight:bold;">Vendas por Pagamento:</td></tr>';
                          resp.vendas.forEach(v => {
                              htmlResumo += `<tr><td>${v.forma_pgto}:</td><td style="text-align:right">R$ ${parseFloat(v.total).toFixed(2)}</td></tr>`;
                              totalVendas += parseFloat(v.total);
                          });
                      }
                      htmlResumo += `<tr><td style="font-weight:bold">Total Vendas:</td><td style="text-align:right; font-weight:bold">R$ ${totalVendas.toFixed(2)}</td></tr>`;
                      htmlResumo += `<tr><td style="font-weight:bold; font-size:1.1em; color:blue">Saldo Final (Dinheiro):</td><td style="text-align:right; font-weight:bold; font-size:1.1em; color:blue">R$ ${parseFloat(resp.saldo_atual).toFixed(2)}</td></tr>`;
                      htmlResumo += '</table>';
                      
                      Swal.fire({
                            title: 'Fechar Caixa',
                            html: htmlResumo + '<br><b>Confirme o valor em dinheiro na gaveta:</b>',
                            input: 'text',
                            inputValue: parseFloat(resp.saldo_atual).toFixed(2).replace('.', ','),
                            inputAttributes: {
                                autocapitalize: 'off',
                                placeholder: 'Ex: 150,00'
                            },
                            showCancelButton: true,
                            confirmButtonText: 'Fechar Caixa',
                            cancelButtonText: 'Cancelar',
                            showLoaderOnConfirm: true,
                            preConfirm: (valor) => {
                                if (!valor) {
                                    Swal.showValidationMessage('Por favor, informe o valor final.');
                                }
                                return valor;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '<?php echo site_url('pdv/fecharCaixa'); ?>',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: { saldo_final: result.value },
                                    success: function(response) {
                                        if(response.result) {
                                            Swal.fire('Sucesso', response.message, 'success').then(() => {
                                                window.location.href = '<?php echo site_url('mapos'); ?>';
                                            });
                                        } else {
                                            Swal.fire('Erro', response.message, 'error');
                                        }
                                    },
                                    error: function() {
                                         Swal.fire('Erro', 'Erro de comunicação com o servidor.', 'error');
                                    }
                                });
                            }
                        });
                  } else {
                       Swal.fire('Erro', resp.message, 'error');
                  }
             },
             error: function() {
                  Swal.fire('Erro', 'Erro ao obter resumo do caixa. Tente novamente.', 'error');
             }
        });
    }

    function abrirOpcoes() {
        Swal.fire({
            title: 'Opções do Caixa',
            input: 'select',
            inputOptions: {
                'sangria': 'Sangria (Retirada)',
                'suprimento': 'Suprimento (Entrada)',
                'fechar': 'Fechar Caixa'
            },
            inputPlaceholder: 'Selecione uma opção',
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.value === 'sangria') {
                    realizarSangria();
                } else if (result.value === 'suprimento') {
                    realizarSuprimento();
                } else if (result.value === 'fechar') {
                    fecharCaixa();
                }
            }
        });
    }

    function realizarSangria() {
        Swal.fire({
            title: 'Sangria',
            html:
                '<input id="swal-ob" class="swal2-input" placeholder="Observação/Motivo">' +
                '<input id="swal-val" class="swal2-input" placeholder="Valor (R$)" onkeyup="formatarMoeda(this)">',
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Realizar Sangria',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                return [
                    document.getElementById('swal-val').value,
                    document.getElementById('swal-ob').value
                ]
            }
        }).then((result) => {
             if(result.isConfirmed) {
                 let valor = result.value[0];
                 let obs = result.value[1];
                 if(!valor) { Swal.fire('Erro', 'Preencha o valor.', 'error'); return; }
                 
                 $.ajax({
                     url: '<?php echo site_url('pdv/sangria'); ?>',
                     type: 'POST',
                     dataType: 'json',
                     data: { valor: valor, observacao: obs },
                     success: function(resp) {
                         if(resp.result) Swal.fire('Sucesso', resp.message, 'success');
                         else Swal.fire('Erro', resp.message, 'error');
                     }
                 });
             }
        });
    }

    function realizarSuprimento() {
        Swal.fire({
            title: 'Suprimento',
            html:
                '<input id="swal-ob" class="swal2-input" placeholder="Observação/Motivo">' +
                '<input id="swal-val" class="swal2-input" placeholder="Valor (R$)" onkeyup="formatarMoeda(this)">',
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Realizar Suprimento',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                return [
                    document.getElementById('swal-val').value,
                    document.getElementById('swal-ob').value
                ]
            }
        }).then((result) => {
             if(result.isConfirmed) {
                 let valor = result.value[0];
                 let obs = result.value[1];
                 if(!valor) { Swal.fire('Erro', 'Preencha o valor.', 'error'); return; }
                 
                 $.ajax({
                     url: '<?php echo site_url('pdv/suprimento'); ?>',
                     type: 'POST',
                     dataType: 'json',
                     data: { valor: valor, observacao: obs },
                     success: function(resp) {
                         if(resp.result) Swal.fire('Sucesso', resp.message, 'success');
                         else Swal.fire('Erro', resp.message, 'error');
                     }
                 });
             }
        });
    }

    function formatarMoeda(elemento) {
        var valor = elemento.value;
        valor = valor + '';
        valor = parseInt(valor.replace(/[\D]+/g, ''));
        valor = valor + '';
        valor = valor.replace(/([0-9]{2})$/g, ",$1");
        if (valor.length > 6) {
            valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
        }
        elemento.value = valor;
        if(valor == 'NaN') elemento.value = '';
    }
</script>
