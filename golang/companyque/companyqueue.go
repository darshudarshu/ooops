package main

//*****************************************************************************
//discription : queue implimentation to maintain the stocks transction
//buy() :buy a stock
//sell() : sell a stock
//Enqueu() :add to queue
//Dueue() : remove from queue
//*****************************************************************************
import (
	"fmt"
	"time"
)

//User interface

func main() {
	//allocating the memory to struct
	link := new(queue)
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

func Buy(link *queue) {
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
		//Addding to the queue
		link.Enqueue(stockname, stockshares, stockprice)
		fmt.Println("SUCCESSFULLY BOUGHT @ ", time.Now())

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

func Sell(link *queue) {
	fmt.Println("Enter no of Stock You want to Sell")
	var noOfStocks int
	fmt.Scanf("%d", &noOfStocks)
	for i := 0; i < noOfStocks; i++ {
		//checking stock is empty
		if link.IsPeak() {
			//removing from the queue
			link.Dqueue()
			fmt.Println("SUCCESSFULLY SOLD  @ ", time.Now())
		} else {
			fmt.Println("Queue is Empty , no more stocks")
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

//a queue type stock
//front : stock type
//back : stock type
//count : type int

type queue struct {
	front *stock
	back  *stock
	count int
}

//function to add to the queue
//front : stock type
//back : stock type
//val : to hold the new struct
//old : to hold old struct

func (l *queue) Enqueue(stockname string, stockshares int, stockprice int) {
	val := &stock{stockname: stockname, stockshares: stockshares, stockprice: stockprice}
	old := l.back
	l.back = val
	if l.front == nil {
		l.front = l.back
	} else {
		old.next = l.back
	}
	//incriment count if struct added to queue
	l.count++
}

//function to remove to the queue
//front : stock type

func (l *queue) Dqueue() {
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

//function to add to the queue
//count : type int

func (l *queue) IsPeak() bool {
	if l.count == 0 {
		return false
	} else {
		return true
	}
}
