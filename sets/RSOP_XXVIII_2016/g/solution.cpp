/*
Written by VNIK Vladimir Nikolov
Problem : Trend with limit
Solution : Greedy & mutable set (vector)
*/
#include <ctime>
#include <cstdio>
#include <iostream>
#include <fstream>
#include <vector>
#include <algorithm>
#include <functional>
#include <iterator>
using namespace std;
#define MAX_TRENDS 50001

vector<unsigned> holderSortVector;
vector<unsigned>::iterator holderVectIt;
int mainMySortVector(){
  //  freopen("C:\\temp\\TrendIn.txt", "rt", stdin);
  static unsigned Tests = 0;
  static unsigned NumPoints = 0;
  static unsigned pnt = 0;
  static unsigned value = 0;
  unsigned Limit = 0;
  fscanf(stdin, "%d", &Tests); //number of test 
  for (; Tests; Tests--)	{
    fscanf(stdin, "%d %d", &NumPoints, &Limit); //number of points & limit trends
    for (pnt = 0; pnt<NumPoints; pnt++)	{
      fscanf(stdin, "%d", &value); // get current value
      if (holderSortVector.size() > Limit){
        continue;
      }
      holderVectIt = upper_bound(holderSortVector.begin(), holderSortVector.end(), value, greater<unsigned >());
      if (holderVectIt != holderSortVector.end()){
        holderSortVector.at(holderVectIt - holderSortVector.begin()) = value;
      }
      else{
        holderSortVector.push_back(value);
      }
    }
    if (holderSortVector.size() > Limit){
      cout << "impossible" << endl;
    }
    else{
      cout << holderSortVector.size() << endl;
    }
    holderSortVector.clear();
  }
  return 0;
}
// MySortVector


// Array version simply (trivial) solution
int holderArray[MAX_TRENDS];
int mainMyArray(){
  //  freopen("C:\\temp\\TrendIn.txt", "rt", stdin);
  static int Tests = 0;
  static int NumPoints = 0;
  static int pnt = 0;
  static int trend = 0;
  static int value = 0;
  int Limit = 0;
  fscanf(stdin, "%d", &Tests); //number of test 
  for (; Tests; Tests--)	{
    trend = 0;
    fscanf(stdin, "%d %d", &NumPoints, &Limit); //number of points & limit trends
    for (pnt = 0; pnt<NumPoints; pnt++)	{
      fscanf(stdin, "%d", &value); // get current value
      if (trend > Limit){
        continue;
      }
      for (trend = 0; trend < MAX_TRENDS; trend++)	{
        if (holderArray[trend]<value)	{
          holderArray[trend] = value; // set value 
          break;
        }
      }
    }
    for (trend = 0; trend < MAX_TRENDS; trend++)	{
      if (holderArray[trend] == 0){
        if (trend > Limit){
          cout << "impossible" << endl;
        }
        else{
          cout << trend << endl;
        }
        break;
      }
      else{
        holderArray[trend] = 0;
      }
    }
  }
  return 0;
}

int main(void){
  //  cout << "-------------------------------------mainMySortVector---------------------------------" << endl;
  //  unsigned sTime = clock();
  mainMySortVector();
  //  cout << "Time (s): " << (double)(clock() - sTime) / CLOCKS_PER_SEC << endl;
  //  cout << "-------------------------------------mainMyArray()---------------------------" << endl;
  //  sTime = clock();
  //  mainMyArray();
  //  cout << "Time (s): " << (double)(clock() - sTime) / CLOCKS_PER_SEC << endl;
  //  cout << "------------------------------------End------------------------------------" << endl;
  //  system("pause");
  return 0;
}