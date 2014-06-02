<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">Nueva Carga</h3>
  </div>
</div>

<div class="row">
  <div class="col-md-offset-1 col-md-9">

    <?php echo form_open('liquidation/save'); ?>
      <fieldset>
        <div class="form-group col-md-4 col-xs-4">
          <label for="exampleInputEmail1">Distribuidor</label>
          <?php
            echo form_dropdown('distributor', $distributor, '', 'class="chosen-select form-control" ');
          ?>
        </div>

        <div class="form-group col-md-4 col-xs-4">
          <label for="exampleInputEmail1">Ruta</label>
          <select name="route" class="form-control">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
          </select>
        </div>

        <div class="form-group col-md-4 col-xs-4">
          <label for="exampleInputEmail1">Fecha</label>
          <?php 
            echo form_input(array('name' => 'date', 'class' => 'datecontainer datepicker datemedium form-control'));
          ?>
        </div>

        <div class="form-group col-md-4 col-xs-4">
          <label for="exampleInputEmail1">Observaciones</label>
          <?php 
            echo form_textarea(array('name' => 'desc', 'class' => 'form-control', 'rows' => '3', 'cols' => '4'), set_value('desc'));
          ?>
        </div>
        
        <div class="form-group col-md-10 col-xs-10">
          <input type="submit" value="Crear" name="submit" class="btn btn-primary">
          <a class="btnTitle btn btn-info" href="http://localhost/horizon/index.php/user">Cancelar</a>
        </div>
      </fieldset>
    <?php echo form_close(); ?>
  </div>
</div>