<?php

namespace Orr;

class JDOException extends \Exception {
    
}

/**
 * JAVA Database Objects
 * @author suchart bunhachirat
 */
class Jdo {

    private $ModelsPath = '/var/www/html/HIS/jar/models/';
    private $LibrariesPath = '/var/www/html/HIS/jar/libraries/';
    private $dbUrl = NULL;
    private $dbUser = NULL;
    private $dbPasswd = NULL;
    private $Json = NULL;

    /**
     * 
     * @param type $user
     * @param type $passwd
     * @param type $url
     */
    public function __construct($user, $passwd, $url) {
        putenv('LANG=en_US.UTF-8');
        $this->dbUrl = $url;
        $this->dbUser = $user;
        $this->dbPasswd = $passwd;
    }

    /**
     * JDO::query
     * @param string $sql
     * @return array 
     */
    public function query($sql) {
        $this->execQuery($sql);
        return ($this->isExecOk()) ? $this->Json['data'] : FALSE;
    }

    /**
     * JDO::update
     * @param string $sql
     * @return array 
     */
    public function exec($sql) {
        $this->execUpdate($sql);
        return ($this->isExecOk()) ? $this->Json['data'] : FALSE;
    }

    /**
     * เพิ่มข้อมูล
     * @param type $table
     * @param array $data
     * @return mix
     */
    public function insert($table, array $data) {
        $key = array_keys($data);
        $val = array_values($data);
        $sql = "INSERT INTO $table (" . implode(', ', $key) . ") "
                . "VALUES ('" . implode("', '", $val) . "')";
        return $this->exec($sql);
    }
    
    /**
     * แก้ไขข้อมูลตามฟิลด์และเงื่อนไขที่กำหนด
     * @param type $table
     * @param array $data
     * @param array $keys
     * @return type
     */
    public function update($table, array $data, array $keys) {
        $cols = array();
        foreach ($data as $key => $val) {
            $cols[] = "$key = '$val'";
        }
        foreach ($keys as $key => $val) {
            $where[] = "$key = '$val'";
        }
        $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE " . implode(' AND ', $where);
        return $this->exec($sql);
    }

    /**
     * ลบข้อมูลเงื่อนไขที่กำหนด
     * @param type $table
     * @param array $keys
     * @return mix
     */
    public function delete($table, array $keys) {
        foreach ($keys as $key => $val) {
            $where[] = "$key = '$val'";
        }
        $sql = "DELETE FROM $table WHERE " . implode(' AND ', $where);
        return $this->exec($sql);
    }

    public function isExecOk() {
        return ($this->Json['execute'] === 'successed') ? TRUE : FALSE;
    }

    public function getJson() {
        return $this->Json;
    }

    private function execQuery($sql) {
        $output = NULL;
        try {
            $file_path = 'java -cp ' . $this->LibrariesPath . '*:' . $this->ModelsPath . 'jdb.jar execQuery ' . '"' . $sql . '" ' . '"' . $this->dbUser . '" ' . '"' . $this->dbPasswd . '" ' . '"' . $this->dbUrl . '" ';
            exec($file_path, $output);
            $this->Json = json_decode($output[0], TRUE);
            if ($this->Json['execute'] === 'failed') {
                throw new JDOException($this->Json['info']);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        } finally {
            
        }
    }

    private function execUpdate($sql) {
        $output = NULL;
        try {
            $file_path = 'java -cp ' . $this->LibrariesPath . '*:' . $this->ModelsPath . 'jdb.jar execUpdate ' . '"' . $sql . '" ' . '"' . $this->dbUser . '" ' . '"' . $this->dbPasswd . '" ' . '"' . $this->dbUrl . '" ';
            exec($file_path, $output);
            $this->Json = json_decode($output[0], TRUE);
            if ($this->Json['execute'] === 'failed') {
                throw new JDOException($this->Json['info']);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        } finally {
            
        }
    }

}
