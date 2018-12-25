<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
   integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
   crossorigin=""/>

  <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

 <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"
   integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
   crossorigin=""></script>


   <style>
     #mapid { height: 400px; width: 700px;}
   </style>
</head>
<body>

<div id="mapid"></div>

<input class="type" type="text" name="state" id="division" placeholder="state/division">
<input class="type" type="text" name="city" id="city" placeholder="city">
<input class="type" type="text" name="neighbourhood" id="neighbourhood" placeholder="neighbourhood">
<input type="text" name="country" id="country" placeholder="Country">
<input type="text" name="postcode" id="postcode" placeholder="postcode">
<input type="text" name="road" id="road" placeholder="road">
<input type="text" name="state-division" id="state" placeholder="Division/State">


<input type="submit" id="submit">




  <script>
  jQuery(document).ready(function($){

    $("#submit").on('click',function(){
      // document.getElementById('mapid').innerHTML = "<div id='theMap' style='width: 100%; height: 100%;'></div>";
      $("#mapid").html("<div id='theMap' style='width: 100%; height: 100%;'></div>");
    var latitude;
    var longitude;

    village = $('#village').val();
      city = $('#city').val()
      country = $("#country").val();

     
      
    var address = {

        country:country,
        city:city,
       village:village


    };
    var rawData = $.get('https://nominatim.openstreetmap.org/?format=json&addressdetails=1&format=json&limit=1',address,function(data){
      console.log(data)
       latitude = data[0].lat;
      longitude = data[0].lon;
      console.log(data[0]);
      console.log("Latitude: "+latitude+" Longitude: "+longitude);

      var mymap = L.map('theMap').setView([latitude, longitude], 15);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
    maxZoom: 20

}).addTo(mymap);   

var marker = L.marker([latitude, longitude],{draggable:true}).addTo(mymap);

// marker Drag  
    marker.on('dragend', function(event) {
    var marker = event.target; 
    var result = marker.getLatLng();  
    var lat = result.lat; //Latitude of the current marker postition
    var lng = result.lng; //Lnogitude of the current market postition
    var latLgn = {
      format:"jsonv2",
      lat:lat,
      lon:lng
    };
    
  var revGeoCode = $.get('https://nominatim.openstreetmap.org/reverse?format=jsonv2',latLgn,function(data){

    myAdd = data.address
    console.log(myAdd);

    let country = myAdd.country;
    console.log(country);
    $("#country").val(country);


    let city = myAdd.city;
    console.log(city);
    $("#city").val(city);
    let postcode = myAdd.postcode;
    console.log(postcode);
    $("#postcode").val(postcode)
    let road = myAdd.road;
    console.log(road);
    $('#road').val(road)
    let neighbourhood = myAdd.neighbourhood;
    console.log(neighbourhood);
    $("#neighbourhood").val(neighbourhood);
    let state= myAdd.state;
    console.log(state);
    $("#state").val(state);





  });

});


    });
    });

  });


  
  </script>
</body>
</html>
