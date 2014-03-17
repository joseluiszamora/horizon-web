<div class="row">
  <div class="span12 titleTop">
    <h1 class="floatLeft">Diario</h1>
  </div>

  <div class="container formContainer logincontainer">
    <div class="span11">
      <div class="block_head row">
        <h2 class="span4">Diario</h2>
      </div>
      <div class="block_content row">
          <fieldset>
            <input id="btnAdd" class="btn btn-primary" type="submit"  value="+" />
             <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="data-table" width="100%">
              <thead>
                <tr>
                  <th class="center">Distribuidor</th>
                  <th class="center">Cliente</th>
                  <th class="center">Fecha</th>
                  <th class="center">Voucher</th>
                  <th class="center">Monto</th>
                  <th class="center">Detalle</th>
                </tr>
              </thead>
              <tbody id="diaryTable">
                <tr class="even gradeX">
                  <td class="center" id ="distributorDropdown">
                    <?php
                      echo form_dropdown('distributor', $distributor, '', 'class="chosen-select" ');
                    ?>
                  </td>
                  <td class="" id ="clientDropdown">
                    <?php
                      echo form_dropdown('client', $clients, '', 'class="chosen-select" ');
                    ?>
                  </td>
                  <td class="center">
                    <?php 
                      echo form_input(array('name' => 'date', 'class' => 'datecontainer datepicker', 'value' => date("Y-m-d"))); 
                    ?>
                  </td>
                  <td class="center"><input id="voucher" type="text" class="span1" value="" ></td>
                  <td class="center"><input id="ammount" type="text" class="span1" value="" ></td>
                  <td class="center"><textarea class="span2" rows="1" cols="0" id="detail" name="detail"></textarea></td>
                </tr>
              </tbody>
            </table>

            <div class="form-actions span9">
              <?php echo anchor('diary', 'Cancelar', array('class' => 'btnTitle btn btn-info')); ?>
              <input class="btn btn-primary" type="submit" name="submit" id="btnSave" value="Guardar" />
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
  registry += '<td class="center"><input id="ammount" type="text" class="span1" value="" ></td>';
  registry += '<td class="center"><textarea class="span2" rows="1" cols="0" id="detail" name="detail"></textarea></td>';
  registry += "</tr>";

  $(document).ready(function(){
    $("#btnAdd").click(function(){
      $("#diaryTable").append(registry);
      $(".datepicker2").datepicker();
    });

    $("#btnSave").click(function(){
      //showLoadingAnimation($('#clientDropdown'));

      $("#diaryTable tr").each(function(){
        console.log($(this).find("select[name='client']").val());
        client = $(this).find("select[name='client']").val();
        date = $(this).find("input[name='date']").val();
        voucher = $(this).find("#voucher").val();;
        ammount = $(this).find("#ammount").val();;
        detail = $(this).find("#detail").val();;

        $.ajax({
          type: "POST",
          url: 'save',
          data: 'client='+client+'&date='+date+'&voucher='+voucher+'&ammount='+ammount+'&detail='+detail,
          dataType: 'json',
          cache: false,
          success: function(data) {
            //redirectxx();
          }
        })
      
      });
      //hideLoadingAnimation($('#clientDropdown'));
    });

  });
  
  function redirectxx(){
    <?php //redirect('diary'); ?>
  }
</script>
