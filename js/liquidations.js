//var url = "https://mariani.bo/horizon/index.php/";
//var url = "https://mariani.bo/horizon-sc/index.php/";
var url = "http://localhost/horizon/index.php/";

$(document).ready(function(){
  $('.datepicker, .datepicker2').datepicker({
    format: 'yyyy-mm-dd'
  }).on('changeDate', function(ev){
    $(this).datepicker('hide');
  });

  // chosen selects
  $(".chosen-select").chosen({no_results_text: "Ningún resultado encontrado :("});

  // SECTION CREATE NEW CHARGE
  $(".routedropdown").hide();
  $("#noRegularSelect").hide();

  // set default date
  var myDate = new Date();
  var prettyDate = myDate.getFullYear() + '-' + (myDate.getMonth()+1) + '-' + myDate.getDate();
  $('.datepicker').val(prettyDate);

  // on select distributor, show his routes
  $('select[name="distributor"]').change(function(){
    $(".routedropdown").hide();
    $(".routedropdown").removeClass("selected");
    $zoneid = $('select[name="distributor"]').find('option[value='+$(this).val()+']').attr("data-zone");
    $(".routedropdown[id="+$zoneid+"]").show();
    $(".routedropdown[id="+$zoneid+"]").addClass("selected");
  });

  // on checked no regular products, show selector
  $('#noregularproducts').change(function() {
    if ($(this).is(":checked")) {
      $("#noRegularSelect").show();
    }else{
      $("#noRegularSelect").hide();
    }
  });

  // save form
  $("#saveform").click(function(){
    $(this).prop( "disabled", true );
    $flag = false;
    // check distrib
    $distrib = $('select[name="distributor"]');
    $distribval = $('select[name="distributor"]').val();
    if ($distribval == 0 || $distribval == "") {
      $flag = false;
      $distrib.addClass("has-error");
      $distrib.parents(".form-group").find("label").addClass("has-error");
      $(this).prop( "disabled", false );
      return false;
    }else{
      $flag = true;
      $distrib.removeClass("has-error");
      $distrib.parents(".form-group").find("label").removeClass("has-error");
    }
    // check Route
    $zone = $(".routedropdown.selected").find('select[name="zone"]');
    $zoneval = $zone.val();
    /*if ($zoneval == 0 || $zoneval == "") {
      $flag = false;
      $zone.parents(".form-group").find("label").addClass("has-error");
      $(this).prop( "disabled", false );
      return false;
    }else{
      $flag = true;
      $zone.parents(".form-group").find("label").removeClass("has-error");
    }*/
    // check Date
    $date = $('input[name="date"]');
    $dateval = $('input[name="date"]').val();
    if ($dateval == 0 || $dateval == "") {
      $flag = false;
      $date.addClass("has-error");
      $date.parents(".form-group").find("label").addClass("has-error");
      $(this).prop( "disabled", false );
      return false;
    }else{
      $flag = true;
      $date.removeClass("has-error");
      $date.parents(".form-group").find("label").removeClass("has-error");
    }
    // check no regular products
    var noregulararray = "";
    if ($('#noregularproducts').is( ":checked")) {
      $('#noregulardropdown :selected').each(function(i, selected){
        noregulararray += $(selected).val() + "***";
      });
    }

    if ($flag) {
      $desc = $('textarea[name="desc"]').val();
      $lastliquid = $('#lastliquid').is( ":checked");

      $.ajax({
        type: "POST",
        url: url+'liquidation/saved/',
        data: 'distributor='+$distribval+'&route='+$zoneval+'&date='+$dateval+'&desc='+$desc+'&lastliquid='+$lastliquid+'&noregular='+noregulararray,
        async: false,
        cache: false
      }).done(function( data ) {
        //console.log(data);
        window.location.href = url + "liquidation/add_products/" + data;
      });
    };
  });
  // END SECTION CREATE NEW CHARGE



  // SECTION DEVOLUTION
  $("#add_no_regular").click(function(){
    // check no regular products
    var idliquid = $("#idLiquidacion").html();
    var noregulararray = "";
    $('#noregulardropdown :selected').each(function(i, selected){
      noregulararray += $(selected).val() + "***";
    });

    $.ajax({
      type: "POST",
      url: url+'liquidation/add_irregular_products/',
      data: 'idliquid='+idliquid+'&noregular='+noregulararray,

      async: false,
      cache: false
    }).done(function( data ) {
      window.location.reload();
    });
  });
  // END SECTION DEVOLUTION

  // SECTION ROUTES
  $("#saveformroute").click(function(){
    console.log("mm");
    $(this).prop( "disabled", true );
    $flag = false;
    // check distrib
    $distrib = $('select[name="distributor"]');
    $distribval = $('select[name="distributor"]').val();
    if ($distribval == 0 || $distribval == "") {
      $flag = false;
      $distrib.addClass("has-error");
      $distrib.parents(".form-group").find("label").addClass("has-error");
      $(this).prop( "disabled", false );
      return false;
    }else{
      $flag = true;
      $distrib.removeClass("has-error");
      $distrib.parents(".form-group").find("label").removeClass("has-error");
    }
    // check Route
    $zone = $(".routedropdown.selected").find('select[name="zone"]');
    $zoneval = $zone.val();
    if ($zoneval == 0 || $zoneval == "") {
      $flag = false;
      $zone.parents(".form-group").find("label").addClass("has-error");
      $(this).prop( "disabled", false );
      return false;
    }else{
      $flag = true;
      $zone.parents(".form-group").find("label").removeClass("has-error");
    }
    // check Date
    $date = $('input[name="date"]');
    $dateval = $('input[name="date"]').val();
    if ($dateval == 0 || $dateval == "") {
      $flag = false;
      $date.addClass("has-error");
      $date.parents(".form-group").find("label").addClass("has-error");
      $(this).prop( "disabled", false );
      return false;
    }else{
      $flag = true;
      $date.removeClass("has-error");
      $date.parents(".form-group").find("label").removeClass("has-error");
    }
    
    if ($flag) {
      $.ajax({
        type: "POST",
        url: url+'routes/save/',
        data: 'distributor='+$distribval+'&route='+$zoneval+'&date='+$dateval,
        async: false,
        cache: false
      }).done(function( data ) {
        window.location.href = url + "routes/";
      });

    };
  });
  // ENDSECTION ROUTES
});