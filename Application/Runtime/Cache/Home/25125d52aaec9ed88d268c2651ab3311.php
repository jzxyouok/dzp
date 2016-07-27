<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<title><?php echo ($name); ?>
</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=no" /> 
<!--移动端版本兼容 end -->
    <link href="/dzp/Public/css/modaldefault.css" rel="stylesheet" type="text/css">
<style type="text/css">
    body{font: normal 100% Helvetica, Arial, sans-serif;color:#fff;background-color: #e62d2d;}
    .orange {
        color: #fef4e9;
        border: solid 1px #da7c0c;
        background: #f78d1d;
        background: -webkit-gradient(linear, left top, left bottom, from(#faa51a), to(#f47a20));
        background: -moz-linear-gradient(top, #faa51a, #f47a20);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#faa51a', endColorstr='#f47a20');
    }

    .orange:hover {
        background: #f47c20;
        background: -webkit-gradient(linear, left top, left bottom, from(#f88e11), to(#f06015));
        background: -moz-linear-gradient(top, #f88e11, #f06015);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f88e11', endColorstr='#f06015');
    }

    .orange:active {
        color: #fcd3a5;
        background: -webkit-gradient(linear, left top, left bottom, from(#f47a20), to(#faa51a));
        background: -moz-linear-gradient(top, #f47a20, #faa51a);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f47a20', endColorstr='#faa51a');
    }

    .button:active {
        position: relative;
        top: 1px;
    }
    .button:hover {
        text-decoration: none;
    }
    .button {
        display: inline-block;
        zoom: 1;
        vertical-align: baseline;
        margin: 0 2px;
        margin-top: 40px;;
        outline: none;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        font: 14px/100% Arial, Helvetica, sans-serif;
        padding: 1em 4em 1em;
        text-shadow: 0 1px 1px rgba(0,0,0,.3);
        -webkit-border-radius: .5em;
        -moz-border-radius: .5em;
        border-radius: .5em;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
        -moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
        box-shadow: 0 1px 2px rgba(0,0,0,.2);
    }
</style>
</head>
<body>
<div class="md-modal md-effect-15" id="modal-15">
    <div class="md-content">
        <h3>提示</h3>
        <div>
            <p>提交成功</p>
            <button class="md-close" onclick='close_modal("<?php echo ($url); ?>")'>确定</button>
        </div>
    </div>
</div>
<div class="md-overlay"></div>
<div style='position: absolute; left:0px; top:0px;z-index: 999;'><img src="<?php echo ($logo); ?>" height="64" width="64"/></div>
<div style="margin: 0 auto; margin-top: 40px;">
        <div style="color:#FFF;text-align: center;font-size:20px;" id="msgspan">
         恭喜获得<?php echo ($grade); ?>哦~~
        </div>
        <div style="color:#FFF;text-align: center;">
            <form id="from1" method="POST">
            <table width="300" align="center">
                <tr><td height="60" width="80" align="center"><span style="color:#FFF;">姓名</span></td>
                    <td width="220" align="left"><input type="text" id="name" name="name" value="<?php echo ($username); ?>" placeholder="您的姓名" onblur="if(this.value==''){$('#name').attr('placeholder','您的姓名不能为空'); return false;}" style="font-size: 16px;height:40px;width: 200px; background-color: #FFF; border:#FFF solid 1px; border-radius: 5px;"></td></tr>
                <tr><td height="60" width="80" align="center"><span style="color:#FFF;">电话</span></td>
                    <td width="220" align="left"><input type="text" id="phone" name="phone" value="<?php echo ($phone); ?>" placeholder="您的手机号码" onblur="if(this.value==''){$('#phone').attr('placeholder','您的手机号码不能为空'); return false;}" style=" font-size: 16px;height:40px;width: 200px; background-color: #FFF; border:#FFF solid 1px; border-radius: 5px;"></td></tr>
                <tr><td height="60" width="80" align="center"><span style="color:#FFF;">地址</span></td>
                    <td width="220" align="left"><input type="text" id="address" name="address" value="<?php echo ($address); ?>" placeholder="您的地址" style="font-size: 16px;height:40px;width: 200px; background-color: #FFF; border:#FFF solid 1px; border-radius: 5px;"></td></tr>
            </table>
                <div><input type="submit" value="提交信息" class="orange button" /></div>
            </form>   
        </div>
            <!--<div style="text-align:left; width:auto; margin: 0 auto;">请提交您的个人信息<br>我们会在第一时间联系您哦~</div>-->

</div>
<script type="text/javascript" src="/dzp/Public/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/dzp/Public/js/jquery.form.js"></script>
<script type="text/javascript" src="/dzp/Public/js/classie.js"></script>
<script type="text/javascript" src="/dzp/Public/js/modalEffects.js"></script>
<script type="text/javascript">
//验证手机号码

function checkTel(){
var tel = $("#phone").val(); //获取手机号
if(tel==''){
  $('#phone').attr('placeholder','您的手机号码不能为空');
  return false;
}else{
var telReg = !!tel.match(/^(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/);
//如果手机号码不能通过验证
if(telReg == false){
 // alert('ok');
$('#phone').val('');
$('#phone').attr('placeholder','您的手机号码格式不对');
return false;
}


}
}

$(function(){
    
       $("#from1").ajaxForm({
            
            url:'<?php echo U("Dzp/post");?>',
            dataType:'json',
            beforeSubmit:  checkForm,
            data:{
                trafficid:"<?php echo ($trafficid); ?>",
                activeid:"<?php echo ($activeid); ?>",
                prizeid:"<?php echo ($grade); ?>",
                openid:"<?php echo ($openid); ?>"
            },
            success:function(data){
                $(".md-effect-15").addClass('md-show');
                var trafficid='<?php echo ($trafficid); ?>';
                var grade= '<?php echo ($grade); ?>';
                var activeid="<?php echo ($activeid); ?>";
                var openid = "<?php echo ($openid); ?>";
            }
           
       });
    
    
});

function checkForm(){
    if($('#name').val()==''){
       $('#name').attr('placeholder','您的姓名不能为空');
       return false;
    }else{
       return checkTel();
    }
}
function close_modal(url) {
    if(url){
        location.href = url;
    }else{
        WeixinJSBridge.invoke('closeWindow',{
            },function(res){

                //alert(res.err_msg);

        });
    }

}

</script>



</body> 

</html>