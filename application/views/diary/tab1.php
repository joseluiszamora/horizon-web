<script src="<?php echo base_url(); ?>js/jquery.dataTables.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.dataTables_themeroller.css">

<?php
  function dateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
  }

?>

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
                  echo form_dropdown('distributor', $distributor, '', 'class="chosen-select" ');
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
                  echo form_dropdown('type', $options, '', 'class="chosen-select" ');
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
                  echo form_dropdown('type', $options, '', 'class="chosen-select" ');
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
                    <th class="center">Total</th>
                    <th class="center">Saldo</th>
                    <th class="center">Detalle</th>
                    <th class="center">&nbsp;</th>
                  </tr>
                </thead>
                <tbody id="diaryTable">

                  <?php foreach ($diaries as $row) {
                  ?>
                    <tr class="even gradeX">
                      <td class="center"><?php echo $row->FechaTransaction; ?></td>
                      <td class="center"><?php
                        echo dateDiff(date("Y-m-d"), $row->FechaTransaction)." días"; 
                      ?></td>
                      <td class="center"><?php echo $row->idCustomer; ?></td>
                      <td class="center"><?php echo $row->NumVoucher; ?></td>
                      <td class="center"><?php echo $row->Monto; ?></td>
                      <td class="center"><?php echo "0"; ?></td>
                      <td class="center"><?php echo $row->Detalle; ?></td>
                      <td class="center">
                        <!--<input value="Adicionar pago" class="btn btn-primary" id="btnAdd" >-->

                        <!-- Button to trigger modal -->
                        <a href="<?php echo '#modal-'.$row->iddiario ?>" role="button" class="btn btn-primary" data-toggle="modal">Adicionar Pago</a>
                         
                        <!-- Modal -->
                        <div id="<?php echo 'modal-'.$row->iddiario ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">Adicionar Pago</h3>
                          </div>
                          <div class="modal-body">
                            <?php 
                              echo form_open('diary/addpay');
                              echo form_hidden('voucher', $row->NumVoucher);
                            ?>

                              <fieldset>
                                <div class="control-group selected_3">
                                  <label class="control-label" for="voucher">Voucher: </label>
                                  <div class="controls">
                                    <?php echo $row->NumVoucher; ?>
                                  </div>
                                </div>

                                <div class="control-group selected_3">
                                  <label class="control-label" for="ammount">Monto Total: </label>
                                  <div class="controls">
                                    <?php echo $row->Monto; ?>
                                  </div>
                                </div>

                                <div class="control-group selected_3">
                                  <label class="control-label" for="ammount">Monto:</label>
                                  <div class="controls">
                                    <?php
                                      echo form_input(array('name' => 'ammount', 'class' => '', 'value' => '', 'placeholder' => $row->Monto)); 
                                    ?>
                                  </div>
                                </div>
                              </fieldset>

                          </div>
                          <div class="modal-footer">
                            <?php echo anchor('diary', 'Cancelar', array('class' => 'btnTitle btn btn-info')); ?>
                            <input class="btn btn-primary" type="submit" name="submit" id="btnSave" value="Guardar" />
                          </div>
                        </div>
                        <?php echo form_close(); ?>
                      </td>
                    </tr>
                  <?php
                    }
                  ?>               
                </tbody>
                <!--<tfoot>
                  <tr>
                    <th class="center">&nbsp;</th>
                    <th class="center">Fecha de Transacción</th>
                    <th class="center">Mora</th>
                    <th class="center">Cliente</th>
                    <th class="center">Voucher</th>
                    <th class="center">Total</th>
                    <th class="center">Saldo</th>
                    <th class="center">Detalle</th>
                  </tr>
                </tfoot>-->
                <tfoot>
                  <tr>
                    <th class="center">&nbsp;</th>
                    <th><input type="text" name="search_engine" placeholder="fecha" class="search_init span1" /></th>
                    <th><input type="text" name="search_browser" placeholder="mora" class="search_init span1" /></th>
                    <th><input type="text" name="search_platform" placeholder="cliente" class="search_init span1" /></th>
                    <th><input type="text" name="search_version" placeholder="Voucher" class="search_init span1" /></th>
                    <th><input type="text" name="search_grade" placeholder="Total" class="search_init span1" /></th>
                    <th><input type="text" name="search_version" placeholder="Saldo" class="search_init span1" /></th>
                    <th><input type="text" name="search_grade" placeholder="detalle" class="search_init span1" /></th>
                     <th class="center">&nbsp;</th>
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
  var asInitVals = new Array();

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











   /* Formating function for row details */
  function fnFormatDetails ( oTable, nTr ){
    var aData = oTable.fnGetData( nTr );
    
    $.ajax({
      type: "POST",
      url: 'diary/getpays',
      data: 'voucher='+aData[3],
      dataType: 'json',
      cache: false,
      success: function(response) {
        console.log("++++++++++++++++++");
        console.log(response);
      }
    })

    var sOut = '<table cellpadding="5" cellspacing="0" border="0" class="table table-striped table-bordered">';
    sOut +=  '<thead><tr><th class="center">Fecha de Pago</th><th class="center">Monto</th><th class="center">Detalle</th></tr></thead>';
    sOut += '<tbody>';
    sOut += '<tr><td class="center">12/12/2012</td><td class="center">123.54</td><td class="center">ninguna obs</td></tr>';
    sOut += '<tr><td class="center">12/12/2012</td><td class="center">123.54</td><td class="center">ninguna obs</td></tr>';
    sOut += '<tr><td class="center">12/12/2012</td><td class="center">123.54</td><td class="center">ninguna obs</td></tr>';
    sOut += '</tbody>';
    sOut += '<tfoot>';  
    sOut += '<tr><td class="center"><b>Total:</b></td><td class="center">123.45</td><td class="center">&nbsp;</td></tr>';
    sOut += '</tfoot>';
    sOut += '</table>';

    return sOut;
  }

  // add row details
  $(document).ready(function() {
    /*
     * Insert a 'details' column to the table
     */
    var nCloneTh = document.createElement( 'th' );
    var nCloneTd = document.createElement( 'td' );
    nCloneTd.innerHTML = '<img src="<?php echo base_url(); ?>img/details_open.png">';
    nCloneTd.className = "center";
    
    $('#data-table thead tr').each( function () {
      this.insertBefore( nCloneTh, this.childNodes[0] );
    } );
    
    $('#data-table tbody tr').each( function () {
      this.insertBefore(  nCloneTd.cloneNode( true ), this.childNodes[0] );
    } );
    
    /*
     * Initialse DataTables, with no sorting on the 'details' column
     */
    var oTable = $('#data-table').dataTable( {
      "sDom": "<'row'<'span4'l><'span4'f>r>t<'row'<'span4'i><'span4'p>>",
          "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ records por pagina",
            "sZeroRecords": "Ningun dato encontrado",
            "sInfo": "Mostrar _START_ a _END_ ( de _TOTAL_ records )",
            "sInfoEmpty": "Mostrar 0 a 0 de 0 records",
            "sInfoFiltered": "(Filtrado de _MAX_ records)",
            "sSearch": "Buscar:"
          },
          "aoColumnDefs": [
        { "bSortable": false, "aTargets": [ 0 ] }
      ],
      "aaSorting": [[1, 'asc']]
      /*,
      "bVisible": false, "aTargets": [ 3 ]*/
    });
    
    /* Add event listener for opening and closing details
     * Note that the indicator for showing which row is open is not controlled by DataTables,
     * rather it is done here
     */
    $('#data-table tbody td img').click(function () {
      var nTr = $(this).parents('tr')[0];
      if ( oTable.fnIsOpen(nTr) )
      {
        /* This row is already open - close it */
        this.src = "<?php echo base_url(); ?>img/details_open.png";
        oTable.fnClose( nTr );
      } else {
        /* Open this row */
        this.src = "<?php echo base_url(); ?>img/details_close.png";
        oTable.fnOpen( nTr, fnFormatDetails(oTable, nTr), 'details' );
      }
    } );


    /* search input footer */
    $("tfoot input").keyup( function () {
        oTable.fnFilter( this.value, $("tfoot input").index(this) );
      } );
      
      $("tfoot input").each( function (i) {
        asInitVals[i] = this.value;
      } );
      
      $("tfoot input").focus( function () {
        if ( this.className == "search_init" )
        {
          this.className = "";
          this.value = "";
        }
      } );
      
      $("tfoot input").blur( function (i) {
        if ( this.value == "" )
        {
          this.className = "search_init";
          this.value = asInitVals[$("tfoot input").index(this)];
        }
      } );
   
  } );
</script>