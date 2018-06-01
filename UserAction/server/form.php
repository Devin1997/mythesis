<?php
/**
 * Created by Shijie Liu. 2018-4-10
 * 表单填写的数据传入
 */
include "DB_util.php";
$db = new DB_util();

$name = $_POST["InputName"];
$comment = $_POST["InputMessage"];

$sql_insert = "INSERT INTO FormData(name, comment) VALUES('$name','$comment')";
$db->queryDB($sql_insert);