#include <stdio.h>
#include <math.h>
#define MAXN 1024
#define DINF 1000000000.0

typedef struct {  int N,M; int T[MAXN][MAXN]; double  TD[MAXN][MAXN];} WLN_Graph;

typedef struct { double key; int vertex; } heapel;

typedef struct { heapel data[MAXN]; int N, where[MAXN]; } heap;

typedef struct
{  int N; int P[MAXN+1]; } LP_Tree;

WLN_Graph G; LP_Tree D; heap H; heapel E;
int used[MAXN],from,to;

void swapij(int i, int j)
{  int t;double tt;
   H.where[H.data[i].vertex]=j;
   H.where[H.data[j].vertex]=i;
   tt=H.data[i].key; H.data[i].key=H.data[j].key; H.data[j].key=tt;
   t=H.data[i].vertex; H.data[i].vertex=H.data[j].vertex; H.data[j].vertex=t;
}

void heapify(int i)
{  int j = i;
   if(2*i<=H.N && H.data[j].key>H.data[2*i].key) j=2*i;
   if(2*i+1<=H.N && H.data[j].key>H.data[2*i+1].key) j=2*i+1;
   if(j!=i) { swapij(i,j); heapify(j); }
}

void makeheap()
{  int i;
   for(i=H.N/2;i>=1;i--) heapify(i);
}

void get_min(heapel* minn)
{  minn->key=H.data[1].key;
   minn->vertex=H.data[1].vertex;
   H.data[1].key=H.data[H.N].key;
   H.data[1].vertex=H.data[H.N].vertex;
   H.where[H.data[1].vertex]=1;
   H.N--; heapify(1);
}

void go_up(int i)
{  while(i!=1 && H.data[i].key<H.data[i/2].key)
   {  swapij(i,i/2); i/=2; }
}

void input_WLN()
{  int i,j,v,w,c;
   scanf("%d %d",&G.N,&G.M);
   for(i=1;i<=G.N;i++) G.T[i][0]=0;
   for(i=1;i<=G.M;i++)
   {  scanf("%d %d %d", &v,&w,&c);
      G.T[v][++G.T[v][0]]=w;
      G.T[w][++G.T[w][0]]=v;
      double l=-log((1.0*c)/1000);
      G.TD[v][G.T[v][0]]=l;
      G.TD[w][G.T[w][0]]=l;
   }
   scanf("%d %d",&from,&to);
/*for(i=1;i<=G.N;i++)
{ for(j=1;j<=G.T[i][0];j++) printf("%10d ",G.T[i][j]); printf("\n");
  for(j=1;j<=G.T[i][0];j++) printf("%10.2f ",G.TD[i][j]); printf("\n");
}*/
}

void hDijkstra(int r,int f)
{  int i,j,k,x; double y,z;
   for(i=1;i<=G.N;i++)
   {  H.data[i].key=DINF; H.data[i].vertex=i;
      D.P[i]=r; used[i]=0; H.where[i]=i;
   }
   H.N=G.N; H.data[r].key=0.0;D.P[r]=-1;
   makeheap();
   for(i=1;i<=G.N;i++)
   {  get_min(&E); j=E.vertex; z=E.key;
//printf("v:%d p:%f\n",j,z);
      if(j==f) break;
      used[j]=1;
      for(k=1;k<=G.T[j][0];k++)
      {  x=G.T[j][k]; y=G.TD[j][k];
         if(!used[x]&&H.data[H.where[x]].key>z+y)
         { H.data[H.where[x]].key=z+y; go_up(H.where[x]); D.P[x]=j; }
      }
   }
//   printf("%f\n",z);

   int path[MAXN],pp=G.N;j=f;
   while(j!=r) { path[pp--]=j; j=D.P[j]; }
   path[pp]=r;
   for(i=pp;i<G.N;i++) printf("%d ",path[i]);
   printf("%d\n",path[G.N]);
}

int main()
{  int t;
   scanf("%d",&t);
   while (t--)
   {  input_WLN();
      hDijkstra(from,to);
   }
}
