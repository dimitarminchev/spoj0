#define _CRT_SECURE_NO_WARNINGS

#include <cstdio>
#include <assert.h>
#include <algorithm>
#include <vector>
#include <queue>
#include <memory.h>
using namespace std;

#define MAX 150005

int N, Q;
int par[MAX][18];
int level[MAX];
int dist[MAX];

void bfs(vector<vector<pair<int, int>>>& G)
{
	vector<bool> visited(N);

	queue<int> q;
	q.push(0);
	visited[0] = true;

	par[0][0] = -1;
	level[0] = 0;
	dist[0] = 0;

	while (!q.empty())
	{
		int cur = q.front();
		q.pop();

		for (int i = G[cur].size() - 1; i >= 0; i--)
		{
			int next = G[cur][i].first;
			if (visited[next])
				continue;

			visited[next] = true;

			level[next] = level[cur] + 1;
			par[next][0] = cur;
			dist[next] = dist[cur] + G[cur][i].second;

			q.push(next);
		}
	}
}

void initLCA(vector<vector<pair<int, int>>>& G)
{
	memset(par, 0, sizeof par);
	memset(dist, 0, sizeof dist);

	bfs(G);

	for (int j = 1; (1 << j) < N; j++)
		for (int i = 0; i < N; i++)
			if (par[i][j - 1] != -1)
				par[i][j] = par[par[i][j - 1]][j - 1];
}

int LCA(int p, int q)
{
	if (level[p] < level[q])
		swap(p, q);

	int log = 0;
	while ((1 << log) <= level[p])
		++log;
	--log;

	for (int i = log; i >= 0; i--)
		if (level[p] - (1 << i) >= level[q])
			p = par[p][i];

	if (p == q)
		return p;

	for (int i = log; i >= 0; i--)
		if (par[p][i] != -1 && par[p][i] != par[q][i])
			p = par[p][i], q = par[q][i];

	return par[p][0];
}

int main()
{
	int br = 0;
	while (true)
	{
		scanf("%d", &N);
		if (!N)
			break;

		assert(N <= 150001);

		vector<vector<pair<int, int>>> G(N);

		int v, d;
		for (int u = 1; u < N; u++)
		{
			scanf("%d %d", &v, &d);

			assert(u < N);
			assert(v < N);
			assert(u != v);
			assert(d >= 0 && d < 100);

			G[u].push_back(make_pair(v, d));
			G[v].push_back(make_pair(u, d));
		}

		initLCA(G);

		scanf("%d", &Q);
		assert(Q <= N);
		while (Q--)
		{
			int u, v;
			scanf("%d %d", &u, &v);
			printf("%d\n", dist[u] + dist[v] - 2 * dist[LCA(u, v)]);
		}
	}

	return 0;
}