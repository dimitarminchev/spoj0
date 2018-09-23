#include <iostream>
#include <vector>
#include <string>
#include <set>
#include <map>
#include <algorithm>
#include <sstream>
#include <queue>
#include <bitset>
#include <utility>
#include <list>
#include <numeric>

#include <cstdio>
#include <cmath>
#include <cctype>
using namespace std;

#define REP(i,n) for(__typeof(n) i=0; i<(n); ++i)
#define FOR(i,a,b) for(__typeof(b) i=a; i<(b); ++i)
#define FOREACH(it,c) for(__typeof((c).begin()) it=(c).begin(); it!=(c).end(); ++it)

typedef long long ll;
typedef pair<ll, int> PI;
vector<ll> primes;
vector<PI> factorize(ll a) {
    vector<PI> r;
    for (unsigned i=0; i<primes.size() && primes[i]*primes[i]<=a; i++)
        if (a%primes[i]==0) {
            int p=0;
            while (a%primes[i]==0) {
                a/=primes[i];
                p++;
            }
            r.push_back(PI(primes[i], p));
        }
    if (a>1) r.push_back(PI(a, 1));
    return r;
}
vector<ll> divisors(vector<PI> fact) {
    vector<ll> res(1, 1);
    for (unsigned i=0; i<fact.size(); i++) {
        int o=res.size();
        for (int j=0; j<fact[i].second*o; j++)
            res.push_back(res[res.size()-o]*fact[i].first);
    }
    return res;
}
ll phi(ll a) {
    ll res=1;
    vector<PI> fact=factorize(a);
    REP(i,fact.size()) {
        res*=fact[i].first-1;
        REP(j,fact[i].second-1)
            res*=fact[i].first;
    }
    return res;
}
int main() {
    vector<bool> p(10000000, true);
    p[0]=p[1]=false;
    for (int i=2; i<10000000; i++) if (p[i]) {
        primes.push_back(i);
        for (int j=2*i; j<10000000; j+=i)
            p[j]=false;
    }

    int t; scanf("%d", &t);
    for (int cases=0; cases<t; cases++) {
        ll n, poc=0;
        cin>>n;
//cout<<n<<endl;
        vector<ll> div = divisors(factorize(n));
        REP(i,div.size())
            poc+=phi(n/div[i]+1);
        cout<<poc<<endl;
    }
}
