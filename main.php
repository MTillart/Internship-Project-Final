<?php
require_once 'db/conf.php';


$dblink = new mysqli($server, $user, $password, $dbname);
if ($dblink->connect_errno) {
    printf("Failed to connect to database. Blaah 22");
    exit();
}

$sql = '';
$forFromWhere = filter_input(INPUT_POST, 'fromWhere');
$forToWhere = filter_input(INPUT_POST, 'toWhere');
$dbTime = filter_input(INPUT_POST, 'dbTime');
$forDuration = filter_input(INPUT_POST, 'duration');

//$forTimeDiff = round($forTimeDiff,2);

if (empty($forToWhere )){
    $forToWhere = "self";
}

if(isset($dbTime)){
    $sql = "INSERT INTO tracking (FromWhere, ToWhere, TheTime, Duration)
VALUES ('$forFromWhere', '$forToWhere', '$dbTime', '$forDuration')";
    if ($dblink->query($sql) === isset($sql) ) {

    } else {
        echo "The data was not sent to database";
    }

    $dblink->close();

}else{
};

?>
