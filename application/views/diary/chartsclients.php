<script src="<?php echo base_url(); ?>js/jquery.dataTables.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.dataTables_themeroller.css">

<?php
  function dateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $start_ts - $end_ts;
    $diff = round($diff / 86400);
    if ($diff < 0)
      $diff = 0;
    return $diff;
  }

?>

<div class="row" style="overflow:hidden;">
  <div class="container formContainer logincontainer">
    <div class="span9 offset1">
      <div class="block_head row">
        <h2 class="span4">Diario</h2>
      </div>
      <div class="block_content row padding0">
          <?php echo form_open('diary/search'); 
          ?>

          <fieldset>
            <div class="control-group selected_3">
              <label class="control-label" for="city">Distribuidor</label>
              <div class="controls">
                <?php
                  if (isset($parameters['distributor'])) {
                    echo form_dropdown('distributor', $distributor, $parameters['distributor'], 'class="chosen-select" ');
                  }else{
                    echo form_dropdown('distributor', $distributor, '', 'class="chosen-select" ');
                  }
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
            <?php echo anchor('diary', 'Limpiar', array('class' => 'btn btn-primary')); ?>

            <div class="btnPDF">
              <?php echo form_close(); ?>
              <?php echo form_open('diary/pdf'); ?>
              <?php echo form_hidden('parameters', $search_parameters); ?>
              <?php echo form_submit('send', 'PDF'); ?>
              <?php echo form_close(); ?>
            </div>
          </div>
        </fieldset>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="span10 offset1">
      <div class="block_content row">
          <fieldset>
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="data-table" width="100%">
                <thead>
                  <tr>
                    <th class="center" colspan="5"></th>
                    <th class="center" colspan="2">Total: <span class="alert resalt">
                      <?php echo $this->Diary_Model->roundnumber($total[0]->saldo, 2); ?>
                    </span></th>
                    <th class="center" colspan="2">Saldo: <span class="alert resalt">
                      <?php echo $this->Diary_Model->roundnumber($total[0]->saldo - $saldo[0]->saldo, 2); ?>
                    </span></th>
                    <th class="center"  colspan="3">&nbsp;</th>
                  </tr>
                  <tr>
                    <th class="center">Transacción</th>
                    <th class="center">Fecha</th>
                    <th class="center">Mora(Dias)</th>
                    <th class="center">Distribuidor</th>
                    <th class="center">Cliente</th>
                    <th class="center">Recibo</th>
                    <th class="center">Total</th>
                    <th class="center">Saldo</th>
                    <th class="center">Origen</th>
                    <!--<th class="center">Detalle</th>-->
                    <th class="center">&nbsp;</th>
                    <th class="center">&nbsp;</th>
                  </tr>
                </thead>
                <tbody id="diaryTable">
                  <?php 
                    foreach ($diaries as $row) {
                      
                      $data_in['idTransaction'] = $row->idTransaction;
                      $data_in['idCustomer'] = $row->idCustomer;

                      $pagado = $this->Diary_Model->get_all_pay_for($data_in);                      
                      $saldo = $row->Monto - $pagado;

                      $moradate = dateDiff(date("Y-m-d"), $row->FechaTransaction);
                  ?>
                    <tr class="even gradeX">
                      <td class="center">
                        <?php echo $row->idTransaction; ?>
                      </td>
                      <td class="center"><?php echo $row->FechaTransaction; ?></td>
                      <td class="center"><?php echo $moradate; ?></td>
                      <td class="center"><?php echo $row->customer; ?></td>
                      <td class="center"><?php echo $row->code." - ".$row->custname; ?></td>
                      <td class="center"><?php echo $row->NumVoucher; ?></td>
                      <td class="center"><?php echo $this->Diary_Model->roundnumber($row->Monto, 2); ?></td>
                      <td class="center"><?php echo $this->Diary_Model->roundnumber($saldo, 2); ?></td>
                      <td class="center"><?php 
                      if ($row->Origen == "A") {
                        echo "Android";
                      }else{
                        echo "Web";
                      }
                      ?></td>
                      <!--<td class="center"><?php //echo $row->Detalle; ?></td>-->
                      <td class="center">
                        <!--<input value="Adicionar pago" class="btn btn-primary" id="btnAdd" >-->
                      
                      <?php if($saldo > 0 && $row->Estado == "1"){ ?>
                        <!-- Button to trigger modal -->
                        <a href="<?php echo '#modal-'.$row->iddiario ?>" role="button" class="btn btn-primary" data-toggle="modal">+ Pago</a>
                        
                      <?php } ?>
                         
                        <!-- Modal -->
                        <div id="<?php echo 'modal-'.$row->iddiario ?>" class="modal hide fade modaladdpay" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">Adicionar Pago</h3>
                          </div>
                          <div class="modal-body container_form_no_margin">
                            <?php 
                              $attributes = array('class' => 'formaddpay');

                              echo form_open('diary/addpay', $attributes);
                              //echo form_hidden('voucher', $row->NumVoucher);
                              echo form_hidden('idCustomer', $row->idCustomer);
                              echo form_hidden('distributor', $row->idCustomer);
                              echo form_hidden('client', $row->idUser);
                              echo form_hidden('transaction', $row->idTransaction);
                            ?>

                              <fieldset>
                                <legend><?php echo $row->code." - ".$row->custname; ?></legend>

                                <div class="row logincontainer">
                                  <div class="control-group span3">
                                    <span class="label label-info font15">Recibo N.: <bold><?php echo $row->NumVoucher; ?></bold> </span>
                                  </div>

                                  <div class="control-group span3">
                                    <span class="label label-info font15">Monto Total: <bold><?php echo $this->Diary_Model->roundnumber($row->Monto, 2); ?></bold> </span>
                                  </div>

                                  <div class="control-group span2">
                                    <span class="label label-info font15">Saldo: <bold><?php echo $this->Diary_Model->roundnumber($saldo, 2); ?></bold> </span>
                                  </div>                                  
                                </div>

                                <div class="well well-small row logincontainer">
                                    <div class="control-group span2">
                                      <label class="control-label" for="voucher">Factura:</label>
                                      <div class="controls">
                                        <?php 
                                          echo form_input(array('name' => 'voucher', 'id' => 'voucher', 'class' => 'span1', 'value' => '')); 
                                        ?>
                                      </div>
                                    </div>

                                    <div class="control-group span2">
                                      <label class="control-label" for="date">Fecha:</label>
                                      <div class="controls">
                                        <?php 
                                          echo form_input(array('name' => 'date', 'class' => 'datecontainer datepicker datemedium', 'value' => date("Y-m-d")));
                                        ?>
                                      </div>
                                    </div>
                                    
                                    <div class="control-group span3">
                                      <label class="control-label" for="ammount">Monto (Max: <?php echo $this->Diary_Model->roundnumber($saldo, 2); ?>):</label>
                                      <div class="controls">
                                        <input type="text" max="<?php echo $this->Diary_Model->roundnumber($saldo, 2); ?>" class="ammountfield money" value="" name="ammount" id="ammount" required/><br>
                                      </div>
                                    </div>

                                    <div class="control-group span6">
                                      <label class="control-label" for="ammount">Detalle:</label>
                                      <div class="controls">
                                        <?php
                                          echo form_textarea(array('name' => 'detail', 'class' => 'span3', 'rows' => '2', 'cols' => '10'));
                                        ?>
                                      </div>
                                    </div> 
                                </div>
                              </fieldset>
                              <?php echo form_close(); ?>

                              <div class="alert">Pagos Pendientes</div>
                              <div class="paypendings">
                                  <div class="head">
                                    <div class="pp1">Fecha(Transacción)</div>
                                    <div class="pp2">Recibo</div>
                                    <div class="pp3">Total</div>
                                    <div class="pp4">Detalle</div>
                                  </div>
                                  <div class="body">
                                    <?php 
                                      foreach ($diaries as $rowx) {
                                        if ($rowx->code == $row->code && $rowx->iddiario != $row->iddiario ) {
                                    ?>
                                      <div class="pp1"><?php echo $rowx->FechaTransaction; ?> </div>
                                      <div class="pp2"><?php echo $rowx->NumVoucher; ?> </div>
                                      <div class="pp3"><?php echo $this->Diary_Model->roundnumber($rowx->Monto, 2); ?> </div>
                                      <div class="pp4"><?php echo $rowx->Detalle; ?> </div>
                                    <?php
                                        }
                                      }
                                    ?>
                                  </div>
                                </div>
                          </div>
                          <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                            <button class="btn btn-primary btnSaveAddPay">Guardar</button>
                          </div>
                        </div>
                       
                      </td>
                      <td class="center">
                        <?php 
                          if ($row->Estado != "3") {
                            if($this->Account_Model->get_profile() == '1' || $this->Account_Model->get_profile() == '2' || $this->Account_Model->get_profile() == '3') { ?>
                            <a href="<?php echo '#modal-delete-'.$row->iddiario; ?>" role="button" class="btn btn-primary" data-toggle="modal">X</a>
                            <!-- Modal -->
                            <div id="<?php echo 'modal-delete-'.$row->iddiario;?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h3 id="myModalLabel">Desactivar</h3>
                              </div>
                              <div class="modal-body">
                                <p>Esta seguro que desea Desactivar ?</p>
                              </div>
                              <div class="modal-footer">
                                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                <?php echo anchor('diary/deactive/'.$row->iddiario, 'Desactivar', array('class' => 'btn btn-primary')); ?>
                              </div>
                            </div>
                        <?php }} ?>
                      </td>
                    </tr>
                  <?php
                    }
                  ?>               
                </tbody>
                <tfoot>
                  <tr>
                    <th class="center">&nbsp;</th>
                    <th class="center">Transacción</th>
                    <th class="center">Fecha</th>
                    <th class="center">Mora</th>
                    <th class="center">Distribuidor</th>
                    <th class="center">Cliente</th>
                    <th class="center">Recibo</th>
                    <th class="center">Total</th>
                    <th class="center">Saldo</th>
                    <th class="center">Origen</th>
                    <th class="center">&nbsp;</th>
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


  /* Formating function for row details */
  function fnFormatDetails ( oTable, nTr ){
    var aData = oTable.fnGetData( nTr );
    
    var sOut = '<table cellpadding="5" cellspacing="0" border="0" class="table table-striped table-bordered">';
    sOut +=  '<thead><tr><th class="center" style="text-align:center;">Recibo</th><th class="center" style="text-align:center;">Monto</th><th class="center" style="text-align:center;">Fecha  y Hora de Pago</th><th class="center" style="text-align:center;">Origen</th><th class="center">&nbsp;</th></tr></thead>';

    
    $.ajax({
      type: "POST",
      url: '<?php echo base_url(); ?>index.php/diary/getpays',
      data: 'transaction='+aData[1]+'&distributor='+aData[4]+'&customer='+aData[5],
      dataType: "text",
      cache: false,
      async: false,
      success: function(response) {
        sOut += response;
      }
    })

    sOut += '</table>';

    return sOut;

    //transactionCode
  }

  // add row details
  $(document).ready(function() {
    // filter float numbers
    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
      "signed-num-pre": function ( a ) {
        return (a=="-" || a==="") ? 0 : a.replace(',','')*1;
      },
   
      "signed-num-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
      },
   
      "signed-num-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
      }
    });


    $(".btnSaveAddPay").click(function(){
      obj = $(this).parents(".modaladdpay").find("form");

      flag = true;
      $(obj).find(".text-error").remove();
      ammount = Number($(obj).find("#ammount").val().replace(/[^0-9\.]+/g,""));
      max = Number($(obj).find("#ammount").attr("max").replace(/[^0-9\.]+/g,""));
      voucher = $(obj).find("#voucher").val();
      console.log(obj);
      console.log(voucher);


      if (voucher.trim() == "" || voucher.trim() == null) {
        flag = false;
        $(obj).find("#voucher").parents(".controls").append("<span class='text-error'>Introduzca una Factura</span>");
      }

      if (ammount == "" || ammount == "0") {
        flag = false;
        $(obj).find("#ammount").parents(".controls").append("<span class='text-error'>Introduzca una Cantidad</span>");
      }else{
        if ( ammount > max ) {
          flag = false;
          $(obj).find("#ammount").parents(".controls").append("<span class='text-error'>La cantidad excede el saldo del prestamo</span>");
        } 
      }
  
      if (flag) {
        $(this).attr('disabled', true);
        $(obj).find("#ammount").val(ammount);
        $(obj).submit();
      }
    });


    $("#btnAdd").click(function(){
      $("#diaryTable").append(registry);
    });
    
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

    var oTable = $('#data-table').dataTable( {
      "sDom": "<'row'<'span4'l><'span4'f>r>t<'row'<'span2'i><'span2'p>>",
      "sPaginationType": "bootstrap",
      "oLanguage": {
        "sLengthMenu": "Mostrar _MENU_",
        "sZeroRecords": "Ningun dato encontrado",
        "sInfo": "Mostrar _START_ a _END_ ( de _TOTAL_ records )",
        "sInfoEmpty": "Mostrar 0 a 0 de 0 records",
        "sInfoFiltered": "(Filtrado de _MAX_ records)",
        "sSearch": "Buscar:",
        "oPaginate": {
          "sFirst": "<<",
          "sLast": ">>",
          "sNext": ">",
          "sPrevious": "<"
        }
      },
      "aoColumnDefs": [
        { "bSortable": false, "aTargets": [ 0 ] }
      ],
      "aaSorting": [[1, 'asc']],
      "sPaginationType": "full_numbers",
      "aoColumns": [
          null,
          { "sType" : "string" },
          { "sType" : "date" },
          { "sType" : "numeric" },
          { "sType" : "string" },
          { "sType" : "string" },
          { "sType" : "numeric" },
          { "sType" : "signed-num" },
          { "sType" : "signed-num" },
          { "sType" : "string" },
          null,
          null
      ], 
      "aLengthMenu": [
        [10, 25, 50, 100, 200, -1],
        [10, 25, 50, 100, 200, "Todos"]
      ], 
      "iDisplayLength" : 100
    });

    $(document).on("click", '#data-table tbody td img', function() { 
      var nTr = $(this).parents('tr')[0];
      if ( oTable.fnIsOpen(nTr) ) {
        /* This row is already open - close it */
        this.src = "<?php echo base_url(); ?>img/details_open.png";
        oTable.fnClose( nTr );
      } else {
        /* Open this row */
        this.src = "<?php echo base_url(); ?>img/details_close.png";
        oTable.fnOpen( nTr, fnFormatDetails(oTable, nTr), 'details' );
      }
    });

    /* search input footer */
    $("tfoot input").keyup( function () {
      oTable.fnFilter( this.value, $("tfoot input").index(this) );
    } );
    
    $("tfoot input").each( function (i) {
      asInitVals[i] = this.value;
    } );
    
    $("tfoot input").focus( function () {
      if ( this.className == "search_init" ) {
        this.className = "";
        this.value = "";
      }
    });
    
    $("tfoot input").blur( function (i) {
      if ( this.value == "" ) {
        this.className = "search_init";
        this.value = asInitVals[$("tfoot input").index(this)];
      }
    } 

    );
    
  } );
</script>