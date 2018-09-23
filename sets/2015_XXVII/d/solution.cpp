/*
 * war.cpp
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

const std::string PROGRAM_NAME = "war";

int value[256];

void initValues() {
  for (char c = '2'; c <= '9'; ++c) {
    value[(int)c] = c - '0';
  }
  value['T'] = value['t'] = 10;
  value['J'] = value['j'] = 11;
  value['Q'] = value['q'] = 12;
  value['K'] = value['k'] = 13;
  value['A'] = value['a'] = 14;
}

int play(deque<int>& a, deque<int>& b) {
  for (int moves = 0; moves < 10000 && !a.empty() && !b.empty(); ++moves) {
    int ac = a.front();
    a.pop_front();
    int bc = b.front();
    b.pop_front();
    if (ac != bc) {
      if (ac < bc) {
        b.push_back(ac);
        b.push_back(bc);
      } else {
        a.push_back(ac);
        a.push_back(bc);
      }
    } else {
      deque<int> ha, hb;
      ha.push_back(ac);
      hb.push_back(bc);
      while (ha.back() == hb.back()) {
        if (a.size() < 3 || b.size() < 3) {
          break;
        }
        for (int i = 0; i < 3; ++i) {
          ha.push_back(a.front());
          a.pop_front();
          hb.push_back(b.front());
          b.pop_front();
        }
      }
      if (ha.back() == hb.back()) {
        for (int i = 0; i < (int)ha.size(); ++i) {
          a.push_back(ha[i]);
          b.push_back(hb[i]);
        }
      } else {
        if (ha.back() < hb.back()) {
          for (int i = 0; i < (int)ha.size(); ++i) {
            b.push_back(ha[i]);
          }
          for (int i = 0; i < (int)hb.size(); ++i) {
            b.push_back(hb[i]);
          }
        } else  {
          for (int i = 0; i < (int)ha.size(); ++i) {
            a.push_back(ha[i]);
          }
          for (int i = 0; i < (int)hb.size(); ++i) {
            a.push_back(hb[i]);
          }
        }
      }
    }
  }
  if (a.empty()) {
    return 2;
  }
  if (b.empty()) {
    return 1;
  }

  return 0;
}

int main() {
  // freopen((PROGRAM_NAME + ".in").c_str(), "r", stdin);
  // freopen((PROGRAM_NAME + ".out").c_str(), "w", stdout);

  initValues();
  int nt;
  cin >> nt;
  for (int it = 0; it < nt; ++it) {
    int n, m;
    char buf[4];
    scanf("%d", &n);
    deque<int> mimmy(n);
    for (int i = 0; i < (int)mimmy.size(); ++i) {
      scanf("%s", buf);
      mimmy[i] = value[(int)buf[0]];
    }

    scanf("%d", &m);
    deque<int> ivo(m);
    for (int i = 0; i < (int)ivo.size(); ++i) {
      scanf("%s", buf);
      ivo[i] = value[(int)buf[0]];
    }

    int res = play(mimmy, ivo);
    if (res == 1) {
      printf("Mimmy\n");
    } else if (res == 2) {
      printf("Ivo\n");
    } else {
      printf("Tie\n");
    }
  }
  return 0;
}

