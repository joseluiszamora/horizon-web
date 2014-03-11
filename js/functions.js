var baseUrl = '';
var list;

var query = $('#script_base').attr('src').substring($('#script_base').attr('src').indexOf('?')+1);
var parms = query.split('&');
var qsParm = [];
for (var i=0; i<parms.length; i++)
{
    var pos = parms[i].indexOf('=');
    if (pos > 0)
    {
        var key = parms[i].substring(0,pos);
        var val = parms[i].substring(pos+1);
        qsParm[key.toLowerCase()] = val;
    }
}

if(qsParm['baseurl'])
{
    baseUrl = qsParm['baseurl'];
}
$(window).resize(function() {
	$("#bodycontainer").css("height", $(window).height());
});
$(document).ready(function() {

	$("#bodycontainer").css("height", $(window).height());
	console.log($(window).height());


 	$('.fields_product select[name="idLine"]').change(function(){
	    $('.fields_product select[name="idLineVolume"] > option').remove();
	    var idLine = $('.fields_product select[name="idLine"]').val();

	    $.getJSON(baseUrl+"product/get_linesvolumes/"+idLine,
	        function(linesvolumes){
	            $.each(linesvolumes,function(id,name){
	                var opt = $('<option>');
	                opt.val(id);
	                opt.text(name);
	                $('.fields_product select[name="idLineVolume"]').append(opt);
	            });
	        }
	    );
  	});

});