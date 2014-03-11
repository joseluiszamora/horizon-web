<?php
  //print_r($search_parameters);
  //echo "---------------------------";
  //print_r($values_counter);
?>

<div class="row">
<?php echo form_open('transaction/search_tab_report_2'); ?>

 <div class="container fieldsClientForm logincontainer formContainer">
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
                <?php echo form_open('transaction/report_lines_csv'); ?>
                <?php echo form_hidden('parameters', $search_parameters); ?>
                <?php echo form_submit('send', 'CSV'); ?>
                <?php echo form_close(); ?>
                <h5>Lineas</h5>
              </div>

              <div class="btnCSV">
                <?php echo form_close(); ?>
                <?php echo form_open('transaction/report_2_products'); ?>
                <?php echo form_hidden('parameters', $search_parameters); ?>
                <?php echo form_submit('send', 'CSV'); ?>
                <?php echo form_close(); ?>
                <h5>Productos</h5>
              </div>

              <div class="btnPDF">
                <?php echo form_close(); ?>
                <?php echo form_open('transaction/pdfResumeTransaction'); ?>
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

<!--<h2>CLIENTES</h2>

<table class="tableHorizon table table-bordered table-striped" style="width:500px; margin: 0 auto;">
  <tbody>
    <tr>
      <td class="text-info districtDesc"><strong>TOTAL CLIENTES ZONA</strong></td>
      <td class="text-info districtDesc"><?php //echo $clients_by_area; ?></td>
    </tr>   
    <tr>
      <td class="text-info districtDesc"><strong>CLIENTES VISITADOS</strong></td>
      <td class="text-info districtDesc"><?php //echo $values_counter['count'];?></td>
    </tr>
    <tr>
      <td class="text-info districtDesc" style="text-align:right;"><strong style="text-transform:uppercase;">Prevendido</strong></td>
      <td class="text-info districtDesc"><?php //echo $values_counter['prevendido']; ?></td>
    </tr>
    <tr>
      <td class="text-info districtDesc" style="text-align:right;"><strong style="text-transform:uppercase;">Conciliado</strong></td>
      <td class="text-info districtDesc"><?php //echo $values_counter['conciliado']; ?></td>
    </tr>
    <tr>
      <td class="text-info districtDesc" style="text-align:right;"><strong style="text-transform:uppercase;">Cancelado</strong></td>
      <td class="text-info districtDesc"><?php //echo $values_counter['cancelado']; ?></td>
    </tr>
    <tr>
      <td class="text-info districtDesc" style="text-align:right;"><strong style="text-transform:uppercase;">Transaccion Temporal</strong></td>
      <td class="text-info districtDesc"><?php //echo $values_counter['temporal']; ?></td>
    </tr>
    <tr>
      <td class="text-info districtDesc" style="text-align:right;"><strong style="text-transform:uppercase;">Venta Directa</strong></td>
      <td class="text-info districtDesc"><?php //echo $values_counter['ventadirecta']; ?></td>
    </tr>
    <tr>
      <td class="text-info districtDesc" style="text-align:right;"><strong style="text-transform:uppercase;">Transaccion 0</strong></td>
      <td class="text-info districtDesc"><?php //echo $values_counter['transaccion0']; ?></td>
    </tr>
  </tbody>
</table>
-->

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
    if (isset($data_products) && $data_products != ""){
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
      } }
    ?>
      <tr>
        <td colspan="5" class="text-info districtDesc align-right"><strong style="float:right;">TOTAL Bs</strong></td>
        <td class="text-info districtDesc align-right"><?php if (isset($sum_products) && $sum_products != "") echo $this->Transaction_Model->roundnumber($sum_products[0]->Total, 2); ?></td>
      </tr>
  </tbody>
</table>



<h2>LINEAS</h2>

<table class="tableHorizon table table-bordered table-striped" style="width:800px; margin: 0 auto;">
  <thead>
    <tr>
      <th>Linea</th>
      <th>Volumen</th>
      <th style="text-align:center;">Cantidad</th>
      <th style="text-align:center;">TOTAL</th>
    </tr>
  </thead>
  <tbody>
     <?php
     //print_r($data_lines);
     // $price = 0;
     if (isset($data_lines) && $data_lines != ""){
      foreach ($data_lines as $row){
        //$partialprice = $row->cantidad * $row->precio;
        //$price += $partialprice;
    ?>
      <tr>
        <td class="text-info districtDesc"><strong><?php echo $row->line; ?></strong></td>
        <td class="text-info districtDesc"><?php echo $row->volume; ?></td>
        <td class="text-info districtDesc" style="text-align:center;"><?php echo $row->TotalProd; ?></td>
        <td style="text-align:right;" class="text-info districtDesc"><?php echo $this->Transaction_Model->roundnumber($row->Total, 2); ?></td>
      </tr>
    <?php
      } }
    ?>
      <tr>
        <td colspan="3" class="text-info districtDesc align-right"><strong style="float:right;">TOTAL Bs</strong></td>
        <td class="text-info districtDesc align-right"><?php if (isset($sum_products) && $sum_products != "")  echo $this->Transaction_Model->roundnumber($sum_products[0]->Total, 2); ?></td>
      </tr>
  </tbody>
</table>