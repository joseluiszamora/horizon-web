<style type="text/css">
  strong{
    color: #000;
  }
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
  .maintable tbody tr th {
    background-color: #F9F9F9;
    border-bottom: 1px solid #DDDDDD;
  }
  .maintable tbody tr td{
    background-color: #FFFFFF;
    border-bottom: 1px solid #DDDDDD;
  }
</style>

<table class="tableHorizon table table-bordered table-striped" border="1" >
  <thead>
    <tr>
      <th>FECHA</th>
      <th>MORA (dias)</th>
      <th>RECIBO</th>
      <th>NOMBRE</th>
      <th>DIRECCIÓN</th>
      <th>MONTO</th>
      <th>PAGOS</th>
      <th>SALDO</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($diaries as $diary): ?>
      <tr>
        <td><?php echo $diary->FechaTransaction; ?></td>
        <td><?php echo dateDiff(date("Y-m-d"), $row->FechaTransaction); ?></td>
        <td><?php echo $diary->NumVoucher; ?></td>
        <td><?php echo $diary->custname; ?></td>
        <td><?php echo "dirección"; ?></td>
        <!--<td><?php //echo $this->Area_Model->get_area_name($diary->idSubZona); ?></td>-->
        <td><?php echo $diary->Monto; ?></td>
        <td><?php echo "pagos"; ?></td>
        <td><?php echo "saldo"; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>