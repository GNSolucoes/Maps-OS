<?php
$totalProdutos = 0;
foreach ($produtos as $p) {
    $totalProdutos += $p->subTotal;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cupom Não Fiscal</title>
    <style>
        body { font-family: monospace; font-size: 12px; margin: 0; padding: 0; background: #fff; color: #000; width: 80mm; }
        .center { text-align: center; }
        .left { text-align: left; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
        .divider { border-top: 1px dashed #000; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 2px 0; }
        @media print { body { margin: 0; padding: 0; } }
    </style>
</head>
<body onload="window.print()">
    <div class="center">
        <span class="bold"><?php echo $emitente[0]->nome; ?></span><br>
        <?php echo $emitente[0]->cnpj; ?><br>
        <?php echo $emitente[0]->rua . ', ' . $emitente[0]->numero . ' - ' . $emitente[0]->bairro; ?><br>
        <?php echo $emitente[0]->cidade . ' - ' . $emitente[0]->uf; ?>
    </div>
    
    <div class="divider"></div>
    
    <div class="center bold">CUPOM NÃO FISCAL</div>
    <div class="center">Venda: <?php echo $result->idVendas; ?> - <?php echo date('d/m/Y H:i:s', strtotime($result->dataVenda)); ?></div>
    
    <div class="divider"></div>
    
    <table>
        <tr>
            <th class="left">Item</th>
            <th class="right">Qtd</th>
            <th class="right">Vl.Unit</th>
            <th class="right">Total</th>
        </tr>
        <?php foreach ($produtos as $p) : ?>
        <tr>
            <td class="left"><?php echo $p->descricao; ?></td>
            <td class="right"><?php echo number_format($p->quantidade, 0, ',', '.'); ?></td>
            <td class="right"><?php echo number_format($p->preco, 2, ',', '.'); ?></td>
            <td class="right"><?php echo number_format($p->subTotal, 2, ',', '.'); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <div class="divider"></div>
    
    <div class="right">
        Total: <span class="bold">R$ <?php echo number_format($totalProdutos, 2, ',', '.'); ?></span>
    </div>
    
    <div class="divider"></div>
    
    <div class="center">
        Obrigado pela preferência!<br>
        Volte Sempre!
    </div>
</body>
</html>
