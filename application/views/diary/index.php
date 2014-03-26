<div class="container">     

  <!-- Portfolio row of columns -->
  <div id="productList" class="row">
    <div class="span12 titleTop">
      <h1 class="floatLeft">Diario</h1>
    </div>

    <div class="span12">      
      <div class="tabbable">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab1" data-toggle="tab">Todos</a></li>
          <li><?php if($this->Account_Model->get_profile() == '1' || $this->Account_Model->get_profile() == '2'){ ?>
            <!-- Button to trigger modal -->
            <a href="#modal-diarycreate" role="button" class="btnAdd btnTitle btn btn-primary" data-toggle="modal">PRESTAMOS</a>

            <!-- Modal -->
            <div id="modal-diarycreate" class="modal hide fade modalbig" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">PRESTAMOS</h3>
              </div>
              <div class="modal-body" style="min-height: 100px;">
                <fieldset>
                  <table cellpadding="0" cellspacing="0" border="0" class="table" id="data-tabled" width="100%">
                    <thead>
                      <tr>
                        <th class="center">Distribuidor</th>
                        <th class="center">Cliente</th>
                        <th class="center">Fecha</th>
                        <th class="center">Voucher</th>
                        <th class="center">Monto</th>
                        <th class="center">Detalle</th>
                        <th class="center">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody id="diaryTableModal">
                      <tr class="even gradeX">
                        
                        <td class="center" id ="distributorDropdown">
                          <?php
                            echo form_dropdown('distributor', $distributor, '', 'class="chosen-select2"');
                          ?>
                        </td>
                        <td class="" id ="clientDropdown">
                          <?php
                            echo form_dropdown('client', $clients, '', 'class="chosen-select2"');
                          ?>
                        </td>
                        <td class="center">
                          <?php 
                            echo form_input(array('name' => 'date', 'class' => 'datecontainer datepicker datemedium', 'value' => date("Y-m-d"))); 
                          ?>
                        </td> 
                        <td class="center"><input id="voucher" type="text" class="span1" value="" ></td>
                        <td class="center"><input id="ammount" type="text" class="span1" value="" ></td>
                        <td class="center"><textarea class="span2" rows="1" cols="0" id="detail" name="detail"></textarea></td>
                        <td class="center"><input id="btnAddReg" class="btn btn-primary" type="submit"  value="+" /></td>
                      </tr>
                    </tbody>
                  </table>

                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="data-tabled" width="100%">
                    <thead>
                      <tr>
                        <th class="center">Distribuidor</th>
                        <th class="center">Cliente</th>
                        <th class="center">Fecha</th>
                        <th class="center">Voucher</th>
                        <th class="center">Monto</th>
                        <th class="center">Detalle</th>
                        <th class="center">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody id="diaryTableList">
                    </tbody>
                  </table>
                </fieldset>

              </div>
              <div class="modal-footer">
                <div id="formSaveBlock">
                  <?php echo form_open('diary/saveblock'); ?>  
                  <input type="hidden" value="" name="distributor" id="distributor" >
                  <input type="hidden" value="" name="date" id="date" >
                  <input type="hidden" value="" name="voucher" id="voucher" >
                  <input type="hidden" value="" name="client" id="client" >
                  <input type="hidden" value="" name="ammount" id="ammount" >
                  <input type="hidden" value="" name="detail" id="detail" >
                  <?php echo form_close(); ?>  
                </div>
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <input class="btn btn-primary" type="submit" name="submit" id="btnSave" value="Guardar" />
              </div>
            </div>



          <?php } ?></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab1">
            <?php
              $data['category'] = 'client';
              $this->load->view('diary/tab1', $data);
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="modal-confirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Registros guardados</h3>
  </div>
  <div class="modal-body">
    <p>Registros guardados correctamente</p>
  </div>
  <div class="modal-footer">
    <?php echo anchor('diary', 'Ok', array('class' => 'btn btn-primary')); ?>
  </div>
</div>

<style type="text/css">
  #btnAddModal{
    float: right;
    margin: 0 20px 10px 0;
  }
  .datecontainer{
    width: 70px;
  }
</style>

<script type="text/javascript">
  // dropdown distributors
  var distrib = $("#distributorDropdown").html();
  // dropdown users
  var drop = $("#clientDropdown").html();

  var registry = "<tr class='even gradeX'>";
  registry += '<td class="center">' + distrib + '</td> ';
  registry += '<td class="center">' + drop + '</td> ';
  registry += '<td class="center"><input type="text" class="datecontainer datepicker2" value="<?php echo date("Y-m-d");?>" name="date"></td>';
  registry += '<td class="center"><input id="voucher" type="text" class="span1" value="" ></td>';
  registry += '<td class="center"><input id="ammount" data-max="1000" type="text" class="span1" value="" ></td>';
  registry += '<td class="center"><textarea class="span2" rows="1" cols="0" id="detail" name="detail"></textarea></td>';
  registry += "</tr>";

  function templateTable(distributor, client, date, voucher, ammount, detail){
    var registry = "<tr class='even gradeX'>";
    registry += "<td class='center distributor'>"+distributor+"</td>";
    registry += "<td class='center client'>"+client+"</td>";
    registry += "<td class='center date'>"+date+"</td>";
    registry += "<td class='center voucher'>"+voucher+"</td>";
    registry += "<td class='center ammount'>"+ammount+"</td>";
    registry += "<td class='center detail'>"+detail+"</td>";
    registry += "<td class='center'><button class='btn btn-primary span1 btnDeleteRow'>X</button></td>";
    registry += "</tr>";

    return registry;
  }

  $(document).ready(function(){

    $("#btnAddReg").click(function(){
      flag = true;

      distributor = $(this).parents("#diaryTableModal").find("select[name='distributor']").val();
      client = $(this).parents("#diaryTableModal").find("select[name='client']").val();
      date = $(this).parents("#diaryTableModal").find("input[name='date']").val();
      voucher = $(this).parents("#diaryTableModal").find("#voucher").val();
      ammount = $(this).parents("#diaryTableModal").find("#ammount").val();
      detail = $(this).parents("#diaryTableModal").find("#detail").val();

      //validate
      $(this).parents("#diaryTableModal").find(".text-error").remove();

      if (distributor.trim() == "" || distributor.trim() == "0") {
        flag = false;
        $(this).parents("#diaryTableModal").find("select[name='distributor']").parents("td").append("<span class='text-error'>Seleccione un Distribuidor</span>");
      }
      if (client.trim() == "" || client.trim() == "0") {
        flag = false;
        $(this).parents("#diaryTableModal").find("select[name='client']").parents("td").append("<span class='text-error'>Seleccione un Cliente</span>");
      }
      if (voucher.trim() == "" || voucher.trim() == "0") {
        flag = false;
        $(this).parents("#diaryTableModal").find("#voucher").parents("td").append("<span class='text-error'>Introduzca un Voucher</span>");
      }
      if (ammount.trim() == "" || ammount.trim() == "0") {
        flag = false;
        $(this).parents("#diaryTableModal").find("#ammount").parents("td").append("<span class='text-error'>Introduzca una Cantidad</span>");
      }


      if (flag) {
        console.log("3333333333333333");
        val = templateTable(distributor, client, date, voucher, ammount, detail);

        $("#diaryTableList").append(val);

        // delete row
        $(".btnDeleteRow").click(function(){
          console.log("click");
          $(this).parents("tr").remove();
        });
      };

    });


    $("#btnSave").click(function(){
      distributor = "";
      client = "";
      date = "";
      voucher = "";
      ammount = "";
      detail = "";

      $("#diaryTableList tr").each(function(){
        distributor += $(this).find(".distributor").html()+"***";
        client += $(this).find(".client").html()+"***";
        date += $(this).find(".date").html()+"***";
        voucher += $(this).find(".voucher").html()+"***";
        ammount += $(this).find(".ammount").html()+"***";
        detail += $(this).find(".detail").html()+"***";
      });

      $("#formSaveBlock #distributor").val(distributor);
      $("#formSaveBlock #date").val(date);
      $("#formSaveBlock #voucher").val(voucher);
      $("#formSaveBlock #client").val(client);
      $("#formSaveBlock #ammount").val(ammount);
      $("#formSaveBlock #detail").val(detail);

      var form = $("#formSaveBlock form");
      form.submit();
    });


    $('#modal-diarycreate').on('show', function () {
      $(".chosen-select2").chosen({
        no_results_text: "Ningún resultado encontrado :(",
        width: "200px"
      }); 
    })
     
  });
</script>