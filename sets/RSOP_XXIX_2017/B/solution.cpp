/*
 * cake.cpp
 *
 *  Created on: Apr 17, 2017
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

ll evkl_ex(ll a, ll b, ll& x, ll& y) {
  if (b == 0) {
    x = 1; y = 0;
    return a;
  }
  ll x1, y1;
  ll d = evkl_ex(b, a % b, x1, y1);
  x = y1;
  y = x1 - y1 * (a / b);
  return d;
}

pair<ll, ll> solve(ll a, ll b, ll k) {
  ll u, v;
  ll d = evkl_ex(a, b, u, v);
  if (k % d != 0) {
    return mpair(-1, -1);
  }

  ll m = k / d;
  u = u * m;
  v = v * m;
  ll nok = (a * b) / d;
  if (u <= 0 || v > 0) {
    ll u_factor = (-u) / (nok / a) + 1;
    ll v_factor = v / (nok / b);
    if (v > 0 && v % (nok / b)) {
      v_factor++;
    }
    ll factor = max(v_factor, u_factor);
    u += factor * (nok / a);
    v -= factor * (nok / b);
  }
  ll u_factor = u / (nok / a);
  if (u % (nok / a) == 0) {
    u_factor--;
  }
  ll v_factor = (-v) / (nok / b);
  ll factor = min(v_factor, u_factor);
  u -= factor * (nok / a);
  v += factor * (nok / b);
  return mpair(u, -v);
}

int main() {
  ios_base::sync_with_stdio(false);
  int nt;
  cin >> nt;
    for (int it = 0; it < nt; ++it) {
    int a, b, d;
    cin >> a >> b >> d;
    pair<ll, ll> res = solve(a, b, d);
    if (res.first == -1) {
      cout << "IMPOSSIBLE" << endl;
    } else {
      cout << res.first << " " << res.second << endl;
    }
  }
  return 0;
}



