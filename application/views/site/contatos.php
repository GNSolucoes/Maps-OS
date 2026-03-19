<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon"><i class="fas fa-envelope"></i></span>
                <h5>Mensagens de Contato</h5>
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
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Assunto</th>
                            <th>Status</th>
                            <th width="100">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$contatos || count($contatos) == 0): ?>
                        <tr><td colspan="6">Nenhuma mensagem recebida</td></tr>
                        <?php else: ?>
                        <?php foreach ($contatos as $c): ?>
                        <tr class="<?php echo !$c->lido ? 'font-weight-bold' : ''; ?>">
                            <td><?php echo date('d/m/Y H:i', strtotime($c->created_at)); ?></td>
                            <td><?php echo $c->nome; ?></td>
                            <td><?php echo $c->email; ?></td>
                            <td><?php echo $c->assunto ?: '-'; ?></td>
                            <td>
                                <?php if (!$c->lido): ?>
                                    <span class="badge badge-warning">Não lido</span>
                                <?php elseif ($c->respondido): ?>
                                    <span class="badge badge-success">Respondido</span>
                                <?php else: ?>
                                    <span class="badge badge-info">Lido</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url('index.php/site/visualizarContato/' . $c->id); ?>" class="btn-nwe3" title="Visualizar">
                                    <i class="bx bx-show bx-xs"></i>
                                </a>
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
