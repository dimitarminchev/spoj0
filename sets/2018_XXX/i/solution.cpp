#include <stdio.h>
#include <cmath>
using namespace std;
#define MAXN 1000001

int Tb[MAXN][24],TB[MAXN][24];

int RMinQ(int i,int j)
{ int a,b;
  double l=(double)j-i+1;
  l= log2(l);
  int k = l;
  if(k==l) return Tb[i][k];
  a=Tb[i][k];
  b=Tb[j-(1<<k)+1][k];
  return (a<=b?a:b);
}

int RMaxQ(int i,int j)
{int a,b;
  double l=(double)j-i+1;
  l= log2(l);
  int k = l;
  if(k==l) return TB[i][k];
  a=TB[i][k];
  b=TB[j-(1<<k)+1][k];
  return (a>=b?a:b);

}

int main()
{ int T,i,j,k,n,t;
  int pgb,pge,wb,we,gmax;
  scanf("%d",&T);
  while(T--)
  { scanf("%d %d",&n,&t);
    for(i=1;i<=n;i++) { scanf("%d",&Tb[i][0]);TB[i][0]=Tb[i][0]; }
    for(i=1,k=1;i<n;i=i*2,k++)
    {  j=1;
       while(j+2*i-1<=n)
       {  TB[j][k]=(TB[j][k-1]>=TB[j+i][k-1]?TB[j][k-1]:TB[j+i][k-1]);
          Tb[j][k]=(Tb[j][k-1]<=Tb[j+i][k-1]?Tb[j][k-1]:Tb[j+i][k-1]);
          j++;
       }
    }
    gmax=1;pgb=pge=0;wb=we=0;
    while(we<n-1)
    { while(RMaxQ(wb,we+1)-RMinQ(wb,we+1)<=t) {we++;continue;}
      if(we-wb+1>gmax) {gmax=we-wb+1;pgb=wb;pge=we;}
      while(RMaxQ(wb,we+1)-RMinQ(wb,we+1)>t) {wb++;continue;}
    }
    printf("%d\n",gmax);
  }
}
