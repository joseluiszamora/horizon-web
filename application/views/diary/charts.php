<script src="<?php echo base_url(); ?>js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>js/data.js"></script>
<script src="<?php echo base_url(); ?>js/exporting.js"></script>




<script type="text/javascript">
  $(function () {
    $('#containerchart').highcharts({
      title: {
        text: 'Monthly Average Temperature',
        x: -100 //center
      },
      subtitle: {
        text: 'Source: WorldClimate.com',
        x: -20
      },
      xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Jen', 'jin', 'Jon']
      },
      yAxis: {
        title: {
            text: 'Temperature (°C)'
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
      },
      tooltip: {
        valueSuffix: '°C'
      },
      legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        borderWidth: 0
      },
      series: [{
        name: 'Tokyo',
        data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
      }, {
        name: 'New York',
        data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
      }, {
        name: 'Berlin',
        data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
      }, {
        name: 'London',
        data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
      }, {
        name: 'La Paz',
        data: [20.9, 20.2, 20.7, 20.5, 20.9, 20.2, 20.0, 20.6, 20.2, 20.3, 20.6, 20.8]
      }, {
        name: 'Santa Cruz',
        data: [0.9, 0.2, 0.7, 0.5, 0.9, 0.2, 0.0]
      }]
    });
  });
</script>

<div class="row" style="overflow:hidden;">
  <div class="container formContainer logincontainer">
    <div class="span9 offset1">
      <div class="block_head row">
        <h2 class="span4">Diario</h2>
      </div>
      <div class="block_content row padding0">
          <fieldset>
            <div class="control-group selected_3">
              <label class="control-label" for="city">Distribuidor</label>
              <div class="controls">
                <?php
                  $options = array(
                    '1' => 'Pendiente',
                    '2' => 'Pagado/Cancelado',
                    '3' => 'Eliminado'
                  );

                  echo form_dropdown('status', $options, '', 'class="chosen-select" ');
                ?>
              </div>
            </div>

            <div class="control-group selected_3">
              <label class="control-label" for="city">Estado</label>
              <div class="controls">
                <?php
                  $options = array(
                    '1' => 'Pendiente',
                    '2' => 'Pagado/Cancelado',
                    '3' => 'Eliminado'
                  );

                  if (isset($parameters['status'])) {
                    echo form_dropdown('status', $options, $parameters['status'], 'class="chosen-select" ');
                  }else{
                    echo form_dropdown('status', $options, '', 'class="chosen-select" ');
                  }
                ?>
              </div>
            </div>
            
            <div class="control-group selected_1">
              <label class="control-label" for="dateStart">Desde:</label>
              <div class="controls">
                <?php 
                  if (isset($parameters['dateStart'])) {
                    echo form_input(array('name' => 'dateStart', 'class' => 'datecontainer datepicker datemedium', 'value' => $parameters['dateStart'])); 
                  }else{
                    echo form_input(array('name' => 'dateStart', 'class' => 'datecontainer datepicker datemedium')); 
                  }
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="dateFinish">Hasta:</label>
              <div class="controls">
                <?php
                  if (isset($parameters['dateFinish'])) {
                    echo form_input(array('name' => 'dateFinish', 'class' => 'datecontainer datepicker datemedium', 'value' => $parameters['dateFinish'])); 
                  }else{
                    echo form_input(array('name' => 'dateFinish', 'class' => 'datecontainer datepicker datemedium')); 
                  }
                ?>
              </div>
            </div>

          <div class="form-actions span7">
            <input class="btn btn-primary" type="submit" name="submit" id="btnSave" value="Buscar" />
            <input id="btn_clean" class="btn btn-primary" type="reset" value="Limpiar" />
          </div>
        </fieldset>
      </div>
    </div>
  </div>

  <div class="container formContainer">
    <div class="span10 offset1">
      <div class="block_content row">
          
      </div>
    </div>
  </div>


</div>
<div id="containerchart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>