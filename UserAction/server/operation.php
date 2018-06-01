<?php
include "DB_util.php";

/*
 * Created by Shijie Liu. 2018-4-12
 * AJAX同服务端交互操作：数据本地存储+数据数据库存储
 */

$user_data = $_POST["Data"];
$heatmap = $_POST["heatmap"];
Save_To_file($user_data);
Save_To_DB($user_data);
Save_Heatmap($heatmap);

/**
 * 存储json数据至tool文件下data目录，以时间命名
 * 注意：需要放开data目录的写入权限
 * @param $user_data
 */
function Save_To_file($user_data)
{
    $time = date("Y-m-d") . "_" . date("H-i-s");
    $file_name = $time . ".json";
    $file_path = "../mytool/data/" . $file_name;

    $myfile = fopen($file_path, "w");
    fwrite($myfile, $user_data);
    fclose($myfile);
}

/**
 * 存储数据至数据库，6个表：base、text、img、form、link、media
 * annotate与jump等数组格式数据以json存入
 * @param $user_data
 */
function Save_To_DB($user_data)
{
    $db = new DB_util();
    $data_arr = json_decode($user_data, TRUE);  //json转数组,需加true，否则为stdClass

    // 存储base基本信息
    $base_arr = $data_arr["base"];

    $PV = $base_arr["PV"];
    $UV = $base_arr["UV"];
    $IP = $base_arr["IP"];
    $region = $base_arr["region"];
    $visit_time = $base_arr["visit_time"];
    $stay_time = floatval($base_arr["stay_time"]);

    $sql = " INSERT INTO Base VALUES('$PV','$UV','$IP','$region','$visit_time','$stay_time');";
    $db->queryDB($sql);

    // 存储Text行为数据
    $text_arr = $data_arr["text"]["TextAction"];

    for ($i = 0; $i < count($text_arr); $i++) {
        $text = $text_arr[$i]["text"];
        $copy = $text_arr[$i]["copy"];
        $annotate = $text_arr[$i]["annotate"];
        $sql = " INSERT INTO Text VALUES('$text','$copy','$annotate');";
        $db->queryDB($sql);
    }

    // 存储img行为数据
    $img_arr = $data_arr["img"]["ImgAction"];

    for ($i = 0; $i < count($img_arr); $i++) {
        $index = $img_arr[$i]["index"];
        $open = $img_arr[$i]["open"];
        $copy = $img_arr[$i]["copy"];
        $save = $img_arr[$i]["save"];
        $link = $img_arr[$i]["link"];
        $url = $img_arr[$i]["url"];
        $annotate_times = $img_arr[$i]["annotate"]["times"];
        $annotate_content = json_encode($img_arr[$i]["annotate"]["content"], JSON_UNESCAPED_UNICODE);  //数组转json

        $sql = " INSERT INTO Img VALUES('$index','$open','$copy','$save','$link','$url','$annotate_times','$annotate_content');";
        $db->queryDB($sql);
    }

    // 存储media行为数据
    $media_arr = $data_arr["media"]["MediaAciton"];

    for ($i = 0; $i < count($media_arr); $i++) {
        $index = $media_arr[$i]["index"];
        $play = $media_arr[$i]["play"];
        $jump_times = $media_arr[$i]["jump"]["times"];
        $jump_content = json_encode($media_arr[$i]["jump"]["moment"], JSON_UNESCAPED_UNICODE);
        $end = $media_arr[$i]["end"];
        $waiting = $media_arr[$i]["waiting"];
        $volumechange = $media_arr[$i]["volumechange"];
        $length = floatval($media_arr[$i]["length"]);
        $playduration = floatval($media_arr[$i]["playduration"]);  //数组转json

        $sql = " INSERT INTO Media VALUES('$index','$play','$jump_times','$jump_content','$end','$waiting','$volumechange','$length','$playduration');";
        $db->queryDB($sql);
    }

    // 存储表单行为数据
    $form_arr = $data_arr["form"]["FormAction"];

    for ($i = 0; $i < count($form_arr); $i++) {
        $index = $form_arr[$i]["index"];
        $click = $form_arr[$i]["click"];
        $input = $form_arr[$i]["input"];
        $time = floatval($form_arr[$i]["time"]);
        $text = $form_arr[$i]["text"];

        $sql = " INSERT INTO Form VALUES('$index','$click','$input','$time','$text');";
        $db->queryDB($sql);
    }

    // 存储链接行为数据
    $link_arr = $data_arr["link"]["LinkAction"];

    for ($i = 0; $i < count($link_arr); $i++) {
        $index = $link_arr[$i]["index"];
        $click = $link_arr[$i]["click"];
        $url = $link_arr[$i]["url"];

        $sql = " INSERT INTO Link VALUES('$index','$click','$url');";
        $db->queryDB($sql);
    }
}


function Save_Heatmap($heatmap){
    $db = new DB_util();
    $sql = "INSERT INTO heatmap(data) VALUES('$heatmap');";
    $db->queryDB($sql);
}