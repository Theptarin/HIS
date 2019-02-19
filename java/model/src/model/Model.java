package model;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

/**
 * คลาสจัดการข้อมูลภาษาจาวา รับคำสั่ง SQL ผู้ใช้งาน รหัสผ่าน
 *
 * @author suchart bunhachirat
 */
public class Model {

    static final String DB_URL
            = "jdbc:as400://10.1.99.2/trhpfv5";
    static final String DB_DRV
            = "com.ibm.as400.access.AS400JDBCDriver";
    static final String DB_USER = "orrconn";
    static final String DB_PASSWD = "xoylfk";

    /**
     * @param args the command line arguments - SQL command. - user password for
     * connect DB.
     */
    public static void main(String[] args) {
        for (String s : args) {
            System.out.println(s);
        }

        Connection connection = null;
        Statement statement = null;
        ResultSet resultSet = null;

        try {
            connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWD);
            statement = connection.createStatement();
            //statement.executeQuery("UPDATE regmasv5pf SET rmssurnam='จาก HIMS Conn java' where rmshnref='211'" );
            resultSet = statement.executeQuery("select rmshnref,rmsname,rmssurnam from regmasv5pf where rmsname='ทดสอบ'");
            while (resultSet.next()) {
                System.out.printf("%s\t%s\t%s\n",
                        resultSet.getString(1),
                        resultSet.getString(2),
                        resultSet.getString(3));
            }

        } catch (SQLException ex) {
        } finally {
            try {
                resultSet.close();
                statement.close();
                connection.close();
            } catch (SQLException ex) {
            }
        }
    }

}
