<?php

    $query = 'SELECT * FROM sensors';
    $results = pg_query($con, $query) or die('Query failed: ' . pg_last_error());

    $array = pg_fetch_all($results);
    print_r($array);


//preciso de sensor e risk e deve chegar
//atenção para ver se algum deles tem mais que 

/* SELECT DISTINCT ON (sensor) * from measurements
INNER JOIN automatic_monitoring
ON automatic_monitoring.measurements_log_id = measurements.measurements_log_id
WHERE solved = false
ORDER BY  sensor, automatic_monitoring.time_stamp DESC */

?>


