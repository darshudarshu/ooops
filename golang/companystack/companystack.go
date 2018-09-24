package main

//*******************************************************************************
//@discription : stack implimentation to maintain the stocks transction with time
//and date
//@buy() :buy a stock
//@sell() : sell a stock
//@push() :add to stack
//@Pop() : remove from stack
//*******************************************************************************
import (
	"fmt"
)

//User interface

func main() {
	//allocating the memory to struct
	link := new(stack)
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

func Buy(link *stack) {
	fmt.Println("Enter no of Stock You want to purchase")
	//no of stocks to buy
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
		//Addding to the stack
		link.Push(stockname, stockshares, stockprice)
		fmt.Println("SUCCESSFULLY BOUGHT")

	}
	fmt.Println("ENTER 1 : To Sell Stocks ")
	fmt.Println("ENTER 2 : To Main Menu ")
	var show int
	fmt.Scanf("%d", &show)
	if show == 1 {
		//recursion
		Sell(link)
	}
}

//function to sell new stocks

func Sell(link *stack) {
	fmt.Println("Enter no of Stock You want to Sell")
	var noOfStocks int
	fmt.Scanf("%d", &noOfStocks)
	for i := 0; i < noOfStocks; i++ {
		//checking stock is empty
		if link.IsEmpty() {
			//removing from the stack
			link.Pop()
			fmt.Println("SUCCESSFULLY SOLD")
		} else {
			fmt.Println("Stack is Empty")
			break
		}
	}
}

//a struct type stock
//next : stock type

type stock struct {
	next        *stock
	stockname   string
	stockshares int
	stockprice  int
}

// queue type stock
//front : stock type
//count : type int

type stack struct {
	front *stock
	count int
}

//function to add to the stack
//front : stock type
//old : to hold the value of type struct

func (l *stack) Push(stockname string, stockshares int, stockprice int) {
	old := &stock{stockname: stockname, stockshares: stockshares, stockprice: stockprice}
	if l.front == nil {
		l.front = old
	} else {
		old.next = l.front
		l.front = old
	}
	//incriment count if struct added to stack
	l.count++
}

//function to remove to the stack
//@front : stock type

func (l *stack) Pop() {
	if l.front == nil {
		fmt.Println("")
	}
	//taking values of corresponding struct
	value1 := l.front.stockname
	value2 := l.front.stockshares
	value3 := l.front.stockprice
	fmt.Println("--------------------------------------")
	fmt.Printf("Stock Name   : %s\n", value1)
	fmt.Printf("Stock Shares : %d\n", value2)
	fmt.Printf("Stock Price  : %d\n", value3)
	fmt.Println("--------------------------------------")
	//moving to next struct
	l.front = l.front.next
	//decriment the count if it removed
	l.count--
}

//function to add to the stack
//@count : type int

func (l *stack) IsEmpty() bool {
	if l.count == 0 {
		return false
	} else {
		return true
	}
}
