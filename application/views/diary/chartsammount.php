<script src="<?php echo base_url(); ?>js/highcharts/highcharts.js"></script>
<script src="<?php echo base_url(); ?>js/data.js"></script>
<script src="<?php echo base_url(); ?>js/exporting.js"></script>




<script type="text/javascript">
  $(function () {
        $('#containerchart').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Montos de Prestamos'
            },
            subtitle: {
                text: 'Prestamos realizados por distribuidores a la fecha'
            },
            xAxis: {
                categories: [
                    'erivero',
                    'esantacruz',
                    'fmarquez',
                    'jpozo',
                    'melias',
                    'itinini',
                    'vsossa',
                    'rcoria'
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Monto (Bs)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} Bs.</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Prestamos',
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5]
    
            }, {
                name: 'Pagado',
                data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3]
    
            }, {
                name: 'Saldo',
                data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6]
    
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
      <!--<div class="block_content row padding0">
         <fieldset>
            <div class="control-group selected_3">
              <label class="control-label" for="city">Distribuidor</label>
              <div class="controls">
                <?php
                  /**$options = array(
                    '1' => 'Pendiente',
                    '2' => 'Pagado/Cancelado',
                    '3' => 'Eliminado'
                  );

                  echo form_dropdown('status', $options, '', 'class="chosen-select" ');*/
                ?>
              </div>
            </div>

            <div class="control-group selected_3">
              <label class="control-label" for="city">Estado</label>
              <div class="controls">
                <?php
                  /*$options = array(
                    '1' => 'Pendiente',
                    '2' => 'Pagado/Cancelado',
                    '3' => 'Eliminado'
                  );

                  if (isset($parameters['status'])) {
                    echo form_dropdown('status', $options, $parameters['status'], 'class="chosen-select" ');
                  }else{
                    echo form_dropdown('status', $options, '', 'class="chosen-select" ');
                  }*/
                ?>
              </div>
            </div>
            
            <div class="control-group selected_1">
              <label class="control-label" for="dateStart">Desde:</label>
              <div class="controls">
                <?php 
                  /*if (isset($parameters['dateStart'])) {
                    echo form_input(array('name' => 'dateStart', 'class' => 'datecontainer datepicker datemedium', 'value' => $parameters['dateStart'])); 
                  }else{
                    echo form_input(array('name' => 'dateStart', 'class' => 'datecontainer datepicker datemedium')); 
                  }*/
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="dateFinish">Hasta:</label>
              <div class="controls">
                <?php
                  /*if (isset($parameters['dateFinish'])) {
                    echo form_input(array('name' => 'dateFinish', 'class' => 'datecontainer datepicker datemedium', 'value' => $parameters['dateFinish'])); 
                  }else{
                    echo form_input(array('name' => 'dateFinish', 'class' => 'datecontainer datepicker datemedium')); 
                  }*/
                ?>
              </div>
            </div>

          <div class="form-actions span7">
            <input class="btn btn-primary" type="submit" name="submit" id="btnSave" value="Buscar" />
            <input id="btn_clean" class="btn btn-primary" type="reset" value="Limpiar" />
          </div>
        </fieldset>
      </div>-->
    </div>
  </div>

  <div class="container formContainer">
    <div class="span10 offset1">
      <div class="block_content row">
        <div id="containerchart" style="min-width: 500px; height: 500px; margin: 0 auto"></div>    
      </div>
    </div>
  </div>

</div>