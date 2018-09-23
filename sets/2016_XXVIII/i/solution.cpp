#include <iostream>
#include <memory.h>
#include <vector>
#include <bitset>
#include <queue>
#include <string>
#include <functional>
#include <assert.h>
using namespace std;

int t, n, m, u, v, c;

#define MAXN 10005
#define INF 1000000000
#define INFM -1
#define MP(x, y) make_pair((x), (y))

int dist[MAXN], fp[MAXN];
bool b[MAXN];

void init()
{
	memset(b, 0, sizeof b);
	memset(fp, INFM, sizeof fp);
}

void dijkstra(vector<vector<pair<int, int>>>& g, int s)
{
	int i, u, v, w;
	
	vector<int> dist(n + 1, INF); 
	dist[s] = 0;

	// sort by distance
	priority_queue<pair<int, int>, vector<pair<int, int>>, greater<pair<int, int>> > pq; 
	pq.push(make_pair(0, s)); 

	while (!pq.empty())
	{
		pair<int, int> front = pq.top(); 
		int d = front.first;
		int u = front.second;
		pq.pop();

		if (d > dist[u]) 
			continue;

		for (i = 0; i < g[u].size(); i++)
		{
			v = g[u][i].first;
			w = g[u][i].second;

			if (dist[u] + w < dist[v])
			{
				dist[v] = dist[u] + w;
				pq.push(MP(dist[v], v));
			}
		}
	}

	for (int i = 1; i <= n; i++)
		if (!b[i])
			cout << i << " " << (dist[i] == INF ? -1 : dist[i]) << endl;
}

string type;

int main()
{
	ios_base::sync_with_stdio(0);
	cin.tie(0);

	cin >> t;
	while (t--)
	{
		cin >> n;
		cin.get();

		assert(n > 0 && n <= 10000);

		init();
		getline(cin, type);

		assert(type.size() == n);

		for (int i = 0; i < type.size(); i++)
			b[i + 1] = type[i] == 'B';
		
		vector<vector<pair<int, int>>> g(n + 1);

		cin >> m;
		int fake = 0;
		for (int i = 0; i < m; i++)
		{
			cin >> u >> v >> c;
			
			assert(u >= 1 && u <= n);
			assert(v >= 1 && v <= n);
			assert(u != v);
			assert(c >= 0 && c <= 1000);

			if (b[u] && b[v]) //skip B to B
				continue;

			if (b[v])// B to A
			{
				if (fp[u] == INFM || fp[u] > c)
					fp[u] = c;
			}
			else if (b[u])// A to B
			{
				if (fp[v] == INFM || fp[v] > c)
					fp[v] = c;
			}
			else // A to A
			{
				g[v].push_back(MP(u, c));
				g[u].push_back(MP(v, c));
			}
		}

		// add all eadges to the fake vertex
		for (int i = 1; i <= n; i++)
			if (fp[i] != INFM)
				g[fake].push_back(MP(i, fp[i]));

		dijkstra(g, fake);
	}

	return 0;
}