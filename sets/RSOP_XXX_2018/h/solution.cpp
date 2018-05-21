#include <stdio.h>

typedef unsigned int UINT;

UINT _rotl24(UINT unArg, int nCount)
{
	nCount %= 24;
	long long	unArg1 = (long long)unArg << nCount;
	long long	unArg2 = (long long)unArg1 >> 24;

	return (unArg1 | unArg2) & 0xffffff;
}

UINT _rotr24(UINT unArg, int nCount)
{
	return _rotl24(unArg, 24 - (nCount % 24));
}

UINT add(UINT unArg1, UINT unArg2) {
	return (unArg1 + unArg2) & 0xffffff;
}

UINT sub(UINT unArg1, UINT unArg2) {
	return (unArg1 - unArg2) & 0xffffff;
}

void WriteTriple(char * szMessage, UINT unTriple) {
	szMessage[0] = unTriple >> 16;
	szMessage[1] = unTriple >> 8;
	szMessage[2] = unTriple;
}

bool DecryptMessage(UINT * punCrypted, UINT * punKey, char * pchResult)
{
	UINT unA3 = _rotr24(punCrypted[0], punKey[1]);
	UINT unC2 = sub(punCrypted[1], punKey[2]);
	UINT unE3 = punCrypted[2] ^ punKey[0];

	UINT unTemp = unA3 ^ unE3;
	UINT unD1 = _rotr24(unTemp, punKey[2]);
	UINT unD2 = _rotl24(unD1, punKey[1]);
	UINT unC1 = punCrypted[3] ^ unD1;
	UINT unB3 = unC2 ^ unC1;
	UINT unB2 = sub(unB3, unD2);

	UINT unA2 = unA3 ^ unB2;
	UINT unA1 = _rotr24(unA2, punKey[2]);
	UINT unE1 = unA1 ^ unD1;

	UINT unM1 = unA1 ^ punKey[0];
	UINT unM2 = _rotr24(unC1, punKey[1]);
	UINT unM3 = sub(unE1,  punKey[2]);

	WriteTriple(pchResult, unM1);
	WriteTriple(pchResult + 3, unM2);
	WriteTriple(pchResult + 6, unM3);

	pchResult[9] = 0;

	printf("%s\n", pchResult);

	return true;
}

int main(int nArgc, const char ** pchArv)
{
	char szResult[20];
	UINT unCrypted[4], unKey[3];

	int N;
	scanf("%d\r\n", &N);

	for (int i = 0; i < N; i++)
	{
		scanf("%6x%6x%6x%6x %6x%6x%6x\r\n",
			unCrypted + 0, unCrypted + 1, unCrypted + 2, unCrypted + 3,
			unKey + 0, unKey + 1, unKey + 2);
		char szResult[20];
		DecryptMessage(unCrypted, unKey, szResult);
	}

	return 0;
}

