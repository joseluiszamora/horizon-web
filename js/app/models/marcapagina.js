App.Marcapagina = DS.Model.extend({
    nombre: DS.attr('string'),
    url: DS.attr('string')
});
 
App.Marcapagina.FIXTURES = [
    {
        id: 1,
        nombre: "Codehero",
        url: "http://codehero.co"
    },
    {
        id: 2,
        nombre: "Twitter de Carlos Picca",
        url: "https://twitter.com/CarlosPicca"
    }
];