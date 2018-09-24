<?php
 /***********************************************************************************
 * @description : program that can be used to maintain an address book. An address book
 * holds a collection of entries, each recording a person's first and last names, address, 
 * city, state, zip, and phone number.
 * @firstname : string var to hold first name of the user 
 * @lastname  : string var to holf last name of the user
 * @adress : array to hold the @state , @city , @Zipcode and @phonenumber of the user
 *************************************************************************************/
class AddressBook
{
    public $firstName;
    public $lastName;
/**
 * Class constructor to create the user address object
 * initializing all the values of the user 
 */
    public function __construct($firstName, $lastName, $state, $city, $zipCode, $phoneNumber)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        //key value pair array
        $this->address = array("State" => $state, "City" => $city,
            "Zipcode" => $zipCode,
            "PhoneNumber" => $phoneNumber);

    }
}
/**
 * Class to add the address to the JSON file
 * @addressbookref :  to hold the reference of the Addressbook class 
 */
class AddAdress extends UtilityAdd
{
/**
 * function to get the details from the user
 * @check : integer which decides to save the data to file or not
 */
    public function addAddress()
    {
        echo "ENTER the User First Name \n";
        //calling validating string function present in the Utility class
        $firstName = UtilityAdd::stringData();
        echo "ENTER the User Last Name \n";
       //calling validating string function present in the Utility class
        $lastName = UtilityAdd::stringData();
        echo "ENTER the User State \n";
         //calling validating string function present in the Utility class
        $state = UtilityAdd::stringData();
        echo "ENTER the User City \n";
         //calling validating string function present in the Utility class
        $city = UtilityAdd::stringData();
        echo "ENTER the User Zip Code \n";
         //calling validating zipcode function present in the Utility class
        $zipCode = UtilityAdd::zipNum();
        echo "ENTER the User Phone Number \n";
         //calling validating mobilenumber function present in the Utility class
        $phoneNumber = UtilityAdd::moblieNumber();
        //creating the reference to Addressbook
        $addressbookref = new AddressBook($firstName, $lastName, $state, $city, $zipCode, $phoneNumber);
        echo "ENTER 1 : To save adress to JSON \n";
        $check = UtilityAdd::getInt();
        if ($check == 1) {
            //calling the addtojsonfile function by passing the reference
            AddAdress::addToJsonFile($addressbookref);
        } else {
            echo "Addres is not saved \n";
        }
    }
/**
 * function to add data to json
 * @data : array of json data
 * @json_arr [] : new array to store ref
 */
    public function addToJsonFile($addressbookref)
    {
        $data = file_get_contents('address.json');
        $json_arr = json_decode($data, true);
        $json_arr[] = $addressbookref;
        file_put_contents('address.json', json_encode($json_arr));
    }

}
/**
 * class to edit the user adddres
 * @index : integer (editing happens in this index)
 */
class EditAdress extends UtilityAdd
{
    public $index = null;
/**
 * function to choose and edit the address of user
 */
    public function editTheAdress()
    {
        if (EditAdress::searchAddress()) {
            $this->displaySpecificPerson($this->index);
            do {
                echo "---------------------------------\n";
                echo "ENTER 1 : To edit State \n";
                echo "ENTER 2 : To edit city \n";
                echo "ENTER 3 : To edit ZipCode \n";
                echo "ENTER 4 : To edit moblinumber \n";
                echo "---------------------------------\n";
                $get = UtilityAdd::getInt();
                switch ($get) {
                    case 1:
                        EditAdress::changeState();
                        break;
                    case 2:
                        EditAdress::changeCity();
                        break;
                    case 3:
                        EditAdress::changeZipcode();
                        break;
                    case 4:
                        EditAdress::changePhonenumber();
                        break;
                    default:echo "invalid entry \n";
                        EditAdress::editTheAdress();
                        break;
                }
                echo "EDITED SUCCESSFULLY............\n";
                echo "-------------------------------\n";
                echo "ENTER 1 : Edit further \n";
                echo "ENTER 2 : Exit from edit operation \n";
                echo "-------------------------------\n";
                //looping operation
                $continue = EditAdress::getInt();
            } while ($continue == 1);

        } else {
            echo "No such name address is found \n";
            //recursion utill we get valid input
            $this->editTheAdress();
        }
    }
/**
 * function to change the state of the user at the index th postion
 */
    public function changeState()
    {
        echo "ENTER new State \n";
        $name = UtilityAdd::stringData();
        $data = file_get_contents('address.json');
        $json_arr = json_decode($data, true);
        $json_arr[$this->index]["address"]["State"] = $name;
        file_put_contents('address.json', json_encode($json_arr));
    }
/**
 * function to change the city of the user at the index th postion
 */
    public function changeCity()
    {
        echo "ENTER new City \n";
        $name = UtilityAdd::stringData();
        $data = file_get_contents('address.json');
        $json_arr = json_decode($data, true);
        $json_arr[$this->index]["address"]["City"] = $name;
        file_put_contents('address.json', json_encode($json_arr));

    }
/**
 * function to change the zipcode of the user at the index th postion
 */
    public function changeZipcode()
    {
        echo "ENTER new Zipcode \n";
        $num = UtilityAdd::zipNum();
        $data = file_get_contents('address.json');
        $json_arr = json_decode($data, true);
        $json_arr[$this->index]["address"]["Zipcode"] = $num;
        file_put_contents('address.json', json_encode($json_arr));
    }
/**
 * function to change the mobilenumber of the user at the index th postion
 */
    public function changePhonenumber()
    {
        echo "ENTER new Phone Number \n";
        $num = UtilityAdd::moblieNumber();
        $data = file_get_contents('address.json');
        $json_arr = json_decode($data, true);
        $json_arr[$this->index]["address"]["PhoneNumber"] = $num;
        file_put_contents('address.json', json_encode($json_arr));
    }
/**
 * function to find the given user name in the address book
 */
    public function searchAddress()
    {
        echo "ENTER the First name of user to change his/her address \n";
        $name = UtilityAdd::stringData();
        $data = file_get_contents('address.json');
        $json_arr = json_decode($data, true);
        $flag = 0;
        echo "*****************_-SEARCH RESULTS-_*******************\n";
        for ($i = 0; $i < count($json_arr); $i++) {
            //checking at  each index
            if ($json_arr[$i]["firstName"] == $name) {
                echo "ENTER : " . $i . " to EDIT this adress \n";
                //displaying the users that are found
                $this->displaySpecificPerson($i);
                $flag++;
            }
        }
        if ($flag == 1) {
            //case if we found only one user
            $this->index = UtilityAdd::getInteger();
            return true;
        } else if ($flag > 1) {
            //case if we found more than 1 user
            echo "OOPS.....................................................\n";
            echo "There are " . $flag . " results found CHOOSE your address \n";
            $this->index = UtilityAdd::getInteger();
            return true;
        } else {
            //no user found
            return false;
        }

    }
/**
 * function to display adress of the person at the index'th position
 * @data : array of data present in the json file
 */
    public function displaySpecificPerson($index)
    {
        //getting contents from the json file
        $data = file_get_contents('address.json');
        $json_arr = json_decode($data, true);
        echo "*********************************************************************\n";
        echo "User First Name : " . $json_arr[$index]["firstName"] . "\n";
        echo "User Last Name : " . $json_arr[$index]["lastName"] . "\n";
        echo "User Adress     : \n";
        echo "          State       : " . $json_arr[$index]["address"]["State"] . "\n";
        echo "          City        : " . $json_arr[$index]["address"]["City"] . "\n";
        echo "          Zipcode     : " . $json_arr[$index]["address"]["Zipcode"] . "\n";
        echo "          PhoneNumber : " . $json_arr[$index]["address"]["PhoneNumber"] . "\n";
        echo "*********************************************************************\n";
        echo "\n";
    }
}
/**
 * class to delete the index'th address
 * @data : array of data present in the json file
 */
class DeleteAddress extends UtilityAdd
{
    public $index = null;
    public function removeAddres()
    {
        do { 
            //check wheather the given name present in the address book
            if (DeleteAddress::searchAddressToDelete()) {
                $json = array();
                //delete operation
                $data = file_get_contents('address.json');
                $json_arr = json_decode($data, true);
                for ($i = 0; $i < count($json_arr); $i++) {
                    if ($i != $this->index) {
                        $json[] = $json_arr[$i];
                    }
                }
                //uploading to jason file
                file_put_contents('address.json', json_encode($json));
                echo "DELETED SUCCESSFULLY............\n";
            } else {
                echo "No such name address is found \n";
                //recursion
                $this->removeAddres();
            }
            echo "---------------------------------\n";
            echo "ENTER  1 : Delete further \n";
            echo "ENTER  2 : Exit from delete operation \n";
            echo "---------------------------------\n";
            $continue = UtilityAdd::getInt();
            //looping 
        } while ($continue == 1);
    }
/**
 * function to find the given user name in the address book
 */
    public function searchAddressToDelete()
    {
        echo "enter the First name of user to change his/her address \n";
        $name = UtilityAdd::stringData();
        $data = file_get_contents('address.json');
        $json_arr = json_decode($data, true);
        $flag = 0;
        for ($i = 0; $i < count($json_arr); $i++) {
            //checking at each index
            if ($json_arr[$i]["firstName"] == $name) {
                echo "ENTER " . $i . " to delete this adress \n";
                //displaying the users that are found
                $this->displaySpecificPerson($i);
                $flag++;
            }
        }
        if ($flag == 1) {
             //case if we found only one user
            $this->index = UtilityAdd::getInteger();
            return true;
        } else if ($flag > 1) {
            //case if we found more than 1 user
            echo "OOPS.....................................................\n";
            echo "There are " . $flag . " results found CHOOSE your address \n";
            $this->index = UtilityAdd::getInteger();
            return true;
        } else {
            //no user found
            return false;
        }

    }
/**
 * function to display adress of the person at the index'th position
 * @data : array of data present in the json file
 */
    public function displaySpecificPerson($index)
    {
        //getting contents from the json file
        $data = file_get_contents('address.json');
        $json_arr = json_decode($data, true);
        echo "*********************************************************************\n";
        echo "User First Name : " . $json_arr[$index]["firstName"] . "\n";
        echo "User Last Name : " . $json_arr[$index]["lastName"] . "\n";
        echo "User Adress     : \n";
        echo "          State       : " . $json_arr[$index]["address"]["State"] . "\n";
        echo "          City        : " . $json_arr[$index]["address"]["City"] . "\n";
        echo "          Zipcode     : " . $json_arr[$index]["address"]["Zipcode"] . "\n";
        echo "          PhoneNumber : " . $json_arr[$index]["address"]["PhoneNumber"] . "\n";
        echo "*********************************************************************\n";
        echo "\n";
    }
}
/**
 * class to sort the user data according to user convinence
 */
class Sort extends UtilityAdd
{
    public function chooseSort($openaddressbookref)
    {
        echo "------------------------------------\n";
        echo "ENTER 1 : To sort based on first name \n";
        echo "ENTER 2 : To sort based on last name \n";
        echo "ENTER 3 : To sort based on Zipcode \n";
        echo "------------------------------------\n";
        //choosing sort
        $local = sort::getInteger();
        switch ($local) {
            case 1:
                $this->firstNameSort();
                break;
            case 2:
                $this->lastNameSort();
                break;
            case 3:
                $this->zipCodeSort();
                break;
            default:echo "invalid entry , enter again\n";
                $this->chooseSort();
                break;
        }
        echo "-----------------------------------\n";
        echo "ENTER 1 : To view sorted phonebook \n";
        echo "ENTER 2 : To main mebu \n";
        echo "-----------------------------------\n";
        $temp = sort::getInteger();
        if ($temp == 1) {
            //to view sorted results
            echo "_____________________________--SORTED RESULTS--____________________________\n";
            $openaddressbookref->phoneBookDisplay();
        }

    }
/**
 * function to sort by lastname
 * bubble sort concept
 */
    public function lastNameSort()
    {
        $data = file_get_contents('address.json');
        $json_arr = json_decode($data, true);
        for ($i = 0; $i < count($json_arr) - 1; $i++) {
            for ($j = $i + 1; $j < count($json_arr); $j++) {
                if ($json_arr[$i]["lastName"] > $json_arr[$j]["lastName"]) {
                    //calling the swap function
                    Sort::swap($i, $j);
                }
            }
        }
    }
/**
 * function to sort by zipcode
 * bubble sort concept
 */
    public function zipCodeSort()
    {
        $data = file_get_contents('address.json');
        $json_arr = json_decode($data, true);
        for ($i = 0; $i < count($json_arr) - 1; $i++) {
            for ($j = $i + 1; $j < count($json_arr); $j++) {
                if ($json_arr[$i]["address"]["Zipcode"] > $json_arr[$j]["address"]["Zipcode"]) {
                    //calling the swap function
                    Sort::swap($i, $j);
                }
            }
        }
    }
/**
 * function to sort by firstname
 * bubble sort concept
 */
    public function firstNameSort()
    {
        $data = file_get_contents('address.json');
        $json_arr = json_decode($data, true);
        for ($i = 0; $i < count($json_arr) - 1; $i++) {
            for ($j = $i + 1; $j < count($json_arr); $j++) {
                if ($json_arr[$i]["firstName"] > $json_arr[$j]["firstName"]) {
                    //calling the swap function
                    Sort::swap($i, $j);
                }
            }
        }
    }
/**
 * function to swap by given indxes
 * @temp : for temparory storage
 */
    public function swap($a, $b)
    {
        $data = file_get_contents('address.json');
        $json_arr = json_decode($data, true);
        $temp = array();
        $temp = $json_arr[$a];
        $json_arr[$a] = $json_arr[$b];
        $json_arr[$b] = $temp;
        file_put_contents('address.json', json_encode($json_arr));
    }
}
/**
 * class used for opening the phoneBook
 */
class OpenBook
{
    public function phoneBookDisplay()
    {
        $data = file_get_contents('address.json');
        $json_arr = json_decode($data, true);
        for ($i = 0; $i < count($json_arr); $i++) {
            //displaying each user here
            OpenBook::displaySpecificPerson($i);
            echo "\n";
        }
    }
/**
 * function to display adress of the person at the index'th position
 * @data : array of data present in the json file
 */
    public function displaySpecificPerson($index)
    {
        //getting contents from the json file
        $data = file_get_contents('address.json');
        $json_arr = json_decode($data, true);
        echo "*********************************************************************\n";
        echo "User First Name : " . $json_arr[$index]["firstName"] . "\n";
        echo "User Last Name : " . $json_arr[$index]["lastName"] . "\n";
        echo "User Adress     : \n";
        echo "          State       : " . $json_arr[$index]["address"]["State"] . "\n";
        echo "          City        : " . $json_arr[$index]["address"]["City"] . "\n";
        echo "          Zipcode     : " . $json_arr[$index]["address"]["Zipcode"] . "\n";
        echo "          PhoneNumber : " . $json_arr[$index]["address"]["PhoneNumber"] . "\n";
        echo "*********************************************************************\n";
        echo "\n";
    }
}
