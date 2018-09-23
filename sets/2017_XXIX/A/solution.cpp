/*
ID: espr1t
TASK: Stara Zagora
KEYWORDS: Medium, 2-SAT
*/

#include <cstdio>
#include <cstring>
#include <vector>
#include <stack>

using namespace std;
FILE* in = stdin; FILE* out = stdout;

const int MAX = 202;

int n, m, k;

bool vis[MAX];
vector <int> v[MAX], r[MAX];

stack <int> s;
int comp[MAX], numComps;

void forwardRecurse(int node) {
    vis[node] = true;
    for (int i = 0; i < (int)v[node].size(); i++)
        if (!vis[v[node][i]]) forwardRecurse(v[node][i]);
    s.push(node);
}

void backwardRecurse(int node, int component) {
    comp[node] = component;
    for (int i = 0; i < (int)r[node].size(); i++)
        if (comp[r[node][i]] == -1) backwardRecurse(r[node][i], component);
}

void kosaraju() {
    numComps = 0;
    memset(vis, 0, sizeof(vis));
    memset(comp, -1, sizeof(comp));
    while (!s.empty())
        s.pop();

    for (int i = 0; i < 2 * (n + m); i++)
        if (!vis[i]) forwardRecurse(i);

    while (!s.empty()) {
        int node = s.top(); s.pop();
        if (comp[node] != -1)
            continue;
        backwardRecurse(node, numComps++);
    }
}

void addEdge(int node1, int node2) {
    v[node1].push_back(node2);
    r[node2].push_back(node1);
}

inline int getRow(int row, int dir) {return (row * 2) ^ dir;}
inline int getCol(int col, int dir) {return (col * 2 + n * 2) ^ dir;}

int main(void) {
    // in = fopen("StaraZagora.in", "rt");
    // out = fopen("StaraZagora.out", "wt");
    
    int numTests;
    fscanf(in, "%d", &numTests);
    
    for (int test = 0; test < numTests; test++) {
        for (int i = 0; i < MAX; i++)
            v[i].clear(), r[i].clear();

        fscanf(in, "%d %d %d", &n, &m, &k);
        for (int i = 0; i < k; i++) {
            int row1, col1, row2, col2;
            fscanf(in, "%d %d %d %d", &row1, &col1, &row2, &col2);
            row1--, col1--, row2--, col2--;
            int wantedRow = col1 < col2, wantedCol = row1 < row2;
            if (row1 == row2) {
                addEdge(getRow(row1, !wantedRow), getRow(row1, wantedRow));
            } else if (col1 == col2) {
                addEdge(getCol(col1, !wantedCol), getCol(col1, wantedCol));
            } else {
                addEdge(getRow(row1, !wantedRow), getRow(row2, wantedRow));
                addEdge(getRow(row2, !wantedRow), getRow(row1, wantedRow));
                addEdge(getCol(col1, !wantedCol), getCol(col2, wantedCol));
                addEdge(getCol(col2, !wantedCol), getCol(col1, wantedCol));
                addEdge(getRow(row1, !wantedRow), getCol(col1, wantedCol));
                addEdge(getCol(col1, !wantedCol), getRow(row1, wantedRow));
                addEdge(getRow(row2, !wantedRow), getCol(col2, wantedCol));
                addEdge(getCol(col2, !wantedCol), getRow(row2, wantedRow));
            }
        }
        // Run 2-SAT
        kosaraju();
        
        // Check impossibility
        bool impossible = false;
        for (int i = 0; i < n + m; i++) {
            if (comp[i * 2 + 0] == comp[i * 2 + 1]) {
                impossible = true;
                break;
            }
        }
        fprintf(out, "%s\n", impossible ? "No" : "Yes");
    }
    
    return 0;
}
