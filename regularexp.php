<?php
include "utility.php";
/*
* @print : storing the reference of the class Regex  
*/
$print = new Regex();
/*
* @result : to store the result (got from the regex function )
*/
$result =$print->regEx();
echo $result . "\n";