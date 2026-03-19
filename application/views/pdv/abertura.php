<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="fas fa-cash-register"></i>
                </span>
                <h5>Abertura de Caixa</h5>
            </div>
            <div class="widget-content nopadding">
                <form action="<?php echo site_url('pdv/abrirCaixa'); ?>" method="post" class="form-horizontal">
                    <div class="control-group">
                        <label for="saldo_inicial" class="control-label">Saldo Inicial (R$)</label>
                        <div class="controls">
                            <input id="saldo_inicial" type="text" name="saldo_inicial" class="money" value="0,00" />
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Abrir Caixa</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>assets/js/jquery.mask.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.money').mask('#.##0,00', {reverse: true});
    });
</script>
