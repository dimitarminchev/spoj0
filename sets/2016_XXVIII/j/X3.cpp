/**
   Задача: X
   Решение 3
   Сложност: O(n^2)
*/

#include <iostream>
#include <sstream>
#include <algorithm>
using namespace std;

const int MAXN   = 20000;

int a[MAXN];
int c[MAXN];
int n;

long long count(int x, int i, int j)
{ long long cnt = 0;
  while(i<j)
  { int s = a[i]+a[j];
    if(s<x) i++;
    if(s>x) j--;
    if(s==x)
    { cnt = cnt + 1LL*c[i]*c[j];
      i++; j--;
    }
  }
  if(2*a[i]==x) cnt = cnt + 1LL*c[i]*(c[i]-1)/2;
  return cnt;
}

int main()
{
  string s;
  getline(cin,s);

  while(cin.good())
  { n = 0;
    stringstream ss(s,ios_base::in);
    while(ss.good()) ss >> a[n++];

/*
    cout << a[0];
    for(int i=1; i<n; i++)
      cout << " " << a[i];
    cout << endl;
*/

    int m=0; // брой различни числа
    int i=0;
    while(i<n)
    { int j=i+1;
      while(j<n and a[i]==a[j]) j++;
      a[m]=a[i]; c[m]=j-i; m++;
      i = j;
    }
    n = m;

    long long br=0;
    int k0=lower_bound(a,a+n,2*a[0]) - a;
    for(int k=k0; k<n; k++)
      br = br + c[k]*count(a[k],0,k-1);
    printf("%lld\n",br);

    getline(cin,s);
  }

  return 0;
}
