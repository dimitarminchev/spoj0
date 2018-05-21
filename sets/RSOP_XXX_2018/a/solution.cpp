/*
 * foobar2.cpp
 *
 *  Created on: Nov 12, 2017
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

const std::string PROGRAM_NAME = "foobar2";

const int LIMIT_THREE = 6;
const int LIMIT_FIVE = 4;

bool check_fives(const vector<int>& fives) {
  vector<int> expected;
  for (int i = 5; i < 625 * 5; i += 5) {
    int temp = i;
    int cnt = 0;
    while (temp % 5 == 0) {
      temp /= 5;
      cnt++;
    }
    expected.push_back(cnt);
  }
  for (int i = 0; i < 666; ++i) {
    bool good = true;
    for (int j = 0; j < (int)fives.size(); ++j) {
      if (expected[i + j] >= LIMIT_FIVE) {
        if (fives[j] < LIMIT_FIVE) {
          good = false;
          break;
        }
      } else if (expected[i + j] != fives[j]) {
        good = false;
        break;
      }
    }
    if (good) {
      return true;
    }
  }
  return false;
}

bool good(const vector<int>& fives, const vector<pair<int, int> >& a) {
  if ((int)fives.size() >= 430) {
    return false;
  }

  int over_limit5 = 0;
  for (int i = 0; i < (int)a.size(); ++i) {
    if (a[i].first == 5 && a[i].second > LIMIT_FIVE) {
      over_limit5++;
    }
  }

  if (over_limit5 > 1) {
    return false;
  }
  if (!check_fives(fives)) {
    return false;
  }
  vector<int> troiki;
  for (int i = 3; i < 729 * 3; i += 3) {
    int temp = i;
    int cnt = 0;
    while (temp % 3 == 0) {
      temp /= 3;
      cnt++;
    }
    troiki.push_back(cnt);
  }


  int fifteen[8] = {3, 5, 3, 3, 5, 3, 3, 5};
  for (int ind15 = 0; ind15 < 7; ++ind15) {
    for (int st3 = 0; st3 < 729; ++st3) {
      bool good = true;
      int position = ind15;
      int position3 = st3;
      int left_limit3 = 1;
      for (int i = 0; i < (int)a.size(); ++i) {
        if (fifteen[position] != a[i].first) {
          good = false;
          break;
        }

        if (fifteen[position] == 5) {
          position = (position + 1) % 8;
          continue;
        }

        if (i + 1 == (int)a.size()) {
          if (a[i].second == troiki[position3]) {
            continue;
          }
          if (a[i].second > LIMIT_THREE && troiki[position3] >= LIMIT_THREE) {
            if (left_limit3) {
              continue;
            } else {
              good = false;
              break;
            }
          }
          if (position == 2 || position == 5) {
            if (a[i].second == troiki[position3] + troiki[position3 + 1]) {
              continue;
            } else if (a[i].second > LIMIT_THREE
                && troiki[position3 + 1] >= LIMIT_THREE) {
              if (left_limit3) {
                continue;
              } else {
                good = false;
                break;
              }
            } else {
              good = false;
              break;
            }
          } else {
            good = false;
            break;
          }
        }
        if (position == 0 || position == 6 || position == 3) {
          if (troiki[position3] >= LIMIT_THREE) {
            if (a[i].second < LIMIT_THREE) {
              good = false;
              break;
            } else {
              if (a[i].second > LIMIT_THREE) {
                if (left_limit3) {
                  left_limit3--;
                } else {
                  good = false;
                  break;
                }
              }
              position3++;
              position++;
              continue;
            }
          } else {
            if (troiki[position3] != a[i].second) {
              good = false;
              break;
            } else {
              position3++;
              position++;
              continue;
            }
          }
        }

        if (position == 2 || position == 5) {
          if (troiki[position3] >= LIMIT_THREE
              || troiki[position3 + 1] >= LIMIT_THREE) {
            if (a[i].second <= LIMIT_THREE) {
              good = false;
              break;
            } else {
              if (a[i].second > LIMIT_THREE + 1) {
                if (left_limit3) {
                  left_limit3--;
                } else {
                  good = false;
                  break;
                }
              }
              position3 += 2;
              position += 2;
            }
          } else {
            if (a[i].second != troiki[position3] + troiki[position3 + 1]) {
              good = false;
              break;
            } else {
              position3 += 2;
              position += 2;
            }
          }
        }
      }
      if (good) {
        return true;
      }
    }
  }
  return false;
}

int main() {
//  freopen((PROGRAM_NAME + ".in").c_str(), "r", stdin);
//  freopen((PROGRAM_NAME + ".out").c_str(), "w", stdout);

  int nt;
  cin >> nt;
  char buf[5];
  for (int it = 0; it < nt; ++it) {
    int n;
    scanf("%d", &n);
///    cout << it << " "<< n << endl;
    vector<pair<int, int> > b;
    vector<int> fives;
    int current_value = -1;
    int current_number;
    for (int i = 0; i < n; ++i) {
      scanf("%s", buf);
      int value;
      if (strcmp(buf, "foo") == 0) {
        value = 3;
      } else {
        value = 5;
      }

      if (current_value == -1) {
        current_value = value;
        current_number = 1;
      } else if (value == current_value) {
        current_number++;
      } else {
        b.push_back(mpair(current_value, current_number));
        if (current_value == 5) {
          fives.push_back(current_number);
        }
        current_value = value;
        current_number = 1;
      }
    }
    b.push_back(mpair(current_value, current_number));

//    for (int i = 0; i < (int)b.size(); ++i) {
//      printf("%d: %d %d\n", i, b[i].first, b[i].second);
//    }
    if (current_value == 5) {
      fives.push_back(current_number);
    }

    if (good(fives, b)) {
      cout << "Yes\n";
    } else {
      cout << "No\n";
    }
    fflush(stdout);

  }

  return 0;
}

