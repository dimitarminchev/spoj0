#include <iostream>
#include <vector>
#include <algorithm>
#define MAX 2000

using namespace std;

int m,n;

bool used[MAX];
int tin[MAX], low[MAX];
int timer;
vector<pair<int,int>> bridges;

int min(int x, int y) {
    return (x<y)? x:y;
}

bool compare(pair<int,int> a, pair<int,int> b) {
    if (a.first == b.first) {
        return a.second < b.second;
    } else {
        return a.first < b.first;
    }
}

void findBridges (vector<vector<int>> g, int v, int p = -1) {
	used[v] = true;
	tin[v] = low[v] = timer++;
	for (int i = 0; i < g[v].size(); i++) {
		int to = g[v][i];
		if (to == p)  continue;
		if (used[to]) {
			low[v] = min (low[v], tin[to]);
		}
		else {
			findBridges (g, to, v);
			low[v] = min (low[v], low[to]);
			if (low[to] > tin[v]) {
			    if (v<to) bridges.push_back(make_pair(v,to));
			    else bridges.push_back(make_pair(to,v));
			}
		}
	}
}

void solve() {
    cin>>n>>m;
    vector<vector<int>> G(n);
    int x, y;
    for(int i=0; i<m; i++) {
        cin>>x>>y;
        x--;
        y--;
        G[x].push_back(y);
        G[y].push_back(x);
    }
    for(int i=0; i<n; i++) {
        used[i] = false;
    }
    timer = 0;
    bridges.clear();
    findBridges(G,0);
    
    //cout<<endl;
    sort(bridges.begin(), bridges.end(), compare);
    for (int i=0; i<bridges.size(); i++) {
        cout<<bridges[i].first+1<<" "<<bridges[i].second+1<<endl;
    }
}

int main() {
    int t;
    cin>>t;
    while (t>0) {
        solve();
        t--;
    }
    return 0;
}