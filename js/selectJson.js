//var loader = "https://mariani.bo/horizon/img/loader.gif";
//var loader = "http://www.ruizmier.com/systems/horizon/img/loader.gif";
var loader = "http://localhost/horizon/img/loader.gif";

function showLoadingAnimation(obj){
 // console.log(obj);
  $(obj).parents(".controls").append("<img style='margin: 0 90px;' src='"+loader+"'>");
  $(obj).css("display", "none");
}
function showLoadingAnimation_td(obj){
  $(obj).html("");
  $(obj).append("<img style='margin: 0 90px;' src='"+loader+"'>");
}
function hideLoadingAnimation(obj){
  $(obj).css("display", "block");
  $(obj).siblings().remove();
}
function hideLoadingAnimation_td(obj){
  $(obj).find("img").remove();
}
$(document).ready(function(){
  //var url = "http://www.ruizmier.com/systems/horizon/";
  //var url = "https://mariani.bo/horizon/index.php/";
  var url = "http://localhost/horizon/index.php/";

  // chosen selects
  $(".chosen-select").chosen({no_results_text: "Ningún resultado encontrado :("}); 

  // money mask
  $('.money').mask('000,000,000,000,000.00', {reverse: true});

  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
  }).on('changeDate', function(ev){
    $(this).datepicker('hide');
  });

  // seleccionar, deseleccionar permisos de acceso
  $(".permissionChecked input:checkbox").click(function() {
    console.log("clickkkk");
    module = $(this).attr('name');
    profile = $(this).attr('value');
    if ($(this).is( ":checked")) {
      $.ajax({
        type: "POST",
        url: url+'permission/activate',
        data: 'module='+module+'&profile='+profile,
        dataType: 'json',
        cache: false,
        success: function(data) {
        }
      })
    }
    else {
      $.ajax({
        type: "POST",
        url: url+'permission/deactivate',
        data: 'module='+module+'&profile='+profile,
        dataType: 'json',
        cache: false,
        success: function(data) {
        }
      })
    }
  });


  // update AREA for selected CITY 
  $('.formContainer select[name="city"]').change(function(){
    $('.formContainer select[name="area"] > option').remove();
    $('.formContainer select[name="subarea"] > option').remove();
    var idCity = $(this).parents(".formContainer").find('select[name="city"]').val();
    //var idCity = $('.formContainer select[name="city"]').val();
    showLoadingAnimation($('.formContainer select[name="area"]'));
    
    $.getJSON( url+"area/get_area_for_city/"+idCity, {
      format: "jsonp",
      async: true,
      contentType: 'application/json; charset=utf-8', 
      cache: false,
      crossDomain: true
    })
    .done(function( linesvolumes ) {
      $('.formContainer select[name="subarea"]').append('<option selected="selected" value="0">Seleccione Sub Zona</option>');
      $.each(linesvolumes,function(id,name){
        var opt = $('<option>');
        opt.val(id);
        opt.text(name);
        $('.formContainer select[name="area"]').append  (opt);
      });
      hideLoadingAnimation($('.formContainer select[name="area"]'));
    });
  });

  // update DISTRICT for selected CITY 
  $('.formContainer select[name="city"]').change(function(){
    $('.formContainer select[name="disctrict"] > option').remove();
    $('.formContainer select[name="area"] > option').remove();
    //$('.formContainer select[name="subarea"] > option').remove();
    var idCity = $(this).parents(".formContainer").find('select[name="city"]').val();
    //var idCity = $('.formContainer select[name="city"]').val();
    showLoadingAnimation($('.formContainer select[name="disctrict"]'));

    $.getJSON(url+"district/get_districts_for_city/"+idCity, {
      format: "jsonp",
      async: true,
      contentType: 'application/json; charset=utf-8', 
      cache: false,
      crossDomain: true
    })
    .done(function( cities ) {
      $.each(cities,function(id,name){
        var opt = $('<option>');
        opt.val(id);
        opt.text(name);
        $('.formContainer select[name="disctrict"]').append(opt);
      });
      hideLoadingAnimation($('.formContainer select[name="disctrict"]'));
    });
  });

  // update SUBAREA for AREA 
  $('.formContainer select[name="area"]').change(function(){
    $('.formContainer select[name="subarea"] > option').remove();
    var idarea = $(this).parents(".formContainer").find('select[name="area"]').val();
    //var idarea = $('.formContainer select[name="area"]').val();
    showLoadingAnimation($('.formContainer select[name="subarea"]'));
    $.getJSON(url+"area/get_subarea_for_area/"+idarea, {
      format: "jsonp",
      async: true,
      contentType: 'application/json; charset=utf-8', 
      cache: false,
      crossDomain: true
    })
    .done(function( area ) {
      $.each(area,function(id,name){
          var opt = $('<option>');
          opt.val(id);
          opt.text(name);
          $('.formContainer select[name="subarea"]').append(opt);
      });
      hideLoadingAnimation($('.formContainer select[name="subarea"]'));
    });
  });



  // update CUSTOMERS for AREA   
  $('.formContainer select[name="area"]').change(function(){
    $('.formContainer select[name="custom"] > option').remove();
    var idCustom = $(this).parents(".formContainer").find('select[name="area"]').val();
    //var idCustom = $('.formContainer select[name="area"]').val();
    showLoadingAnimation($('.formContainer select[name="custom"]'));
    
    $.getJSON(url+"client/get_customers_by_area/"+idCustom, {
      format: "jsonp",
      async: true,
      contentType: 'application/json; charset=utf-8', 
      cache: false,
      crossDomain: true
    })
    .done(function( cities ) {
      $.each(cities,function(id,name){
        var opt = $('<option>');
        opt.val(id);
        opt.text(name);
        $('.formContainer select[name="custom"]').append(opt);
      });
      hideLoadingAnimation($('.formContainer select[name="custom"]'));
    });
  });



  // update SUBAREA for district 
  $('.formContainer select[name="disctrict"]').change(function(){
    $('.formContainer select[name="area"] > option').remove();
    $('.formContainer select[name="subarea"] > option').remove();
    //var iddisctrict = $('.formContainer select[name="disctrict"]').val();
    var iddisctrict = $(this).parents(".formContainer").find('select[name="disctrict"]').val();
    showLoadingAnimation($('.formContainer select[name="area"]'));
    showLoadingAnimation($('.formContainer select[name="subarea"]'));
    
    $.getJSON(url+"area/get_area_for_district/"+iddisctrict, {
      format: "jsonp",
      async: true,
      contentType: 'application/json; charset=utf-8', 
      cache: false,
      crossDomain: true
    })
    .done(function( area ) {
      $.each(area,function(id,name){
        var opt = $('<option>');
        opt.val(id);
        opt.text(name);
        $('.formContainer select[name="area"]').append(opt);


        // sub zonas       
        $.getJSON(url+"area/get_subarea_for_area/"+id, {
          format: "jsonp",
          async: true,
          contentType: 'application/json; charset=utf-8', 
          cache: false,
          crossDomain: true
        })
        .done(function( subarea ) {
          $.each(subarea,function(id,name){
              var opt = $('<option>');
              opt.val(id);
              opt.text(name);
              $('.formContainer select[name="subarea"]').append(opt);
          });
        });
      });
      hideLoadingAnimation($('.formContainer select[name="area"]'));
      hideLoadingAnimation($('.formContainer select[name="subarea"]'));
    });    
  });

  
  // update VOLUMES for LINE
  $('.formContainer select[name="line"]').change(function(){
    $('.formContainer select[name="volume"] > option').remove();
    var idCustom = $(this).parents(".formContainer").find('select[name="line"]').val();
    //var idCustom = $('.formContainer select[name="line"]').val();
    showLoadingAnimation($('.formContainer select[name="volume"]'));   
    
    $.getJSON(url+"volume/get_volumes_by_line/"+idCustom, {
      format: "jsonp",
      async: true,
      contentType: 'application/json; charset=utf-8', 
      cache: false,
      crossDomain: true
    })
    .done(function( cities ) {
      $.each(cities,function(id,name){
        var opt = $('<option>');
        opt.val(id);
        opt.text(name);
        $('.formContainer select[name="volume"]').append(opt);
      });
      hideLoadingAnimation($('.formContainer select[name="volume"]'));
    });
    

    /*$.ajax({
      type: "POST",
      dataType: "json",
      url: url+"product/get_products_by_line",
      data: { line: idCustom }
    }).done(function( products ) {
      console.log(products);
      $.each(products,function(id,name){
        var opt = $('<option>');
          opt.val(id);
          opt.text(name);
          $('.formContainer select[name="product"]').append(opt);
      });
      hideLoadingAnimation($('.formContainer select[name="product"]'));
    });
*/

    /*$.ajax({
      type: "GET",
      dataType: "html",
      url: url+"volume/get_volumes_by_line/"+idCustom,
      data: { }
    }).done(function( products ) {      
      console.log(products);
      $('.formContainer select[name="volume"]').append(products);
      hideLoadingAnimation($('.formContainer select[name="volume"]'));
    });*/


  });


  // update PRODUCTS for LINE VOLUME
  $('.formContainer select[name="volume"]').change(function(){
    $('.formContainer select[name="product"] > option').remove();
    var idVolume = $(this).parents(".formContainer").find('select[name="volume"]').val();
    var idLine = $(this).parents(".formContainer").find('select[name="line"]').val();
    console.log(idLine);
    console.log(idVolume);
    showLoadingAnimation($('.formContainer select[name="product"]'));
    
    $.ajax({
      type: "POST",
      dataType: "json",
      url: url+"product/get_products_by_line_volume",
      data: { line: idLine, volume: idVolume }
    }).done(function( products ) {
      console.log(products);
      $.each(products,function(id,name){
        var opt = $('<option>');
          opt.val(id);
          opt.text(name);
          $('.formContainer select[name="product"]').append(opt);
      });
      hideLoadingAnimation($('.formContainer select[name="product"]'));
    });
  });


  // select distributor and get clients

  $(document).on("change", '#diaryTableModal select[name="distributor"]', function() { 
    $('#diaryTableModal #clientDropdown').html("");

    var id = $(this).val();
    showLoadingAnimation_td($('#clientDropdown'));

    $.getJSON( url+"diary/get_clients_for_distributor/"+id, {
      format: "jsonp",
      async: true,
      contentType: 'application/json; charset=utf-8', 
      cache: false,
      crossDomain: true
    })
    .done(function( limes ) {
      $('#diaryTableModal #clientDropdown').append('<select name="client"></select>');
      $('#diaryTableModal select[name="client"]').append('<option selected="selected" value="0">Seleccione Cliente</option>');  
      $('#diaryTableModal select[name="client"]').append('<option value="607">000000000 - TEMPORAL</option>');

      $.each(limes,function(id,name){
        if (id != 607) {
          var opt = $('<option>');
          opt.val(id);
          opt.text(name);
          $('#diaryTableModal select[name="client"]').append(opt);
        }
      });
      
      hideLoadingAnimation_td($('#clientDropdown'));

      $('#diaryTableModal select[name="client"]').chosen({
        no_results_text: "Ningún resultado encontrado :(",
        width: "200px"
      });

    });  
  });


  // select prestamo limts 
  $(document).on("change", '#diaryTableModal #clientDropdown select', function() {
    var id = $(this).val();
    console.log("---****> " + id);
    
    $.getJSON( url+"diary/get_loan_limit/"+id, {
      format: "jsonp",
      async: true,
      contentType: 'application/json; charset=utf-8', 
      cache: false,
      crossDomain: true
    })
    .done(function( limes ) {
      $('#diaryTableModal #ammount').attr("placeholder", limes);
      $('#diaryTableModal #ammount').attr("data-max", limes);
    });
  });


/*  
 $('#diaryTableModal select[name="distributor"]').change(function(){
      
      $(this).parents("tr").find('select[name="client"] > option').remove();

      var id = $(this).val();
      //console.log($(this).parents("tr").find('select[name="client"]'));

      //showLoadingAnimation($(this).parents("tr").find('select[name="client"]'));
      //$(this).parents("tr").find("#clientDropdown").append('<select class="chosen-select2" name="client"><option selected="selected" value="0">Seleccione Cliente</option></select>');
      $.getJSON( url+"diary/get_clients_for_distributor/"+id, {
        format: "jsonp",
        async: true,
        contentType: 'application/json; charset=utf-8', 
        cache: false,
        crossDomain: true
      })
      .done(function( limes ) {
        $(this).parents("tr").find('select[name="client"]').append('<option selected="selected" value="0">Seleccione Cliente</option>');
        $.each(limes,function(id,name){
          var opt = $('<option>');
          opt.val(id);
          opt.text(name);
          $(this).parents("tr").find('select[name="client"]').append(opt);
          console.log("&&&&&&&&&&&&&&&&&&&&&&&&&&&&6");
          console.log($(this).parents("tr").find('select[name="client"]'));
        });
        //hideLoadingAnimation($(this).parents("tr").find('select[name="client"]'));


        $(".chosen-select2").chosen({
          no_results_text: "Ningún resultado encontrado :(",
          width: "200px"
        });
      });
    
    });
*/

  // LIMPIAR FORMULARIO
  $('.formContainer #btn_clean').click(function(){
    $('.formContainer input[type="text"]').attr('value','');
    $('.formContainer select option').attr('selected', false);
    $('.formContainer textarea').attr('value', "");

    //$('select[name="distributor"]').val('').trigger('chosen:updated');
    //$('select[name="status"]').val('').trigger('chosen:updated');
  });
});


$(window).resize(function() {
  $("#bodycontainer").css("min-height", $(window).height());
});
$(document).ready(function() {

  $("#bodycontainer").css("min-height", $(window).height());
  console.log($(window).height());

});