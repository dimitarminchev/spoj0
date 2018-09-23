#include<iostream>
#include<stdlib.h>
using namespace std;


long int X[4][3];
long int a[4];
long int b[4];

void input()
{
   cin >> X[1][1] >> X[1][2] >> X[2][1] >> X[2][2] >> X[3][1] >> X[3][2];
   cin >> a[1] >> a[2] >> a[3];
   cin >> b[1] >> b[2] >> b[3];
}

void trans()
{
   for(int i=1;i<=3;i++)
   {  X[i][2]=X[i][2]-X[i][1];
      a[i]=a[i]-X[i][1]; b[i]=b[i]-X[i][1];
      X[i][1]=0;
   }
}

void rot(int k)
{  int i,j,w;
   switch(k)
   {
      case 1: i=2; j=3; break;
      case 2: i=1; j=3; break;
      case 3: i=1; j=2; break;
    }

  w=a[i]; a[i]=X[j][2]-a[j]; a[j]=w;
  w=b[i]; b[i]=X[j][2]-b[j]; b[j]=w;
  w=X[i][2]; X[i][2]=X[j][2]; X[j][2]=w;
}

void show()
{  cout << '\n' << "a: " << a[1] << ' '<< a[2] << ' ' << a[3] << '\n';
   cout << '\n' << "b: " << b[1] << ' '<< b[2] << ' ' << b[3] << '\n';
}

void adown()
{  if(a[3]==0) return;
   rot(1); if(a[3]==0) return;
   rot(1); if(a[3]==0) return;
   rot(1); if(a[3]==0) return;
   rot(2); if(a[3]==0) return;
   rot(2); if(a[3]==0) return;
   rot(2);  if(a[3]==0) return;
}

int brot()
{  if((b[1]==0)&&(b[3]!=X[3][2])) return 1;
   rot(3); if((b[1]==0)&&(b[3]!=X[3][2])) return 1;
   rot(3); if((b[1]==0)&&(b[3]!=X[3][2])) return 1;
   rot(3); if((b[1]==0)&&(b[3]!=X[3][2])) return 1;
   return 0;
}

long int d(long int x1, long int y1, long int x2, long int y2)
{  return (x1-x2)*(x1-x2) + (y1-y2)*(y1-y2); }

void compute()
{  int m, m1;
   m = d(a[1],a[2],-b[3]-b[1],b[2]);
   m1 = d(a[1],a[2],X[1][2]+b[3]+X[1][2]-b[1],b[2]);
   if(m1<m) m=m1; m1 = d(a[1],a[2],b[1],-b[3]-b[2]);
   if(m1<m) m=m1; m1 = d(a[1],a[2],b[1],X[2][2]+b[3]+X[2][2]-b[2]);
   if(m1<m) m=m1;
   cout << m << endl;
}

int notcheck()
{  if(!((0<=b[3])&&(b[3]<=X[3][2])&&
        (0<=b[2])&&(b[2]<=X[2][2])&&
        (0<=b[1])&&(b[1]<=X[1][2]))) return 1;
   if(!((0<=a[3])&&(a[3]<=X[3][2])&&
        (0<=a[2])&&(a[2]<=X[2][2])&&
        (0<=a[1])&&(a[1]<=X[1][2]))) return 1;
   if( ((0<b[3])&&(b[3]<X[3][2])&&
        (0<b[2])&&(b[2]<X[2][2])&&
        (0<b[1])&&(b[1]<X[1][2]))) return 1;
   if( ((0<a[3])&&(a[3]<X[3][2])&&
        (0<a[2])&&(a[2]<X[2][2])&&
        (0<a[1])&&(a[1]<X[1][2]))) return 1;
   return 0;
}


int main()
{  int t,T;
   cin >> T;
for(t=1;t<=T;t++)
{   
   input();
   // show();
   trans();
   if(notcheck()) { cout << "-1\n"; continue; }
   // show();
   adown();
   if(a[3]!=0){ cout << "-1\n";  continue;}
   if(b[3]==0) cout << d(a[1],a[2],b[1],b[2])<< endl;
   else if(brot())
   { //show();
     if(!((0<=b[3])&&(b[3]<=X[3][2])&&
	      (0<=b[2])&&(b[2]<=X[2][2]))) 
     { cout << "-1\n"; continue;}
     cout << d(a[1],a[2],-b[3],b[2]) << endl;
   }
   else
   {
     if(b[3]!=X[3][2]){cout << "-1\n"; continue;}
     compute();
   }
}
   
}
