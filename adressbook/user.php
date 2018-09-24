<?php
include "utilityadress.php";
include "addressbook.php";
/**
 * creating the class references and storing in reference variables
 */
$utilityref = new UtilityAdd();
$addadressref = new AddAdress();
$editadressref = new EditAdress();
$deleteaddresref = new DeleteAddress();
$sortaddresref = new Sort();
$openaddressbookref = new OpenBook();
/*
* ****************** user interface *********************
*/
echo "*_*_*_*_*_*_*_*_FOLLOW BELOW INSTRUCTION_*_*_*_*_*_*_*_*_ \n";
do {
    echo "------------------------------------\n";
    echo "ENTER 1 :   To add address \n";
    echo "ENTER 2 :   To edit address \n";
    echo "ENTER 3 :   To delete the adress \n";
    echo "ENTER 4 :   To sort the adressbook \n";
    echo "ENTER 5 ;   To view the adressbook \n";
    echo "-----------------------------------\n";
    //@get :integer descids user choice
    $get = $utilityref->getInt();
    switch ($get) {
        case 1:echo "ENTER the no of address you want to add to AddressBook\n";
            $noOfAddress = $utilityref->getInt();
            for ($i = 0; $i < $noOfAddress; $i++) {
                $addadressref->addAddress($utilityref);
            }
            break;
        case 2:$editadressref->editTheAdress();
            break;
        case 3:$deleteaddresref->removeAddres();
            break;
        case 4:$sortaddresref->chooseSort($openaddressbookref);
            break;
        case 5:$openaddressbookref->phoneBookDisplay();
            break;
        default:echo "invalid entry \n";
            break;
    }
    echo "---------------------------------\n";
    echo "ENTER 1  :   Continue... \n";
    echo "ENTER 2  :   Exit from phonebook \n";
    echo "---------------------------------\n";
    $continue = $utilityref->getInt();
    //looping
} while ($continue == 1);
