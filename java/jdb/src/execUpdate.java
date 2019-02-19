
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;

/**
 * คลาสเพื่อทำงานกับ JDBC SQL USER PASSWORD URL DB_SQL = "INSERT INTO jdbc_test
 * (id,name) VALUES('5','ทดสอบจาก Java6')" DB_URL =
 * "dbc:as400://10.1.99.2/ttrpf"
 *
 * @author suchart bunhachirat
 */
public class execUpdate {

    static String DB_SQL = "";
    static String DB_USER = "";
    static String DB_PASSWD = "";
    static String DB_URL = "";

    /**
     * @param args SQL USER PASSWORD URL
     */
    public static void main(String[] args) {
        if (args.length > 0) {
            DB_SQL = args[0];
            DB_USER = args[1];
            DB_PASSWD = args[2];
            DB_URL = args[3];

        }
        Connection connection = null;
        Statement statement = null;
        try {
            connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWD);
            statement = connection.createStatement();
            statement.executeUpdate(DB_SQL);
            System.out.println("{\"status\":\"success\"},{\"data\":\"\"}");
        } catch (SQLException ex) {
            System.out.println("{\"status\":\"fail\"},{\"data\":\"\"},{\"SQLException\":\"" + ex + " : execUpdate 40\"}");
            System.exit(0);
        } finally {
            try {
                if (statement != null) {
                    statement.close();
                }
                if (connection != null) {
                    connection.close();
                }
                System.exit(0);
            } catch (SQLException ex) {
                System.out.println("{\"status\":\"fail\"},{\"data\":\"\"},{\"SQLException\":\"" + ex + " : execUpdate 52\"}");
                System.exit(0);
            }
        }
    }
}
