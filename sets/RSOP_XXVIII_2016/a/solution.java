import java.util.Scanner;
import java.math.BigInteger;

public class solution 
{
  public static void main(String[] args) 
  { 
    Scanner in = new Scanner(System.in);
    while(in.hasNext())
    { 
      String s = in.next();
      int n = Integer.parseInt(s);  
      BigInteger p = (new BigInteger(s)).pow(n);
      s = p.toString();
      if (s.length()>=n)
        System.out.println(s.charAt(n-1));
      else
		System.out.println("*");
    }
    in.close();
  }
}
