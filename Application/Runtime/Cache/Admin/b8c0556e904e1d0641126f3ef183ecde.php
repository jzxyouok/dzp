<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>大转盘抽奖活动后台</title>
</head>
<style type="text/css">
a {color:blue; text-decoration: none;}
.table-bodered{border: 1px solid #ddd;border-collapse:collapse; border-radius:5px;}
</style>
<link rel="stylesheet" href="js/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="js/bootstrap.min.css" />
<link rel="stylesheet" href="js/datetimepicker.css" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script src="js/date/WdatePicker.js"></script>
<script src="js/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="js/bootstrap-datetimepicker.js"></script>
<script>

$(function(){
	//$('.datepicker').datepicker();
	$('.datepicker').datetimepicker({
		language: 'zh-CN',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$("#addnew").click(function(){
		$.post("?act=addnew&type=", {},
		function (data, textStatus){
			if(data.errcode==0){
				alert('添加成功！');
				location.replace('?lid='+data.newid);
			}
		}, "json");
	});
      $("#info").html("");
});
</script>
<body style="font-size:13px;">
 <div style="width:940px;margin:0 auto;height:40px; margin-top:10px;background-color: #e1e1e1;">
         <a href="" style="display: block;text-decoration: none; color:#000;position:relative; left:20px; top:10px; border:1px solid #c3c3c3; width: 40px;height: 20px; text-align: center; background-image: linear-gradient(to bottom, #eeeeee 0%, #eeeeee 100%);">返回</a>    
     </div>
<div style="width:940px;margin:0 auto; margin-top:5px; border:#C3C3C3 solid 1px;border-radius: 5px;">
	<div style="text-align:left;">
	</div>

	<div style="width:940px;">
	
		<form action="" method="POST" enctype="multipart/form-data">
			<table style="font-size:13px;">
				<tr>
					<td height="60">
                                            <span style="color:#F00;">*</span>是否开启
                                        </td>    
                                        <td><input checked type="radio" name="open" value="1"/> 开 &nbsp; 
                                            <input type="radio" name="open" value="2"/> 关 &nbsp;
                                        </td>
                                </tr>
                                 <tr>
                                      <td height="60"><span style="color:#F00;">*</span>标题
                                      </td>
                                      <td>
                                            <input id="name_id" style="font-size:13px;height:30px; width:180px;-webkit-border-radius: 3px; border: 1px solid #ccc;" type="text" name="name"  value="">
                                            
                                        
                                        </td>
                                    
                                </tr>
								<tr>
                                      <td height="60"><span style="color:#F00;">*</span>抽奖次数
                                      </td>
                                      <td>
                                            <input id="times" style="font-size:13px;height:30px; width:180px;-webkit-border-radius: 3px; border: 1px solid #ccc;" type="text" name="times"  value="">
                                            
                                        
                                        </td>
                                    
                                </tr>
				<tr>
                                    <td height="60"><span style="color:#F00;">*</span>
									开始时间
								
                                        </td>
										<td>
										<input type="text" data-date="" data-date-format="yyyy-mm-dd hh:ii" value="" class="datepicker" id="start_time" name="start_time" style="width:180px;height:30px;" />
										<span style="color:#ff0000; font-size:13px;">可以精确到时分秒，如：2015-07-11 08:30</span>
									</td>
                                       
                                      
				</tr>
				<tr><td><span style="color:#F00;">*</span>
				结束时间

				</td>
				<td height="60">
										<input type="text" data-date="" data-date-format="yyyy-mm-dd hh:ii" value="" class="datepicker" id="end_time" name="end_time" style="width:180px; height:30px;" />
										<span style="color:#ff0000; font-size:13px;">可以精确到时分秒，如：2015-07-11 15:30</span>
								
				</td></tr>
                        </table><br><br>
                        <table style="font-size:13px;">
                            <tr><td align="right " height="60">奖品设置</td></tr>
                   
                            <tr>
                                <td align="right"><span style="color:#F00;">*</span>一等奖</td>
                                <td align="left" height="60">&nbsp;&nbsp;<input type="text" name="prize[1][name]" value="" style="font-size:13px;height:30px; width:200px;-webkit-border-radius: 3px; border: 1px solid #ccc;"></td>
                                <td align="right"><span style="color:#F00;">*</span>中奖概率</td>
                                <td align="left" height="60"><input type="text" name="prize[1][chance]" value="" style="font-size:13px;height:30px; width:60px;-webkit-border-radius: 3px; border: 1px solid #ccc;">%</td>
<!--                                <td align="left" height="60">奖品总数量<input type="text" name="prize[1][ptotalnum]" value="" style="height:30px; width:60px;-webkit-border-radius: 3px; border: 1px solid #ccc;"></td>
                                <td align="left" height="60">每天奖品数量<input type="text" name="prize[1][ptodaynum]" value="" style="height:30px; width:60px;-webkit-border-radius: 3px; border: 1px solid #ccc;"></td>-->
                                
                            </tr>
                            <tr> <td align="right"><span style="color:#F00;">*</span>二等奖</td>
                                <td align="left" height="60">&nbsp;&nbsp;<input type="text" name="prize[2][name]" value="" style="font-size:13px;height:30px; width:200px;-webkit-border-radius: 3px; border: 1px solid #ccc;"></td>
                                <td align="right"><span style="color:#F00;">*</span>中奖概率</td>
                                <td align="left" height="60"><input type="text" name="prize[2][chance]" value="" style="font-size:13px;height:30px; width:60px;-webkit-border-radius: 3px; border: 1px solid #ccc;">%</td>
<!--                                <td align="left" height="60">奖品总数量<input type="text" name="prize[2][ptotalnum]" value="" style="height:30px; width:60px;-webkit-border-radius: 3px; border: 1px solid #ccc;"></td>
                                <td align="left" height="60">每天奖品数量<input type="text" name="prize[2][ptodaynum]" value="" style="height:30px; width:60px;-webkit-border-radius: 3px; border: 1px solid #ccc;"></td>    -->
                            </tr>
                                <tr> <td align="right"><span style="color:#F00;">*</span>三等奖</td>
                                <td align="left" height="60">&nbsp;&nbsp;<input type="text" name="prize[3][name]" value="" style="font-size:13px;height:30px; width:200px;-webkit-border-radius: 3px; border: 1px solid #ccc;"></td>
                                <td align="right"><span style="color:#F00;">*</span>中奖概率</td>
                                <td align="left" height="60"><input type="text" name="prize[3][chance]" value="" style="font-size:13px;height:30px; width:60px;-webkit-border-radius: 3px; border: 1px solid #ccc;">%</td>
<!--                                 <td align="left" height="60">奖品总数量<input type="text" name="prize[3][ptotalnum]" value="" style="height:30px; width:60px;-webkit-border-radius: 3px; border: 1px solid #ccc;"></td>
                                <td align="left" height="60">每天奖品数量<input type="text" name="prize[3][ptodaynum]" value="" style="height:30px; width:60px;-webkit-border-radius: 3px; border: 1px solid #ccc;"></td>-->
                                </tr>
                                <tr> <td align="right"><span style="color:#F00;">*</span>四等奖</td>
                                <td align="left" height="60">&nbsp;&nbsp;<input type="text" name="prize[4][name]" value="" style="font-size:13px;height:30px; width:200px;-webkit-border-radius: 3px; border: 1px solid #ccc;"></td>
                                <td align="right"><span style="color:#F00;">*</span>中奖概率</td>
                                <td align="left" height="60"><input type="text" name="prize[4][chance]" value="" style="font-size:13px;height:30px; width:60px;-webkit-border-radius: 3px; border: 1px solid #ccc;">%</td>
<!--                                 <td align="left" height="60">奖品总数量<input type="text" name="prize[4][ptotalnum]" value="" style="height:30px; width:60px;-webkit-border-radius: 3px; border: 1px solid #ccc;"></td>
                                <td align="left" height="60">每天奖品数量<input type="text" name="prize[4][ptodaynum]" value="" style="height:30px; width:60px;-webkit-border-radius: 3px; border: 1px solid #ccc;"></td>-->
                                </tr>
                                 <tr>
                                <td align="left" height="60">&nbsp;&nbsp;<input type="hidden" name="prize[5][name]" value="谢谢参与" style="height:30px; width:200px;-webkit-border-radius: 3px; border: 1px solid #ccc;"></td>
                            
                                <td align="left" height="60"><input type="hidden" name="prize[5][chance]" value="8000" style="height:30px; width:50px;-webkit-border-radius: 3px; border: 1px solid #ccc;"></td>
                                </tr>
                            
                        </table>
                         <table class='table-bodered' style="font-size:13px;" width='900'>
                            <tr>
                                <td height="60"><p style="color:#F00;">注意:<br>填写的中奖概率越大，中奖机会越高，未中奖的概率是100%减去四个奖品概率的总和，如果想让未中奖概率最大，四个奖品相加的概率之和不能大于未中奖概率，且四个奖品之和不能大于100%，如果大于100%，未中奖的概率为0，也就是百分百中奖。</td>
                            
                               
                                </tr>
                        </table><br><br>
		

                       
                                <table class='table-bodered' style="font-size:13px;" width='900'>
			
				<tr>
                                    <td width="60" height="30" colspan="8">活动描述 : <textarea name="desc" style="width:500px; height:200px;font-size:13px;"></textarea></td>
				</tr>
                                <tr>
					<td width="60" height="30" colspan="8">-----------------------------</td>
				</tr>
				 <tr>
                                     <td width="60" height="30" colspan="8"><span style="color:#F00;">*</span>上传logo图片 : <input type="file" style="font-size:13px;" name="fileupload" value="上传" /><span id="info" style="color:#F00;font-size:16px;"></span></td>
				 </tr>
				 
				 <tr>
					<td width="60" height="30" colspan="8">-----------------------------</td>
				</tr>
			
				
			</table>
			<br><br>
			<table  class='table-bodered' style="font-size:13px;" width='900'>
				<tr>
                <td height="30">
                <select name="account" style="font-size:13px;">
                                      
                <option value=""></option>
                                       
                </select></td>				 
				</tr>
                <tr>
                <td>
                <select name="team" style="font-size:13px;"><option value=""></option>
                </select>
                </td>
                </tr>
				<tr>
					<td height="30"><input type="submit" value="保存" style="width:100px;height:30px;font-size:13px;" /></td>
				</tr>
			</table>
		</form>
	</div>
</div>
</body>
</html>