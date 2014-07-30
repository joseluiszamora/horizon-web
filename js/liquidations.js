//var url = "http://www.ruizmier.com/systems/horizon/";
//var url = "https://mariani.bo/horizon/index.php/";
var url = "http://localhost/horizon/index.php/";


$(document).ready(function(){
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
  }).on('changeDate', function(ev){
    $(this).datepicker('hide');
  });

  // chosen selects
  $(".chosen-select").chosen({no_results_text: "Ningún resultado encontrado :("});
});