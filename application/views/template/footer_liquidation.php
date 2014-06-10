  
</div>

</body>
</html>

<!-- Core Scripts  -->
<script src="<?php echo base_url(); ?>js/jquery-1.11.0.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>js/sb-admin.js"></script>
<script src="<?php echo base_url(); ?>js/chosen.jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-datepicker.js"></script>

<!-- ANGULAR -->
<script src="<?php echo base_url(); ?>js/angular/angular.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/angular/app.js" type="text/javascript"></script>

<script type="text/javascript">
 	// chosen selects
  	$(".chosen-select").chosen({no_results_text: "Ningún resultado encontrado :("}); 

	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd'
	}).on('changeDate', function(ev){
		$(this).datepicker('hide');
	});
</script>