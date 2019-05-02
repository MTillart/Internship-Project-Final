<?php
/*
*This file is for adminpanel, where command is sent to PHP.
*PHP then fetches the required data from the database and sends it to webpage.
*/
include('../db/conf.php');

//JSON decoding for data sent by JS for PHP to understand
$data = json_decode(file_get_contents("php://input"),true);
$command = $data['command'];

$method = $_SERVER['REQUEST_METHOD'];

$request = explode('/', trim($_SERVER['REQUEST_URI'],'/'));

// check if database is connected
if($dblink === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
//Show all the results
if ($command == 'all'){
    $sql = "select * from tracking";
    $result = mysqli_query($dblink,$sql);
    $dbdata = array();

    while ( $row = $result->fetch_assoc())  {
        $dbdata[]=$row;
    }

    echo json_encode($dbdata);
}// Show specific id related query
elseif (is_numeric($command)){
    $sql = "select * from tracking".($command?" where id=$command":'');
    $result = mysqli_query($dblink,$sql);
    $dbdata = array();

    while ( $row = $result->fetch_assoc())  {
        $dbdata[]=$row;
    }
    echo json_encode($dbdata);
} // Order data by duration (declining)
elseif ($command == 'desc') {
    $sql = "select * from tracking ORDER BY duration desc";
    $result = mysqli_query($dblink, $sql);
    $dbdata = array();

    while ($row = $result->fetch_assoc()) {
        $dbdata[] = $row;
    }
    echo json_encode($dbdata);
} //Order data by earliest
elseif ($command == 'earliest') {
    $sql = "select * from tracking ORDER BY id desc";
    $result = mysqli_query($dblink, $sql);
    $dbdata = array();

    while ($row = $result->fetch_assoc()) {
        $dbdata[] = $row;
    }
    echo json_encode($dbdata);
} // Show data where FromWhere = contact.php
elseif ($command == 'contact') {
    $sql = "select * from tracking WHERE FromWhere ='contact.php'";
    $result = mysqli_query($dblink, $sql);
    $dbdata = array();

    while ($row = $result->fetch_assoc()) {
        $dbdata[] = $row;
    }
    echo json_encode($dbdata);
}else{
    http_response_code(404);
    die(mysqli_error($dblink));

}

?>
