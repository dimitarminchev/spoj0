/*
This program solves the problem Rational Numbers, 
proposed for the Bulgarian Student Olympiad in Programming, 2016.
Author Valentin Bakoev.                        Version 4.05.2016.
----------------------------------------------------------------------------
Some notes and examples:
1) 22/7= 3,142857142857... n=6=period - without finite (non-periodic) part
   in the beginning.
2) 1/4+1/275= 279/1100= 0,25363636...  n=4 - the necessary number of digits,
   period= 2. The non-periodic part has: (n - period)= 2 digits.
3) Analogously 1/8+1/1375= 1383/11000= 0,125727272... n=5, period=2, ...
----------------------------------------------------------------------------
*/

#include <iostream>
#include <string.h>

using namespace std;

const int max_length= 1000020;		// Maximal length (i.e. maximal number of digits)
    // of the decimal fraction. The periodic part cannot be greater than the maximal
    // value of q (which is 1000000) because of the Dirichlet principle (in other words,
    // the sequence of numerators starts to repeat itself after at most q divisions.
    // The length of the non-periodic (i.e. finite) part in the beginning cannot be
    // greater than 20= $\log_2 q$. Hence max_length= 1000000 + 20= 1000020.

int p, q, period, n, k;

int	fract_digits [max_length],	// stores the digits of the decimal fraction
	appearance [max_length];	// appearance [i] contains the serial number of
					// the step in which the numerator i is appeared

void init_arrays ( int m )
{
    memset (fract_digits, 0, sizeof fract_digits);
    memset (appearance, 0, sizeof fract_digits);
}

int get_fraction ( int p1, int q1 )	// returns the period of the decimal
{					// fraction p1/q1 and determines its digits
	if ( p1>q1 )
		p1= p1%q1;	// ignore the whole part - so p1<q1
	if ( 0 == p1 )
		return 0;	// when p1/q1 is a whole number
	n= 0;		    // counter of the digits of the decimal fraction
	while ( true )
	{
	    n++;
	    appearance [p1]= n;
		p1= 10*p1;			// since p1<q1, multiply by 10 and divide after that
		int digit= p1/q1;		// serial digit of the decimal fraction
		fract_digits [n]= digit;		// store the serial digit of the decimal fraction
//		cout << "n=" << n << "   p1=" << p1 << ", digit= " << digit << endl;
		p1= p1%q1;		// remainder - so the new fraction is p1/q1
		if ( 0==p1 ) return 0;		// when the decimal fraction has not a period
		if ( appearance [p1]>0 )	// whether this numerator appears for the second time
			return	n-appearance [p1]+1;    // this is the length of the period
		if ( n==max_length-1 ) return -1;	// possible error - out of memory
	}
}

int main ( void )
{
    int m;
//    cout << "Number of tests: ";
    cin >> m;
    for (int i=1; i<=m; i++)
    {
//        cout << "p= ";
        cin >> p;
//        cout << "q= ";
        cin >> q;
//        cout << "k= ";
        cin >> k;
        init_arrays ( q );
        period= get_fraction ( p, q );
        if ( period<0 )
        {
            cout << "Overflow memory error!" << endl;
            return -1;
        }
        //cout << "Number of digits= " << n << "\t Period= " << period << endl;
        cout << period << ' ';//endl;
        int non_per_part= n - period;
        //cout << "The length of the non-periodic part is: " << non_per_part << endl;
        //cout << "The " << k << "-th digit is ";
        if ( k<=n )     // when the k-th digit is computed and stored -
            cout << fract_digits [k] << endl;   // simply prints it
        else
            if ( 0==period )
                cout << 0 << endl;	// a non-periodic fraction -
                                    	// it has zeros after the non-periodic part
            else	// a periodic fraction - it can have a non-periodic part in the beginning
            {		// and a periodic part after it - example (3): 1383/11000= 0,125727272...
                int t= non_per_part + 1 + (k - 1 - non_per_part)%period;
                cout << fract_digits [t] << endl;
            }
    }
    return 0;
}
