<script src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>

<script src="<?php echo base_url(); ?>js/jquery.gomap-1.3.2.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    // view all the maps
    $("#btnViewMap").click(function (){

     // $("#mapModal .mapContainer").remove(".mapContainer");
     // $("#mapModal .mapContainer").append("<div class='mapContainer'></div>");

      var jsonObj = []; //declare object

      $("table tbody tr").each(function(){
        var lat = $(this).children(".latitude").html();
        var lon = $(this).children(".longitude").html();
        if(lat != null && lat !="" && lon != null && lon !="") {
          jsonObj.push({
            latitude: lat, 
            longitude: lon, 
            title: '" '+$(this).children(".name").html()+'" - '+$(this).children(".address").html()
          });
        }
      });
      console.log(jsonObj);

//      $("#mapModal .mapContainer").html('');
      $("#mapModal .mapContainer").goMap({ 
        latitude: 40.396764, 
        longitude: -3.713379, 
        zoom: 10,
        markers: jsonObj
      });    
      
      $('#mapModal').modal('show');
    });



    // view single map
    $(".viewSingleMap").click(function (){
      var codeUser = $(this).parents("tr").children(".text-info").children("strong").html();
      var lat = $(this).parents("tr").children(".latitude").html();
      var lon = $(this).parents("tr").children(".longitude").html();



      if(lat != null && lat !="" && lon != null && lon !="") {
        $("#singleMapModal-"+codeUser).children('.mapContainer').html("");
        
        var objMap = "";       
        objMap += "<iframe width='800' height='350' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' ";
        objMap += "src='https://maps.google.es/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=+"+lat+"++"+lon+"&amp;aq=&amp;sll=-16.49901,-68.146248&amp;sspn=0.422016,0.780716&amp;ie=UTF8&amp;t=m&amp;z=14&amp;output=embed";
        //objMap += "&amp;aq=&amp;sll=-16.49901,-68.146248&amp;sspn=0.422016,0.780716&amp;ie=UTF8&amp;t=m&amp;z=14&amp;output=embed'";
        objMap += "></iframe><br />";

        objMap += "<smallMapModal><a href='https://maps.google.es/maps?f=q&amp;source=embed&amp;hl=es&amp;geocode=&amp;q=+"+lat+"++ "+lon+"";
        objMap += "&amp;aq=&amp;sll=-16.49901,-68.146248&amp;sspn=0.422016,0.780716&amp;ie=UTF8&amp;t=m&amp;z=14' style='color:#0000FF;text-align:left'>Ver mapa más grande</a></small>";



        $("#singleMapModal-"+codeUser).children('.mapContainer').append(objMap);

        $("#singleMapModal-"+codeUser).modal('show');
      }
    });

  });
</script>

<style type="text/css">
  #btnViewMap{
    float: right;
    width: 100px;
  }

  #mapModal{
    width: 900px;
    margin: -250px 0 0 -445px;
  }

  .smallMapModal{
    width: 900px;
    margin: -250px 0 0 -445px;
  }

  .mapContainer{
    width: 870px;
    height: 500px;
  }

  .latitude{
    display: none;
  }
  .longitude{
    display: none; 
  }
</style>


 <!-- Modal -->
  <div id="mapModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="myModalLabel">Clientes</h3>
    </div>
    <div class="modal-body mapContainer">
      
    </div>
  </div>

<div class="row">
<?php echo form_open('client/client_active'); ?>

 <div class="container formContainer logincontainer">
    <div class="span10 offset1">
      <div class="block_content row">
          <fieldset>
            <div class="control-group selected_1">
              <label class="control-label" for="name">Fecha de Ingreso (desde):</label>
              <div class="controls">
                <?php echo form_input(array('name' => 'dateStart', 'class' => 'span2 datepicker'), set_value('dateStart')); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="name">Fecha de Ingreso (hasta):</label>
              <div class="controls">
                <?php echo form_input(array('name' => 'dateFinish', 'class' => 'span2 datepicker'), set_value('dateFinish')); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="commercetype">Tipo de Comercio</label>
              <div class="controls">
                <?php echo form_dropdown('commercetype', $commerce); ?>
              </div>
            </div>

            <div class="selected_2" style="float:left;">
              <div class="control-group selected_1">
                <div class="controls">
                  <?php echo form_dropdown('city', $city); ?>
                </div>
              </div>

              <div class="control-group selected_1">
                <div class="controls">
                  <?php echo form_dropdown('area', $area); ?>
                </div>
              </div>

              <div class="control-group selected_1">
                <div class="controls">
                  <?php echo form_dropdown('subarea', $subarea); ?>
                </div>
              </div>
            </div>
            <div class="control-group selected_1">
              <label class="control-label" for="name">Nombre del negocio:</label>
              <div class="controls">
                <?php 
                echo form_input(array('name' => 'name', 'class' => 'span4'), set_value('name'));
                echo form_error('name');
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="code">Codigo:</label>
              <div class="controls">
                <?php 
                echo form_input(array('name' => 'code', 'class' => 'span3'), set_value('code'));
                echo form_error('code');
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="channel">Canal</label>
              <div class="controls">
                <?php echo form_dropdown('channel', $channel); ?>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="sort">Ordenar por</label>
              <div class="controls">
                 <?php 
                  $options = array(
                    'customer.idComercio'  => 'Tipo de Comercio',
                    'customer.idCiudad'  => 'Ciudad',
                    'zona.idZona'  => 'Zona',
                    'customer.NombreTienda'  => 'Nombre',
                    'customer.CodeCustomer'  => 'Codigo',
                    'customer.FechaAlta'  => 'Fecha de Alta'
                  );
                  echo form_dropdown('orderSelect', $options); 
                ?>
              </div>
            </div>

            <div class="control-group" style="width:100%;">
              <input class="btn btn-primary" type="submit" name="submit" value="Ver" />
              <input id="btn_clean" class="btn btn-primary" type="reset" value="Limpiar" >

              <a id="btnViewMap" class="btn btn-info" href="#"><i class="icon-globe"></i> Ver Mapa</a>
            </div>
          </fieldset>
      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>

<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>CodeCustomer</th>
      <th>NombreTienda</th>
      <th>Tipo de Comercio</th>
      <th>Direccion</th>
      <th>Barrio</th>
      <th>Zona</th>
      <th>Sub Zona</th>
      <th>Ciudad</th>
      <th>Encargado</th>
      <th>Telefono</th>
      <th>Fecha de Alta</th>      
      <th>&nbsp;</th>
    </tr>
  </thead>  
  <tbody>
    <?php foreach ($clients as $row) {
      $coordinate = explode(";", $row->Coordenada);

      if ( $row->Estado === '1') {
    ?>
      <tr>
        <td class="latitude"><?php echo $coordinate[0]; ?></td>
        <td class="longitude"><?php echo $coordinate[1]; ?></td>
        <td class="text-info"><strong><?php echo $row->CodeCustomer; ?></strong></td>
        <td class="name"><?php echo $row->NombreTienda; ?></td>
        <td><?php echo $row->comercio; ?></td>
        <td class="grid_3 address"><?php echo $row->Direccion; ?></td>
        <td><?php echo $row->Barrio; ?></td>
        <td><?php echo $row->Zona; ?></td>
        <td><?php echo $row->idSubZona; ?></td>
        <td><?php echo $row->Ciudad; ?></td>
        <td><?php echo $row->NombreContacto; ?></td>
        <td><?php echo $row->Telefono; ?></td>
        <td><?php echo $row->FechaAlta; ?></td>        
        <td>
          <div class="btnActionsForm">

            <?php
            if($this->Account_Model->get_profile() == '1' || $this->Account_Model->get_profile() == '2' || $this->Account_Model->get_profile() == '3'){
            ?>
              <?php echo anchor('client/edit/'.$row->idCustomer, 'Editar', array('class' => 'btn btn-info')); ?>

              <!-- Button to trigger modal -->
              <a href="<?php echo '#modal-'.$row->idCustomer ?>" role="button" class="btn btn-primary" data-toggle="modal">Desactivar</a>
            <?php
          }
            ?>
             
            <a class="viewSingleMap btn btn-small" href="#"><i class="icon-globe"></i> Ver Mapa</a>


            <!-- MAPA Modal -->
            <div id="<?php echo 'singleMapModal-'.$row->CodeCustomer ?>" class="smallMapModal modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Clientes</h3>
              </div>
              <div class="modal-body mapContainer">
                
              </div>
            </div>


            <!-- Modal -->
            <div id="<?php echo 'modal-'.$row->idCustomer ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Desactivar Cliente</h3>
              </div>
              <div class="modal-body">
                <p>Esta seguro que desea desactivar este cliente ?</p>
              </div>
              <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <?php echo anchor('client/deactive/'.$row->idCustomer, 'Desactivar Cliente', array('class' => 'btn btn-primary')); ?>
              </div>
            </div>

          </div>
        </td>
      </tr>
    <?php
      }
    }
    ?>
  </tbody>
</table> 
