<?php

/**
 * Created by Shijie Liu. 2018-4-10
 * 通用数据库处理类
 */
error_reporting(0);
//$test = new DB_util();
//$test->connectDB();
//echo $test;

define("DB_host", "120.79.146.123");
define("DB_user", "root");
define("DB_psd", "19971010");
define("DB_name", "UserAction");


class DB_util
{
    /**
     * 回数据库连接，false为连接错误
     * @return bool|mysqli
     */
    function connectDB()
    {
        $con_db = mysqli_connect(DB_host, DB_user, DB_psd, DB_name);
        if (empty($con_db)) {
            $con_db = false;  //数据库连接错误
        }
        return $con_db;
    }

    /**
     * 数据库查询，查询错误返回false，查询为空和有数据均为数组，可通过行数查询判空
     * @param $sql
     * @return bool|mysqli_result
     */
    function queryDB($sql)
    {
        $result = true;
        $con_db = $this->connectDB();
        if ($con_db == false) {
            $result = false;
        } else {
            $result = mysqli_query($con_db, $sql);
        }

        $con_db->close();
        return $result;
    }
}