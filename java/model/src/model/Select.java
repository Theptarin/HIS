/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package model;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

/**
 *
 * @author it
 */
public class Select {

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
            resultSet = statement.executeQuery("SELECT * FROM jdbc_test");
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
