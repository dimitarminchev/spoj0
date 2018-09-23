#include <iostream>
#include <complex>
#include <cmath>
#include <cstdio>
#include <cstdlib>
#include <algorithm>
#include <vector>
#include <deque>
#include <queue>
#include <stack>
#include <map>
#include <set>
#include <string>
#include <cstring>
#include <bitset>
#include <cassert>
#include <utility>
using namespace std;
#define all(a) (a).begin(), (a).end()
#define pb push_back
#define mp make_pair
#define fi first
#define se second
typedef long long ll;
typedef vector<int> vi;
void do_cin(){
  ios_base::sync_with_stdio(false);
  cin.tie(0);
}
const int MAXN = 2100;
char in[MAXN][MAXN];
int UP[MAXN];
int N , ANS;
int Left[MAXN] , Right[MAXN];
stack<int> pos;
void go_left(){
  while(!pos.empty()) pos.pop();
  UP[0] = -100;
  pos.push(0);
  for(int i=1;i<=N;++i){
   while(UP[pos.top()] >= UP[i])
    pos.pop();
   Left[i] = pos.top();
   pos.push(i);
                       }
}
void go_right(){
  while(!pos.empty()) pos.pop();
  UP[N+1] = -100;
  pos.push(N+1);
  for(int i=N;i>=1;--i){
   while(UP[pos.top()] >= UP[i])
    pos.pop();
   Right[i] = pos.top();
   pos.push(i);
                       }
}
void doit(){
  ANS = 0;
  scanf("%d", &N);
  for(int i=0;i<N;++i)
     scanf("%s", in[i]);
  fill(UP , UP + N + 1 , 0);
  for(int i=0;i<N;++i){
   for(int j=0;j<N;++j)
    if(in[i][j] == '0') UP[j+1] = 0;
    else UP[j+1] = 1 + UP[j+1];
   //for(int j=1;j<=N;++j)
   //  cout<<UP[j]<<' ';
   //cout<<endl;
   go_left();
   go_right();
   for(int j=1;j<=N;++j){
    int H = UP[j];
    int LP = Left[j];
    int RP = Right[j];
    //cout<<RP<<' ';
    int span = max(1 , (RP-1) - (LP+1) + 1);
    ANS = max(ANS , H * span);
                        }
   //cout<<endl<<endl<<endl;
                      }
  printf("%d\n", ANS);
}
int main(){
  int Q;
  scanf("%d" , &Q);
  while(Q-- > 0) doit();
  return 0;
}
