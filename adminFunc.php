<?php

session_start();

if (!isset($_SESSION['logged_in'])) {

  header('Location: login.php');
  http_response_code(511);
  die;

} elseif (isset($_POST['delete'])) {

  require_once('config.php');

  if ($_POST['delete'] == 'location') {
    // if we are deleting a location, find the location and delete it.
    if ($stmt = $con->prepare('DELETE FROM locationdata WHERE (id = ?);')) {
      $stmt->bind_param('s', $_POST['locationID']);

      $stmt->execute();

      $stmt->close();

      header('Location: manageData.php?dataSubmitted=1');
      die;
    } else {
      header('Location: manageData.php?dataSubmitted=0');
      http_response_code(400);
      die;
    }
  } elseif ($_POST['delete'] == 'event') {
    // if we are deleting a event, find the event and delete it.
    if ($stmt = $con->prepare('DELETE FROM eventdata WHERE (id = ?);')) {
      $stmt->bind_param('s', $_POST['eventID']);

      $stmt->execute();

      $stmt->close();

      header('Location: manageData.php?dataSubmitted=1');
      die;
    } else {
      header('Location: manageData.php?dataSubmitted=0');
      http_response_code(400);
      die;
    }
  } else {
    // IF DELETE WAS TRUE, BUT NO VALID TABLE, QUIT
    header('Location: manageData.php?dataSubmitted=0');
    http_response_code(400);
    die;
  }

} elseif (isset($_POST['update']) && isset($_POST['id'])) {

  require_once('config.php');

  if ($_POST['update'] == 'location') {
    // IF THE UPDATE EVENT IS FOR THE LOCATION TABLE
    if ($stmt = $con->prepare('UPDATE locationdata
                               SET evenice_id=?, name_IT=?, name_EN=?,
                                   description_IT=?, description_EN=?,
                                   organization_IT=?, organization_EN=?,
                                   address=?, lat=?, lon=?, type=?,
                                   evenice_type=?, website=?
                               WHERE id=?;')) {

      // Setting defaults
      $e_id = (isset($_POST['evenice_id'])) ? $_POST['evenice_id'] : '' ;
      $name_IT = (isset($_POST['name_IT'])) ? $_POST['name_IT'] : '' ;
      $name_EN = (isset($_POST['name_EN'])) ? $_POST['name_EN'] : '' ;
      $description_IT = (isset($_POST['description_IT'])) ? $_POST['description_IT'] : '' ;
      $description_EN = (isset($_POST['description_EN'])) ? $_POST['description_EN'] : '' ;
      $organization_IT = (isset($_POST['organization_IT'])) ? $_POST['organization_IT'] : '' ;
      $organization_EN = (isset($_POST['organization_EN'])) ? $_POST['organization_EN'] : '' ;
      $address = (isset($_POST['address'])) ? $_POST['address'] : 'Venice' ;
      $lat = (isset($_POST['lat'])) ? $_POST['lat'] : '' ;
      $lon = (isset($_POST['lon'])) ? $_POST['lon'] : '' ;
      $type = (isset($_POST['type'])) ? $_POST['type'] : 'Other' ;
      $e_type = (isset($_POST['evenice_type'])) ? $_POST['evenice_type'] : 'Other' ;
      $website = (isset($_POST['website'])) ? $_POST['website'] : 'Other' ;

      $stmt->bind_param('ssssssssssssss', $e_id, $name_IT, $name_EN,
                                         $description_IT, $description_EN,
                                         $organization_IT, $organization_EN,
                                         $address, $lat, $lon, $type, $e_type,
                                         $website, $_POST['id']);

      $stmt->execute();

      $stmt->close();

      header('Location: manageData.php?dataSubmitted=1');
      die;

    } else {

      header('Location: manageData.php?dataSubmitted=0');
      http_response_code(400);
      die;

    }
  } elseif ($_POST['update'] == 'event') {
    // IF THE UPDATE EVENT IS FOR THE EVENT TABLE
    if ($stmt = $con->prepare('UPDATE eventdata
                               SET evenice_id=?, evenice_location_id=?,
                                   event_name=?, location_name=?,
                                   event_description=?, start_date=?,
                                   start_time=?, end_date=?, end_time=?
                               WHERE id=?;')) {

      // Setting defaults
      $e_id = (isset($_POST['evenice_id'])) ? $_POST['evenice_id'] : '' ;
      $e_loc_id = (isset($_POST['evenice_location_id'])) ? $_POST['evenice_location_id'] : '' ;
      $event_name = (isset($_POST['event_name'])) ? $_POST['event_name'] : '' ;
      $loc_name = (isset($_POST['location_name'])) ? $_POST['location_name'] : '' ;
      $e_description = (isset($_POST['event_description'])) ? $_POST['event_description'] : '' ;
      $start_date = (isset($_POST['start_date'])) ? $_POST['start_date'] : '' ;
      $start_time = (isset($_POST['start_time'])) ? $_POST['start_time'] : '' ;
      $end_date = (isset($_POST['end_date'])) ? $_POST['end_date'] : '' ;
      $end_time = (isset($_POST['end_time'])) ? $_POST['end_time'] : '' ;



      $stmt->bind_param('ssssssssss', $e_id, $e_loc_id, $event_name,
                                     $loc_name, $e_description,
                                     $start_date, $start_time,
                                     $end_date, $end_time, $_POST['id']);

      $stmt->execute();

      $stmt->close();

      header('Location: manageData.php?dataSubmitted=1');
      die;

    } else {

      header('Location: manageData.php?dataSubmitted=0');
      http_response_code(400);
      die;

    }
  }  else {
    // IF UPDATE WAS TRUE, BUT NO VALID TABLE, QUIT
    header('Location: manageData.php?dataSubmitted=0');
    http_response_code(400);
    die;
  }

} elseif (isset($_POST['new'])) {

  require_once('config.php');

  if ($_POST['new'] == 'location') {
    // IF THE UPDATE EVENT IS FOR THE LOCATION TABLE
    if ($stmt = $con->prepare('INSERT INTO locationdata (evenice_id, name_IT, name_EN, description_IT, description_EN, organization_IT, organization_EN, address, lat, lon, type, evenice_type, website)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);')) {

      // Setting defaults
      $e_id = (isset($_POST['evenice_id'])) ? $_POST['evenice_id'] : '' ;
      $name_IT = (isset($_POST['name_IT'])) ? $_POST['name_IT'] : '' ;
      $name_EN = (isset($_POST['name_EN'])) ? $_POST['name_EN'] : '' ;
      $description_IT = (isset($_POST['description_IT'])) ? $_POST['description_IT'] : '' ;
      $description_EN = (isset($_POST['description_EN'])) ? $_POST['description_EN'] : '' ;
      $organization_IT = (isset($_POST['organization_IT'])) ? $_POST['organization_IT'] : '' ;
      $organization_EN = (isset($_POST['organization_EN'])) ? $_POST['organization_EN'] : '' ;
      $address = (isset($_POST['address'])) ? $_POST['address'] : 'Venice' ;
      $lat = (isset($_POST['lat'])) ? $_POST['lat'] : '' ;
      $lon = (isset($_POST['lon'])) ? $_POST['lon'] : '' ;
      $type = (isset($_POST['type'])) ? $_POST['type'] : 'Other' ;
      $e_type = (isset($_POST['evenice_type'])) ? $_POST['evenice_type'] : 'Other' ;
      $website = (isset($_POST['website'])) ? $_POST['website'] : 'Other' ;

      $stmt->bind_param('sssssssssssss', $e_id, $name_IT, $name_EN,
                                         $description_IT, $description_EN,
                                         $organization_IT, $organization_EN,
                                         $address, $lat, $lon, $type, $e_type,
                                         $website);

      $stmt->execute();

      $stmt->close();

      header('Location: manageData.php?dataSubmitted=1');
      die;

    } else {

      header('Location: manageData.php?dataSubmitted=0');
      http_response_code(400);
      die;

    }
  } elseif ($_POST['new'] == 'event') {
    // IF THE UPDATE EVENT IS FOR THE EVENT TABLE
    if ($stmt = $con->prepare('INSERT INTO eventdata (evenice_id, evenice_location_id, event_name, location_name, event_description, start_date, start_time, end_date, end_time)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);')) {

      // Setting defaults
      $e_id = (isset($_POST['evenice_id'])) ? $_POST['evenice_id'] : '' ;
      $e_loc_id = (isset($_POST['evenice_location_id'])) ? $_POST['evenice_location_id'] : '' ;
      $event_name = (isset($_POST['event_name'])) ? $_POST['event_name'] : '' ;
      $loc_name = (isset($_POST['location_name'])) ? $_POST['location_name'] : '' ;
      $e_description = (isset($_POST['event_description'])) ? $_POST['event_description'] : '' ;
      $start_date = (isset($_POST['start_date'])) ? $_POST['start_date'] : '' ;
      $start_time = (isset($_POST['start_time'])) ? $_POST['start_time'] : '' ;
      $end_date = (isset($_POST['end_date'])) ? $_POST['end_date'] : '' ;
      $end_time = (isset($_POST['end_time'])) ? $_POST['end_time'] : '' ;



      $stmt->bind_param('sssssssss', $e_id, $e_loc_id, $event_name,
                                     $loc_name, $e_description,
                                     $start_date, $start_time,
                                     $end_date, $end_time);

      $stmt->execute();

      $stmt->close();

      header('Location: manageData.php?dataSubmitted=1');
      die;

    } else {

      header('Location: manageData.php?dataSubmitted=0');
      http_response_code(400);
      die;

    }
  }  else {
    // IF NEW WAS TRUE, BUT NO VALID TABLE, QUIT
    header('Location: manageData.php?dataSubmitted=0');
    http_response_code(400);
    die;
  }



?>
