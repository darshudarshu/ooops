package main

//*****************************
//@discription  :​ DeckOfCards
//suit : array of cards type
//rank : array of cards numbers
//deck  : array of full cards
//******************************
import (
	"fmt"
	"math/rand"
	"time"
)

func main() {
	PlayerCards()
}
func PlayerCards() {
	suit := [4]string{"Clubs", "Diamonds", "Hearts", "Spades"}
	rank := [13]string{"2", "3", "4", "5", "6", "7", "8", "9", "10", "Jack", "Queen", "King", "Ace"}
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
	//size of inner array : no of players
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
	fmt.Println("**************************   PLAYERS AND THEIR CARDS DETAILS   ************************************")
	for i := 0; i < 9; i++ {
		for j := 0; j < 4; j++ {
			//assigning to each players
			players[i][j] = tempdeck[num]
			if j == 0 {
				//1st player
				fmt.Printf("1st")
				fmt.Printf("[%17s]", players[i][j])
			} else if j == 1 {
				//2nd player
				fmt.Printf("  /  2nd")
				fmt.Printf("[%17s]", players[i][j])
			} else if j == 2 {
				//3rd player
				fmt.Printf("  /  3rd")
				fmt.Printf("[%17s]", players[i][j])
			} else {
				//4th player
				fmt.Printf("  /  4th")
				fmt.Printf("[%17s]", players[i][j])
			}
			num++
		}
		fmt.Println("\n")
	}

}
func randInt(min int, max int) int {
	//return random number btw min and max
	return min + rand.Intn(max-min)
}
