<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon"><i class="fas fa-file-invoice-dollar"></i></span>
                <h5>Solicitações de Orçamento</h5>
            </div>

            <div style="padding: 10px">
                <div class="row-fluid">
                    <div class="span2">
                        <a href="<?php echo base_url('index.php/site/configuracoes'); ?>" class="btn btn-info btn-block"><i class="fas fa-cog"></i> Configurações</a>
                    </div>
                    <div class="span2">
                        <a href="<?php echo base_url('index.php/site/paginas'); ?>" class="btn btn-info btn-block"><i class="fas fa-file-alt"></i> Páginas</a>
                    </div>
                    <div class="span2">
                        <a href="<?php echo base_url('index.php/site/servicos'); ?>" class="btn btn-info btn-block"><i class="fas fa-wrench"></i> Serviços</a>
                    </div>
                    <div class="span2">
                        <a href="<?php echo base_url('index.php/site/depoimentos'); ?>" class="btn btn-info btn-block"><i class="fas fa-comments"></i> Depoimentos</a>
                    </div>
                    <div class="span2">
                        <a href="<?php echo base_url('index.php/site/contatos'); ?>" class="btn btn-warning btn-block"><i class="fas fa-envelope"></i> Mensagens</a>
                    </div>
                    <div class="span2">
                        <a href="<?php echo base_url('index.php/site/orcamentos'); ?>" class="btn btn-success btn-block"><i class="fas fa-file-invoice-dollar"></i> Orçamentos</a>
                    </div>
                </div>
            </div>

            <div class="widget-content nopadding">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Nome / Empresa</th>
                            <th>WhatsApp</th>
                            <th>Equipamentos</th>
                            <th>Status</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$orcamentos || count($orcamentos) == 0): ?>
                        <tr><td colspan="6">Nenhuma solicitação de orçamento recebida</td></tr>
                        <?php else: ?>
                        <?php foreach ($orcamentos as $o): ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i', strtotime($o->created_at)); ?></td>
                            <td>
                                <b><?php echo $o->nome; ?></b><br>
                                <small><?php echo $o->empresa ?: '-'; ?></small>
                            </td>
                            <td><?php echo $o->whatsapp; ?></td>
                            <td><?php echo $o->equipamentos; ?></td>
                            <td>
                                <select class="status-orcamento" data-id="<?php echo $o->idOrcamento; ?>" style="width: 120px; margin-bottom: 0;">
                                    <option value="Pendente" <?php echo $o->status == 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
                                    <option value="Em Andamento" <?php echo $o->status == 'Em Andamento' ? 'selected' : ''; ?>>Em Andamento</option>
                                    <option value="Finalizado" <?php echo $o->status == 'Finalizado' ? 'selected' : ''; ?>>Finalizado</option>
                                    <option value="Cancelado" <?php echo $o->status == 'Cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                                </select>
                            </td>
                            <td>
                                <a href="https://wa.me/55<?php echo preg_replace('/[^0-9]/', '', $o->whatsapp); ?>?text=Olá <?php echo $o->nome; ?>, recebemos sua solicitação de orçamento para <?php echo $o->equipamentos; ?>." target="_blank" class="btn-nwe" style="background-color: #25D366; color: white; border: none;" title="Chamar no WhatsApp"><i class="bx bxl-whatsapp bx-xs"></i></a>
                                
                                <a href="mailto:<?php echo $o->email; ?>?subject=Orçamento Map-OS&body=Olá <?php echo $o->nome; ?>, segue retorno sobre sua solicitação..." class="btn-nwe3" title="Enviar E-mail"><i class="bx bx-envelope bx-xs"></i></a>
                                
                                <a href="#modal-excluir" role="button" data-toggle="modal" orcamento="<?php echo $o->idOrcamento; ?>" class="btn-nwe4" title="Excluir"><i class="bx bx-trash-alt bx-xs"></i></a>
                                
                                <a href="#" class="btn-nwe2 btn-detalhes" data-toggle="modal" data-target="#modal-detalhes" 
                                   data-descricao="<?php echo $o->descricao; ?>"
                                   data-endereco="<?php echo $o->endereco; ?>"
                                   title="Ver Detalhes"><i class="bx bx-show bx-xs"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detalhes -->
<div id="modal-detalhes" class="modal hide fade" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h5>Detalhes da Solicitação</h5>
    </div>
    <div class="modal-body">
        <p><strong>Descrição do Problema:</strong></p>
        <p id="detalhes-descricao" style="background: #f9f9f9; padding: 10px; border-radius: 5px;"></p>
        <hr>
        <p><strong>Endereço Completo:</strong></p>
        <p id="detalhes-endereco" style="background: #f9f9f9; padding: 10px; border-radius: 5px;"></p>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal">Fechar</button>
    </div>
</div>

<!-- Modal Excluir -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1">
    <form action="<?php echo base_url() ?>index.php/site/excluirOrcamento" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h5>Excluir Orçamento</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idOrcamento" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente excluir esta solicitação?</h5>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button class="button btn btn-warning" data-dismiss="modal"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Excluir</span></button>
        </div>
    </form>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', 'a[data-toggle="modal"]', function() {
        var orcamento = $(this).attr('orcamento');
        $('#idOrcamento').val(orcamento);
    });

    $('.btn-detalhes').on('click', function(e){
        e.preventDefault();
        var descricao = $(this).data('descricao');
        var endereco = $(this).data('endereco');
        
        $('#detalhes-descricao').text(descricao);
        $('#detalhes-endereco').text(endereco);
        $('#modal-detalhes').modal('show');
    });

    $('.status-orcamento').on('change', function(){
        var id = $(this).data('id');
        var status = $(this).val();
        var url = '<?php echo base_url("index.php/site/atualizarOrcamentoStatus"); ?>';

        $.post(url, {id: id, status: status}, function(data){
             var json = JSON.parse(data);
             if(json.result){
                 // Sucesso visual opcional
             } else {
                 alert('Erro ao atualizar status');
             }
        });
    });
});
</script>
