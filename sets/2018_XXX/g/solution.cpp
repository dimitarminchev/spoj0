#include <iostream>
#include <string>
using namespace std;

int main()
{    string s;
    while(cin >> s)
    {
        int max0 = 0, max1 = 0;
        int i0 = 0, i1 = 0;
        for(int i = 0; i < s.length(); i++)
        {
            if (s[i] == '0') i0++;
            else
            {
                if (i0 > max0) max0 = i0;
                i0 = 0;
            }
            if (s[i] == '1') i1++;
            else
            {
                if (i1 > max1) max1 = i1;
                i1 = 0;
            }
        }
        if (i0 > max0) max0 = i0;
        if (i1 > max1) max1 = i1;
        cout << max0 << " " << max1 << endl;
    }
    return 0;
}
