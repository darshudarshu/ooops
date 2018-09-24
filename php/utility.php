<?php
 /**************************************************** 
 * @description : program to read data from the json file
 *  @arr : read the data from the file
 *******************************************************/
class Utility
{
    public function ReadFromJSONFile($data)
    {
        $arr = json_decode($data);

        $priceRice = $arr->rice->price * $arr->rice->weight;
        $pricePulses = $arr->Pulses->price * $arr->Pulses->weight;
        $priceWheats = $arr->Wheats->price * $arr->Wheats->weight;
        echo "Inventory \n";
        echo "product name   :" . $arr->rice->name . "\n";
        echo "Total quantity :" . $arr->rice->weight . "\n";
        echo "Price /kg      :" . $arr->rice->price . "\n";
        echo "Total cost     :" . $priceRice . "\n\n";

        echo "product name   :" . $arr->Pulses->name . "\n";
        echo "Total quantity :" . $arr->Pulses->weight . "\n";
        echo "Price /kg      :" . $arr->Pulses->price . "\n";
        echo "Total cost     :" . $pricePulses . "\n\n";

        echo "product name   :" . $arr->Wheats->name . "\n";
        echo "Total quantity :" . $arr->Wheats->weight . "\n";
        echo "Price /kg      :" . $arr->Wheats->price . "\n";
        echo "Total cost     :" . $priceWheats . "\n\n";

    }
}
 /*************************************************************************************** 
 * @description : Use Regex to the firstname ,lastname,moblino and date of user and replace those in the given message
 * @massage :Hello <<name>>, We have your fullname as <<full name>> in our system. your contact number is 91-xxxxxxxxxx.
 * Please,let us know in case of any clarification Thank you BridgeLabz 01/01/2016.
 ***************************************************************************************/
class Regex
{

    private $firstName;
    private $lastName;
    private $mobileNo;
    private $date;
/**
 * Class constructor to take input from user
 */
    public function __construct()
    {
        Regex::moblieNumber();
        Regex::dateFormate();
        Regex::nameFormateFirst();
        Regex::nameFormateLast();

    }
/**
 * Function to set the user firstname
 */
    public function setfName($firstName)
    {
        $this->firstName = $firstName;
    }
/**
 * Function to set the user lastname
 */
    public function setlName($lastName)
    {
        $this->lastName = $lastName;
    }
/**
 * Function to set the user mobilenumber
 */
    public function setmobileNo($mobileNo)
    {
        $this->mobileNo = $mobileNo;
    }
/**
 * Function to set the user input date
 */
    public function setdate($date)
    {
        $this->date = $date;
    }
/**
 * Function to get the user firstname
 */
    public function getfName()
    {
        return $this->firstName;
    }
/**
 * Function to get the user lastname
 */
    public function getlName()
    {
        return $this->lastName;
    }
/**
 * Function to get the user mobilenumber
 */
    public function mobileNo()
    {
        return $this->mobileNo;
    }
/**
 * Function to get the user date
 */
    public function date()
    {
        return $this->date;
    }
/**
 * Function to validate moblinumber
 * @num : to read data from user
 * recursion happens if in put is invalid
 */
    public function moblieNumber()
    {
        echo "enter the moblile number \n";
        $num = readline();
        if (preg_match('/^\d{10}$/', $num)) {
            Regex::setmobileNo($num);
            return 0;
        } else {
            echo "invalid mobile number \n";
            return Regex::moblieNumber();
        }

    }
/**
 * Function to validate date
 * @date : to read int from user
 * recursion happens if in put is invalid
 */
    public function dateFormate()
    {
        echo "enter the date \n";
        $date = readline();
        if (Regex::isDate($date)) {
            Regex::setdate($date);
            return 0;
        } else {
            echo "invalid date \n";
            return Regex::dateFormate();
        }

    }
/**
 * Function to validate date formate
 * @matches :array to store day, month and year in array index
 * @chechdate : validate the month,day and year present in the matches array 
 */
    function isDate($string) {
        $matches = array();
        $pattern = '/^([0-9]{1,2})\\/([0-9]{1,2})\\/([0-9]{4})$/';
        if (!preg_match($pattern, $string, $matches)) return false;
        if (!checkdate($matches[2], $matches[1], $matches[3])) return false;
        return true;
    }
/**
 * Function to validate the name
 * @name : read the string from the user
 * recursion happens if in put is invalid
 */
    public function nameFormateFirst()
    {
        echo "enter the first name \n";
        $name = readline();

        if (preg_match("/[^A-Z]{1}[a-z]$/", $name) && !(preg_match('/[0-9]/', $name))) {
            Regex::setfName(ucfirst($name));
            return 0;
        } else {
            echo "invalid  name \n";
            return Regex::nameFormateFirst();
        }

    }
/**
 * Function to validate name
 * @name : read the string from the user
 * recursion happens if in put is invalid
 */
    public function nameFormateLast()
    {
        echo "enter the last name \n";
        $name = readline();

        if (preg_match("/[^A-Z]{1}[a-z]$/", $name) && !(preg_match('/[0-9]/', $name))){
            Regex::setlName(ucfirst($name));
            return 0;
        } else {
            echo "invalid name \n";
            return Regex::nameFormateLast();
        }

    }
/**
 * Function to replace the massage with the given inputs
 * @replaceArray :array to hold which data to be replaced
 * @replaceByArray :array with which data(user choice) we should replace
 * @str_replace : to replace all 1st arg present in 3 arg by 2nd arg
 */
    public function regEx()
    {
        $message = "Hello <<name>>, We have your full name as <<full name>> in our system. your contact number is 91-xxxxxxxxxx.
         Please,let us know in case of any clarification Thank you BridgeLabz xx/xx/xxxx. \n";

        $mobliNum = Regex::mobileNo();
        $date = Regex::date();
        $firstname = Regex::getfName();
        $lastname = Regex::getlName();
        $replaceArray = array("<<name>>", "<<full name>>", "xx/xx/xxxx", "xxxxxxxxxx");
        $replaceByArray = array($firstname, $firstname . " " . $lastname, $date, $mobliNum);
        return str_replace($replaceArray, $replaceByArray, $message);
    }
}
/*************************************************************************************** 
 * @description : program to read in Stock Names, Number of Share, Share Price.
 * Print a Stock Report with total value of each Stock
 * @JSON file : Stocks.json
 * @stcoreport :class to act as stock reporter
 ***************************************************************************************/
class StockReport
{
    public $stockname ;
    public $stockshares ;
    public $Stockprice ;
/**
 * constructor of the class
 * initialize the all data with delfult values
 */
    public function __construct()
    {
        $this->stockname=null;
        $this->stockshares = 0;
        $this->Stockprice = 0;
    }
/**
 * function to validate the string data
 * @name : to take data from user
 * recursion happens if input is invalid 
 */
    public function getString()
    {
        $name = readline();
        if (preg_match('/[0-9]/', $name)) {
            echo "enter valid string  \n";
            return $this->getString();
        } else {
            return $name;
        }
    }
/**
 * function to validate the integer data
 * @name : to take data from user
 * recursion happens if input is invalid 
 */
    public function getInt()
    {
        fscanf(STDIN, '%d', $num);
        if (filter_var($num, FILTER_VALIDATE_INT)) {
            return $num;
        } else {
            echo "enter valid integer  \n";
            return $this->getInt();
        }
    }
/**
 * function to validate the double data
 * @name : to take data from user
 * recursion happens if input is invalid 
 */
    public function getDouble()
    {
        fscanf(STDIN, '%f', $num);
        if (filter_var($num, FILTER_VALIDATE_FLOAT)) {
            return $num;
        } else {
            echo "enter valid double value  \n";
            return $this->getDouble();
        }
    }
/**
 * function to write into json file (file name is paased to method while calling)
 * @noOfStocks : no of stocks to be added
 * @url : to hold the file name
 * @arrayOfData :array to store the data to the file
 * method returns Array of data (report)
 */
    public function writeIntoFile($fileName)
    {
        echo "enter the no of stocks \n";
        $noOfStocks = $this->getInt();

        $url = $fileName;
        $content = file_get_contents($url);
        $arrayOfData = json_decode($content, true);
        for ($i = 0; $i < $noOfStocks; $i++) {
            //@th : to display each persons
            $th = $i + 1;
            echo "Enter the " . $th . "th stock name \n";
            $stockName = $this->getString();

            echo "enter the no of shares of " . $th . "th stock \n";
            $stockShares = $this->getInt();

            echo "enter the share price of each share of " . $th . "th stock \n";
            $sharePrice = $this->getDouble();
            //@totalvalue : to store the totalvalue of each stock
            $totalValue = $stockShares * $sharePrice;

            $arrayOfData[$i]['stockName'] = $stockName;
            $arrayOfData[$i]['stockShares'] = $stockShares;
            $arrayOfData[$i]['sharePrice'] = $sharePrice;
            $arrayOfData[$i]['totalValue'] = $totalValue;
        }
        return $arrayOfData;
    }
/**
 * function to print the Stock report in terminal
 * @jsondata : get data from the file 
 */
    public function stockRep($arrayOfdata)
    {
        $jsonData = json_encode($arrayOfdata);
        //loading contents to the file and displaying in terminal
        file_put_contents('stock.json', $jsonData);
        echo "\n***********************stock report********************************\n";
        foreach ($arrayOfdata as $key => $value) {
            echo "stock name               :" . $value['stockName'] . "\n";
            echo "No of stock shares       :" . $value['stockShares'] . "\n";
            echo "value of each shares is  :" . $value['sharePrice'] . "\n";
            //calling the calculate funtion 
            $total=new Calculate($value['stockShares'], $value['sharePrice']);
            //calling a claculate class function using that class reference 
            echo "The total stock value is :" . $total->getToatalValue() . "\n";
         echo "\n*********************************************************************\n";
        }
       
    }
    
}
/**
 * @discription : class to calculate the totalvalue of each stock
*/
class Calculate
{
    public $totalvalue = 0;
 /**
 * function for calculation
*/   
    public function __construct($stockshares,$Stockprice)
    {
        $this->totalvalue=$stockshares * $Stockprice;
    }
/**
 * function to return the totalvalue calculated 
*/
    public function getToatalValue()
    {
        return $this->totalvalue;
    }
}
/*************************************************************************************** 
 * @description : InventoryManager to manage the Inventory.use InventoryFactory to create 
 * Inventory Object from JSON
 * @JSON file : Stocks.json
 * @arr : Store the data from the JSON file
 ***************************************************************************************/
class InvrntoryManagement
{
    public $totalprice;
    public $file;
/**
 * constructor to create the Inventorymanagement object having Total value of all stock
*/
    public function __construct($file)
    {
        $this->totalprice=0;
        $this->file=$file;
    }
/**
 * function for calculatuing totalvalue of all stocks
*/
    public function inventory()
    {
        $data = file_get_contents($this->file);
        $arr = json_decode($data ,true);
        foreach ($arr as $key => $value) {
            echo "stock name               :" . $value['stockName'] . "\n";
            echo "No of stock shares       :" . $value['stockShares'] . "\n";
            echo "value of each shares is  :" . $value['sharePrice'] . "\n";
            echo "The total stock value is :" . $value['totalValue'] . "\n";
            //caluculating the totalvale of all stock
            $this->totalprice=$this->totalprice + $value['totalValue'];
            echo "\n";
        }
        echo "total price of inventory is : " . $this->totalprice . "\n";
    }
}