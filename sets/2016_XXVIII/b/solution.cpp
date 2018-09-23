#include <iostream>
#include <string>
#include <algorithm>
#include <vector>
#include <ctime>
using namespace std;

// http://bach.dynet.com/palin/
int pal [] = {0, 1, 3, 5, 7, 9, 33, 99, 313, 585, 717, 7447, 9009, 15351, 32223, 39993, 53235, 53835, 73737, 585585, 1758571, 1934391, 1979791, 3129213, 5071705, 5259525, 5841485, 13500531, 719848917, 910373019, 939474939, 1290880921};

bool isPalindrome(string str)
{
    int len = str.length();
    for (int i = 0; i < len / 2; i++) 
    if (str[i] != str[len - 1 - i]) 
    return false;
    return true;
}

bool isDoublePal(unsigned long long& i)
{
	string s = to_string(i);
	if(!isPalindrome(s)) return false;
	unsigned long long k = i;
	string binary;
	while (k > 0)
	{
		binary += (k & 1) ? "1" : "0";
		k >>= 1;
	}
	if(!isPalindrome(binary)) return false;
	return true;
}

int main()
{

	ios_base::sync_with_stdio(false);
	cin.tie(0);

	vector<int> v(pal, pal + 32);
	vector<int>::iterator low, up;

	int a, b;
	while(cin >> a >> b)
	{
		low = lower_bound (v.begin(), v.end(), a);
		up = upper_bound (v.begin(), v.end(), b); 
		cout<< ((int)(up - low)) << endl;
	}

	return 0;
}
