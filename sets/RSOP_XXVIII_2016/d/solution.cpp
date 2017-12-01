#include <stdio.h>
#include <iostream>
#include <queue>
#include <vector>
#include <algorithm>
#define MAXN 1000
#define MAXM 10000

using namespace std;

struct Street {
    int a, b, t;
};

bool compare(Street s1, Street s2) {
    return s1.t < s2.t;
}

int findComp(int x, int *V) {
    int k = x;
    while (V[k] != k) k = V[k];
    V[x] = k;
    return k;
}

void solve() {
    int n,m,k;
    Street streets[MAXM];
    int flood[MAXM];
    scanf("%d %d %d", &n, &m, &k);
    for(int i=0; i<m; i++) {
        scanf("%d %d %d", &streets[i].a, &streets[i].b, &streets[i].t);
    }
    for(int i=0; i<m; i++) flood[i] = 1;
    
    for(int i=0; i<k; i++){
        int x;
        scanf("%d", &x);
        flood[x-1] = 0;
    }
    
    vector<int> G[MAXN];
    vector<Street> S;
    for(int i=0; i<m; i++) {
        if (flood[i]) {
            G[streets[i].a].push_back(streets[i].b);
            G[streets[i].b].push_back(streets[i].a);
        } else {
            S.push_back(streets[i]);
        }
    }
    
    int V[MAXN];
    for(int i=0; i<n; i++) V[i] = -1;
    
    for(int i=0; i<n; i++) {
        if (V[i] == -1) {
            //dfs
            queue<int> q;
            q.push(i);
            V[i] = i;
            while (!q.empty()){
                int x = q.front();
                q.pop();
                for(vector<int>::iterator it=G[x].begin(); it!=G[x].end(); it++) {
                    if (V[*it] == -1) {
                        V[*it] = i;
                        q.push(*it);
                    }
                }
            }
            
        }
    }
    
    sort(S.begin(), S.end(), compare);
    int sum = 0;
    
    for(vector<Street>::iterator it=S.begin(); it!=S.end(); it++){
        int cA = findComp(it->a, V);
        int cB = findComp(it->b, V);
        if (cA != cB) {
            V[cB] = cA;
            sum += it->t; 
        }
    }
    
    printf("%d\n", sum);
}

int main() {
    int t;
    scanf("%d", &t);
    for(int i=0; i<t; i++) {
        solve();
    }
    return 0;
}