<?php

include("DB/connect.php"); 

$problem = $_POST['problem'];
$cost = $_POST['cost'];
$mender = $_POST['mender'];
$description = $_POST['description'];
$sensor = $_POST['sensor'];


/* Fetch the specific automatic_monitoring_id of the selected Sensor */
$query = "  SELECT DISTINCT ON (sensor) automatic_monitoring_id  FROM measurements
            INNER JOIN automatic_monitoring
            ON automatic_monitoring.measurements_log_id = measurements.measurements_log_id
            WHERE sensor = '" . $sensor . "'
            ORDER BY  sensor, automatic_monitoring.time_stamp DESC";

$result = pg_query($con, $query) or die('Query failed: ' . pg_last_error());   
$arr_automatic_monitoring_id = pg_fetch_array($result);
$automatic_monitoring_id = $arr_automatic_monitoring_id['automatic_monitoring_id'];



/* Inserts entry on automatic_maintenance */ //TODO CHANGE 15
$query = "INSERT INTO automatic_maintenance(problem,cost,time_stamp,mender,description,automatic_monitoring_id)
            VALUES ('" . $problem . "','" . $cost . "',CURRENT_TIMESTAMP,'" . $mender . "','" . $description . "','" . $automatic_monitoring_id . "')";

$result = pg_query($con, $query) or die('Query failed: ' . pg_last_error());    

/*Updates monitoring, so it knows the selected sensor its solved, this impacts 2 things:
    1. No longed displays as Risk in the monitoring interface
    2. No longer displays as an option in maintenance interface
*/
$query = "  UPDATE automatic_monitoring
            SET solved = true
            WHERE automatic_monitoring_id = '" . $automatic_monitoring_id . "'";

$result = pg_query($con, $query) or die('Query failed: ' . pg_last_error());  


/* Future Work:
    1. Requesting a new read from the sensor to make sure it's working properly
*/

header("Location: monitoring.php"); /* Redirect browser */
  exit();

?>

