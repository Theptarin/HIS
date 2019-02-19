
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import org.json.JSONArray;
import org.json.JSONObject;

/**
 * JDBC executeQuery
 *
 * @author suchart bunhachirat
 */
public class execQuery {

    static final String EXEC_FAILED = "failed";
    static final String EXEC_SUCCESSED = "successed";
    static String DB_SQL = "SELECT * FROM jdbc_test WHERE id > 0";
    static String DB_USER = "orrconn";
    static String DB_PASSWD = "xoylfk";
    static String DB_URL
            = "jdbc:as400://10.1.99.2/ttrpf";

    /**
     * @param args Array the command line arguments - SQL User Password URL
     * @throws java.lang.Exception
     */
    public static void main(String[] args) throws Exception {
        if (args.length == 4) {
            DB_SQL = args[0];
            DB_USER = args[1];
            DB_PASSWD = args[2];
            DB_URL = args[3];
        } else {
            //return;
        }
        Connection connection = null;
        Statement statement = null;
        ResultSet resultSet = null;

        try {
            connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWD);
            statement = connection.createStatement();
            resultSet = statement.executeQuery(DB_SQL);
            System.out.println("{\"execute\":\"" + EXEC_SUCCESSED +"\",\"data\":" + convertToJSON(resultSet) + ",\"info\":\"\"}");
        } catch (SQLException ex) {
            System.out.println("{\"execute\":\""+ EXEC_FAILED +"\",\"data\":\"\",\"info\":\"" + ex + " | execQuery 48\"}");
            System.exit(0);
        } finally {
            try {
                if (resultSet != null) {
                    resultSet.close();
                }
                if (statement != null) {
                    statement.close();
                }
                if (connection != null) {
                    connection.close();
                }
            } catch (SQLException ex) {
                System.out.println("{\"execute\":\""+ EXEC_FAILED +"\",\"data\":\"\",\"info\":\"" + ex + " | execQuery 62\"}");
                System.exit(0);
            }
        }
    }

    /**
     * Convert a result set into a JSON Array
     *
     * @param resultSet
     * @return a JSONArray
     * @throws Exception
     */
    public static JSONArray convertToJSON(ResultSet resultSet)
            throws Exception {
        JSONArray jsonArray = new JSONArray();
        while (resultSet.next()) {
            int total_rows = resultSet.getMetaData().getColumnCount();
            JSONObject obj = new JSONObject();
            for (int i = 0; i < total_rows; i++) {
                obj.put(resultSet.getMetaData().getColumnLabel(i + 1)
                        .toLowerCase(), resultSet.getObject(i + 1));
            }
            jsonArray.put(obj);
        }
        return jsonArray;
    }
}
