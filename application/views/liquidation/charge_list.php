<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">Cargas Realizadas</h3>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th class="center">Distribuidor</th>
          <th class="center">Fecha</th>
          <th class="center">Ruta</th>
          <th class="center">Estado</th>
          <th class="center">Detalle</th>
          <th class="center">&nbsp;</th>
          <th class="center">&nbsp;</th>
          <th class="center">&nbsp;</th>
        </tr>
      </thead>
      <tbody id="diaryTable">
          <tr class="even gradeX">
            <td class="center">SSSS</td>
            <td class="center">SSSS</td>
            <td class="center">SSSS</td>
            <td class="center">SSSS</td>
            <td class="center">SSSS</td>
            <td class="center">
              <?php echo anchor('diary', 'Adicionar Productos', array('class' => 'btn btn-primary')); ?>
            </td>
            <td class="center">
              <?php echo anchor('diary', 'Recarga de Productos', array('class' => 'btn btn-primary')); ?>
            </td>
            <td class="center">
              <?php echo anchor('diary', 'Eliminar', array('class' => 'btn btn-primary')); ?>
            </td>
          </tr>
      </tbody>
    </table>
  </div>
</div>
