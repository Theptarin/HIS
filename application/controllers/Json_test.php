<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of json_test
 *
 * @author it
 */
class json_test extends CI_Controller {

    public function index() {
        //$array_json = ['Status' => 'Success', 'Data' => [['id' => 1, 'name' => 'ทดสอบ', 'list' => [1, 2, 3]]], ['id' => 2, 'name' => 'ตัวอย่าง', 'list' => [4, 5, 6]], ['id' => 3, 'name' => 'ตัวอย่าง3', 'list' => [4, 5, 6]]];
        $str_json_java = '{"status":"success","data":[{"name":"ทดสอบ","id":1},{"name":"TEST","id":2},{"name":"ลองอีกครั้ง","id":3},{"name":"ทดสอบจาก Java","id":9},{"name":"ทดสอบจาก Java2","id":8},{"name":"ทดสอบจาก Java3","id":7},{"name":"ทดสอบจาก Java5","id":6},{"name":"ทดสอบจาก Java6","id":5},{"name":"สุชาติ บุญหชัยรัตน์","id":23},{"name":"Insert by PHP2","id":10},{"name":"Insert by PHP2 ครับ","id":11},{"name":"เพิ่มข้อมูลจาก PHP ครับ","id":12},{"name":"เพิ่มข้อมูลจาก PHP ครับ","id":13},{"name":"เพิ่มข้อมูลจาก PHP ครับ","id":14},{"name":"ทดสอบ","id":21},{"name":"สุชาติ บุญหชัยรัตน์","id":22},{"name":"15ทดสอบ","id":15},{"name":"ทดสอบ","id":16}]}';
        header('Content-Type: application/json');
        print_r(json_decode($str_json_java));
        //$json = json_encode($array_json,JSON_UNESCAPED_UNICODE);
        //echo $json;
        //print_r(json_decode($json));
        //$str_json = '{"Status":"Success","Data":[{"id":1,"name":"ทดสอบ","list":[1,2,3]}],"0":{"id":2,"name":"ตัวอย่าง","list":[4,5,6]},"1":{"id":3,"name":"ตัวอย่าง3","list":[4,5,6]}}';
        //print_r(json_decode($str_json,TRUE));
    }

}
