
// Get the latitude and longitude of the angel
let lat = document.querySelector('#mapid').dataset.lat;
let lon = document.querySelector('#mapid').dataset.lon;

let mymap = L.map('mapid').setView([lat, lon], 13);

L.tileLayer('//{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    maxZoom: 18,   
}).addTo(mymap);

// Add a circle to target the location
let circle = L.circle([lat, lon], {
   color: 'green',
   fillColor: '#198754',
   fillOpacity: 0.5,
   radius: 500
}).addTo(mymap);
