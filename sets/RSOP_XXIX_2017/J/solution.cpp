#include <bits/stdc++.h>

int main()
{
    int t;
    scanf ("%i", &t);
    for (int tt=0; tt<t; tt++) {
        unsigned long long paths = 1;
        int N;
        scanf ("%i",&N);

        for (int i = 0; i < N; i++)
        {
            paths *= (2 * N) - i;
            paths /= i + 1;
        }

        printf ("%llu\n",paths);
    }
}
