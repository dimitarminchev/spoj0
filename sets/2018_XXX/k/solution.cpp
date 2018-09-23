#include <cstdio>
#include <cstring>

char convert(char ch) {
	if(ch >= 'a' && ch <= 'z')
		ch = ch - 'a' + 'A';
	if(ch >= 'W') return 9;
	if(ch >= 'T') return 8;
	if(ch >= 'P') return 7;
	else return 2 + (ch - 'A') / 3;
}

char s[12345];
int len, ct;

int moo() {
	for(int i = 0; i < len - 1 - i; ++i) {
		if(s[i] != s[len - 1 - i]) return 0;
	}
	return 1;
}

int main() {
	scanf("%d\n", &ct);
	while(ct--) {
		gets(s);
		len = strlen(s);
		for(int i = 0; i < len; ++i) {
			s[i] = convert(s[i]);
		}
		if(moo()) puts("YES");
		else puts("NO");
	}
	return 0;
}


