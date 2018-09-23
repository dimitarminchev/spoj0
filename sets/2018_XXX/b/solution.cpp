#include <stdio.h>
#include <stdlib.h>
#include <iostream>
#include <string.h>
#define MAXN 200

using namespace std;

struct saveRes{
               int dist;        // Обща дължина в км.
               int lnh;         // Брой населени места в маршрута
               char rpnt[MAXN]; // Маршрут --> списък от населени места
              }res[1000];
int n, sv, ev, maxd;
int A[MAXN][MAXN];  // матрица на съседство
bool used[MAXN];    // флаг необходен/обходен
int path[MAXN], npaths = 0, cnt;
// функция за сравнение --> използва се от qsort()
int cmp(const void *a,const void *b){
  saveRes *c, *d;
  c=(saveRes *)a;
  d=(saveRes *)b;
  if(c->dist > d->dist) return 1;
  if(c->dist < d->dist) return -1;
  return(strcmp((*c).rpnt,(*d).rpnt));
}
void findPaths(void){
    int k, s;
    s=0;
    for(k = 0; k < cnt; k++)s += A[path[k]][path[k+1]];
    if(s<=maxd){
       res[npaths].dist = s;
       for(k = 0; k <= cnt; k++){
          res[npaths].rpnt[k]= path[k]+1;
       }
       res[npaths].lnh = cnt;
       npaths++;
   }
  return;
}
void allDFS(int i, int j){
    int k;
    if(i == j){
      path[cnt] = j;
      findPaths();
      return;
    }
    used[i] = true;
    path[cnt++] = i;
    for(k = 0; k < n; k++)  /* рекурсия за всички съседи на i */
       if(A[i][k] && !used[k]) allDFS(k, j);
    /* връщане: размаркирване на посетеният връх */
    used[i] = false; cnt--;
}
int main(void){
  int m, i, k;
  while(cin >> n >> m){
       npaths = cnt = 0;
       for(k = 0; k < n; k++){
          used[k] = false;
          for(i=0; i<n; i++) A[k][i] = 0;
       }
    for(i = 0; i < m; i++ ){
        int u, v, d;
        cin >> u >> v >> d;
        u--; v--;
        A[u][v] = A[v][u] = d;
    }
    cin >> sv >> ev >> maxd;
    allDFS(sv-1, ev-1);
    if( npaths > 0 ){
        qsort(res, npaths,sizeof(saveRes),cmp);
        for(i=0; i<npaths; i++){
            printf("%u:", res[i].dist);
            for(k=0; k<=res[i].lnh; k++)
               printf(" %u", res[i].rpnt[k]);
            printf("\n");
        }
    }
    else printf("No\n");
  }
  return 0;
}
/* End of File */
