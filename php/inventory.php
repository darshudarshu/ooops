<?php
include "utility.php";
/**
 * @ref : object of the InvrntoryManagement class
 */
$ref =new InvrntoryManagement("stock.json");
/**
 *using ref calling function of the InvrntoryManagement class
 */
$ref->inventory();