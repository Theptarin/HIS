//////////////////////////////////////////////////////////////////////////////////
//
// JDBCQuery example.  This program uses the IBM Toolbox for Java JDBC driver to
// query a table and output its contents.
//
// Command syntax:
//    Db2Csv system collectionName tableName
//
// For example,
//    Db2Csv MySystem qiws qcustcdt
//
//////////////////////////////////////////////////////////////////////////////////

import java.io.*;/*การทำงานกับ Stream I/O ต้องอิมพอร์ตแพ็กเกจ java.io เสมอ*/
import java.sql.*;

public class Db2Csv {

	/* Replace all instances of a String in a String.
	 *   @param  s  String to alter.
	 *   @param  f  String to look for.
	 *   @param  r  String to replace it with, or null to just remove it.
	 */  
	private static String replace( String s, String f, String r )
	{
	   if (s == null)  return s;
	   if (f == null)  return s;
	   if (r == null)  r = "";

	   int index01 = s.indexOf( f );
	   while (index01 != -1)
	   {
	      s = s.substring(0,index01) + r + s.substring(index01+f.length());
	      index01 += r.length();
	      index01 = s.indexOf( f, index01 );
	   }
	   return s;
	}
	
	public static void main(String[] parameters) {
		// Check the input parameters.
		if (parameters.length != 3) {
			System.out.println("");
			System.out.println("Usage:");
			System.out.println("");
			System.out.println("   Db2Csv system file.sql file.csv");
			System.out.println("");
			System.out.println("");
			System.out.println("For example:");
			System.out.println("");
			System.out.println("");
			System.out.println("   Db2Csv mySystem SqlFile CsvFile");
			System.out.println("");
			return;
		}

		/*
		 * String system = parameters[0]; String collectionName = parameters[1];
		 * String tableName = parameters[2];
		 */
		String system = parameters[0];
		String SqlFile = parameters[1];
		String CsvFile = parameters[2];

		Connection connection = null;

		try {

			// Read SQL File
			BufferedReader in = new BufferedReader(new FileReader(SqlFile));
			String s1;
			String s2 = new String();
			while ((s1 = in.readLine()) != null) {
				s2 += s1 + "\r\n";
			}
			in.close();

			// Load the IBM Toolbox for Java JDBC driver.
			DriverManager
					.registerDriver(new com.ibm.as400.access.AS400JDBCDriver());

			// Get a connection to the database. Since we do not
			// provide a user id or password, a prompt will appear.
			connection = DriverManager.getConnection("jdbc:as400://" + system
					+ ";user=it;password=it");
			// DatabaseMetaData dmd = connection.getMetaData ();

			// Execute the query.
			Statement select = connection.createStatement();
			/*
			 * ResultSet rs = select.executeQuery ("SELECT * FROM " +
			 * collectionName + dmd.getCatalogSeparator() + tableName);
			 */
			ResultSet rs = select.executeQuery(s2);
			// System.out.println("SELECT * FROM " + collectionName +
			// dmd.getCatalogSeparator() + tableName);
			System.out.println(s2);
			// Get information about the result set. Set the column
			// width to whichever is longer: the length of the label
			// or the length of the data.
			ResultSetMetaData rsmd = rs.getMetaData();
			int columnCount = rsmd.getColumnCount();
			String[] columnLabels = new String[columnCount];
			int[] columnWidths = new int[columnCount];
			for (int i = 1; i <= columnCount; ++i) {
				columnLabels[i - 1] = rsmd.getColumnLabel(i);
				columnWidths[i - 1] = Math.max(columnLabels[i - 1].length(),
						rsmd.getColumnDisplaySize(i));
			}
			// กำหนด file.csv ข้อมูลที่ต้องการ
			BufferedWriter out = new BufferedWriter(new FileWriter(CsvFile));

			int rows = 0;
			String RowValue = "";
			while (rs.next()) {

				try {
					for (int i = 1; i <= columnCount; ++i) {
						String value = rs.getString(i);
						if (rs.wasNull())
							// value = "<null>";
							value = "";

						int type = rsmd.getColumnType(i);
						if (type == 1 || type == 12) {
							try 
							{
								RowValue += "\"" + replace(value.trim(),"\"","\\\"") + "\"";
								
							} catch (Exception e) {
								System.out.println(value);
								RowValue = "";
								System.out.println("ERROR: " + e);
								break; // ทำงาน record ถัดไป
							}

							// out.write("\"" + value.trim() + "\"");
						} else {
							try {
								if (value == null) {
									System.out.println(value);
									RowValue = "";
									break; // ทำงาน record ถัดไป
								} else {
									RowValue += value;
								}
								// out.write(value + "");
							} catch (Exception e) {
								System.out.println(value);
								RowValue = "";
								System.out.println("ERROR: " + e);
								break; // ทำงาน record ถัดไป
							}
						}
						if (i < columnCount)
							RowValue += ";";
						// out.write(";");
					}
					if (RowValue != "") {
						out.write(RowValue);
						out.newLine();
						++rows;
					}
					RowValue = "";
				} catch (Exception e) {
					System.out.println("ERROR: " + e);
					RowValue = "";
				}
			}

			System.out.println("Transfer " + rows + " Rows");
			out.close();
		} catch (Exception e) {
			System.out.println();
			System.out.println("ERROR: " + e);
		} finally {
			// Clean up.
			try {
				if (connection != null)
					connection.close();
			} catch (SQLException e) {
				// Ignore.
			}
		}
		System.exit(0);
	}
}