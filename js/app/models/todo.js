Todos.Todo = DS.Model.extend({
  title: DS.attr('string'),
  isCompleted: DS.attr('boolean')
});

// ... additional lines truncated for brevity ...
Todos.Todo.FIXTURES = [
 {
   id: 1,
   title: 'one',
   isCompleted: false
 },
 {
   id: 2,
   title: 'two',
   isCompleted: false
 },
 {
   id: 3,
   title: 'Three',
   isCompleted: false
 }
];