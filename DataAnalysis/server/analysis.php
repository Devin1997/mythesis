<?php

/**
 * Created by Shijie Liu. 2018-4-15
 * 数据分析页面后台
 */

include "DB_util.php";
/**
 * 当月访问量
 */
function Base_Chart_1($kind)
{
    $db = new DB_util();
    $sql = "SELECT sum(PV),sum(UV) FROM Base;";
    $result = $db->queryDB($sql);
    $arr = mysqli_fetch_all($result);

    $PV = $arr[0][0];
    $UV = $arr[0][1];
    if ($kind == "PV") {
        return $PV;
    }
    if ($kind == "UV") {
        return $UV;
    }
    if ($kind == "data") {
        $option = '{"title":{"x":"center"},"tooltip":{"trigger":"item","textStyle":{"fontSize":10,"fontStyle":"normal"}},"toolbox":{"show":false,"feature":{"mark":{"show":true},"dataView":{"show":true,"readOnly":true},"restore":{"show":true},"saveAsImage":{"show":true}}},"calculable":true,"series":[{"name":"访问来源","type":"pie","radius":"55%","center":["50%","60%"],"itemStyle":{"normal":{"label":{"show":true,"formatter":"{b}: {d}%"}}},"data":[{"value":335,"name":"新增"},{"value":850,"name":"历史"}]}]}';
        $option_arr = json_decode($option, TRUE);
        $option_arr["series"][0]["data"][0]["value"] = $UV;
        $option_arr["series"][0]["data"][1]["value"] = $PV - $UV;

        return json_encode($option_arr, JSON_UNESCAPED_UNICODE);
    }
}

/**
 * 分时图
 */
function Base_Chart_2()
{
    $db = new DB_util();
    $sql = "SELECT visit_time FROM Base Order by visit_time;";
    $result = $db->queryDB($sql);
    $time_arr = mysqli_fetch_all($result);

    $today = date("Y-m-d");

    $option = '{"tooltip":{"trigger":"axis","textStyle":{"fontSize":10,"fontStyle":"normal"}},"legend":{"data":["PV"],"y":"bottom"},"toolbox":{"feature":{"mark":{"show":true},"dataView":{"show":true,"readOnly":true},"magicType":{"show":false,"type":["line","bar"]},"restore":{"show":true},"saveAsImage":{"show":true}}},"calculable":true,"xAxis":[{"type":"category","boundaryGap":false,"data":["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24"],"name":"时间","nameLocation":"end","scale":true}],"yAxis":[{"type":"value","nameLocation":"end","name":"访问量"}],"series":[{"name":"PV","type":"line","data":[]}]}';
    $option_arr = json_decode($option, TRUE);

    for ($i = 0; $i < count($time_arr); $i++) {
        if (substr($time_arr[$i][0], 0, 10) == $today) {  //今日数据
            $hour = substr($time_arr[$i][0], 11, 2);
            for ($j = 0; $j < 24; $j++) {
                if (strcmp($hour, sprintf("%02d", $j)) == 0) {  // 某一时刻
                    $option_arr["series"][0]["data"][$j]++;
                    break;
                }
            }
        }
    }

    $data_put = $option_arr["series"][0]["data"];
    $all_visit = 0;
    $time_end = end(array_keys($data_put));

    for ($i = 0; $i < 24; $i++) {
        if ($data_put[$i] > 0) {
            $all_visit += $data_put[$i];
            $option_arr["series"][0]["data"][$i] = $all_visit;
        } else {
            $option_arr["series"][0]["data"][$i] = $all_visit;
        }
    }
    ksort($option_arr["series"][0]["data"]);
    array_splice($option_arr["series"][0]["data"], $time_end + 1);  //删除多余补足的元素

    return json_encode($option_arr, JSON_UNESCAPED_UNICODE);
}

/**
 * IP分布图
 */
function Base_Chart_3()
{
    $db = new DB_util();
    $sql = "SELECT region FROM Base;";
    $result = $db->queryDB($sql);
    $region_arr = mysqli_fetch_all($result);

    $option = '{"title":{"x":"center"},"tooltip":{"trigger":"item","textStyle":{"fontSize":10,"fontStyle":"normal"}},"dataRange":{"min":0,"max":0,"calculable":true,"x":"left","y":"bottom","text":["高","低"],"color":["#006edd","#e0ffff"]},"toolbox":{"orient":"vertical","x":"right","y":"bottom","feature":{"mark":{"show":false},"dataView":{"show":true,"readOnly":false},"restore":{"show":true},"saveAsImage":{"show":true}},"show":false},"roamController":{"show":false,"x":"right","mapTypeControl":{"china":true}},"series":[{"name":"IP","type":"map","mapType":"china","roam":false,"mapValueCalculation":"sum","itemStyle":{"emphasis":{"label":{"show":true,"textStyle":{"fontSize":12,"color":"rgb(51, 51, 51)","fontStyle":"italic"}}}},"showLegendSymbol":false,"data":[{"value":0,"name":"北京"},{"value":0,"name":"天津"},{"value":0,"name":"上海"},{"value":0,"name":"重庆"},{"value":0,"name":"河北"},{"value":0,"name":"河南"},{"value":0,"name":"云南"},{"value":0,"name":"辽宁"},{"value":0,"name":"黑龙江"},{"value":0,"name":"湖南"},{"value":0,"name":"安徽"},{"value":0,"name":"山东"},{"value":0,"name":"新疆"},{"value":0,"name":"江苏"},{"value":0,"name":"浙江"},{"value":0,"name":"江西"},{"value":0,"name":"湖北"},{"value":0,"name":"广西"},{"value":0,"name":"甘肃"},{"value":0,"name":"山西"},{"value":0,"name":"内蒙古"},{"value":0,"name":"陕西"},{"value":0,"name":"吉林"},{"value":0,"name":"福建"},{"value":0,"name":"贵州"},{"value":0,"name":"广东"},{"value":0,"name":"青海"},{"value":0,"name":"西藏"},{"value":0,"name":"四川"},{"value":0,"name":"宁夏"},{"value":0,"name":"海南"},{"value":0,"name":"台湾"},{"value":0,"name":"香港"},{"value":0,"name":"澳门"}]}]}';
    $option_arr = json_decode($option, TRUE);
    $map_arr = $option_arr["series"][0]["data"];

    $max = 0;
    for ($i = 0; $i < count($region_arr); $i++) {
        $region = substr($region_arr[$i][0],0,6);
        if (substr($region_arr[$i][0],0,3) == "黑龙江" || $region_arr[$i][0] == "内蒙古"){
            $region = substr($region_arr[$i],0,3);
        }

        for ($j = 0; $j < 34; $j++) {
            if ($region == $map_arr[$j]["name"]) {
                $option_arr["series"][0]["data"][$j]["value"]++;
                $max++;
            }
        }
    }
//    print_r($option_arr["series"][0]["data"]);
    $option_arr["dataRange"]["max"] = $max;
    return json_encode($option_arr, JSON_UNESCAPED_UNICODE);
}

/**
 * 媒体行为百分比
 */
function Media_Chart_1(){
    $db = new DB_util();
    $sql = "SELECT count(play),sum(play),sum(waiting),sum(end),sum(volumechange) FROM Media where id = 'MyAudio';";
    $sql2 = "SELECT count(jump_times) FROM Media WHERE jump_times > 0 and id = 'MyAudio';";
    $sql3 = "SELECT count(play) FROM Media WHERE playduration/length > 0.5 and id = 'MyAudio';";

    $media_arr = mysqli_fetch_all($db->queryDB($sql));
    $all = $media_arr[0][0];

    $media_arr2 = mysqli_fetch_all($db->queryDB($sql2));
    $media_arr3 = mysqli_fetch_all($db->queryDB($sql3));

    $option = '{ "legend": { "y": "bottom", "data": [ "播放行为", "跳转行为", "缓冲等待", "播放过半", "播放结束", "音量调节" ] }, "title": { "text": false }, "toolbox": { "show": false }, "tooltip": { "trigger": "item", "textStyle": { "fontSize": 10, "fontStyle": "normal" } }, "series": [ { "type": "pie", "center": [ "12%", "30%" ], "radius": [ 50, 70 ], "x": "0%", "itemStyle": { "normal": { "label": { "textStyle": { "baseline": "top" } } } }, "data": [ { "name": "other", "value": 46, "itemStyle": { "normal": { "color": "#ccc", "label": { "show": true, "position": "center" }, "labelLine": { "show": false } }, "emphasis": { "color": "rgba(0,0,0,0)" } } }, { "name": "播放行为", "value": 54, "itemStyle": { "normal": { "label": { "show": true, "position": "center", "formatter": "{b}", "textStyle": { "baseline": "bottom" } }, "labelLine": { "show": false } } } } ] }, { "type": "pie", "center": [ "48%", "30%" ], "radius": [ 50, 70 ], "x": "40%", "itemStyle": { "normal": { "label": { "textStyle": { "baseline": "top" } } } }, "data": [ { "name": "other", "value": 56, "itemStyle": { "normal": { "color": "#ccc", "label": { "show": true, "position": "center" }, "labelLine": { "show": false } }, "emphasis": { "color": "rgba(0,0,0,0)" } } }, { "name": "跳转行为", "value": 44, "itemStyle": { "normal": { "label": { "show": true, "position": "center", "formatter": "{b}", "textStyle": { "baseline": "bottom" } }, "labelLine": { "show": false } } } } ] }, { "type": "pie", "center": [ "84%", "30%" ], "radius": [ 50, 70 ], "x": "80%", "itemStyle": { "normal": { "label": { "textStyle": { "baseline": "top" } } } }, "data": [ { "name": "other", "value": 65, "itemStyle": { "normal": { "color": "#ccc", "label": { "show": true, "position": "center" }, "labelLine": { "show": false } }, "emphasis": { "color": "rgba(0,0,0,0)" } } }, { "name": "缓冲等待", "value": 35, "itemStyle": { "normal": { "label": { "show": true, "position": "center", "formatter": "{b}", "textStyle": { "baseline": "bottom" } }, "labelLine": { "show": false } } } } ] }, { "type": "pie", "center": [ "12%", "70%" ], "radius": [ 50, 70 ], "x": "0%", "y": "55%", "itemStyle": { "normal": { "label": { "textStyle": { "baseline": "top" } } } }, "data": [ { "name": "other", "value": 70, "itemStyle": { "normal": { "color": "#ccc", "label": { "show": true, "position": "center" }, "labelLine": { "show": false } }, "emphasis": { "color": "rgba(0,0,0,0)" } } }, { "name": "播放过半", "value": 30, "itemStyle": { "normal": { "label": { "show": true, "position": "center", "formatter": "{b}", "textStyle": { "baseline": "bottom" } }, "labelLine": { "show": false } } } } ] }, { "type": "pie", "center": [ "48%", "70%" ], "radius": [ 50, 70 ], "x": "40%", "y": "55%", "itemStyle": { "normal": { "label": { "formatter":"50%", "textStyle": { "baseline": "top" } } } }, "data": [ { "name": "other", "value": 73, "itemStyle": { "normal": { "color": "#ccc", "label": { "show": true, "position": "center" }, "labelLine": { "show": false } }, "emphasis": { "color": "rgba(0,0,0,0)" } } }, { "name": "播放结束", "value": 27, "itemStyle": { "normal": { "label": { "show": true, "position": "center", "formatter": "{b}", "textStyle": { "baseline": "bottom" } }, "labelLine": { "show": false } } } } ] }, { "type": "pie", "center": [ "84%", "70%" ], "radius": [ 50, 70 ], "y": "55%", "x": "80%", "itemStyle": { "normal": { "label": { "textStyle": { "baseline": "top" } } } }, "data": [ { "name": "other", "value": 48, "itemStyle": { "normal": { "color": "#ccc", "label": { "show": true, "position": "center" }, "labelLine": { "show": false } }, "emphasis": { "color": "rgba(0,0,0,0)" } } }, { "name": "音量调节", "value": 22, "itemStyle": { "normal": { "label": { "show": true, "position": "center", "formatter": "{b}", "textStyle": { "baseline": "bottom" } }, "labelLine": { "show": false } } } } ] } ] }';
    $option_arr = json_decode($option, TRUE);
    //播放
    $option_arr["series"][0]["data"][0]["value"] = $all - $media_arr[0][1];
    $option_arr["series"][0]["data"][1]["value"] = $media_arr[0][1];
    $option_arr["series"][0]["itemStyle"]["normal"]["label"]["formatter"]  =  sprintf("%.1f", ($media_arr[0][1])/$all*100).'%';
    //跳转
    $option_arr["series"][1]["data"][0]["value"] = $all - $media_arr2[0][0];
    $option_arr["series"][1]["data"][1]["value"] = $media_arr2[0][0];
    $option_arr["series"][1]["itemStyle"]["normal"]["label"]["formatter"]  =  sprintf("%.1f", ($media_arr2[0][0])/$all*100).'%';
    //缓冲等待
    $option_arr["series"][2]["data"][0]["value"] = $all - $media_arr[0][2];
    $option_arr["series"][2]["data"][1]["value"] = $media_arr[0][2];
    $option_arr["series"][2]["itemStyle"]["normal"]["label"]["formatter"]  =  sprintf("%.1f", ($media_arr[0][2])/$all*100).'%';
    //过半
    $option_arr["series"][3]["data"][0]["value"] = $all - $media_arr3[0][0];
    $option_arr["series"][3]["data"][1]["value"] = $media_arr3[0][0];
    $option_arr["series"][3]["itemStyle"]["normal"]["label"]["formatter"]  =  sprintf("%.1f", ($media_arr3[0][0])/$all*100).'%';
    //结束
    $option_arr["series"][4]["data"][0]["value"] = $all - $media_arr[0][3];
    $option_arr["series"][4]["data"][1]["value"] = $media_arr[0][3];
    $option_arr["series"][4]["itemStyle"]["normal"]["label"]["formatter"]  =  sprintf("%.1f", ($media_arr[0][3])/$all*100).'%';
    //音量
    $option_arr["series"][5]["data"][0]["value"] = $all - $media_arr[0][4];
    $option_arr["series"][5]["data"][1]["value"] = $media_arr[0][4];
    $option_arr["series"][5]["itemStyle"]["normal"]["label"]["formatter"]  =  sprintf("%.1f", ($media_arr[0][4])/$all*100).'%';

//    print_r($option_arr["series"][0]["itemStyle"]["normal"]["label"]);
    return json_encode($option_arr, JSON_UNESCAPED_UNICODE);
}

/**
 * 堆积条形图
 */
function Img_Chart_1(){
    $db = new DB_util();
    $sql = "SELECT id,sum(open),sum(copy),sum(save),sum(link) FROM Img GROUP BY id;";
    $sql2 = "SELECT id,sum(annotate_times) FROM Img GROUP BY id;";
    $img_arr = mysqli_fetch_all($db->queryDB($sql));
    $img_arr2  = mysqli_fetch_all($db->queryDB($sql2));

    $option = '{"tooltip":{"trigger":"axis","axisPointer":{"type":"shadow"},"textStyle":{"fontSize":10,"fontStyle":"normal"}},"legend":{"data":["新窗口打开","图片复制","图片保存","链接复制","图像标注"],"y":"bottom"},"toolbox":{"show":false,"feature":{"mark":{"show":true},"dataView":{"show":true,"readOnly":true},"magicType":{"show":false,"type":["line","bar","stack","tiled"]},"restore":{"show":true},"saveAsImage":{"show":true}}},"calculable":true,"xAxis":[{"type":"value","name":"次数"}],"yAxis":[{"type":"category","data":["Img_6","Img_5","Img_4","Img_3","Img_2","Img_1"]}],"series":[{"name":"新窗口打开","type":"bar","stack":"总量","itemStyle":{"normal":{"label":{"show":true,"position":"insideRight"}}},"data":[320,302,301,334,390,330]},{"name":"图片复制","type":"bar","stack":"总量","itemStyle":{"normal":{"label":{"show":true,"position":"insideRight"}}},"data":[120,132,101,134,90,230]},{"name":"图片保存","type":"bar","stack":"总量","itemStyle":{"normal":{"label":{"show":true,"position":"insideRight"}}},"data":[220,182,191,234,290,330]},{"name":"链接复制","type":"bar","stack":"总量","itemStyle":{"normal":{"label":{"show":true,"position":"insideRight"}}},"data":[150,212,201,154,190,330]},{"name":"图像标注","type":"bar","stack":"总量","itemStyle":{"normal":{"label":{"show":true,"position":"insideTop"}}},"data":[123,321,122,110,342,231]}]}';
    $option_arr = json_decode($option, TRUE);

    for ($i = 0;$i <6;$i++){
        if ($i < 4){
            for ($j = 0;$j<6;$j++){
                $option_arr["series"][$i]["data"][5-$j] = $img_arr[$j][$i+1];
            }
        }
    }

    for ($i = 0;$i <6;$i++){
        $option_arr["series"][4]["data"][5-$i] = $img_arr2[$i][1];
    }

    return json_encode($option_arr, JSON_UNESCAPED_UNICODE);
}

/**
 * 散点图
 */
function Media_Chart_2(){
    $db = new DB_util();
    $sql = "SELECT id,jump_content FROM Media WHERE jump_content != '[]' Order By id;";
    $moment_arr = mysqli_fetch_all($db->queryDB($sql));

    $moment_audio = array();  // 全部moment的数组
    $moment_video = array();  //

    for ($i = 0;$i < count($moment_arr);$i++){
        if ($moment_arr[$i][0] == "MyAudio"){
            $moment = substr($moment_arr[$i][1],1,strlen($moment_arr[$i][1])-2);
            $moment_str = explode(",",$moment);
            $moment_audio = array_merge($moment_audio,$moment_str);
        }else{
            $moment = substr($moment_arr[$i][1],1,strlen($moment_arr[$i][1])-2);
            $moment_str = explode(",",$moment);
            $moment_video = array_merge($moment_video,$moment_str);
        }
    }

    $option = '{"title":{"text":false},"tooltip":{"trigger":"axis","showDelay":0,"axisPointer":{"show":true,"type":"cross","lineStyle":{"type":"dashed","width":1}}},"legend":{"data":["音频","视频"]},"toolbox":{"show":false},"xAxis":[{"type":"value","scale":true,"axisLabel":{"formatter":"{value}"}}],"yAxis":[{"min":0,"type":"value","scale":true,"axisLabel":{"formatter":"{value}"}}],"series":[{"name":"音频","type":"scatter","data":[]},{"name":"视频","type":"scatter","data":[]}]}';
    $option_arr = json_decode($option, TRUE);

    //音频
    $audio_data = array_count_values($moment_audio);
    for ($i = 0;$i < count($audio_data);$i++){
        $key =  array_keys($audio_data)[$i];  //键名即时刻字符
        $key_str = substr($key,1,strlen($key)-2);  //时刻，去引号
        $key_num = (int)substr($key_str,0,1)+ (int)substr($key_str,-2)*0.01;
        $sandian = array($key_num,$audio_data[$key]);
        array_push($option_arr["series"][0]["data"],$sandian);

    }

    //视频
    $video_data = array_count_values($moment_video);
    for ($i = 0;$i < count($video_data);$i++){
        $key =  array_keys($video_data)[$i];  //键名即时刻字符
        $key_str = substr($key,1,strlen($key)-2);  //时刻，去引号
        $key_num = (int)substr($key_str,0,1)+ (int)substr($key_str,-2)*0.01;
        $sandian = array($key_num,$video_data[$key]);
        array_push($option_arr["series"][1]["data"],$sandian);
    }

    return json_encode($option_arr, JSON_UNESCAPED_UNICODE);
}

/**
 * 热力图数据
 */
function Heatmap(){
    $db = new DB_util();
    $sql = "select data from heatmap order by id desc LIMIT 1;";
    $heatmap_arr = mysqli_fetch_all($db->queryDB($sql))[0][0];
    $heatmap_arr = json_decode($heatmap_arr, TRUE);

    return json_encode($heatmap_arr, JSON_UNESCAPED_UNICODE);
}