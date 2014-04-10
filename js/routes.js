/*//Rutas
App.Router.map(function() {
	this.resource("marcapaginas"); 
    this.resource("nosotros", function() {
        this.route("equipo");
    });
    this.route("contacto");
});
*/
Todos.Router.map(function() {
  this.resource('todos', { path: '/' });
});

// ... additional lines truncated for brevity ...
Todos.TodosRoute = Ember.Route.extend({
  model: function() {
    return this.store.find('todo');
  }
});