/*------------------------------------------------------------------------------
This program solves the problem Sum, proposed for the
Bulgarian Student's Olympiad in Programming 2016.
Author: Valentin Bakoev.       Version 5.05.2016.
--------------------------------------------------------------------------------
Some notes and examples: let n= 123= 1.10^2+2.10^1+3.10^0. All possible numbers
obtained by n are: 000, 003, 020, 023, 100, 103, 120 and 123. Note that there
is a bijection between them (i.e. between all subsets of the set of all digits
of n) and the vectors of the 3-dimensional boolean cube: (0,0,0), (0,0,1),
(0,1,0), (0,1,1), (1,0,0), (1,0,1) and (1,1,1). Their number is 2^3= 8 (here 3
is the number of the digits of n). Half of them (i.e. 4) contain zero, and the
rest half contain one - for each of its coordinates. So, if we sum the obtained
numbers we shall obtain 4.(1.10^2+2.10^1+3.10^0)= 4.123= 492. If some of the
digits of n are equal to 0, they remain the same and only the remaining digits
of n can vary. So we have to use a boolean cube, corresponding to the non-zero
digits only and the arguments are analogous. The proposed solution firstly
computes the number of digits of n (let n has k digits) and the number of zeros
among them (let their number be m). After that we obtain the solution very 
simply - by multiplying n and the number 2^(k-m-1). Each other solution, 
based on generating of all possible numbers (obtained by n) is ineffective 
and leads to a Time Limit Exceeded message.
--------------------------------------------------------------------------------
*/
#include <iostream>

using namespace std;

typedef unsigned long long ull;
int digit, num_of_digits, num_of_zeros;
ull n, save_n, res;

int main ( )
{
    while ( true ) {
//        cout << "n= ";
        cin >> n;
        if ( 0==n ) {
            break;
        }
        save_n= n;  // save n before it to be modified
        num_of_digits= 0;
        num_of_zeros= 0;
        while ( n ){
            digit= n%10;
            n= n/10;
            num_of_digits++;
            if ( 0==digit )
                num_of_zeros++;
        }
        int mult= 1<<(num_of_digits-num_of_zeros-1); // fast computing of power of 2
        res= save_n*mult;
//        cout << "res= ";
        cout << res << endl;
    }
    return 0;
}
