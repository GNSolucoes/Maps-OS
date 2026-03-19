<style>
    .box-content-tecnico {
        background: #f8f9fa;
        padding: 20px;
        text-align: center;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .box-content-tecnico h1 {
        margin: 0;
        font-size: 32px;
        color: #2c3e50;
        font-weight: bold;
    }
    .box-content-tecnico p {
        margin: 5px 0 0;
        color: #7f8c8d;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
    }
    
    .os-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 15px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        transition: transform 0.2s;
    }
    .os-card:active {
        transform: scale(0.98);
    }
    .os-header {
        background: #f1f2f6;
        padding: 10px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
    }
    .os-id {
        font-weight: bold;
        color: #555;
    }
    .os-status {
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 10px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .status-aberto { background: #ffeaa7; color: #d63031; }
    .status-orçamento { background: #fab1a0; color: #d63031; }
    .status-emandamento { background: #74b9ff; color: #0984e3; }
    .status-finalizado { background: #55efc4; color: #00b894; }
    
    .os-body {
        padding: 15px;
    }
    .os-body h5 {
        margin: 0 0 10px;
        font-size: 16px;
        color: #2d3436;
    }
    .os-body p {
        margin: 0 0 8px;
        font-size: 13px;
        color: #636e72;
    }
    .btn-block-mobile {
        width: 100%;
        display: block;
        box-sizing: border-box;
        margin-top: 10px;
    }
</style>

<div class="row-fluid" style="margin-top: 10px;">
    <div class="span12">
        <div class="widget-box">
             <div class="widget-title">
                <span class="icon"><i class="fas fa-tools"></i></span>
                <h5>Painel do Técnico</h5>
                <div class="buttons">
                    <a href="<?php echo base_url('index.php/tecnico/minhas_os'); ?>" class="btn btn-mini btn-primary"><i class="fas fa-list"></i> Ver Todas</a>
                </div>
             </div>
             <div class="widget-content">
                  <div class="alert alert-info" style="margin-bottom: 20px;">
                      Olá, <strong><?php echo $this->session->userdata('nome_admin'); ?></strong>. Aqui estão suas tarefas.
                  </div>

                  <!-- Ações Rápidas -->
                  <div class="row-fluid" style="margin-bottom: 20px; text-align: center;">
                       <div class="span2">
                           <a href="<?php echo base_url('index.php/tecnico/rotas'); ?>" class="btn-action-tecnico purple">
                               <i class="fas fa-map-marked-alt fa-2x"></i><br>Rotas
                           </a>
                       </div>
                       <div class="span2">
                           <a href="<?php echo base_url('index.php/tecnico/produtos'); ?>" class="btn-action-tecnico orange">
                               <i class="fas fa-box-open fa-2x"></i><br>Saída Produtos
                           </a>
                       </div>
                       <div class="span2">
                           <a href="<?php echo base_url('index.php/tecnico/nova_os_rapida'); ?>" class="btn-action-tecnico green">
                               <i class="fas fa-plus-circle fa-2x"></i><br>Nova OS Rápida
                           </a>
                       </div>
                       <div class="span2">
                           <a href="<?php echo base_url('index.php/tecnico/minhas_os'); ?>" class="btn-action-tecnico blue">
                               <i class="fas fa-file-signature fa-2x"></i><br>Assinar OS
                           </a>
                       </div>

                       <div class="span2">
                           <a href="<?php echo base_url('index.php/tecnico/sair'); ?>" class="btn-action-tecnico red">
                               <i class="fas fa-sign-out-alt fa-2x"></i><br>Sair
                           </a>
                       </div>
                  </div>

                  <style>
                      .btn-action-tecnico {
                          display: block;
                          padding: 15px;
                          color: #FFF;
                          border-radius: 10px;
                          text-decoration: none;
                          transition: transform 0.2s;
                          box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                      }
                      .btn-action-tecnico:hover { color: #FFF; transform: translateY(-3px); text-decoration: none; filter: brightness(1.1); }
                      .btn-action-tecnico.purple { background: #9b59b6; }
                      .btn-action-tecnico.orange { background: #e67e22; }
                      .btn-action-tecnico.green { background: #2ecc71; }
                      .btn-action-tecnico.blue { background: #3498db; }
                      .btn-action-tecnico.yellow { background: #f1c40f; }
                      .btn-action-tecnico.red { background: #e74c3c; }
                  </style>

                  <!-- Cards de Resumo -->
                  <div class="row-fluid">
                      <div class="span6">
                          <div class="box-content-tecnico">
                              <h1><?php echo $count_pendentes; ?></h1>
                              <p>OSs Pendentes</p>
                          </div>
                      </div>
                      <div class="span6">
                           <div class="box-content-tecnico">
                              <h1><?php echo $count_finalizadas_mes; ?></h1>
                              <p>Finalizadas (Mês)</p>
                          </div>
                      </div>
                  </div>
                  
                  <hr>
                  
                  <h5 style="margin-bottom:15px"><i class="fas fa-clock"></i> Pendentes Recentes</h5>
                  
                  <?php if (!$results) { ?>
                      <div class="alert alert-warning">Nenhuma OS pendente atribuída a você.</div>
                  <?php } else { ?>
                      <div class="os-list-mobile">
                          <?php foreach ($results as $os) { 
                              $statusClass = strtolower(str_replace(' ', '', preg_replace('/[^A-Za-z0-9\-]/', '', $os->status)));
                          ?>
                              <div class="os-card">
                                  <div class="os-header">
                                      <span class="os-id">OS #<?php echo $os->idOs; ?></span>
                                      <span class="os-status status-<?php echo $statusClass; ?>"><?php echo $os->status; ?></span>
                                  </div>
                                  <div class="os-body">
                                      <h5><?php echo $os->nomeCliente; ?></h5>
                                      <p title="Equipamento"><i class="fas fa-desktop"></i> <?php echo $os->descricaoProduto; ?></p>
                                      <?php if($os->defeito) { ?>
                                      <p title="Defeito Relatado"><i class="fas fa-exclamation-triangle"></i> <?php echo character_limiter($os->defeito, 50); ?></p>
                                      <?php } ?>
                                      <?php if($os->celular_cliente) { ?>
                                          <p><a href="https://wa.me/55<?php echo preg_replace('/[^0-9]/', '', $os->celular_cliente); ?>" target="_blank" class="btn btn-mini btn-success"><i class="fab fa-whatsapp"></i> WhatsApp Cliente</a></p>
                                      <?php } ?>
                                      <a href="<?php echo base_url('index.php/os/visualizar/'.$os->idOs); ?>" class="btn btn-primary btn-block-mobile"><i class="fas fa-eye"></i> Detalhes / Ação</a>
                                  </div>
                              </div>
                          <?php } ?>
                      </div>
                  <?php } ?>
             </div>
        </div>
    </div>
</div>
