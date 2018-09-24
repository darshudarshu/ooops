<?php
class UtilityAdd 
{
    //validating string data
    public function stringData()
    {
        $name = readline();

        if (preg_match("/[^A-Z]{1}[a-z]$/", $name) && !(preg_match('/[0-9]/', $name))) {
            return ucfirst($name);
        } else {
            echo "invalid Name , Enter again\n";
            //recursion
            return UtilityAdd::stringData();
        }

    }
    //validating mobilenumber data
    public function moblieNumber()
    {
        $num = readline();
        if (preg_match('/^\d{10}$/', $num)) {

            return $num;
        } else {
            echo "invalid Mobile Number , Enter again\n";
            //recursion
            return UtilityAdd::moblieNumber();
        }

    }
    //validating zipcode data
    public function zipNum()
    {
        $num = readline();
        if (preg_match('/^\d{6}$/', $num)) {
            return $num;
        } else {
            echo "invalid Zip Code , Enter again\n";
            //recursion
            return UtilityAdd::zipNum();
        }

    }
    //validating ineger data
    public function getInt()
    {
        fscanf(STDIN, '%d', $num);
        if (filter_var($num, FILTER_VALIDATE_INT)) {
            return $num;
        } else {
            echo "enter valid number , Enter again \n";
            //recursion
            return UtilityAdd::getInt();
        }
    }
    //validating integer data
    public function getInteger()
    {
        fscanf(STDIN, '%d', $num);
        if (preg_match('/[0-9]/', $num)) {
            return $num;
        } else {
            echo "enter valid number , Enter again \n";
            //recursion
            return UtilityAdd::getInt();
        }
    }
    //dispalying the index'th user 
    public function displaySpecificPerson($index)
    {
        $data = file_get_contents('address.json');
        $json_arr = json_decode($data, true);
        // print_r($json_arr[$index]);
        echo "User First Name : " . $json_arr[$index]["firstName"] . "\n";
        echo "User First Name : " . $json_arr[$index]["lastName"] . "\n";
        echo "User Adress     : \n";
        echo "          State       : " . $json_arr[$index]["address"]["State"] . "\n";
        echo "          City        : " . $json_arr[$index]["address"]["City"] . "\n";
        echo "          Zipcode     : " . $json_arr[$index]["address"]["Zipcode"] . "\n";
        echo "          PhoneNumber : " . $json_arr[$index]["address"]["PhoneNumber"] . "\n";
    }
}