<script type="text/javascript">
/*var baseUrl = '';
var list;

var query = $('#script_base').attr('src').substring($('#script_base').attr('src').indexOf('?')+1);
var parms = query.split('&');
var qsParm = [];
for (var i=0; i<parms.length; i++)
{
    var pos = parms[i].indexOf('=');
    if (pos > 0)
    {
        var key = parms[i].substring(0,pos);
        var val = parms[i].substring(pos+1);
        qsParm[key.toLowerCase()] = val;
    }
}

if(qsParm['baseurl'])
{
    baseUrl = qsParm['baseurl'];
}*/
</script>

<div class="row">
  <div class="span12 titleTop">
    <h1 class="floatLeft">Productos</h1>
    <?php echo anchor('product', 'Cancelar', array('class' => 'btnTitle btn btn-primary')); ?>
  </div>

<?php
  echo form_open('product/save');

  if ($action === "new"){
    echo form_hidden('form_action', "save");
    $pageTitle= "Nuevo Producto en HORIZON";
  }else{
    echo form_hidden('form_action', "edit");
    $pageTitle= "Editar Usuario";
  }

  if (isset($idproduct)) echo form_hidden('idproduct', $idproduct);
?>


  <div class="container logincontainer">
    <div class="span9 offset1">
      <div class="block_head row">
        <h2 class="span4"><?php echo $pageTitle; ?></h2>
      </div>
      <div class="block_content row fields_product">
        <?php echo form_open('product/save'); ?>
          <fieldset>
            <div class="control-group">
              <label class="control-label" for="codigoProduct">Codigo de Producto</label>
              <div class="controls">
                <?php
                  if (isset($idproduct))
                    echo form_input(array('name' => 'codigoProduct', 'class' => 'span5', 'value' => $product->idProduct));
                  else
                    echo form_input(array('name' => 'codigoProduct', 'class' => 'span5'), set_value('codigoProduct'));

                  echo form_error('codigoProduct');
                ?>

              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="productname">Nombre del Producto</label>
              <div class="controls">
                <?php
                  if (isset($idproduct))
                    echo form_input(array('name' => 'productname', 'class' => 'span5', 'value' => $product->Nombre));
                  else
                    echo form_input(array('name' => 'productname', 'class' => 'span5'), set_value('productname'));

                  echo form_error('productname');
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="idLine">Línea</label>
              <div class="controls">
                <?php
                  if (isset($product))
                    echo form_dropdown('idLine', $lines, $product->idLine);
                  else
                    echo form_dropdown('idLine', $lines);

                  echo form_error('idLine');
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="idLineVolume">Volumen</label>
              <div class="controls">
                <?php
                  if (isset($product))
                    echo form_dropdown('idLineVolume', $linesvolumes, $product->idLineVolume);
                  else
                    echo form_dropdown('idLineVolume', $linesvolumes);

                  echo form_error('idLineVolume');
                ?>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="price">Precio Unitario</label>
              <div class="controls">
                <?php
                  if (isset($idproduct))
                    echo form_input(array('name' => 'price', 'class' => 'span5', 'value' => $product->PrecioUnit));
                  else
                    echo form_input(array('name' => 'price', 'class' => 'span5'), set_value('price'));

                  echo form_error('price');
                ?>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="desc">Descripcion</label>
              <div class="controls">
                <?php
                  if (isset($idproduct))
                    echo form_textarea(array('name' => 'desc', 'class' => 'span5 text_area_1', 'rows' => '1', 'cols' => '0', 'value' => $product->Descripcion));
                  else
                    echo form_textarea(array('name' => 'desc', 'class' => 'span5 text_area_1', 'rows' => '1', 'cols' => '0'), set_value('desc'));

                  echo form_error('desc');
                ?>
              </div>
            </div>

            <div class="form-actions span5">
              <input class="btn btn-primary" type="submit" name="submit" value="Guardar" />
            </div>
          </fieldset>
      </div>
    </div>
  </div>
</div>
