<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.gomap-1.3.2.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    // view all the maps
    $("#btnViewMap").click(function (){
      var jsonObj = []; //declare object
      console.log("single map 1");
      $("table tbody tr .mapInfo").each(function(){
        var coordinatestart = $(this).attr("data-coordinate-start");
        var coordinatefinish = $(this).attr("data-coordinate-finish");
        console.log("single map 2");
        var datatrans = $(this).attr("data-trans");

        if(coordinatestart != null && coordinatestart !="" && coordinatefinish != null && coordinatefinish !="") {
          console.log("single map 3");
          jsonObj.push({
            latitude: coordinatestart, 
            longitude: coordinatefinish,
            html: { 
              id: '#'+datatrans
              //popup: true 
            } 
          });
        }
      });
     
      jsonObj.push({
        hideByClick:   false
      });
      jsonObj.push({
        oneInfoWindow: false 
      });

      $("#mapModal .mapContainer").goMap({ 
        latitude: 40.396764, 
        longitude: -3.713379, 
        zoom: 16,
        markers: jsonObj
      });    
      
      console.log("single map 5");
      $('#mapModal').modal('show');
      console.log("single map 6");
    });


    $(".viewSingleMap").click(function (){
      console.log("single map 1");
      var jsonObj = []; //declare object
      var code = $(this).attr("data-code");
      var objMe = $(this).parents("tr");
      console.log("single map 2");
     $(objMe).children(".mapInfo").each(function(){
        console.log("single map 3");
        var coordinatestart = $(this).attr("data-coordinate-start");
        var coordinatefinish = $(this).attr("data-coordinate-finish");

        var datatrans = $(this).attr("data-trans");

        if(coordinatestart != null && coordinatestart !="" && coordinatefinish != null && coordinatefinish !="") {
          console.log("single map 4");
          jsonObj.push({
            latitude: coordinatestart, 
            longitude: coordinatefinish,
            html: { 
              id: '#'+datatrans, 
              popup: true 
            } 
          });
        }
      });

      jsonObj.push({
        hideByClick:   false
      });
      jsonObj.push({
        oneInfoWindow: false 
      });
      
      $("#singleMapModal-"+code).children('.mapContainer').goMap({       
        zoom: 16,
        markers: jsonObj
      });

      google.maps.event.trigger($.goMap.map, 'resize');
      
      console.log("single map 6");
      $("#singleMapModal-"+code).modal('show');
      console.log("single map 7");
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


<div class="row">
<?php echo form_open('transaction/search_tab'); ?>

 <div class="container fieldsClientForm logincontainer formContainer fieldsSearch">
    <div class="span10 offset1">
      <div class="block_head row">
        <h2 class="span4">Busqueda</h2>
      </div>
      <div class="block_content row">
          <fieldset>            
            <div class="control-group selected_1">
              <label class="control-label" for="dateStart">Desde:</label>
              <div class="controls">
                <?php 
                echo form_input(array('name' => 'dateStart', 'class' => 'span2 datepicker'), set_value('dateStart')); 
                echo form_error('dateStart');
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="dateFinish">Hasta:</label>
              <div class="controls">
                <?php 
                echo form_input(array('name' => 'dateFinish', 'class' => 'span2 datepicker'), set_value('dateFinish'));
                echo form_error('dateFinish');
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="status">Estado:</label>
              <div class="controls">
                <?php
                  $options = array(
                    ''  => 'Seleccione Estado',
                    '1'  => 'Preventa',
                    '3'  => 'Distribuidas',
                    '5'  => 'Transaccion Temporal',
                    '6'  => 'Venta Directa',
                    '7'  => 'Transaccion0',
                  );

                  echo form_dropdown('status', $options);
                  echo form_error('status');
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

              <a id="btnViewMap" class="btn btn-info" href="#"><i class="icon-globe"></i> Ver Mapa</a>

              <!-- MAPA Modal -->
              <div id="mapModal" class="smallMapModal modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h3 id="myModalLabel">Transacciones</h3>
                </div>
                <div class="modal-body mapContainer">
                  
                </div>
              </div>

              <div class="btnCSV">
                <?php echo form_close(); ?>
                <?php echo form_open('transaction/search_csv'); ?>
                <?php echo form_hidden('parameters', $search_parameters); ?>
                <?php echo form_submit('send', 'CSV'); ?>
                <?php echo form_close(); ?>
              </div>

              <div class="btnPDF">
                <?php echo form_close(); ?>
                <?php echo form_open('transaction/pdf'); ?>
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
      <th><?php echo anchor('transaction/index/idTransaction', 'Codigo de Transaccion' , array('class' => 'newLinkTables')); ?></th>
      <th><?php echo anchor('transaction/index/user', 'Creado Por' , array('class' => 'newLinkTables')); ?></th>
      <th><?php echo anchor('transaction/index/customer', 'Cliente' , array('class' => 'newLinkTables')); ?></th>
      <th>Codigo de Cliente</th>
      <th>Observaciones</th>
      <th>Estado</th>
      <th>Fechas</th>
      <th>&nbsp;</th> 
    </tr>
  </thead>
  <tbody>
    <?php foreach ($transaction as $row) { ?>
      <tr>
        <td class="text-info districtDesc"><strong><?php echo $row->idTransaction; ?></strong></td>
        <td class="text-info districtDesc"><strong><?php echo $row->user; ?></strong></td>
        <td class="text-info districtDesc"><?php echo $row->customer; ?></td>
        <td class="text-info districtDesc"><?php echo $row->codecustomer; ?></td>
        <td class="text-info districtDesc"><?php echo $row->Observacion; ?></td>
         <?php
          $status = "";
          // set Status
          if($row->Estado == "1"){
            $status = "Prevendido";
          ?>
            <td class="text-info districtDesc"><?php echo $status; ?></td>

            <div style="float:left;">
            </div>
            <td class="text-info districtDesc"><?php 
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

            <td style="display:none;" class="mapInfo" data-trans="transinfostart-<?php echo $row->idTransaction."-".$codeBlog; ?>" data-coordinate-start="<?php echo $coordinateStart[0]; ?>" data-coordinate-finish="<?php echo $coordinateStart[1]; ?>">
              <div id="transinfostart-<?php echo $row->idTransaction."-".$codeBlog; ?>" style="display:none;">
                <ul>
                  <li><strong><?php echo $status; ?></strong></li>
                  <li><strong>Inicio</strong></li>
                  <li><strong>Fecha Hora: </strong><?php echo $FechaHoraInicio; ?></li>
                  <li><strong>Cliente: </strong><?php echo $row->customer; ?></li>
                  <li><strong>Observacion: </strong><?php echo $row->Observacion; ?></li>
                </ul>
              </div>
            </td>

            <td style="display:none;" class="mapInfo" data-trans="transinfofinish-<?php echo $row->idTransaction."-".$codeBlog; ?>" data-coordinate-start="<?php echo $coordinateFinish[0]; ?>" data-coordinate-finish="<?php echo $coordinateFinish[1]; ?>">
              <div id="transinfofinish-<?php echo $row->idTransaction."-".$codeBlog; ?>" style="display:none;">
                <ul>
                  <li><strong><?php echo $status; ?></strong></li>
                  <li><strong>Final</strong></li>
                  <li><strong>Fecha Hora: </strong><?php echo $FechaHoraFin; ?></li>
                  <li><strong>Cliente: </strong><?php echo $row->customer; ?></li>
                  <li><strong>Observacion: </strong><?php echo $row->Observacion; ?></li>
                </ul>
              </div>
            </td>
          <?php
          }
            
          if($row->Estado == "2"){
            $status = "Conciliado";
          ?>
            <td class="text-info districtDesc"><?php echo $status; ?></td>

            <td class="text-info districtDesc"><?php
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
            <td style="display:none;" class="mapInfo" data-trans="transinfostart-<?php echo $row->idTransaction."-".$codeBlog; ?>" data-coordinate-start="<?php echo $coordinateStart[0]; ?>" data-coordinate-finish="<?php echo $coordinateStart[1]; ?>">
              <div id="transinfostart-<?php echo $row->idTransaction."-".$codeBlog; ?>" style="display:none;">
                <ul>
                  <li><strong><?php echo $status; ?></strong></li>
                  <li><strong>Inicio</strong></li>
                  <li><strong>Fecha Hora: </strong><?php echo $FechaHoraInicio; ?></li>
                  <li><strong>Cliente: </strong><?php echo $row->customer; ?></li>
                  <li><strong>Observacion: </strong><?php echo $row->Observacion; ?></li>
                </ul>
              </div>
            </td>

            <td style="display:none;" class="mapInfo" data-trans="transinfofinish-<?php echo $row->idTransaction."-".$codeBlog; ?>" data-coordinate-start="<?php echo $coordinateFinish[0]; ?>" data-coordinate-finish="<?php echo $coordinateFinish[1]; ?>">
              <div id="transinfofinish-<?php echo $row->idTransaction."-".$codeBlog; ?>" style="display:none;">
                <ul>
                  <li><strong><?php echo $status; ?></strong></li>
                  <li><strong>Final</strong></li>
                  <li><strong>Fecha Hora: </strong><?php echo $FechaHoraFin; ?></li>
                  <li><strong>Cliente: </strong><?php echo $row->customer; ?></li>
                  <li><strong>Observacion: </strong><?php echo $row->Observacion; ?></li>
                </ul>
              </div>
            </td>
          <?php
          }
            
          if($row->Estado == "3"){
            $status = "Distribuido";
          ?>
            <td class="text-info districtDesc"><?php echo $status; ?></td>

            <td class="text-info districtDesc"><?php
              $Blog = $this->Blog_Model->get_by_transaction($row->idTransaction);
          
              foreach ($Blog as $rowBlog){
                echo "<div style='float:left;'>";
                echo "<strong>Accion : </strong>".$rowBlog->Operation."<br>";
                echo "<strong>Inicio: </strong>".$rowBlog->FechaHoraInicio."<br>";
                echo "<strong>Finalizacion: </strong>".$rowBlog->FechaHoraFin."<br>";
                echo "<strong>Duracion: </strong>".$this->Transaction_Model->dateDiff($rowBlog->FechaHoraInicio, $rowBlog->FechaHoraFin)."<br>";
                echo "</div>";
                $FechaHoraInicio = $rowBlog->FechaHoraInicio;
                $FechaHoraFin = $rowBlog->FechaHoraFin;
                $codeBlog = $rowBlog->idBlog;

                $coordinateStart = explode(";", $rowBlog->CoordenadaInicio);
                $coordinateFinish = explode(";", $rowBlog->CoordenadaFin);
              }
                ?>
            </td>
                  <td style="display:none;" class="mapInfo" data-trans="transinfostart-<?php echo $row->idTransaction."-".$codeBlog; ?>" data-coordinate-start="<?php echo $coordinateStart[0]; ?>" data-coordinate-finish="<?php echo $coordinateStart[1]; ?>">
                    <div id="transinfostart-<?php echo $row->idTransaction."-".$codeBlog; ?>" style="display:none;">
                      <ul>
                        <li><strong><?php echo $status; ?></strong></li>
                        <li><strong>Operacion: <?php echo $rowBlog->Operation; ?></strong></li>
                        <li><strong>Fecha Hora: </strong><?php echo $FechaHoraInicio; ?></li>
                        <li><strong>Cliente: </strong><?php echo $row->customer; ?></li>
                        <li><strong>Observacion: </strong><?php echo $row->Observacion; ?></li>
                      </ul>
                    </div>
                  </td>

                  <td style="display:none;" class="mapInfo" data-trans="transinfofinish-<?php echo $row->idTransaction."-".$codeBlog; ?>" data-coordinate-start="<?php echo $coordinateFinish[0]; ?>" data-coordinate-finish="<?php echo $coordinateFinish[1]; ?>">
                    <div id="transinfofinish-<?php echo $row->idTransaction."-".$codeBlog; ?>" style="display:none;">
                      <ul>
                        <li><strong><?php echo $status; ?></strong></li>
                        <li><strong>Operacion: <?php echo $rowBlog->Operation; ?></strong></li>
                        <li><strong>Fecha Hora: </strong><?php echo $FechaHoraFin; ?></li>
                        <li><strong>Cliente: </strong><?php echo $row->customer; ?></li>
                        <li><strong>Observacion: </strong><?php echo $row->Observacion; ?></li>
                      </ul>
                    </div>
                  </td>
                <?php
                            
            ?>
          <?php
          }
            
          if($row->Estado == "4"){
            $status = "Cancelado";
          ?>
            <td class="text-info districtDesc"><?php echo $status; ?></td>

            <td class="text-info districtDesc"><?php
              $Blog = $this->Blog_Model->get_by_transaction($row->idTransaction);
          
              foreach ($Blog as $rowBlog){
                echo "<strong>Inicio: </strong>".$rowBlog->FechaHoraInicio."<br>";
                echo "<strong>Finalizacion: </strong>".$rowBlog->FechaHoraFin."<br>";
                echo "<strong>Duracion: </strong>".$this->Transaction_Model->dateDiff($rowBlog->FechaHoraInicio, $rowBlog->FechaHoraFin)."<br>";
              }             
            ?></td>


          <?php
          }
            
          if($row->Estado == "5"){
            $status = "Transaccion Temporal";
          ?>
            <td class="text-info districtDesc"><?php echo $status; ?></td>

            <td class="text-info districtDesc"><?php
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

            <td style="display:none;" class="mapInfo" data-trans="transinfostart-<?php echo $row->idTransaction."-".$codeBlog; ?>" data-coordinate-start="<?php echo $coordinateStart[0]; ?>" data-coordinate-finish="<?php echo $coordinateStart[1]; ?>">
              <div id="transinfostart-<?php echo $row->idTransaction."-".$codeBlog; ?>" style="display:none;">
                <ul>
                  <li><strong><?php echo $status; ?></strong></li>
                  <li><strong>Inicio</strong></li>
                  <li><strong>Fecha Hora: </strong><?php echo $FechaHoraInicio; ?></li>
                  <li><strong>Cliente: </strong><?php echo $row->customer; ?></li>
                  <li><strong>Observacion: </strong><?php echo $row->Observacion; ?></li>
                </ul>
              </div>
            </td>

            <td style="display:none;" class="mapInfo" data-trans="transinfofinish-<?php echo $row->idTransaction."-".$codeBlog; ?>" data-coordinate-start="<?php echo $coordinateFinish[0]; ?>" data-coordinate-finish="<?php echo $coordinateFinish[1]; ?>">
              <div id="transinfofinish-<?php echo $row->idTransaction."-".$codeBlog; ?>" style="display:none;">
                <ul>
                  <li><strong><?php echo $status; ?></strong></li>
                  <li><strong>Final</strong></li>
                  <li><strong>Fecha Hora: </strong><?php echo $FechaHoraFin; ?></li>
                  <li><strong>Cliente: </strong><?php echo $row->customer; ?></li>
                  <li><strong>Observacion: </strong><?php echo $row->Observacion; ?></li>
                </ul>
              </div>
            </td>

          <?php
          }
            
          if($row->Estado == "6"){
            $status = "Venta Directa";
          ?>
            <td class="text-info districtDesc"><?php echo $status; ?></td>

            <td class="text-info districtDesc"><?php
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

            <td style="display:none;" class="mapInfo" data-trans="transinfostart-<?php echo $row->idTransaction."-".$codeBlog; ?>" data-coordinate-start="<?php echo $coordinateStart[0]; ?>" data-coordinate-finish="<?php echo $coordinateStart[1]; ?>">
              <div id="transinfostart-<?php echo $row->idTransaction."-".$codeBlog; ?>" style="display:none;">
                <ul>
                  <li><strong><?php echo $status; ?></strong></li>
                  <li><strong>Inicio</strong></li>
                  <li><strong>Fecha Hora: </strong><?php echo $FechaHoraInicio; ?></li>
                  <li><strong>Cliente: </strong><?php echo $row->customer; ?></li>
                  <li><strong>Observacion: </strong><?php echo $row->Observacion; ?></li>
                </ul>
              </div>
            </td>

            <td style="display:none;" class="mapInfo" data-trans="transinfofinish-<?php echo $row->idTransaction."-".$codeBlog; ?>" data-coordinate-start="<?php echo $coordinateFinish[0]; ?>" data-coordinate-finish="<?php echo $coordinateFinish[1]; ?>">
              <div id="transinfofinish-<?php echo $row->idTransaction."-".$codeBlog; ?>" style="display:none;">
                <ul>
                  <li><strong><?php echo $status; ?></strong></li>
                  <li><strong>Final</strong></li>
                  <li><strong>Fecha Hora: </strong><?php echo $FechaHoraFin; ?></li>
                  <li><strong>Cliente: </strong><?php echo $row->customer; ?></li>
                  <li><strong>Observacion: </strong><?php echo $row->Observacion; ?></li>
                </ul>
              </div>
            </td>
          <?php
          }
          




          
          if($row->Estado == "7"){
            $status = "Transaccion 0";
          ?>
            <td class="text-info districtDesc"><?php echo $status; ?></td>

            <td class="text-info districtDesc"><?php
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

            <td style="display:none;" class="mapInfo" data-trans="transinfofinish-<?php echo $row->idTransaction."-".$codeBlog; ?>" data-coordinate-start="<?php echo $coordinateFinish[0]; ?>" data-coordinate-finish="<?php echo $coordinateFinish[1]; ?>">
              <div id="transinfofinish-<?php echo $row->idTransaction."-".$codeBlog; ?>" style="display:none;">
                <ul>
                  <li><strong><?php echo $status; ?></strong></li>
                  <li><strong>Fecha Hora: </strong><?php echo $FechaHoraFin; ?></li>
                  <li><strong>Cliente: </strong><?php echo $row->customer; ?></li>
                  <li><strong>Observacion: </strong><?php echo $row->Observacion; ?></li>
                </ul>
              </div>
            </td>
          <?php
          }
        ?>

        <td>
          <div class="btnActionsForm2">
            <?php echo anchor('transaction/products/'.$row->idTransaction, 'Productos', array('class' => 'btn btn-info')); ?>
          
            <!-- Button to trigger modal -->
            <a class="viewSingleMap btn btn-small" data-code="<?php echo $row->idTransaction ?>"><i class="icon-globe"></i> Ver Mapa</a>

            <!-- MAPA Modal -->
            <div id="<?php echo 'singleMapModal-'.$row->idTransaction ?>" class="smallMapModal modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Clientes</h3>
              </div>
              <div class="modal-body mapContainer">
                
              </div>
            </div>
          </div>
        </td>



      </tr>
    <?php } ?>
  </tbody>
</table>