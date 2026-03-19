<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="fas fa-box-open"></i>
                </span>
                <h5>Produtos</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Preço Venda</th>
                            <th>Estoque</th>
                            <th>Estoque Mínimo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$results) { ?>
                            <tr>
                                <td colspan="6">Nenhum produto cadastrado.</td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach ($results as $r) { ?>
                                <tr>
                                    <td><?php echo $r->idProdutos; ?></td>
                                    <td><?php echo $r->descricao; ?></td>
                                    <td>R$ <?php echo number_format($r->precoVenda, 2, ',', '.'); ?></td>
                                    <td><?php echo $r->estoque; ?></td>
                                    <td><?php echo $r->estoqueMinimo; ?></td>
                                    <td>
                                        <!-- Botão apenas visual de ação, já que a lógica de "saída" real seria mais complexa.
                                             Aqui vamos colocar um modal simples para simular ou efetivar a baixa se necessário. -->
                                        <a href="#modal-saida" role="button" data-toggle="modal" produto_id="<?php echo $r->idProdutos; ?>" produto_nome="<?php echo $r->descricao; ?>" class="btn btn-warning tip-top" title="Dar Saída / Usar"><i class="fas fa-sign-out-alt"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>

<!-- Modal Saída -->
<div id="modal-saida" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url('index.php/tecnico/saida_produto_acao'); ?>" method="post">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Saída de Estoque</h3>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idProduto" name="idProduto" value="" />
    <p>Produto: <strong id="nomeProduto"></strong></p>
    <p>Quantidade a retirar:</p>
    <input type="number" name="quantidade" value="1" min="1" class="span12" required />
    <p>Observação (Opcional):</p>
    <input type="text" name="observacao" class="span12" />
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-primary">Confirmar Saída</button>
  </div>
  </form>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', 'a[data-toggle="modal"]', function() {
        var id = $(this).attr('produto_id');
        var nome = $(this).attr('produto_nome');
        $('#idProduto').val(id);
        $('#nomeProduto').text(nome);
    });
});
</script>
