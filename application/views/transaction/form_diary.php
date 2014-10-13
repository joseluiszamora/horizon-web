<div class="row">
  <div class="span12 titleTop">
    <h1 class="floatLeft">Transacciones</h1>
  </div>
  
<?php

  echo form_open('transaction/save_diary');

  if ($action === "new"){ 
    echo form_hidden('form_action', "save");
    $pageTitle= "Nueva Transaccion en HORIZON";
  }else{  
    echo form_hidden('form_action', "edit");
    $pageTitle= "Editar Transaccion";
  }

  if (isset($idtransaction)) {
    foreach ($transaction as $trans){
      $code =  $this->Client_Model->get_code_by_id($trans->idCustomer);
      $status =  $trans->Estado;
      $obs =  $trans->Observacion;
    }
    echo form_hidden('idtransaction', $idtransaction);
  }
?>


 <div class="container logincontainer formContainer">
    <div class="span9 offset1">
      <div class="block_head row">
        <h2 class="span6"><?php echo $pageTitle; ?></h2>
      </div>
      <div class="block_content row">
          <fieldset>
            <div class="control-group selected_3">
              <label class="control-label" for="code">Codigo de Cliente:</label>
              <div class="controls">
                <?php 
                if (isset($idtransaction)){

                  echo form_input(array('name' => 'code', 'class' => 'span3', 'value' => $code));
                }else{
                  echo form_input(array('name' => 'code', 'class' => 'span3'), set_value('code'));
                }
                echo form_error('code');
                ?>
              </div>
            </div>

            <div class="control-group selected_3">
              <label class="control-label" for="voucher">Numero de factura:</label>
              <div class="controls">
                <?php 
                if (isset($idtransaction)){

                  echo form_input(array('name' => 'voucher', 'class' => 'span3', 'value' => $voucher));
                }else{
                  echo form_input(array('name' => 'voucher', 'class' => 'span3'), set_value('voucher'));
                }
                echo form_error('voucher');
                ?>
              </div>
            </div>

            <div class="control-group selected_3">
              <label class="control-label" for="area">Transaccion</label>
              <div class="controls">
                 <?php
                  $options = array(
                    '1' => 'Preventa',
                    '6' => 'Venta Directa',
                    '7' => 'Transaccion 0'
                  );

                  if (isset($idtransaction)){
                    echo form_dropdown('status', $options, $status);
                  }
                  else
                    echo form_dropdown('status', $options);
                ?>
              </div>
            </div>


            <div class="control-group selected_1">
              <label class="control-label" for="obs">Observacion</label>
              <div class="controls">
                <?php
                 if (isset($idtransaction))
                    echo form_textarea(array('name' => 'obs', 'class' => 'span8', 'rows' => '1', 'cols' => '0', 'value' => $obs));                    
                  else
                    echo form_textarea(array('name' => 'obs', 'class' => 'span8', 'rows' => '1', 'cols' => '0'), set_value('obs'));

                  echo form_error('obs');
                ?>
              </div>
            </div>

            <div class="form-actions span7">
              <input class="btn btn-primary" type="submit" name="submit" value="Guardar" />
              <?php echo anchor('transaction', 'Cancelar', array('class' => 'btnTitle btn btn-info')); ?>
            </div>              
          </fieldset>
      </div>
    </div>
  </div>
</div>
