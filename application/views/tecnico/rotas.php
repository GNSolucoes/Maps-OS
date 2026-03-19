<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
             <div class="widget-title">
                <span class="icon"><i class="fas fa-map-marked-alt"></i></span>
                <?php $isAdmin = $this->permission->checkPermission($this->session->userdata('permissao'), 'cUsuario'); ?>
                <h5><?php echo $isAdmin ? 'Visualização de Rotas (Geral)' : 'Minhas Rotas de Hoje'; ?></h5>
             </div>
             <div class="widget-content">
                 <table class="table table-bordered">
                     <thead>
                         <tr>
                             <th>ID OS</th>
                             <th>Técnico</th>
                             <th>Cliente</th>
                             <th>Endereço</th>
                             <th>Bairro</th>
                             <th>Ações</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php if(!$rotas){ ?>
                             <tr><td colspan="6">Nenhuma OS em aberto encontrada para gerar rota.</td></tr>
                         <?php } else { foreach($rotas as $r){ ?>
                             <tr>
                                 <td>#<?php echo $r->idOs; ?></td>
                                 <td><?php echo isset($r->nomeTecnico) ? $r->nomeTecnico : '-'; ?></td>
                                 <td><?php echo $r->nomeCliente; ?></td>
                                 <td><?php echo $r->rua . ', ' . $r->numero; ?></td>
                                 <td><?php echo $r->bairro; ?></td>
                                 <td>
                                     <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo urlencode($r->rua . ', ' . $r->numero . ' - ' . $r->bairro . ', ' . $r->cidade); ?>" target="_blank" class="btn btn-primary btn-mini" title="Google Maps"><i class='bx bxl-google'></i> Maps</a>
                                     <a href="https://waze.com/ul?q=<?php echo urlencode($r->rua . ', ' . $r->numero . ' - ' . $r->bairro . ', ' . $r->cidade); ?>&navigate=yes" target="_blank" class="btn btn-info btn-mini" style="background-color: #33ccff; border-color: #33ccff;" title="Waze"><i class='bx bxs-navigation'></i> Waze</a>
                                 </td>
                             </tr>
                         <?php }} ?>
                     </tbody>
                 </table>
             </div>
        </div>
    </div>
</div>
