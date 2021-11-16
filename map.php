<?php

// Setting the page and language type
$page = "map";

// Set the engine to catch no errors
set_error_handler(function() { /* ignore errors */ });

// determine the language of the page to display, default
if ($_GET['lang'] == "it" || $_POST['lang'] == "it") {
  $lang = "it";
} else {
  $lang = "en";
}

// Everything should be caught after here
restore_error_handler();

?>

<!DOCTYPE html>
<html>

<!--HEADER:-->
<!--Contains: Leaflet Link Info, Leaflet CSS Tag, Leaflet Script Tag -->

<head>
    <!--FONT LINKS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Playfair+Display:ital@0;1&display=swap"
        rel="stylesheet">

    <!--LEAFLET LINK INFO-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />
    <!--LEAFLET CSS TAG-->
    <style>
        #observatoryMap {
            height: 100%;
            width: 100%;
            border-right: ridge;
        }
    </style>

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>

    <title>OAV</title>

    <!--CSS BULLSHIT-->
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/searchbar.css">
    <style>
        body {
            display: flex;
            margin-top: 7vh;
        }

        .mapPanel {
            display: flex;
            background-color: none;
            width: 100%;
            height: 93vh;
            z-index: 0;
            overflow: none;
        }

        .navPanel {
            position: fixed;
            margin-top: 7vh;
            top: 25px;
            right: 25px;
            display: flex;
            flex-direction: column;
            background-color: white;
            width: 30%;
            min-width: 350px;
            height: 85%;
            border-top: none;
            border-radius: 25px;
        }

        .resultsPanel {
            display: block;
            align-items: center;
            flex-direction: column;
            overflow-y: scroll;
            overflow-x: hidden;
            background-color: none;
            width: 100%;
            height: 100%;
            border-top: solid lightgray 1pt;
            background-color: white;

        }

        .resultsPanelWrapper {
            overflow-y: hidden;
            overflow-x: hidden;
            background-color: none;
            width: 100%;
            height: 90%;
            border-bottom-left-radius: 25px;
            border-bottom-right-radius: 25px;
        }

        .resultBox {
            display: flex;
            flex-direction: column;
            height: fit-content;
            width: 95%;
            border-radius: 20px;
            outline: solid 1pt gray;
            background-color: rgb(233, 233, 233);
            margin-bottom: 15px;
        }

        .resultBox:first-child {
          margin-top: 15px;
        }

        .resultImg {
            align-self: center;
            justify-self: center;
            width: 50%
        }

        .resultTitleLabel {
            display: flex;
            font-size: 20pt;
            height: 25%;
            align-self: center;
            font-weight: bold;
            justify-content: center;
            width: 100%;
            margin-top: 10px;
            border-bottom: solid 1pt gray;
        }

        .resultCatLabelContainer {
            display: flex;
            height: 50px;
            align-self: center;
            width: 95%;
        }

        .resultCatLabel {
            display: flex;
            font-size: 16pt;
            height: 20pt;
            align-self: center;
            font-family: 'Playfair-Display';
            font-weight: normal;
            font-style: italic;
            width: 100%;
            outline: none;
            background-color: inherit;
            overflow: hidden;
        }

        .resultCatIcon {
            width: auto;
            height: 100%;
            align-self: center;
            background-color: inherit;
            filter: saturate(100%);
        }

        .resultDescLabel {
            display: flex;
            min-height: 200px;
            font-size: 12pt;
            height: 50%;
            align-self: left;
            font-weight: normal;
            width: 95%;
            align-self: center;
            margin-top: 10px;
        }

        .resultLinkContainer {
            display: flex;
            align-items: center;
            flex-direction: row;
            height: 50px;
            width: 100%;
            justify-content: space-evenly;
        }

        .resultLink {
            height: 75%;
            display: flex;
            width: 95%;
            font-family: "Playfair-Display";
            font-size: 12pt;
            font-weight: normal;
            font-style: italic;
            justify-content: space-evenly;
            outline: solid 1pt gray;
            user-select: none;
            border-radius: 15px;
            align-items: center;
            text-decoration: none;
            background-color: whitesmoke;
        }

        .resultLinkBroken {
            height: 75%;
            display: flex;
            width: 95%;
            font-family: "Playfair-Display";
            font-size: 12pt;
            font-weight: normal;
            font-style: italic;
            color: gray;
            justify-content: space-evenly;
            outline: solid 1pt gray;
            user-select: none;
            border-radius: 15px;
            align-items: center;
            text-decoration: none;
            background-color: inherit;
        }

        .resultLink:visited {
            color: inherit;
        }

        .resultLink:hover {
            background-color: lightgray;
        }
    </style>

</head>

<!--BODY - Main Site Structure (Visual)-->

<body style="height: 93vh;" onclick="showResult('')">

    <!-- HTML for the page header so that it is placed in the original document
     with the variables changed by php. -->

     <?php include_once 'shared/header.php'; ?>

    <!--Main Two Panels: mapPanel & navPanel-->
    <div class='mapPanel'>
        <div id="observatoryMap"></div>
    </div>

    <div class='navPanel'>
      <div id="searchBarWrapper">
          <!--SEARCH PANEL STRUCTURE-->
          <div id="searchClick">
            <div class='searchBar'>
                <input type='text' id='searchTextField' placeholder="Search by Name or Keyword..."  onkeyup="showResult(this.value)"></input>
                <button id='searchButton' onclick="updateResults('reqType=map')">SEARCH</button>
            </div>
            <div id="livesearch"></div>
          </div>
          <!--DATE PANEL STRUCTURE-->
          <div id='datePanel'>
              <input class='dateField' type='date' id='fromDate'></input>
              <label id='datePanelToLabel'>To</label>
              <input class='dateField' type='date' id='toDate'></input>
          </div>
          <!--CATEGORY PANEL STRUCTURE-->
          <div class='categoryPanel'>
              <div data-state='disabled' class='categoryCheckbox CC_disabled' id='galleries_checkbox' onclick='toggleCheckbox(id)'>Galleries</div>
              <div data-state='disabled' class='categoryCheckbox CC_disabled' id='museums_checkbox' onclick='toggleCheckbox(id)'>Museums</div>
              <div data-state='disabled' class='categoryCheckbox CC_disabled' id='theatres_checkbox' onclick='toggleCheckbox(id)'>Theatres</div>
              <div data-state='disabled' class='categoryCheckbox CC_disabled' id='opera_checkbox' onclick='toggleCheckbox(id)'>Opera Houses</div>
          </div>
        </div>

        <!--RESULTS PANEL STRUCTURE-->
        <div class='resultsPanelWrapper'>
            <div class='resultsPanel' id='resultsDisplayArea' align='center'>
                <!-- PRESENCE OF RESULTS BOXES ARE DETERMINED IN JS SCRIPT TAG BELOW -->
            </div>
        </div>
    </div>

</body>

<!--SCRIPT FOR JS CODE-->
<script src="js\liveSearchFunc.js" charset="utf-8"></script>
<script>
    // XML HTTP CODE
    function getDB(params = 'reqType=map&limit=75') {
        const xhttp = new XMLHttpRequest();
        xhttp.open('POST', 'searchFunc.php', true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.onload = function(){
          if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            var response = xhttp.responseText
            var JSONData = JSON.parse(response)

            //clear markers
            markerGroup.clearLayers();

            //clear results
            var resultsDisp = document.getElementById('resultsDisplayArea');
            resultsDisp.innerHTML = "";

            //code to create results from data
            for (var location of JSONData) {
              // console.log(location);
              if (location['Name_EN'] != '') {
                title = location['Name_EN'];
              } else {
                title = location['Name_IT'];
              }
              createNewResult(location['id'], title, location['Description_EN'], location['Type'], location['Website']);
              createNewMarker(location['id'], title, location['Lat'], location['Lon'], location['Type']);
            }
          } else {
            alert('Request failure.');
          }
        }

        xhttp.send(params);

    }

    //MAP CODE
    var interactiveMap = L.map('observatoryMap').setView([45.44, 12.35], 13);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1Ijoib3NzZXJ2YXRvcmlvZGFydGV2ZW5lemlhIiwiYSI6ImNrdjg1dGx4ZTF3OGwybnA2bmNhcDV0anEifQ.26pkj5a9zna3N4vVLz0J8g'
    }).addTo(interactiveMap);

    //create markerGroup
    var markerGroup = L.layerGroup();
    markerGroup.addTo(interactiveMap);

    // Key event on searchBarWrapper
    var searchBarWrapper = document.getElementById('searchBarWrapper');
    searchBarWrapper.addEventListener("keyup", function(event) {
      if (event.keyCode === 13) {
        // Cancel the default action, if needed
        event.preventDefault();
        // Trigger the button element with a click
        document.getElementById("searchButton").click();
      }
    });

    //ACCESS TOKEN:
    //pk.eyJ1Ijoib3NzZXJ2YXRvcmlvZGFydGV2ZW5lemlhIiwiYSI6ImNrdjg1dGx4ZTF3OGwybnA2bmNhcDV0anEifQ.26pkj5a9zna3N4vVLz0J8g

    //MARKER ICONS
    var icon_galleries = L.icon({
        iconUrl: 'Markers/Marker_Gallery.png',
        shadowUrl: 'Markers/Marker_Shadow.png',
        iconSize: [50, 50],
        shadowSize: [50, 50],
        iconAnchor: [25, 45],
        shadowAnchor: [6, 47],
        popupAnchor: [0, -40]
    });
    var icon_museums = L.icon({
        iconUrl: 'Markers/Marker_Museum.png',
        shadowUrl: 'Markers/Marker_Shadow.png',
        iconSize: [50, 50],
        shadowSize: [50, 50],
        iconAnchor: [25, 45],
        shadowAnchor: [6, 47],
        popupAnchor: [0, -40]
    });
    var icon_opera = L.icon({
        iconUrl: 'Markers/Marker_Opera.png',
        shadowUrl: 'Markers/Marker_Shadow.png',
        iconSize: [50, 50],
        shadowSize: [50, 50],
        iconAnchor: [25, 45],
        shadowAnchor: [6, 47],
        popupAnchor: [0, -40]
    });
    var icon_theatres = L.icon({
        iconUrl: 'Markers/Marker_Theatre.png',
        shadowUrl: 'Markers/Marker_Shadow.png',
        iconSize: [50, 50],
        shadowSize: [50, 50],
        iconAnchor: [25, 45],
        shadowAnchor: [6, 47],
        popupAnchor: [0, -40]
    });
    var icon_dot_size = 12;
    var icon_dot = L.icon({
      iconUrl: "Markers/Marker_Dot.png",
      iconSize: [icon_dot_size, icon_dot_size],
      iconAnchor: [icon_dot_size/2, icon_dot_size/2],
      popupAnchor: [0, 0]
    })
    var icon_unknown = L.icon({
        iconUrl: 'Markers/Marker_Other.png',
        shadowUrl: 'Markers/Marker_Shadow.png',
        iconSize: [50, 50],
        shadowSize: [50, 50],
        iconAnchor: [25, 45],
        shadowAnchor: [6, 47],
        popupAnchor: [0, -40]
    });

    //CREATE NEW MARKER
    function createNewMarker(databaseID, venueName, lat, lng, category) {
        //select icontype
        switch (category) {
          case 'Gallery':
            var iconType = icon_galleries;
            break;
          case 'Museum':
            var iconType = icon_museums;
            break;
          case 'Theatre':
            var iconType = icon_theatres;
            break;
          case 'Opera':
            var iconType = icon_opera;
            break;
          default:
            iconType = icon_dot;
        }

        var marker = L.marker([lat, lng], { icon: iconType });
        marker.addTo(interactiveMap).bindPopup("<b align='center'>" + venueName + "</b>").on('click', function(e) {
          document.getElementById('result_' + databaseID).scrollIntoView();
        });
        markerGroup.addLayer(marker);
        /*
        var def_marker = L.marker([lat, lng]);
        def_marker.addTo(Map).bindPopup("<b align='center'>" + venueName + "</b>");
        */

    }

    //RESULTS CODE
    function createNewResult(databaseID, venueName, descText, category, outLink, inLink=null) {
        // Fix the categories to match the icon names
        switch (category) {
          case 'Museum':
            category = 'Museums';
            break;
          case 'Gallery':
            category = 'Galleries';
            break;
          case 'Theatre':
            category = 'Theatres';
            break;
          case 'Opera':
            category = 'Opera Houses';
            break;
          default:
            category = 'Other';
        }


        //create result box
        var newResult = document.createElement('DIV');
        newResult.className = 'resultBox';
        newResult.id = 'result_' + databaseID;

        //create title label
        var newTitleLabel = document.createElement('LABEL');
        newTitleLabel.textContent = venueName;
        newTitleLabel.className = 'resultTitleLabel';

        //create category label container
        var newCatLabelContainer = document.createElement('DIV');
        newCatLabelContainer.className = 'resultCatLabelContainer';

        //create category label
        var newCatLabel = document.createElement('LABEL');
        newCatLabel.textContent = "(Category: " + category + ") ----------------------------------------";
        newCatLabel.className = 'resultCatLabel';

        //create category icon
        var newCatIcon = document.createElement('IMG');
        newCatIcon.className = 'resultCatIcon';
        newCatIcon.src = ('WebIcons/Checkbox/' + category + '_Checkbox.png');


        //create desc label
        var newDescLabel = document.createElement('LABEL');
        newDescLabel.textContent = descText;
        newDescLabel.className = 'resultDescLabel';

        //create image
        /*
        var newImg = document.createElement('IMG');
        newImg.src = 'WebIcons/Coded/WebIcon_Coded_Other.png';
        newImg.className = 'resultImg';
        */

        //create inner link
        /*
        var newInnerLink = document.createElement('A');
        newInnerLink.textContent = "Link Broken :(";
        newInnerLink.className = 'resultLinkBroken colorClass_' + category;
        if (inLink != null) {
            newInnerLink.href = inLink;
            newInnerLink.textContent = "Learn More on OAV";
            newInnerLink.target = "_blank";
            newInnerLink.className = 'resultLink colorClass_' + category;
        }
        */

        //create outer link
        var newOuterLink = document.createElement('A');
        newOuterLink.textContent = "Link Broken :(";
        newOuterLink.className = 'resultLinkBroken colorClass_' + category;
        if (outLink != null) {
            newOuterLink.href = outLink;
            newOuterLink.textContent = "Visit the Venue's Website";
            newOuterLink.target = "_blank";
            newOuterLink.className = 'resultLink colorClass_' + category;
        }

        //create Link Container
        var newLinkContainer = document.createElement('DIV');
        newLinkContainer.className = 'resultLinkContainer';

        //APPEND RESULT
        //newLinkContainer.appendChild(newInnerLink);
        newLinkContainer.appendChild(newOuterLink);
        newResult.appendChild(newTitleLabel);
        newCatLabelContainer.appendChild(newCatLabel);
        newCatLabelContainer.appendChild(newCatIcon);
        newResult.appendChild(newCatLabelContainer);
        newResult.appendChild(newDescLabel);
        //newResult.appendChild(newImg);
        newResult.appendChild(newLinkContainer);
        document.getElementById('resultsDisplayArea').appendChild(newResult);

        /*
        console.log("CREATED NEW RESULT:");
        console.log("ID: " + databaseID);
        console.log("Venue Name: " + venueName);
        console.log("Description: " + descText);
        console.log("Inner URL: " + inLink);
        console.log("Outer URL: " + outLink);
        */
    }

    // Run an initial request with no restrictions.
    getDB();

</script>

</html>
