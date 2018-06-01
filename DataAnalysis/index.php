<?php
    include "server/analysis.php";
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>User Action Data Analysis</title>
	<link rel="stylesheet" href="assets/css/amazeui.css" />
	<link rel="stylesheet" href="assets/css/core.css" />
	<link rel="stylesheet" href="assets/css/menu.css" />
	<link rel="shortcut icon" href="assets/img/icon.ico" type="image/x-icon">
</head>

<body>
	<!-- Begin page -->
	<header class="am-topbar am-topbar-fixed-top">
		<div class="am-topbar-left am-hide-sm-only">
			<a href="index.php" class="logo">
				<span>User Action Data Analysis</span>
				<i class="zmdi zmdi-layers"></i>
			</a>
		</div>

		<div class="contain">
			<ul class="am-navbar-right button">
				<li class="inform">
					<a href="../UserAction/heatmap.php" class="heatmap" target="_blank">Heatmap</a>
				</li>
				<li class="inform">
					<a href="../UserAction/index.html" target="_blank" class="heatmap">TestPage</a>
				</li>
				<li class="inform">
					<a href="" class="heatmap">Refresh</a>
				</li>
			</ul>
		</div>
	</header>
	<!-- end page -->

	<div class="admin">
		<div class="content-page div_height_0">

			<!-- 1. 基础用户信息栏 -->
			<div id="diy_nav">
				<h4 class="page-title">访问信息</h4>
				<hr id="hr_diy">
			</div>
            <?php
                echo "<p id='pv_uv_data' style='display: none'>";
                echo  Base_Chart_1("data");
                echo "</p>"
            ?>
            <div class="am-g div_height">
				<!-- 页面总访问量 -->
				<div class="div_height_0 am-u-md-4 ">
					<div class="div_height_0 card-box ">
						<h4 class="header-title m-t-0 m-b-30">页面总访问量</h4>
						<div id="pv_uv_chart" style="height: 100%;width:75%;float: left;"></div>
						<div id="pv_uv_text">
							<div class="widget-detail-1">
								<h2 class="p-t-10 m-b-0"><?php  echo  Base_Chart_1("PV");?> </h2>
								<p class="text-muted">PV总量</p>
							</div>
							<div class="widget-detail-1">
                                <h2 class="p-t-10 m-b-0"> <?php  echo  Base_Chart_1("UV");?></h2>
								<p class="text-muted">UV总量</p>
							</div>
						</div>
					</div>
				</div>

				<!-- 访问量分日图 -->
                <?php
                echo "<p id='pv_uv_data_2' style='display: none'>";
                echo  Base_Chart_2();
                echo "</p>"
                ?>
				<div class="am-u-md-4 div_height_0">
					<div class="card-box div_height_0">
						<h4 class="header-title m-t-0 m-b-30">当日访问量分时图</h4>
						<div id="pv_zhexian" style="height: 100%;width: 100%;float: left;">
						</div>
					</div>
				</div>

				<!-- 访问IP地域分布图 -->
                <?php
                echo "<p id='pv_uv_data_3' style='display: none'>";
                echo  Base_Chart_3();
                echo "</p>"
                ?>
				<div class="am-u-md-4 div_height_0">
					<div class="card-box div_height_0">
						<h4 class="header-title m-t-0 m-b-30">访客地域分布图</h4>
						<div id="ip_map" style="height: 90%;width: 100%;float: left;">
						</div>
					</div>
				</div>
			</div>

			<!-- 2. 文本标注 -->
			<div id="diy_nav">
				<h4 class="page-title">文本行为</h4>
				<hr id="hr_diy">
			</div>
			<!-- Row start -->
			<div class="am-g div_height_1">
				<div class="am-u-md-6 div_height_0">
					<div class="card-box div_height_0">
						<h4 class="header-title m-t-0">选中文本-词云图</h4>
						<div id="text_ciyun_1" style="height: 115%;width: 100%;float: left;"></div>
					</div>
				</div>
				<div class="am-u-md-6 div_height_0">
					<div class="card-box div_height_0">
						<h4 class="header-title m-t-0">标记文本-词云图</h4>
						<div id="text_ciyun_2" style="height: 115%;width: 100%;float: left;"></div>
					</div>
				</div>
			</div>

			<!-- 3. 媒体行为 -->
			<div id="diy_nav">
				<h4 class="page-title">媒体行为</h4>
				<hr id="hr_diy">
			</div>

            <?php
            echo "<p id='media_data_1' style='display: none'>";
            echo  Media_Chart_1();
            echo "</p>"
            ?>
			<div class="am-g div_height_3">
				<div class="am-u-md-6 div_height_0">
					<div class="card-box div_height_0">
						<h4 class="header-title m-t-0">音频各项行为占比图</h4>
						<div id="media_percent" style="height: 100%;width: 100%;float: left;"></div>
					</div>
				</div>
                <?php
                echo "<p id='media_data_2' style='display: none'>";
                echo   Media_Chart_2();
                echo "</p>"
                ?>
				<div class="am-u-md-6 div_height_0">
					<div class="card-box div_height_0">
						<h4 class="header-title m-t-0">媒体跳转播放时刻散点图</h4>
						<div id="media_sandian" style="height: 100%;width: 100%;float: left;"></div>
					</div>
				</div>
			</div>

			<!-- 4. 图像行为 -->
			<div id="diy_nav">
				<h4 class="page-title">图像行为</h4>
				<hr id="hr_diy">
			</div>
            <?php
            echo "<p id='img_data_1' style='display: none'>";
            echo  Img_Chart_1();
            echo "</p>"
            ?>
			<div class="am-g div_height_2">
				<div class="am-u-md-6 div_height_0">
					<div class="card-box div_height_0">
						<h4 class="header-title m-t-0">图像行为次数条形图</h4>
						<div id="img_action_times" style="height: 105%;width: 100%;float: left;"></div>
					</div>
				</div>
				<div class="am-u-md-6 div_height_0">
					<div class="card-box div_height_0">
						<h4 class="header-title m-t-0">图片标注内容词云图(Img_1)</h4>
						<div id="img_text_1" style="height: 115%;width: 100%;float: left;"></div>
					</div>
				</div>
			</div>

		</div>
	</div>

	<div class="bottom_div">
		<footer class="foot">
			<h3>User Action Data Analysis Page.</h3>
			<p>Copyright © Shijie Liu. 2018. Wuhan University.</p>
		</footer>
	</div>


</body>
<script type="text/javascript" src="http://echarts.baidu.com/build/dist/echarts-all.js"></script>
<script type="text/javascript" src="assets/js/mychart.js"></script>

</html>