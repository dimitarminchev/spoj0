#include <bits/stdc++.h>
#define NAME "employees"
using namespace std;

const int inf = 1e9 + 5;
const int maxN = 1005;

int a[maxN], b[maxN], dp[maxN][maxN];

int dist(int i, int j) {
    if (i == 0) return abs(b[j] - a[j]);
    return abs(a[j] - b[i]) + abs(b[j] - a[j]);
}

void solve() {
	
	int n, m;
    scanf("%d %d", &n, &m);
    for (int i = 1; i <= m; i++) {
		scanf("%d %d", &a[i], &b[i]);
	}
	
    for (int i = 0; i < maxN; i++) {
        for(int j = 1; j < maxN; j++) {
            dp[i][j] = inf;
		}
	}
	
    int res = inf;
    for (int i = 0; i < m; i++) {
        for (int j = i; j <= m; j++) {
            if (j == m) {
                res = min(res, dp[i][j]);
            } else {
				int me = dp[i][j];
				dp[i][j + 1] = min(dp[i][j + 1], me + dist(j, j + 1));
				dp[j][j + 1] = min(dp[j][j + 1], me + dist(i, j + 1));
			}
		}
	}
	
	printf("%d\n", res);
}

int main() {
	
	// freopen(NAME ".in", "r", stdin);
	// freopen(NAME ".out", "w", stdout);
	
	int t;
	scanf("%d", &t);
	
	for (int k = 0; k < t; k++) {
		solve();
	}
    
    return 0;
}