
window.onload = function () {
    Base_chart1();
    Base_chart2();
    Base_chart3();
    Img_chart1();
    Img_chart2();
    Text_chart_1();
    Text_chart_2();
    Media_chart1();
    Media_chart2();
};

/**
 * 交互后台，传输数据
 * @constructor
 */
function Ajax_data() {

}

/**
 * UV，PV百分比图
 */
function Base_chart1() {
    var myChart = echarts.init(document.getElementById('pv_uv_chart'));
    var option = document.getElementById("pv_uv_data").innerHTML;
    myChart.setOption(JSON.parse(option));
}


/**
 * 页面访问分时折线图
 */
function Base_chart2() {
    var myChart2 = echarts.init(document.getElementById('pv_zhexian'));
    var option = document.getElementById("pv_uv_data_2").innerHTML;
    myChart2.setOption(JSON.parse(option));
}

/**
 *  ip分布地域图
 * 
 */
function Base_chart3() {
    var myChart3 = echarts.init(document.getElementById('ip_map'));
    var option = document.getElementById("pv_uv_data_3").innerHTML;
    myChart3.setOption(JSON.parse(option));

}



/**
 * 
 * 选区文本词云1
 */
function Text_chart_1() {
    var option3 = {
        title: {
            text: false
        },
        tooltip: {
            show: true,
            textStyle: {
                fontSize: 10,
                fontStyle: "normal"
            }
        },
        series: [{
            name: '标记文本词云图',
            type: 'wordCloud',
            size: ['80%', '80%'],
            textRotation: [0, 45, 90, -45],
            textPadding: 0,
            autoSize: {
                enable: true,
                minSize: 14
            },
            data: [
                {
                    name: "愿得此身长报国",
                    value: 10000,
                    itemStyle: {
                        normal: {
                            color: 'black'
                        }
                    }
                },
                {
                    name: "云淡风轻",
                    value: 6181,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "映门淮水绿",
                    value: 4386,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "玉门关",
                    value: 4055,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "深闺梦里人",
                    value: 2467,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "玉颜",
                    value: 2244,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "钟声",
                    value: 1898,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "送灵澈",
                    value: 1484,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "昭阳",
                    value: 1112,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "陇西行",
                    value: 965,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "郭司仓",
                    value: 847,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "塞上曲",
                    value: 582,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "长信秋词",
                    value: 555,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "匈奴",
                    value: 462,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "杳杳钟声晚",
                    value: 366,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "留骑主人心",
                    value: 360,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "少年",
                    value: 282,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "竹林寺",
                    value: 273,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "汉家旌帜满阴山",
                    value: 265,
                    itemStyle: createRandomItemStyle()
                }
            ]
        }]
    };
    var myChart3 = echarts.init(document.getElementById('text_ciyun_1'));
    myChart3.setOption(option3);
}

/**
 * 
 * 选区文本词云2
 */
function Text_chart_2() {
    var option4 = {
        title: {
            text: false
        },
        tooltip: {
            show: true,
            textStyle: {
                fontSize: 10,
                fontStyle: "normal"
            }
        },
        series: [{
            name: '标记文本词云图',
            type: 'wordCloud',
            size: ['80%', '80%'],
            textRotation: [0, 45, 90, -45],
            textPadding: 0,
            autoSize: {
                enable: true,
                minSize: 14
            },
            data: [
                {
                    name: "古诗精选",
                    value: 10000,
                    itemStyle: {
                        normal: {
                            color: 'black'
                        }
                    }
                },
                {
                    name: "春风不度玉门关",
                    value: 6181,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "郭司仓是谁？",
                    value: 4386,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "这句写的不错",
                    value: 4055,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "春日胜景",
                    value: 2467,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "很励志",
                    value: 2244,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "很有魄力",
                    value: 1898,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "有气势",
                    value: 1484,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "好美的描述",
                    value: 1112,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "是唐玄宗吧",
                    value: 965,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "意境很美",
                    value: 847,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "好霸气",
                    value: 582,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "壮烈",
                    value: 555,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "古诗真好",
                    value: 550,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "爱国情怀",
                    value: 462,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "家国情怀",
                    value: 366,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "像是王维写的",
                    value: 360,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "作者李白",
                    value: 282,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "朱熹的诗",
                    value: 273,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "朱老夫子",
                    value: 265,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "云淡风轻",
                    value: 1265,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "杳杳两个字好听",
                    value: 965,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "好美的诗",
                    value: 565,
                    itemStyle: createRandomItemStyle()
                }
            ]
        }]
    };

    var myChart4 = echarts.init(document.getElementById('text_ciyun_2'));
    myChart4.setOption(option4);

}


/**
 * 词云图随机生成
 * @returns 
 */
function createRandomItemStyle() {
    return {
        normal: {
            color: 'rgb(' + [
                Math.round(Math.random() * 160),
                Math.round(Math.random() * 160),
                Math.round(Math.random() * 160)
            ].join(',') + ')'
        }
    };
}

/**
 * 媒体百分比数据
 * 
 */
function Media_chart1() {

    var option9 = document.getElementById("media_data_1").innerHTML;
    var myChart9 = echarts.init(document.getElementById('media_percent'));
    myChart9.setOption(JSON.parse(option9));

}

/**
 * 跳转时刻散点图
 * 
 */
function Media_chart2() {

    var option10 = document.getElementById("media_data_2").innerHTML;

    var myChart10 = echarts.init(document.getElementById('media_sandian'));
    myChart10.setOption(JSON.parse(option10));

}

// 图像行为次数柱形图
function Img_chart1() {
    var option5 = document.getElementById("img_data_1").innerHTML;

    var myChart5 = echarts.init(document.getElementById('img_action_times'));
    myChart5.setOption(JSON.parse(option5));
}


/**
 * 图像文本数据
 */
function Img_chart2() {
    var option3 = {
        title: {
            text: false
        },
        tooltip: {
            show: true,
            textStyle: {
                fontSize: 10,
                fontStyle: "normal"
            }
        },
        series: [{
            name: '标记文本词云图',
            type: 'wordCloud',
            size: ['80%', '80%'],
            textRotation: [0, 45, 90, -45],
            textPadding: 0,
            autoSize: {
                enable: true,
                minSize: 14
            },
            data: [
                {
                    name: "美丽的爱情",
                    value: 10000,
                    itemStyle: {
                        normal: {
                            color: 'black'
                        }
                    }
                },
                {
                    name: "幸福美满",
                    value: 6181,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "幸福",
                    value: 4386,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "爱情",
                    value: 4055,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "恩爱",
                    value: 2467,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "牵手",
                    value: 2244,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "亲密无间",
                    value: 1898,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "love",
                    value: 1484,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "祝福",
                    value: 1112,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "I love you",
                    value: 965,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "呵，爱情",
                    value: 847,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "略狗了",
                    value: 582,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "狗粮",
                    value: 555,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "好甜",
                    value: 550,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "发糖了",
                    value: 462,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "甜到牙疼",
                    value: 366,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "牙疼",
                    value: 360,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "甜蜜蜜",
                    value: 282,
                    itemStyle: createRandomItemStyle()
                },
                {
                    name: "祝幸福",
                    value: 273,
                    itemStyle: createRandomItemStyle()
                }
            ]
        }]
    };
    var myChart6 = echarts.init(document.getElementById('img_text_1'));
    myChart6.setOption(option3);
}