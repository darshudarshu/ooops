package main

//***************************
//@discription  :​ DeckOfCards
//suit : array of cards type
//rank : array of cards numbers
//deck  : array of full cards
//****************************
import (
	"fmt"
	"math/rand"
	"strings"
	"time"
)

func main() {
	link := new(queue)
	PlayerCards(link)
}
func PlayerCards(link *queue) {
	suit := [4]string{"Clubs", "Diamonds", "Hearts", "Spades"}
	rank := [13]string{"Ace", "2", "3", "4", "5", "6", "7", "8", "9", "10", "Jack", "Queen", "King"}
	deck := [52]string{}
	l := 0
	for i := 0; i < len(suit); i++ {
		for j := 0; j < len(rank); j++ {
			//creating card using array
			deck[l] = suit[i] + " of " + rank[j]
			l++
		}
	}

	//players : 2d array
	//size of outer array : no of cards to be distrubuted

	players := [9][4]string{}
	//store in temp deck to shuffel
	tempdeck := deck

	for i := 0; i < len(deck); i++ {
		//random function
		rand.Seed(time.Now().UTC().UnixNano())
		r := randInt(0, 51)
		var temp string
		//shuffle cards
		temp = tempdeck[r]
		tempdeck[r] = tempdeck[i]
		tempdeck[i] = temp
	}

	num := 0

	for i := 0; i < 9; i++ {
		for j := 0; j < 4; j++ {
			//assigning to each players
			players[i][j] = tempdeck[num]

			num++
		}
	}
	//@temp  : each player cards
	temp := [4][9]string{}
	for i := 0; i < 9; i++ {
		for j := 0; j < 4; j++ {

			temp[j][i] = players[i][j]

			num++
		}
	}
	// sorting the rank
	var val1, val2 int
	for l := 0; l < 4; l++ {
		for i := 0; i < 8; i++ {
			for j := i + 1; j < 9; j++ {
				for k := 0; k < 13; k++ {
					if strings.Contains(temp[l][i], rank[k]) {
						val1 = k
					}
					if strings.Contains(temp[l][j], rank[k]) {
						val2 = k
					}
				}
				if val1 >= val2 {
					temparory := temp[l][i]
					temp[l][i] = temp[l][j]
					temp[l][j] = temparory
				}
			}
		}
	}

	//adding to queue
	for i := 0; i < 4; i++ {
		for j := 0; j < 9; j++ {
			link.Enqueue(temp[i][j])
		}
	}
	//removing from queue
	fmt.Println("**************************   PLAYERS AND THEIR CARDS DETAILS   ************************************")
	for i := 0; i < 4; i++ {
		fmt.Printf("player %d has \n", i)
		for j := 0; j < 9; j++ {
			ref := link.Dqueue()
			fmt.Printf("[%18s]\n", ref)
		}
		fmt.Println("\n")
	}

}

func randInt(min int, max int) int {
	//return random number btw min and max
	return min + rand.Intn(max-min)
}

//a struct type stock
//next : stock type

type stock struct {
	next *stock
	data string
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

func (l *queue) Enqueue(data string) {
	val := &stock{data: data}
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

func (l *queue) Dqueue() string {
	if l.front == nil {
		fmt.Println("")
	}
	//taking values of corresponding struct
	value1 := l.front.data
	//moving to next struct
	l.front = l.front.next
	//decriment the count if it removed
	l.count--
	return value1
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
