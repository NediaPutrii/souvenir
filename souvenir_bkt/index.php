<?php
session_start();
require("../connect.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <title>Bukittinggi's Souvenir</title>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDgpfxdQ0Ep_nieNjV64u4yXWeSFHAT4BE&callback=basemap"></script>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>
    <link href="assets/js/fancybox/jquery.fancybox.css" rel="stylesheet" />
     <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-datetimepicker/datertimepicker.html" />
  <link rel="stylesheet" href="assets/css/bootstrap-slider.css" type="text/css">
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

<script type="text/javascript">

var server = "http://localhost/souvenir_mysql/souvenir_bkt/";
var map;
var markersDua = [];
var koordinat = 'null'
var infoposisi = [];
var markerposisi = [];
var centerLokasi;
var markerposisi = [];
var centerBaru;
var cekRadiusStatus = "off"; 
var circles = [];
var rad;
var fotosrc = 'image/';
var angkot = [];
var directionsDisplay;
var infoDua=[];
var rute = [];
var color = "";

function a()
{
  $("#filterik").hide();
  $('#hasilik').show();
  $('#hasilcari1').show();
  $('#hasilcari').empty();
  $("#nearbyik").hide();
  $("#nearbyik1").hide();
  hapusInfo();

}


//Membuat Fungsi Saat Onload
function initt()
{
  basemap();
  viewdigitcul();
  viewdigitkec();
  $("#result").hide();

}

function init()
{
  basemap();
  viewdigitcul();
  viewdigitkec();
  $("#hasilik").hide();
  $("#hasilrute").hide();

  

}


function hapusawal()
{
  init();
  hapusMarkerTerdekat();
  hapusRadius();
  clearroute2();
  clearangkot();
  clearroute();
  hapusInfo();
  $("#nearbyik").hide();
  $("#hasilrute").hide();
  $("#tampilangkotsekitarik").hide();
  $("#selectkulll").hide();
  $("#selectfacility").hide();
  $('#hasildet').hide();
  $('#hasilcari').empty();
  $('#hasilpencarian').empty();
  $("#filterik").hide();
  $('#hasilik').show();
  $('#hasilcari1').show();
  $('#hasilcari').empty();
  $("#hasilculi").hide();
  $("#hasilsouv").hide();
  $("#hasilindustry").hide();
  $("#hasilobj").hide();
  $("#hasilhotel").hide();
  $("#hasilmosque").hide();
  $("#hasilrestaurant").hide();
}

function hapusawal1()
{
  hapusMarkerTerdekat();
  clearroute2();
  clearangkot();
  clearroute();
  hapusInfo();
  $("#nearbyik").hide();
  $("#hasilrute").hide();
  $("#tampilangkotsekitarik").hide();
  $("#selectkulll").hide();
  $("#selectfacility").hide();
  $('#hasildet').hide();
  $('#hasilcari').empty();
  $('#hasilpencarian').empty();
  $("#filterik").hide();
  $('#hasilik').show();
  $('#hasilcari1').show();
  $('#hasilcari').empty();
  $("#hasilculi").hide();
  $("#hasilsouv").hide();
  $("#hasilindustry").hide();
  $("#hasilobj").hide();
  $("#hasilhotel").hide();
  $("#hasilmosque").hide();
  $("#hasilrestaurant").hide();
}

//Membuat Fungsi Lokasi Manual
function lokasimanual()
{
  $("#filterik").hide();
  alert('Click On The Map');
  //hapusMarkerTerdekat();
  hapusRadius();
  cekRadius();    
  map.addListener('click', function(event) {

    icon: "assets/img/now.png",
    addMarker(event.latLng);

    });
  }


function viewdigitcul()
{
  cull = new google.maps.Data();
  cull.loadGeoJson(server+'souvenir.php');
  cull.setStyle(function(feature)
  {
    return({
            fillColor: '#f75d5d',
            strokeColor: '#f75d5d ',
            strokeWeight: 2,
            fillOpacity: 0.5
          });          
  }
  );
  cull.setMap(map);
}


//Membuat Fungsi Menampilkan Digitasi Kecamatan (Batas Kecamatan Bukittinggi)
function viewdigitkec()
{
  ab = new google.maps.Data();
  ab.loadGeoJson(server+'subdistrict_boundary.php');
  ab.setStyle(function(feature)
  {
     var gid = feature.getProperty('id');
     console.log("gid="+gid);
     color = '#ff3300';
     console.log(color); 
      if (gid == 'K001'){ color = '#ff3300'; 
        console.log(color); 
        return({
          fillColor:color,
          strokeWeight:2.0,
          strokeColor:'black',
          fillOpacity:0.2,
          clickable: false
        }); 
    }
      else if(gid == 'K002'){ color = '#ffd777'; 
        return({
        fillColor:color,
          strokeWeight:2.0,
          strokeColor:'black',
          fillOpacity:0.2,
          clickable: false
        });
    }
      else if(gid == 'K003'){ color = '#ec87ec'; 
        return({
        fillColor:color,
          strokeWeight:2.0,
          strokeColor:'black',
          fillOpacity:0.2,
          clickable: false
        });

    }
              
  }
  );
  ab.setMap(map);
}

function legenda()
{
  $('#tombol').empty();
  $('#tombol').append('<a type="button" id="hidelegenda" onclick="hideLegenda()" class="btn btn-default " data-toggle="tooltip" title="Sembunyikan Legenda" style="margin-right;background-color:black: 7px;"><i class="fa fa-eye-slash"></i></a> ');
  
  var layer = new google.maps.FusionTablesLayer(
    {
          query: {
            select: 'Location',
            from: 'AIzaSyBNnzxae2AewMUN0Tt_fC3gN38goeLVdVE'
          },
          map: map
        });
    var legend = document.createElement('div');
        legend.id = 'legend';
        var content = [];
        content.push('<h4>Legenda</h4>');
        content.push('<p><div class="color l"></div style=>Culinary</p>');
        content.push('<p><div class="color f"></div>Small Industry</p>');
        content.push('<p><div class="color g"></div>Souvenir</p>');
        content.push('<p><div class="color h"></div>Hotel</p>');
        content.push('<p><div class="color i"></div>Restaurant</p>');
        content.push('<p><div class="color j"></div>WorshipPlace</p>');
        content.push('<p><div class="color k"></div>Tourism</p>');
        content.push('<p><div class="color e"></div>Angkot</p>');
        content.push('<p><div class="color d"></div>District of Mandiangin Koto Selayan</p>');
        content.push('<p><div class="color c"></div>District of Guguk Panjang</p>');
        content.push('<p><div class="color b"></div>District of Aur Birugo Tigo Baleh</p>');
        
        legend.innerHTML = content.join('');
        legend.index = 1;
        map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(legend);

        
}

function hideLegenda() {
  $('#legend').remove();
  $('#tombol').empty();
  // console.log("hy jackkky");
  $('#tombol').append('<a type="button" id="showlegenda" onclick="legenda()" class="btn btn-success btn-sm " data-toggle="tooltip" title="Legenda" style="margin-right: 7px;"><i class="fa fa-eye" style="color:white;"> </i></a>');
}


//Membuat Fungsi Memberikan Marker IK
function addMarker(location)
{
  for (var i = 0; i < markerposisi.length; i++) 
  {
    markerposisi[i].setMap(null);
    hapusMarkerTerdekat();
    hapusRadius();
    cekRadius();
  } 
  marker = new google.maps.Marker
  ({
    icon: "assets/img/now.png",
    position : location,
    map: map,
    animation: google.maps.Animation.DROP,
  });
  koordinat = 
  {
    lat: location.lat(),
    lng: location.lng(),
  }
  centerLokasi = new google.maps.LatLng(koordinat.lat, koordinat.lng);
  markerposisi.push(marker);
  infowindow = new google.maps.InfoWindow();
  infowindow.setContent("<center><a style='color:black;'>You're Here <br> lat : "+koordinat.lat+" <br> long : "+koordinat.lng+"</a></center>");
  infowindow.open(map, marker);
  usegeolocation=true;
  markerposisi.push(marker)
  infoposisi.push(infowindow);  
}


//Membuat Fungsi Menampilkan Posisi Saat Ini
function posisisekarang()
{
  $("#filterik").hide();
  hapusMarkerTerdekat();  
  google.maps.event.clearListeners(map, 'click');
  navigator.geolocation.getCurrentPosition(function(position)
  {
    koordinat = 
    {
      lat: position.coords.latitude,
      lng: position.coords.longitude
    };
    console.log(koordinat)

    marker = new google.maps.Marker
    ({
      icon:"assets/img/now.png",
      position: koordinat,
      map: map,
      animation: google.maps.Animation.DROP,
    });

    infowindow = new google.maps.InfoWindow
    ({
      position: koordinat,
      content: "<center><a style='color:black;'>You're Here <br> lat : "+koordinat.lat+" <br> long : "+koordinat.lng+"</a></center>"
    });
    infowindow.open(map, marker);
    markersDua.push(marker);
    infoposisi.push(infowindow);
     map.setCenter(koordinat);
     map.setZoom(20); 
  });
}


//Membuat Fungsi Menampilkan Peta Google Map
function basemap()
{
  map = new google.maps.Map(document.getElementById('map'), 
  {
    zoom: 13,
    center: new google.maps.LatLng(-0.30504082579099817, 100.36937713623047),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
}



//Membuat Fungsi Hapus Market Terdekat
function hapusMarkerTerdekat() 
{
  for (var i = 0; i < markersDua.length; i++) 
  {
    markersDua[i].setMap(null);
  }
}

function detailinforestaurant(id19)
{  
  $('#info').empty();
  hapusInfo();
  clearangkot();
  clearroute();
  hapusMarkerTerdekat();
       $.ajax({ 
      url: server+'detailinforestaurant.php?info='+id19, data: "", dataType: 'json', success: function(rows)
        { 
         for (var i in rows) 
          { 
            console.log('dd');
            var row = rows[i];
            var id = row.id;
            
            var namaa = row.name;
            var address=row.address;
            
           
            var owner=row.owner;
            var cp = row.cp;
            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            centerBaru = new google.maps.LatLng(row.latitude, row.longitude);
            marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/culf.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(latitude);
              console.log(longitude);
              markersDua.push(marker);
            map.setCenter(centerBaru);
            map.setZoom(16); 
            if (address==null)
                    {
                      address="tidak ada";
                    } 
             $('#info').append("");
            infowindow = new google.maps.InfoWindow({
            position: centerBaru,

            content: "<center><span style=color:black><b>Information</b><table><tr><td><i class='fa fa-home'></i>Name</td><td>:</td><td> "+namaa+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Address</td><td>:</td><td> "+address+"</td></tr><br><tr><td><i class='fa fa-phone'></i>Telephone</td><td>:</td><td> "+cp+"</td></tr></table></span>",   
            pixelOffset: new google.maps.Size(0, -33)
            });
          infoposisi.push(infowindow); 
          hapusInfo();
          infowindow.open(map);
            
          }  
        }
      }); 
}

//Menampilkan Detail Info IK
function detailinfoik(id1)
{  
  $('#info').empty();
  hapusInfo();
  clearangkot();
  clearroute();
  hapusMarkerTerdekat();
       $.ajax({ 
      url: server+'detailinfoik.php?info='+id1, data: "", dataType: 'json', success: function(rows)
        { 
         for (var i in rows) 
          { 
            console.log('dd');
            var row = rows[i];
            var id = row.id;
            
            var namaa = row.name;
            var address=row.address;
            
           
            var owner=row.owner;
            var cp = row.cp;
            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            centerBaru = new google.maps.LatLng(row.latitude, row.longitude);
            marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/ik.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(latitude);
              console.log(longitude);
              markersDua.push(marker);
            map.setCenter(centerBaru);
            map.setZoom(16); 
            if (address==null)
                    {
                      address="tidak ada";
                    } 
          //           if (foto=='null' || foto=='' || foto==null){
          //   foto='eror.png';
          // } 
             $('#info').append("");
            infowindow = new google.maps.InfoWindow({
            position: centerBaru,

            content: "<center><span style=color:black><b>Information</b><table><tr><td><i class='fa fa-home'></i>Name</td><td>:</td><td> "+namaa+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Address</td><td>:</td><td> "+address+"</td></tr><br><tr><td><i class='fa fa-phone'></i>Telephone</td><td>:</td><td> "+cp+"</td></tr></table></span>",   
            pixelOffset: new google.maps.Size(0, -33)
            });
          infoposisi.push(infowindow); 
          hapusInfo();
          infowindow.open(map);
            
          }  
           
            // ;ow();tampilsekitar()
        }
      }); 
}

function nearby()
{  
  $("#hasilik").hide();
  $("#nearbyik").show();
  $("#nearbyik1").show();
}



//Menghapus Info
function hapusInfo() 
{
  for (var i = 0; i < infoposisi.length; i++) 
    {
      infoposisi[i].setMap(null);
    }
}

//Menampilkan Detail Info Kuliner
function detculi(id14433){  
  
  $('#info').empty();
  $('#tampilangkotsekitarik').hide();
  $("#hasilrute").hide();
  $('#hasilcaridetculi').empty();
  $('#hasilcaridetculi1').show();
  // $('#hasildet').show();
  $('#hasilcaridet').empty();
  $('#hasilcaridet1').show();
   hapusInfo();
   clearroute2();
   clearroute();
   hapusrouteangkot();
   hapusMarkerTerdekat();
       $.ajax({ 
      url: server+'detculi.php?info='+id14433, data: "", dataType: 'json', success: function(rows)
        { 

          // $('#hasilcaridet').append("<tr><td colspan='2'><strong>Culinary</strong></td><td><strong>Price</strong></td></tr>");

         for (var i in rows) 
          { 
            console.log('ddd');
            var row = rows[i];
            var id = row.id;
            var namaa = row.name;
            var capacity = row.capacity;
            var address=row.address;
            var cp=row.cp;
            var open=row.open;
            var close=row.close;
            var price = row.price;
            var culinary = row.culinary; 
            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            centerBaru = new google.maps.LatLng(row.latitude, row.longitude);
            marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/cul.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(latitude);
              console.log(longitude);
              console.log(id);
              markersDua.push(marker);
            map.setCenter(centerBaru);
            map.setZoom(18); 

                // $('#hasilcaridet').append("<tr><td colspan='2'> "+culinary+"</td><td> "+price+"</td></tr>");
            infowindow = new google.maps.InfoWindow({
            position: centerBaru,
            content: "<center><span style=color:black><b>Information</b><table><tr><td><i class='fa fa-home'></i>Name</td><td>:</td><td> "+namaa+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Address</td><td>:</td><td> "+address+"</td></tr><br><tr><td><i class='fa fa-phone'></i>Telephone</td><td>:</td><td> "+cp+"</td></tr><br><tr><td><i class='fa fa-clock-o'></i>Open</td><td>:</td><td> "+open+"</td></tr><br><tr><td><i class='fa fa-clock-o'></i>Close</td><td>:</td><td> "+close+"</td></tr><br><tr><td><i class='fa fa-building'></i>Capacity</td><td>:</td><td> "+capacity+"</td></tr></table></span>",   
            pixelOffset: new google.maps.Size(0, -33)
            });
          infoposisi.push(infowindow); 
          hapusInfo();
          infowindow.open(map);
            
          }  
        }
      }); 
}


function detailinfomosque(id9)
{  
  $('#info').empty();
   hapusInfo();
      // clearroute2();
      hapusMarkerTerdekat();
      clearangkot();
      clearroute();
       $.ajax({ 
      url: server+'detailinfomosque.php?info='+id9, data: "", dataType: 'json', success: function(rows)
        { 
         for (var i in rows) 
          { 
            console.log('dd');
            var row = rows[i];
            var id = row.id;
            //var foto = row.foto;
            var name = row.name;
            var address=row.address;
            var capacity = row.capacity;
            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            centerBaru = new google.maps.LatLng(row.latitude, row.longitude);
            marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/msj.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(latitude);
              console.log(longitude);
              markersDua.push(marker);
            map.setCenter(centerBaru);
            map.setZoom(18); 
          
            infowindow = new google.maps.InfoWindow({
            position: centerBaru,
            content: "<center><span style=color:black><b>Information</b><table><tr><td><i class='fa fa-home'></i>Mosque Name</td><td>:</td><td> "+name+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Address</td><td>:</td><td> "+address+"</td></tr><br><tr><td><i class='fa fa-building'></i>Capacity</td><td>:</td><td> "+capacity+"</td></tr></table></span>",   
            pixelOffset: new google.maps.Size(0, -33)
            });
          infoposisi.push(infowindow); 
          hapusInfo();
          infowindow.open(map);
            
          }   
        }
      }); 
}


//Menampilkan Detail Info Obj Wisata
function detailinfoobj(id3)
{   
  $('#info').empty();
   hapusInfo();
     clearangkot();
      clearroute();
      hapusMarkerTerdekat();
       $.ajax({ 
      url: server+'detailinfoobj.php?info='+id3, data: "", dataType: 'json', success: function(rows)
        { 
         for (var i in rows) 
          { 
            console.log('dddd');
            var row = rows[i];
            var id = row.id;
            //var foto = row.foto;
            var name = row.name;
            var address=row.address;
            var open = row.open;
            var close = row.close;
            var ticket = row.ticket;
            //var fasilitas = row.fasilitas;
            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            centerBaru = new google.maps.LatLng(row.latitude, row.longitude);
            marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/tours.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(latitude);
              console.log(longitude);
              markersDua.push(marker);
            map.setCenter(centerBaru);
            map.setZoom(16); 
         
            infowindow = new google.maps.InfoWindow({
            position: centerBaru,
            content: "<center><span style=color:black><b>Information</b><table><tr><td><i class='fa fa-home'></i>Object Name</td><td>:</td><td> "+name+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Address</td><td>:</td><td> "+address+"</td></tr><br><tr><td><i class='fa fa-building'></i>Open</td><td>:</td><td> "+open+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Close</td><td>:</td><td> "+close+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Cost</td><td>:</td><td> "+ticket+"</td></tr></table></span>",   
            pixelOffset: new google.maps.Size(0, -33)
            });
            infoposisi.push(infowindow); 
            hapusInfo();
            infowindow.open(map);
            
          }      
        }
      }); 
}


//Menampilkan Detail Info Souvenir
function detailinfosou(id14)
{  
  $('#info').empty();
   hapusInfo();
      clearangkot();
      clearroute();
      hapusMarkerTerdekat();
       $.ajax({ 
      url: server+'detailinfosouv.php?info='+id14, data: "", dataType: 'json', success: function(rows)
        { 
         for (var i in rows) 
          { 
            console.log('ddd');
            var row = rows[i];
            var id = row.id;
            var namaa = row.name;
            var address=row.address;
            var cp = row.cp;
            var owner = row.owner;
           

            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            centerBaru = new google.maps.LatLng(row.latitude, row.longitude);
            marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/souv.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(latitude);
              console.log(longitude);
              markersDua.push(marker);
            map.setCenter(centerBaru);
            map.setZoom(18); 
            if (address==null)
                    {
                      address="tidak ada";
                    } 
            infowindow = new google.maps.InfoWindow({
            position: centerBaru,
            content: "<center><span style=color:black><b>Information</b><table><tr><td><i class='fa fa-home'></i>Name</td><td>:</td><td> "+namaa+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Address</td><td>:</td><td> "+address+"</td></tr><br><tr><td><i class='fa fa-phone'></i>Telephone</td><td>:</td><td> "+cp+"</td></tr></table></span>",   
            pixelOffset: new google.maps.Size(0, -33)
            });
          infoposisi.push(infowindow); 
          hapusInfo();
          infowindow.open(map);   
          }  
        }
      }); 
}



function detailangkot(id_angkot,lat,lng,lat1,lng1)
{
          
          clearangkot();
          hapusRadius();
          //hapusMarkerTerdekat();
          clearangkot();
          clearroute();
          
            $.ajax({ 
            url: server+'/tampilkanrute.php?id='+id_angkot, data: "", dataType: 'json', success: function(rows) 
            { 
              
              for (var i in rows.features) 
                { 
                  var id=rows.features[i].properties.id;
                  //var warna=rows.features[i].properties.warna;
                  var latitude  = rows.features[i].properties.latitude; 
                  var longitude = rows.features[i].properties.longitude ;
                  var destination=rows.features[i].properties.destination;
                  var track=rows.features[i].properties.track;
                  var route_color=rows.features[i].properties.route_color;
                  console.log(id);

                  tampilrute(id,  latitude, longitude,route_color);
                  var centerBaru = new google.maps.LatLng(latitude,longitude);
                  // map.setCenter(centerBaru);
                  var infowindow = new google.maps.InfoWindow({
                    position: centerBaru,
                    content: "<bold>INFORMATION</bold><br>Kode Trayek: "+id+"<br>Jurusan: "+destination+"<br>Jalur Angkot: "+track+"",
                  });
                    infowindow.open(map);                    
                  route_sekitar(lat,lng,lat1,lng1);

                }  
                $('#hasilrute').hide();                  
            } 
         });           
}

function listgeom(id_angkot){
        hapusInfo();
        $.ajax({ 
            url: server+'tampilkanrute.php?id='+id_angkot, data: "", dataType: 'json', success: function(rows) 
            { 
              arraylatlngangkot=[];
              var count=0;
              for (var i in rows.features[0].geometry.coordinates) 
                { 
                  for (var n in rows.features[0].geometry.coordinates[i])
                  {
                    var latlng=rows.features[0].geometry.coordinates[i][n];
                    // var latlng=rows.features[0].geometry.coordinates[i][n][0];
                    count++;
                    arraylatlngangkot.push(latlng);
                  }
                  console.log("a");
                } 
              console.log(count);
              if(count%2==1){
                count++;
              }
              //console.log(mid);
              var mid=count/2;
              // arraylatlngangkot[mid];
              var lat=arraylatlngangkot[mid][1];
              var lon=arraylatlngangkot[mid][0];
              var id_angkot=rows.features[0].properties.id;
              var jalur_angkot=rows.features[0].properties.track;
              var jurusan=rows.features[0].properties.destination;
              
           }
         });
        }


function tampilrute(id_angkot,  latitude, longitude, route_color){
        //clearangkot();
        ja = new google.maps.Data();
        ja.loadGeoJson(server+'tampilkanrute.php?id='+id_angkot);
        ja.setStyle(function(feature){
          return({
              fillColor: 'yellow',
              strokeColor: route_color,
              strokeWeight: 2,
              fillOpacity: 0.5
              });          
        });
        ja.setMap(map);  
        angkot.push(ja);
        map.setZoom(18);
        }


//Membuat Fungsi Menampilkan Seluruh Kuliner 
function viewsou()
{
  $("#result").show();
  $("#view_kanan_table").empty();
  hapusawal();
  $.ajax
  ({ 
    url: server+'viewsou.php', data: "", dataType: 'json', success: function(rows) 
    { 
      if(rows==null)
      {
        alert('Data Did Not Exist!');
      }
      else
      {
        $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
        console.log("rownya");
        console.log(rows);
        for (var i in rows) 
        { 
          var row = rows[i];
          var id = row.id;
          var name = row.name;
          var address=row.address;
          var lat=row.lat;
          var lon = row.lng;
          var tabel = row.tabel;
          console.log(name);
          centerBaru = new google.maps.LatLng(lat, lon);
          map.setCenter(centerBaru);
          map.setZoom(13); 
          clickMarker(centerBaru, id); 
          // var marker = new google.maps.Marker
          // ({
          //   position: centerBaru,              
          //   icon:'assets/img/souv.png',
          //   animation: google.maps.Animation.DROP,
          //   map: map
          // });
          // markersDua.push(marker);
          map.setCenter(centerBaru);
          // if(tabel == 'sou'){
           $('#hasilcari').append("<tr><td>"+name+"</td><td style='text-align: center;'  ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id+"\");detsousou(\""+id+"\");'></a></td><td style='text-align: center;'  ><a role='button' class='btn btn-success fa fa-taxi' title='Angkot' onclick='souangkot(\""+id+"\",\""+lat+"\",\""+lon+"\");ikangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
            
          // } else {
            
          //  $('#hasilcari').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success fa fa-info' onclick='detsouxx(\""+id+"\");'></a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='ikangkot(\""+id+"\")'></a></td></tr>");
            
          // }

        }
      } 
      // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
    }
  });           
}


//Menampilkan Detail Info Kuliner
function detsousou(id144){  
  
 $('#info').empty();
   $('#tampilangkotsekitarik').hide();
   $("#hasilrute").hide();
   $('#hasilcaridetculi').empty();
   $('#hasilcaridetculi1').show();
   $('#hasildet').show();
   $('#hasilcaridet').empty();
   $('#hasilcaridet1').show();
   hapusInfo();
   hapusrouteangkot();
   clearroute2();
   clearroute();
   hapusMarkerTerdekat();
       $.ajax({ 
      url: server+'detailinfosou.php?info='+id144, data: "", dataType: 'json', success: function(rows)
        { 
         for (var i in rows) 
          { 
            console.log('ddd');
            var row = rows[i];
            var id = row.id;
            var namaa = row.name;
            var nama = row.nama;
            var status = row.status;
            var address=row.address;
            var cp=row.cp;
            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            centerBaru = new google.maps.LatLng(row.latitude, row.longitude);
            //markersDua.push(marker);
            // map.setCenter(centerBaru);
            map.setZoom(18); 
                // $('#hasilcaridet').append("<tr><td><b> Place's Status </b></td><td>:</td><td> "+status+"</td></tr>");
                //$('#hasilcaridet').append("<tr><td><b> Souvenir's Type </b></td><td>:</td><td> "+nama+"</td></tr>");
            if (address==null)
                    {
                      address="tidak ada";
                    } 
          }  
        }
      }); 
}


//Menampilkan Detail Info Kuliner
function detsousou1(id144z){  
  
$('#info').empty();
   $('#tampilangkotsekitarik').hide();
   $("#hasilrute").hide();
   $('#hasilcaridetculi').empty();
   $('#hasilcaridetculi1').show();
   $('#hasildet').show();
   $('#hasilcaridet').empty();
   $('#hasilcaridet1').show();
   console.log(server+'detailinfoik.php?info='+id144z)
   hapusInfo();
   hapusrouteangkot();
   clearroute2();
   clearroute();
       $.ajax({ 
      url: server+'detik.php?info='+id144z, data: "", dataType: 'json', success: function(rows)
        { 
         for (var i in rows) 
          { 
            console.log('ddd');
            var row = rows[i];
            var id = row.id;
            var namaa = row.name;
            var nama = row.nama;
            var status = row.status;
            var address=row.address;
            var cp=row.cp;
            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            var type = row.type ;
            centerBaru = new google.maps.LatLng(row.latitude, row.longitude);
            //markersDua.push(marker);
            marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/souv.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(latitude);
              console.log(longitude);
              console.log(id);
              markersDua.push(marker);
            map.setCenter(centerBaru);
            map.setZoom(18); 
                $('#hasilcaridet').append("<tr><td><b> Place's Status </b></td><td>:</td><td> "+status+"</td></tr>");
                $('#hasilcaridet').append("<tr><td><b> Industry's Type </b></td><td>:</td><td> "+type+"</td></tr>");
            if (address==null)
                    {
                      address="tidak ada";
                    } 
          }  
        }
      }); 
}


//Menampilkan Detail Info Kuliner
function detsou(id14433){  
  
  $('#info').empty();
  $('#tampilangkotsekitarik').hide();
  $("#hasilrute").hide();
  $('#hasilcaridetculi').empty();
  $('#hasilcaridetculi1').show();
  $('#hasildet').show();
  $('#hasilcaridet').empty();
  $('#hasilcaridet1').show();
   hapusInfo();
   clearroute2();
   clearroute();
   hapusrouteangkot();
   hapusMarkerTerdekat();
      console.log('aaa');
      console.log(server+'detsou.php?info='+id14433)
       $.ajax({ 
      url: server+'detsou.php?info='+id14433, data: "", dataType: 'json', success: function(rows)
        { 

         console.log(rows);
          // $('#hasilcaridet').append("<tr><td colspan='2'><strong><tr><td><b> Place's Status </b></td><td>:</td><td>"+rows[0].status+"</td></tr><tr><td><b> Souvenir's Type </b></td><td>:</td><td>"+rows[0].type+"</td></tr><td colspan='2'><strong>Product</strong></td><td><strong>Price</strong></td></tr>");
           console.log('bb');
         for (var i in rows) 
          { 
            console.log('ddd');
            var row = rows[i];
            var id = row.id;
            var name = row.name;
            
            var address=row.address;
            var cp=row.cp;
            var owner=row.owner;
           
            var price = row.price;
            var status = row.status;
            var type = row.type;
            var product_souvenir = row.product_souvenir; 
            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            centerBaru = new google.maps.LatLng(latitude, longitude);
            marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/souv.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(latitude);
              console.log(longitude);
              console.log(id);
              markersDua.push(marker);
            // map.setCenter(centerBaru);
            map.setZoom(18); 

                // $('#hasilcaridet').append("<tr><td colspan='2'> "+product_souvenir+"</td><td> "+price+"</td></tr>");
            infowindow = new google.maps.InfoWindow({
            position: centerBaru,
            content: "<center><span style=color:black><b>Information</b><table><tr><td><i class='fa fa-home'></i>Name</td><td>:</td><td> "+name+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Address</td><td>:</td><td> "+address+"</td></tr><br><tr><td><i class='fa fa-phone'></i>Telephone</td><td>:</td><td> "+cp+"</td></tr><br><tr><td><i class='fa fa-clock-o'></i>Owner</td><td>:</td><td> "+owner+"</td></tr></table></span><br > <a  class='btn btn-success fa fa-compass' type='button' title=Nearby style='color:white;'  onclick='tampil_sekitar(\""+latitude+"\",\""+longitude+"\",\""+name+"\")'<br></a>&nbsp<a class='btn btn-success fa fa-info' title='Info' type='button' style='color:white;' onclick='gallery(\""+id+"\")'<br> </a>&nbsp<a class='btn btn-success fa fa-road' title='Route'  role=button' type='button' style='color:white;'  onclick='callRoute(centerLokasi,centerBaru);rutetampil()' />",   
            pixelOffset: new google.maps.Size(0, -33)
            });
          infoposisi.push(infowindow); 
          hapusInfo();
          infowindow.open(map);
            
          }  
        }
      }); 
}


//Menampilkan Detail Info IK
function detsouxx(id14433){  
  
  $('#info').empty();
  $('#tampilangkotsekitarik').hide();
  $("#hasilrute").hide();
  $('#hasilcaridetculi').empty();
  $('#hasilcaridetculi1').show();
  $('#hasildet').show();
  $('#hasilcaridet').empty();
  $('#hasilcaridet1').show();
   hapusInfo();
   clearroute2();
   clearroute();
   hapusrouteangkot();
   hapusMarkerTerdekat();
      console.log('aaa');
      
       $.ajax({ 
      url: server+'detik.php?info='+id14433, data: "", dataType: 'json', success: function(rows)
        { 

          // $('#hasilcaridet').append("<tr><td colspan='2'><strong><tr><td><b> Place's Status </b></td><td>:</td><td>"+rows[0].status+"</td></tr><tr><td><b> Industry's Type</b></td><td>:</td><td>"+rows[0].type+"</td></tr><td colspan='2'><strong>Product</strong></td><td><strong>Price</strong></td></tr>");
           console.log('bb');
         for (var i in rows) 
          { 
            console.log('ddd');
            var row = rows[i];
            var id = row.id;
            var name = row.name;
            
            var address=row.address;
            var cp=row.cp;
            var owner=row.owner;
           
            var price = row.price;
            var status = row.status;
            var type = row.type;
            var product_small_industry = row.product_small_industry; 
            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            centerBaru = new google.maps.LatLng(row.latitude, row.longitude);
            marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/souv.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(latitude);
              console.log(longitude);
              console.log(id);
              markersDua.push(marker);
            map.setCenter(centerBaru);
            map.setZoom(18); 

                // $('#hasilcaridet').append("<tr><td colspan='2'> "+product_small_industry+"</td><td> "+price+"</td></tr>");
            infowindow = new google.maps.InfoWindow({
            position: centerBaru,
            content: "<center><span style=color:black><b>Information</b><table><tr><td><i class='fa fa-home'></i>Name</td><td>:</td><td> "+name+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Address</td><td>:</td><td> "+address+"</td></tr><br><tr><td><i class='fa fa-phone'></i>Telephone</td><td>:</td><td> "+cp+"</td></tr><br><tr><td><i class='fa fa-clock-o'></i>Owner</td><td>:</td><td> "+owner+"</td></tr></table></span><br><a class='btn btn-success fa fa-compass' onclick='tampil_sekitar(\""+latitude+"\",\""+longitude+"\",\""+name+"\")'<br>&nbsp&nbsp<a class='btn btn-success fa fa-info' title='Info' onclick='gallery(\""+id+"\")'<br>&nbsp&nbsp <a class='btn btn-success fa fa-road' title='Angkot' onclick='callRoute(centerLokasi,centerBaru);rutetampil()' />",   
            pixelOffset: new google.maps.Size(0, -33)
            });
          infoposisi.push(infowindow); 
          hapusInfo();
          infowindow.open(map);
            
          }  
        }
      }); 
}



//Menampilkan Detail Info Kuliner
function detsou1(id14433f){  
  
 $('#info').empty();
   $('#tampilangkotsekitarik').hide();
   $("#hasilrute").hide();
   $('#hasilcaridetculi').empty();
   $('#hasilcaridetculi1').show();
   $('#hasildet').show();
   $('#hasilcaridet').empty();
   $('#hasilcaridet1').show();
   hapusInfo();
   hapusrouteangkot();
   clearroute2();
   clearroute();
      console.log('aaa');
      
       $.ajax({ 
      url: server+'detsou.php?info='+id14433f, data: "", dataType: 'json', success: function(rows)
        { 

          // $('#hasilcaridet').append("<tr><td colspan='2'><strong>Product</strong></td><td><strong>Price</strong></td></tr>");
           console.log('bb');
         for (var i in rows) 
          { 
            console.log('ddd');
            var row = rows[i];
            var id = row.id;
            var name = row.name;
            var dataproduct = row.dataproduct;
            
            var address=row.address;
            var cp=row.cp;
            var owner=row.owner;
           
            var price = row.price;
            var product_souvenir = row.product_souvenir; 
            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            centerBaru = new google.maps.LatLng(row.latitude, row.longitude);
            marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/souv.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(latitude);
              console.log(longitude);
              console.log(id);
              markersDua.push(marker);
            map.setCenter(centerBaru);
            map.setZoom(18); 

                // $('#hasilcaridet').append("<tr><td colspan='2'> "+dataproduct+"</td><td> "+price+"</td></tr>");
            infowindow = new google.maps.InfoWindow({
            position: centerBaru,
            content: "<center><span style=color:black><b>Information</b><table><tr><td><i class='fa fa-home'></i>Name</td><td>:</td><td> "+name+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Address</td><td>:</td><td> "+address+"</td></tr><br><tr><td><i class='fa fa-phone'></i>Telephone</td><td>:</td><td> "+cp+"</td></tr><br><tr><td><i class='fa fa-clock-o'></i>Owner</td><td>:</td><td> "+owner+"</td></tr></table></span><br><a class='btn btn-success fa fa-compass' style='color:white' title=Nearby onclick='tampil_sekitar(\""+latitude+"\",\""+longitude+"\",\""+name+"\")'<br></a>&nbsp<a class='btn btn-success fa fa-info' title='Info' style='color:white' title='Info' onclick='gallery(\""+id+"\") '<br><br></a>&nbsp<a class='btn btn-success fa fa-road' title='Route' style='color:white' onclick='callRoute(centerLokasi,centerBaru);rutetampil()' />",   
            pixelOffset: new google.maps.Size(0, -33)
            });
          infoposisi.push(infowindow); 
          hapusInfo();
          infowindow.open(map);
            
          }  
        }
      }); 
}

//Menampilkan Detail Info IK 
function detik(id14433){  
  
 $('#info').empty();
  $('#tampilangkotsekitarik').hide();
  $("#hasilrute").hide();
  $('#hasilcaridetculi').empty();
  $('#hasilcaridetculi1').show();
  $('#hasildet').show();
  $('#hasilcaridet').empty();
  $('#hasilcaridet1').show();
   hapusInfo();
   clearroute2();
   clearroute();
   hapusrouteangkot();
   hapusMarkerTerdekat();
      console.log('aaa');
      
       $.ajax({ 
      url: server+'detik.php?info='+id14433, data: "", dataType: 'json', success: function(rows)
        { 

          $('#hasilcaridet').append("<tr><td colspan='2'><strong>Product</strong></td><td><strong>Price</strong></td></tr>");
           console.log('bb');
         for (var i in rows) 
          { 
            console.log('ddd');
            var row = rows[i];
            var id = row.id;
            var name = row.name;
            
            var address=row.address;
            var cp=row.cp;
            var owner=row.owner;
           
            var price = row.price;
            var product_small_industry = row.product_small_industry; 
            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            centerBaru = new google.maps.LatLng(row.latitude, row.longitude);
            marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/ik.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(latitude);
              console.log(longitude);
              console.log(id);
              markersDua.push(marker);
            map.setCenter(centerBaru);
            map.setZoom(18); 

                $('#hasilcaridet').append("<tr><td colspan='2'> "+product_small_industry+"</td><td> "+price+"</td></tr>");
            infowindow = new google.maps.InfoWindow({
            position: centerBaru,
            content: "<center><span style=color:black><b>Information</b><table><tr><td><i class='fa fa-home'></i>Name</td><td>:</td><td> "+name+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Address</td><td>:</td><td> "+address+"</td></tr><br><tr><td><i class='fa fa-phone'></i>Telephone</td><td>:</td><td> "+cp+"</td></tr><br><tr><td><i class='fa fa-clock-o'></i>Owner</td><td>:</td><td> "+owner+"</td></tr></table></span><br><a type='button' class='btn btn-success fa fa-compass'  onclick='tampil_sekitar(\""+latitude+"\",\""+longitude+"\",\""+name+"\")'<br>&nbsp&nbsp<a type='button' class='btn btn-success fa fa-info' onclick='gallery(\""+id+"\")'<br>&nbsp&nbsp <a class='btn btn-success fa fa-road' onclick='callRoute(centerLokasi,centerBaru);rutetampil()' />",   
            pixelOffset: new google.maps.Size(0, -33)
            });
          infoposisi.push(infowindow); 
          hapusInfo();
          infowindow.open(map);
            
          }  
        }
      }); 
}



function hapusrouteangkot() 
{
  for (var i = 0; i < angkot.length; i++) 
  {
    angkot[i].setMap(null);
  }
}

function gallery(azz){    
      console.log(azz);
    window.open(server+'gallery.php?idgallery='+azz);    
   }


function clickMarker(centerBaru, id)
{
  
  var marker = new google.maps.Marker
    ({
      icon: "assets/img/souv.png",
      position: centerBaru,
      map: map
    });
    markersDua.push(marker);
    
    google.maps.event.addListener(marker, "click", function(){
        detsou1(id);
        //detsousou1(id);
       
      });

}


//Membuat Fungsi Mencari Kuliner
function find_sou() 
{
  hapusawal();
  if(kul_nama.value=='')
  {
    alert("Isi kolom pencarian terlebih dahulu !");
  }
  else
  {
    //$('#hasilcari').empty();
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var kulnama = document.getElementById('kul_nama').value;
    
    $.ajax
    ({ 
      url: server+'find_sou.php?cari_nama='+kulnama, data: "", dataType: 'json', success: function(rows)
      { 
        // console.log(url);
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var name   = row.name;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          var tabel = row.tabel;

          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/souv.png",
          });
          // console.log(lat);
          // console.log(lon);
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(15);
          clickMarker(centerBaru, id);
          console.log(name);
          // if(tabel == 'sou'){
           $('#hasilcari').append("<tr><td>"+name+"</td><td style='text-align:center;'><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id+"\");detsousou(\""+id+"\");'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\",\""+lat+"\",\""+lon+"\");ikangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
            
          // } else {
          //  $('#hasilcari').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success fa fa-info' onclick='detsouxx(\""+id+"\");'></a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='ikangkot(\""+id+"\")'></a></td></tr>");
            
          // }
          // $('#hasilcari').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success' onclick='detsou(\""+id+"\");detsousou(\""+id+"\");'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='souangkot(\""+id+"\")'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }

    }); 
  }
}





//Membuat Fungsi Cari Kuliner Berdasarkan Kecamatan
function viewkecamatansou()
{
  $('#populertourism').hide();
  hapusawal();
  if (document.getElementById('carikecamatankul').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var kulkec = document.getElementById('carikecamatankul').value;
    console.log(kulkec);
    
    $.ajax
    ({ 
      url: server+'district.php?district='+kulkec, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id_tempat_kuliner  = row.id;
          var id_small_industry = row.id;
          var nama_tempat_kuliner   = row.name;
          var id_kecamatan   = row.id;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          var jenis = row.jenistabel ;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/souv.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id_tempat_kuliner);
          console.log(jenis);
          // if (jenis == 'sou') {
            $('#hasilcari').append("<tr><td>"+nama_tempat_kuliner+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id_tempat_kuliner+"\");detsousou(\""+id_tempat_kuliner+"\")'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id_tempat_kuliner+"\",\""+lat+"\",\""+lon+"\");ikangkot(\""+id_tempat_kuliner+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
          // } else {
          //   $('#hasilcari').append("<tr><td>"+nama_tempat_kuliner+"</td><td><a role='button' class='btn btn-success fa fa-info' onclick='detsouxx(\""+id_tempat_kuliner+"\");'></a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='ikangkot(\""+id_tempat_kuliner+"\")'></a></td></tr>");
          // }

          // $('#hasilcari').append("<tr><td>"+nama_tempat_kuliner+"</td><td><a role='button' class='btn btn-success' onclick='detsou(\""+id_tempat_kuliner+"\");'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='souangkot(\""+id_tempat_kuliner+"\")'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}


function viewtipea()
{
  $('#populertourism').hide();
  hapusawal();
  if (document.getElementById('caritipesou').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var stat = document.getElementById('caritipesou').value;
    console.log(stat);
    $('#hasilcari').empty();
    $('#hasilpencarian').empty();
    $.ajax
    ({ 
      url: server+'sou_tipea.php?tipe_sou='+stat, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var nama   = row.nama;
          var address   = row.address;
          var owner   = row.owner;
          var id_souvenir_type   = row.id_souvenir_type;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/souv.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id);
          console.log(id_souvenir_type);
          $('#hasilcari').append("<tr><td>"+nama+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id+"\");detsousou(\""+id+"\");'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\",\""+lat+"\",\""+lon+"\");ikangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}

function viewtipeb()
{
  $('#populertourism').hide();
  hapusawal();
  if (document.getElementById('caritipesou').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var stat = document.getElementById('caritipesou').value;
    console.log(stat);
    $('#hasilcari').empty();
    $('#hasilpencarian').empty();
    $.ajax
    ({ 
      url: server+'sou_tipeb.php?tipe_sou='+stat, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var nama   = row.nama;
          var address   = row.address;
          var owner   = row.owner;
          var id_souvenir_type   = row.id_souvenir_type;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/souv.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id);
          console.log(id_souvenir_type);
          $('#hasilcari').append("<tr><td>"+nama+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info'  onclick='detsou(\""+id+"\");detsousou(\""+id+"\");'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\",\""+lat+"\",\""+lon+"\");ikangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}


function viewtipec()
{
  $('#populertourism').hide();
  hapusawal();
  if (document.getElementById('caritipesou').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var stat = document.getElementById('caritipesou').value;
    console.log(stat);
    $('#hasilcari').empty();
    $('#hasilpencarian').empty();
    $.ajax
    ({ 
      url: server+'sou_tipec.php?tipe_sou='+stat, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var nama   = row.nama;
          var address   = row.address;
          var owner   = row.owner;
          var id_souvenir_type   = row.id_souvenir_type;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/souv.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id);
          console.log(id_souvenir_type);
          $('#hasilcari').append("<tr><td>"+nama+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info'  onclick='detsou(\""+id+"\");detsousou(\""+id+"\");'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\",\""+lat+"\",\""+lon+"\");ikangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}



function viewtiped()
{
  $('#populertourism').hide();
  hapusawal();
  if (document.getElementById('caritipesou').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var stat = document.getElementById('caritipesou').value;
    console.log(stat);
    $('#hasilcari').empty();
    $('#hasilpencarian').empty();
    $.ajax
    ({ 
      url: server+'sou_tiped.php?tipe_sou='+stat, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var nama   = row.nama;
          var address   = row.address;
          var owner   = row.owner;
          var id_souvenir_type   = row.id_souvenir_type;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/souv.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id);
          console.log(id_souvenir_type);
          $('#hasilcari').append("<tr><td>"+nama+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id+"\");detsousou(\""+id+"\");'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\",\""+lat+"\",\""+lon+"\");ikangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}




function viewtipe()
{
  $('#populertourism').hide();
  hapusawal();
  if (document.getElementById('caritipe').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var stat = document.getElementById('caritipe').value;
    console.log(stat);
    $('#hasilcari').empty();
    $('#hasilpencarian').empty();
    $.ajax
    ({ 
      url: server+'sou_tipe.php?tipe_sou='+stat, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var nama   = row.nama;
          var address   = row.address;
          var owner   = row.owner;
          var id_souvenir_type   = row.id_souvenir_type;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/souv.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id);
          console.log(id_souvenir_type);
          $('#hasilcari').append("<tr><td>"+nama+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id+"\");detsousou(\""+id+"\");'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\",\""+lat+"\",\""+lon+"\");'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}


function viewtipe2()
{
  $('#populertourism').hide();
  hapusawal();
  if (document.getElementById('caritipe2').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var stat = document.getElementById('caritipe2').value;
    console.log(stat);
    $('#hasilcari').empty();
    $('#hasilpencarian').empty();
    $.ajax
    ({ 
      url: server+'ik_tipe.php?tipe_ik='+stat, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var nama   = row.nama;
          var address   = row.address;
          var owner   = row.owner;
          var id_industry_type   = row.id_industry_type;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/ik.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id);
          console.log(id_industry_type);
          // $('#hasilcari').append("<tr><td>"+nama+"</td><td><a role='button' class='btn btn-success fa fa-info' onclick='detik(\""+id+"\");detikik(\""+id+"\");'></a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='ikangkot(\""+id+"\")'></a></td></tr>");
          $('#hasilcari').append("<tr><td>"+nama+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id+"\");detsousou(\""+id+"\")'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='ikangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");

        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}

function viewtipe_rad()
{
  hapusawal();
  aktifkanRadiuss1();
  if (document.getElementById('caritipe_rad').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var stat = document.getElementById('caritipe_rad').value;
    var inputradiuss=document.getElementById("inputradiuss_type").value * 100;
    console.log(server+'sou_tipe_rad.php?tipe_sou='+stat+'&lat='+koordinat.lat+'&lng='+koordinat.lng+'&rad='+inputradiuss);
    $('#hasilcari').empty();
    $('#hasilpencarian').empty();
    $.ajax
    ({ 
      url: server+'sou_tipe_rad.php?tipe_sou='+stat+'&lat='+koordinat.lat+'&lng='+koordinat.lng+'&rad='+inputradiuss, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var nama   = row.nama;
          var address   = row.address;
          var owner   = row.owner;
          var id_souvenir_type   = row.id_souvenir_type;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/souv.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id);
          console.log(id_souvenir_type);
          $('#hasilcari').append("<tr><td>"+nama+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info'  onclick='detsou(\""+id+"\");detsousou(\""+id+"\");'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\",\""+lat+"\",\""+lon+"\");ikangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}


function viewtipe2_rad()
{
  hapusawal();
  aktifkanRadiuss1();
  if (document.getElementById('caritipe2_rad').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var stat = document.getElementById('caritipe2_rad').value;
    var inputradiuss=document.getElementById("inputradiuss_type").value * 100;
    console.log(stat);
    $('#hasilcari').empty();
    $('#hasilpencarian').empty();
    $.ajax
    ({ 
      url: server+'ik_tipe_rad.php?tipe_ik='+stat+'&lat='+koordinat.lat+'&lng='+koordinat.lng+'&rad='+inputradiuss, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var nama   = row.nama;
          var address   = row.address;
          var owner   = row.owner;
          var id_industry_type   = row.id_industry_type;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/ik.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id);
          console.log(id_industry_type);
          $('#hasilcari').append("<tr><td>"+nama+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detik(\""+id+"\");detikik(\""+id+"\");'></a></td><td  style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='ikangkot(\""+id+"\")'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}


function viewstatus()
{
  $('#populertourism').hide();
  hapusawal();
  if (document.getElementById('caristatus').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var stat = document.getElementById('caristatus').value;
    console.log(stat);
    $('#hasilcari').empty();
    $('#hasilpencarian').empty();
    $.ajax
    ({ 
      url: server+'sou_status.php?status_sou='+stat, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var name   = row.name;
          var address   = row.address;
          var owner   = row.owner;
          var id_status   = row.id_status;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          var tabel = row.tabel;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/souv.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id);
          console.log(id_status);
          // if (tabel == 'sou') {
            $('#hasilcari').append("<tr><td>"+name+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id+"\");detsousou(\""+id+"\")'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\",\""+lat+"\",\""+lon+"\");ikangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
          // } else {
          //   $('#hasilcari').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success fa fa-info' onclick='detsouxx(\""+id+"\");'></a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='ikangkot(\""+id+"\")'></a></td></tr>");
          // }
          // $('#hasilcari').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success' onclick='detsou(\""+id+"\");detsousou(\""+id+"\");detsouxx(\""+id+"\");'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='souangkot(\""+id+"\")'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}

function viewstatus_rad()
{
  hapusawal();
  aktifkanRadiuss2();
  if (document.getElementById('caristatus_rad').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var stat = document.getElementById('caristatus_rad').value;
    var inputradiuss=document.getElementById("inputradiuss_status").value * 100;
    console.log(server+'sou_status_rad.php?status_sou='+stat+'&lat='+koordinat.lat+'&lng='+koordinat.lng+'&rad='+inputradiuss);
    $('#hasilcari').empty();
    $('#hasilpencarian').empty();
    $.ajax
    ({ 
      url: server+'sou_status_rad.php?status_sou='+stat+'&lat='+koordinat.lat+'&lng='+koordinat.lng+'&rad='+inputradiuss, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var name   = row.name;
          var address   = row.address;
          var owner   = row.owner;
          var id_status   = row.id_status;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          var tabel = row.tabel;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/souv.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id);
          console.log(id_status);
          // if (tabel == 'sou') {
            $('#hasilcari').append("<tr><td>"+name+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id+"\");detsousou(\""+id+"\")'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\",\""+lat+"\",\""+lon+"\");ikangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
          // } else {
          //   $('#hasilcari').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success fa fa-info' onclick='detsouxx(\""+id+"\");'></a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='ikangkot(\""+id+"\")'></a></td></tr>");
          // }
          // $('#hasilcari').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success' onclick='detsou(\""+id+"\");detsousou(\""+id+"\");detsouxx(\""+id+"\");'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='souangkot(\""+id+"\")'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}


function viewstatuses()
{
  hapusawal();
  if (document.getElementById('caristatuses').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var stat = document.getElementById('caristatuses').value;
    console.log(stat);
    $('#hasilcari').empty();
    $('#hasilpencarian').empty();
    $.ajax
    ({ 
      url: server+'sou_statuses.php?status_souses='+stat, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var name   = row.name;
          var address   = row.address;
          var owner   = row.owner;
          var id_status   = row.id_status;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          var tabel = row.tabel;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/souv.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id);
          console.log(id_status);
          // if (tabel == 'sou') {
            $('#hasilcari').append("<tr><td>"+name+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id+"\");detsousou(\""+id+"\")'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\",\""+lat+"\",\""+lon+"\");ikangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
          // } else {
          //   $('#hasilcari').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success fa fa-info' onclick='detsouxx(\""+id+"\");'></a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='ikangkot(\""+id+"\")'></a></td></tr>");
          // }
          // $('#hasilcari').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success' onclick='detsou(\""+id+"\");detsousou(\""+id+"\");detsouxx(\""+id+"\");'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='souangkot(\""+id+"\")'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}

function cpes()
{
  $('#populertourism').hide();
  hapusawal();
  if (document.getElementById('cp').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var stat = document.getElementById('cp').value;
    console.log(stat);
    $('#hasilcari').empty();
    $('#hasilpencarian').empty();
    $.ajax
    ({ 
      url: server+'sou_cpes.php?contact_person='+stat, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var name   = row.name;
          var address   = row.address;
          var owner   = row.owner;
          var id_status   = row.id_status;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          var tabel = row.tabel;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/souv.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id);
          console.log(id_status);
          // if (tabel == 'sou') {
            $('#hasilcari').append("<tr><td>"+name+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id+"\");detsousou(\""+id+"\")'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\",\""+lat+"\",\""+lon+"\");ikangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
          // } else {
          //   $('#hasilcari').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success fa fa-info' onclick='detsouxx(\""+id+"\");'></a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='ikangkot(\""+id+"\")'></a></td></tr>");
          // }
          // $('#hasilcari').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success' onclick='detsou(\""+id+"\");detsousou(\""+id+"\");detsouxx(\""+id+"\");'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='souangkot(\""+id+"\")'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}

function ratinges()
{
  $('#populertourism').hide();
  hapusawal();
  if (document.getElementById('rating').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var stat = document.getElementById('rating').value;
    console.log(stat);
    $('#hasilcari').empty();
    $('#hasilpencarian').empty();
    $.ajax
    ({ 
      url: server+'sou_ratinges.php?rating='+stat, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var name   = row.name;
          var address   = row.address;
          var owner   = row.owner;
          var id_status   = row.id_status;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          var tabel = row.tabel;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/souv.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id);
          console.log(id_status);
          // if (tabel == 'sou') {
            $('#hasilcari').append("<tr><td>"+name+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id+"\");detsousou(\""+id+"\")'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\",\""+lat+"\",\""+lon+"\");ikangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
          // } else {
          //   $('#hasilcari').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success fa fa-info' onclick='detsouxx(\""+id+"\");'></a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='ikangkot(\""+id+"\")'></a></td></tr>");
          // }
          // $('#hasilcari').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success' onclick='detsou(\""+id+"\");detsousou(\""+id+"\");detsouxx(\""+id+"\");'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='souangkot(\""+id+"\")'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}

function genderes()
{
  $('#populertourism').hide();
  hapusawal();
  if (document.getElementById('genderes').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var stat = document.getElementById('genderes').value;
    console.log(stat);
    $('#hasilcari').empty();
    $('#hasilpencarian').empty();
    $.ajax
    ({ 
      url: server+'sou_genderes.php?gender='+stat, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var name   = row.name;
          var address   = row.address;
          var owner   = row.owner;
          var id_status   = row.id_status;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          var tabel = row.tabel;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/souv.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id);
          console.log(id_status);
          // if (tabel == 'sou') {
            $('#hasilcari').append("<tr><td>"+name+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id+"\");detsousou(\""+id+"\")'></a></td><td  style='text-align:center;'><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\",\""+lat+"\",\""+lon+"\");ikangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
          // } else {
          //   $('#hasilcari').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success fa fa-info' onclick='detsouxx(\""+id+"\");'></a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='ikangkot(\""+id+"\")'></a></td></tr>");
          // }
          // $('#hasilcari').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success' onclick='detsou(\""+id+"\");detsousou(\""+id+"\");detsouxx(\""+id+"\");'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='souangkot(\""+id+"\")'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}

function detailinfohotel(id90){  
  
  $('#info').empty();
   hapusInfo();
      // clearroute2();
      hapusMarkerTerdekat();
       $.ajax({ 
      url: server+'detailinfohotel.php?info='+id90, data: "", dataType: 'json', success: function(rows)
        { 
         for (var i in rows) 
          { 
            console.log('dd');
            var row = rows[i];
            var id = row.id
            //var foto = row.foto;
            var name = row.name;
            var address=row.address;
            var cp = row.cp;
            var star = row.star;
            var ktp = row.ktp;
            var marriage_book = row.marriage_book;
            
            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            centerBaru = new google.maps.LatLng(row.latitude, row.longitude);
            marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/hotels.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(latitude);
              console.log(longitude);
              markersDua.push(marker);
            map.setCenter(centerBaru);
            map.setZoom(18); 
          
            infowindow = new google.maps.InfoWindow({
            position: centerBaru,
            content: "<center><span style=color:black><b>Information</b><br><table><tr><td><i class='fa fa-home'></i>Hotel Name</td><td>:</td><td> "+name+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Address</td><td>:</td><td> "+address+"</td></tr><br><tr><td><i class='fa fa-phone'></i>Telephone</td><td>:</td><td> "+cp+"</td></tr><br><tr><td><i class='fa fa-star'></i>Star</td><td>:</td><td> "+star+"</td></tr></table></span>",   
            pixelOffset: new google.maps.Size(0, -33)
            });
          infoposisi.push(infowindow); 
          hapusInfo();
          infowindow.open(map);
            
          }  
        }
      }); 
}


//Menampilkan Angkot Sekitar Kuliner
function kulAngkot(id_angkot1122,lat1,lng1){
          hapusMarkerTerdekat();
          hapusInfo();
          clearroute();
          clearroute2();
          $('#tampilangkotsekitarik').show();
          $('#tampillistangkotik1').show();
          $('#tampillistangkotik').empty();
          // $('#hasildet').hide();
          // $('#hasilrute').hide();
          $('#tampillistangkotik').append("<thead><th class='centered'>No Angkot</th><th class='centered' colspan='2'>Action</th></thead>");
          console.log("hh");
          $.ajax({ 
          url: server+'/_angkot_culinary.php?id='+id_angkot1122, data: "", dataType: 'json', success: function(rows) 
          { 
            if(rows==null)
            {
              alert('Data Did Not Exist!');
            }
            else
            {
            for (var i in rows) 
              { 
                var row = rows[i];
                console.log(row);
                var id = row.id;
                var id_angkot = row.id_angkot;
                var route_color = row.route_color;
               var lat = row.lat;
               var lng = row.lng;
               var latitude = row.latitude;
               var longitude = row.longitude;
               var description = row.description;
                var name = row.name;
                
                var latitude=row.latitude;
                var longitude= row.longitude;
                console.log(id_angkot);
                listgeom(id_angkot);
                tampilrute(id_angkot,  latitude, longitude, route_color);
                centerBaru = new google.maps.LatLng(latitude, longitude);
                map.setCenter(centerBaru);
                map.setZoom(18);  
                var marker = new google.maps.Marker({
                  position: centerBaru,              
                  icon:'assets/img/cul.png',
                  animation: google.maps.Animation.DROP,
                  map: map
                  });
                //markersDua.push(marker);
                map.setCenter(centerBaru);
                infowindow = new google.maps.InfoWindow({
                  position: centerBaru,
                  content: "<bold>"+name+"",
                  pixelOffset: new google.maps.Size(0, -1)
                    });
                infoposisi.push(infowindow); 
                infowindow.open(map,marker);
                console.log(id_angkot);
                $('#tampillistangkotik').append("<tr><td>"+id_angkot+"</td><td ><a role='button' class='btn btn-success fa fa-road' style='color:white;' title='route' onclick='detailangkot(\""+id_angkot+"\",\"" + lat + "\",\"" + lng + "\",\"" + latitude+ "\",\"" + longitude + "\")'></a></td></tr>");
              }
            }
           }
         });  
        }

function ikangkot(id_angkot1122442,lat1,lng1){
          hapusMarkerTerdekat();
          hapusInfo();
          clearroute();
          clearroute2();
          $('#tampilangkotsekitarik').show();
          $('#tampillistangkotik1').show();
          $('#tampillistangkotik').empty();
          $('#tampillistangkotik').append("<thead><th class='centered'>No Angkot</th><th class='centered' colspan='2'>Action</th></thead>");
          console.log("hh");
          $.ajax({ 
          url: server+'/_angkot_industri.php?id='+id_angkot1122442, data: "", dataType: 'json', success: function(rows) 
          { 
            if(rows==null)
            {
              // alert('Data Did Not Exist!');
            }
            else
            {
            for (var i in rows) 
              { 
                var row = rows[i];
                var id = row.id;
                var id_angkot = row.id_angkot;
                var route_color = row.route_color;
               var lat = row.lat;
               var lng = row.lng;
               var description = row.description;
                var name = row.name;
                
                var latitude=row.latitude;
                var longitude= row.longitude;
                console.log(id_angkot);
                listgeom(id_angkot);
                tampilrute(id_angkot,  latitude, longitude, route_color);
                centerBaru = new google.maps.LatLng(latitude, longitude);
                map.setCenter(centerBaru);
                map.setZoom(18);  
                var marker = new google.maps.Marker({
                  position: centerBaru,              
                  icon:'assets/img/ik.png',
                  animation: google.maps.Animation.DROP,
                  map: map
                  });
                //markersDua.push(marker);
                map.setCenter(centerBaru);
                infowindow = new google.maps.InfoWindow({
                  position: centerBaru,
                  content: "<bold>"+name+"",
                  pixelOffset: new google.maps.Size(0, -1)
                    });
                infoposisi.push(infowindow); 
                infowindow.open(map,marker);
                console.log(id_angkot);
                $('#tampillistangkotik').append("<tr><td>"+id_angkot+"</td><td style='text-align: center;'  ><a role='button' class='btn btn-success fa fa-road' style='color:white;' title='route' onclick='detailangkot(\""+id_angkot+"\",\""+lat+"\",\""+lng+"\",\""+lat1+"\",\""+lng1+"\")'></a></td></tr>");
              }
            }
           }
         });  
        }

function restaurantangkot(id_angkot1122492,lat1,lng1){
          hapusMarkerTerdekat();
          hapusInfo();
          clearroute();
          clearroute2();
          $('#tampilangkotsekitarik').show();
          $('#tampillistangkotik1').show();
          $('#tampillistangkotik').empty();
          $('#tampillistangkotik').append("<thead><th class='centered'>No Angkot</th><th class='centered' colspan='2'>Action</th></thead>");
          console.log("hh");
          $.ajax({ 
          url: server+'/_angkot_restaurant.php?id='+id_angkot1122492, data: "", dataType: 'json', success: function(rows) 
          { 
            if(rows==null)
            {
              alert('Data Did Not Exist!');
            }
            else
            {
            for (var i in rows) 
              { 
                var row = rows[i];
                var id = row.id;
                var id_angkot = row.id_angkot;
                var route_color = row.route_color;
               var lat = row.lat;
               var lng = row.lng;
               var description = row.description;
                var name = row.name;
                
                var latitude=row.latitude;
                var longitude= row.longitude;
                console.log(id_angkot);
                listgeom(id_angkot);
                tampilrute(id_angkot,  latitude, longitude, route_color);
                centerBaru = new google.maps.LatLng(latitude, longitude);
                map.setCenter(centerBaru);
                map.setZoom(18);  
                var marker = new google.maps.Marker({
                  position: centerBaru,              
                  icon:'assets/img/ik.png',
                  animation: google.maps.Animation.DROP,
                  map: map
                  });
                //markersDua.push(marker);
                map.setCenter(centerBaru);
                infowindow = new google.maps.InfoWindow({
                  position: centerBaru,
                  content: "<bold>"+name+"",
                  pixelOffset: new google.maps.Size(0, -1)
                    });
                infoposisi.push(infowindow); 
                infowindow.open(map,marker);
                console.log(id_angkot);
                $('#tampillistangkotik').append("<tr><td>"+id_angkot+"</td><td style='text-align: center;'  ><a role='button' class='btn btn-success fa fa-road' style='color:white;' title='route' onclick='detailangkot(\""+id_angkot+"\",\""+lat+"\",\""+lng+"\",\""+lat1+"\",\""+lng1+"\")'></a></td></tr>");
              }
            }
           }
         });  
        }

function souangkot(id_angkot112244,lat1,lng1){
          hapusMarkerTerdekat();
          hapusInfo();
          clearroute();
          clearroute2();
          $('#tampilangkotsekitarik').show();
          $('#tampillistangkotik1').show();
          $('#tampillistangkotik').empty();
          $('#tampillistangkotik').append("<thead><th class='centered'>No Angkot</th><th class='centered' colspan='2'>Action</th></thead>");
          console.log("hh");
          $.ajax({ 
          url: server+'/_angkot_souvenirs.php?id='+id_angkot112244, data: "", dataType: 'json', success: function(rows) 
          { 
            if(rows==null)
            {
              // alert('Data Did Not Exist!');
            }
            else
            {
            for (var i in rows) 
              { 
                var row = rows[i];
                console.log(row);
                var id = row.id;
                var id_angkot = row.id_angkot;
                var route_color = row.route_color;
               var lat = row.lat;
               var lng = row.lng;
               var description = row.description;
                var name = row.name;
                
                var latitude=row.latitude;
                var longitude= row.longitude;
                console.log(id_angkot);
                listgeom(id_angkot);
                tampilrute(id_angkot,  latitude, longitude, route_color);
                centerBaru = new google.maps.LatLng(latitude, longitude);
                map.setCenter(centerBaru);
                map.setZoom(18);  
                var marker = new google.maps.Marker({
                  position: centerBaru,              
                  icon:'assets/img/souv.png',
                  animation: google.maps.Animation.DROP,
                  map: map
                  });
                //markersDua.push(marker);
                map.setCenter(centerBaru);
                infowindow = new google.maps.InfoWindow({
                  position: centerBaru,
                  content: "<bold>"+name+"",
                  pixelOffset: new google.maps.Size(0, -1)
                    });
                infoposisi.push(infowindow); 
                infowindow.open(map,marker);
                console.log(id_angkot);
                $('#tampillistangkotik').append("<tr><td>"+id_angkot+"</td><td style='text-align: center;'  ><a role='button' class='btn btn-success fa fa-road' style='color:white;' title='route' onclick='detailangkot(\""+id_angkot+"\",\""+lat+"\",\""+lng+"\",\""+lat1+"\",\""+lng1+"\")'></a></td></tr>");
              }
            }
           }
         });  
        }

function hotelangkot(id_angkot11224436,lat1,lng1){
          hapusMarkerTerdekat();
          hapusInfo();
          clearroute();
          clearroute2();
          $('#tampilangkotsekitarik').show();
          $('#tampillistangkotik1').show();
          $('#tampillistangkotik').empty();
          $('#tampillistangkotik').append("<thead><th class='centered'>No Angkot</th><th class='centered' colspan='2'>Action</th></thead>");
          console.log("hh");
          $.ajax({ 
          url: server+'/_angkot_hotel.php?id='+id_angkot11224436, data: "", dataType: 'json', success: function(rows) 
          { 
            if(rows==null)
            {
              alert('Data Did Not Exist!');
            }
            else
            {
            for (var i in rows) 
              { 
                var row = rows[i];
                var id = row.id;
                var id_angkot = row.id_angkot;
                var route_color = row.route_color;
               var lat = row.lat;
               var lng = row.lng;
               var description = row.description;
                var name = row.name;
                
                var latitude=row.latitude;
                var longitude= row.longitude;
                console.log(id_angkot);
                listgeom(id_angkot);
                tampilrute(id_angkot,  latitude, longitude, route_color);
                centerBaru = new google.maps.LatLng(latitude, longitude);
                map.setCenter(centerBaru);
                map.setZoom(18);  
                var marker = new google.maps.Marker({
                  position: centerBaru,              
                  icon:'assets/img/hotels.png',
                  animation: google.maps.Animation.DROP,
                  map: map
                  });
                //markersDua.push(marker);
                map.setCenter(centerBaru);
                infowindow = new google.maps.InfoWindow({
                  position: centerBaru,
                  content: "<bold>"+name+"",
                  pixelOffset: new google.maps.Size(0, -1)
                    });
                infoposisi.push(infowindow); 
                infowindow.open(map,marker);
                console.log(id_angkot);
                $('#tampillistangkotik').append("<tr><td>"+id_angkot+"</td><td style='text-align: center;'  ><a role='button' class='btn btn-success fa fa-road' style='color:white;' title='route' onclick='detailangkot(\""+id_angkot+"\",\""+lat+"\",\""+lng+"\",\""+lat1+"\",\""+lng1+"\")'></a></td></tr>");
              }
            }
           }
         });  
        }

function owangkot(id_angkot11224439,lat1,lng1){
          hapusMarkerTerdekat();
          hapusInfo();
          clearroute();
          clearroute2();
          $('#tampilangkotsekitarik').show();
          $('#tampillistangkotik1').show();
          $('#tampillistangkotik').empty();
          $('#tampillistangkotik').append("<thead><th class='centered'>No Angkot</th><th class='centered' colspan='2'>Action</th></thead>");
          console.log("hh");
          $.ajax({ 
          url: server+'/_angkot_ow.php?id='+id_angkot11224439, data: "", dataType: 'json', success: function(rows) 
          { 
            if(rows==null)
            {
              alert('Data Did Not Exist!');
            }
            else
            {
            for (var i in rows) 
              { 
                var row = rows[i];
                var id = row.id;
                var id_angkot = row.id_angkot;
                var route_color = row.route_color;
               var lat = row.lat;
               var lng = row.lng;
               var description = row.description;
                var name = row.name;
                
                var latitude=row.latitude;
                var longitude= row.longitude;
                console.log(id_angkot);
                listgeom(id_angkot);
                tampilrute(id_angkot,  latitude, longitude, route_color);
                centerBaru = new google.maps.LatLng(latitude, longitude);
                map.setCenter(centerBaru);
                map.setZoom(18);  
                var marker = new google.maps.Marker({
                  position: centerBaru,              
                  icon:'icon/marker_tw.png',
                  animation: google.maps.Animation.DROP,
                  map: map
                  });
                //markersDua.push(marker);
                map.setCenter(centerBaru);
                infowindow = new google.maps.InfoWindow({
                  position: centerBaru,
                  content: "<bold>"+name+"",
                  pixelOffset: new google.maps.Size(0, -1)
                    });
                infoposisi.push(infowindow); 
                infowindow.open(map,marker);
                console.log(id_angkot);
                $('#tampillistangkotik').append("<tr><td>"+id_angkot+"</td><td style='text-align: center;'  ><a role='button' class='btn btn-success fa fa-road' style='color:white;' title='route' onclick='detailangkot(\""+id_angkot+"\",\""+lat+"\",\""+lng+"\",\""+lat1+"\",\""+lng1+"\")'></a></td></tr>");
              }
            }
           }
         });  
        }

function worshipangkot(id_angkot11224437,lat1,lng1){
          hapusMarkerTerdekat();
          hapusInfo();
          clearroute();
          clearroute2();
          $('#tampilangkotsekitarik').show();
          $('#tampillistangkotik1').show();
          $('#tampillistangkotik').empty();
          $('#tampillistangkotik').append("<thead><th class='centered'>No Angkot</th><th class='centered' colspan='2'>Action</th></thead>");
          console.log("hh");
          $.ajax({ 
          url: server+'/_angkot_worship.php?id='+id_angkot11224437, data: "", dataType: 'json', success: function(rows) 
          { 
            if(rows==null)
            {
              alert('Data Did Not Exist!');
            }
            else
            {
            for (var i in rows) 
              { 
                var row = rows[i];
                var id = row.id;
                var id_angkot = row.id_angkot;
                var route_color = row.route_color;
               var lat = row.lat;
               var lng = row.lng;
               var description = row.description;
                var name = row.name;
                
                var latitude=row.latitude;
                var longitude= row.longitude;
                console.log(id_angkot);
                listgeom(id_angkot);
                tampilrute(id_angkot,  latitude, longitude, route_color);
                centerBaru = new google.maps.LatLng(latitude, longitude);
                map.setCenter(centerBaru);
                map.setZoom(18);  
                var marker = new google.maps.Marker({
                  position: centerBaru,              
                  icon:'assets/img/msj.png',
                  animation: google.maps.Animation.DROP,
                  map: map
                  });
                //markersDua.push(marker);
                map.setCenter(centerBaru);
                infowindow = new google.maps.InfoWindow({
                  position: centerBaru,
                  content: "<bold>"+name+"",
                  pixelOffset: new google.maps.Size(0, -1)
                    });
                infoposisi.push(infowindow); 
                infowindow.open(map,marker);
                console.log(id_angkot);
                $('#tampillistangkotik').append("<tr><td>"+id_angkot+"</td><td style='text-align: center;'  ><a role='button' class='btn btn-success fa fa-road' style='color:white;' title='route' onclick='detailangkot(\""+id_angkot+"\",\""+lat+"\",\""+lng+"\",\""+lat1+"\",\""+lng1+"\")'></a></td></tr>");
              }
            }
           }
         });  
        }
function clearroute() { // HAPUS RUTE
  for (i in rute) {
  rute[i].setMap(null);
  }
  rute = [];
}

function callRoute(start, end)
{
  init();
  viewsou();
  
  $('#hasilcari').show();
  $('#hasildet').hide();
  $('#hasilrute').hide();  
  $('#detailrute1').show();
  $('#detailrute').empty();
  $('#hasildet').empty();
  // clearroute2();
  // clearroute();

  if (koordinat == 'null' || typeof(koordinat) == "undefined")
  {
    alert('Determine your position');
  }
  else
  {
    // clearroute();
    // clearroute2();
    // if (directionsDisplay)
    // {
    //   clearroute();
    // }
      
    
    $('#hasilrute').show();
    directionsService = new google.maps.DirectionsService;
    directionsDisplay = new google.maps.DirectionsRenderer;
    directionsService.route
    (
    {
      origin:start,
      destination : end,
      travelMode:google.maps.TravelMode.DRIVING
    },
    function(response, status)
    {
      if (status === google.maps.DirectionsStatus.OK)
      {
        directionsDisplay.setDirections(response);
      }
      else
      {
        window.alert('Direction request failed due to' +status);
      }
    }
    );
    if (directionsDisplay) {
            clearroute();
            hapusInfo();
          }
    directionsDisplay.setMap(map);
    map.setZoom(16);

    directionsDisplay.setPanel(document.getElementById('detailrute1'));
    // $('#hasilrute').empty();
  }
}




function clearroute2(){      
    if(typeof(directionsDisplay) != "undefined" && directionsDisplay.getMap() != undefined){
    directionsDisplay.setMap(null);
    $("#rute").remove();
    }     

}

//Menampilkan Form Filter souvenir
function selectsou()
{

  $("#selectkulll").show();
  $("#hasilik").hide();
  $("#selectfacility").hide();

}

//Menampilkan Form Filter IK
function selectik()
{

  $("#selectkulll").show();
  $("#hasilik").hide();
  $("#selectfacility").hide();

}

function selectfacility()
{

  $("#selectfacility").show();
  $("#hasilik").hide();
  $("#selectkulll").hide();
  //$("#filterik").hide();
}

function viewsouv()
{
  clearroute2();
  $("#hasilik").show();
  $('#hasilcari1').show();
  $('#hasilcari').empty();
  $('#hasilcari').empty();
  $('#hasilpencarian').empty();

hapusawal();
  var fas=selectsou.value;
  var arrayLay=[];
  for(i=0;i<$("input[name=product_souvenir]:checked").length;i++){
    arrayLay.push($("input[name=product_souvenir]:checked")[i].value);
  }
  var jumlah_centang = $("input[name=product_souvenir]:checked").length + $("input[name=product_small_industry]:checked").length;

  console.log(jumlah_centang, koordinat);
  if (jumlah_centang==0){
    alert('Pilih Produk');
  }else{
    if(arrayLay == ''){
      console.log('baba');
      var jumlah1 = 0;
      viewikk(jumlah1);

    } else {
      if(koordinat == 'null'){
      $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
      $.ajax({ url: server+'selectsou.php?lay='+arrayLay, data: "", dataType: 'json', success: function(rows){
        console.log("hai");
        if(rows==null)
              {
                alert('Data not found');
              }
          for (var i in rows) 
              {   
                var row     = rows[i];
                var id   = row.id;
                var nama_produk   = row.name;
                var nama_tempat_kuliner   = row.name;
                var latitude  = row.latitude ;
                var longitude = row.longitude ;
                centerBaru = new google.maps.LatLng(latitude, longitude);
                marker = new google.maps.Marker
              ({
                position: centerBaru,
                icon:'assets/img/souv.png',
                map: map,
                animation: google.maps.Animation.DROP,
              });
                console.log(name);
                console.log(latitude);
                console.log(longitude);
                markersDua.push(marker);
                map.setCenter(centerBaru);
                map.setZoom(16);
                clickMarker(centerBaru, id);
                $('#hasilcari').append("<tr><td>"+nama_tempat_kuliner+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id+"\");detsousou(\""+id+"\");'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\",\""+lat+"\",\""+lon+"\");ikangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
              }
              var jumlah = rows.length;
              viewikk(jumlah);
              // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>");
      }});
      }else{
        aktifkanRadiuss3();
        var inputradiuss=document.getElementById("inputradiuss_selsou").value * 100;
        $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
      $.ajax({ url: server+'selectsou_rad.php?lay='+arrayLay+'&lat='+koordinat.lat+'&lng='+koordinat.lng+'&rad='+inputradiuss, data: "", dataType: 'json', success: function(rows){
        // console.log("hai");
        if(rows==null)
              {
                alert('Data not found');
              }
          for (var i in rows) 
              {   
                var row     = rows[i];
                var id   = row.id;
                var nama_produk   = row.name;
                var nama_tempat_kuliner   = row.name;
                var latitude  = row.latitude ;
                var longitude = row.longitude ;
                centerBaru = new google.maps.LatLng(latitude, longitude);
                marker = new google.maps.Marker
              ({
                position: centerBaru,
                icon:'assets/img/souv.png',
                map: map,
                animation: google.maps.Animation.DROP,
              });
                console.log(name);
                console.log(latitude);
                console.log(longitude);
                markersDua.push(marker);
                map.setCenter(centerBaru);
                map.setZoom(16);
                clickMarker(centerBaru, id);
                $('#hasilcari').append("<tr><td>"+nama_tempat_kuliner+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id+"\");detsousou(\""+id+"\");'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\",\""+lat+"\",\""+lon+"\");ikangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
              }
              var jumlah = rows.length;
              viewikk(jumlah);
              // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>");
      }});
    }
  }
}
}

// function viewikk2(jml){
  
// }

function viewikk(jml)
{
// hapusawal();

  var fas=selectik.value;
  var arrayLay2=[];
  for(i=0;i<$("input[name=product_small_industry]:checked").length;i++){
    arrayLay2.push($("input[name=product_small_industry]:checked")[i].value);
  }
  // alert(arrayLay.length)
  console.log(koordinat);
  if (jml == 0){
    alert('Pilih Produk');
  }else{
    if(koordinat == 'null'){
      console.log('aa');
    // alert(server+'selectik.php?lay='+arrayLay2)
    // $('#hasilcari').append("<thead><th>Name</th><th colspan='3'>Action</th></thead>");
    $.ajax({ url: server+'selectik.php?lay='+arrayLay2, data: "", dataType: 'json', success: function(rows){
      if(rows==null && arrayLay2.length != 0)
            {
              alert('Data not found');
            }

        for (var i in rows) 
            {   
              var row     = rows[i];
              // var id   = row.id;
              // var nama_produk   = row.product;
              var nama_tempat_kuliner   = row.name;
              var latitude  = row.latitude ;
              var longitude = row.longitude ;
              centerBaru = new google.maps.LatLng(latitude, longitude);
              marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/ik.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(name);
              console.log(latitude);
              console.log(longitude);
              markersDua.push(marker);
              map.setCenter(centerBaru);
              map.setZoom(16);
              clickMarker(centerBaru, id);
              $('#hasilcari').append("<tr><td>"+nama_tempat_kuliner+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detik(\""+id+"\");detikik(\""+id+"\");'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='ikangkot(\""+id+"\")'></a></td></tr>");
            }
            // jml = jml + rows.length;
            // alert('hai')
            // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+jml);
    }});
    }else{
      console.log('dd');
      aktifkanRadiuss3();
      var inputradiuss=document.getElementById("inputradiuss_selsou").value * 100;
      $.ajax({ url: server+'selectik_rad.php?lay='+arrayLay2+'&lat='+koordinat.lat+'&lng='+koordinat.lng+'&rad='+inputradiuss, data: "", dataType: 'json', success: function(rows){
      if(rows==null && arrayLay2.length != 0)
            {
              alert('Data not found');
            }

        for (var i in rows) 
            {   
              var row     = rows[i];
              // var id   = row.id;
              // var nama_produk   = row.product;
              var nama_tempat_kuliner   = row.name;
              var latitude  = row.latitude ;
              var longitude = row.longitude ;
              centerBaru = new google.maps.LatLng(latitude, longitude);
              marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/ik.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(name);
              console.log(latitude);
              console.log(longitude);
              markersDua.push(marker);
              map.setCenter(centerBaru);
              map.setZoom(16);
              clickMarker(centerBaru, id);
              $('#hasilcari').append("<tr><td>"+nama_tempat_kuliner+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detik(\""+id+"\");detikik(\""+id+"\");'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='ikangkot(\""+id+"\")'></a></td></tr>");
            }
            // jml = jml + rows.length;
            // alert('hai')
            // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+jml);
    }});
    }
  }
}

//Membuat Fungsi Menampilkan Seluruh IK 
function viewik()
{
hapusawal();
  $.ajax
  ({ 
    url: server+'viewik.php', data: "", dataType: 'json', success: function(rows) 
    { 
      if(rows==null)
      {
        alert('Data Did Not Exist!');
      }
      else
      {
        $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
        console.log(rows);
        for (var i in rows) 
        { 
          var row = rows[i];
          var id = row.id;
          var name = row.name;
          var address=row.address;
          var owner=row.owner;
          var lat=row.lat;
          var lon = row.lng;
          console.log(name);
          centerBaru = new google.maps.LatLng(lat, lon);
          // var marker = new google.maps.Marker
          // ({
          //   position: centerBaru,              
          //   icon:'assets/img/ik.png',
          //   animation: google.maps.Animation.DROP,
          //   map: map
          // });
          // markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(13);
           clickMarker(centerBaru, id); 
           $('#hasilcari').append("<tr><td>"+name+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detik(\""+id+"\");detikik(\""+id+"\");'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='ikangkot(\""+id+"\")'></a></td></tr>");
        }
      } 
      // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
    }
  });           
}


 function hapus_Semua(){
          //set posisi
          basemap()

          //hapus semua data
          hapusRadius();
          //hapus_landmark();
          //hapus_kecuali_landmark();
          a();
          }

 function hapus_kecuali_landmark(){
            hapusRadius();
            hapusMarkerObject();
            hapusInfo();
            clearangkot();
            clearroute();
          }
 
 function hapusMarkerObject() {
            for (var i = 0; i < markersDua.length; i++) {
                  markersDua[i].setMap(null);
              }
          }

   function clearangkot(){
          for (i in angkot){
              angkot[i].setMap(null);
            } 
            angkot=[]; 
          }

  function clearroute(){
          for (i in rute){
            rute[i].setMap(null);
          } 
          rute=[]; 
        }

 /********************************************************** RADIUS - OBJEK SEKITAR******************************************************/
 /***************************************************************************************************************************************/


function route_sekitar(lat1,lng1,lat,lng) {
      var start = new google.maps.LatLng(lat1, lng1);
      var end = new google.maps.LatLng(lat, lng);

      if(directionsDisplay){
          clearroute();  
          hapusInfo();
      }

      directionsService = new google.maps.DirectionsService();
      var request = {
        origin:start,
        destination:end,
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC,
        provideRouteAlternatives: true
      };

      directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
         directionsDisplay.setDirections(response);
       }
      });
      
      directionsDisplay = new google.maps.DirectionsRenderer({
        draggable: false,
        polylineOptions: {
          strokeColor: "darkorange"
        }
      });

      directionsDisplay.setMap(map);
      $('#hasilrute').show();
      $('#detailrute1').show();
      directionsDisplay.setPanel(document.getElementById('detailrute1'));
      rute.push(directionsDisplay);          
  }



 function tampil_sekitar(latitude,longitude,namaa){
       hapus_Semua();

        rad_lat = latitude;
        rad_lng = longitude;

        //Hilangkan Button Sekitar
        $('#view_sekitar').empty();
        $('#hasilik').hide();
        document.getElementById("inputradius").style.display = "inline";

        // POSISI MARKER
        centerBaru = new google.maps.LatLng(latitude, longitude);
        map.setZoom(16);  
          var marker = new google.maps.Marker({map: map, position: centerBaru, 
         icon:'assets/img/souv.png',
          animation: google.maps.Animation.DROP,
          clickable: true});

        //INFO WINDOW
        marker.info = new google.maps.InfoWindow({
          content: "<bold>"+namaa+"",
          pixelOffset: new google.maps.Size(0, -1)
            });
          marker.info.open(map, marker);

        $("#nearbyik").show();
        $("#hasildet").hide();
        $("#hasilcaridet").hide();
        $("#hasilculi").hide();
        $("#hasilsouv").hide();
        $("#hasilindustry").hide();
        $("#hasilobj").hide();
        $("#hasilhotel").hide();
        $("#hasilmosque").hide();
        $("#hasilrestaurant").hide();
                        
      }


function industri_sekitar(latitude,longitude,rad){ //INDUSTRI SEKITAR
        $('#hasilcariind').empty();
        $('#hasilcariind1').show();
        $('#hasilcariind').append("<thead><th class='centered'>Name</th><th colspan='3' class='centered'>Action</th></thead>");
        $.ajax({url: server+'_sekitar_industri.php?lat='+latitude+'&long='+longitude+'&rad='+rad, data: "", dataType: 'json', success: function(rows){ 
          for (var i in rows){ 
            var row = rows[i];
            var id = row.id;
            var name = row.name;
            var address = row.address;
            var cp = row.cp;
            var lat=row.latitude;
            var lon = row.longitude;
            console.log(name);

            //POSISI MAP
            centerBaru = new google.maps.LatLng(lat, lon);
            map.setCenter(centerBaru);
            map.setZoom(16);  
            var marker = new google.maps.Marker({
              position: centerBaru,              
              icon:'assets/img/ik.png',
              animation: google.maps.Animation.DROP,
              map: map
              });
            markersDua.push(marker);
            map.setCenter(centerBaru);
            $('#hasilcariind').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success fa fa-info' style='color:white;' title='info' onclick='detailinfoik(\""+id+"\")'></a></td><td><a role='button' class='btn btn-success fa fa-road' title='route' style='color:white;' onclick='route_sekitar(\""+latitude+"\",\""+longitude+"\",\""+lat+"\",\""+lon+"\")'></a></td><td><a role='button' class='btn btn-success fa fa-taxi' title='angkot' style='color:white;' onclick='ikangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
          }//end for
        }});//end ajax  
      }

function restaurant_sekitar(latitude,longitude,rad){ //INDUSTRI SEKITAR
        $('#hasilcarirestaurant').empty();
        $('#hasilcarirestaurant1').show();
        $('#hasilcarirestaurant').append("<thead><th class='centered'>Name</th><th colspan='3' class='centered'>Action</th></thead>");
        $.ajax({url: server+'_sekitar_restaurant.php?lat='+latitude+'&long='+longitude+'&rad='+rad, data: "", dataType: 'json', success: function(rows){ 
          for (var i in rows){ 
            var row = rows[i];
            var id = row.id;
            var name = row.name;
            var address = row.address;
            var cp = row.cp;
            var lat=row.latitude;
            var lon = row.longitude;
            console.log(name);

            //POSISI MAP
            centerBaru = new google.maps.LatLng(lat, lon);
            map.setCenter(centerBaru);
            map.setZoom(16);  
            var marker = new google.maps.Marker({
              position: centerBaru,              
              icon:'assets/img/culf.png',
              animation: google.maps.Animation.DROP,
              map: map
              });
            markersDua.push(marker);
            map.setCenter(centerBaru);
            $('#hasilcarirestaurant').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success fa fa-info' style='color:white;' title='info' onclick='detailinforestaurant(\""+id+"\")'></a></td><td><a role='button' class='btn btn-success fa fa-road' style='color:white;' title='route' onclick='route_sekitar(\""+latitude+"\",\""+longitude+"\",\""+lat+"\",\""+lon+"\")'></a></td><td><a role='button' class='btn btn-success fa fa-taxi' style='color:white;' title='angkot' onclick='restaurantangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
          }//end for
        }});//end ajax  
      }


function kuliner_sekitar(latitude,longitude,rad){ //KULINER SEKITAR 

          $('#hasilcariculi').empty();
          $('#hasilcariculi1').show();
          $('#hasilcariculi').append("<thead><th class='centered'>Name</th><th colspan='3' class='centered'>Action</th></thead>");
          $.ajax({url: server+'_sekitar_kuliner.php?lat='+latitude+'&long='+longitude+'&rad='+rad, data: "", dataType: 'json', success: function(rows){ 
            for (var i in rows){ 
              var row = rows[i];
              var id = row.id;
              var name = row.name;
              var address = row.address;
              var cp = row.cp;
              
              var open = row.open;
              var close = row.close;
              var capacity = row.capacity;
              
              var employee = row.employee;
              var lat=row.latitude;
              var lon = row.longitude;

              //POSISI MAP
              centerBaru = new google.maps.LatLng(lat, lon);
              map.setCenter(centerBaru);
              map.setZoom(16);  
              var marker = new google.maps.Marker({
                position: centerBaru,              
                icon:'assets/img/cul.png',
                animation: google.maps.Animation.DROP,
                map: map
                });
              markersDua.push(marker);
              map.setCenter(centerBaru);

              $('#hasilcariculi').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success fa fa-info' style='color:white;' title='info' onclick='detculi(\""+id+"\")'></a></td><td><a role='button' class='btn btn-success fa fa-road' style='color:white;' title='route' onclick='route_sekitar(\""+latitude+"\",\""+longitude+"\",\""+lat+"\",\""+lon+"\")'></a></td><td><a role='button' class='btn btn-success fa fa-taxi' style='color:white;' title='angkot' onclick='kulAngkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
            }//end for
          }});//end ajax  
        }


function masjid_sekitar(latitude,longitude,rad){ // MASJID SEKITAR 

        $('#hasilcarimosque').empty();
        $('#hasilcarimosque1').show();
        $('#hasilcarimosque').append("<thead><th class='centered'>Name</th><th colspan='3' class='centered'>Action</th></thead>");
        $.ajax({url: server+'_sekitar_masjid.php?lat='+latitude+'&long='+longitude+'&rad='+rad, data: "", dataType: 'json', success: function(rows){ 
          for (var i in rows){ 
            var row = rows[i];
            var id = row.id;
            var name = row.name;
            var address = row.address;
            var capacity = row.capacity;
            var lat=row.latitude;
            var lon = row.longitude;
            
            //POSISI MAP
            centerBaru = new google.maps.LatLng(lat, lon);
            map.setCenter(centerBaru);
            map.setZoom(16);  
            var marker = new google.maps.Marker({
              position: centerBaru,              
              icon:'assets/img/msj.png',
              animation: google.maps.Animation.DROP,
              map: map
              });
            markersDua.push(marker);
            map.setCenter(centerBaru);

            $('#hasilcarimosque').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success fa fa-info' style='color:white;' title='info' onclick='detailinfomosque(\""+id+"\")'></a></td><td><a role='button' class='btn btn-success fa fa-road' style='color:white;' title='route' onclick='route_sekitar(\""+latitude+"\",\""+longitude+"\",\""+lat+"\",\""+lon+"\")'></a></td><td><a role='button' class='btn btn-success fa fa-taxi' style='color:white;' title='angkot' onclick='worshipangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
          }//end for
        }});//end ajax  
      }

function oleholeh_sekitar(latitude,longitude,rad){ // OLEH-OLEH SEKITAR 

          $('#hasilcarisouv').empty();
           $('#hasilcarisouv1').show();
          $('#hasilcarisouv').append("<thead><th class='centered'>Name</th><th colspan='3' class='centered'>Action</th></thead>");
          $.ajax({url: server+'_sekitar_oleholeh.php?lat='+latitude+'&long='+longitude+'&rad='+rad, data: "", dataType: 'json', success: function(rows){ 
            for (var i in rows){ 
              var row = rows[i];
              var id = row.id;
              var name = row.name;
              var owner = row.owner;
              var cp = row.cp;
              var address = row.address;
              
              var lat=row.latitude;
              var lon = row.longitude;
              
              //POSISI MAP
              centerBaru = new google.maps.LatLng(lat, lon);
              map.setCenter(centerBaru);
              map.setZoom(16);  
              var marker = new google.maps.Marker({
                position: centerBaru,              
                icon:'assets/img/souv.png',
                animation: google.maps.Animation.DROP,
                map: map
                });
              markersDua.push(marker);
              map.setCenter(centerBaru);

              $('#hasilcarisouv').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success fa fa-info' style='color:white;' title='info' onclick='detailinfosou(\""+id+"\")'></a></td><td><a role='button' class='btn btn-success fa fa-road' title='route' style='color:white;' onclick='route_sekitar(\""+latitude+"\",\""+longitude+"\",\""+lat+"\",\""+lon+"\")'></a></td><td><a role='button' class='btn btn-success fa fa-taxi' title='angkot' style='color:white;' onclick='souangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
            }//end for
          }});//end ajax  
        } 

function tw_sekitar(latitude,longitude,rad){ // TEMPAT WISATA SEKITAR 

          $('#hasilcariobj').empty();
          $('#hasilcariobj1').show();
          $('#hasilcariobj').append("<thead><th class='centered'>Name</th><th colspan='3' class='centered'>Action</th></thead>");
          $.ajax({url: server+'_sekitar_tw.php?lat='+latitude+'&long='+longitude+'&rad='+rad, data: "", dataType: 'json', success: function(rows){ 
            for (var i in rows){ 
              var row = rows[i];
              var id = row.id;
              var name = row.name;
              var address = row.address;
              var open = row.open;
              var close = row.close;
              var ticket = row.ticket;
              
              var lat=row.latitude;
              var lon = row.longitude;
              
              //POSISI MAP
              centerBaru = new google.maps.LatLng(lat, lon);
              map.setCenter(centerBaru);
              map.setZoom(16);  
              var marker = new google.maps.Marker({
                position: centerBaru,              
                icon:'assets/img/tours.png',
                animation: google.maps.Animation.DROP,
                map: map
                });
              markersDua.push(marker);
              map.setCenter(centerBaru);

              $('#hasilcariobj').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success fa fa-info' style='color:white;' title='info' onclick='detailinfoobj(\""+id+"\")'></a></td><td><a role='button' class='btn btn-success fa fa-road' style='color:white;' title='route' onclick='route_sekitar(\""+latitude+"\",\""+longitude+"\",\""+lat+"\",\""+lon+"\")'></a></td><td><a role='button' class='btn btn-success fa fa-taxi' style='color:white;' title='angkot' onclick='owangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
            }//end for
          }});//end ajax  

        }



      function h_sekitar(latitude,longitude,rad){ // TEMPAT WISATA SEKITAR 

          $('#hasilcarihotel').empty();
          $('#hasilcarihotel1').show();
          //cekRadius();
          $('#hasilcarihotel').append("<thead><th class='centered'>Name</th><th colspan='3' class='centered'>Action</th></thead>");
          $.ajax({url: server+'_sekitar_hotel.php?lat='+latitude+'&long='+longitude+'&rad='+rad, data: "", dataType: 'json', success: function(rows){ 
            for (var i in rows){ 
              var row = rows[i];
              var id = row.id;
              var name = row.name;
              var address = row.address;
              var cp = row.cp;
              
              var lat=row.latitude;
              var lon = row.longitude;
              
              //POSISI MAP
              centerBaru = new google.maps.LatLng(lat, lon);
              map.setCenter(centerBaru);
              map.setZoom(16);  
              var marker = new google.maps.Marker({
                position: centerBaru,              
                icon:'assets/img/hotels.png',
                animation: google.maps.Animation.DROP,
                map: map
                });
              markersDua.push(marker);
              map.setCenter(centerBaru);
              console.log(rad);

              $('#hasilcarihotel').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success fa fa-info' style='color:white;' title='info' onclick='detailinfohotel(\""+id+"\")'></a></td> <td><a role='button' style='color:white;' class='btn btn-success fa fa-road' title='route'  onclick='route_sekitar(\""+latitude+"\",\""+longitude+"\",\""+lat+"\",\""+lon+"\")'></a></td><td><a role='button' class='btn btn-success fa fa-taxi' style='color:white;' title='angkot' onclick='hotelangkot(\""+id+"\",\""+lat+"\",\""+lon+"\")'></a></td></tr>");
            }//end for
          }});//end ajax  
        }


//Fungsi Aktifkan Radius Souv
function aktifkanRadius()
{
   var koordinat = new google.maps.LatLng(rad_lat, rad_lng);
          map.setCenter(koordinat);
          map.setZoom(16);  

          hapus_kecuali_landmark();
          hapusRadius();
          var inputradius=document.getElementById("inputradius").value;
          console.log(inputradius);
          var rad = parseFloat(inputradius*100);
          var circle = new google.maps.Circle({
            center: koordinat,
            radius: rad,      
            map: map,
            strokeColor: "blue",
            strokeOpacity: 0.5,
            strokeWeight: 1,
            fillColor: "blue",
            fillOpacity: 0.35
          });        
          circles.push(circle);     
          //TAMPILAN
          $("#hasilindustry").hide();
          $("#hasilculi").hide();
          $("#hasilmosque").hide();
          $("#hasilsouv").hide();
          $("#hasilobj").hide();
          $("#hasilhotel").hide();
           $("#hasilrestaurant").hide();

          if (document.getElementById("check_i").checked) {
            industri_sekitar(rad_lat,rad_lng,rad);
            $("#hasilindustry").show();
          }        

          if (document.getElementById("check_k").checked) {
            kuliner_sekitar(rad_lat,rad_lng,rad);
            $("#hasilculi").show();
          }      

          if (document.getElementById("check_m").checked) {
            masjid_sekitar(rad_lat,rad_lng,rad);
            $("#hasilmosque").show();
          }        

          if (document.getElementById("check_oo").checked) {
            oleholeh_sekitar(rad_lat,rad_lng,rad);
            $("#hasilsouv").show();
          }        

          if (document.getElementById("check_tw").checked) {
            tw_sekitar(rad_lat,rad_lng,rad);
            $("#hasilobj").show();
          }        

          if (document.getElementById("check_h").checked) {
            h_sekitar(rad_lat,rad_lng,rad);
            $("#hasilhotel").show();
          }  
          if (document.getElementById("check_res").checked) {
            restaurant_sekitar(rad_lat,rad_lng,rad);
            $("#hasilrestaurant").show();
          }        
          
        }

//Fungsi Aktifkan Radius IK
function aktifkanRadius2()
{
   var koordinat = new google.maps.LatLng(rad_lat, rad_lng);
          map.setCenter(koordinat);
          map.setZoom(16);  

          hapus_kecuali_landmark();
          hapusRadius();
          var inputradius=document.getElementById("inputradius2").value;
          console.log(inputradius);
          var rad = parseFloat(inputradius*100);
          var circle = new google.maps.Circle({
            center: koordinat,
            radius: rad,      
            map: map,
            strokeColor: "blue",
            strokeOpacity: 0.5,
            strokeWeight: 1,
            fillColor: "blue",
            fillOpacity: 0.35
          });        
          circles.push(circle);     
          //TAMPILAN
          $("#hasilindustry").hide();
          $("#hasilculi").hide();
          $("#hasilmosque").hide();
          $("#hasilsouv").hide();
          $("#hasilobj").hide();
          $("#hasilhotel").hide();
           $("#hasilrestaurant").hide();

          if (document.getElementById("check_i2").checked) {
            industri_sekitar(rad_lat,rad_lng,rad);
            $("#hasilindustry").show();
          }        

          if (document.getElementById("check_k2").checked) {
            kuliner_sekitar(rad_lat,rad_lng,rad);
            $("#hasilculi").show();
          }      

          if (document.getElementById("check_m2").checked) {
            masjid_sekitar(rad_lat,rad_lng,rad);
            $("#hasilmosque").show();
          }        

          if (document.getElementById("check_oo2").checked) {
            oleholeh_sekitar(rad_lat,rad_lng,rad);
            $("#hasilsouv").show();
          }        

          if (document.getElementById("check_tw2").checked) {
            tw_sekitar(rad_lat,rad_lng,rad);
            $("#hasilobj").show();
          }        

          if (document.getElementById("check_h2").checked) {
            h_sekitar(rad_lat,rad_lng,rad);
            $("#hasilhotel").show();
          }  
          if (document.getElementById("check_res2").checked) {
            restaurant_sekitar(rad_lat,rad_lng,rad);
            $("#hasilrestaurant").show();
          }        
          
        }


 function set_center(lat,lon,nama){

        //Hapus Info Sebelumnya
        hapusInfo();
        
        //POSISI MAP
        var centerBaru      = new google.maps.LatLng(lat, lon);
        map.setCenter(centerBaru);

        //JENDELA INFO
        var infowindow = new google.maps.InfoWindow({
              position: centerBaru,
              content: "<bold>"+nama+"</bold>",
            });
        infoDua.push(infowindow); 
        infowindow.open(map);  

      }


//Cek Radius
function cekRadius()
{
  rad = inputradius.value*100;
  console.log(rad);
}


//Fungsi Hapus Radius
function hapusRadius()
{
  for(var i=0;i<circles.length;i++)
  {
    circles[i].setMap(null);
  }
  circles=[];
  cekRadiusStatus = 'off';
}

//Fungsi Aktifkan Radius
function aktifkanRadiuss()
{
  $('#populertourism').hide();
  if (koordinat == 'null')
  {
    alert ('Click the Button of Your Position Beforehand');
  }
  else 
  {
    hapusRadius();
    centerLokasi = new google.maps.LatLng(koordinat.lat, koordinat.lng);
    console.log('lat='+koordinat.lat+', lng='+koordinat.lng);
    //hapusgrafik();
    var inputradiuss=document.getElementById("inputradiuss").value;
    var circle = new google.maps.Circle
    ({
      center: centerLokasi,
      radius: parseFloat(inputradiuss*100),      
      map: map,
      strokeColor: "blue",
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: "blue",
      fillOpacity: 0.35
    });        
    map.setZoom(12);       
    map.setCenter(centerLokasi);
    circles.push(circle);     
  }
  cekRadiusStatus = 'on';
  tampilradiuss();
  tampilradiuss2();
  hitung_jumlah();

}

function aktifkanRadiuss1()
{
  if (koordinat == 'null')
  {
    alert ('Click the Button of Your Position Beforehand');
  }
  else 
  {
    hapusRadius();
    centerLokasi = new google.maps.LatLng(koordinat.lat, koordinat.lng);
    console.log('lat='+koordinat.lat+', lng='+koordinat.lng);
    //hapusgrafik();
    var inputradiuss=document.getElementById("inputradiuss_type").value;
    var circle = new google.maps.Circle
    ({
      center: centerLokasi,
      radius: parseFloat(inputradiuss*100),      
      map: map,
      strokeColor: "blue",
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: "blue",
      fillOpacity: 0.35
    });        
    map.setZoom(12);       
    map.setCenter(centerLokasi);
    circles.push(circle);     
  }
  cekRadiusStatus = 'on';
}

function aktifkanRadiuss2()
{
  if (koordinat == 'null')
  {
    alert ('Click the Button of Your Position Beforehand');
  }
  else 
  {
    hapusRadius();
    centerLokasi = new google.maps.LatLng(koordinat.lat, koordinat.lng);
    console.log('lat='+koordinat.lat+', lng='+koordinat.lng);
    //hapusgrafik();
    var inputradiuss=document.getElementById("inputradiuss_status").value;
    var circle = new google.maps.Circle
    ({
      center: centerLokasi,
      radius: parseFloat(inputradiuss*100),      
      map: map,
      strokeColor: "blue",
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: "blue",
      fillOpacity: 0.35
    });        
    map.setZoom(12);       
    map.setCenter(centerLokasi);
    circles.push(circle);     
  }
  cekRadiusStatus = 'on';
}

function aktifkanRadiuss3()
{
  if (koordinat == 'null')
  {
    alert ('Click the Button of Your Position Beforehand');
  }
  else 
  {
    hapusRadius();
    centerLokasi = new google.maps.LatLng(koordinat.lat, koordinat.lng);
    console.log('lat='+koordinat.lat+', lng='+koordinat.lng);
    //hapusgrafik();
    var inputradiuss=document.getElementById("inputradiuss_selsou").value;
    var circle = new google.maps.Circle
    ({
      center: centerLokasi,
      radius: parseFloat(inputradiuss*100),      
      map: map,
      strokeColor: "blue",
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: "blue",
      fillOpacity: 0.35
    });        
    map.setZoom(12);       
    map.setCenter(centerLokasi);
    circles.push(circle);     
  }
  cekRadiusStatus = 'on';
}

function aktifkanRadiuss4()
{
  if (koordinat == 'null')
  {
    alert ('Click the Button of Your Position Beforehand');
  }
  else 
  {
    hapusRadius();
    centerLokasi = new google.maps.LatLng(koordinat.lat, koordinat.lng);
    console.log('lat='+koordinat.lat+', lng='+koordinat.lng);
    //hapusgrafik();
    var inputradiuss=document.getElementById("inputradiuss_price").value;
    var circle = new google.maps.Circle
    ({
      center: centerLokasi,
      radius: parseFloat(inputradiuss*100),      
      map: map,
      strokeColor: "blue",
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: "blue",
      fillOpacity: 0.35
    });        
    map.setZoom(12);       
    map.setCenter(centerLokasi);
    circles.push(circle);     
  }
  cekRadiusStatus = 'on';
}


function hitung_jumlah(){
  $.ajax
  ({ 
    url: server+'hitung_jumlah_radius.php?lat='+koordinat.lat+'&lng='+koordinat.lng+'&rad='+rad, data: "", dataType: 'json', success: function(rows)
    { 
      console.log(rows);
      // for (var i in rows) 
      // {   
      //   var row     = rows[i];
      //   var id  = row.id;
      //   var name   = row.name;
      //   var latitude  = row.latitude; ;
      //   var longitude = row.longitude ;
      //   centerBaru      = new google.maps.LatLng(latitude, longitude);
      //   //map.setCenter(centerBaru);
      //  // map.setCenter(koordinat);
      //   centerBaru = new google.maps.LatLng(latitude, longitude);
      //   marker = new google.maps.Marker
      //   ({
      //     position: centerBaru,
      //     map: map,
      //     icon: "assets/img/souv.png",
      //   });
      //   markersDua.push(marker);
      //   map.setCenter(centerBaru);
      //   map.setZoom(14);
      //   console.log(latitude);
      //   console.log(longitude);
      //   console.log(rad);
      //   clickMarker(centerBaru, id);
      //   $('#hasilcari').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success' onclick='detsou(\""+id+"\");detsousou(\""+id+"\");'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='souangkot(\""+id+"\")'></a></td></tr>");     
      //  }
       // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
       // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.jumlah);

    }

  });
}

//Menampilkan Data Radius Sou yg dicari pada Result
function tampilradiuss()
{
  hapusawal1();
  cekRadiuss();
  console.log(server+'souvenirradius.php?lat='+koordinat.lat+'&lng='+koordinat.lng+'&rad='+rad);
  $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='2'>Action</th></thead>");
  $.ajax
  ({ 
    url: server+'souvenirradius.php?lat='+koordinat.lat+'&lng='+koordinat.lng+'&rad='+rad, data: "", dataType: 'json', success: function(rows)
    { 
      for (var i in rows) 
      {   
        var row     = rows[i];
        console.log(row);
        var id  = row.id;
        var name   = row.name;
        var latitude  = row.latitude; ;
        var longitude = row.longitude ;
        centerBaru      = new google.maps.LatLng(latitude, longitude);
        //map.setCenter(centerBaru);
       // map.setCenter(koordinat);
        centerBaru = new google.maps.LatLng(latitude, longitude);
        marker = new google.maps.Marker
        ({
          position: centerBaru,
          map: map,
          icon: "assets/img/souv.png",
        });
        markersDua.push(marker);
        map.setCenter(centerBaru);
        map.setZoom(14);
        // console.log(latitude);
        // console.log(longitude);
        // console.log(rad);
        clickMarker(centerBaru, id);
        $('#hasilcari').append("<tr><td>"+name+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id+"\");detsousou(\""+id+"\");'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\",\""+latitude+"\",\""+longitude+"\");ikangkot(\""+id+"\",\""+latitude+"\",\""+longitude+"\")'></a></td></tr>");     
       }
       // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
    }

  });   
}


//Menampilkan Data Radius IK yg dicari pada Result
function tampilradiuss2()
{
  hapusawal1();
  cekRadiuss();
  $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='2'>Action</th></thead>");
  $.ajax
  ({ 
    url: server+'ikradius.php?lat='+koordinat.lat+'&lng='+koordinat.lng+'&rad='+rad, data: "", dataType: 'json', success: function(rows)
    { 
      for (var i in rows) 
      {   
        var row     = rows[i];
        console.log(row);
        var id  = row.id;
        var name   = row.name;
        var latitude  = row.latitude; ;
        var longitude = row.longitude ;
        centerBaru      = new google.maps.LatLng(latitude, longitude);
        //map.setCenter(centerBaru);
       // map.setCenter(koordinat);
        //centerBaru = new google.maps.LatLng(latitude, longitude);
        marker = new google.maps.Marker
        ({
          position: centerBaru,
          map: map,
          icon: "assets/img/ik.png",
        });
        markersDua.push(marker);
        map.setCenter(centerBaru);
        map.setZoom(14);
        // console.log(latitude);
        // console.log(longitude);
        // console.log(rad);
        clickMarker(centerBaru, id);
        $('#hasilcari').append("<tr><td>"+name+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id+"\");detsousou(\""+id+"\")'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\",\""+latitude+"\",\""+longitude+"\");ikangkot(\""+id+"\",\""+latitude+"\",\""+longitude+"\")'></a></td></tr>");
     // $('#hasilcari').append("<tr><td>"+name+"</td><td><a role='button' class='btn btn-success fa fa-info' onclick='detsouxx(\""+id+"\");'></a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='ikangkot(\""+id+"\")'></a></td></tr>");    
       }
       // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
    }

  });   
}



//Cek Radius
function cekRadiuss()
{
  rad = inputradiuss.value*100;
}


function clean()
 {
  $('#hasilcari').empty();
  $('#hasilculi').empty();
  $('#selectfacility').hide();
  $('#hasilpencarian').empty();
  $('#hasilpencarian').append("Bukittinggi Tourism..");
  //$('#jarakj').css('display','none');
  //hapusgrafik();
  hapusInfo();
  hapusRadius();
  hapusMarkerTerdekat();
  //clearmarkerDkt();
  //clearroute2();
  
}


function viewprice() //melihat harga souvenir
{
  $('#populertourism').hide();
  hapusawal();
  if (document.getElementById('cariprice').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var kulprice = document.getElementById('cariprice').value;
    console.log(kulprice);
    $('#hasilcari').empty();
    $('#hasilpencarian').empty();
    console.log("s");
    $.ajax
    ({ 
      url: server+'price.php?harga='+kulprice, data: "", dataType: 'json', success: function(rows)
      { 
         console.log("sa");
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var name   = row.name;
          var price   = row.price;
          var latitude  = row.latitude ;
          var longitude = row.longitude ;
          centerBaru = new google.maps.LatLng(latitude, longitude);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/souv.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id);
          console.log(id);
          $('#hasilcari').append("<tr><td>"+name+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id+"\");detsousou(\""+id+"\");'></a></td ><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\",\""+latitude+"\",\""+longitude+"\")'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}


function viewprice2() //melihat harga ik
{
  $('#populertourism').hide();
hapusawal();
  if (document.getElementById('cariprice2').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var kulprice = document.getElementById('cariprice2').value;
    console.log(kulprice);
    $('#hasilcari').empty();
    $('#hasilpencarian').empty();
    console.log("s");
    $.ajax
    ({ 
      url: server+'price_ik.php?harga='+kulprice, data: "", dataType: 'json', success: function(rows)
      { 
         console.log("sa");
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var name   = row.name;
          var price   = row.price;
          var latitude  = row.latitude ;
          var longitude = row.longitude ;
          centerBaru = new google.maps.LatLng(latitude, longitude);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/ik.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id);
          console.log(id);
          $('#hasilcari').append("<tr><td>"+name+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detik(\""+id+"\");detikik(\""+id+"\");'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='ikangkot(\""+id+"\",\""+latitude+"\",\""+longitude+"\")'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}

function viewprice_rad() //melihat harga souvenir
{
  hapusawal();
  aktifkanRadiuss4();
  if (document.getElementById('cariprice_rad').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var kulprice = document.getElementById('cariprice_rad').value;
    var inputradiuss=document.getElementById("inputradiuss_price").value * 100;
    console.log(server+'price_rad.php?harga='+kulprice+'&lat='+koordinat.lat+'&lng='+koordinat.lng+'&rad='+inputradiuss);
    $('#hasilcari').empty();
    $('#hasilpencarian').empty();
    console.log("s");
    $.ajax
    ({ 
      url: server+'price_rad.php?harga='+kulprice+'&lat='+koordinat.lat+'&lng='+koordinat.lng+'&rad='+inputradiuss, data: "", dataType: 'json', success: function(rows)
      { 
         console.log("sa");
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var name   = row.name;
          var price   = row.price;
          var latitude  = row.latitude ;
          var longitude = row.longitude ;
          centerBaru = new google.maps.LatLng(latitude, longitude);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/souv.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id);
          console.log(id);
          $('#hasilcari').append("<tr><td>"+name+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detsou(\""+id+"\");detsousou(\""+id+"\");'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='souangkot(\""+id+"\")'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}


function viewprice2_rad() //melihat harga ik
{
hapusawal();
aktifkanRadiuss4();
  if (document.getElementById('cariprice2_rad').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
    $('#hasilcari').append("<thead><th class='centered'>Name</th><th class='centered' colspan='3'>Action</th></thead>");
    var kulprice = document.getElementById('cariprice2_rad').value;
    var inputradiuss=document.getElementById("inputradiuss_price").value * 100;
    console.log(server+'price_ik_rad.php?harga='+kulprice+'&lat='+koordinat.lat+'&lng='+koordinat.lng+'&rad='+inputradiuss);
    $('#hasilcari').empty();
    $('#hasilpencarian').empty();
    console.log("s");
    $.ajax
    ({ 
      url: server+'price_ik_rad.php?harga='+kulprice+'&lat='+koordinat.lat+'&lng='+koordinat.lng+'&rad='+inputradiuss, data: "", dataType: 'json', success: function(rows)
      { 
         console.log("sa");
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var name   = row.name;
          var price   = row.price;
          var latitude  = row.latitude ;
          var longitude = row.longitude ;
          centerBaru = new google.maps.LatLng(latitude, longitude);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/ik.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          clickMarker(centerBaru, id);
          console.log(id);
          $('#hasilcari').append("<tr><td>"+name+"</td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-info' title='info' onclick='detik(\""+id+"\");detikik(\""+id+"\");'></a></td><td style='text-align:center;' ><a role='button' class='btn btn-success fa fa-taxi' title='angkot' onclick='ikangkot(\""+id+"\")'></a></td></tr>");
        }   
        // $('#hasilpencarian').append("<h5 class='box-title' id='hasilpencarian'>Result :</h5>"+rows.length);
      }
    }); 
  }
}

        
</script>
</head>

  <body onload="init()"> 
 
  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg" style="background-color:black;border-bottom: 1px solid black;">
            <div class="sidebar-toggle-box">
              <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
            </div>
            <!--logo start-->
            <a href="index.php" class="logo" style="font-family: Lucida Console;text-transform: capitalize;"><b>WebGIS Souvenir (11 1811521012 Nedia Putri Ismala)</b></a>
           <!-- <a class="logo"><p style="font-family: Lucida Console">&nbsp<b >Bukittinggi</b><b style="font-size: 17px"></b> - <b></b>Souvenir <i class="fa fa-gift" aria-hidden="true"></i></p></a> -->
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
              <ul class="nav top-menu">
                    <!-- settings start -->
                   
                    <!-- inbox dropdown end -->
              </ul>
                <!--  notification end -->
            </div>
            <h4>
            <div class="top-menu">
              <ul class="nav pull-right" style="margin-top: 6px">
                   <?php 
                   if ($_SESSION['C'] == false) 
                   {
                    echo "<a href='admin/' class='logo1' title='Login' ><img src='image/login.png'>
                   <span>Login</span></a>";
                   }
                   else
                   {
                    echo "<a href='admin/act/logout.php' class='logo1' title='Login' ><img src='image/login.png'>
                   <span>Logout</span></a>";
                   }
                    ?>
              </ul> 
            </div></h4>

    <style type="text/css">
    
      #legend {
        background:black;
        padding: 10px;
        margin: 5px;
        font-size: 12px;
        color: white;
        font-family: Arial, sans-serif;
    }
    .color {
        border: 1px solid;
        height: 12px;
        width: 12px;
        margin-right: 3px;
        float: left;
    }
    .a {
        background: #f75d5d;
      }
    .b {
        background: #ff3300;
      }
      .c {
        background: #ffd777;
      }
    .d {
        background: #ec87ec;
      }
    .e {
        background: darkcyan;
      }
    .f {
        background: magenta;
      }
    .g {
        background: pink;
      }
    .h {
        background: white;
      }
    .i {
        background: maroon;
      }
    .j {
        background: yellow;
      }
    .k {
        background: blue;
      }
    .l {
        background: navy;
      }


      /* akhir style slider popular  */
              body {
          font-family: Arial;
          margin: 0;
        }

        * {
          box-sizing: border-box;

          
        }

        img {
          vertical-align: middle;
        }

        /* Position the image container (needed to position the left and right arrows) */
        .container2 {
          position: relative;
        }

        /* Hide the images by default */
        .mySlides {
          display: block;
          width: auto;
          height: auto;
          padding: 20px;
          background-color: rgba(219,219,219,0.8);
        } 

        /* Add a pointer when hovering over the thumbnail images */
        .cursor {
          cursor: pointer;
        }

        /* Next & previous buttons */
        .prev,
        .next {
          cursor: pointer;
          position: absolute;
          top: 60%;
          width: auto;
          padding: 16px;
          margin-top: -50px;
          color: black;
          background-color: rgba(219,219,219,0.5);
          font-weight: bold;
          font-size: 20px;
          border-radius: 0 3px 3px 0;
          user-select: none;
          -webkit-user-select: none;
        }

        .prev1,
        .next1 {
          cursor: pointer;
          position: absolute;
          top: 100%;
          width: auto;
          padding: 10px;
          margin-top: 9.2px;
          color: white;
          background-color: rgba(0,0,0,0.5);
          font-weight: bold;
          font-size: 20px;
          border-radius: 0 3px 3px 0;
          user-select: none;
          -webkit-user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
          right: 0;
          border-radius: 3px 0 0 3px;
        }

        .next1 {
          right: 0;
          border-radius: 3px 0 0 3px;
        }

        .prev{
          left: 0;
          border-radius: 3px 0 0 3px;
        }

        .prev1{
          left: 0;
          border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover,
        .next:hover {
          background-color: rgba(255, 255, 255, 0.8);
          color: black;
        }

        .prev1:hover,
        .next1:hover {
          background-color: rgba(255, 255, 255, 0.8);
          color: black;
        }
        .row2:after {
          
          display: none;
          clear: both;
        }

        /* Six columns side by side */
        .column {
          float: left;
          width: 25%; 
          padding: 4px;
          background-color: grey;
        }

        /* Add a transparency effect for thumnbail images */
        .demo {
          opacity: 1;
        }

        .active,
        .demo:hover {
          opacity: 1;
          color: black;
        }
      
    /* akhir style slider popular  */
   </style>

      </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside >

          <div  id="sidebar"  class="nav-collapse " >
              <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">
              
              <p class="centered"><a href="#"><img src="assets/img/jam.jpg" class="img-circle" width="150" height="120"></a></p>
              <h5 class="centered">
              <?php 
              if ($_SESSION['C'] == true) {
                echo $_SESSION['username']; 
              }
              else{
                 echo "Bukittinggi";
              }
              
              ?>&nbsp</h5>

            <br>

                
              <!-- <h6 class="centered" style="color: white;">Souvenir</h6> -->

                    <li class="sub-menu">
                      <a href="javascript:;" onclick="init();viewsou()">
                        <i class="fa fa-list"></i>
                        <span>Souvenir List</span>
                      </a>
                      </li>
        
                      <li class="sub-menu">
                      <a href="javascript:;" >
                        <i class="fa fa-map-pin"></i>
                        <span>Souvenir Arround You</span>
                      </a>
                      <ul class="treeview-menu">
                        <div class=" form-group" style="color: white;"> <br>
                          <label>Based On Radius</label><br>
                          <label for="inputradiuss">Radius : </label>
                          <label  id="nilai">0</label> m
                          <script>
                            function cekkk()
                            { 
                              console.log('nilai: '+document.getElementById('nilai').value);
                              document.getElementById('nilai').innerHTML=document.getElementById('inputradiuss').value*100
                            }
                          </script>
                          <input  type="range" onchange="cekkk();aktifkanRadiuss()" id="inputradiuss" 
                                  name="inputradiuss" data-highlight="true" min="0" max="20" value="0" >
                        </div>
                                      <!-- <button type="button" id="inputradius" onclick="aktifkanRadius();aktifkanRadius2()" class="btn btn-info btn-block btn-flat" >Cari</button> -->
                      </ul>
                    </li>

         

              <li class="sub-menu">
                  <!-- <a href="javascript:;" >
                    <i class="fa fa-search"></i>
                    <span>Search Souvenir Place</span>
                  </a> -->
                  <ul class="sub">
                    <div class=" form-group">
                      <li>
                        <div class="search">
                          <div class="col-md-15 padding-0 text-center">
                          <div class="form-group form-animate-text"><br>
                            <input type="text"  class="form-control" placeholder="Name of Souvenir" id="kul_nama" required>
                              <span class="bar"></span> 
                          </div>         
                        <button type="submit" class="btn btn-info btn-block btn-flat" id="kul_button" onclick='find_sou();'>Search</button>
                      </div> 
                      </div> 
                      </li>
                    </div>         
                  </ul>
                </li>


              <li class="sub-menu">
                  <a href="javascript:;" >
                    <i class="fa fa-eye"></i>
                    <span>View Souvenir</span>
                  </a>
                  <ul class="sub">
                    <li class="sub-menu">
                      <a href="javascript:;" >
                        <i class="fa fa-globe"></i>
                        <span>Sub District</span>
                      </a>
                      <ul class="sub">
                        <div class=" form-group"> <br>
                          <!-- <label style="color: white;">Sub District</label> -->
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="carikecamatankul">
                            <option value="">-Choose-</option>
                            <?php
                              include("connect.php"); 
                              $carikecamatankul=mysqli_query($conn,"select * from district order by name ASC");
                              while($rowcarikecamatankul = mysqli_fetch_assoc($carikecamatankul))
                              {
                                echo"<option value=".$rowcarikecamatankul['id'].">".$rowcarikecamatankul['name']."</option>";
                              }
                            ?>
                          </select>
                                              
                        </div>
                        
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="kul_kec" onclick='viewkecamatansou();'>Search</button>
                        </div>
                     </ul>
                    </li>

                    <li class="sub-menu">
                  <a href="javascript:;" >
                    <i class="fa fa-cubes"></i>
                    <span>Type</span>
                  </a>
                  <ul class="sub">
                  <li class="sub-menu">
                      <a href="javascript:;" >
                        <i class="fa fa-cubes"></i>
                        <span>Souvenir</span>
                      </a>
                      <ul class="sub">
                        <div class=" form-group"> <br>
                          <!-- <label style="color: white;">Sub District</label> -->
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="caritipe">
                            <option value="">-Choose-</option>
                            <?php
                              include("connect.php"); 
                              $caritipe=mysqli_query($conn,"select * from souvenir_type order by name ASC");
                              while($rowcaristatus = mysqli_fetch_assoc($caritipe))
                              {
                                echo"<option value=".$rowcaristatus['id'].">".$rowcaristatus['name']."</option>";
                              }
                            ?>
                          </select>
                                              
                        </div>
                        
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="viewtipe" onclick='viewtipe();'>Search</button>
                        </div>
                     </ul>
                </li>


                    <li class="sub-menu">
                      <a href="javascript:;" >
                        <i class="fa fa-cubes"></i>
                        <span>Craft</span>
                      </a>
                      <ul class="sub">
                        <div class=" form-group"> <br>
                          <!-- <label style="color: white;">Sub District</label> -->
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="caritipe2">
                            <option value="">-Choose-</option>
                            <?php
                              include("connect.php"); 
                              $caritipe2=mysqli_query($conn,"select * from industry_type order by name ASC");
                              while($rowcaristatus = mysqli_fetch_assoc($caritipe2))
                              {
                                echo"<option value=".$rowcaristatus['id'].">".$rowcaristatus['name']."</option>";
                              }
                            ?>
                          </select>
                                              
                        </div>
                        
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="viewstipe" onclick='viewtipe2();'>Search</button>
                        </div>
                     </ul>
                    </li>
                  </ul>
                  </li>


                    <li class="sub-menu">
                      <a href="javascript:;" >
                        <i class="fa fa-home"></i>
                        <span>Status</span>
                      </a>
                      <ul class="sub">
                        <div class=" form-group"> <br>
                          <!-- <label style="color: white;">Sub District</label> -->
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="caristatus">
                            <option value="">-Choose-</option>
                            <?php
                              include("connect.php"); 
                              $caristatus=mysqli_query($conn,"select * from status order by status ASC");
                              while($rowcaristatus = mysqli_fetch_assoc($caristatus))
                              {
                                echo"<option value=".$rowcaristatus['id'].">".$rowcaristatus['status']."</option>";
                              }
                            ?>

                          </select>
                                              
                        </div>
                        
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="viewstatus" onclick='viewstatus();'>Search</button>
                        </div>
                     </ul>
                    </li>

                    <!-- <li class="sub-menu">
                      <a href="javascript:;" >
                        <i class="fa fa-unlock"></i>
                        <span>Active</span>
                      </a>
                      <ul class="sub">
                        <div class=" form-group"> <br>
                          <label style="color: white;">Sub District</label>
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="caristatuses">
                            <option value="">-Choose-</option>
                            <option value="1">Active</option>
                            <option value="2">Non Active</option>
                          </select>
                                              
                        </div>
                        
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="viewstatuses" onclick='viewstatuses();'>Search</button>
                        </div>
                     </ul>
                    </li> -->

                    <li class="sub-menu">
                      <a href="javascript:;" >
                      <i class="fa fa-user"></i>
                        <span>Contact Person</span>
                      </a>
                      <ul class="sub">
                        <div class=" form-group"> <br>
                          <!-- <label style="color: white;">Sub District</label> -->
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="cp">
                            <option value="">-Choose-</option>
                            <option value="1">Available</option>
                            <option value="2">Not Available</option>
                          </select>
                                              
                        </div>
                        
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="cp" onclick='cpes();'>Search</button>
                        </div>
                     </ul>
                    </li>

                    <li class="sub-menu">
                      <a href="javascript:;" >
                        <i class="fa fa-sort"></i>
                        <span>Rating</span>
                      </a>
                      <ul class="sub">
                        <div class=" form-group"> <br>
                          <!-- <label style="color: white;">Sub District</label> -->
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="rating">
                            <option value="">-Choose-</option>
                            <option value="1">Star 1</option>
                            <option value="2">Star 2</option>
                            <option value="3">Star 3</option>
                            <option value="4">Star 4</option>
                            <option value="5">Star 5</option>
                          </select>
                                              
                        </div>
                        
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="rating" onclick='ratinges();'>Search</button>
                        </div>
                     </ul>
                    </li>

                    <!-- <li class="sub-menu">
                      <a href="javascript:;" >
                        <i class="fa fa-male"></i>
                        <span>Gender</span>
                      </a>
                      <ul class="sub"> -->
                        <!-- <div class=" form-group"> <br>
                          <label style="color: white;">Sub District</label>
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="genderes">
                            <option value="">-Choose-</option>
                            <option value="l">Male</option>
                            <option value="p">Female</option>
                          </select>
                                              
                        </div>
                        
                         <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="genderes"
                          onclick='genderes();'>Search</button>
                        </div> -->
                     <!-- </ul>
                    </li>  -->

                    <!-- <li class="sub-menu">
                      <a href="javascript:;" onclick="selectsou()">
                       <i class="fa fa-shopping-cart"></i>
                       <span>Select Souvenir</span>
                       </a>
                    </li> -->


                    <!-- <li class="sub-menu">
                      <a href="javascript:;" onclick="selectik()">
                       <i class="fa fa-shopping-cart"></i>
                       <span>Select Craft</span>
                       </a>
                    </li> -->



                  <li class="sub-menu">
                  <a href="javascript:;" >
                    <i class="fa fa-money"></i>
                    <span>Price</span>
                  </a>
                  <ul class="sub">  

                  <li class="sub-menu">
                    <a href="javascript:;" >
                      <i class="fa fa-money"></i>
                      <span>Souvenir</span>
                    </a>
                    <ul class="sub">
                       <div class=" form-group"> <br>
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="cariprice">
                            <option name="harga" value="">-Choose-</option>
                            <option name="harga" value="1"> < Rp 20.000</option>
                            <option name="harga" value="2">Rp 20.000 - Rp 50.000</option>
                            <option name="harga" value="3"> > Rp 50.000</option>
                          </select>
                        </div>
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="kul_kec" onclick='viewprice();'>Search
                          </button>
                        </div>
                    </ul>
                  </li>


                  <li class="sub-menu">
                    <a href="javascript:;" >
                      <i class="fa fa-money"></i>
                      <span>Craft</span>
                    </a>
                    <ul class="sub">
                       <div class=" form-group"> <br>
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="cariprice2">
                            <option name="harga" value="">-Choose-</option>
                            <option name="harga" value="1"> < Rp 100.000</option>
                            <option name="harga" value="2">Rp 100.000 - Rp 500.000</option>
                            <option name="harga" value="3"> > Rp 500.000</option>
                          </select>
                        </div>
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="kul_kec" onclick='viewprice2();'>Search
                          </button>
                        </div>
                    </ul>
                  </li>


                </ul>
              </li></ul></li>
              
              <li class="sub-menu">
                  <!-- <a href="javascript:;" >
                    <i class="fa fa-eye"></i>
                    <span>View Souvenir with Radius</span>
                  </a> -->
                  <ul class="sub">
                    <li class="sub-menu">
                  <a href="javascript:;" >
                    <i class="fa fa-cubes"></i>
                    <span>Type</span>
                  </a>
                  <ul class="sub">
                  <div class=" form-group" style="color: white;"> <br>
                          <label>Based On Radius</label><br>
                          <label for="inputradiuss_type">Radius : </label>
                          <label  id="nilai_type">0</label> m
                          <script>
                            function cekkk1()
                            {
                              document.getElementById('nilai_type').innerHTML=document.getElementById('inputradiuss_type').value*100
                            }
                          </script>
                          <input  type="range" onchange="cekkk1();aktifkanRadiuss1()" id="inputradiuss_type" 
                                  name="inputradiuss_type" data-highlight="true" min="0" max="20" value="0" >
                  </div>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                        <i class="fa fa-cubes"></i>
                        <span>Souvenir</span>
                      </a>
                      <ul class="sub">
                        <div class=" form-group"> <br>
                          <!-- <label style="color: white;">Sub District</label> -->
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="caritipe_rad">
                            <option value="">-Choose-</option>
                            <?php
                              include("connect.php"); 
                              $caritipe=mysqli_query($conn,"select * from souvenir_type order by name ASC");
                              while($rowcaristatus = mysqli_fetch_assoc($caritipe))
                              {
                                echo"<option value=".$rowcaristatus['id'].">".$rowcaristatus['name']."</option>";
                              }
                            ?>
                          </select>
                                              
                        </div>
                        
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="viewtipe" onclick='viewtipe_rad();'>Search</button>
                        </div>
                     </ul>
                </li>


                    <li class="sub-menu">
                      <a href="javascript:;" >
                        <i class="fa fa-cubes"></i>
                        <span>Craft</span>
                      </a>
                      <ul class="sub">
                        <div class=" form-group"> <br>
                          <!-- <label style="color: white;">Sub District</label> -->
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="caritipe2_rad">
                            <option value="">-Choose-</option>
                            <?php
                              include("connect.php"); 
                              $caritipe2=mysqli_query($conn,"select * from industry_type order by name ASC");
                              while($rowcaristatus = mysqli_fetch_assoc($caritipe2))
                              {
                                echo"<option value=".$rowcaristatus['id'].">".$rowcaristatus['name']."</option>";
                              }
                            ?>
                          </select>
                                              
                        </div>
                        
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="viewstipe" onclick='viewtipe2_rad();'>Search</button>
                        </div>
                     </ul>
                    </li>
                  </ul>
                  </li>


                    <li class="sub-menu">
                      <a href="javascript:;" >
                        <i class="fa fa-home"></i>
                        <span>Status</span>
                      </a>
                      <ul class="sub">
                        <div class=" form-group" style="color: white;"> <br>
                          <label>Based On Radius</label><br>
                          <label for="inputradiuss_status">Radius : </label>
                          <label  id="nilai_status">0</label> m
                          <script>
                            function cekkk2()
                            {
                              document.getElementById('nilai_status').innerHTML=document.getElementById('inputradiuss_status').value*100
                            }
                          </script>
                          <input  type="range" onchange="cekkk2();aktifkanRadiuss2()" id="inputradiuss_status" 
                                  name="inputradiuss_status" data-highlight="true" min="0" max="20" value="0" >
                        </div>
                          <!-- <label style="color: white;">Sub District</label> -->
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="caristatus_rad">
                            <option value="">-Choose-</option>
                            <?php
                              include("connect.php"); 
                              $caristatus=mysqli_query($conn,"select * from status order by status ASC");
                              while($rowcaristatus = mysqli_fetch_assoc($caristatus))
                              {
                                echo"<option value=".$rowcaristatus['id'].">".$rowcaristatus['status']."</option>";
                              }
                            ?>

                          </select>
                                              
                        
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="viewstatus_rad" onclick='viewstatus_rad();'>Search</button>
                        </div>
                     </ul>
                    </li>


                    <li class="sub-menu">
                      <a href="javascript:;" onclick="selectsou()">
                       <i class="fa fa-shopping-cart"></i>
                       <span>Select Souvenir</span>
                       </a>
                       <ul class="sub">
                       <div class=" form-group" style="color: white;"> <br>
                          <label>Based On Radius</label><br>
                          <label for="inputradiuss_selsou">Radius : </label>
                          <label  id="nilai_selsou">0</label> m
                          <script>
                            function cekkk3()
                            {
                              document.getElementById('nilai_selsou').innerHTML=document.getElementById('inputradiuss_selsou').value*100
                            }
                          </script>
                          <input  type="range" onchange="cekkk3();aktifkanRadiuss3()" id="inputradiuss_selsou" 
                                  name="inputradiuss_selsou" data-highlight="true" min="0" max="20" value="0" >
                        </div>
                        </ul>
                    </li>


                    <!-- <li class="sub-menu">
                      <a href="javascript:;" onclick="selectik()">
                       <i class="fa fa-shopping-cart"></i>
                       <span>Select Craft</span>
                       </a>
                    </li> -->



                  <li class="sub-menu">
                  <a href="javascript:;" >
                    <i class="fa fa-money"></i>
                    <span>Price</span>
                  </a>
                  <ul class="sub">  
                  <div class=" form-group" style="color: white;"> <br>
                          <label>Based On Radius</label><br>
                          <label for="inputradiuss_price">Radius : </label>
                          <label  id="nilai_price">0</label> m
                          <script>
                            function cekkk4()
                            {
                              document.getElementById('nilai_price').innerHTML=document.getElementById('inputradiuss_price').value*100
                            }
                          </script>
                          <input  type="range" onchange="cekkk4();aktifkanRadiuss4()" id="inputradiuss_price" 
                                  name="inputradiuss_price" data-highlight="true" min="0" max="20" value="0" >
                  </div>
                  <li class="sub-menu">
                    <a href="javascript:;" >
                      <i class="fa fa-money"></i>
                      <span>Souvenir</span>
                    </a>
                    <ul class="sub">
                       <div class=" form-group"> <br>
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="cariprice_rad">
                            <option name="harga" value="">-Choose-</option>
                            <option name="harga" value="1"> < Rp 20.000</option>
                            <option name="harga" value="2">Rp 20.000 - Rp 50.000</option>
                            <option name="harga" value="3"> > Rp 50.000</option>
                          </select>
                        </div>
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="kul_kec" onclick='viewprice_rad();'>Search
                          </button>
                        </div>
                    </ul>
                  </li>


                  <li class="sub-menu">
                    <a href="javascript:;" >
                      <i class="fa fa-money"></i>
                      <span>Craft</span>
                    </a>
                    <ul class="sub">
                       <div class=" form-group"> <br>
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="cariprice2_rad">
                            <option name="harga" value="">-Choose-</option>
                            <option name="harga" value="1"> < Rp 100.000</option>
                            <option name="harga" value="2">Rp 100.000 - Rp 500.000</option>
                            <option name="harga" value="3"> > Rp 500.000</option>
                          </select>
                        </div>
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="kul_kec" onclick='viewprice2_rad();'>Search
                          </button>
                        </div>
                    </ul>
                  </li>

                  


                </ul>
              </li></ul></li>
            
              <li class="sub-menu">
                      <a class="active" href=".././">
                          <i class="fa fa-hand-o-left"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <section id="main-content">
        <section class="wrapper site-min-height">
          <div class="row mt">
           <div class="col-lg-8 ds" >
            <section class="panel">
               <header class="panel-heading">
                <label style="color: black">Google Map With Location List :</label>
                   <button type="button" onclick="posisisekarang()" class="btn btn-success " data-toggle="tooltip" id="posisinow" title="My Position" 
                      ><i class="fa fa-location-arrow"  style="color:white"> </i>
                      </button>

                       <button type="button" onclick="lokasimanual()" class="btn btn-success"  data-toggle="tooltip" id="posmanual" title="Manual Position" 
                              ><i class="fa fa-map-marker" style="color:white;"></i>
                      </button>
                                            
                       <!-- <button type="button" onclick="viewsou()" class="btn btn-default" data-toggle="tooltip" title="Melihat Semua Souvenir" 
                               style="margin: 7px" ><i class="fa fa-bullseye"></i>
                       </button> -->

                       <!-- <button type="button" onclick="clean()" class="btn btn-default" data-toggle="tooltip" title="Refresh" ><i class="fa fa-refresh"></i>
                       </button> -->
                       <label id="tombol">
                       <a type="button" onclick="legenda()" id="showlegenda" class="btn btn-success" data-toggle="tooltip" title="Legenda" ><i class="fa fa-eye" style="color:white;"></i>
                       </a>
                       </label>
                  </header>
                <!-- First Action -->
                      <div class="panel-body" >
                          <div id="map" style="width:100%;height:400px; z-index:50"></div>
                      </div>
            </section>
           
              
                      <!--custom chart end-->
                          <div class="col-lg-6 ds"  id="hasildet" style="display:none;">
                          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
                          <!-- <h3 style="font-size:16px">Information</h3> -->
                          <!-- <a class="btn btn-compose">Information</a> -->
                              <!-- First Action -->
                              <div class="box-body" style="max-height:450px;overflow:auto;">
                                <div class="form-group" id="hasilcaridet1" style="display:none;">
                                  <table class="table " id='hasilcaridet'></table>
                               
                                </div>
                              </div>         
                        </div>

                         <div  class="col-lg-4 ds"  id="hasildetsou" style="display:none; ">
                          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
                          <!-- <h3 style="font-size:16px">Information Kul</h3> -->
                          <a style="background-color:black" class="btn btn-compose" >Information</a>
                              <!-- First Action -->
                              <div class="box-body" style="max-height:450px;overflow:auto;">
                                <div class="form-group" id="hasilcaridetsou1" style="display:none;">
                                  <table class="table " id='hasilcaridetsou'></table>
                               
                                </div>
                                
                              </div>         
                        </div>

                        <div class="col-lg-4 ds"  id="tampilangkotsekitarik" style="display:none;" >
                          
                          <!-- <h3 style="font-size:16px">Angkot Information</h3> -->
                              <a class="btn btn-compose" style="background-color:black;color:white">Angkot Information</a>
                              <div class="box-body" style="max-height:450px;overflow:auto;">
                                <div class="form-group" id="tampillistangkotik1" style="display:none;">
                                  <table class="table table-bordered" id='tampillistangkotik'></table>
                                </div>
                              </div>         
                        </div> 
                        <div class="col-lg-4 ds"  id="hasilmosque" style="display:none;">
                          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
                          <!-- <h3 style="font-size:16px">Mosque Information</h3> -->
                          <a class="btn btn-compose" style="background-color:black;color:white">Mosque Information</a>
                              <!-- First Action -->
                              <div class="box-body" style="max-height:450px;overflow:auto;">
                                <div class="form-group" id="hasilcarimosque1" style="display:none;">
                                  <table class="table table-bordered" id='hasilcarimosque'></table>
                                </div>
                              </div>         
                        </div> 

                           <div class="col-lg-4 ds"  id="hasilrestaurant" style="display:none;">
                          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
                          <!-- <h3 style="font-size:16px">Mosque Information</h3> -->
                          <a class="btn btn-compose" style="background-color:black;color:white">Restaurant Information</a>
                              <!-- First Action -->
                              <div class="box-body" style="max-height:450px;overflow:auto;">
                                <div class="form-group" id="hasilcarirestaurant1" style="display:none;">
                                  <table class="table table-bordered" id='hasilcarirestaurant'></table>
                                </div>
                              </div>         
                        </div>


                        <div class="col-lg-4 ds"  id="hasilhotel" style="display:none;">
                          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
                          <!-- <h3 style="font-size:16px">Hotel Information</h3> -->
                          <a class="btn btn-compose" style="background-color:black;color:white">Hotel Information</a>
                              <!-- First Action -->
                              <div class="box-body" style="max-height:450px;overflow:auto;">
                                <div class="form-group" id="hasilcarihotel1" style="display:none;">
                                  <table class="table table-bordered" id='hasilcarihotel'></table>
                                </div>
                              </div>         
                        </div> 

                        <div class="col-lg-4 ds"  id="hasilobj" style="display:none;">
                          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
                          <!-- <h3 style="font-size:16px">Tourism Information</h3> -->
                          <a class="btn btn-compose" style="background-color:black;color:white">Tourism Information</a>
                              <!-- First Action -->
                              <div class="box-body" style="max-height:450px;overflow:auto;">
                                <div class="form-group" id="hasilcariobj1" style="display:none;">
                                  <table class="table table-bordered" id='hasilcariobj'></table>
                                </div>
                              </div>         
                        </div> 

                        <div class="col-lg-4 ds"  id="hasilindustry" style="display:none;">
                          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
                          <!-- <h3 style="font-size:16px">Industry Information</h3> -->
                          <a class="btn btn-compose" style="background-color:black;color:white">Industry Information</a>
                              <!-- First Action -->
                              <div class="box-body" style="max-height:450px;overflow:auto;">
                                <div class="form-group" id="hasilcariind1" style="display:none;">
                                  <table class="table table-bordered" id='hasilcariind'></table>
                                </div>
                              </div>         
                        </div> 

                        <div class="col-lg-4 ds"  id="hasilsouv" style="display:none;">
                          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
                          <!-- <h3 style="font-size:16px">Souvenir Information</h3> -->
                           <a class="btn btn-compose" style="background-color:black;color:white">Souvenir Information</a>
                              <!-- First Action -->
                              <div class="box-body" style="max-height:450px;overflow:auto;">
                                <div class="form-group" id="hasilcarisouv1" style="display:none;">
                                  <table class="table table-bordered" id='hasilcarisouv'></table>
                                </div>
                              </div>         
                        </div> 

                        <div class="col-lg-4 ds"  id="hasilculi" style="display:none;">
                          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
                          <!-- <h3 style="font-size:16px">Culinary Information</h3> -->
                           <a class="btn btn-compose" style="background-color:black;color:white">Culinary Information</a>
                              <!-- First Action -->
                              <div class="box-body" style="max-height:450px;overflow:auto;">
                                <div class="form-group" id="hasilcariculi1" style="display:none;">
                                  <table class="table table-bordered" id='hasilcariculi'></table>
                                </div>
                              </div>         
                        </div> 

                      </div>
                    
             
					

      <!-- </div>/col-lg-9 END SECTION MIDDLE -->
                  
                  
                  
      <!-- **********************************************************************************************************************************************************
      RIGHT SIDEBAR CONTENT
      *********************************************************************************************************************************************************** -->                  
    
      <!-- <div id="view_kanan_table" class="col-md-4 col-sm-4 mb" style="margin-top:0px; display:block;">
                        <div class="white-panel pns" style="height:510px">
                           <div class="white-header" style="height:40px;margin:20px;background:white;color:black">
                             <h5 class="btn btn-compose" id="judul_table" style="background-color:black;border-bottom:black">Popular Tourism</h5>
                           </div>
                           <div class="row">
                             <div class="col-sm-6 col-xs-6"></div>
                           </div>
                           <div style="height:410px; overflow-y: scroll; margin:20px;">
                              <div class="html5gallery" style="max-height:700px; overflow:auto; display:block;" data-skin="horizontal" data-width="280" data-resizemode="fit">
                              <a href='../_foto/tw0012.jpg'><img src='../_foto/tw0012.jpg'></a>
                              <a href='../_foto/tw0041.jpg'><img src='../_foto/tw0041.jpg'></a>
                              <a href='../_foto/tw0071.jpg'><img src='../_foto/tw0071.jpg'></a>
                              <a href='../_foto/tw0112.jpg'><img src='../_foto/tw0112.jpg'></a>
                              <?php
                                // $querysearch  ="SELECT a.id, b.gallery_tourism FROM tourism as a left join tourism_gallery as b on a.id=b.id where a.id='tw001' OR a.id='tw002' OR a.id='tw003'";  
                                // var_dump($querysearch);
                                // die();
                                // $hasil=pg_query($querysearch);
                                // while($baris = pg_fetch_assoc($hasil)){
                                //   if(($baris['gallery_tourism']=='-')||($baris['gallery_tourism']=='')){
                                //     echo "<a href='../_foto/foto.jpg'><img src='../_foto/foto.jpg' ></a>";
                                //   }
                                //   else{
                                //     echo "<a href='../_foto/".$baris['gallery_tourism']."'><img src='../_foto/".$baris['gallery_tourism']."'></a>";
                                //   }
                                // }
                              ?>
                              </div>
                              <table style="color:black" class="table table-bordered">
                                <tbody id='kanan_table'></tbody>
                              </table>
                           </div>
                        </div>
                      </div>/col-md-12 -->


<!-- batas awal popular tourism clickable -->
                <!-- GALLLERY  RECOMMENDASI TOURISM -->
                <div id="populertourism">
                <div id="view_kanan_table" class="col-md-4 col-sm-4 mb" style="display:block;">    
                   <div class="white-panel pns" style="height: 530px;">
                      
                        <header class="panel-heading" style=" width: 100%"  >
                          <label class="btn btn-compose" id="judul_table" style="background-color:black;border-bottom:black;color:white;">Popular Souvenir
                          </label>
                        </header>
                        <div style="heigh:500px; margin-left:40px;margin-right:40px;margin-bottom:5px;margin-top:10px;">

                        
                          <div class="container2" style="padding-top:0px;">
                            <div class="row2" >
                            <div class="mySlides">
                                
                                <option href="" onclick='viewtipea();' id="caritipesou" value="a" ><img src="../_foto/sanjai.jpg" style="width:100%" value="a"></option>
                                <!-- <h5 style="color:black">Sanjai</h5> -->
                              </div>

                              <div class="mySlides">
                                  
                                <option href="" onclick='viewtipeb();' id="caritipesou" value="a" ><img src="../_foto/coffe.jpg" style="width:100%" value="a"></option>
                                <!-- <h5 style="color:black">Samek</h5> -->
                              </div>

                              <div class="mySlides">
                              
                              <option href="" onclick='viewtiped();' id="caritipesou" value="d" ><img src="../_foto/bktshirt.jpg" style="width:100%" value="d"></option>
                                <!-- <h5 style="color:black">Tangkelek</h5> -->
                              </div>
                                
                              <div class="mySlides">
                              
                              <option href="" onclick='viewtipec();' id="caritipesou" value="c" ><img src="../_foto/cake.jpg" style="width:100%" value="c"></option>
                                <!-- <h5 style="color:black">Umi Aufa Hakim</h5> -->
                              </div>

                              <!-- <div class="mySlides">
                              
                                <a href="" onclick="galleryreco('SO007')"><img src="../_foto/ananda.png" style="width:100%"></a>
                                <h5 style="color:black">Sanjai Ananda</h5>
                              </div> -->
                               
                              <a class="prev" onclick="plusSlides(-1)">❮</a>
                              <a class="next" onclick="plusSlides(1)">❯</a>
                            </div>  
                            <br>
                            <div class="row2">
                              <div class="column">
                                <img class="demo cursor" src="../_foto/sanjai.jpg" style="width:100%" onclick="currentSlide(1)">
                              </div>
                              <div class="column">
                                <img class="demo cursor" src="../_foto/coffe.jpg" style="width:100%" onclick="currentSlide(2)">
                              </div>
                              <div class="column">
                                <img class="demo cursor" src="../_foto/bktshirt.jpg" style="width:100%" onclick="currentSlide(3)">
                              </div>
                              <div class="column">
                                <img class="demo cursor" src="../_foto/cake.jpg" style="width:100%" onclick="currentSlide(4)">
                              </div>

                            


                              <a class="prev1" onclick="plusSlides(-1)">❮</a>
                              <a class="next1" onclick="plusSlides(1)">❯</a>
                            </div>
                          </div>
                        </div>
                          <div style="height:400px; overflow-y: scroll; margin:2px;">
                            <table style="color:black;" class="table table-bordered" >
                                <tbody id='kanan_table'></tbody>
                            </table>
                          </div>  
                        <script>
                          var slideIndex = 1;
                          showSlides(slideIndex);


                          function plusSlides(n) {
                            showSlides(slideIndex += n);
                          }

                          function currentSlide(n) {
                            showSlides(slideIndex = n);
                          }

                          function showSlides(n) {
                            var i;
                            var slides = document.getElementsByClassName("mySlides");
                            var dots = document.getElementsByClassName("demo");
                            var captionText = document.getElementById("caption");
                            if (n > slides.length) {slideIndex = 1}
                            if (n < 1) {slideIndex = slides.length}
                            for (i = 0; i < slides.length; i++) {
                                slides[i].style.display = "none";
                            }
                            for (i = 0; i < dots.length; i++) {
                                dots[i].className = dots[i].className.replace(" active", "");
                            }
                            slides[slideIndex-1].style.display = "block";
                            dots[slideIndex-1].className += " active";
                            captionText.innerHTML = dots[slideIndex-1].alt;
                            }

                            // GALLERY RECOMENDATION SLIDER DI INDEX
                              function galleryreco(a) {
                              console.log(a);
                              window.open(server + 'gallery.php?idgallery=' + a);
                              }
                          </script>


                      </div>
                    </div>
                </div>
<!-- batas akhir popular tourism clickable -->


        <div   id="hasilik" class="col-md-4 col-sm-4 mb"  display:block; >
          <section class="panel"style="height: 500px;" >
          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
          <h2 class="box-title" id="hasilpencarian">
          <!-- <marquee width="100%" behavior="alternate" scrollamount="4">Bukittinggi Tourism..</marquee> -->
          </h2><br>
           <section class="panel" id="result">
                    <div  class="panel-body" >
          <a class="btn btn-compose" style="background-color:black">Result</a>
              <!-- First Action -->

              <div class="box-body" style="max-height:400px;overflow:auto;">
                <div class="form-group" id="hasilcari1" style="display:none;">
                  <table class="table table-bordered" id='hasilcari'></table>
                </div>
              </div>         
        </div> 
        </section>
        </div>

      <div id="nearbyik" class="col-md-4 col-sm-4 mb" style="display:none">
                        <div class="white-panel pns" style="padding:15px">
                           <div class="white-header" style="height:40px;background:white;color:black">
                             <!-- <h4><u><b>Object Arround</b></u></h4> -->
                             <a class="btn btn-compose" style="background-color:black">Object Arround</a>
                           </div>
                           <div class="row">
                             <div class="col-sm-6 col-xs-6"></div>
                           </div>
                           <div style="text-align:left;margin:10px; color:black;">
                              <!--img src="assets/img/product.png" width="120"-->
                              <div class="checkbox">
                                <label>
                                  <input id="check_tw" type="checkbox">
                                  Object Tourism
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input id="check_i" type="checkbox" >
                                  Small Industry
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input id="check_m" type="checkbox" value="">
                                  Worship
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input id="check_oo" type="checkbox" value="">
                                  Souvenir
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input id="check_k" type="checkbox" value="">
                                  Culinary
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input id="check_h" type="checkbox" value="">
                                  Hotel
                                </label>
                              </div>
                                <div class="checkbox">
                                <label>
                                  <input id="check_res" type="checkbox" value="">
                                  Restaurant
                                </label>
                              </div>

                              <!--RADIUS-->
                              <label for="inputradius">Radius : </label>
                          <label  id="nilaiiiii">0</label> m
                          <script>
                            function cek()
                            {
                              document.getElementById('nilaiiiii').innerHTML=document.getElementById('inputradius').value*100
                            }
                          </script>
                              <input type="range" onchange="cek(); aktifkanRadius()" id="inputradius" name="inputradius" data-highlight="true" min="0" max="15" value="0">

                              <!--BUTTON CARI SEKITAR-->
                              <div id="view_sekitar" class="centered">
                              </div>


                           </div>
                        </div>
                      </div><!-- /col-md-12 -->    
        

<!-- HASIL RUTE -->
        <!-- <div class="col-lg-4 ds"  id="hasilrute" style="display:none;"> -->
          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
          <!-- <h3 style="font-size:16px">Rute</h3> -->
          <div   id="hasilrute" class="col-md-4 col-sm-4 mb"  display:block;>
          <section class="panel"style="height: auto;padding:15px" >
          <a class="btn btn-compose" style="background-color:black;color:white;">Route</a>
              <!-- First Action -->
              <div class="box-body" style="max-height:557px;overflow:auto;">
                <div class="form-group" id="detailrute1" >

                  <table class="table table-bordered" id='detailrute'></table>
                </div>
              </div>         
        </div> 

        <div class="col-lg-4 ds"  id="selectkulll" style="display:none;">
          <!-- <h3 style="font-size:16px">Select Culinary</h3> -->
          <a class="btn btn-compose">Select Souvenir</a>
        <div class="panel box-v3">
                  <ul class="sub">
                        <div id="forml">
                        <input type="text" class="form-control hidden" id="id" name="id" value="<?php echo $id ?>">
                          <div class="form-group row col-xs-9" >
                            <?php
                              $sql2 = mysqli_query($conn,"select * from product_souvenir order by product");
                              while($dt = mysqli_fetch_array($sql2)){
                                  echo "<div class='checkbox'><label style='color:black'><input name='product_souvenir' value=\"$dt[id]\" type='checkbox' style='width:25px'>$dt[product]</label></div>";
                                }
                              
                            ?>


                             <?php
                              $sql2 = mysqli_query($conn,"select * from product_small_industry order by product");
                              while($dt = mysqli_fetch_array($sql2)){
                                  echo "<div class='checkbox'><label style='color:black'><input name='product_small_industry' value=\"$dt[id]\" type='checkbox' style='width:25px'>$dt[product]</label></div>";
                                }
                              
                            ?>
            
                      </div>
                      </div>
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="kul_kec" onclick='viewsouv()'>Search</button>
                        </div>
                      </ul>
                </div> 
                </div>
     
      </section>
    </section>
  
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>    
  	<script src="assets/js/zabuto_calendar.js"></script>	
	
	   <script type="application/javascript">
        $(document).ready(function () 
        {
          $("#date-popover").popover({html: true, trigger: "manual"});
          $("#date-popover").hide();
          $("#date-popover").click(function (e) 
          {
           $(this).hide();
          });
        
          $("#my-calendar").zabuto_calendar
          ({
            action: function () 
            {
              return myDateFunction(this.id, false);
            },
            action_nav: function () 
            {
              return myNavFunction(this.id);
            },
            ajax: 
            {
              url: "show_data.php?action=1",
              modal: true
            },
            legend: 
            [
                    {type: "text", label: "Special event", badge: "00"},
                    {type: "block", label: "Regular event", }
            ]
          });
        });
        
        
        function myNavFunction(id) 
        {
          $("#date-popover").hide();
          var nav = $("#" + id).data("navigation");
          var to = $("#" + id).data("to");
          console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
        }
    </script>
  </body>
</html>
