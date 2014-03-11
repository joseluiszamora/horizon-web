<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/datepicker.css">
<script src="<?php echo base_url(); ?>js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    //datepicker
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd'
    }).on('changeDate', function(ev){
      $(this).datepicker('hide');
    });

    //select barrio by city
    $('.fieldsClientForm select[name="city"]').change(function(){
      $('.fieldsClientForm select[name="disctrict"] > option').remove();
      $('.fieldsClientForm select[name="area"] > option').remove();
      $('.fieldsClientForm select[name="subarea"] > option').remove();
      var idCity = $('.fieldsClientForm select[name="city"]').val();
      $.getJSON("http://localhost/horizon/district/get_districts_for_city/"+idCity,
        function(cities){
          $.each(cities,function(id,name){
              var opt = $('<option>');
              opt.val(id);
              opt.text(name);
              $('.fieldsClientForm select[name="disctrict"]').append(opt);
          });
        }
      );
    });

    // select zona by Barrio
    $('.fieldsClientForm select[name="disctrict"]').change(function(){
      $('.fieldsClientForm select[name="area"] > option').remove();
      $('.fieldsClientForm select[name="subarea"] > option').remove();
      var iddisctrict = $('.fieldsClientForm select[name="disctrict"]').val();

      $.getJSON("http://localhost/horizon/area/get_area_for_district/"+iddisctrict,
        function(area){
          $.each(area,function(id,name){
              var opt = $('<option>');
              opt.val(id);
              opt.text(name);
              $('.fieldsClientForm select[name="area"]').append(opt);


              // sub zonas
              $.getJSON("http://localhost/horizon/area/get_subarea_for_area/"+id,
                function(subarea){
                  $.each(subarea,function(id,name){
                      var opt = $('<option>');
                      opt.val(id);
                      opt.text(name);
                      $('.fieldsClientForm select[name="subarea"]').append(opt);
                  });
                }
              );
          });
        }
      );
    });

  });
</script>

<div class="row">
<?php echo form_open('transaction/search_tab'); ?>

 <div class="container fieldsClientForm logincontainer">
    <div class="span9 offset1">
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
                    '1'  => 'Creado',
                    '2'  => 'Conciliado',
                    '3'  => 'Distribuido',
                    '4'  => 'Cancelado',
                    '5'  => 'Temporal',
                    '6'  => 'Venta Directa',
                    '7'  => 'Transaccion 0',
                  );
                  echo form_dropdown('status', $options);
                ?>
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
              <label class="control-label" for="disctrict">Barrio</label>
              <div class="controls">
                <?php echo form_dropdown('disctrict', $district); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="area">Zona</label>
              <div class="controls">
                <?php echo form_dropdown('area', $area); ?>
              </div>
            </div>


            <div class="control-group selected_1">
              <label class="control-label" for="subarea">Sub Zona</label>
              <div class="controls">
                <?php echo form_dropdown('subarea', $subarea); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="commercetype">Tipo de Comercio</label>
              <div class="controls">
                <?php echo form_dropdown('commercetype', $commerce); ?>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="channel">Canal</label>
              <div class="controls">
                <?php echo form_dropdown('channel', $channel); ?>
              </div>
            </div>

            <div class="form-actions span7">
              <input class="btn btn-primary" type="submit" name="submit" value="Buscar" />
            </div>
          </fieldset>
      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>

<?php echo form_open('transaction/pdf'); ?>
<?php echo form_hidden('parameters', $search_parameters); ?>
<?php echo form_submit('send', 'PDF'); ?>
<?php echo form_close(); ?>

<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th><?php echo anchor('transaction/index/idTransaction', 'Codigo de Transaccion' , array('class' => 'newLinkTables')); ?></th>
      <th><?php echo anchor('transaction/index/user', 'Creado Por' , array('class' => 'newLinkTables')); ?></th>
      <th><?php echo anchor('transaction/index/customer', 'Cliente' , array('class' => 'newLinkTables')); ?></th>
      <th>Codigo de Cliente</th>
      <th>Preventa</th>
      <th>Distribucion</th>
      <th>Estado</th>
      <th>Observaciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($transaction as $row) {
        // get datetime coordinate
        $Blog = $this->Blog_Model->get_by_transaction($row->idTransaction);
        $timeStart = "";
        $timeFinish = "";
        foreach ($Blog as $rowBlog){
          if($rowBlog->Operation == "creacion"){
            $timeStart = "De: ".$rowBlog->FechaHoraInicio."<br> Hasta: ".$rowBlog->FechaHoraFin;
          }
          if($rowBlog->Operation == "entregado"){
            $timeFinish = "De: ".$rowBlog->FechaHoraInicio."<br> Hasta: ".$rowBlog->FechaHoraFin;
          }
        }
    ?>
      <tr>
        <td class="text-info districtDesc"><strong><?php echo $row->idTransaction; ?></strong></td>
        <td class="text-info districtDesc"><strong><?php echo $row->user; ?></strong></td>
        <td class="text-info districtDesc"><?php echo $row->customer; ?></td>
        <td class="text-info districtDesc"><?php echo $row->codecustomer; ?></td>
        <td class="text-info districtDesc"><?php echo $timeStart; ?></td>
        <td class="text-info districtDesc"><?php echo $timeFinish; ?></td>

        <td class="text-info districtDesc"><?php
          if($row->Estado == "1")
            echo "Creado";
          if($row->Estado == "2")
            echo "Conciliado";
          if($row->Estado == "3")
            echo "Distribuido";
          if($row->Estado == "4")
            echo "Cancelado";
          if($row->Estado == "5")
            echo "Transaccion Temporal";
          if($row->Estado == "6")
            echo "Venta Directa";
          if($row->Estado == "7")
            echo "Transaccion 0";

        ?></td>

         <td class="text-info districtDesc"><?php $row->Observacion; ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>