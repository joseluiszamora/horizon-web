<script src="<?php echo base_url(); ?>js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.dataTables_themeroller.css">

<script type="text/javascript">
  $(document).ready(function() {
    $('#data-table').dataTable( {
          "sDom": "<'row'<'span4'l><'span4'f>r>t<'row'<'span4'i><'span4'p>>",
          "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ records por pagina",
            "sZeroRecords": "Ningun dato encontrado",
            "sInfo": "Mostrar _START_ a _END_ ( de _TOTAL_ records )",
            "sInfoEmpty": "Mostrar 0 a 0 de 0 records",
            "sInfoFiltered": "(Filtrado de _MAX_ records)"
          }
      } );
  } );
</script>


<div class="row" style="overflow:hidden;">
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
              <label class="control-label" for="city">otro parametro</label>
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
      <div class="block_content row">
          <fieldset>
             <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="data-table" width="100%">
              <thead>
                <tr>
                  <th class="center">Fecha de Transacción</th>
                  <th class="center">Cliente</th>
                  <th class="center">Voucher</th>
                  <th class="center">Monto</th>
                  <th class="center">Detalle</th>
                </tr>
              </thead>
              <tbody id="diaryTable">
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 1</td>
                  <td class="center">23456</td>
                  <td class="center">124,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 2</td>
                  <td class="center">1236789</td>
                  <td class="center">256.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 3</td>
                  <td class="center">1236025</td>
                  <td class="center">6,589.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 4</td>
                  <td class="center">195874</td>
                  <td class="center">5,487.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 5</td>
                  <td class="center">130258</td>
                  <td class="center">1.265.258.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 6</td>
                  <td class="center">87459</td>
                  <td class="center">1.025.12.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 7</td>
                  <td class="center">18475</td>
                  <td class="center">562.140.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 8</td>
                  <td class="center">79315</td>
                  <td class="center">123,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 9</td>
                  <td class="center">805020</td>
                  <td class="center">123,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 1</td>
                  <td class="center">23456</td>
                  <td class="center">124,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 2</td>
                  <td class="center">1236789</td>
                  <td class="center">256.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 3</td>
                  <td class="center">1236025</td>
                  <td class="center">6,589.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 4</td>
                  <td class="center">195874</td>
                  <td class="center">5,487.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 5</td>
                  <td class="center">130258</td>
                  <td class="center">1.265.258.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 6</td>
                  <td class="center">87459</td>
                  <td class="center">1.025.12.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 7</td>
                  <td class="center">18475</td>
                  <td class="center">562.140.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 8</td>
                  <td class="center">79315</td>
                  <td class="center">123,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 9</td>
                  <td class="center">805020</td>
                  <td class="center">123,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 1</td>
                  <td class="center">23456</td>
                  <td class="center">124,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 2</td>
                  <td class="center">1236789</td>
                  <td class="center">256.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 3</td>
                  <td class="center">1236025</td>
                  <td class="center">6,589.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 4</td>
                  <td class="center">195874</td>
                  <td class="center">5,487.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 5</td>
                  <td class="center">130258</td>
                  <td class="center">1.265.258.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 6</td>
                  <td class="center">87459</td>
                  <td class="center">1.025.12.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 7</td>
                  <td class="center">18475</td>
                  <td class="center">562.140.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 8</td>
                  <td class="center">79315</td>
                  <td class="center">123,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 9</td>
                  <td class="center">805020</td>
                  <td class="center">123,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 1</td>
                  <td class="center">23456</td>
                  <td class="center">124,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 2</td>
                  <td class="center">1236789</td>
                  <td class="center">256.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 3</td>
                  <td class="center">1236025</td>
                  <td class="center">6,589.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 4</td>
                  <td class="center">195874</td>
                  <td class="center">5,487.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 5</td>
                  <td class="center">130258</td>
                  <td class="center">1.265.258.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 6</td>
                  <td class="center">87459</td>
                  <td class="center">1.025.12.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 7</td>
                  <td class="center">18475</td>
                  <td class="center">562.140.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 8</td>
                  <td class="center">79315</td>
                  <td class="center">123,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 9</td>
                  <td class="center">805020</td>
                  <td class="center">123,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 1</td>
                  <td class="center">23456</td>
                  <td class="center">124,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 2</td>
                  <td class="center">1236789</td>
                  <td class="center">256.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 3</td>
                  <td class="center">1236025</td>
                  <td class="center">6,589.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 4</td>
                  <td class="center">195874</td>
                  <td class="center">5,487.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 5</td>
                  <td class="center">130258</td>
                  <td class="center">1.265.258.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 6</td>
                  <td class="center">87459</td>
                  <td class="center">1.025.12.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 7</td>
                  <td class="center">18475</td>
                  <td class="center">562.140.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 8</td>
                  <td class="center">79315</td>
                  <td class="center">123,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 9</td>
                  <td class="center">805020</td>
                  <td class="center">123,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 1</td>
                  <td class="center">23456</td>
                  <td class="center">124,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 2</td>
                  <td class="center">1236789</td>
                  <td class="center">256.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 3</td>
                  <td class="center">1236025</td>
                  <td class="center">6,589.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 4</td>
                  <td class="center">195874</td>
                  <td class="center">5,487.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 5</td>
                  <td class="center">130258</td>
                  <td class="center">1.265.258.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 6</td>
                  <td class="center">87459</td>
                  <td class="center">1.025.12.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 7</td>
                  <td class="center">18475</td>
                  <td class="center">562.140.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 8</td>
                  <td class="center">79315</td>
                  <td class="center">123,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 9</td>
                  <td class="center">805020</td>
                  <td class="center">123,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 1</td>
                  <td class="center">23456</td>
                  <td class="center">124,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 2</td>
                  <td class="center">1236789</td>
                  <td class="center">256.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 3</td>
                  <td class="center">1236025</td>
                  <td class="center">6,589.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 4</td>
                  <td class="center">195874</td>
                  <td class="center">5,487.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 5</td>
                  <td class="center">130258</td>
                  <td class="center">1.265.258.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 6</td>
                  <td class="center">87459</td>
                  <td class="center">1.025.12.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 7</td>
                  <td class="center">18475</td>
                  <td class="center">562.140.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 8</td>
                  <td class="center">79315</td>
                  <td class="center">123,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 9</td>
                  <td class="center">805020</td>
                  <td class="center">123,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 1</td>
                  <td class="center">23456</td>
                  <td class="center">124,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 2</td>
                  <td class="center">1236789</td>
                  <td class="center">256.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 3</td>
                  <td class="center">1236025</td>
                  <td class="center">6,589.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 4</td>
                  <td class="center">195874</td>
                  <td class="center">5,487.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 5</td>
                  <td class="center">130258</td>
                  <td class="center">1.265.258.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 6</td>
                  <td class="center">87459</td>
                  <td class="center">1.025.12.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 7</td>
                  <td class="center">18475</td>
                  <td class="center">562.140.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 8</td>
                  <td class="center">79315</td>
                  <td class="center">123,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 9</td>
                  <td class="center">805020</td>
                  <td class="center">123,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 1</td>
                  <td class="center">23456</td>
                  <td class="center">124,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 2</td>
                  <td class="center">1236789</td>
                  <td class="center">256.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">10/14/2014</td>
                  <td class="center">Cliente 3</td>
                  <td class="center">1236025</td>
                  <td class="center">6,589.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 4</td>
                  <td class="center">195874</td>
                  <td class="center">5,487.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 5</td>
                  <td class="center">130258</td>
                  <td class="center">1.265.258.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">11/14/2014</td>
                  <td class="center">Cliente 6</td>
                  <td class="center">87459</td>
                  <td class="center">1.025.12.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 7</td>
                  <td class="center">18475</td>
                  <td class="center">562.140.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 8</td>
                  <td class="center">79315</td>
                  <td class="center">123,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
                <tr class="even gradeX">
                  <td class="center">12/14/2014</td>
                  <td class="center">Cliente 9</td>
                  <td class="center">805020</td>
                  <td class="center">123,25.00</td>
                  <td class="center">observaciones</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th class="center">Fecha de Transacción</th>
                  <th class="center">Cliente</th>
                  <th class="center">Voucher</th>
                  <th class="center">Monto</th>
                  <th class="center">Detalle</th>
                </tr>
              </tfoot>
            </table>

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
