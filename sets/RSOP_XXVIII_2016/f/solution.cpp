#include <iostream>
#include <string>
#include <memory.h>
using namespace std;

#define MAX 200

int memo[MAX][MAX];
string line;

bool can(int start, int len)
{
	int& ans = memo[start][len];
	if (ans > -1) 
		return ans;
  
	if (len == 0) 
		return ans = true;
    
	// suppose x and y are winnable strings and A is any letter, then the only winnable strings can be:

	// xy
	for (int l = 1; l < len; l++) 
		if (can(start,	   l) && 
			can(start + l, len - l)) 
		return ans = true;

	if (len >= 2 && line[start] == line[start + len - 1])
	{
		// AxA
		if (can(start + 1, len - 2)) 
			return ans = true;
    
		// AxAyA
		for (int mid = start + 1; mid < start + len - 1; mid++) 
			if (line[start] == line[mid] && 
				can(start + 1, mid - start - 1) && 
				can(mid + 1,   len - (mid - start + 2)))
			return ans = true;
	}
	  
	return ans = false;
}

int main()
{
	ios_base::sync_with_stdio(0);
	cin.tie(0);

	int tc = 1;
	while (getline(cin, line)) 
	{
		 memset(memo, -1, sizeof memo);
		 cout << "Case #" << tc++ << ": " << (can(0, line.length()) ? "yes" : "no") << endl;
	}
	
	return 0;
}
