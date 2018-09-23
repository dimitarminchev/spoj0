#include <iostream>
#include <algorithm>
using namespace std;

int n, k, prices[100001];
long long paid;

int main(){

	int tests;

	cin >> tests;

	for(int t = 0; t < tests; t++){

		cin >> n >> k;

		paid = 0;
		for(int i = 0; i < n; i++){
			cin >> prices[i];
			paid += prices[i];
		}

		sort(prices,prices+n);

		int br = 1;
		for(int i = n-1; i >= 0; i--){
			if(br % k == 0)
				paid -= prices[i];
			br++;
		}

		cout << paid << endl;
	}

	return 0;
}
