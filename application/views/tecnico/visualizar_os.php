<style>
    .os-detail-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
    }
    .detail-section {
        margin-bottom: 20px;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
    }
    .detail-section:last-child {
        border-bottom: none;
    }
    .detail-section h6 {
        color: #7f8c8d;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        margin-bottom: 10px;
        font-weight: bold;
    }
    .detail-section p {
        font-size: 15px;
        color: #2c3e50;
        margin-bottom: 5px;
    }
    .status-badge {
        font-size: 14px;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: bold;
        display: inline-block;
        margin-bottom: 15px;
        background: #f1f2f6;
        color: #333;
    }
    .action-buttons .btn {
        margin-bottom: 10px;
        text-align: left;
        padding: 15px;
        font-size: 16px;
    }
    .action-buttons .btn i {
        margin-right: 10px;
    }
</style>

<div class="row-fluid" style="margin-top: 10px;">
    <div class="span12">
        <div class="widget-box">
             <div class="widget-title">
                <span class="icon"><i class="fas fa-eye"></i></span>
                <h5>Visualizar OS #<?php echo $result->idOs; ?></h5>
                <div class="buttons">
                    <a href="<?php echo base_url('index.php/tecnico'); ?>" class="btn btn-mini btn-inverse"><i class="fas fa-arrow-left"></i> Voltar</a>
                </div>
             </div>
             <div class="widget-content">
                  <div class="os-detail-card">
                      <div class="status-badge">
                          Status: <?php echo $result->status; ?>
                      </div>
                      
                      <div class="detail-section">
                          <h6><i class="fas fa-user"></i> Cliente</h6>
                          <p><strong><?php echo $result->nomeCliente; ?></strong></p>
                           <?php if($result->celular_cliente) { ?>
                          <div style="margin-top: 10px;">
                             <a href="tel:<?php echo $result->celular_cliente; ?>" class="btn btn-mini"><i class="fas fa-phone"></i> Ligar</a> 
                             <a href="https://wa.me/55<?php echo preg_replace('/[^0-9]/', '', $result->celular_cliente); ?>" target="_blank" class="btn btn-mini btn-success"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                          </div>
                           <?php } ?>
                      </div>

                      <div class="detail-section">
                          <h6><i class="fas fa-desktop"></i> Equipamento</h6>
                          <p><?php echo $result->descricaoProduto; ?></p>
                          <p><strong>Defeito:</strong> <?php echo $result->defeito; ?></p>
                          <p><strong>Observações:</strong> <?php echo $result->observacoes ?: 'Sem observações'; ?></p>
                          <p><strong>Laudo:</strong> <?php echo $result->laudoTecnico ?: 'Pendente'; ?></p>
                      </div>
                      
                      <div class="detail-section">
                          <h6><i class="fas fa-calendar"></i> Datas</h6>
                          <p><strong>Entrada:</strong> <?php echo date('d/m/Y', strtotime($result->dataInicial)); ?></p>
                          <?php if($result->dataFinal) { ?>
                          <p><strong>Finalizado:</strong> <?php echo date('d/m/Y', strtotime($result->dataFinal)); ?></p>
                          <?php } ?>
                      </div>

                      <div class="action-buttons">
                          <a href="<?php echo base_url('index.php/os/editar/'.$result->idOs); ?>" class="btn btn-primary btn-large btn-block"><i class="fas fa-edit"></i> Editar OS Completa</a>
                      </div>
                  </div>
             </div>
        </div>
    </div>
</div>
