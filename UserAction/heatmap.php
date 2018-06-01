<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="author" content="Liu Shijie">

    <title>鼠标轨迹热力图</title>
    <link href="assets/img/icon/icon.ico" rel="shortcut icon" />

    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS-->
    <link href="assets/css/general.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body id="home">
<?php
    include "../DataAnalysis/server/analysis.php";
    echo "<p id='heatmapdata' style='display: none'>";
    echo Heatmap();
    echo "</p>"
?>
    <!-- Preloader -->
    <div id="preloader">
        <div id="status"></div>
    </div>

    <!-- FullVideo_Area -->
    <div class="intro-header">
        <div class="col-xs-12 text-center abcen1">
            <h1 class="h1_home wow fadeIn">测试页面</h1>
            <h3 class="h3_home wow fadeIn">用户网络阅读行为数据实时收集系统</h3>
        </div>
    </div>

    <!-- NavBar-->
    <nav class="navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#home" id="link_0">TestPage</a>
            </div>

            <div class="collapse navbar-collapse navbar-right navbar-ex1-collapse">
                <ul class="nav navbar-nav">

                    <li class="menuItem">
                        <a href="#Text_Area" id="link_1">文本</a>
                    </li>
                    <li class="menuItem">
                        <a href="#Img_Area" id="link_2">图像</a>
                    </li>
                    <li class="menuItem">
                        <a href="#Audio_Area" id="link_3">声频</a>
                    </li>
                    <li class="menuItem">
                        <a href="#Video_Area" id="link_4">视频</a>
                    </li>
                    <li class="menuItem">
                        <a href="#Form_Area" id="link_5">表单</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Text -->
    <div id="Text_Area" class="content-section-b" style="border-top: 0">
        <div class="container">

            <div class="col-md-6 col-md-offset-3 text-center wrap_title">
                <p class="lead" style="margin-top:0">下面这些文本，如果你觉得不错，可以框选或者复制它。</p>
            </div>

            <div class="row">

                <div class="col-sm-4 text-center">
                    <img class="rotate" src="assets/img/icon/book.svg">
                    <h3>《春日偶成》</h3>
                    <p class="lead">云淡风轻近午天，傍花随柳过前川。
                        <br>时人不识余心乐，将谓偷闲学少年。</p>
                </div>

                <div class="col-sm-4 text-center">
                    <img class="rotate" src="assets/img/icon/bank.svg">
                    <h3>《送郭司仓》</h3>
                    <p class="lead">映门淮水绿，留骑主人心。
                        <br>明月随良掾，春潮夜夜深。</p>
                </div>

                <div class="col-sm-4 text-center">
                    <img class="rotate" src="assets/img/icon/beacon.svg">
                    <h3>《塞上曲》</h3>
                    <p class="lead">汉家旌帜满阴山，不遣胡儿匹马还。
                        <br>愿得此身长报国，何须生入玉门关。</p>
                </div>
            </div>

            <div class="row tworow">

                <div class="col-sm-4  text-center">
                    <img class="rotate" src="assets/img/icon/bulb.svg">
                    <h3>《陇西行》</h3>
                    <p class="lead">誓扫匈奴不顾身，五千貂锦丧胡尘。
                        <br>可怜无定河边骨，犹是深闺梦里人。 </p>
                </div>

                <div class="col-sm-4 text-center">
                    <img class="rotate" src="assets/img/icon/letter.svg">
                    <h3>《送灵澈》</h3>
                    <p class="lead">苍苍竹林寺，杳杳钟声晚。
                        <br>荷笠带斜阳，青山独归远。</p>
                </div>

                <div class="col-sm-4 text-center">
                    <img class="rotate" src="assets/img/icon/clipboard.svg">
                    <h3>《长信秋词》</h3>
                    <p class="lead">奉帚平明金殿开，且将团扇暂徘徊。
                        <br>玉颜不及寒鸦色，犹带昭阳日影来。</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Picture -->
    <div id="Img_Area" class="content-section-a">

        <div class="col-md-6 col-md-offset-3 text-center wrap_title">
            <p class="lead" style="margin-top:0">下面这些图片，如果你觉得不错，可以复制或者保存它。</p>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="services">
                        <img class="img-responsive" src="assets/img/img-1.jpg" id="MyImg_1">
                        <!-- <a href="" id="annotate_save_btn"></a> -->
                        <div class="desc">
                            <h3>
                                <a href="javascript:void(0);">Love</a>
                            </h3>
                            <p>This picture descripes a scene of pretty love.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="services">
                        <img class="img-responsive" src="assets/img/img-2.jpg" id="MyImg_2">
                        <div class="desc">
                            <h3>
                                <a href="javascript:void(0);">Holy</a>
                            </h3>
                            <p>This picture descripes a scene of Holy pray.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="services">
                        <img class="img-responsive" src="assets/img/img-3.jpg" id="MyImg_3">
                        <div class="desc">
                            <h3>
                                <a href="javascript:void(0);">Reading</a>
                            </h3>
                            <p>This picture descripes a scene of reading books.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="services">
                        <img class="img-responsive" src="assets/img/img-4.jpg" id="MyImg_4">
                        <div class="desc">
                            <h3>
                                <a href="javascript:void(0);">Flower</a>
                            </h3>
                            <p>This picture descripes a scene of beautiful flowers.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="services">
                        <img class="img-responsive" src="assets/img/img-5.jpg" id="MyImg_5">
                        <div class="desc">
                            <h3>
                                <a href="javascript:void(0);">Time</a>
                            </h3>
                            <p>This picture descripes a scene of quiet time.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="services">
                        <img class="img-responsive" src="assets/img/img-6.jpg" id="MyImg_6">
                        <div class="desc">
                            <h3>
                                <a href="javascript:void(0);">Kite</a>
                            </h3>
                            <p>This picture descripes a scene of flying a kite.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Music -->
    <div id="Audio_Area" class="content-section-b">
        <div class="container">
            <div class="row">

                <div class="col-md-6 col-md-offset-3 text-center wrap_title">
                    <p class="lead" style="margin-top:0">下面这段音乐，你可以尽情欣赏它，支持跳转播放进度。</p>
                </div>
                <div class="myrow">

                    <div id="fansile" class="col-sm-12">
                        <div class="row">
                            <div class="col-md-4 box-icon rotate music" style="margin-right:45px">
                                <i class="fa fa-4x"> </i>
                            </div>
                            <div>
                                <div class="box-ct">
                                    <h3>Auld lang syne</h3>
                                    <p>苏格兰著名民歌，中文译作《友谊天长地久》，这是Charlie Landsborough演唱的版本。</p>
                                </div>
                                <div class="myaudio" id="myaudio">
                                    <audio controls name="audio" id="MyAudio">
                                        <source src="assets/media/test.mp3" type="audio/mp3">
                                    </audio>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Video -->
    <div id="Video_Area" class="content-section-a">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 text-center wrap_title ">
                    <p class="lead" style="margin-top:0">下面这段视频，你可以尽情观看它，支持跳转播放进度。</p>
                </div>
            </div>
            <div class="row">
                <video controls="controls" name="video" width="100%" height="100%" id="MyVideo">
                    <source src="assets/media/test.mp4" type="video/mp4">
                </video>
            </div>
        </div>


    </div>

    <div class="morph-button zhenfan">
        <button display:none></button>
    </div>


    <!-- Form -->
    <div id="Form_Area" class="content-section-b">
        <div class="container">
            <div class="row opinion">
                <div class="col-md-6 col-md-offset-3 text-center">
                    <p class="lead" style="margin-top:0">下面是表单区，希望可以留下您的评论和意见。</p>
                </div>

                <form role="form" method="post" id="Myform" action="server/form.php" target="frameFile">
                    <div class="col-md-6 fanform">
                        <div class="form-group">
                            <label for="InputName">您的姓名</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="InputName" id="Input_Name" placeholder="请输入您的姓名" required>
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-ok form-control-feedback"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="InputMessage">评论和意见</label>
                            <div class="input-group">
                                <textarea name="InputMessage" id="Input_Message" class="form-control" rows="7" placeholder="请留下您宝贵的评论和意见" required></textarea>
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-ok form-control-feedback"></i>
                                </span>
                            </div>
                        </div>
                        <input type="submit" name="submit" id="submit" class="btn wow tada btn-embossed btn-primary pull-right" style="width:120px;height:45px"
                            onclick="form_submit()">
                    </div>
                </form>
                <iframe name='frameFile' style='display: none;'></iframe>
                <hr class="featurette-divider hidden-lg">
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="myfoot">
                    <h3 class="footer-title">Thank You!</h3>
                    <p>Copyright &#169; <a href="../DataAnalysis/index.php">Shijie Liu.2018.</a>  Wuhan University.
                    </p>

                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="assets/js/modernizr-2.6.2.min.js"></script>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/owl.carousel.js"></script>
    <script src="assets/js/script.js"></script>

    <!-- StikyMenu -->
    <script src="assets/js/stickUp.min.js"></script>
    <script type="text/javascript">
        jQuery(function ($) {
            $(document).ready(function () {
                $('.navbar-default').stickUp();
            });
        });
    </script>

    <!-- Smoothscroll -->
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/uiMorphingButton_inflow.js"></script>
    <script src="assets/js/jquery.magnific-popup.js"></script>
    <script type="text/javascript"> document.getElementById("MyAudio").volume = 0.6; </script>
    <script type="text/javascript"> document.getElementById("MyVideo").volume = 0.6; </script>

<script src="mytool/js/heatmap.js"></script>
<script type="text/javascript">
    // 创建一个heatmap实例对象
    // 这里直接指定热点图渲染的div了.heatmap支持自定义的样式方案,网页外包接活具体可看官网api
    var heatmapInstance = h337.create({
        container: document.querySelector('#home'),
    });

    var option = document.getElementById("heatmapdata").innerText;
    var data = JSON.parse(option);

    heatmapInstance._renderer.setDimensions(document.body.scrollWidth, document.body.scrollHeight);
    heatmapInstance.setData(data);
</script>

</body>

</html>