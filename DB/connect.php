
<?php

/* 
URL structure:   
    postgres://username:password@hostname/databasename

elephant URL:
    Personal:
        postgres://rdhrwzeu:repIExoUMPQIJp-oBioH9fHYJ8gRpIgK@tai.db.elephantsql.com/rdhrwzeu 
    Group:
        postgres://dzfajhvp:a4j_fqNcY4YmK4ZgDyl4EC8_hWbJY9wt@tai.db.elephantsql.com/dzfajhvp 
*/

    $host = "tai.db.elephantsql.com";
    $user = "rdhrwzeu";
    $pass = "repIExoUMPQIJp-oBioH9fHYJ8gRpIgK";
    $db = "rdhrwzeu";
 
    // Open a PostgreSQL connection
    $con = pg_connect("host=$host dbname=$db user=$user password=$pass")
    or die ("Could not connect to server\n");


    // Closing connection
    //pg_close($con); 

?>