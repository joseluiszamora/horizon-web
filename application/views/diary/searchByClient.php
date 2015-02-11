<div class="container">     

  <!-- Portfolio row of columns 
  <div id="productList" class="row">
    <div class="span12 titleTop">
      <h1 class="floatLeft">Diario</h1>
    </div>
  </div>
-->
  <div class="span12">      
      <div class="tabbable">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab1" data-toggle="tab">Todos</a></li>
          <li><?php if($this->Account_Model->get_profile() == '1' || $this->Account_Model->get_profile() == '2'){ ?>
            <!-- Button to trigger modal -->
            <?php echo anchor('transaction/create_diary', 'Prestamos', array('class'=>'btnAdd btnTitle btn btn-primary')); ?>

          <?php } ?></li>
          <li class="tab2"><?php echo anchor('diary/chartsClients', 'Clientes', array('class' => '')); ?></li>
          <li class="tab2"><?php echo anchor('diary/chartsAmmount', 'Estadisticas Montos', array('class' => '')); ?></li>
          <li class="tab2"><?php echo anchor('diary/chartsDistrib', 'Estadisticas Distribuidores', array('class' => '')); ?></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab1">
            <?php
              $data['category'] = 'client';
              //$this->load->view('diary/tab1', $data);
            ?>
          </div>
        </div>
      </div>
    </div>


  <div class="row" style="overflow:hidden;">
    <div class="container formContainer logincontainer">
      <div class="span9 offset1">
        <div class="block_head row">
          <h2 class="span4">Diario</h2>
        </div>
        <div class="block_content row padding0">
            <?php echo form_open('diary/search'); ?>

            <fieldset>
              <div class="control-group selected_3">
                <label class="control-label" for="city">Cliente</label>
                <div class="controls">
                  <div class="wrapper">
                    <input customerid="0" id="clientInput" type="text" name="autocompletar" maxlength="15" onpaste="return false" class="autocompletar" placeholder="Escribe tu búsqueda" />
                    <div class="contenedor"></div>
                  </div>
                </div>
              </div>

              <div class="control-group selected_3">
                <label class="control-label" for="city">Estado</label>
                <div class="controls">
                  <?php
                    $options = array(
                      '0' => 'Todos',
                      '1' => 'Pendiente',
                      '2' => 'Pagado/Cancelado',
                      '3' => 'Eliminado'
                    );

                    if (isset($parameters['status'])) {
                      echo form_dropdown('statusInput', $options, $parameters['status'], 'class="chosen-select" ', 'id="statusInput" ');
                    }else{
                      echo form_dropdown('statusInput', $options, '', 'class="chosen-select" ', 'id="statusInput" ');
                    }
                  ?>
                </div>
              </div>
              
              <div class="control-group selected_1">
                <label class="control-label" for="dateStart">Desde:</label>
                <div class="controls">
                  <?php 
                    if (isset($parameters['dateStart'])) {
                      echo form_input(array('id' => 'dateStartInput','name' => 'dateStart', 'class' => 'datecontainer datepicker datemedium', 'value' => $parameters['dateStart'])); 
                    }else{
                      echo form_input(array('id' => 'dateStartInput', 'name' => 'dateStart', 'class' => 'datecontainer datepicker datemedium')); 
                    }
                  ?>
                </div>
              </div>

              <div class="control-group selected_1">
                <label class="control-label" for="dateFinish">Hasta:</label>
                <div class="controls">
                  <?php
                    if (isset($parameters['dateFinish'])) {
                      echo form_input(array('id' => 'dateFinishInput', 'name' => 'dateFinish', 'class' => 'datecontainer datepicker datemedium', 'value' => $parameters['dateFinish'])); 
                    }else{
                      echo form_input(array('id' => 'dateFinishInput', 'name' => 'dateFinish', 'class' => 'datecontainer datepicker datemedium')); 
                    }
                  ?>
                </div>
              </div>

            <div class="form-actions span7">
              <input class="btn btn-primary" type="submit" name="submit" id="btnSearch" value="Buscar" />
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
  </div>

  <div class="container">
    <div class="span10 offset1">
      <div class="block_content row">
          <fieldset>
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="data-table" width="100%">
                <thead>
                  <tr>
                    <th class="center">Transacción</th>
                    <th class="center">Fecha</th>
                    <th class="center">Mora(Dias)</th>
                    <th class="center">Distribuidor</th>
                    <th class="center">Recibo</th>
                    <th class="center">Total</th>
                    <th class="center">Saldo</th>
                    <th class="center">Origen</th>
                  </tr>
                </thead>
                <tbody id="diaryTable" class="ajaxResult">  
                </tbody>
            </table>

          </fieldset>
      </div>
    </div>
  </div>


<script type="text/javascript">
  $(document).ready(function(){
    $(".autocompletar").keyup(function(){
      var info = $(this).val();
      $.post('autocompletar',{ info : info }, function(data){
        if(data != ''){
          $('.contenedor').show();
          $(".contenedor").html(data );
        }else{
          $(".contenedor").html('');
        }

        $(".customerElement").click(function() {
          var customer = $(this).html();
          cust = customer.split(" - ");

          $("#clientInput").attr("customerid", cust[0]);
          $("#clientInput").val(cust[1]);
          $(".contenedor").css("display", "none");
        });
      })
    })
    $(".contenedor").find("a").on('click',function(e){
      e.preventDefault();
      alert($(this).html());
    });
  });

  $("#btnSearch").click(function(event) {
    event.preventDefault();
    var client = $("#clientInput").attr("customerid");
    var status = $("select[name=statusInput]").val();
    var datestart = $("#dateStartInput").val();
    var datefinish = $("#dateFinishInput").val();

    jQuery.ajax({
      type: "POST",
      url: "user_data_submit",
      dataType: 'json',
      data: {client: client, status: status, datestart: datestart, datefinish: datefinish},
        success: function(res) {
        if (res){
          console.log(res);
          //jQuery("#diaryTable").html(res);
          // Show Entered Value
          /*jQuery("div#result").show();
          jQuery("div#value").html(res.username);
          jQuery("div#value_pwd").html(res.pwd);*/
          $res='';
          $.each(res,function(code,name){
            /*opt.val(id);
            opt.text(name);
            $($to).append(opt);*/
            //console.log(this.iddiario)
            $res+='<tr class="even gradeX">';
              $res+='<td class="center">'+this.idTransaction+'</td>';
              $res+='<td class="center">'+this.FechaTransaction+'</td>';
              $res+='<td class="center">'+this.iddiario+'</td>';
              $res+='<td class="center">'+this.iddiario+'</td>';
              $res+='<td class="center">'+this.NumVoucher+'</td>';
              $res+='<td class="center">'+this.iddiario+'</td>';
              $res+='<td class="center">'+this.iddiario+'</td>';
              $res+='<td class="center">'+this.Origen+'</td>';
            $res+='</tr>';
          });

          $("#diaryTable").html($res);
        }
      }
    });
  });
</script>

<style type="text/css">
  .autocompletar {
    margin-bottom: 20px;
  }
  .contenedor p {
    background-color: #0088cc;
    background-image: linear-gradient(90deg, transparent 50%, rgba(255, 255, 255, 0.5) 50%);
    background-size: 203px 203px;
    border: 1px solid #ccc;
    color: #fff;
    font-size: 14px;
    margin-top: -14px;
    max-width: 300px;
    padding: 3px 2px;
  }
  .contenedor p a {
    color: #fff;
    text-decoration: none;
  }
  .customerElement{
    width: 100%;
    height: 100%;
    cursor: pointer;
  }
</style>