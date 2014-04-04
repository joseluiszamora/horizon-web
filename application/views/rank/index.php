<div class="container">

  <!-- Portfolio row of columns -->
  <div id="productList" class="row">
    <div class="span12 titleTop">
      <h1 class="floatLeft">Rangos de Prestamo</h1>
    </div>

    <div class="span8 smallTableCenter">
      <div class="tabbable">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab1" data-toggle="tab">Activos</a></li>
          <li><?php if($this->Account_Model->get_profile() == '1'){ ?>
            <!-- Button to trigger modal -->
            <a href="#modal-newrank" role="button" class="btnAdd btnTitle btn btn-primary" data-toggle="modal">Nuevo Rango</a>
          <?php } ?></li>

          <!-- Modal -->
          <div id="modal-newrank" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3 id="myModalLabel">Nuevo Rango</h3>
            </div>
            <div class="modal-body container_form_no_margin">
              <?php 
                $attributes = array('class' => 'formaddpay', 'id' => 'addrank');
                echo form_open('rank/save', $attributes);
              ?>

              <fieldset>
                <div class="well well-small row logincontainer">
                  <div class="control-group span2">
                    <label class="control-label" for="ammount">Monto:</label>
                    <div class="controls">
                      <input type="text" class="span2 money" value="" name="ammount" id="ammount" required/><br>
                    </div>
                  </div>
                </div>
              </fieldset>
              <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
              <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
              <button class="btn btn-primary btnSaveAddPay">Guardar</button>
            </div>
          </div>

        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab1">
            <?php
              $data['category'] = 'rank';
              $this->load->view('rank/tab1', $data);
            ?>
          </div>
          <div class="tab-pane" id="tab2">
            <?php
              $data['category'] = 'volume';
              //$this->load->view('area/tab3', $data);
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
  $(document).ready(function() {

    $(".btnSaveAddPay").click(function(){
      obj = $("#addrank");
      flag = true;
      $(obj).find(".text-error").remove();
      ammount = Number($(obj).find("#ammount").val().replace(/[^0-9\.]+/g,""));
      if (ammount == "" || ammount == "0") {
        flag = false;
        $(obj).find("#ammount").parents(".controls").append("<span class='text-error'>Introduzca una Cantidad</span>");
      }
  
      if (flag) {
        $(obj).find("#ammount").val(ammount);
        $(obj).submit();
      }
    });

  });
</script>