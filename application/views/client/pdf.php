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

<table class="tableHorizon table table-bordered table-striped" >
  <thead>
    <tr>
      <th>Codigo Cliente</th>
      <th>Nombre del Negocio</th>
      <th>Dirección</th>
      <th>Barrio</th>
      <th>Zona</th>
      <th>Subzona</th>
      <th>Ciudad</th>
      <th>Fecha de Alta</th>
      <th>Fecha Ultima Transaccion</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($clients as $client): ?>
      <tr>
        <td><strong><?php echo $client->CodeCustomer; ?></strong></td>
        <td><?php echo $client->NombreTienda; ?></td>
        <td><?php echo $client->Direccion; ?></td>
        <td><?php echo $client->Barrio; ?></td>
        <td><?php echo $client->Zona; ?></td>
        <td><?php echo $this->Area_Model->get_area_name($client->idSubZona); ?></td>
        <td><?php echo $client->Ciudad; ?></td>
        <td><?php echo $client->FechaAlta; ?></td>
        <td><?php echo $client->ff; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>