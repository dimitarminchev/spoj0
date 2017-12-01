#include <iostream>
#include <vector>
using namespace std;

void fspot(vector<vector<int> > &bd, int x, int y, int c, bool flag) {
  if(x < 0 || y < 0 || x >= (int)bd.size() || y >= (int)bd.size()) return;
  if(bd[y][x] >= 0) {
    if(bd[y][x] & c) return;
    bd[y][x] |= c;
  } else if(!flag) return;
  fspot(bd, x-1, y, c, false);
  fspot(bd, x, y-1, c, false);
  fspot(bd, x+1, y, c, false);
  fspot(bd, x, y+1, c, false);
}
int main(){
  int NT, n, b, w, x, y;
  cin >> NT;
  while(NT--){
       cin >> n >> b >> w;
       vector<vector<int> > bd(n, vector<int>(n, 0));
       for(int i = 0; i < b; i++) {
          cin >> y >> x;
          bd[y-1][x-1] = -1;
       }
       for(int i = 0; i < w; i++) {
          cin >> y >> x;
          bd[y-1][x-1] = -2;
       }
       for(y = 0; y < n; y++)
          for(x = 0; x < n; x++){
             if(bd[y][x] == -1)fspot(bd, x, y, 1, true);
             else if(bd[y][x] == -2)fspot(bd, x, y, 2, true);
       }
       int scoreB = 0, scoreR = 0;
       for(y = 0; y < n; y++)
          for(x = 0; x < n; x++){
             if(bd[y][x] == 1)scoreB++;
             if(bd[y][x] == 2)scoreR++;
       }
       cout << "B" << scoreB << ":R" << scoreR << endl;
  }; //End while
  return 0;
}
