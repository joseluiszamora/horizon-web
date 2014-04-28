<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Dias</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($ranks as $row) { ?>
      <tr>
        <td class="text-info areaDesc"><strong><?php echo $row->Days; ?></strong></td>
        <td>
          <?php 
            if($this->Account_Model->get_profile() == '1'){
          ?>
          <div class="btnActionsForm">
            <!-- Button to trigger modal -->
            <a href="<?php echo '#modal-'.$row->idrank ?>" role="button" class="btn btn-primary" data-toggle="modal">Editar</a>

            <!-- Modal -->
            <div  id="<?php echo 'modal-'.$row->idrank ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Editar Rango</h3>
              </div>
              <div class="modal-body container_form_no_margin">
                <?php 
                  $attributes = array('class' => 'formaddpay', 'id' => 'editrank');
                  echo form_open('rank/edit', $attributes);
                  echo form_hidden('idrank', $row->idrank);
                ?>

                <fieldset>
                  <div class="well well-small row logincontainer">
                    <div class="control-group span2">
                      <label class="control-label" for="ammount">Dias:</label>
                      <div class="controls">
                        <input type="text" class="span2 money" value="<?php echo $row->Days; ?>" name="ammount" id="ammount" required/><br>
                      </div>
                    </div>
                  </div>
                </fieldset>
                <?php echo form_close(); ?>
              </div>
              <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <button class="btn btn-primary btnSaveEditPay">Guardar</button>
              </div>
            </div>

          </div>
          <?php            
          }
          ?> 
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>



<script type="text/javascript">
  $(document).ready(function() {
    $(".btnSaveEditPay").click(function(){
      obj = $(this).parents(".btnActionsForm").find("#editrank");
      flag = true;
      $(obj).find(".text-error").remove();
      ammount = Number($(obj).find("#ammount").val().replace(/[^0-9\.]+/g,""));
      console.log(ammount);
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