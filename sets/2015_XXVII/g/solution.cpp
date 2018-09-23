#include <iostream>
#include <vector>
#include <algorithm>
using namespace std;

bool my (int i, int j) { return (i > j); }

int n, m, suma, sumb, maxa;
vector<int> a(100), b(100);

void printa()
{
    cout << "a ";
    for (int i=0; i< n; i++) cout << a[i] << " ";
    cout << endl;
}

void printb()
{
    cout << "b ";
    for (int j=0; j< m; j++) cout << b[j] << " ";
    cout << endl;
}

bool solve()
{
    if (suma > sumb) return false;
    if (maxa > m) return false;

    sort(a.begin(), a.begin() + n, my);
    for (int i = 0; i < n; i++)
    {
        sort(b.begin(), b.begin() + m, my);
//        cout << i << " " << a[i] << endl; printb();
        for (int j=m-1; j >= 0 && b[j] == 0; j--) m--;
        if (m == -1) return false;
        for (int j=0; j < m && j < a[i]; j++)
        {
            b[j]--; suma--;
        }
//        printb(); cout << endl;
    }
    if (suma == 0) return true;
    else return false;
}

void read()
{
    suma = 0; maxa = 0;
    cin >> n;
    for (int i=0; i < n; i++)
    {
        cin >> a[i]; suma += a[i];
        if (a[i] > maxa) maxa = a[i];
    }
    sumb = 0;
    cin >> m;
    for (int j = 0; j < m; j++)
    {
        cin >> b[j]; sumb += b[j];
    }
//    printa(); printb(); cout << endl;
}

int main()
{
    int num;
    cin >> num;
    for (int k=0; k < num; ++k)
    {
        read();
        cout << (solve()?"yes":"no") << endl;
        }
        return 0;
}
