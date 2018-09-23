#include <stdio.h>
#include <memory.h>

#define MAXN 100005

int par[MAXN][17], tree[MAXN];

int N, Q, t, q, x, y, k, lgn;

void prepare()
{
	int n = N;
	lgn = 17;

	/*
	n = MAXN;
	while(n)
		n >>= 1, lgn++;
	*/

	for(int i = 0;i < N;i++)
		for(int l = 1;l < lgn;l++)
		{
			int prev = par[tree[i]][l - 1];
			par[tree[i]][l] = par[prev][l - 1];
		}

}

int main()
{
	scanf("%d", &t);
	while(t--)
	{
		memset(par, 0, sizeof par);

		scanf("%d%d", &N, &Q);
		for(int i = 0;i < N;i++)
		{
			scanf("%d%d", &x, &y);
			tree[i] = x;
			par[x][0] = y;
		}

		prepare();

		for(int i = 0;i < Q;i++)
		{
			scanf("%d", &q);
			if(q == 0)
			{
				scanf("%d%d", &x, &y);
				par[x][0] = y;
				for(int l = 1;l < lgn;l++)
				{
					int prev = par[x][l - 1];
					par[x][l] = par[prev][l - 1];
				}
			}
			else if(q == 1)
			{
				scanf("%d", &x);
				for(int l = 0;l < lgn;l++)
					par[x][l] = 0;
			}
			else
			{
				scanf("%d%d", &x, &k);
				int l = 0;
				while(k)
				{
					if(k & 1)
						x = par[x][l];
					k >>= 1;
					l++;
				}
				printf("%d\n", x);
			}
		}
	}

	return 0;
}

