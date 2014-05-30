<div class="row">
  <div class="span12 titleTop">
    <h1 class="floatLeft">Productos</h1>
  </div>

<?php
  echo form_open('product/save');

  if ($action === "new"){
    echo form_hidden('form_action', "save");
    $pageTitle= "Nuevo Producto en HORIZON";
  }else{
    echo form_hidden('form_action', "edit");
    $pageTitle= "Editar Producto";
  }

  if (isset($idproduct)) echo form_hidden('idproduct', $idproduct);
?>


  <div class="container logincontainer formContainer">
    <div class="span9 offset1">
      <div class="block_head row">
        <h2 class="span4"><?php echo $pageTitle; ?></h2>
      </div>
      <div class="block_content row fields_product">
        <?php echo form_open('product/save'); ?>
          <fieldset>
            <div class="control-group selected_1">
              <label class="control-label" for="codigoProduct">Codigo de Producto</label>
              <div class="controls">
                <?php
                  if (isset($idproduct))
                    echo form_input(array('disabled' => 'disabled', 'name' => 'codigoProduct', 'class' => 'span3', 'value' => $product->idProduct));
                  else
                    echo form_input(array('name' => 'codigoProduct', 'class' => 'span3'), set_value('codigoProduct'));

                  echo form_error('codigoProduct');
                ?>

              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="productname">Nombre del Producto</label>
              <div class="controls">
                <?php
                  if (isset($idproduct))
                    echo form_input(array('name' => 'productname', 'class' => 'span4', 'value' => $product->Nombre));
                  else
                    echo form_input(array('name' => 'productname', 'class' => 'span4'), set_value('productname'));

                  echo form_error('productname');
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="line">Línea</label>
              <div class="controls">
                <?php
                  if (isset($product))
                    echo form_dropdown('line', $lines, $product->idLine);
                  else
                    echo form_dropdown('line', $lines);

                  echo form_error('line');
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="volume">Volumen</label>
              <div class="controls">
                <?php
                  if (isset($product))
                    echo form_dropdown('volume', $linesvolumes, $product->idLineVolume);
                  else
                    echo form_dropdown('volume', $linesvolumes);

                  echo form_error('volume');
                ?>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="price">Precio Unitario (Bs.)</label>
              <div class="controls">
                <?php
                  if (isset($idproduct))
                    echo form_input(array('name' => 'price', 'class' => 'span2', 'value' => $product->PrecioUnit));
                  else
                    echo form_input(array('name' => 'price', 'class' => 'span2'), set_value('price'));

                  echo form_error('price');
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="uxp">Unidades por Paquete</label>
              <div class="controls">
                <?php
                  if (isset($idproduct))
                    echo form_input(array('name' => 'uxp', 'class' => 'span2', 'value' => $product->uxp));
                  else
                    echo form_input(array('name' => 'uxp', 'class' => 'span2'), set_value('uxp'));

                  echo form_error('uxp');
                ?>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="desc">Descripcion</label>
              <div class="controls">
                <?php
                  if (isset($idproduct))
                    echo form_textarea(array('name' => 'desc', 'class' => 'span6 text_area_1', 'rows' => '1', 'cols' => '0', 'value' => $product->Descripcion));
                  else
                    echo form_textarea(array('name' => 'desc', 'class' => 'span6 text_area_1', 'rows' => '1', 'cols' => '0'), set_value('desc'));

                  echo form_error('desc');
                ?>
              </div>
            </div>

            <div class="form-actions span7">
              <input class="btn btn-primary" type="submit" name="submit" value="Guardar" />
              <?php echo anchor('product', 'Cancelar', array('class' => 'btnTitle btn btn-info')); ?>
            </div>
          </fieldset>
      </div>
    </div>
  </div>
</div>
