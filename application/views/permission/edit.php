<div class="row">
  <div class="span12 titleTop">
    <h1 class="floatLeft">Permisos de Acceso</h1>
  </div>  

 <div class="container logincontainer">
    <div class="span9 offset1">
      <?php foreach ($profile as $row_profile) { ?>
        <div class="block_head row">
          <h2 class="span6"><?php echo $row_profile->Descripcion; ?></h2>
          <?php echo anchor('permission', 'Volver', array('class' => 'btnTitle btn btn-primary', 'style'=>'float:right;')); ?>
        </div>
        <div class="block_content row">
            <table class="tableHorizon table table-bordered table-striped">
              <tbody>
                <?php foreach ($modules as $row) { ?>
                  <tr>
                    <td class="text-info grid grid_1"><strong><?php echo $row->Descripcion; ?></strong></td>
                    <td class="grid grid_2">
                      <div class="btnActionsForm permissionChecked">
                        <?php 
                          if ($this->Permission_Model->check_access($row_profile->idProfile, $row->idModulo)) {
                            echo form_checkbox($row->idModulo, $row_profile->idProfile, TRUE);
                          }else{
                            echo form_checkbox($row->idModulo, $row_profile->idProfile, FALSE);
                          }                          
                        ?>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
        </div>
      <?php } ?>
    </div>
  </div>
</div>