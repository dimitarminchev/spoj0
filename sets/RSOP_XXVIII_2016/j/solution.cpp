/**
   Задача: X
   Решение 1
   Сложност: O(n^2)
*/

#include <iostream>
#include <sstream>
#include <cstring>
using namespace std;

const int MAXN   = 20000;
const int MAXVAL = 100000000;

int a[MAXN];
int b[MAXVAL];
int n;

int main()
{ string s;
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

    memset(b,0,sizeof(b));
    for(int i=0; 2*a[i]<=a[n-1]; i++)
     for(int j=i+1; a[i]+a[j]<=a[n-1]; j++)
       b[a[i]+a[j]]++;

    long long br=0;
    for(int k=2; k<n; k++)
      br = br + b[a[k]];
    cout << br << endl;

    getline(cin,s);
  }

  return 0;
}
