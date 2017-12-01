import java.io.PrintWriter;
import java.math.BigInteger;
import java.util.HashMap;
import java.util.Map;
import java.util.Scanner;

/**
 * Sample application.
 *
 * @author Test
 */
public class program {

	/** Cache of the floor combinations. */
	private static Map<Integer, BigInteger> cache = new HashMap<Integer, BigInteger>();

	/**
	 * Calculates the number of combinations for the specified floor number.
	 *
	 * @param floor
	 *            is the floor number
	 * @return the number of combinations for the specified floor number
	 */
	private static BigInteger towerCalculator(int floor) {
		if (floor == 1) {
			return new BigInteger("2");
		}
		if (floor == 2) {
			return new BigInteger("7");
		}
		if (cache.containsKey(Integer.valueOf(floor))) {
			return cache.get(Integer.valueOf(floor));
		}
		BigInteger sum = new BigInteger("0");
		for (int i = 1; i <= floor - 1; i++) {
			sum = sum.add(towerCalculator(i).multiply(new BigInteger("2")));
		}
		sum = sum.add(towerCalculator(floor - 2)).add(new BigInteger("2"));
		cache.put(Integer.valueOf(floor), sum);
		return sum;
	}

	/**
	 * Executable method.
	 *
	 * @param args
	 *            is the VarArgs array
	 * @throws Exception
	 *             if problem occur during execution
	 */
	public static void main(String[] args) throws Exception {
		Scanner scanner = new Scanner(System.in);
		PrintWriter writer = new PrintWriter(System.out);
		int iterations = scanner.nextInt();
		for (int i = 0; i < iterations; i++) {
			writer.write(towerCalculator(scanner.nextInt()).toString());
			writer.write(System.lineSeparator());
		}
		scanner.close();
		writer.close();
	}
}
