#include <stdio.h>
#define MAXN 1024
int N,M,A[MAXN][MAXN],G[MAXN][MAXN],U[MAXN],P[MAXN],H[MAXN];
int Q[MAXN],b,e,color=0;

void make_empty(){b=0;e=-1;}
void push(int x){Q[++e]=x;}
int pop(){return Q[b++];}
bool not_empty(){return b<=e;}

void BFS_Components(int r)
{  int  x,y,i;
   make_empty();push(r);P[r]=r;H[r]=1;
   while(not_empty())
   {  x=pop();
      for(i=1;i<=G[x][0];i++)
      {  y=G[x][i]; if(!U[y]){push(y); U[y]=1; P[y]=r;}
      }
   }
 }
int find(int u)
{
    int x=u,y;
    while(P[x]!=x)x=P[x];
    while(P[u]!=x) {y=P[u];P[u]=x;u=y;}
    return x;
}
void join(int u, int v)
{
    if(H[u]<H[v]) {P[u]=v;H[u]=0;}
    else if(H[u]>H[v]){P[v]=u;H[v]=0;}
    else {P[v]=u;H[u]++;H[v]=0;}
}

int main()
{  int i,j,u,v,t,R,x,y;

   scanf("%d",&t);
   while(t--)
   {  scanf("%d %d", &N, &M);
      for(i=1;i<=N;i++) {G[i][0]=P[i]=U[i]=0;}
      for(i=1;i<=M;i++)
      {  scanf("%d %d",&u,&v);
         G[u][++G[u][0]]=v;
         G[v][++G[v][0]]=u;
         A[u][v]=A[v][u]=1;
      }

      for(i=1;i<=N;i++) {if(!U[i]) BFS_Components(i); }
      scanf("%d",&R);
      while(R--)
      {  scanf("%d %d %d",&j,&u,&v);
         switch (j)
         {  case 1: x=find(u);y=find(v);
                    if(x==y) printf("1"); else printf("0");
                    break;

            case 2: if(A[u][v]) break;
                    G[u][++G[u][0]]=v;
                    G[v][++G[v][0]]=u;
                    A[u][v]=A[v][u]=1;
                    x=find(u);y=find(v);
                    if(x!=y) join(x,y);
                    break;

            case 3: if(!A[u][v]) break;
                    A[u][v]=0;
                    for(i=1;i<=G[u][0];i++)
                       if(G[u][i]==v) {G[u][i]=G[u][G[u][0]]; break;}
                    G[u][0]--;
                    for(i=1;i<=G[v][0];i++)
                       if(G[v][i]==u) {G[v][i]=G[v][G[v][0]]; break;}
                    G[v][0]--;
                    for(i=1;i<=N;i++) U[i]=0;
                    BFS_Components(u);
                    if(U[v]==0) BFS_Components(v);
                    break;
         }
      }
      printf("\n");
   }
}

