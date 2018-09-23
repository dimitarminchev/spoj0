/*
 * primary_root.cpp
 *
 *  Created on: Apr 10, 2015
 *      Author: istrandjev
 */

#define _CRT_SECURE_NO_DEPRECATE
#include <iostream>
#include <string>
#include <vector>
#include <sstream>
#include <queue>
#include <algorithm>
#include <iomanip>
#include <map>
#include <set>
#include <math.h>
#include <stack>
#include <deque>
#include <numeric>
#include <cstring>
#include <cstdio>
#include <cstdlib>
#include <bitset>
#include <functional>
#define mpair make_pair
#define all(v) v.begin(),v.end()
using namespace std;
typedef long long ll;
typedef long double ld;
const ld epsylon = 1e-9;

const std::string PROGRAM_NAME = "mul_order";

const int size = 1000000;
vector<int> devs(size + 1, 1);
void compute_devs() {
  int o = sqrt((ld) size);
  for (int i = 2; i <= size; i += 2) {
    devs[i] = 2;
  }

  for (int i = 3; i <= size; i += 2) {
    if (devs[i] != 1) {
      continue;
    }
    devs[i] = i;
    if (i <= o) {
      for (int j = i * i; j < size; j += 2 * i) {
        devs[j] = i;
      }
    }
  }
}

int evkl(int a, int b) {
  int r;
  if (a == 0) {
    return b != 0 ? b : 1;
  }
  if (b == 0) {
    return a;
  }
  while (a % b) {
    r = a % b;
    a = b;
    b = r;
  }
  return b;
}

int phi(int x) {
  int last_dev = 1;
  int result = x;
  while (x != 1) {
    if (devs[x] != last_dev) {
      result /= devs[x];
      result *= devs[x] - 1;
      last_dev = devs[x];
    }
    x /= devs[x];
  }
  return result;
}


ll stepen(ll x, ll y, ll mod) {
  ll res = 1;
  ll p = x;
  while (y) {
    if (y % 2) {
      res = (res * p) % mod;
    }
    p = (p * p) % mod;
    y /= 2;
  }
  return res;
}

int primitiveRoot(int x, int y) {
  if (evkl(x, y) != 1) {
    return 0;
  }

  int phi_value = phi(y);
  int primitive_root = 1;
  int current = phi_value;
  while (current > 1) {
    int d = devs[current];
    while (current % d == 0) {
      int next = current / d;
      if (stepen(x, next, y) != 1) {
        break;
      }
      current = next;
    }
    while (current % d == 0) {
      primitive_root *= d;
      current /= d;
    }
  }
  return primitive_root;
}

int main() {
  // freopen((PROGRAM_NAME + ".in").c_str(), "r", stdin);
  // freopen((PROGRAM_NAME + ".out").c_str(), "w", stdout);
  compute_devs();

  int nt;
  cin >> nt;
  for (int it = 0; it < nt; ++it) {
    int a, from, to;
    scanf("%d %d %d", &a, &from, &to);
    long long ans = 0;
    for (int i = from; i <= to; ++i) {
      ans += (ll)primitiveRoot(a, i);
    }
    cout << ans << endl;
  }

  return 0;
}


