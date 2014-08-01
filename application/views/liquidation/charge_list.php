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
          <th class="center" colspan="4">&nbsp;</th>
        </tr>
      </thead>
      <tbody id="diaryTable">
         <?php foreach ($charges as $row) { ?>
          <tr class="even gradeX">
            <td class="center"><?php echo $row->Nombre." ".$row->Apellido; ?></td>
            <td class="center"><?php echo $row->fechaRegistro; ?></td>
            <td class="center"><?php echo $row->Descripcion; ?></td>
            <td class="center"><?php echo $row->mark; ?></td>
            <td class="center"><?php echo $row->detalle; ?></td>
            <td class="center">
              <?php
                if ( $row->mark == "creado"){
                  echo anchor('liquidation/add_products/'.$row->idLiquidacion, 'Adicionar Productos', array('class' => 'btn btn-default', 'title' => 'Ninguna carga realizada, cargar por primera vez')); 
                }elseif ($row->mark == "cargado") {
                  echo anchor('liquidation/add_products/'.$row->idLiquidacion, '<span class="glyphicon glyphicon-circle-arrow-up"></span> Adicionar Productos', array('class' => 'btn btn-default', 'title' => 'Carga realizada, realizar una carga extra')); 
                }elseif ($row->mark == "cargaextra1") {
                  echo anchor('liquidation/add_products/'.$row->idLiquidacion, '<span class="glyphicon glyphicon-circle-arrow-up"></span><span class="glyphicon glyphicon-circle-arrow-up"></span> Adicionar Productos', array('class' => 'btn btn-default', 'title' => 'Carga extra realizada, realizar una segunda carga extra')); 
                }elseif ($row->mark == "cargaextra2") {
                  echo anchor('liquidation/add_products/'.$row->idLiquidacion, '<span class="glyphicon glyphicon-circle-arrow-up"></span><span class="glyphicon glyphicon-circle-arrow-up"></span><span class="glyphicon glyphicon-circle-arrow-up"></span> Adicionar Productos', array('class' => 'btn btn-default', 'title' => '2 cargas extra realizadas, realizar una tercera carga extra'));
                }
              ?>
            </td>
            <td class="center">
              <?php if ($row->mark != "creado") { ?>
                <button class="btn btn-success" data-toggle="modal" data-target="<?php echo "#myModalComplete".$row->idLiquidacion;?>">
                  <span class="glyphicon glyphicon-ok"></span> Carga Completa
                </button>
              <?php } ?>

              <!-- Modal -->
              <div class="modal fade" id="<?php echo "myModalComplete".$row->idLiquidacion;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                      <h4 class="modal-title" id="myModalLabel">Finalizar carga</h4>
                    </div>
                    <div class="modal-body">
                      Esta seguro de Finalizar esta carga?
                      <br>
                      Ya no sera posible adicionar mas productos.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                      <?php echo anchor('liquidation/complete_charge/'.$row->idLiquidacion, 'Finalizar carga', array('class' => 'btn btn-warning')); ?>
                    </div>
                  </div>
                </div>
              </div>

            </td>
            <td class="center">
              <?php echo anchor('liquidation/pdf/'.$row->idLiquidacion, '<span class="glyphicon glyphicon-download-alt"></span> Pdf', array('class' => 'btn btn-info')); ?>
              <?php echo anchor('liquidation/show/'.$row->idLiquidacion, '<span class="glyphicon glyphicon-th-large"></span> Ver', array('class' => 'btn btn-info')); ?>
            </td>
            <td class="center">
              <button class="btn btn-danger" data-toggle="modal" data-target="<?php echo "#myModalDelete".$row->idLiquidacion;?>">
                <span class="glyphicon glyphicon-trash"></span> Eliminar
              </button>

              <!-- Modal -->
              <div class="modal fade" id="<?php echo "myModalDelete".$row->idLiquidacion;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                      <h4 class="modal-title" id="myModalLabel">Eliminar carga</h4>
                    </div>
                    <div class="modal-body">
                      Esta seguro de Eliminar esta carga? tambien se eliminaran todos los productos asociados !!!
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                      <?php echo anchor('liquidation/deactive/'.$row->idLiquidacion, 'Eliminar', array('class' => 'btn btn-danger')); ?>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>