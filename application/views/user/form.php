<script type="text/javascript">
  $(document).ready(function(){
    
    //display or hide dropdowns for filter user
    $('#form_new_user select[name="usertype"]').change(function(){
      $('#form_new_user select[name="area"] > option').remove();
      var idUser = $('#form_new_user select[name="usertype"]').val();

      if(idUser == "1"){
        $('#form_new_user #form_city_container').hide();
        $('#form_new_user #form_area_container').hide();
      }else{
        if(idUser == "2" || idUser == "3"){
          $('#form_new_user #form_city_container').show();
          $('#form_new_user #form_area_container').hide();
        }else{
          $('#form_new_user #form_city_container').show();
          $('#form_new_user #form_area_container').show();
        }
      }
    });

    

  });
</script>
<div class="row">
  <div class="span12 titleTop">
    <h1 class="floatLeft">Usuarios</h1>
  </div>
  
<?php
  echo form_open('user/save');

  if ($action === "new"){ 
    echo form_hidden('form_action', "save");
    $pageTitle= "Nuevo Usuario en HORIZON";
  }else{  
    echo form_hidden('form_action', "edit");
    $pageTitle= "Editar Usuario";
  }

  if (isset($idUser)) echo form_hidden('iduser', $idUser);

  // password change flag
  //echo form_hidden('changepassflag', "false");
?>


  <div class="container logincontainer formContainer"id="form_new_user">
    <div class="span9 offset1">
      <div class="block_head row">
        <h2 class="span4"><?php echo $pageTitle; ?></h2>
      </div>
      <div class="block_content row">     
        <?php echo form_open('user/save'); ?>
          <fieldset>
            <div class="control-group selected_1">
              <label class="control-label" for="usertype">Tipo de Usuario</label>
              <div class="controls">
                <?php
                  if (isset($idUser))
                    echo form_dropdown('usertype', $profile, $user->NivelAcceso);
                  else
                    echo form_dropdown('usertype', $profile);

                  echo form_error('usertype');
                ?>
              </div>
            </div>

            <div class="control-group selected_1" id="form_city_container">
              <label class="control-label" for="city" id="label-city">Ciudad</label>
              <div class="controls">
                <?php
                  if (isset($idUser))
                    echo form_dropdown('city', $city, $user->idCiudadOpe);
                  else
                    echo form_dropdown('city', $city);

                  echo form_error('city');
                ?>
              </div>
            </div>

            <div class="control-group" id="form_area_container">
              <label class="control-label" for="area">Zona</label>
              <div class="controls">
                <?php
                  if (isset($idUser))
                    echo form_dropdown('area', $area, $user->idZona);
                  else
                    echo form_dropdown('area', $area);

                  echo form_error('area');
                ?>
              </div>
            </div>

            <div class="control-group selected_2">
              <label class="control-label" for="ci">Carnet de Identidad</label>
              <div class="controls">
                <?php
                  if (isset($idUser))
                    echo form_input(array('name' => 'ci', 'class' => 'span3', 'value' => $user->ci));                    
                  else
                    echo form_input(array('name' => 'ci', 'class' => 'span3'), set_value('ci'));                    

                  echo form_error('ci');
                ?>
                
              </div>  
            </div>

            <div class="control-group selected_3">
              <label class="control-label" for="username">Nombre(s)</label>
              <div class="controls">                
                <?php
                  if (isset($idUser))
                    echo form_input(array('name' => 'username', 'class' => 'span4', 'value' => $user->Nombre));
                  else
                    echo form_input(array('name' => 'username', 'class' => 'span4'), set_value('username'));

                  echo form_error('username');
                ?>                
              </div>  
            </div>

            <div class="control-group">
              <label class="control-label" for="userlastname">Apellido(s)</label>
              <div class="controls">
                <?php
                  if (isset($idUser))
                    echo form_input(array('name' => 'userlastname', 'class' => 'span4', 'value' => $user->Apellido));                    
                  else
                    echo form_input(array('name' => 'userlastname', 'class' => 'span4'), set_value('userlastname'));

                  echo form_error('userlastname');
                ?>
              </div>  
            </div>

            <div class="control-group selected_2">
              <label class="control-label" for="email">Email</label>
              <div class="controls">
                <?php
                  if (isset($idUser))
                    echo form_input(array('name' => 'email', 'class' => 'span3', 'value' => $user->Email));                    
                  else
                    echo form_input(array('name' => 'email', 'class' => 'span3'), set_value('email'));

                  echo form_error('email');
                ?>
              </div>                
            </div>

            <div class="control-group selected_2">
              <div class="controls">
                <?php
                  if (isset($idUser)){
                    $data = array(
                      'name'        => 'changepass',
                      'id'          => 'changepass',
                      'value'       => 'accept',
                      'checked'     => FALSE,
                      'style'       => 'margin:10px',
                    );
                  }else{
                    $data = array(
                      'name'        => 'changepass',
                      'id'          => 'changepass',
                      'value'       => 'accept',
                      'checked'     => TRUE,
                      'style'       => 'margin:10px',
                    );
                  }
                  echo form_checkbox($data);
                ?>
                Cambiar Password
              </div>
            </div>

            <div class="control-group selected_3">
              <label class="control-label" for="pass">Password</label>
              <div class="controls">
                <?php
                  if (isset($idUser)){
                    echo form_input(array('id' => 'pass', 'type' => 'password', 'name' => 'pass', 'class' => 'span4', 'disabled' => 'disabled', 'value' => $user->Password));
                  }else{
                    echo form_input(array('id' => 'pass', 'type' => 'password', 'name' => 'pass', 'class' => 'span4'), set_value('pass'));
                  }

                  echo form_error('pass');
                ?>
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="password_conf">Confirmar Password</label>
              <div class="controls">
                <?php
                  if (isset($idUser))
                    echo form_input(array('id' => 'repass', 'type' => 'password','name' => 'password_conf', 'class' => 'span4', 'disabled' => 'disabled', 'value' => $user->Password));
                  else
                    echo form_input(array('id' => 'repass', 'type' => 'password', 'name' => 'password_conf', 'class' => 'span4'), set_value('pass'));

                  echo form_error('password_conf');
                ?>                
              </div>               
            </div>
            
            <div class="control-group selected_3">
              <label class="control-label" for="phone">Telefono</label>
              <div class="controls">
                <?php
                  if (isset($idUser))
                    echo form_input(array('name' => 'phone', 'class' => 'span4', 'value' => $user->Telefono));                    
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
                  if (isset($idUser))
                    echo form_input(array('name' => 'cellphone', 'class' => 'span4', 'value' => $user->TelfCelular));                    
                  else
                    echo form_input(array('name' => 'cellphone', 'class' => 'span4'), set_value('cellphone'));

                  echo form_error('cellphone');
                ?>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="obs">Observaciones</label>
              <div class="controls">
                <?php
                  if (isset($idUser))
                    echo form_textarea(array('name' => 'obs', 'class' => 'span8 text_area_1', 'rows' => '1', 'cols' => '0', 'value' => $user->Observacion));                    
                  else
                    echo form_textarea(array('name' => 'obs', 'class' => 'span8 text_area_1', 'rows' => '1', 'cols' => '0'), set_value('obs'));

                  echo form_error('obs');
                ?>                
              </div>
            </div>

            <div class="control-group selected_2">
              <div class="controls">
                <?php
                  if (isset($idUser)){
                    if ($user->Web == '1') {
                      $data = array(
                        'name'        => 'webaccess',
                        'id'          => 'webaccess',
                        'value'       => 'accept',
                        'checked'     => TRUE,
                        'style'       => 'margin:10px',
                      ); 
                    }else{
                      $data = array(
                        'name'        => 'webaccess',
                        'id'          => 'webaccess',
                        'value'       => 'accept',
                        'checked'     => FALSE,
                        'style'       => 'margin:10px',
                      );
                    }
                  }else{
                    $data = array(
                      'name'        => 'webaccess',
                      'id'          => 'webaccess',
                      'value'       => 'accept',
                      'checked'     => FALSE,
                      'style'       => 'margin:10px',
                    );
                  }
                  echo form_checkbox($data);
                ?>
                Permitir acceso Via Web
              </div>
            </div>

            <div class="form-actions span7">
              <input class="btn btn-primary" type="submit" name="submit" value="Guardar" />
               <?php echo anchor('user', 'Cancelar', array('class' => 'btnTitle btn btn-info')); ?>
            </div>              
          </fieldset>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $("#changepass").change(function(){
      console.log($(this));
      if($(this).prop("checked")) {
        console.log("aaaaaaaaaaa check");
        //$("input name:changepassflag").val("true");
        $("#pass").prop('disabled', false);
        $("#repass").prop('disabled', false);
      }
      else {
        console.log("aaaaaaaaaaa no check");
        //$("input name:changepassflag").val("false");
        $("#pass").prop('disabled', "disabled");
        $("#repass").prop('disabled', "disabled");
      }
  });
</script>