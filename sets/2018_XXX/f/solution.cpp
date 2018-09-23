#include <stdio.h>
#define MAXN 1000000
using namespace std;

int a[MAXN], s[MAXN+1];

int main() {
	int n;
	scanf("%d", &n);
	while(n>0) {
		int ind = n-1, sum = 0, minsum = 0;
		bool all_positive = true;
		for (int i=0; i<n; ++i) {
			scanf("%d", &a[i]);
			sum += a[i];
			if (a[i] < 0)
				all_positive = false;
			if (sum <= minsum) {
				minsum = sum;
				ind = i;
			}
		}

		if (all_positive)
			printf("%d\n", n);
		else if (sum < 0)
			puts("0");
		else {
			int l = 0;
			sum = 0;
			for (int i=0; i<n; ++i) {
				if (++ind == n) ind = 0;
				sum += a[ind];
				while(l && s[l-1] > sum) --l;
				s[l++] = sum;
			}
			printf("%d\n", l);
		}
	scanf("%d", &n);
	}
	return 0;
}
