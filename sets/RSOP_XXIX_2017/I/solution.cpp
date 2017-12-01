#include <iostream>
#include <string>

using namespace std;

int main()
{
    int t;
    cin>>t;
    for (int tt=0; tt<t; tt++) {
        string s; int cnt = 0;
        cin>>s;
        for (int i=s.size()-1; i>=0; i--){
            if (s[i]=='0')cnt++;
            else break;}
        cout<<"1";
        if (cnt>0) for (int i=0; i<cnt; i++)cout<<"0"; cout<<endl;
    }
	return 0;
}
