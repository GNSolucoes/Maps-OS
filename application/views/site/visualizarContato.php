<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon"><i class="fas fa-envelope"></i></span>
                <h5>Mensagem de Contato</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" style="padding: 20px;">
                    <div class="row-fluid">
                        <div class="span6">
                            <p><strong>Nome:</strong> <?php echo $contato->nome; ?></p>
                            <p><strong>Email:</strong> <a href="mailto:<?php echo $contato->email; ?>"><?php echo $contato->email; ?></a></p>
                            <?php if ($contato->telefone): ?>
                            <p><strong>Telefone:</strong> <?php echo $contato->telefone; ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="span6">
                            <p><strong>Data:</strong> <?php echo date('d/m/Y H:i', strtotime($contato->created_at)); ?></p>
                            <?php if ($contato->assunto): ?>
                            <p><strong>Assunto:</strong> <?php echo $contato->assunto; ?></p>
                            <?php endif; ?>
                            <p><strong>Status:</strong> 
                                <?php if (!$contato->lido): ?>
                                    <span class="badge badge-warning">Não lido</span>
                                <?php elseif ($contato->respondido): ?>
                                    <span class="badge badge-success">Respondido</span>
                                <?php else: ?>
                                    <span class="badge badge-info">Lido</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row-fluid">
                        <div class="span12">
                            <h5>Mensagem:</h5>
                            <div style="background: #f5f5f5; padding: 15px; border-radius: 5px;">
                                <?php echo nl2br($contato->mensagem); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="span12">
                    <div class="span6 offset3" style="display:flex;justify-content: center">
                        <a href="<?php echo base_url('index.php/site/contatos'); ?>" class="button btn btn-warning">
                            <span class="button__icon"><i class="bx bx-undo"></i></span>
                            <span class="button__text2">Voltar</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
