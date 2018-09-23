#include <stdio.h>
int P,Q;
int drive[10],dL; char line[180];
void prdrive()
{  int i,j,b=0,e;
   for(i=0;i<dL;i++)
   { e=b+drive[i];
     if(i%2==0)  for(j=b;j<e;j++) {line[j]=' ';/*printf("space\n");*/}
     else for(j=b;j<e;j++) {line[j]='*';/*printf("asterisk\n");*/}
     b=e;
   }
   line[b]='\0';printf("%s\n",line);
}

int main()
{
   int t,Pb,Qb,a,b,c,d,i,j;

   scanf("%d",&t);
   while(t--)
   {
      scanf("%d %d",&P,&Q);Pb=2*P-1;Qb=2*Q-1;
      if(P==Q)
      { a=(Pb-1)/2;b=(3*Pb-1)/2;
        drive[0]=a;drive[1]=Pb;dL=2;prdrive();
        b=a-1;c=1;d=Pb-4;
        for(i=a-1;i>0;i--)
        { drive[0]=b;drive[1]=drive[3]=drive[5]=drive[7]=1;
          drive[2]=drive[6]=c;drive[4]=d;dL=8;prdrive();
          b--;c+=2;d-=2;
        }
        drive[0]=0;drive[1]=2*Pb-1;dL=2;prdrive();
      }
      else if(P>Q)
      {
        drive[0]=P-1;drive[1]=drive[3]=1;drive[2]=2*P-3;dL=4;prdrive();
        a=P-2;b=2*P-5;c=1;d=Pb-4;
        for(i=P-1;i>Q;i--)
        { drive[0]=a;drive[1]=drive[3]=drive[5]=drive[7]=1;
          drive[2]=drive[6]=c;drive[4]=b;dL=8;prdrive();
          a--;b-=2;c+=2;
        }
        drive[0]=a;drive[1]=drive[5]=1;drive[2]=drive[4]=c;
        drive[3]=b+2;dL=6;prdrive();
        a--;b-=2;c+=2;
        for(i=Q-1;i>1;i--)
        { drive[0]=a;drive[1]=drive[3]=drive[5]=drive[7]=1;
          drive[2]=drive[6]=c;drive[4]=b;dL=8;prdrive();
          a--;b-=2;c+=2;
        }
        drive[0]=0;drive[1]=2*Pb-1;dL=2;prdrive();
      }
      else
      {
         if(Qb>2*Pb-1)
         { drive[0]=0;drive[1]=Qb;dL=2;prdrive();
           a=1;b=Qb-4;
           for(i=Q-1;i>=P;i--)
           { drive[0]=a;drive[1]=drive[3]=1;drive[2]=b;dL=4;prdrive();
             a++;b-=2;
           }
           a-=2;c=1;
           for(i=P-1;i>1;i--)
           { drive[0]=a;drive[1]=drive[3]=drive[5]=drive[7]=1;
             drive[2]=drive[6]=c;drive[4]=b;dL=8;prdrive();
             a--;b-=2;c+=2;
           }
           drive[0]=(Qb-2*Pb+1)/2;drive[1]=2*Pb-1;dL=2;prdrive();
         }
         else
         {
            drive[0]=(2*Pb-1-Qb)/2;drive[1]=Qb;dL=2;prdrive();
            a=(2*Pb-1-Qb)/2+1;b=Qb-4;
            for(i=Q-1;i>=P;i--)
            { drive[0]=a;drive[1]=drive[3]=1;drive[2]=b;dL=4;prdrive();
              a++;b-=2;
            }
            a-=2;c=1;
            for(i=P-1;i>1;i--)
            { drive[0]=a;drive[1]=drive[3]=drive[5]=drive[7]=1;
              drive[2]=drive[6]=c;drive[4]=b;dL=8;prdrive();
              a--;c+=2;b-=2;
            }
            drive[0]=0;;drive[1]=2*Pb-1;dL=2;prdrive();


         }
      }
   }
}

