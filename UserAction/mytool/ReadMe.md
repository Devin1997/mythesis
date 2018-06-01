	
	1. 插件简介
	-------------------------------------------------------------------------------
	** 基于客户端的用户行为数据收集插件  V1.0
	** 本插件利用原生js在客户端(Browser)收集用户各类行为数据，具有通用性
	** 数据收集以页面一次Session会话为基准，页面关闭和刷新前提交数据，收集完成
	** 注意：本插件仅以兼容Chrome平台开发，能否兼容其余浏览器不做保证
	
	** Copyright © Shijie Liu. Wuhan University.
	** Document Time: 2018-4-16

	
	2. 数据说明
	-------------------------------------------------------------------------------
	** 本插件可收集30项用户数据，如下：
	
		1. 访问信息：PV、UV、IP、IP地域、访问时间、访问时长
		2. 文本行为：文本框选内容、是否复制、标注内容
		3. 图像行为：图片打开次数、复制次数、复制链接次数、保存次数、图片url、标记行为(标记次数、标记起始位置、标记结束位置、标记内容)
		4. 媒体行为：媒体是否播放、跳转播放次数、跳转播放的时间点、是否播放完完毕、是否缓冲等待、是否调节音量、媒体长度、总播放时长
		5. 表单行为：表单点击次数、是否填写、填写内容、停留时长
		6. 链接行为：链接点击次数、链接url
		7. 鼠标轨迹：用户全局浏览的鼠标位置，以heatmap.js所需的数据格式记录，可用于制作网页热力图
		
	** 全部数据在sessionStorage中实时存储，可在Chrome调试中查看
	** 全部数据的数据类型、统计规则等细节，在data目录下data_norms.json文件有详细说明
	** 时长的统计均以秒为单位记录，保留两位小数点。
		
	
	3. 文件说明
	-------------------------------------------------------------------------------
	** js：  全部脚本程序，capture.js为自行开发，其余为第三方js插件，对其有部分修改
	** css： 图像标注所需css样式、图标、图片等文件
	** data：数据存放目录，以时间命名，文件格式.json
	
	
	4. 使用说明
	-------------------------------------------------------------------------------
	** 使用本插件，除annotator.min.js外，在HTML头部引入mytool目录下的js即可

		<script src="mytool/js/capture.js"></script>   									 // 主程序
		<script src="mytool/js/annotorious.min.js"></script>						 	 // 图像标注
		<script src="mytool/js/clipboard.min.js"></script>								 // 剪贴板
		<script src="http://pv.sohu.com/cityjson?ie=utf-8"></script>					 // IP查询

		<link type="text/css" rel="stylesheet" href="mytool/css/annotorious.css" /> 	 // 图像标注css
	
	  
    <script src="mytool/js/annotator.min.js"></script>									 //文本标注，需要加载在文档底部！
    <script>																			 //文本标注初始化程序
        if (typeof annotator === 'undefined') {
            alert("Oops! it looks like you haven't built Annotator. ");
        } else {
            var app = new annotator.App();
            app.include(annotator.ui.main);
            app.start();
        }
    </script>