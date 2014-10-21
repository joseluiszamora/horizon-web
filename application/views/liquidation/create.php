<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">Nueva Carga</h3>
  </div>
</div>


<div class="modal fade" id="modalConfirmSave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<div class="row" >
  <div class="col-md-offset-1 col-md-9 form-horizontal">
      <fieldset>
        <div class="form-group">
          <label for="distributor" class="control-label col-xs-2">Distribuidor</label>
          <div class="col-xs-7">
            <?php echo $distributor; ?>
          </div>
        </div>

        <div class="form-group">
          <label for="date" class="control-label col-xs-2">Fecha</label>
          <div class="col-xs-3">
            <?php
              echo form_input(array('name' => 'date', 'class' => 'datecontainer datepicker datemedium form-control'));
            ?>
          </div>
        </div>

        <div class="form-group">
          <label for="desc" class="control-label col-xs-2">Observaciones</label>
          <div class="col-xs-7">
            <?php
              echo form_textarea(array('name' => 'desc', 'class' => 'form-control', 'rows' => '3', 'cols' => '4'), set_value('desc'));
            ?>
          </div>
        </div>

        <div class="form-group">
          <div class="col-xs-offset-2 col-xs-10">
            <div class="checkbox">
              <label>
                <?php
                  $data = array(
                    'name'        => 'lastliquid',
                    'id'        => 'lastliquid',
                    'value'       => 'accept',
                    'checked'     => TRUE
                  );
                  echo form_checkbox($data);
                ?>
                <b>Cargar la ultima liquidación</b>
              </label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="col-xs-offset-2 col-xs-10">
            <div class="checkbox">
              <label>
                <?php 
                  $data2 = array(
                    'name'        => 'noregularproducts',
                    'id'        => 'noregularproducts',
                    'value'       => 'accept',
                    'checked'     => FALSE
                  );
                  echo form_checkbox($data2);
                ?>
                <b>Desea adicionar productos no regulares?</b>
              </label>
            </div>
          </div>
        </div>

        <div class="form-group" id="noRegularSelect">
          <div class="col-xs-offset-2 col-xs-10">
            <?php
              echo form_dropdown('noregular', $linenoregular, '', 'id="noregulardropdown" data-placeholder="Linea de productos no regulares..." class="chosen-select" multiple style="width:400px;"');
            ?>
          </div>
        </div>

        <div class="form-group">
          <div class="col-xs-offset-2 col-xs-10">
            <input id="saveform" type="submit" value="Crear" name="submit" class="btn btn-primary">

            <?php echo anchor('liquidation', 'Cancelar', array('class'=>'btnTitle btn btn-info')); ?>

          </div>
        </div>

      </fieldset>
  </div>
</div>