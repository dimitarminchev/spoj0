#include <stdlib.h>
#include <iostream>

#define MAX 100010
using namespace std;

    typedef struct card
            {
             int l, h, sum;
            } card;

int cmpsum(const void *a, const void *b)
    {
     return ((card *)a)->sum - ((card *)b)->sum;
    }

card K[MAX];
int  N;
int  SUM;

void ReadData(void)
     {
     int i, a, b;
     cin >> N;
     for(i = 0; i < N; i++)
        {
         cin >> a >> b;
         K[i].l = (a < b) ? a : b;
         K[i].h = (a > b) ? a : b;
         K[i].sum = a + b;
        }
}

int main(void)
{
    int i,brt;
    cin>>brt;
    for(int j=0;j<brt;j++)
    {
     ReadData();
     qsort(K, N, sizeof(card), cmpsum);
     for (i = 0; i < N/2; i++)
        SUM += K[i].l - K[N/2 + i].h;
     cout << SUM << endl;
     SUM = 0;
    }
    return 0;
}
