	<div class="container logincontainer">
	<div id="logo">
		<img width="218" height="56" src="<?php echo base_url(); ?>img/logobig.png" alt="">
	</div>
	<div class="span6 offset3">
		<div class="block_head row">
			<h2 class="span4">Registrate en HORIZON</h2>
		</div>
		<div class="block_content row">			
			<?php echo form_open('account/register'); ?>
				<fieldset>
					<legend>
						<h3>Crea tu cuenta ahora!</h3>
					</legend>
					<div class="control-group">
		        <label class="control-label" for="usertype">Tipo de Usuario</label>
		        <div class="controls">
		        	<?php
		            if (isset($idprofile))
	                echo form_dropdown('usertype', $users, $users->idprofile);
		            else
	                echo form_dropdown('usertype', $users);
			        ?>
		        </div>
	        </div>

	        <div class="control-group">
		        <label class="control-label" for="city">Ciudad</label>
		        <div class="controls">
		        	<?php
		            if (isset($idprofile))
	                echo form_dropdown('city', $city, $city->idCiudad);
		            else
	                echo form_dropdown('city', $city);
			        ?>
		        </div>
	        </div>

	        <div class="control-group">
		        <label class="control-label" for="area">Zona</label>
		        <div class="controls">
		        	<?php
		            if (isset($idprofile))
	                echo form_dropdown('area', $area, $area->idZona);
		            else
	                echo form_dropdown('area', $area);
			        ?>
		        </div>
	        </div>

	        <div class="control-group">
		        <label class="control-label" for="ci">Carnet de Identidad</label>
		        <div class="controls">
			        <input type="text" class="span5" name="ci" value="<?php echo set_value('ci'); ?>" />
			        <p><?php echo form_error('ci'); ?></p>        
		        </div>	
	        </div>

					<div class="control-group">
		        <label class="control-label" for="username">Nombre(s)</label>
		        <div class="controls">
			        <input type="text" class="span5" name="username" value="<?php echo set_value('username'); ?>" />
			        <p><?php echo form_error('username'); ?></p>        
		        </div>	
	        </div>

	        <div class="control-group">
		        <label class="control-label" for="userlastname">Apellido(s)</label>
		        <div class="controls">
			        <input type="text" class="span5" name="userlastname" value="<?php echo set_value('userlastname'); ?>" />
			        <p><?php echo form_error('userlastname'); ?></p>        
		        </div>	
	        </div>

	        <div class="control-group">
		        <label class="control-label" for="email">Email</label>
		        <div class="controls">
			        <input type="text" class="span5" name="email" value="<?php echo set_value('email'); ?>" />
			        <p><?php echo form_error('email'); ?></p>
		        </div>				        
	        </div>

	        <div class="control-group">
		        <label class="control-label" for="password">Password</label>
		        <div class="controls">
			        <input type="password" class="span5" name="password" value="<?php echo set_value('password'); ?>" />	
			        <p><?php echo form_error('password'); ?></p>	       
		        </div>
	        </div>
	        
	        <div class="control-group">
		        <label class="control-label" for="password_conf">Confirmar Password</label>
		        <div class="controls">
			        <input type="password" class="span5" name="password_conf" value="<?php echo set_value('password_conf'); ?>" />	
			        <p><?php echo form_error('password_conf'); ?></p>   
		        </div>				       
	        </div>
	        
	       	<div class="control-group">
		        <label class="control-label" for="phone">Telefono</label>
		        <div class="controls">
			        <input type="text" class="span5" name="phone" value="<?php echo set_value('phone'); ?>" />	
			        <p><?php echo form_error('phone'); ?></p>   
		        </div>
	        </div>
	        
	        <div class="control-group">
		        <label class="control-label" for="cellphone">Celular</label>
		        <div class="controls">
			        <input type="text" class="span5" name="cellphone" value="<?php echo set_value('cellphone'); ?>" />	
			        <p><?php echo form_error('cellphone'); ?></p>   
		        </div>
	        </div>

	        <div class="control-group">
		        <label class="control-label" for="obs">Observaciones</label>
		        <div class="controls">
		        	<textarea class="span5" name="obs" value="<?php echo set_value('obs'); ?>"></textarea>
			        <p><?php echo form_error('obs'); ?></p>   
		        </div>
	        </div>

	        <div class="form-actions">
	        	<div class="alert alert-info">
			    	<strong>Atencion!</strong> Al registrarme estoy de acuerdo y acepto las <a href="">Condiciones de uso</a>.
			    </div>  
	        	<input class="btn btn-primary" type="submit" name="submit" value="Registrarme" />			        	   	    
	        </div>		        	
		    </fieldset>	
		    <p id="forgot_pass">Un momento, ya tengo una cuenta! <a href="<?php echo base_url(); ?>account/login">Ingresar</a></p>
		</div>
		<div class="bendl"></div>
		<div class="bendr"></div>
	</div>
</div>