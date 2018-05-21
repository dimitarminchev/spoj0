#include <stdio.h>
#include <vector>
#define MAXN 128
using namespace std;

int D[MAXN][MAXN],N,G[MAXN][MAXN],L[MAXN];
vector<vector<int> > mmap;
int fin[MAXN],fin2[MAXN],neib[MAXN][2];
int brL,brF,brF2;
int Q[MAXN],U[MAXN],b,e;
void make_empty(){b=0;e=-1;}
void push(int x){Q[++e]=x;}
int pop(){return Q[b++];}
bool not_empty(){return b<=e;}

void BFS(int r,int k)
{  int  x,y,i;
   L[k]=r;for(i=1;i<=N;i++) D[k][i]=-1;
   make_empty();push(r); D[k][r]=0;
   while(not_empty())
   {  x=pop();
      for(i=1;i<=G[x][0];i++)
      {  y=G[x][i];
         if(D[k][y]== -1){push(y); D[k][y]=D[k][x]+1; }
      }
   }
}

bool covered(int i,int k)
{  int j,p,q;
   for(p=0;p<mmap[i].size()-1;p++)
   {  for(q=p+1;q<mmap[i].size();q++)
      {
         int f = 1;
         for(j=1;j<=k;j++)
         {
             if(D[j][mmap[i][p]]!=D[j][mmap[i][q]]) {f=0;break;}
         }
         if(f) {return false;}
      }
   }
   return true;
}

void fin_in()
{ int i,t,u,v,nei;

  for(i=1;i<=N;i++) fin[i]=fin2[i]=neib[i][0]=neib[i][1]=0;
  brL=brF=brF2=0;
  for(v=1;v<=N;v++) if(G[v][0]==1)
  {  brL++; nei=G[v][1];
     if(G[nei][0]!=2) {fin[v]=nei;neib[nei][1]++;continue;}
     u=v;
     while(G[nei][0]==2)
     {  if(G[nei][1]==u) t=2; else t=1;
        u=nei;nei=G[nei][t];
     }
     neib[nei][0]++;fin2[v]=nei;
  }
  for(i=1;i<=N;i++)
  { if(neib[i][0]!=0) if(G[i][0]>2) brF2++; else brF++;
    else if(neib[i][1]!=0) brF++;

  }
  return;
}

int main()
{  int TT,T,i,j,u,v,k,res;vector<int> emp;
   scanf("%d",&T);
   for(TT=1;TT<=T;TT++)
   {
      scanf("%d",&N); mmap.reserve(N+1);
      for(i=1;i<=N;i++) {neib[i][0]=neib[i][1]=G[i][0]=fin[i]=0;mmap.push_back(emp);}
      mmap.push_back(emp);
      for(i=1;i<=N-1;i++)
      {  scanf("%d %d",&u,&v);
         G[u][++G[u][0]]=v; G[v][++G[v][0]]=u;
      }
      k=0;
      fin_in();

/*for(i=1;i<=N;i++) printf("%d ",fin[i]); printf("\n");
for(i=1;i<=N;i++) printf("%d ",fin2[i]); printf("\n");
for(i=1;i<=N;i++) printf("%d ",neib[i][0]);printf("\n");
for(i=1;i<=N;i++) printf("%d ",neib[i][1]);printf("\n");
printf("L=%d F2=%d,F=%d\n",brL,brF2,brF);*/
if(brF2!=0) printf("%d\n",brL-brF2);else printf("%d\n",brL-1);
continue;
      for(i=1;i<=N;i++) if(neib[i][0]>1) neib[i][0]--;
      for(i=1;i<=N;i++)
         if(G[i][0]==1)
         { if(fin2[i]==0&&neib[fin[i]][0]==0) {k++;BFS(i,k);}
           else if(neib[fin[i]][0]>0) {neib[fin[i]][0]--;k++;BFS(i,k);}
         }
      int flag=0;
      for(i=1;i<=N;i++)
      {   mmap[D[1][i]].push_back(i); if(mmap[D[1][i]].size()>1) flag=1; }
          if(!flag) {printf("1\n");return 0;}
      k=2;
      for(i=0;i<=N;i++)
      { if(mmap[i].size()<2) continue;
        while(!covered(i,k)) {k++;continue;}
      }
      printf("%d\n",k);
      mmap.clear();
   }
   return 0;
}
