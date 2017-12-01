#include <bits/stdc++.h>
using namespace std;
#define null NULL
#define mp make_pair
#define pb(a) push_back(a)
#define sz(a) ((int)(a).size())
#define all(a) a.begin() , a.end()
#define fi first
#define se second
#define relaxMin(a , b) (a) = min((a),(b))
#define relaxMax(a , b) (a) = max((a),(b))
#define SQR(a) ((a)*(a))
#define PI 3.14159265358979323846
typedef vector<int> vi;
typedef pair<int,int> pii;
typedef long long ll;

const int UP = 1E6 + 10;

bool not_prime[UP];
vi primes;

ll SumDivisors(const vector<ll>& del, const vi& deg){
  ll res = 1;
  for(int i = 0;i < sz(del);++i){
    ll mult = 1;
    for(int j = 0;j < deg[i];++j)
      mult = mult * del[i] + 1;
    res *= mult;
  }
  return res;
}

map<ll, int> Factor(ll w){
  map<ll, int> del;

  for(int e : primes){
    if(e > w) break;
    while(w % e == 0) w /= e, ++del[e];
  }

  if(w > 1){
    ll t = sqrt(w);
    while(SQR(t) > w) --t;
    while(SQR(t + 1) <= w) ++t;
    if(SQR(t) == w) del[t] += 2;
  }

  return del;
}

ll Doit(ll w){
  vector<ll> del;
  vi deg;
  auto factors = Factor(w);
  for(const auto& e : factors)
    if(e.se > 1)
      del.pb(e.fi), deg.pb(e.se / 2);
  return SumDivisors(del, deg);
}

// Stupid solution
ll SolveStupid(ll w){
  ll res = 0;
  for(ll i = 1;i <= w;++i)
    if(w % SQR(i) == 0)
      res += i;
  return res;
}

int main(){
  ios_base::sync_with_stdio(false);

  for(int i = 2;i < UP;++i)
    if(!not_prime[i]){
      primes.pb(i);
      for(int j = i + i;j < UP;j += i)
        not_prime[j] = true;
    }

  /*
  for(int i = 1;i < 100000;++i){
    if(i % 500 == 0) cout << i << endl;
    if(SolveStupid(i) != Doit(i))
      cout << "BAD\n";
  }
  */
  int q;
  cin >> q;
  while(q-- > 0){
    ll w;
    cin >> w;
    cout << Doit(w) << '\n';
  }

  return 0;
}
