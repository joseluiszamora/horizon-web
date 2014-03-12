<div class="row">
  <div class="span12 titleTop">
    <h1 class="floatLeft">Diario</h1>
  </div>
  
  <div class="container formContainer logincontainer">
    <div class="span9 offset1">
      <div class="block_head row">
        <h2 class="span4">Diario</h2>
      </div>
      <div class="block_content row">
          <fieldset>
            
            <div class="control-group selected_3">
              <label class="control-label" for="city">Distribuidor</label>
              <div class="controls">
                <?php
                  $options = array(
                    '1'    => 'Distribuidor',
                    '2'    => 'Distribuidor',
                    '3'    => 'Distribuidor',
                    '4'    => 'Distribuidor',
                    '5'    => 'Distribuidor',
                    '6'    => 'Distribuidor'
                  );

                  echo form_dropdown('distributor', $options, 'large');
                ?>
              </div>
            </div>

            <div class="control-group selected_3">
              <label class="control-label" for="city">Tipo</label>
              <div class="controls">
                <?php
                  $options = array(
                    'credito'  => 'Creditos',
                    'debito'    => 'Debitos'
                  );

                  echo form_dropdown('type', $options, 'large');
                ?>
              </div>
            </div>

            <div class="control-group selected_3">
              <label class="control-label" for="city">Fecha de Transacción</label>
              <div class="controls">
                <?php
                  $options = array(
                    ' '    => ' '
                  );

                  echo form_dropdown('type', $options, 'large');
                ?>
              </div>
            </div>

          </fieldset>
      </div>
    </div>
  </div>


  <div class="container formContainer logincontainer">
    <div class="span9 offset1">
      <div class="block_head row">
        
      </div>
      <div class="block_content row">
          <fieldset>
            <input id="btnAdd" class="btn btn-primary" type="submit"  value="+" />
             <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="data-table" width="100%">
              <thead>
                <tr>
                  <th class="center">Cliente</th>
                  <th class="center">Voucher</th>
                  <th class="center">Monto</th>
                  <th class="center">Detalle</th>
                </tr>
              </thead>
              <tbody id="diaryTable">
                <tr class="even gradeX">
                  <td class="center"><input type="text" class="span2" value="" ></td>
                  <td class="center"><input type="text" class="span2" value="" ></td>
                  <td class="center"><input type="text" class="span2" value="" ></td>
                  <td class="center"><input type="text" class="span2" value="" ></td>
                </tr>
              </tbody>
            </table>

            <div class="form-actions span7">
              <input class="btn btn-primary" type="submit" name="submit" value="Guardar" />
              <?php echo anchor('diary', 'Cancelar', array('class' => 'btnTitle btn btn-info')); ?>
            </div>              
          </fieldset>
      </div>
    </div>
  </div>



</div>
<style type="text/css">
  #btnAdd{
    float: right;
    margin: 0 20px 10px 0;
  }
</style>

<script type="text/javascript">
  var registry = "<tr class='even gradeX'>";
  registry += '<td class="center"> <input type="text" class="span2" value="" ></td> ';
  registry += '<td class="center"> <input type="text" class="span2" value="" ></td> ';
  registry += '<td class="center"> <input type="text" class="span2" value="" ></td> ';
  registry += '<td class="center"> <input type="text" class="span2" value="" ></td> ';
  registry += "</tr>";
  $(document).ready(function(){
    $("#btnAdd").click(function(){
      $("#diaryTable").append(registry);
    });
  });

</script>
