#include <iostream>
#include <cmath>
#include <string>
#include <iomanip>
using namespace std;

struct kor {
    int x, y, v;
    string name;
};

double dist(int x1, int y1, int x2, int y2)
{
    return sqrt(1.0*(x1-x2)*(x1-x2) + (y1-y2)*(y1-y2));
}

int main()
{
    int num;
    cin >> num;
    for (int ii=0; ii<num; ii++)
    {
        int x0, y0;
        cin >> x0 >> y0;
        int n;
        cin >> n;
        kor h, first;
        double mintime, time;
        cin >> first.name >> first.x >> first.y >> first.v;
        mintime = dist(x0, y0, first.x, first.y)/first.v;
//        cout << first.name << " "
//            << setprecision(10) << mintime << endl;
        for (int i=1; i < n; i++)
        {
            cin >> h.name >> h.x >> h.y >> h.v;
            time = dist(x0, y0, h.x, h.y)/h.v;
//            cout <<  h.name << " "
//                << setprecision(10) << time << endl;
            if (time < mintime)
            {
                mintime = time;
                first = h;
            }
        }
        cout << first.name << endl;
    }
	return 0;
}
