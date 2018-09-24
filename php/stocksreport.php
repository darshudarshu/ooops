<?php
include "utility.php";
/*
* @ref : object of the StockReport class
*/
$ref=new StockReport();
/*
* @filename : JSON file name 
*/
$fileName='stock.json';
/*
* calling writeintofile function assigning it to @arrayOfArray array
*/
$arrayOfData = $ref->writeIntoFile($fileName);
/*
* calling stockrep function of stockreport class
*/
$ref->stockRep($arrayOfData);