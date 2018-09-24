package main

//*******************************************************************************
//@discription : Commercial data processing (stockaccount implimentation)
//@buy() :buy a stock shares
//@sell() : sell a stock shares
//@printreport : view the user or stock reports
//*******************************************************************************
import (
	"encoding/json"
	"fmt"
	"io/ioutil"
	"os"
)

type user struct {
	//->name   ->datatype ->json keyname
	Username    string `json:"username"`
	Userbalance int    `json:"userbalance"`
	Usershares  int    `json:"usershares"`
}
type Stocks struct {
	//->name   ->datatype ->json keyname
	Stockname   string `json:"stockname"`
	Stockshares int    `json:"stockshares"`
	Stockprice  int    `json:"Stockprice"`
}

func main() {
	//creating the user
	fmt.Println("enter the user name")
	var username string
	fmt.Scanf("%s", &username)
	fmt.Println("enter the initial balance")
	var userbalance int
	fmt.Scanf("%d", &userbalance)
	fmt.Println("enter the intitial shares")
	var usershares int
	fmt.Scanf("%d", &usershares)
	data := []user{
		{
			Username:    username,
			Userbalance: userbalance,
			Usershares:  usershares,
		},
	}
	//saving to user jason file
	SaveToUser(data)

	fmt.Println(" ENTER 0 : To Create a Stock ")
	fmt.Println(" ENTER 1 : To Buy a Stock ")
	fmt.Println(" ENTER 2 : To Sell a Stock ")
	fmt.Println(" ENTER 3 : To Print Report")
	fmt.Println(" ENTER 4 : Exit")
	var ch int
	//@ch : to take user choice
	fmt.Scanf("%d", &ch)
	switch ch {
	case 0:
		StocksAccount()
		break
	case 1:
		Buy()
		break
	case 2:
		Sell()
		break
	case 3:
		PrintReport()
		break
	case 4:
		fmt.Println("EXIT")
		break

	}
}

//creating the user choice stocks
//@stockarry :struct type stocks
//@stockname : type string
//@stockshares : type int
//@stockprice : type int

func StocksAccount() {

	fmt.Println("ENTER the no of stocks you want to create")
	var noOfStocks int
	fmt.Scanf("%d", &noOfStocks)
	for i := 0; i < noOfStocks; i++ {
		fmt.Println("ENTER the stock name")
		var stocksname string
		fmt.Scanf("%s", &stocksname)
		fmt.Println("ENTER the stock shares")
		var stockshare, stockprice int
		fmt.Scanf("%d", &stockshare)
		fmt.Println("ENTER the stock price")
		fmt.Scanf("%d", &stockprice)
		var stockarray []Stocks
		//getting data from the json
		stockarray = GetArrayStocks()
		//appending new stocks to existing  stock
		stockarray = append(stockarray, Stocks{Stockname: stocksname, Stockshares: stockshare, Stockprice: stockprice})
		//adding to json by marshaling array data
		result, err := json.Marshal(stockarray)
		if err != nil {
			fmt.Println(err)
		}
		err = ioutil.WriteFile("stocks.json", result, 0644)

	}
}

//function to buy stockshares
//@userarray :struct type user

func Buy() {

	fmt.Println("ENTER the stock name from you want to buy shares ")
	var stockname string
	fmt.Scanf("%s", &stockname)
	var stockarray []Stocks
	stockarray = GetArrayStocks()
	var userarray []user
	userarray = GetArrayUser()
	check := 0
	for i := 0; i < len(stockarray); i++ {
		//check the stocks name present or not
		if stockarray[i].Stockname == stockname {
			fmt.Println("*****The Stock Name and It's Details*******")
			fmt.Printf("Stockname   : %s\n", stockarray[i].Stockname)
			fmt.Printf("stockshare  : %d\n", stockarray[i].Stockshares)
			fmt.Printf("stockprice  : %d\n", stockarray[i].Stockprice)
			fmt.Println("**********************************************")
			fmt.Println("ENTER the no of shares you want to buy")
			var stockshare int
			fmt.Scanf("%d", &stockshare)
			//checking shares present in that stock
			if stockshare <= stockarray[i].Stockshares {
				value := stockarray[i].Stockprice * stockshare
				//checking the userbalance to buy shares
				if userarray[0].Userbalance >= value {
					//updating the user and stocks details
					userarray[0].Usershares = userarray[0].Usershares + stockshare
					userarray[0].Userbalance = userarray[0].Userbalance - value
					stockarray[i].Stockshares = stockarray[i].Stockshares - stockshare
					//saving to corresponding json file
					SaveToStock(stockarray)
					SaveToUser(userarray)
					fmt.Println("***********SUCCESSFULLY BOUGHT**********")
					check = 1
					break
				} else {
					fmt.Println("need more money to buy")
					Buy()
				}
			} else {
				fmt.Println("not enough stockshares to buy")
				Buy()
			}
		}

	}
	if check != 1 {
		fmt.Println("No Such STOCK NAME Exist To Buy")
		Buy()
	}

}

//function to sell stockshares
//@userarray :struct type user

func Sell() {
	fmt.Println("ENTER the stock name to which you want to sell shares ")
	var stockname string
	fmt.Scanf("%s", &stockname)
	var stockarray []Stocks
	stockarray = GetArrayStocks()
	var userarray []user
	userarray = GetArrayUser()
	check := 0
	for i := 0; i < len(stockarray); i++ {
		//checking shares present in that stock
		if stockarray[i].Stockname == stockname {
			fmt.Println("******The Stock Name and It's Details******")
			fmt.Printf("Stockname : %s\n", stockarray[i].Stockname)
			fmt.Printf("stockshare: %d\n", stockarray[i].Stockshares)
			fmt.Printf("stockprice: %d\n", stockarray[i].Stockprice)
			fmt.Println("******************************************")
			fmt.Println("ENTER the no of shares you want to sell")
			var stockshare int
			fmt.Scanf("%d", &stockshare)
			//checking the usershares to buy shares
			if stockshare <= userarray[0].Usershares {
				//@value :total price
				value := stockarray[i].Stockprice * stockshare
				//updating the value to user and stocks
				userarray[0].Usershares = userarray[0].Usershares - stockshare
				userarray[0].Userbalance = userarray[0].Userbalance + value
				stockarray[i].Stockshares = stockarray[i].Stockshares + stockshare
				//saving to user and stocks json
				SaveToStock(stockarray)
				SaveToUser(userarray)
				fmt.Println("************SUCCESSFULLY SOLD*************")
				check = 1
				break
			} else {
				fmt.Println("not enough stockshares to sell")
				Sell()
			}
		}
	}
	if check != 1 {
		fmt.Println("No Such STOCK NAME Exist")
		Sell()
	}
}

//function to print stocks or user report
//@userarray :struct type user
//@stockarray :struct type stock

func PrintReport() {
	fmt.Println("ENTER 1 :  To Print Stock Report")
	fmt.Println("ENTER 2 :  To Print User Report")
	var report int
	fmt.Scanf("%d", &report)
	//user choice to choose report
	switch report {
	case 1:
		var stockarray []Stocks
		//getting the stock data from file
		stockarray = GetArrayStocks()
		fmt.Println("****************STOCK REPORT********************")
		for i := 0; i < len(stockarray); i++ {
			fmt.Printf("STOCK NAME         :  %s\n", stockarray[i].Stockname)
			fmt.Printf("STOCK SHARES       :  %d\n", stockarray[i].Stockshares)
			fmt.Printf("STOCK PRICE        :  %d\n", stockarray[i].Stockprice)
			fmt.Println("************************************************")
		}
	case 2:
		//getting the user data from file
		var userarray []user
		userarray = GetArrayUser()
		fmt.Println("*******************USER REPORT**********************")

		fmt.Printf("USER NAME         :  %s\n", userarray[0].Username)
		fmt.Printf("USER SHARES       :  %d\n", userarray[0].Userbalance)
		fmt.Printf("USER BALANCE      :  %d\n", userarray[0].Usershares)
		fmt.Println("*****************************************************")

	}

}

//function to get data from json
//@stockarray :struct type stock

func GetArrayStocks() []Stocks {
	file, err1 := ioutil.ReadFile("stocks.json")
	if err1 != nil {
		os.Exit(1)
	}
	var stockarray []Stocks

	err2 := json.Unmarshal(file, &stockarray)
	if err2 != nil {
		fmt.Println("error:", err2)
		os.Exit(1)
	}
	return stockarray
}

//function to get data from json
//@userarray :struct type user

func GetArrayUser() []user {
	file, err1 := ioutil.ReadFile("users.json")
	if err1 != nil {
		os.Exit(1)
	}
	var userarray []user

	err2 := json.Unmarshal(file, &userarray)
	if err2 != nil {
		fmt.Println("error:", err2)
		os.Exit(1)
	}
	return userarray
}

//function to stock data to stock json file
//@arr:struct type stock

func SaveToStock(arr []Stocks) {
	result, err := json.Marshal(arr)
	if err != nil {
		fmt.Println(err)
	}
	err = ioutil.WriteFile("stocks.json", result, 0644)
}

//function to user data to user json file
//@arr :struct type user

func SaveToUser(arr []user) {
	result, err := json.Marshal(arr)
	if err != nil {
		fmt.Println(err)
	}
	err = ioutil.WriteFile("users.json", result, 0644)
}
