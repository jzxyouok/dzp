<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>ThinkPHP JQuery Ajax 实现示例</title>
<script type="text/javascript" src="/think/Public/js/jquery.js"></script>
<script type="text/javascript" src="/think/Public/js/jquery.form.js"></script>
<script language="JavaScript">
function checkName(){
    $.post('<?php echo U("Home/Index/index");?>',{'username':$('#username').val()},function(data){
        alert(data.content);
        
        $('#result').html(data.data).show();
		$("#result").fadeOut(4000);
    },'json');
}

//$(function(){
//	$('#form1').ajaxForm({
//                url:'<?php echo U("Index/add");?>',
//                dataType: 'json',
////		beforeSubmit:  checkForm,  // pre-submit callback
//		success:function(data){
////                    alert(data);
////                            if(data.status==1){
////                                $('#result').html(data.info).show();
////                                // 更新列表
////                                username = data.data;
////                                $('#list').html('<span style="color:blue">'+username+'你好!</span>');
////                            }else{
////                                $('#result').html(data.info).show();
////                                            // 隐藏上次遗留的信息
////                                            $('#list').hide();
////                            }
//                        } // post-submit callback
//		
//	});
//	function checkForm(){
//		if( '' == $.trim($('#username').val())){
//			$('#result').html('用户名不能为空！').show();
//			$("#result").fadeOut(4000);
//			$('#username').focus();
//			return false;
//		}
//		// 可以在此添加其它判断
//	}
//});

//-->
</script>
</head>
<body>
<div>
<div id="result"></div>
<div id="list"></div>
<form name="login" id="form1" method="post">
    用户名: <input type="text" name="name" id="username" />
<input type="button" value="检查用户名" onClick="checkName()"><br />
密 码: <input type="password" name="password" /><br />
<!--<input type="hidden" name="ajax" value="1">-->
<input type="submit" value="提 交">
</form>
</div>
</body>
</html>