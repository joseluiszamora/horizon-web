<div class="row">
  <div class="span12 titleTop">
    <h1 class="floatLeft">Clientes</h1>
  </div>
  
<?php
  echo form_open('client/save');

  if ($action === "new"){ 
    echo form_hidden('form_action', "save");
    $pageTitle= "Nuevo Cliente en HORIZON";
  }else{  
    echo form_hidden('form_action', "edit");
    $pageTitle= "Editar Cliente";
  }

  if (isset($idclient)) {
    echo form_hidden('idclient', $idclient);
    $coordinate = explode(";", $client->Coordenada);
  }
?>

 <div class="container formContainer logincontainer">
    <div class="span9 offset1">
      <div class="block_head row">
        <h2 class="span4"><?php echo $pageTitle; ?></h2>
      </div>
      <div class="block_content row">
          <fieldset>
            <div class="control-group selected_1">
              <label class="control-label" for="name">Nombre del negocio</label>
              <div class="controls">
                <?php
                  if (isset($idclient))
                    echo form_input(array('name' => 'name', 'class' => 'span4', 'value' => $client->NombreTienda));
                  else
                    echo form_input(array('name' => 'name', 'class' => 'span4'), set_value('name'));                    

                  echo form_error('name');
                ?>
                
              </div>  
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="city">Ciudad</label>
              <div class="controls">
                <?php
                  if (isset($idclient))
                    echo form_dropdown('city', $city, $client->idCiudad);
                  else
                    echo form_dropdown('city', $city);

                  echo form_error('city');
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="latitude">Coordenada Latitud:</label>
              <div class="controls">
                <?php
                  if (isset($idclient) && isset($coordinate[0]))
                    echo form_input(array('name' => 'latitude', 'class' => 'span3', 'value' => $coordinate[0]));
                  else
                    echo form_input(array('name' => 'latitude', 'class' => 'span3'), set_value('latitude'));

                  echo form_error('latitude');
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="longitude">Coordenada Longitud:</label>
              <div class="controls">
                <?php
                  if (isset($idclient) && isset($coordinate[1]))
                    echo form_input(array('name' => 'longitude', 'class' => 'span3', 'value' => $coordinate[1]));
                  else
                    echo form_input(array('name' => 'longitude', 'class' => 'span3'), set_value('longitude'));

                  echo form_error('longitude');
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="disctrict">Barrio</label>
              <div class="controls">
                <?php
                  if (isset($idclient)){
                    echo form_dropdown('disctrict', $district, $client->idBarrio);
                  }
                  else
                    echo form_dropdown('disctrict', $district);

                  echo form_error('disctrict');
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="area">Zona</label>
              <div class="controls">
                <?php
                  if (isset($idclient)){
                    $thisarea = $this->Area_Model->get_one_area_for_one_district($client->idBarrio);
                    //print_r($thisarea[0]->idZona);
                    echo form_dropdown('area', $area, $thisarea[0]->idZona);
                  }
                  else
                    echo form_dropdown('area', $area);

                  echo form_error('area');
                ?>
              </div>
            </div>


            <div class="control-group">
              <label class="control-label" for="subarea">Sub Zona</label>
              <div class="controls">
                <?php
                  if (isset($idclient)){
                    //echo $subarea, $client->idSubZona;
                    echo form_dropdown('subarea', $subarea, $client->idSubZona);
                  }
                  else
                    echo form_dropdown('subarea', $subarea);

                  echo form_error('subarea');
                ?>
              </div>
            </div>

            <div class="control-group selected_1" style="margin-right:30px;">
              <label class="control-label" for="manualcode">ZonaGeo de referencia</label>
              <div class="controls">
                <?php
                  if (isset($idclient))
                    echo form_input(array('name' => 'manualcode', 'class' => 'span3', 'value' => $client->Ref0));
                  else
                    echo form_input(array('name' => 'manualcode', 'class' => 'span3'), set_value('manualcode'));

                  echo form_error('manualcode');
                ?>
              </div>
            </div>

            <div class="control-group selected_1" style="margin-right:30px;">
              <label class="control-label" for="usertype">Tipo de Comercio</label>
              <div class="controls">
                <?php
                  if (isset($idclient)){
                    //echo $client->idComercio;
                    echo form_dropdown('commercetype', $commerce, $client->idComercio);
                  }
                  else
                    echo form_dropdown('commercetype', $commerce);

                  echo form_error('commercetype');
                ?>
              </div>
            </div> 

            <div class="control-group">
              <label class="control-label" for="channel">Canal</label>
              <div class="controls">
                <?php
                  if (isset($idclient))
                    echo form_dropdown('channel', $channel, $client->idChannel);
                  else
                    echo form_dropdown('channel', $channel);

                  echo form_error('channel');
                ?>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="address">Direccion</label>
              <div class="controls">
                <?php
                  if (isset($idclient))
                    echo form_textarea(array('name' => 'address', 'class' => 'span8 text_area_1', 'rows' => '1', 'cols' => '0', 'value' => $client->Direccion));                    
                  else
                    echo form_textarea(array('name' => 'address', 'class' => 'span8 text_area_1', 'rows' => '1', 'cols' => '0'), set_value('address'));

                  echo form_error('address');
                ?>                
              </div>
            </div>

            <div class="control-group selected_3">
              <label class="control-label" for="username">Nombre del Encargado</label>
              <div class="controls">                
                <?php
                  if (isset($idclient))
                    echo form_input(array('name' => 'username', 'class' => 'span4', 'value' => $client->NombreContacto));
                  else
                    echo form_input(array('name' => 'username', 'class' => 'span4'), set_value('username'));

                  echo form_error('username');
                ?>                
              </div>  
            </div>
            
            <div class="control-group">
              <label class="control-label" for="email">Email</label>
              <div class="controls">
                <?php
                  if (isset($idclient))
                    echo form_input(array('name' => 'email', 'class' => 'span4', 'value' => $client->Email));          
                  else
                    echo form_input(array('name' => 'email', 'class' => 'span4'), set_value('email'));

                  echo form_error('email');
                ?>
              </div>                
            </div>

            <div class="control-group selected_3">
              <label class="control-label" for="phone">Telefono</label>
              <div class="controls">
                <?php
                  if (isset($idclient))
                    echo form_input(array('name' => 'phone', 'class' => 'span4', 'value' => $client->Telefono));
                  else
                    echo form_input(array('name' => 'phone', 'class' => 'span4'), set_value('phone'));

                  echo form_error('phone');
                ?>
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="cellphone">Celular</label>
              <div class="controls">
                <?php
                  if (isset($idclient))
                    echo form_input(array('name' => 'cellphone', 'class' => 'span4', 'value' => $client->TelfCelular));
                  else
                    echo form_input(array('name' => 'cellphone', 'class' => 'span4'), set_value('cellphone'));

                  echo form_error('cellphone');
                ?>
              </div>
            </div>

            <div class="control-group selected_3">
              <label class="control-label" for="contactop1">otro Contacto</label>
              <div class="controls">
                <?php
                  if (isset($idclient))
                    echo form_input(array('name' => 'contactop1', 'class' => 'span4', 'value' => $client->Contactop01));
                  else
                    echo form_input(array('name' => 'contactop1', 'class' => 'span4'), set_value('contactop1'));

                  echo form_error('contactop1');
                ?>
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="telfcontactop1">Telefono Otro Contacto</label>
              <div class="controls">
                <?php
                  if (isset($idclient))
                    echo form_input(array('name' => 'telfcontactop1', 'class' => 'span4', 'value' => $client->Telfcontop01));
                  else
                    echo form_input(array('name' => 'telfcontactop1', 'class' => 'span4'), set_value('telfcontactop1'));

                  echo form_error('telfcontactop1');
                ?>
              </div>
            </div>

            <div class="control-group selected_3">
              <label class="control-label" for="contactop2">otro Contacto</label>
              <div class="controls">
                <?php
                  if (isset($idclient))
                    echo form_input(array('name' => 'contactop2', 'class' => 'span4', 'value' => $client->Contactop02));
                  else
                    echo form_input(array('name' => 'contactop2', 'class' => 'span4'), set_value('contactop2'));

                  echo form_error('contactop2');
                ?>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="telfcontactop1">Telefono Otro Contacto</label>
              <div class="controls">
                <?php
                  if (isset($idclient))
                    echo form_input(array('name' => 'telfcontactop2', 'class' => 'span4', 'value' => $client->Telfcontop02));
                  else
                    echo form_input(array('name' => 'telfcontactop2', 'class' => 'span4'), set_value('telfcontactop2'));

                  echo form_error('telfcontactop2');
                ?>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="obs">Observaciones</label>
              <div class="controls">
                <?php
                  if (isset($idclient))
                    echo form_textarea(array('name' => 'obs', 'class' => 'span8 text_area_1', 'rows' => '1', 'cols' => '0', 'value' => $client->Observacion));                    
                  else
                    echo form_textarea(array('name' => 'obs', 'class' => 'span8 text_area_1', 'rows' => '1', 'cols' => '0'), set_value('obs'));

                  echo form_error('obs');
                ?>                
              </div>
            </div>

            <div class="form-actions span7">
              <input class="btn btn-primary" type="submit" name="submit" value="Guardar" />
              <?php echo anchor('client', 'Cancelar', array('class' => 'btnTitle btn btn-info')); ?>
            </div>              
          </fieldset>
      </div>
    </div>
  </div>
</div>
