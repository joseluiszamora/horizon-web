/*//Start ember App
window.App = Ember.Application.create();

//Global vars
var cuentaGlobal = 0;


// data storage
App.Store = DS.Store.extend({
    revision: 11,
    adapter: "DS.FixtureAdapter"
});



//Declare class
var Marcapagina = Ember.Object.extend({
 	nombre: "laravel",
    url: "http://laravel.com",

    link: function() {
    	return this.convertir_en_link();
    }.property("nombre", "url"),
    
    convertir_en_link: function() {
        return "<a href='" + this.get("url") + "'>"
        + this.get("nombre")
        + "</a>";
    },
	
	detalle: function() {
	  return 'Link: ' + this.get('link') + '; Nombre: ' + this.get('nombre') + '; Url: ' + this.get('url');
	}.property('link', 'nombre', 'url'),

	modificarCuenta: function() {
	   cuentaGlobal += 1;
	   console.log("El valor global de cuentaGlobal es " + cuentaGlobal);
	}.observes("nombre", "url")
});

var mark = Marcapagina.create({ nombre: "jl", url: "jl.com" });*/




var idTodo = 4;
    

window.Todos = Ember.Application.create();

Todos.ApplicationAdapter = DS.FixtureAdapter.extend();