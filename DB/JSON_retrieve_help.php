<?php

// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json);


$json = '{
	"title": "PHP",
	"site": "GeeksforGeeks"
}';

$data = json_decode($json);

echo $data->title;
echo "\n";

echo $data->site;
?>


<!-- https://www.geeksforgeeks.org/how-to-receive-json-post-with-php/ -->