#include <stdio.h>
int main()
{  double Av, New, cnt; unsigned a;
   scanf("%d",&a); Av=(double)a; cnt = 1;
   while(scanf("%d",&a)!=EOF)
   {  New=(double)a; //printf("%.5f\n",New);
      Av=Av*cnt/(cnt+1) + New/(cnt+1); cnt++;
   }
   printf("%.5f\n",Av);
}
