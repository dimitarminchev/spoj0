#include <algorithm>
#include <cstdio>
#include <cstring>
using namespace std;

int hight [ 131072 ], n, r, c, ans;

void read ()
{
	int i;
	scanf ( "%d%d%d", &n, &r, &c );
	for ( i = 0; i < n; i++ ) scanf ( "%d", &hight [ i ] );
	sort ( hight, hight + n );
}

int find_groups ( int x )
{
	int first, last, diff, count_groups = 0, current_group = 0;
	first = 0;
	last = 0;
	while ( 1 )
	{
		if ( last == n ) break;
		if ( count_groups == r ) break;

		diff = hight [ last ] - hight [ first ];

		if ( diff <= x )
		{
			current_group++;
			last++;
		}
		else
		{
			first++;
			current_group--;
		}

		if ( current_group == c )
		{
			count_groups++;
			current_group = 0;
			first = last;
		}
	}
	return ( count_groups == r );
}

void bin_search ()
{
	int left, right, mid;
	left = 0;
	right = hight [ n - 1 ];
	while ( left <= right )
	{
		mid = ( right + left ) / 2;
		if ( find_groups ( mid ) )
		{
			ans = mid;
			right = mid - 1;
		}
		else left = mid + 1;
	}
	printf ( "%d\n", ans );
}


int main ()
{
    int t,i;
    scanf ( "%d", &t);
    for(i=1;i<=t;i++)
    {
        memset(hight,0,sizeof(hight));
        n=r=c=ans=0;
        read ();
        bin_search ();
    }

	return 0;
}
