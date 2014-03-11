<table>
  <tr>
    <th>Codigo de Producto</th>
    <th>Nombre</th>
    <th>Linea Volumen</th>
    <th>Precio Unitario</th>
    <th>Descripcion</th>
    <th>Unidades Vendidas</th>
  </tr>
  <?php foreach ($products as $row): ?>
    <tr>
      <td><strong><?php echo $row->idProduct; ?></strong></td>
      <td><?php echo $row->Nombre; ?></td>
      <td><?php echo $row->lineDescription." - ".$row->volumeDescription; ?></td>
      <td class="align-right"><?php echo $this->Transaction_Model->roundnumber($row->PrecioUnit, 2); ?></td>
      <td><?php echo $row->Descripcion."&nbsp;"; ?></td>
      <td><?php echo $row->sum; ?></td>
    </tr>
  <?php endforeach; ?>
</table>