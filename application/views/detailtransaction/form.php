<div class="row">
  <div class="span12 titleTop">
    <h1 class="floatLeft">Producto</h1>
  </div>
  
<?php
  echo form_open('detailtransaction/save');

  if ($action === "new"){ 
    echo form_hidden('form_action', "save");
    $pageTitle = "Nuevo Producto";
  }else{  
    echo form_hidden('form_action', "edit");
    $pageTitle = "Editar Producto";
  }

  if (isset($idtransaction)) echo form_hidden('idtransaction', $idtransaction);
?>


 <div class="container logincontainer formContainer">
    <div class="span9 offset1">
      <div class="block_head row">
        <h2 class="span6"><?php echo $pageTitle; ?></h2>
      </div>
      <div class="block_content row">
          <fieldset>  

            <div class="control-group selected_1">
              <label class="control-label" for="product">Linea</label>
              <div class="controls">
                <?php
                  echo form_dropdown('line', $linea);  
                
                  echo form_error('line');
                ?>
                
              </div>  
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="volume">Volumen</label>
              <div class="controls">
                <?php
                  echo form_dropdown('volume', $volumen);  
                
                  echo form_error('volume');
                ?>
                
              </div>  
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="product">Producto</label>
              <div class="controls">
                <?php
                 /* if (isset($idtransaction))
                    echo form_dropdown('product', $products, $transdetail->idProduct);
                  else
                */
                  echo form_dropdown('product', $products);
                
                  echo form_error('product');
                ?>
                
              </div>  
            </div>
 
            <div class="control-group selected_1">
              <label class="control-label" for="name">Cantidad</label>
              <div class="controls">
                <?php
                   /*if (isset($idtransaction))
                    echo form_input(array('name' => 'cantidad', 'class' => 'span3', 'value' => $transdetail->Cantidad));                    
                  else
  */
                    echo form_input(array('name' => 'cantidad', 'class' => 'span3'), set_value('cantidad'));   
  
                  echo form_error('cantidad');
                ?>
                
              </div>  
            </div>   

            <div class="control-group selected_2">
              <label class="control-label" for="obs">Observacion</label>
              <div class="controls">
                <?php
                  /*if (isset($idtransaction))
                    echo form_textarea(array('name' => 'obs', 'class' => 'span4', 'rows' => '1', 'cols' => '0', 'value' => $transaction->Observacion));                    
                  else
*/
                    echo form_textarea(array('name' => 'obs', 'class' => 'span4', 'rows' => '1', 'cols' => '0'), set_value('obs'));

                  echo form_error('obs');
                ?>
              </div>
            </div>
             <div class="control-group selected_1 span5">
              <input class="btn btn-primary" type="submit" name="submit" value="Guardar" />
              <?php echo anchor('transaction/products/'.$idtransaction, 'Cancelar', array('class' => 'btnTitle btn btn-primary')); ?>
            </div>
          </fieldset>
      </div>
    </div>
  </div>
</div>