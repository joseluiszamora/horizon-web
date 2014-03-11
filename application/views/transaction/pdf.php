<style type="text/css">
  table{
    -moz-border-bottom-colors: none;
    -moz-border-image: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-collapse: separate;
    border-color: #DDDDDD #DDDDDD #DDDDDD -moz-use-text-color;
    border-radius: 4px 4px 4px 4px;
    border-style: solid solid solid none;
    border-width: 1px 1px 1px 0;
  }
  table tbody tr th {
    background-color: #F9F9F9;
    border-bottom: 1px solid #DDDDDD;
  }
  table tbody tr td{
    background-color: #FFFFFF;
    border-bottom: 1px solid #DDDDDD;
  }
</style>
<table>
  <tr>    
    <th>Fecha de inicio</th>
    <th>Codigo de Transaccion</th>
    <th>Usuario</th>
    <th>Nombre Cliente</th>
    <th>Codigo de Cliente</th>
    <th>Estado</th>
    <th>Observaciones</th>

  </tr>
  <tbody>
  <?php foreach ($transactions as $transaction): ?>
    <tr>
      <td><?php echo $transaction->FechaHoraInicio; ?></td>
      <td><?php echo $transaction->idTransaction; ?></td>
      <td><?php echo $transaction->user; ?></td>
      <td><?php echo $transaction->customer; ?></td>
      <td><?php echo $transaction->codecustomer; ?></td>
      <td><?php 
        if($transaction->Estado == '1')
          $status = 'Prevendido';
        if($transaction->Estado == '2')
          $status = 'Conciliado';
        if($transaction->Estado == '3')
          $status = 'Distribuido';
        if($transaction->Estado == '4')
          $status = 'Cancelado';
        if($transaction->Estado == '5')
          $status = 'Temporal';
        if($transaction->Estado == '6')
          $status = 'Venta Directa';
        if($transaction->Estado == '7')
          $status = 'Transaccion 0';

        echo $status;
      ?></td>
      <td><?php echo $transaction->Observacion; ?></td>      
    </tr>

  <?php endforeach; ?>
  </tbody>
</table>