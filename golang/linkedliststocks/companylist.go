package main

//******************************************************************************
//@discription : Linked list implimentation to maintain the stocks transction
//@buy() :buy a stock
//@sell() : sell a stock
//@purchase() :add to list
//@sold() : remove from list
//@display() : display list
//*******************************************************************************
import (
	"fmt"
)

//User interface

func main() {
	// var link linkedliststock
	link := new(linkedliststock)
	loop := 1
	for loop == 1 {
		fmt.Println("ENTER 1 : To Purchase Stocks ")

		fmt.Println("ENTER 2 : To Exit ")
		var check int
		fmt.Scanf("%d", &check)
		switch check {
		case 1:
			Buy(link)
		}
		//looping
		if check == 2 {
			loop = 0
		}
	}
}

//function to buy new stocks

func Buy(link *linkedliststock) {
	fmt.Println("Enter no of Stock You want to purchase")
	var noOfStocks int
	fmt.Scanf("%d", &noOfStocks)
	for i := 0; i < noOfStocks; i++ {
		var stockname string
		var stockshares, stockprice int
		fmt.Println("enter stockname")
		fmt.Scanf("%s", &stockname)
		fmt.Println("enter stockshares ")
		fmt.Scanf("%d", &stockshares)
		fmt.Println("enter stockprice")
		fmt.Scanf("%d", &stockprice)
		//Addding to the list
		link.Purchase(stockname, stockshares, stockprice)
		fmt.Println("SUCCESSFULLY BOUGHT")

	}
	fmt.Println("ENTER 1 : To View Stocks ")
	fmt.Println("ENTER 2 : To Sell Stocks ")
	fmt.Println("ENTER 3 : To Main Menu ")
	var show int
	fmt.Scanf("%d", &show)
	if show == 1 {
		//displaying bought stacks
		View(link)
	} else if show == 2 {
		//recursion
		Sell(link)
	}
}

//function to sell new stocks
//@stockname : string user input

func Sell(link *linkedliststock) {
	fmt.Println("Enter no of Stock You want to Sell")
	var noOfStocks int

	fmt.Scanf("%d", &noOfStocks)
	for i := 0; i < noOfStocks; i++ {
		var stockname string
		fmt.Println("enter the stockname  ")
		fmt.Scanf("%s", &stockname)
		//selling the corresponding stock
		sold := link.Sold(stockname)
		if sold {
			fmt.Println("SUCCESSFULLY SOLD")
			fmt.Println("ENTER 1 : To View Stocks ")
			fmt.Println("ENTER 2 : To Main Menu ")
			var show int
			fmt.Scanf("%d", &show)
			if show == 1 {
				//displaying remaining stocks
				View(link)
			}
		} else {
			fmt.Println("No such Stock Name Exist")
		}
	}
}

//function to view the list of stocks

func View(link *linkedliststock) {
	fmt.Println("-----------------STOCK REPORT------------------")
	//calling display function of linked list
	link.Display()
	fmt.Println("ENTER 1 : To Sell Stocks ")
	fmt.Println("ENTER 2 : To Main Menu ")
	var show int
	fmt.Scanf("%d", &show)
	if show == 1 {
		//recursion
		Sell(link)
	} else {
		fmt.Println("No such Stock Name Exist")
	}
}

//a struct type stock
//@next : stock type

type stock struct {
	next        *stock
	stockname   string
	stockshares int
	stockprice  int
}

//a linkedlist type stock
//@front : stock type
//@back : stock type
//@count : type int

type linkedliststock struct {
	front *stock
	back  *stock
	count int
}

//function to add to the linkedlist
//@front : stock type
//@back : stock type
//@val : to hold the new struct
//@old : to hold old struct

func (l *linkedliststock) Purchase(stockname string, stockshares int, stockprice int) {
	val := &stock{stockname: stockname, stockshares: stockshares, stockprice: stockprice}
	old := l.back
	l.back = val
	if l.front == nil {
		l.front = l.back
	} else {
		old.next = l.back
	}
	//incriment count if struct added to list
	l.count++
}

//function to remove to the linkedlist
//@fro

func (l *linkedliststock) Display() {
	current := l.front
	for current != nil {
		//taking values of corresponding struct
		value1 := current.stockname
		value2 := current.stockshares
		value3 := current.stockprice
		fmt.Println("--------------------------------------")
		fmt.Printf("Stock Name   : %s\n", value1)
		fmt.Printf("Stock Shares : %d\n", value2)
		fmt.Printf("Stock Price  : %d\n", value3)
		fmt.Println("--------------------------------------")
		//moving to next struct
		current = current.next
	}

}

//function to remove specific struct from linkedlist
//@current : to hold the current struct
//@previous : to hold the previous struct

func (l *linkedliststock) Sold(stockname string) bool {

	current := l.front
	previous := l.front
	//check given struct present
	for current.stockname != stockname {
		if current.next == nil {
			return false
		} else {
			previous = current
			current = current.next
		}
	}
	//check if it is 1st  struct
	if current == l.front {
		if l.count == 1 {
			l.back = l.front
		}
		l.front = l.front.next
	} else {
		//check if it is a last struct
		if l.back == current {
			l.back = previous
		}
		previous.next = current.next
	}
	//decriment the count if it removed
	l.count--
	return true
}
