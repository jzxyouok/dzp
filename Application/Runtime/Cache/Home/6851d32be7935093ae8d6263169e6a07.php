<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<title>
<?php echo ($name); ?>
</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=no" /> 
<!--移动端版本兼容 end -->
<link href="/tp_activity/Public/css/example.css" rel="stylesheet" type="text/css">
<link href="/tp_activity/Public/css/weui.css" rel="stylesheet" type="text/css">
<style type="text/css">
    body{font: normal 100% Helvetica, Arial, sans-serif;color:#fff;background-color: #e62d2d;}
</style>
</head>
<body>
<div id="bg">
    <div style="margin-top: 5px;"><img src="<?php echo ($logo); ?>" height="64" width="64"/></div>
<div id="msgbox" style="margin:0 auto;text-align: center;width:50%;">

        <div style="margin-top: 30px;text-align: center;" id="msgspan">
              恭喜获得<?php echo ($grade); ?>哦~~
        </div>
        <div style="margin-left:10px;margin-top:30px;text-align:left;">姓名:<?php echo ($username); ?></div>
        <div style="margin-left:10px;margin-top:30px;text-align:left;">电话:<?php echo ($phone); ?></div>
        <div style="margin-left:10px;margin-top:30px;text-align:left;">地址:<?php echo ($address); ?></div>
        <?php if($is_send_prize == 0 ): ?><div style="margin:0 auto;margin-top:30px;"><a href="<?php echo U('Dzp/submit',array('openid'=>$openid,'trafficid'=>$trafficid,'activeid'=>$activeid,'grade'=>$grade));?>" class="weui_btn weui_btn_default">修改信息</a></div>
        <?php elseif($is_send_prize == 1 ): ?>
        <div style="margin:0 auto;margin-top: 30px;"><a href="javascript:;" class="weui_btn weui_btn_default">您的奖品已发出</a></div><?php endif; ?>
        
</div>
</div>
<script type="text/javascript" src="/tp_activity/Public/js/jquery-1.7.2.min.js"></script>
</body> 

</html>