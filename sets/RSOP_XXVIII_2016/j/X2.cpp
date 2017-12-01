/**
   Задача: X
   Решение 2
   Сложност: O(n^2)
*/

#include <iostream>
#include <sstream>
#include <algorithm>
using namespace std;

const int MAXN   = 20000;

int a[MAXN];
int n;

long long count(int x, int i, int j)
{ long long cnt = 0;
  while(i<j)
  { int s = a[i]+a[j];
    if(s<x) i++;
    if(s>x) j--;
    if(s==x)
    { if(a[i]<a[j])
      { int p=i+1; while(a[i]==a[p]) p++;
        int q=j-1; while(a[q]==a[j]) q--;
        cnt = cnt + 1LL*(p-i)*(j-q);
        i = p; j = q;
      }
      else
      { cnt = cnt + 1LL*(j-i+1)*(j-i)/2;
        return cnt;
      }
    }
  }
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

    long long br=0;
    int k=lower_bound(a,a+n,2*a[0]) - a;
    while(k<n)
    { long long s = count(a[k],0,k-1);
      int p=k+1;
      while(p<n and a[k]==a[p]) p++;
      br = br + (p-k)*s;
      k = p;
    }
    cout << br << endl;

    getline(cin,s);
  }

  return 0;
}
