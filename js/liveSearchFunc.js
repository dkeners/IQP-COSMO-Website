document.getElementById('searchClick').click(function(e) { //button click class name is myDiv
 e.stopPropagation();
})

// refactor this shit its disgusting
function showResult(str) {
  if (str.length==0) {
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  var xhttp=new XMLHttpRequest();
  xhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch").innerHTML = this.responseText;
      document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
    }
  }
  xhttp.open('POST', 'searchFunc.php', true);
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  params = "reqType=live&limit=10&title=" + str;
  xhttp.send(params);
}

// Set the searchbar text to be the clicked text and submit.
function selectSuggestion(e) {
  console.log(e.innerHTML);
  document.getElementById('searchTextField').value = e.innerHTML;
  document.getElementById("livesearch").innerHTML="";
  document.getElementById("livesearch").style.border="0px";
  // Immediatly update the newest
  document.getElementById("searchButton").click();
  return;
}

//UPDATE RESULTS PANEL ---------------------------------------------------------------------------!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
function updateResults(params) {
    //GET / define filter parameters
    var searchString = document.getElementById('searchTextField').value;
    var venues = document.getElementById('venues_checkbox').getAttribute('data-state') == 'enabled';
    var events = document.getElementById('events_checkbox').getAttribute('data-state') == 'enabled';
    var startDate = document.getElementById('fromDate').value;
    var endDate = document.getElementById('toDate').value;
    var includeGalleries = document.getElementById('galleries_checkbox').getAttribute('data-state') == 'enabled';
    var includeMuseums = document.getElementById('museums_checkbox').getAttribute('data-state') == 'enabled';
    var includeTheatres = document.getElementById('theatres_checkbox').getAttribute('data-state') == 'enabled';
    var includeOperaHouses = document.getElementById('opera_checkbox').getAttribute('data-state') == 'enabled';


    // SETTING PARAMETERS FOR THE SEARCHFUNC FILE
    // Some of these act as 'pre-sanitized' though some get sanitized later

    // Set table to search from:
    if (venues) {
      params += '&table=location';
    } else if (events) {
      params += '&table=event'
    }

    if (searchString != '') {
      params += '&keyword=' + searchString;
    }

    // Dates only needed for events
    if (startDate != '') {
      params += '&start=' + startDate;
    }
    if (endDate != '') {
      params += '&end=' + endDate;
    }

    // // Check which types are needed
    // if (includeGalleries) {
    //   params += '&Gallery=1';
    // }
    // if (includeMuseums) {
    //   params += '&Museum=1';
    // }
    // if (includeTheatres) {
    //   params += '&Theatre=1';
    // }
    // if (includeOperaHouses) {
    //   params += '&Opera=1';
    // }

    // code to get data from server via parameters
    getDB(params);
}

//CLEAR FILTERS
function clearFilters() {
    disableCheckbox('galleries_checkbox');
    disableCheckbox('theatres_checkbox');
    disableCheckbox('museums_checkbox');
    disableCheckbox('opera_checkbox');
    document.getElementById('searchTextField').value = "";
}

//HELPER - DISABLE CHECKBOX
function disableCheckbox(checkboxID) {
    if (document.getElementById(checkboxID).getAttribute('data-state') == 'enabled') {
        toggleCheckbox(checkboxID);
    }
}

//TOGGLE CUSTOM CHECKBOX
function toggleCheckbox(checkboxID, recursive=false) {
    var targetCheckbox = document.getElementById(checkboxID);
    var startState = targetCheckbox.getAttribute('data-state');

    if (startState == 'enabled') {
        //TOGGLE TO DISABLED STATE
        targetCheckbox.setAttribute('data-state', 'disabled');
        targetCheckbox.setAttribute('class', 'categoryCheckbox CC_disabled');
    } else {
        //TOGGLE TO ENABLED STATE
        targetCheckbox.setAttribute('data-state', 'enabled');
        targetCheckbox.setAttribute('class', 'categoryCheckbox CC_'+checkboxID);
    }

    if (!recursive) {
      // Toggle extra options visibility for venue and events (Venue starts on)
      if (checkboxID == 'venues_checkbox') {
        document.getElementById('eventsOptions').classList.toggle('hidden');
        document.getElementById('venueOptions').classList.toggle('hidden');
        toggleCheckbox('events_checkbox', true)
      } else if (checkboxID == 'events_checkbox') {
        document.getElementById('eventsOptions').classList.toggle('hidden');
        document.getElementById('venueOptions').classList.toggle('hidden');
        toggleCheckbox('venues_checkbox', true)
      }

      // Immediatly update the results as long as not the more/less options box
      if (checkboxID != 'options_checkbox') {
        document.getElementById("searchButton").click();
      }
    }
}

// Function to display the extra sorting options
function toggleOptions(elem) {
  if (elem.innerHTML == "More Options") {
    elem.innerHTML = "Less Options";
    document.getElementById('expandableSearchBar').classList.remove("hidden");
  } else {
    elem.innerHTML = "More Options";
    document.getElementById('expandableSearchBar').classList.add("hidden");
  }
}
