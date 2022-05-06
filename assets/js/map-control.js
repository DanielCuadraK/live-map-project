var mediaFolderRoot = "assets/img/";

//Sets starting size for icons
var iconSizeCrane = {
    width: 48,
    height: 48
};

var iconSizeShip = {
    width: 48,
    height: 48
};

//Sets label text in case the project requires future localization in another language
var labels = {
    tabName1: "Vessel",
    tabName2: "Voyage",
    tabName3: "Port info",
    tabName4: "Schedule"
}

var voyageLabels = {
    labelDestination: "Current Destination",    
    labelNavStatus: "Nav Status",
    labelSog: "Speed",
    labelCog: "Course",
    labelEta: "ETA",
    marker: ""
}

//Sets initial parameters for the ports
var progresoPort = {
    name : "Progreso", 
    lat : 21.28546,  
    lon : -89.64744,
    documentationCutOff : "Wednesday 1700",
    containerCutOff : "Thursday 1700",
    image: "images/tampico-port.jpg",
    marker: "",
    sailingSchedule: ""
}; 

var tampicoPort = {
    name : "Tampico", 
    lat : 22.61226, 
    lon : -97.858626,
    documentationCutOff : "Wednesday 1700",
    containerCutOff : "Thursday 1700",
    image: "images/tampico-port.jpg",
    marker: "",
    sailingSchedule: ""
};

var tuxpanPort = {
    name : "Tuxpan", 
    
    lat : 20.954466, //old [20.954466,-97.339811]
    lon : -97.379811, //new [20.954466,-97.359811]
    documentationCutOff : "Thursday 1700",
    containerCutOff : "Friday 1700",
    image: "images/tuxpan-port.jpg",
    marker: "",
    sailingSchedule: ""
};

var coatzacoalcosPort = {
    name : "Coatzacoalcos", 
    lat : 18.134433,  // old [18.134433,-94.415989])
    lon : -94.5, // new [18.134433,-94.46])
    documentationCutOff : "Thursday 1700",
    containerCutOff : "Friday 1700",
    image: "images/coatzacoalcos-port.jpg",
    marker: "",
    sailingSchedule: ""
};

var floridaPort = {
    name : "Port Manatee", 
    lat : 27.633809, //old [27.633809,-82.557278]
    lon : -82.527278, //new [27.633809,-82.527278]
    documentationCutOff : "Monday 1700",
    containerCutOff : "Tuesday 1200",
    image: "images/port-manatee.jpg",
    marker: "",
    sailingSchedule: ""
}; 

//Function that initializes a new Vessel Object
function Vessel(attr) {
    this.imo = attr.imo;
    this.mmsi =  attr.mmsi;
    this.name = attr.name;
    this.length = "";
    this.breadth = "";
    this.grossTonnage = "";
    this.deadweight = "";
    this.yearBuilt = "";
    this.cranesInstalled = "";
    this.sog = parseInt(attr.sog);
    this.cog = parseInt(attr.cog);
    this.eta = attr.eta;
    this.lat = parseFloat(attr.lat);
    this.lon = parseFloat(attr.lon);
    this.navStatus = attr.navStatus;
    this.currentDestination = attr.destination;
    this.dateUpdated = attr.recordDate;
    this.image= "images/queenb_2018lg.jpg",
    this.marker= attr.marker;
    this.route= "",
    this.routeColor= attr.routeColor;
    this.mediaFolder = mediaFolderRoot + attr.mediaFolder;
    this.icon = "marker-yellow-01.png",
    this.displacement = attr.displacement;
  }

 var vessels = [];

//Custom options for leaflet map
var customOptions =     {
    'className' : 'leaflet-custom-popup'
    };

//Function that sets the ship icon to use based on the speed, longitude and course defined as business rules
function setShipMarkerOrientation(vesselObject){
    if (vesselObject.sog < 0.5){
        if (vesselObject.lon < -86.00) {
            shipIcon.options.iconUrl = "assets/icons/ship0.png";
            return shipIcon;
        }
        else {
            shipIcon.options.iconUrl = "assets/icons/ship270.png"; 
            return shipIcon;
        }
    }   
    else {
    if ((vesselObject.cog > 0) && (vesselObject.cog <= 90)) {
        shipIcon.options.iconUrl = "assets/icons/ship90.png"; 
        return shipIcon;
    }
    else if ((vesselObject.cog > 90) && (vesselObject.cog <= 180)) {
        shipIcon.options.iconUrl = "assets/icons/ship180.png";    
        return shipIcon;
    }
    else if ((vesselObject.cog > 180) && (vesselObject.cog <= 270)) {
        shipIcon.options.iconUrl = "assets/icons/ship270.png"; 
        return shipIcon;
    }
    else if ((vesselObject.cog > 270) && (vesselObject.cog <= 359) || (vesselObject.cog == 0)) {
        shipIcon.options.iconUrl = "assets/icons/ship0.png";   
        return shipIcon;
    }
    }
    
}

//Function that draws all the points for the traveled route by the vessel
function drawRoute(vesselObject) {
    $.ajax({
        data: {"mmsi" : vesselObject.mmsi, "action" : "route"},
        type: "POST",
        dataType: "json",
        url: "scripts/getData.php",
    })
     .done(function( data, textStatus, jqXHR ) {
        var jsondata2 = data;
        var viajeRecorrido = [];
        jsondata2.forEach(asignarPuntos);
        //creates a new poligon to draw the route
        vesselObject.route = new L.Polyline(viajeRecorrido, {
            color: vesselObject.routeColor,
            weight: 2,
            opacity: 1,
            smoothFactor: 1
        });
         vesselObject.route.addTo(mymap);
//Function that draws each point using lat and lon obtained
        function asignarPuntos(value){
            var pointLat = parseFloat(value.lat);
            var pointLon = parseFloat(value.lon) + vesselObject.displacement;
            //Verifies that the point to be drawn and the current location of the vessel is not the same to avoid drawing a marker on top of the vessel icon
            if (Math.abs(Math.abs(vesselObject.lat) - Math.abs(pointLat))>=0.0001 || Math.abs(Math.abs(vesselObject.lon) - Math.abs(pointLon))>= 0.0001){
             L.marker([pointLat, pointLon], {
                icon: L.icon({
                    iconUrl: vesselObject.mediaFolder+"/marker.png",
                
                    iconSize:     [16, 16], // size of the icon
                    shadowSize:   [50, 64], // size of the shadow
                    iconAnchor:   [8, 8], // point of the icon which will correspond to marker's location
                    shadowAnchor: [4, 62],  // the same for the shadow
                    popupAnchor:  [0, 0], // point from which the popup should open relative to the iconAnchor
                    className: 'claseIcono'
                }),
                rotationAngle: value.cog
             }).bindPopup('<span style=font-weight:bold>' + value.name + "</span> | " +value.recordDate + " | " + value.sog + " kn").addTo(mymap);}
             viajeRecorrido.push(new L.LatLng(pointLat, pointLon));
             vesselObject.displacement = 0;
            
        }
     })
     .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "The request has failed: " +  textStatus);
        }
   });
}

//Function used to draw a popup containg port information
function drawPortPopup(portObject) {
    var htmlContent = "";
    var isPortManatee = false;
    if(portObject.name == 'Port Manatee')
        var isPortManatee = true;
    htmlContent = '<div class="container sc">'    
    +'              <div class="row">'
    +'                  <div class="col-md-12 text-center">'
    +'                      <h4>'+ portObject.name +' Itinerary</h4>'
    +'                  </div>'
    +'              </div>'
    +'              <div class="row">'
    +'<div class="col-md-12 text-center" style="padding-top:5px;"><a class="btn btn-primary btn-sm" style="color:white;" href="resources/SailingSchedule.pdf" role="button">Download Schedule</a></div>';
    return htmlContent;
}

//Function to draw a popup for each vessel containing its information
function drawVesselPopup(vesselObject) {
    return " <span style=font-weight:bold>" + vesselObject.name + "</span> | Dest: " + vesselObject.destination + " | " + vesselObject.recordDate + " | " + vesselObject.sog + " kn | ETA: " + vesselObject.eta;
}

// Detects the userAgrent, if the user is using a mobile device the map has disabled draging and tapping.
var pc = true;


if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    pc = false;
  }

if (pc) {
var mymap = L.map('map-container', {scrollWheelZoom: false, zoomControl: false, dragging: pc, tap: pc}).fitBounds([
    [28.940612, -102.766113],
    [16.106485, -75.805664]
]);
}
else {
    var mymap = L.map('map-container', {scrollWheelZoom: false, zoomControl: false, dragging: pc, tap: pc}).fitBounds([
        [34.161494, -107.050781],
        [-6.539476, -76.816406]
    ]);    
}

const mapEl = document.querySelector("#map-container");

// Binds event listeners for the map and calls the function
mapEl.addEventListener("touchstart", onTwoFingerDrag);
mapEl.addEventListener("touchend", onTwoFingerDrag);

//Define two fingers behavior on mobile
function onTwoFingerDrag (e) {
  if (e.type === 'touchstart' && e.touches.length === 1) {
    e.currentTarget.classList.add('swiping')
  } else {
    e.currentTarget.classList.remove('swiping')
  }
}

//Define the map layer origin and initial values
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 10,
    minZoom: 4,
}).addTo(mymap);

L.control.zoom({
    position: 'topright'
}).addTo(mymap);

var popup = L.popup();

//Scalates vessel icons according to current zoom level
iconSizeShip.width = mymap.getZoom() * 8;
iconSizeShip.height = mymap.getZoom() * 8;

//Define icon values
var shipIcon = L.icon({
    iconUrl: 'assets/icons/ship90.png',
    iconSize:     [iconSizeShip.width, iconSizeShip.height], // size of the icon
    shadowSize:   [50, 64], // size of the shadow
    iconAnchor:   [iconSizeShip.width/2, iconSizeShip.height/2], // point of the icon which will correspond to marker's location
    shadowAnchor: [4, 62],  // the same for the shadow
    popupAnchor:  [0, 0], // point from which the popup should open relative to the iconAnchor
    className: 'claseIcono'
});

var portIcon = L.icon({
    iconUrl: 'assets/icons/crane.png',
    iconSize:     [iconSizeCrane.width, iconSizeCrane.height], // size of the icon
    shadowSize:   [iconSizeCrane.width, iconSizeCrane.height], // size of the shadow
    iconAnchor:   [iconSizeCrane.width/2, iconSizeCrane.height/2], // point of the icon which will correspond to marker's location
    shadowAnchor: [4, 62],  // the same for the shadow
    popupAnchor:  [0, 0], // point from which the popup should open relative to the iconAnchor
    className: 'claseIcono'
});

var portIcon2 = L.icon({
    iconUrl: 'assets/icons/crane-02.png',
    iconSize:     [iconSizeCrane.width, iconSizeCrane.height], // size of the icon
    shadowSize:   [iconSizeCrane.width, iconSizeCrane.height], // size of the shadow
    iconAnchor:   [iconSizeCrane.width/2, iconSizeCrane.height/2], // point of the icon which will correspond to marker's location
    shadowAnchor: [4, 62],  // the same for the shadow
    popupAnchor:  [0, 0], // point from which the popup should open relative to the iconAnchor
    className: 'claseIcono'
});

var portIcon3 = L.icon({
    iconUrl: 'assets/icons/crane-03.png',
    iconSize:     [iconSizeCrane.width, iconSizeCrane.height], // size of the icon
    shadowSize:   [iconSizeCrane.width, iconSizeCrane.height], // size of the shadow
    iconAnchor:   [iconSizeCrane.width/2, iconSizeCrane.height/2], // point of the icon which will correspond to marker's location
    shadowAnchor: [4, 62],  // the same for the shadow
    popupAnchor:  [0, 0], // point from which the popup should open relative to the iconAnchor
    className: 'claseIcono'
});

var portIcon4 = L.icon({
    iconUrl: 'assets/icons/crane-03.png',
    iconSize:     [iconSizeCrane.width, iconSizeCrane.height], // size of the icon
    shadowSize:   [iconSizeCrane.width, iconSizeCrane.height], // size of the shadow
    iconAnchor:   [iconSizeCrane.width/2, iconSizeCrane.height/2], // point of the icon which will correspond to marker's location
    shadowAnchor: [4, 62],  // the same for the shadow
    popupAnchor:  [0, 0], // point from which the popup should open relative to the iconAnchor
    className: 'claseIcono'
});

//Function that sets the correct orientation for the vessels
function setShipMarkerOrientation2(item){
    item.marker.setIcon(setShipMarkerOrientation(item));
}

//Function that is triggered after zooming on the map that resizes and places the icons accordingly
mymap.on('zoomend', function() {

    var zoomLevel = mymap.getZoom();
    iconSizeShip.width = 8 * zoomLevel;
    iconSizeShip.height = 8 * zoomLevel;
    iconSizeCrane.width = 8 * zoomLevel;
    iconSizeCrane.height = 8 * zoomLevel;
    shipIcon.options.iconSize = [iconSizeShip.width, iconSizeShip.height];
    shipIcon.options.iconAnchor = [iconSizeShip.width/2, iconSizeShip.height/2];
    portIcon.options.iconSize = [iconSizeCrane.width, iconSizeCrane.height];
    portIcon.options.iconAnchor = [iconSizeCrane.width/2, iconSizeCrane.height/2];
    portIcon2.options.iconSize = [iconSizeCrane.width, iconSizeCrane.height];
    portIcon2.options.iconAnchor = [iconSizeCrane.width/2, iconSizeCrane.height/2];      
    portIcon3.options.iconSize = [iconSizeCrane.width, iconSizeCrane.height];
    portIcon3.options.iconAnchor = [iconSizeCrane.width/2, iconSizeCrane.height/2];
    portIcon4.options.iconSize = [iconSizeCrane.width, iconSizeCrane.height];
    portIcon4.options.iconAnchor = [iconSizeCrane.width/2, iconSizeCrane.height/2];   
    tampicoPort.marker.setIcon(tampicoPort.marker.getIcon());  
    coatzacoalcosPort.marker.setIcon(coatzacoalcosPort.marker.getIcon()); 
    tuxpanPort.marker.setIcon(tuxpanPort.marker.getIcon());   
    floridaPort.marker.setIcon(floridaPort.marker.getIcon());
    vessels.forEach(setShipMarkerOrientation2);
    switch(zoomLevel) {
        case 7:
            tampicoPort.marker.setLatLng([tampicoPort.lat-.22,tampicoPort.lon]);
        break;
        case 6:
            tampicoPort.marker.setLatLng([tampicoPort.lat,tampicoPort.lon]);
        break;
        default:
            tampicoPort.marker.setLatLng([22.31226,tampicoPort.lon]);
        break;
    }

});


//Draws the location of each Vessel on the map
$.ajax({
    data: {"action" : "location"},
    type: "POST",
    dataType: "json",
    url: "scripts/getData.php",
})
 .done(function( data, textStatus, jqXHR ) {
     if ( console && console.log ) {
        var jsondata = data;
        jsondata.forEach(asignarValores);

        //Sets values to vessels objects and adds it to the vessel object array
        function asignarValores (value) {
            var currentVessel = null;
            var markerVessel = L.marker([value.lat, value.lon], {
                icon: setShipMarkerOrientation(value), 
                draggable: false
                            }).addTo(mymap);
                markerVessel.bindPopup(drawVesselPopup(value));
                value.marker = markerVessel;
                vessels.push(new Vessel(value));
                drawRoute(vessels[vessels.length - 1]);
        }
        //Creates all the ports
        progresoPort.marker= L.marker([progresoPort.lat,progresoPort.lon],{icon: portIcon3, zIndexOffset:1000}).addTo(mymap);
        tampicoPort.marker= L.marker([tampicoPort.lat,tampicoPort.lon],{icon: portIcon3, zIndexOffset:1000}).addTo(mymap);
        tuxpanPort.marker = L.marker([tuxpanPort.lat,tuxpanPort.lon],{icon: portIcon3,zIndexOffset:1000}).addTo(mymap);
        coatzacoalcosPort.marker = L.marker([coatzacoalcosPort.lat,coatzacoalcosPort.lon],{icon: portIcon4,zIndexOffset:1000}).addTo(mymap);
        floridaPort.marker= L.marker([floridaPort.lat,floridaPort.lon],{icon: portIcon2,zIndexOffset:1000}).addTo(mymap);
        }
 })
 .fail(function( jqXHR, textStatus, errorThrown ) {
     if ( console && console.log ) {
         console.log( "The request has failed: " +  textStatus);
     }
});


