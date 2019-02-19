package model;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;

/**
 * คลาสคำสั่งเพิ่มข้อมูล DB SQL USER PASSWORD
 *
 * @author suchart bunhachirat
 */
public class Insert {

    static final String DB_URL
            = "jdbc:as400://10.1.99.2/ttrpf";
    static final String DB_DRV
            = "com.ibm.as400.access.AS400JDBCDriver";
    static final String DB_USER = "orrconn";
    static final String DB_PASSWD = "xoylfk";

    /**
     * @param args the command line arguments - SQL command. - user password for
     * connect DB.
     */
    public static void main(String[] args) {
        String sql = "";
        if (args.length > 0) {
            sql = args[0];
        }
        Connection connection = null;
        Statement statement = null;
        //String sql = "INSERT INTO jdbc_test (id,name) VALUES('5','ทดสอบจาก Java6')";
        try {
            connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWD);
            statement = connection.createStatement();
            statement.executeUpdate(sql);
            System.out.println("[{\"Status\":\"Success\"}]");
        } catch (SQLException ex) {
            System.out.println("[{\"Status\":\"Fail\"}]");
            System.out.println(ex);
        } finally {
            try {
                statement.close();
                connection.close();
            } catch (SQLException ex) {
                System.out.println("[{\"Status\":\"Fail\"}]");
                System.out.println(ex);
            }
        }
    }
}
