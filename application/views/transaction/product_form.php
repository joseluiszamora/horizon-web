<div class="span10 offset1">
  <div class="block_head row">
    <h2 class="span6">Nuevo Producto</h2>
  </div>
  <div class="block_content row">
    <?php
      echo form_open('transaction/product_save');

      if ($action === "new"){ 
        echo form_hidden('form_action', "save");
      }else{  
        echo form_hidden('form_action', "edit");
      }

      if (isset($idtransaction)) echo form_hidden('idtransaction', $idtransaction);
    ?>

    <fieldset>  

      <div class="control-group selected_2">
        <label class="control-label" for="product">Producto</label>
        <div class="controls">
          <?php
           /* if (isset($idtransaction))
              echo form_dropdown('product', $products, $transdetail->idProduct);
            else*/
              echo form_dropdown('product', $products);

            echo form_error('product');
          ?>
          
        </div>  
      </div>             

      <div class="control-group selected_2">
        <label class="control-label" for="name">Cantidad</label>
        <div class="controls">
          <?php
           /* if (isset($idtransaction))
              echo form_input(array('name' => 'cantidad', 'class' => 'span3', 'value' => $transdetail->Cantidad));                    
            else*/
              echo form_input(array('name' => 'cantidad', 'class' => 'span3'), set_value('cantidad'));   

            echo form_error('cantidad');
          ?>
          
        </div>  
      </div>   

      <div class="control-group selected_1">
        <label class="control-label" for="obs">Observacion</label>
        <div class="controls">
          <?php
           /*if (isset($idtransaction))
              echo form_textarea(array('name' => 'obs', 'class' => 'span4', 'rows' => '1', 'cols' => '0', 'value' => $transaction->Observacion));                    
            else*/
              echo form_textarea(array('name' => 'obs', 'class' => 'span4', 'rows' => '1', 'cols' => '0'), set_value('obs'));

            echo form_error('obs');
          ?>
        </div>
      </div>

      <div class="control-group selected_1 span5">
        <input class="btn btn-primary" type="submit" name="submit" value="Guardar" />
      </div>

    </fieldset>

  </div>
</div>