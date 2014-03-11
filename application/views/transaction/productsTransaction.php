<div class="row">
<?php echo form_open('transaction/search_tab_report'); ?>

 <div class="container fieldsClientForm logincontainer fieldsSearch formContainer">
    <div class="span10 offset1">
      <div class="block_head row">
        <h2 class="span4">Busqueda</h2>
      </div>
      <div class="block_content row">
          <fieldset>
            <div class="control-group selected_1">
              <label class="control-label" for="dateStart">Desde:</label>
              <div class="controls">
                <?php echo form_input(array('name' => 'dateStart', 'class' => 'span2 datepicker'), set_value('dateStart')); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="dateFinish">Hasta:</label>
              <div class="controls">
                <?php echo form_input(array('name' => 'dateFinish', 'class' => 'span2 datepicker'), set_value('dateFinish')); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="status">Estado:</label>
              <div class="controls">
                <?php
                  $options = array(
                    ''  => 'Seleccione Estado',
                    '1'  => 'Prevendido',
                    '3'  => 'Distribuido',                    
                    '6'  => 'Venta Directa',
                    '7'  => 'Transaccion 0'
                  );
                  echo form_dropdown('status', $options);
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="channel">Usuario</label>
              <div class="controls">
                <?php echo form_dropdown('searchuser', $user); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="commercetype">Tipo de Comercio</label>
              <div class="controls">
                <?php echo form_dropdown('commercetype', $commerce); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="channel">Canal</label>
              <div class="controls">
                <?php echo form_dropdown('channel', $channel); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="name">Nombre del negocio:</label>
              <div class="controls">
                <?php echo form_input(array('name' => 'name', 'class' => 'span4'), set_value('name')); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="code">Codigo:</label>
              <div class="controls">
                <?php echo form_input(array('name' => 'code', 'class' => 'span3'), set_value('code')); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="city">Ciudad</label>
              <div class="controls">
                <?php echo form_dropdown('city', $city); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="area">Zona</label>
              <div class="controls">
                <?php echo form_dropdown('area', $area); ?>
              </div>
            </div>


            <div class="control-group">
              <label class="control-label" for="subarea">Sub Zona</label>
              <div class="controls">
                <?php echo form_dropdown('subarea', $subarea); ?>
              </div>
            </div>

            

            <div class="control-group">
              <label class="control-label" for="channel">Ordenar por</label>
              <div class="controls">
                 <?php 
                  $options = array(                    
                    'transaction.idTransaction'  => 'Codigo de transaccion',
                    'users.idUser'  => 'Creado por',
                    'customer.idCustomer'  => 'Cliente',
                    'customer.CodeCustomer'  => 'Codigo de Cliente',
                    'transaction.Estado'  => 'Estado',
                    'blog.FechaHoraInicio'  => 'Fecha'
                  );
                  echo form_dropdown('orderSelect', $options); 
                ?>



              </div>
            </div>

            <div class="form-actions span7">
              <input class="btn btn-primary" type="submit" name="submit" value="Buscar" />
              <input id="btn_clean" class="btn btn-primary" type="reset" value="Limpiar" >

              <div class="btnCSV">
                <?php echo form_close(); ?>
                <?php echo form_open('transaction/report2_csv'); ?>
                <?php echo form_hidden('parameters', $search_parameters); ?>
                <?php echo form_submit('send', 'CSV'); ?>
                <?php echo form_close(); ?>
                <h5>Productos</h5> 
              </div>

              <div class="btnCSV">
                <?php echo form_close(); ?>
                <?php echo form_open('transaction/search_csv'); ?>
                <?php echo form_hidden('parameters', $search_parameters); ?>
                <?php echo form_submit('send', 'CSV'); ?>
                <?php echo form_close(); ?>
                <h5>Transacciones</h5> 
              </div>

              <div class="btnPDF">
                <?php echo form_close(); ?>
                <?php echo form_open('transaction/pdfProducts'); ?>
                <?php echo form_hidden('parameters', $search_parameters); ?>
                <?php echo form_submit('send', 'PDF'); ?>
                <?php echo form_close(); ?>
              </div>
            </div>
          </fieldset>
      </div>
    </div>
  </div>
</div>

<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Numero de Transaccion</th>
      <th>Usuario</th>
      <th>Fechas</th>
      <th>Codigo de Cliente</th>
      <th>Nombre de Cliente</th>
      <th>Sub Zona</th>
      <th style="width: 150px;">Producto</th>
      <th style="width: 40px;">Cantidad</th>
      <th style="width: 60px;">P.U.</th>
      <th style="width: 80px;">Importe</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $totalTransactionPrice = 0;
    foreach ($transaction as $row) {
     ?>
      <tr>
        <td class="text-info districtDesc"><strong><?php echo $row->idTransaction; ?></strong></td>
        <td class="text-info districtDesc"><?php echo $this->Account_Model->get_initials_by_email($row->user); ?></td>
        <td class="text-info districtDesc"><?php 
          //echo $this->Transaction_Model->get_start_date_for_this_transaction($row->idTransaction); 
          $Blog = $this->Blog_Model->get_by_transaction($row->idTransaction);
          foreach ($Blog as $rowBlog){
            echo "<strong>Inicio: </strong>".$rowBlog->FechaHoraInicio."<br>";
            echo "<strong>Finalizacion: </strong>".$rowBlog->FechaHoraFin."<br>";
            echo "<strong>Duracion: </strong>".$this->Transaction_Model->dateDiff($rowBlog->FechaHoraInicio, $rowBlog->FechaHoraFin)."<br>";

            $FechaHoraInicio = $rowBlog->FechaHoraInicio;
            $FechaHoraFin = $rowBlog->FechaHoraFin;
            $codeBlog = $rowBlog->idBlog;

            $coordinateStart = explode(";", $rowBlog->CoordenadaInicio);
            $coordinateFinish = explode(";", $rowBlog->CoordenadaFin);
          }
        ?></td>
        <td class="text-info districtDesc"><?php echo $row->codecustomer; ?></td>
        <td class="text-info districtDesc"><?php echo $row->customer; ?></td>
        <td class="text-info districtDesc"><?php echo $this->Area_Model->get_area_name($row->idSubZona); ?></td>
        
        <td colspan="4">
          <table class="tableHorizon table table-bordered table-striped">
            <tbody>
              <?php     
                $transdetail = $this->Detailtransaction_Model->get_actives($row->idTransaction);
                $totalPrice = 0;
                foreach ($transdetail as $row_product) {
                  $partialPrice = ($row_product->Cantidad * $row_product->precio);
                  $totalPrice += $partialPrice;
                  $totalTransactionPrice+= $partialPrice;
                      
              ?>  
                <tr>
                  <td style="width: 150px;" class="text-info districtDesc"><?php echo $row_product->productName; ?></td>
                  <td style="width: 40px;" class="text-info districtDesc align-right"><?php echo $row_product->Cantidad; ?></td>

                   <td style="width: 60px;" class="text-info districtDesc align-right"><?php echo $this->Transaction_Model->roundnumber($row_product->precio, 2); ?></td>
                  <td style="width: 80px;" class="text-info districtDesc align-right"><?php echo $this->Transaction_Model->roundnumber($partialPrice, 2); ?></td>
                </tr>
              <?php }
                if($totalPrice > 0){
              ?>
                <tr>
                  <td colspan="3" class="text-info districtDesc" style="text-align:right;"><strong>PRECIO TOTAL Bs:</strong></td>
                  <td class="text-info districtDesc align-right"><strong><?php echo $this->Transaction_Model->roundnumber($totalPrice, 2); ?></strong></td>
                </tr>
              <?php
                }
               ?>
            </tbody>
          </table>
        </td>
      </tr>
    <?php } ?>
    <tr style="margin-top:50px;">
      <td style="border:0; background-color: #DDD;text-align:right;border:0;" colspan="9"><strong>TOTAL TRANSACCIONES:</strong></td>
      <td style="border:0; background-color: #DDD;color: #000;border:0;border:0;" class="text-info align-right t_4"><strong><?php echo count($transaction); ?></strong></td>
    </tr>

    <tr>
      <td style="border:0; background-color: #DDD;text-align:right;border:0;" colspan="9"><strong>TOTAL IMPORTE Bs:</strong></td>
      <td style="border:0; background-color: #DDD;color: #000;border:0;border:0;" class="text-info align-right t_4"><strong>
        <?php //echo $this->Transaction_Model->roundnumber($totalTransactionPrice, 2);
         if (isset($sum_products)) {
          echo $this->Transaction_Model->roundnumber($sum_products[0]->Total, 2); 
          }else{
            echo "0.00";
          }
        ?></strong></td>
    </tr>
  </tbody>
</table>














<h2>PRODUCTOS</h2>

<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Codigo</th>
      <th>Nombre</th>
      <th>Linea Volumen</th>
      <th style="text-align:center;">Cantidad</th>
      <th>P.U.</th>
      <th>TOTAL</th>
    </tr>
  </thead>
  <tbody>
    <?php
      //print_r($sum_products);
      //$sum_products->Total
      //$price = 0;
      foreach ($data_products as $row){
        //$partialprice = $row->Cantidad * $row->Total;
        //$price += $partialprice;
    ?>
      <tr>
        <td class="text-info districtDesc"><strong><?php echo $row->idProduct; ?></strong></td>
        <td class="text-info districtDesc"><?php echo $row->Nombre; ?></td>
        <td class="text-info districtDesc"><?php echo $row->line." - ".$row->volume; ?></td>
        <td class="text-info districtDesc" style="text-align:center;"><?php echo $row->Cantidad; ?></td>
        <td class="text-info districtDesc align-right"><?php echo $this->Transaction_Model->roundnumber($row->PrecioUnit, 2); ?></td>
        <td class="text-info districtDesc align-right"><?php echo $this->Transaction_Model->roundnumber(($row->Total), 2); ?></td>
      </tr>
    <?php
      }
    ?>
      <tr>
        <td colspan="5" class="text-info districtDesc align-right"><strong style="float:right;">TOTAL Bs</strong></td>
        <td class="text-info districtDesc align-right"><?php 
          if (isset($sum_products)) {
          echo $this->Transaction_Model->roundnumber($sum_products[0]->Total, 2); 
          }else{
            echo "0.00";
          }
          
        ?></td>
      </tr>
  </tbody>
</table>

