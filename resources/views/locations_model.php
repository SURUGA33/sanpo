<?php
require("db.php");

// Gets data from URL parameters.
if(isset($_REQUEST['address'])) {
    add_location();
}
if(isset($_REQUEST['user_status'])) {
    update_location();
}

function add_location(){

    $con=mysqli_connect ("localhost", 'root', '','test');
    mysqli_set_charset($con,"utf8");

    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    $lat = $_REQUEST['latitude'];
    $lng = $_REQUEST['longitude'];
    $store_name = $_REQUEST['store_name'];
    $address = $_REQUEST['address'];
    // Inserts new row with place data.
    $sql = "INSERT INTO locations (latitude,longitude,address,store_name) VALUES ($lat,$lng,'$address','$store_name')";
    session_start();
    if ($con->query($sql) === TRUE) {
         $_SESSION['message'] = "New record created successfully";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['message'] = "Error:$con->error";
        header("Location: ". $_SERVER['HTTP_REFERER']);
    }

    $con->close();
}
function update_location(){

    $con=mysqli_connect ("localhost", 'root', '','test');
    mysqli_set_charset($con,"utf8");

    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    $id = $_REQUEST['id'];
    $user_status = $_REQUEST['user_status'];
    // Inserts new row with place data.
    $sql = "UPDATE locations set user_status = $user_status WHERE  id = $id";
    if ($con->query($sql) === TRUE) {
        echo json_encode(true);
    } else {
        echo json_encode($user_status);
    }

    $con->close();
}
function get_saved_locations(){
    $con=mysqli_connect ("localhost", 'root', '','test');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($con,"select latitude, longitude from locations ");

    $rows = array();
    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }
    $indexed = array_map('array_values', $rows);

    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}
function get_all_locations(){
    $con=mysqli_connect ("localhost", 'root', '','test');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($con,"select id ,latitude,longitude,address,user_status from locations ");

    $rows = array();
    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }
    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}
function get_all_users(){
    $con=mysqli_connect ("localhost", 'root', '','test');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($con,"select store_name,latitude,longitude from locations ");

    while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC))
    {
        echo "<option data-lng=". $row['longitude'] ." data-lat=". $row['latitude'] .">" . $row['username'] . "</option>";
    }

}

?>