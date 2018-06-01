/*
 * 客户端用户行为数据捕获工具 v1.0 
 * Copyright © Shijie Liu. 2018
 * 
 * 图片、音视频、链接、表单需要将其元素id作为参数传入
 * 全部数据的数据类型、统计规则见data目录下的data_norms.json文件
 * 监听浏览器关闭事件，用户关闭浏览器前传输数据，传输说明见Ajax_Data()方法注释
 */


// 页面加载时执行
window.onload = function () {
    getUserBaseData();
    getHeatMapData();
    getTextActionData();
    getImgActionData("MyImg_1"); getImgActionData("MyImg_2"); getImgActionData("MyImg_3"); getImgActionData("MyImg_4"); getImgActionData("MyImg_5"); getImgActionData("MyImg_6");
    getMediaActionData("MyAudio"); getMediaActionData("MyVideo");
    getFormActionData("Input_Name"); getFormActionData("Input_Message");
    getLinkActionData("link_0"); getLinkActionData("link_1"); getLinkActionData("link_2"); getLinkActionData("link_3"); getLinkActionData("link_4"); getLinkActionData("link_5");
    NewMenu_IMG();
};

//监听浏览器关闭，关闭浏览器前传输数据
window.onbeforeunload = function (event) {
    getStayTime("end");
    Ajax_Data();
    event.returnValue = "您确定要离开吗？";
};

/**
 * Ajax方法,传输全部前台数据
 * 服务端的data.php用于保存ajax收到的数据保存mytool/data/目录下，以时间命名
 * 注意：此方法不可跨域
 */
function Ajax_Data() {
    var xmlhttp;

    var UserActionData = {  //全部数据
        "base": UserBaseData,
        "text": TextActionData,
        "img": ImgActionData,
        "media": MediaAcitonData,
        "form": FormActionData,
        "link": LinkActionData
        // "heatmap":heatmapdata,
    };

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            console.log("Post Success!");
        }
    }

    xmlhttp.open("POST", "./server/operation.php", true);  //设置后台传输action，不可跨域
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Data=" + JSON.stringify(UserActionData)+"&heatmap="+JSON.stringify(heatmapdata));
    sessionStorage.pagecount = 0;
}


/**
 * 数据一：用户基础数据：PV、UV、IP、访问时间、访问时长
 */
const UserBaseData = { "PV": "", "UV": "", "IP": "","region": "", "visit_time": "", "stay_time": "" };
function getUserBaseData() {
    getPV();
    getIP();
    getUV();
    getStayTime("begin");
    sessionStorage.UserBaseData = JSON.stringify(UserBaseData);

    /**
     *  PV数据，全部访问统计
     *  使用sessionStorage统计,统计用户单次会话访问数据提交后需清零，多次访问不需要清零
     */
    function getPV() {
        if (sessionStorage.pagecount) {
            sessionStorage.pagecount = Number(sessionStorage.pagecount) + 1;
        } else {
            sessionStorage.pagecount = 1;
        }
        UserBaseData["PV"] = sessionStorage.pagecount;
    }

    // IP查询，借助搜狐第三方API
    function getIP() {
        UserBaseData["IP"] = returnCitySN.cip;
        UserBaseData["region"] = returnCitySN.cname;
    }
}

/**
 * UV统计
 * 利用Cookies的统计，以24小时作为访问周期
 * chrome不支持本地操作js，必须在服务器端调试
 */
function getUV() {
    var user = getCookie("visitor");

    if (user == "") {	  //cookies为""，新用户
        setCookie("visitor", "visted_user");
        UserBaseData["UV"] = 1;
        // console.log("欢迎新人!" + getCookie("visitor"));
    } else {  		 //cookies存在，历史用户
        // console.log("欢迎老人!");
        UserBaseData["UV"] = 0;
    }

    //cookies创建
    function setCookie(cname, cvalue) {
        var d = new Date();
        d.setTime(d.getTime() + (24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    //cookies查找
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i].trim();
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
}

/**
 * 页面停留时长统计
 */
var visit_begin;
function getStayTime(flag) {
    // var begin;
    if (flag == "begin") {
        var c_time = new Date();
        visit_begin = c_time.getTime();
        UserBaseData["visit_time"] = c_time.Format("yyyy-MM-dd hh:mm:ss");
    }

    if (flag == "end") {
        var end = new Date().getTime();
        var stay = (Number(end) - Number(visit_begin)) / 1000;
        UserBaseData["stay_time"] = stay.toFixed(2);
        // localStorage.setItem("time", UserBaseData["stay_time"]);  //测试数据
    }
}

//格式化时间输出
Date.prototype.Format = function (fmt) {
    var o = {
        "M+": this.getMonth() + 1, //月份
        "d+": this.getDate(), //日
        "h+": this.getHours(), //小时
        "m+": this.getMinutes(), //分
        "s+": this.getSeconds(), //秒
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}

/**
 * 数据二：用户文本行为数据：选中文本、是否复制、标记内容
 * 该方法为全局文本行为，图片Selection亦会被统计
 */

var TextActionData = { "TextAction": [] };
function getTextActionData() {
    var text_field = document.getElementsByTagName("html")[0];
    var init_data = { text: "", copy: 0, annotate: "" }; //初始化数据
    TextActionData["TextAction"].push(init_data);
    sessionStorage.TextActionData = JSON.stringify(TextActionData);

    // 选中文本事件监听
    text_field.addEventListener("click", function () {
        var text_data = { text: "", copy: 0, annotate: "" };   //文本行为数据,定义位置需放置在监听中，属于引用类型

        let selectedText = window.getSelection().toString();
        if (selectedText.length > 0) {  //点击行为排除
            text_data.text = selectedText;
        } else {
            return;
        }
        if (TextActionData["TextAction"][0].text == "") { //删除空数据
            TextActionData["TextAction"].splice(0, 1);
        }

        // 获取文本复制行为数据：是或否
        text_field.oncopy = function () {
            text_data.copy = 1;
            sessionStorage.TextActionData = JSON.stringify(TextActionData);
        };

        // 获取文本标注内容
        var annotator_save_btn = document.getElementById("annotator_save_btn");
        annotator_save_btn.onclick = function () {
            var comment_input = document.getElementById("annotator-field-0");
            text_data.annotate = comment_input.value;
            sessionStorage.TextActionData = JSON.stringify(TextActionData);
        }

        TextActionData["TextAction"].push(text_data);
        // console.log(TextActionData);
        sessionStorage.TextActionData = JSON.stringify(TextActionData);
    });
}


/**
 * 数据三：用户图片行为数据：打开、复制、保存、复制链接、标注行为(标记次数、标记起始位置、标记结束位置、标记内容)
 * @param img_index 图片元素id
 */

const ImgActionData = { "ImgAction": [] };

function getImgActionData(img_id) {
    var img_field = document.getElementById(img_id);
    img_field.classList.add("annotatable");  //新增class：annotatable，用于图像标注

    //初始化图片行为数据
    var img_data = {
        index: img_id,
        open: 0,
        copy: 0,
        save: 0,
        link: 0,
        annotate: {
            "times": 0,
            "content": [{ "position_begin": "", "position_end": "", "text": "" }]
        },
        url: img_field.src
    };
    ImgActionData["ImgAction"].push(img_data);
    sessionStorage.ImgActionData = JSON.stringify(ImgActionData);

    //为img元素新增父元素span
    var span_img = document.createElement("span");
    span_img.id = "span_img";

    if (img_field.parentNode.id != "span_img") {
        img_field.parentNode.replaceChild(span_img, img_field);
        span_img.appendChild(img_field);
    }

    /**
     * 监听右键事件，禁用图片区域浏览器右键
     */
    span_img.oncontextmenu = function (ev) {
        ev.returnValue = false;  //阻止默认事件

        var menu = document.getElementById("menu");
        var menu_ul = document.getElementById("menu_ul");
        var open_img = document.getElementById("open_img");
        var save_img = document.getElementById("save_img");
        var copy_img = document.getElementById("copy_img");
        var link_img = document.getElementById("link_img");

        var ev = ev || event;
        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;

        // 将“另存为”设置为可下载的链接a
        var a_img = document.createElement("a");
        a_img.href = img_data.url;
        a_img.download = "";
        if (menu_ul.childNodes[1].id == "save_img") {
            menu_ul.replaceChild(a_img, save_img);
            a_img.appendChild(save_img)
        } else {
            menu_ul.childNodes[1].href = img_data.url;
        }

        menu.style.display = "block";
        menu.style.left = ev.clientX + "px";
        //当滑动滚动条时也能准确获取菜单位置
        menu.style.top = ev.clientY + scrollTop + "px";


        // 打开图片事件监听和执行，打开次数为增量
        open_img.onclick = function () {
            //记录行为数据
            var Data_Arr = ImgActionData["ImgAction"];
            for (var i = 0; i < Data_Arr.length; i++) {
                if (Data_Arr[i].index == (img_id + "")) {
                    img_data.open++;
                    break;
                }
            }
            sessionStorage.ImgActionData = JSON.stringify(ImgActionData);

            //执行打开图片
            window.open(img_data.url);
        };

        // 保存图片事件监听和执行，保存次数为增量
        save_img.onclick = function () {
            //记录行为数据
            var Data_Arr = ImgActionData["ImgAction"];
            for (var i = 0; i < Data_Arr.length; i++) {
                if (Data_Arr[i].index == (img_id + "")) {  //同一图片
                    img_data.save++;
                    break;
                }
            }
            sessionStorage.ImgActionData = JSON.stringify(ImgActionData);
        };

        // 复制图片事件监听和执行，复制次数为增量
        copy_img.onclick = function () {
            // 记录行为数据
            var Data_Arr = ImgActionData["ImgAction"];
            for (var i = 0; i < Data_Arr.length; i++) {
                if (Data_Arr[i].index == (img_id + "")) {  //同一图片
                    img_data.copy++;
                    break;
                }
            }
            sessionStorage.ImgActionData = JSON.stringify(ImgActionData);

            // 执行图片复制,chrome不支持，只能曲线救国,按照选区复制
            var clipboard = new Clipboard('#copy_img', {
                target: function () {
                    return img_field.parentNode;
                }
            });
        };

        // 复制图片链接事件监听和执行，复制次数为增量
        link_img.onclick = function () {
            //记录行为数据
            var Data_Arr = ImgActionData["ImgAction"];
            for (var i = 0; i < Data_Arr.length; i++) {
                if (Data_Arr[i].index == (img_id + "")) {  //同一图片
                    img_data.link++;
                    break;
                }
            }
            sessionStorage.ImgActionData = JSON.stringify(ImgActionData);

            // 执行图片链接复制
            link_img.setAttribute("data-clipboard-text", img_data.url);
            var clipboard = new Clipboard("#link_img");
        };
    };

    //点击行为释放禁止的右键菜单
    window.onclick = function () {
        var menu = document.getElementById("menu");
        menu.style.display = "none";
    };


    /** 
     * 图片标记行为数据收集
     * 标记次数、标记起始位置、标记结束位置、标记内容
     */
    var click_flag = 0; //开关,监测点击起始位置,拖拽后置1禁该行为,标注后恢复

    // 获取标注起始位置
    span_img.addEventListener("mousedown", function (e) {
        if (e.button == 0 && click_flag == 0) {  //鼠标左键
            position_begin = getTagPositon(e);
        }

    });
    span_img.addEventListener("mouseup", function (e) {
        // console.log(position_begin);
        if (e.button == 0 && click_flag == 0 && position_begin != undefined) {
            var position_end = getTagPositon(e);
            if (position_end != position_begin) { //数据不一致时，方为真实标注行为
                click_flag = 1;

                /**
                 * 为两个按钮添加事件监听，执行数据收集,查找略微复杂，根据DOM结构
                 * 计入标注位置及标注内容
                 * */
                var annotate_editor = document.getElementById(img_id).parentNode.childNodes[4];  //小编辑器
                var annotate_input = annotate_editor.childNodes[0].childNodes[0];  //标注文本输入框
                // console.log(annotate_input);
                var annotate_save_btn = annotate_editor.childNodes[0].childNodes[1].childNodes[1];  //保存按钮
                var annotate_cancel_btn = annotate_editor.childNodes[0].childNodes[1].childNodes[0];  //取消按钮

                var tag_data = { "position_begin": position_begin, "position_end": position_end, "text": "" };  //标记内容初始化

                //输入文本框失焦时获取内容
                annotate_input.onblur = function () {
                    tag_data.text = annotate_input.value;
                }

                //点击Save时保存全部标注数据
                annotate_save_btn.onclick = function () {
                    click_flag = 0;
                    var Data_Arr = ImgActionData["ImgAction"];
                    for (var i = 0; i < Data_Arr.length; i++) {
                        if (Data_Arr[i].index == (img_id + "")) {  //同一图片
                            img_data.annotate["times"]++;
                            if (img_data.annotate["content"][0].position_begin == "") {
                                img_data.annotate["content"].splice(0, 1);
                            }
                            img_data.annotate["content"].push(tag_data);
                            break;
                        }
                    }
                    sessionStorage.ImgActionData = JSON.stringify(ImgActionData);
                    // console.log(img_data.annotate);
                };

                //点击Cancel时保存部分标注数据，含空标注
                annotate_cancel_btn.onclick = function () {
                    click_flag = 0;
                    var Data_Arr = ImgActionData["ImgAction"];
                    for (var i = 0; i < Data_Arr.length; i++) {
                        if (Data_Arr[i].index == (img_id + "")) {  //同一图片
                            img_data.annotate["times"]++;
                            if (img_data.annotate["content"][0].position_begin == "") {
                                img_data.annotate["content"].splice(0, 1);
                            }
                            img_data.annotate["content"].push(tag_data);
                        }
                    }
                    sessionStorage.ImgActionData = JSON.stringify(ImgActionData);
                };
            } else {
                // console.log("这是单击，不是拖拽");
            }
        }
    });

    //获取标注点对图片的相对位置
    function getTagPositon(e) {
        var img_position = getElementOffset(span_img);  //图片位置
        var tag_point = getPositionInHtml(e);  //点击位置
        let teg_x = tag_point.x - img_position.left;
        let teg_y = tag_point.y - img_position.top;
        let tag_postion = "(" + teg_x + "," + teg_y + ")";
        return tag_postion;
    }
}

//获取鼠标点击位置
function getPositionInHtml(e) {
    e = e || window.event;
    var x = e.pageX || (e.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft));
    var y = e.pageY || (e.clientY + (document.documentElement.scrollTop || document.body.scrollTop));
    return { 'x': x, 'y': y };
}
//获取元素offset位置
function getElementOffset(element) {
    var left = 0, top = 0;
    while (element && !isNaN(element.offsetLeft) && !isNaN(element.offsetTop)) {
        left += element.offsetLeft - element.scrollLeft;
        top += element.offsetTop - element.scrollTop;
        element = element.offsetParent;
    }
    return { "left": left, "top": top };
}

/** 
 * 图片右键重写，新增div和CSS
 * 浏览器加载时新增元素和css
 */

function NewMenu_IMG() {
    //添加自定义右键元素
    var menu = document.createElement("div");
    menu.id = "menu";
    var ul = document.createElement("ul");
    ul.id = "menu_ul"

    var li_1 = document.createElement("li");  //打开
    li_1.innerHTML = "在新标签页打开图片";
    li_1.id = "open_img";

    var li_2 = document.createElement("li");  //另存为
    li_2.innerHTML = "图片另存为";
    li_2.id = "save_img";

    var li_3 = document.createElement("li");  //复制
    li_3.innerHTML = "复制图片";
    li_3.id = "copy_img";

    var li_4 = document.createElement("li");  //复制链接
    li_4.innerHTML = "复制图片地址";
    li_4.id = "link_img";

    ul.appendChild(li_1);
    ul.appendChild(li_2);
    ul.appendChild(li_3);
    ul.appendChild(li_4);
    menu.appendChild(ul);
    document.body.appendChild(menu);

    //添加自定义右键的css
    var menu_css = document.createElement('style');
    menu_css.type = "text/css";
    menu_css.innerText = "#menu {width:200px;background: #fff;position: absolute;display: none; z-index: 100;box-shadow: 2px 2px 1px #888888;}"
        + "#menu ul{list-style: none;padding: 0!important;;margin:4px 0!important;;}"
        + "#menu ul li{font-size: 13px;color: #222;text-indent: 28px!important;;line-height: 40px!important;}"
        + "#menu ul li:hover{background-color: #ecf0f1;cursor: default ;}";
    document.getElementsByTagName("head")[0].appendChild(menu_css);
}



/**
 * 数据五：用户媒体播放行为数据:播放、跳转(跳转次数、跳转时刻)、结束、缓冲等待、调节音量、播放时长
 * @param id 传入媒体元素id
 * 除jump外，均为判断性数据类型，即0或1
 */
const MediaAcitonData = { "MediaAciton": [] };

function getMediaActionData(media_id) {
    var media_field = document.getElementById(media_id);
    var media_data = {
        "index": media_id,  //媒体id
        "play": 0,  //播放
        "jump": { "times": 0, "moment": [] },  //跳转，times为增量数据，跳转时刻为数组
        "end": 0,  //结束
        "waiting": 0,  //缓冲等待
        "volumechange": 0,   //音量调节
        "length": 0, //媒体长度
        "playduration": 0  //播放时长
    };

    MediaAcitonData["MediaAciton"].push(media_data);
    sessionStorage.setItem("MediaAcitonData", JSON.stringify(MediaAcitonData));

    /**
     * 播放行为
     */
    media_field.addEventListener('play', function () {
        media_data.length = media_field.duration;
        var Data_Arr = MediaAcitonData["MediaAciton"];
        for (var i = 0; i < Data_Arr.length; i++) {
            if (Data_Arr[i].index == (media_id + "")) {  ////查找该media
                media_data.play = 1;
                begin = getTime();  //begin全局
                // console.log("Begin:" +new Date(begin));
                break;
            }
        }
        sessionStorage.MediaAcitonData = JSON.stringify(MediaAcitonData);
    });

    /**
     * 跳转行为
     */
    media_field.addEventListener('seeked', function () {
        var Data_Arr = MediaAcitonData["MediaAciton"];
        for (var i = 0; i < Data_Arr.length; i++) {
            if (Data_Arr[i].index == (media_id + "")) {  //查找该media
                media_data.jump["times"]++;
                let moment = TimeFormat(media_field.currentTime);
                media_data.jump["moment"].push(moment);  //跳转时刻记录
                break;
            }
        }
        sessionStorage.MediaAcitonData = JSON.stringify(MediaAcitonData);
    });

    /**
     * 播放结束行为
     */
    media_field.addEventListener('ended', function () {
        var Data_Arr = MediaAcitonData["MediaAciton"];
        for (var i = 0; i < Data_Arr.length; i++) {
            if (Data_Arr[i].index == (media_id + "")) {  //查找该media
                media_data.end = 1;
                break;
            }
        }
        sessionStorage.MediaAcitonData = JSON.stringify(MediaAcitonData);
    });

    /**
     * 缓冲等待行为
     */
    media_field.addEventListener('waiting', function () {
        var Data_Arr = MediaAcitonData["MediaAciton"];
        for (var i = 0; i < Data_Arr.length; i++) {
            if (Data_Arr[i].index == (media_id + "")) {  //查找该media
                media_data.waiting = 1;
                break;
            }
        }
        sessionStorage.MediaAcitonData = JSON.stringify(MediaAcitonData);
    });

    /**
     * 音量调节
     */
    media_field.addEventListener('volumechange', function () {
        var Data_Arr = MediaAcitonData["MediaAciton"];
        for (var i = 0; i < Data_Arr.length; i++) {
            if (Data_Arr[i].index == (media_id + "")) {  //查找该media
                media_data.volumechange = 1;
                break;
            }
        }
        sessionStorage.MediaAcitonData = JSON.stringify(MediaAcitonData);
    });

    /**
     * 播放暂停，跳转亦会触发
     */
    media_field.addEventListener('pause', function () {
        var Data_Arr = MediaAcitonData["MediaAciton"];
        for (var i = 0; i < Data_Arr.length; i++) {
            if (Data_Arr[i].index == (media_id + "")) {  //查找该media
                time_seg = Number((getTime() - begin) / 1000).toFixed(2);
                // console.log(time_seg);
                media_data.playduration += Number(time_seg);
                // console.log("Test:"+media_data.playduration);
                break;
            }
        }
        sessionStorage.MediaAcitonData = JSON.stringify(MediaAcitonData);
    });
}

function getTime() {
    let time = new Date().getTime();
    return time;
}

// 时间戳格式化输出
function TimeFormat(timestamp) {
    let minute = Math.floor(timestamp / 60);
    let second = Math.floor(timestamp - minute * 60);
    if (second < 10) {
        second = "0" + second;
    }
    let moment = minute + ":" + second;
    return moment;
}

/**
 * 数据六：获取用户表单行为数据： 点击、填写、停留时长、填写内容
 * @param form_id 传入表单(文本框)的元素id
 */
const FormActionData = { "FormAction": [] };

function getFormActionData(form_id) {
    var form_field = document.getElementById(form_id);

    //初始化表单行为数据
    var form_data = {
        "index": form_id,
        "click": 0,
        "input": 0,
        "time": 0,
        "text": ""
    };
    FormActionData["FormAction"].push(form_data);
    sessionStorage.FormActionData = JSON.stringify(FormActionData);

    /**
     * 表单区域点击，增量数据
     * 表单停留时间，初识时间
     */
    form_field.addEventListener('focus', function () {
        var Data_Arr = FormActionData["FormAction"];
        for (var i = 0; i < Data_Arr.length; i++) {
            if (Data_Arr[i].index == (form_id + "")) {
                form_data.click++;
                focus_time = getTime();
                // console.log(form_data.index+"开始:"+focus_time);
                break;
            }
        }
        sessionStorage.FormActionData = JSON.stringify(FormActionData);
    });

    // 表单区域输入
    form_field.addEventListener("input", function () {
        var Data_Arr = FormActionData["FormAction"];
        for (var i = 0; i < Data_Arr.length; i++) {
            if (Data_Arr[i].index == (form_id + "")) {
                form_data.input = 1;
                break;
            }
        }
        sessionStorage.FormActionData = JSON.stringify(FormActionData);
    });

    /**
     * 表单内容获取
     * 表单停留时长统计
     */
    form_field.addEventListener('blur', function () {
        var Data_Arr = FormActionData["FormAction"];
        for (var i = 0; i < Data_Arr.length; i++) {
            if (Data_Arr[i].index == (form_id + "")) {
                let time_seg = Number((getTime() - focus_time) / 1000).toFixed(2);
                // console.log(form_data.index+"碎片:"+time_seg);
                form_data.time += Number(time_seg);
                // console.log(form_data.index+"总长:"+form_data.time);
                form_data.text = form_field.value;
                break;
            }
        }
        sessionStorage.FormActionData = JSON.stringify(FormActionData);
    });
}

/**
 * 数据七：获取用户链接行为数据： 点击次数、链接URL
 * @param link_id 传入元素id 
 */
const LinkActionData = { "LinkAction": [] };
function getLinkActionData(link_id) {
    var link_field = document.getElementById(link_id);

    //初始化表单行为数据
    var link_data = {
        "index": link_id,
        "click": 0,
        "url": link_field.href
    };
    LinkActionData["LinkAction"].push(link_data);
    sessionStorage.LinkActionData = JSON.stringify(LinkActionData);

    // 链接点击，增量数据
    link_field.addEventListener('click', function () {
        var Data_Arr = LinkActionData["LinkAction"];
        for (var i = 0; i < Data_Arr.length; i++) {
            if (Data_Arr[i].index == (link_id + "")) {
                link_data.click++;
                break;
            }
        }
        sessionStorage.LinkActionData = JSON.stringify(LinkActionData);
    });
}


/**
 * 数据八：用户点击和浏览热力分布数据
 * 捕获热力点击数据，heatmap.js所需数据格式如下：
 * data = {max:12,data:[{x:11,y:32,value:24},{x:11,y:32,value:24}]}
 */
var heatmapdata;
var pointdata = [];
var max = 1;
function getHeatMapData() {
    var coords = document.getElementsByTagName("html")[0];
    coords.onmousemove = function (e) {
        var pointer = getPositionInHtml(e);
        var X = pointer.x;
        var Y = pointer.y;

        var point = {
            "x": X,
            "y": Y,
            "value": 1
        };
        pointdata.push(point);  //追加在最后
        for (var i = 0; i < pointdata.length - 1; i++) {   //重复数据value值叠加,删除重复数据
            // console.log(pointdata[i]);
            if ((pointdata[i].x == X + "") && (pointdata[i].y == Y + "")) {
                pointdata[i].value++;
                pointdata.splice(-1, 1);  //删除最后项

                if (pointdata[i].value > max) {  //计算最大count
                    max = pointdata[i].value;
                }
                break;
            }
        }
        heatmapdata = { "max": max + "", "data": pointdata };
        sessionStorage.heatmapdata = JSON.stringify(heatmapdata);  //local or session 需要研讨
    }
}