<div class="row">
  <div class="span12 titleTop">
    <h1 class="floatLeft">Diario</h1>
  </div>
  
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
              <label class="control-label" for="city">Fecha de Transacción</label>
              <div class="controls">
                <?php 
                  echo form_input(array('name' => 'date', 'class' => 'span2 datepicker'), set_value('dateStart')); 
                ?>
              </div>
            </div>
          </fieldset>
      </div>
    </div>
  </div>


  <div class="container formContainer logincontainer">
    <div class="span9 offset1">
      <div class="block_head row">
        
      </div>
      <div class="block_content row">
          <fieldset>
            <input id="btnAdd" class="btn btn-primary" type="submit"  value="+" />
             <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="data-table" width="100%">
              <thead>
                <tr>
                  <th class="center">Cliente</th>
                  <th class="center">Fecha</th>
                  <th class="center">Voucher</th>
                  <th class="center">Monto</th>
                  <th class="center">Detalle</th>
                </tr>
              </thead>
              <tbody id="diaryTable">
                <tr class="even gradeX">
                  <td class="" id ="clientDropdown">
                    <?php
                      echo form_dropdown('client', $clients, 'large');
                    ?>
                  </td>
                  <td class="center">
                    <?php 
                      echo form_input(array('name' => 'date', 'class' => 'datecontainer datepicker'), set_value('dateStart')); 
                    ?>
                  </td>
                  <td class="center"><input id="voucher" type="text" class="span1" value="" ></td>
                  <td class="center"><input id="ammount" type="text" class="span1" value="" ></td>
                  <td class="center"><input id="detail" type="text" class="span1" value="" ></td>
                </tr>
              </tbody>
            </table>

            <div class="form-actions span7">
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
  // dropdown users
  var drop = $("#clientDropdown").html();

  var registry = "<tr class='even gradeX'>";
  registry += '<td class="center">' + drop + '</td> ';
  registry += '<td class="center"><input type="text" class="datecontainer datepicker" value="" name="date"></td>';
  registry += '<td class="center"><input id="voucher" type="text" class="span1" value="" ></td>';
  registry += '<td class="center"><input id="ammount" type="text" class="span1" value="" ></td>';
  registry += '<td class="center"><input id="detail" type="text" class="span1" value="" ></td>';
  registry += "</tr>";

  $(document).ready(function(){
    $("#btnAdd").click(function(){
      $("#diaryTable").append(registry);
      //$(".datepicker").datepicker();
    });

    $("#btnSave").click(function(){
      //showLoadingAnimation($('#clientDropdown'));

      $("#diaryTable tr").each(function(){
        console.log($(this).find("select[name='type']").val());
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
