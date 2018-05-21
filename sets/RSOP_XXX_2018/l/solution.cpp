#include <iostream>
#include <vector>
#include <cmath>
#include <numeric>
#include <algorithm>


using namespace std;

const long long MAXN = 10000001;

vector<long long>  vPrimeNumbers;

void getPrimes(std::vector<long long> & primeNumbers)
{
	primeNumbers.clear();
	bool* isPrime = new bool[MAXN];
	for (unsigned int i = 0; i < MAXN; i++)
		isPrime[i] = true;

	for (unsigned long long i = 2; i < MAXN; i++)
	{
		if (isPrime[i]) {
			primeNumbers.push_back(i);
			for (unsigned long long j = i*i; j < MAXN; j += i)
				isPrime[j] = false;

		}
	}

	delete[] isPrime;

}


void factorize(long long a, vector<pair<long long, long long> > & vRes) {
	vRes.clear();
	long long llCurrA = a;
	long long lsqrt = sqrt(llCurrA) + 1;
	for (long long i = 0; llCurrA > 1 && i < vPrimeNumbers.size(); i++) {
		if (vPrimeNumbers[i] > lsqrt)
			break;
		if (llCurrA % vPrimeNumbers[i] == 0) {
			int nPower = 2;
			llCurrA /= vPrimeNumbers[i];
			while (llCurrA % vPrimeNumbers[i] == 0) {
				nPower++;
				llCurrA /= vPrimeNumbers[i];
			}
			vRes.push_back(make_pair(vPrimeNumbers[i], nPower));
		}
	}

	if (llCurrA > 1)
		vRes.push_back(make_pair(llCurrA, 2));
}

long long CountCommonDivisors(vector<pair<long long, long long> > & factorsA,
	vector<pair<long long, long long> > & factorsB) {

	long long nRes = 1;
	int nIndexA = 0;
	int nIndexB = 0;
	while (nIndexA < factorsA.size() && nIndexB < factorsB.size()) {
		long long nCurrAFactor = factorsA[nIndexA].first;
		long long nCurrBFactor = factorsB[nIndexB].first;

		if (nCurrAFactor < nCurrBFactor)
			nIndexA++;
		else if (nCurrAFactor > nCurrBFactor)
			nIndexB++;
		else {
			nRes *= min(factorsA[nIndexA].second,
				factorsB[nIndexB].second);
			nIndexA++;
			nIndexB++;
		}
	}

	return nRes;
}

	vector<pair<long long, pair<long long, long long> > > vSequence;
	vector<vector<pair<long long, long long> > > vFactors(320);
	vector<long long> vNumbers(320);

int main(int nArgc, char ** ppchArgv)
{getPrimes(vPrimeNumbers);
 int T;
 cin >> T;
 while(T--)
 {
	int N;
	cin >> N;

	for (int i = 0; i < N; i++) {
		long long a;
		cin >> a;

		vNumbers[i] = a;
		factorize(a, vFactors[i]);

	}

	for (int i = 0; i < N - 1; i++) {
		for (int j = i + 1; j < N; j++) {
			vSequence.push_back(make_pair(CountCommonDivisors(vFactors[i],
				vFactors[j]), make_pair(min(vNumbers[i], vNumbers[j]),
					max(vNumbers[i], vNumbers[j]))));
		}
	}


	sort(vSequence.begin(), vSequence.end());
	for (int i = 0; i < vSequence.size(); i++)
		cout << vSequence[i].second.first
			<< " " << vSequence[i].second.second << endl;


 }
	return 0;
}

