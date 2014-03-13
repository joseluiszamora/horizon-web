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
                  echo form_dropdown('distributor', $distributor, 'large');
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
              <label class="control-label" for="city">Estado</label>
              <div class="controls">
                <?php
                  $options = array(
                    'pendings'    => 'Pendientes',
                    'cancel'    => 'Cancelados',
                    'mora'    => 'En Mora'
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
                  <th class="center">Mora</th>
                  <th class="center">Cliente</th>
                  <th class="center">Voucher</th>
                  <th class="center">Monto</th>
                  <th class="center">Saldo Pendiente</th>
                  <th class="center">Detalle</th>
                </tr>
              </thead>
              <tbody id="diaryTable">

                <?php foreach ($diaries as $row) {
                ?>
                  <tr class="even gradeX">
                    <td class="center"><?php echo $row->FechaTransaction; ?></td>
                    <td class="center"><?php echo "0 dias"; ?></td>
                    <td class="center"><?php echo $row->idCustomer; ?></td>
                    <td class="center"><?php echo $row->NumVoucher; ?></td>
                    <td class="center"><?php echo $row->Monto; ?></td>
                    <td class="center"><?php echo "0"; ?></td>
                    <td class="center"><?php echo $row->Detalle; ?></td>
                  </tr>
                <?php
                  }
                ?>               
              </tbody>
              <tfoot>
                <tr>
                  <th class="center">Fecha de Transacción</th>
                  <th class="center">Mora</th>
                  <th class="center">Cliente</th>
                  <th class="center">Voucher</th>
                  <th class="center">Monto</th>
                  <th class="center">Saldo Pendiente</th>
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
