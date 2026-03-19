<style>
    .os-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 15px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    .os-header {
        background: #f1f2f6;
        padding: 10px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
    }
    .os-id { font-weight: bold; color: #555; }
    .os-status { font-size: 11px; padding: 2px 8px; border-radius: 10px; font-weight: 600; text-transform: uppercase; }
    .status-aberto { background: #ffeaa7; color: #d63031; }
    .status-orçamento { background: #fab1a0; color: #d63031; }
    .status-emandamento { background: #74b9ff; color: #0984e3; }
    .status-finalizado { background: #55efc4; color: #00b894; }
    .status-cancelado { background: #dfe6e9; color: #636e72; }
    
    .os-body { padding: 15px; }
    .os-body h5 { margin: 0 0 10px; font-size: 16px; color: #2d3436; }
    .os-body p { margin: 0 0 8px; font-size: 13px; color: #636e72; }
    .btn-block-mobile { width: 100%; display: block; box-sizing: border-box; margin-top: 10px; }
</style>

<div class="row-fluid" style="margin-top: 10px;">
    <div class="span12">
        <div class="widget-box">
             <div class="widget-title">
                <span class="icon"><i class="fas fa-list-alt"></i></span>
                <h5>Minhas Ordens de Serviço (Todas)</h5>
                <div class="buttons">
                    <a href="<?php echo base_url('index.php/tecnico'); ?>" class="btn btn-mini btn-inverse"><i class="fas fa-arrow-left"></i> Voltar</a>
                </div>
             </div>
             <div class="widget-content">
                  <?php if (!$results) { ?>
                      <div class="alert alert-info">Nenhuma OS encontrada.</div>
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
                                      <p title="Data Inicial"><i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($os->dataInicial)); ?></p>
                                      
                                      <a href="<?php echo base_url('index.php/os/visualizar/'.$os->idOs); ?>" class="btn btn-primary btn-block-mobile"><i class="fas fa-eye"></i> Detalhes / Ação</a>
                                  </div>
                              </div>
                          <?php } ?>
                      </div>
                      
                      <?php echo $this->pagination->create_links(); ?>
                  <?php } ?>
             </div>
        </div>
    </div>
</div>
