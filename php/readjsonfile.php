<?php
include "utility.php";
/*
*@data : to store the data present in the json file
*/
$data = file_get_contents("file.json");
/*
* @print : object of the Utility class
*/
$print = new Utility();
/*
* using reference calling a function by passing data present in the json file
*/
$print->ReadFromJSONFile($data);
