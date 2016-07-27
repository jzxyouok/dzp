<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php echo ($name); ?></title>
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, minimum-scale=1.0, user-scalable=no">    
<script src="/dzp/Public/js/jquery-1.7.2.min.js">
</script>
<script src="/dzp/Public/js/jquery.flexslider-min.js">
</script>
<script src="/dzp/Public/js/common.js">
</script>
<link href="/dzp/Public/css/index.css?b=10" rel="stylesheet">
<script src="/dzp/Public/js/index.js?v=1.1">
</script>
<script type="text/javascript">
        var mengvalue = 2;
        //if(mengvalue<0){mengvalue=0;}
        var phoneWidth = parseInt(window.screen.width);
        var phoneScale = phoneWidth / 640;

        var ua = navigator.userAgent;
        if (/Android (\d+\.\d+)/.test(ua)) {
                var version = parseFloat(RegExp.$1);
                // andriod 2.3
                if (version > 2.3) {
                        document.write('<meta name="viewport" content="width=640, minimum-scale = ' + phoneScale + ', maximum-scale = ' + phoneScale + ', target-densitydpi=device-dpi">');
                        // andriod 2.3以上
                } else {
                        document.write('<meta name="viewport" content="width=640, target-densitydpi=device-dpi">');
                }
                // 其他系统
        } else {
                document.write('<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">');
        }
</script>
    </head>

    <body>
        <div style='position: absolute; left:0px; top:0px;z-index: 999;'><img src="<?php echo ($logo); ?>" height="64" width="64"/></div>
        <form method="post" action="<?php echo U('poll/index',array('activeid'=>$activeid,'trafficid'=>$trafficid));?>" id="form1">
            <div class="block_huo_slider">
                <div class="flexslider" style="background: url('/dzp/Public/images/top.png') no-repeat; width:640px;height:349px;">
                    
                </div>
            </div>
            <div class="main">
                <div class="search" style="height:52px;line-height:52px;">
                    <div class="search-input" style="line-height:52px;width:320px;">
                        <input name="search_key" type="text" value="" placeholder="请输入选手编号/姓名">
                        <input name="openid" type="hidden" value="<?php echo ($openid); ?>">
                    </div>
                    <div class="search-btn">
                        <a href="javascript:;" onclick="$('#form1').submit();">
                            搜索
                        </a>
                    </div>
<!--                    <div class="search-btn" style="margin-left:8px;">
                        <a href="">
                            查看规则
                        </a>
                    </div>-->
                </div>
                <style type="text/css">
		        .infobtn .btn {
				  width: 90%;
				  overflow: hidden;
				  background: #ffed3d;
				  border-radius: 6px;
				  height: 54px;
				  line-height: 54px;
				  display: block;
				  text-align: center;
				  color: #d5005c;
				  font-size: 26px;
				}
        		</style>
                <div class="inlist" id="memberList">
                <?php echo ($emphtml); ?>
<!--					<div style="float:left;width: 50%;position:relative">
						<div><img style="width:90%;padding-left:8px;" src="/dzp/Public/images/member_bg.png" /></div>
						
						<div style="position:absolute;top:58px;left:96px;"><a href=""><img width="136" height="136" style="border-radius:68px;" src="" /></a></div>
						
						<div style="position:absolute;top:226px;left:92px;font-size:26px;color:#151d50; font-weight: bold;width:60px;text-align:center;">号</div>
						<div style="position:absolute;top:212px;left:140px;font-size:26px;color:#151d50; font-weight: bold;width:120px;text-align:center;"></div>
						
                                                <div style="margin-top:8px;text-align:center;"><span style="color:#FFF;font-size:18px;">排名：票数：</span></div>
						<div style="margin-top:8px;margin-left:40px;letter-spacing:6px;" class="infobtn"><a href="" class="btn">投Ta一票</a></div>
					</div>-->
                           
                  
                </div>
                        <div class="inlist" id="memberList" style="margin-left:40px;margin-top: 30px;color: #FFF;">
                            <?php echo ($regulation); ?>
                        </div>
            </div>
        
        </form>
    </body>

</html>