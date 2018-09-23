#include <iostream>
#include <stdio.h>
#include <vector>
#include <algorithm>
#include <memory.h>
using namespace std;

#define MAXN 10000000

int t = 1, a, b;
int lp[MAXN + 100];
bool p[MAXN + 10];
int x[MAXN + 10];
vector<int> pr;

//Prime Sieve of Eratosthenes O(n) - http://e-maxx.ru/algo/prime_sieve_linear
void precompute()
{
	for (int i = 2; i <= MAXN; i++)
	{
		if (lp[i] == 0) 
		{
			lp[i] = i;
			pr.push_back (i);
			p[i] = true;
		}

		for (int j = 0; j < (int)pr.size() && pr[j] <= lp[i] && i * pr[j] <= MAXN; j++)
			lp[i * pr[j]] = pr[j];
	}
}


int main()
{
	precompute();
	
	int sz = sizeof (int);
	bool first = true;

	//while(cin>>a>>b)
	//{
	while(fread(&a, sz, 1, stdin))
	{
		fread(&b, sz, 1, stdin);

		int prCount = 0;
		memset(x, 0, sizeof x);

		for(int i = a;i <= b;i++)
		{
			if(p[i])
				prCount++;
			else
				x[lp[i]]++;
		}

		if(first)
			first = false;
		else
			printf("\n");

		printf("test case #%d: ", t++);
		printf("\n%d primes in [%d, %d].\n", prCount, a, b);

		if(x[2])
			printf("%d %d\n", 2, x[2]);

		for(int i = 3;i <= b / 2; i += 2)
			if(x[i])
				printf("%d %d\n", i, x[i]);
	}

	return 0;
}