<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon"><i class="fas fa-cog"></i></span>
                <h5>Configurações do Site</h5>
            </div>
            
                <div style="padding: 10px">
                    <div class="row-fluid">
                        <div class="span2">
                            <a href="<?php echo base_url('index.php/site/configuracoes'); ?>" class="btn btn-primary btn-block"><i class="fas fa-cog"></i> Configurações</a>
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

                <form action="<?php echo current_url(); ?>" id="formConfig" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <div class="widget-content">
                        <div class="row-fluid">
                            <div class="span6">
                                <h5>Informações Gerais</h5>
                                <div class="control-group">
                                    <label for="nome_empresa" class="control-label">Nome da Empresa</label>
                                    <div class="controls">
                                        <input type="text" name="nome_empresa" class="span11" value="<?php echo $config->nome_empresa ?? ''; ?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="slogan" class="control-label">Slogan</label>
                                    <div class="controls">
                                        <input type="text" name="slogan" class="span11" value="<?php echo $config->slogan ?? ''; ?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="sobre" class="control-label">Sobre</label>
                                    <div class="controls">
                                        <textarea name="sobre" class="span11" rows="5"><?php echo $config->sobre ?? ''; ?></textarea>
                                    </div>
                                </div>
                                
                                <h5>Contato</h5>
                                <div class="control-group">
                                    <label for="telefone" class="control-label">Telefone</label>
                                    <div class="controls">
                                        <input type="text" name="telefone" class="span11" value="<?php echo $config->telefone ?? ''; ?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="email" class="control-label">Email</label>
                                    <div class="controls">
                                        <input type="text" name="email" class="span11" value="<?php echo $config->email ?? ''; ?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="endereco" class="control-label">Endereço</label>
                                    <div class="controls">
                                        <textarea name="endereco" class="span11" rows="3"><?php echo $config->endereco ?? ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="mapa_iframe" class="control-label">Mapa do Google (Embed)</label>
                                    <div class="controls">
                                        <textarea name="mapa_iframe" class="span11" rows="3" placeholder="Cole o código iframe do Google Maps aqui..."><?php echo $config->mapa_iframe ?? ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="horario_atendimento" class="control-label">Horário</label>
                                    <div class="controls">
                                        <input type="text" name="horario_atendimento" class="span11" value="<?php echo $config->horario_atendimento ?? ''; ?>" placeholder="Seg-Sex: 8h-18h">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="span6">
                                <h5>Visual</h5>
                                <div class="control-group">
                                    <label for="logo" class="control-label">Logo</label>
                                    <div class="controls">
                                        <input type="file" name="logo" class="span11">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="cor_primaria" class="control-label">Cor Primária</label>
                                    <div class="controls">
                                        <input type="color" name="cor_primaria" value="<?php echo $config->cor_primaria ?? '#4e73df'; ?>">
                                    </div>
                                </div>
                                 <div class="control-group">
                                    <label for="cor_secundaria" class="control-label">Cor Secundária</label>
                                    <div class="controls">
                                        <input type="color" name="cor_secundaria" value="<?php echo $config->cor_secundaria ?? '#858796'; ?>">
                                    </div>
                                </div>

                                <h5>Imagens de Login</h5>
                                <div class="control-group">
                                    <label for="imagem_login" class="control-label">Login Principal</label>
                                    <div class="controls">
                                        <input type="file" name="imagem_login" class="span11">
                                        <?php if(isset($config->imagem_login) && $config->imagem_login): ?>
                                            <div class="span12" style="margin-left: 0; margin-top: 10px">
                                                <img src="<?php echo base_url('uploads/site/' . $config->imagem_login); ?>" style="max-height: 100px; border-radius: 5px">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="imagem_cliente" class="control-label">Área do Cliente</label>
                                    <div class="controls">
                                        <input type="file" name="imagem_cliente" class="span11">
                                        <?php if(isset($config->imagem_cliente) && $config->imagem_cliente): ?>
                                            <div class="span12" style="margin-left: 0; margin-top: 10px">
                                                <img src="<?php echo base_url('uploads/site/' . $config->imagem_cliente); ?>" style="max-height: 100px; border-radius: 5px">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="imagem_tecnico" class="control-label">Painel do Técnico</label>
                                    <div class="controls">
                                        <input type="file" name="imagem_tecnico" class="span11">
                                        <?php if(isset($config->imagem_tecnico) && $config->imagem_tecnico): ?>
                                            <div class="span12" style="margin-left: 0; margin-top: 10px">
                                                <img src="<?php echo base_url('uploads/site/' . $config->imagem_tecnico); ?>" style="max-height: 100px; border-radius: 5px">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <h5>Redes Sociais</h5>
                                <div class="control-group">
                                    <label for="facebook" class="control-label">Facebook</label>
                                    <div class="controls">
                                        <input type="text" name="facebook" class="span11" value="<?php echo $config->facebook ?? ''; ?>" placeholder="https://facebook.com/suapagina">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="instagram" class="control-label">Instagram</label>
                                    <div class="controls">
                                        <input type="text" name="instagram" class="span11" value="<?php echo $config->instagram ?? ''; ?>" placeholder="https://instagram.com/seuusuario">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="whatsapp" class="control-label">WhatsApp</label>
                                    <div class="controls">
                                        <input type="text" name="whatsapp" class="span11" value="<?php echo $config->whatsapp ?? ''; ?>" placeholder="5511999999999">
                                    </div>
                                </div>

                                <h5>SEO</h5>
                                <div class="control-group">
                                    <label for="meta_description" class="control-label">Meta Description</label>
                                    <div class="controls">
                                        <textarea name="meta_description" class="span11"><?php echo $config->meta_description ?? ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="meta_keywords" class="control-label">Meta Keywords</label>
                                    <div class="controls">
                                        <input type="text" name="meta_keywords" class="span11" value="<?php echo $config->meta_keywords ?? ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span12 text-center" style="padding: 10px;">
                                <button type="submit" class="button btn btn-primary">
                                    <span class="button__icon"><i class='bx bx-save'></i></span><span class="button__text2">Salvar Configurações</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>
