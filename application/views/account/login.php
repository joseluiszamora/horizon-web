<div class="container logincontainer">
  <div id="logo">
    <img width="200" src="<?php echo base_url(); ?>img/logo_horizon.png">
  </div>
  <div class="span6 offset3">
    <div class="block_head row">
      <h2 class="span4">Ingresa en HORIZON</h2>
    </div>
    <div class="block_content row">

      <?php echo form_open('account/login'); ?>
        <fieldset>
          <div class="control-group">
            <label class="control-label" for="email">Email</label>
            <div class="controls">
              <input type="mail" class="span5" name="email" value="<?php echo set_value('email'); ?>">
              <p><?php echo form_error('email'); ?></p>            
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="pass">Password</label>
            <div class="controls">
              <input type="password" class="span5" name="pass" value="<?php echo set_value('pass'); ?>" />  
              <?php echo form_error('pass'); ?>          
            </div>
          </div>
          <div class="control-group">
            <input class="btn btn-primary" type="submit" name="submit" value="Ingresar" />                  
          </div>
        </fieldset>                                 
    </div>
    <div class="bendl"></div>
    <div class="bendr"></div>
  </div>
</div>