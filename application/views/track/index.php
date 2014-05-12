<style>
      html, body, #map-canvas {
        margin: 0;
        padding: 0;
        height: 100%;
      }
    </style>
  
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBK0isvT6X0cAA7ivuiLSf79CViqSacQSU&sensor=true"></script>
    <!--<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBK0isvT6X0cAA7ivuiLSf79CViqSacQSU&sensor=true"></script>-->
    
    <script>

      $(document).ready(function(){
        var positions = [];
        $("#mapslinks .mapInfo").each(function(){
          var coordinatestart = $(this).attr("data-coordinate-start");
          var coordinatefinish = $(this).attr("data-coordinate-finish");

          var datatrans = $(this).attr("data-trans");

          

          if(coordinatestart != null && coordinatestart !="" && coordinatefinish != null && coordinatefinish !="" && coordinatestart != "0.0" && coordinatefinish != "0.0") {
            positions.push(new google.maps.LatLng(coordinatestart, coordinatefinish));
          }
        });

        function initialize() {
        if (positions[0] != null){
          var myLatLng = positions[0];
          var mapOptions = {
            zoom: 14,
            center: myLatLng,
            mapTypeId: google.maps.MapTypeId.TERRAIN
          };
        }else{
          //var myLatLng = new google.maps.LatLng(-16.49901, -68.146248);
          var myLatLng = new google.maps.LatLng(-16.615138, -62.20459);
          var mapOptions = {
            zoom: 6,
            center: myLatLng,
            mapTypeId: google.maps.MapTypeId.TERRAIN
          };
        }

        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        var flightPlanCoordinates = positions;
        /*var flightPlanCoordinates = [
            new google.maps.LatLng(37.772323, -122.214897),
            new google.maps.LatLng(21.291982, -157.821856),
            new google.maps.LatLng(-18.142599, 178.431),
            new google.maps.LatLng(-27.46758, 153.027892)
        ];*/
        var flightPath = new google.maps.Polyline({
          path: flightPlanCoordinates,
          strokeColor: '#FF0000',
          strokeOpacity: 1.0,
          strokeWeight: 2
        });

        flightPath.setMap(map);
      }

      google.maps.event.addDomListener(window, 'load', initialize);
      });



    </script>
    
    <a href="#mapModal" role="button" class="btn btn-primary" data-toggle="modal" style="margin:85px 0 7px 70px">Filtro</a>
    <a href="#mapLastModal" role="button" class="btn btn-primary" data-toggle="modal" style="margin:85px 0 7px 10px">Ultimos Tracks</a>
    <!-- MAPA Modal -->
    <div id="mapModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <h3 id="myModalLabel">Busqueda</h3>
      </div>
      <div class="modal-body mapContainer formContainer" style="float: left; margin: 0; width: 525px;">
        <?php echo form_open('track/search'); ?>
          <fieldset>
            <ul style="list-style-type:none;">
              <li style="float:left; width: 100%;">
                <div class="control-group" style="margin-right:30px;float:left;">
                  <label class="control-label" for="channel">Usuario</label>
                  <div class="controls">
                    <?php echo form_dropdown('searchuser', $user); ?>
                  </div>
                </div>

                <div class="control-group" style="float:left;">
                  <label class="control-label" for="name">Fecha:</label>
                  <div class="controls">
                    <?php echo form_input(array('name' => 'dateStart', 'class' => 'span2 datepicker'), set_value('dateStart')); ?>
                  </div>
                </div>
              </li>
              <li style="float:left;">
                

                <div class="control-group" style="float:left; margin-right:30px;">
                  <label class="control-label" for="name">Hora Inicio:</label>
                  <div class="controls">
                    <?php
                        $options = array(
                          ''  => 'Seleccione Hora',
                          '00:00:00'  => '12:00 AM',
                          '00:30:00'  => '12:30 AM',
                          '01:00:00'  => '1:00 AM',
                          '01:30:00'  => '1:30 AM',
                          '02:00:00'  => '2:00 AM',
                          '02:30:00'  => '2:30 AM',
                          '03:00:00'  => '3:00 AM',
                          '03:30:00'  => '3:30 AM',
                          '04:00:00'  => '4:00 AM',
                          '04:30:00'  => '4:30 AM',
                          '05:00:00'  => '5:00 AM',
                          '05:30:00'  => '5:30 AM',
                          '06:00:00'  => '6:00 AM',
                          '06:30:00'  => '6:30 AM',
                          '07:00:00'  => '7:00 AM',
                          '07:30:00'  => '7:30 AM',
                          '08:00:00'  => '8:00 AM',
                          '08:30:00'  => '8:30 AM',
                          '09:00:00'  => '9:00 AM',
                          '09:30:00'  => '9:30 AM',
                          '10:00:00'  => '10:00 AM',
                          '10:30:00'  => '10:30 AM',
                          '11:00:00'  => '11:00 AM',
                          '11:30:00'  => '11:30 AM',
                          '12:00:00'  => '12:00 PM',
                          '12:30:00'  => '12:30 PM',
                          '13:00:00'  => '1:00 PM',
                          '13:30:00'  => '1:30 PM',
                          '14:00:00'  => '2:00 PM',
                          '14:30:00'  => '2:30 PM',
                          '15:00:00'  => '3:00 PM',
                          '15:30:00'  => '3:30 PM',
                          '16:00:00'  => '4:00 PM',
                          '16:30:00'  => '4:30 PM',
                          '17:00:00'  => '5:00 PM',
                          '17:30:00'  => '5:30 PM',
                          '18:00:00'  => '6:00 PM',
                          '18:30:00'  => '6:30 PM',
                          '19:00:00'  => '7:00 PM',
                          '19:30:00'  => '7:30 PM',
                          '20:00:00'  => '8:00 PM',
                          '20:30:00'  => '8:30 PM',
                          '21:00:00'  => '9:00 PM',
                          '21:30:00'  => '9:30 PM',
                          '22:00:00'  => '10:00 PM',
                          '22:30:00'  => '10:30 PM',
                          '23:00:00'  => '11:00 PM',
                          '23:30:00'  => '11:30 PM'
                        );
                        echo form_dropdown('startHour', $options);
                        echo form_error('startHour');
                      ?>
                  </div>
                </div>
                <div class="control-group " style="float:left;">
                  <label class="control-label" for="name">Hora Final:</label>
                  <div class="controls">
                    <?php 
                        $options = array(
                          ''  => 'Seleccione Hora',
                          '00:00:00'  => '12:00 AM',
                          '00:30:00'  => '12:30 AM',
                          '01:00:00'  => '1:00 AM',
                          '01:30:00'  => '1:30 AM',
                          '02:00:00'  => '2:00 AM',
                          '02:30:00'  => '2:30 AM',
                          '03:00:00'  => '3:00 AM',
                          '03:30:00'  => '3:30 AM',
                          '04:00:00'  => '4:00 AM',
                          '04:30:00'  => '4:30 AM',
                          '05:00:00'  => '5:00 AM',
                          '05:30:00'  => '5:30 AM',
                          '06:00:00'  => '6:00 AM',
                          '06:30:00'  => '6:30 AM',
                          '07:00:00'  => '7:00 AM',
                          '07:30:00'  => '7:30 AM',
                          '08:00:00'  => '8:00 AM',
                          '08:30:00'  => '8:30 AM',
                          '09:00:00'  => '9:00 AM',
                          '09:30:00'  => '9:30 AM',
                          '10:00:00'  => '10:00 AM',
                          '10:30:00'  => '10:30 AM',
                          '11:00:00'  => '11:00 AM',
                          '11:30:00'  => '11:30 AM',
                          '12:00:00'  => '12:00 PM',
                          '12:30:00'  => '12:30 PM',
                          '13:00:00'  => '1:00 PM',
                          '13:30:00'  => '1:30 PM',
                          '14:00:00'  => '2:00 PM',
                          '14:30:00'  => '2:30 PM',
                          '15:00:00'  => '3:00 PM',
                          '15:30:00'  => '3:30 PM',
                          '16:00:00'  => '4:00 PM',
                          '16:30:00'  => '4:30 PM',
                          '17:00:00'  => '5:00 PM',
                          '17:30:00'  => '5:30 PM',
                          '18:00:00'  => '6:00 PM',
                          '18:30:00'  => '6:30 PM',
                          '19:00:00'  => '7:00 PM',
                          '19:30:00'  => '7:30 PM',
                          '20:00:00'  => '8:00 PM',
                          '20:30:00'  => '8:30 PM',
                          '21:00:00'  => '9:00 PM',
                          '21:30:00'  => '9:30 PM',
                          '22:00:00'  => '10:00 PM',
                          '22:30:00'  => '10:30 PM',
                          '23:00:00'  => '11:00 PM',
                          '23:30:00'  => '11:30 PM'
                        );

                        echo form_dropdown('startFinish', $options);
                        echo form_error('startFinish');
                      ?>
                  </div>
                </div>
              </li>
            </ul>
            <div class="form-actions span4">
              <input class="btn btn-primary" type="submit" name="submit" value="Buscar" />
              <input id="btn_clean" class="btn btn-primary" type="reset" value="Limpiar" >
            </div>
          </fieldset>
        <?php echo form_close(); ?>
      </div>
    </div>




    <!-- MAPA Modal -->
    <div id="mapLastModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <h3 id="myModalLabel">Busqueda</h3>
      </div>
      <div class="modal-body mapContainer" style="float: left; margin: 0; width: 525px;">
        <?php echo form_open('track/last'); ?>
          <fieldset>
            <ul style="list-style-type:none;">
              <li style="float:left; width: 100%;">
                <div class="control-group" style="margin-right:30px;float:left;">
                  <label class="control-label" for="channel">Ultimos Tracks</label>
                  <div class="controls">
                    <?php echo form_dropdown('searchuser', $user); ?>
                  </div>
                </div>
              </li>
            </ul>
            <div class="form-actions span4">
              <input class="btn btn-primary" type="submit" name="submit" value="Buscar" />
              <input id="btn_clean" class="btn btn-primary" type="reset" value="Limpiar" >
            </div>
          </fieldset>
        <?php echo form_close(); ?>
      </div>
    </div>



            <table style="display:none;" id="mapslinks">
            <?php foreach ($track as $row) { 
              $coord = explode(' ', $row->Coordenada);
              $latitude = $coord[0];
              $longitude = $coord[1];
              if ($latitude !="0.0" && $longitude !="0.0"){
            ?>
            <tr style="display:none;">
              <td data-coordinate-finish="<?php echo $longitude; ?>" 
              data-coordinate-start="<?php echo $latitude; ?>" data-trans="transinfostart-2-2" class="mapInfo" style="display:none;">
              </td>
            </tr>
            <?php }} ?>
            </table>

<div id="map-canvas"></div>
