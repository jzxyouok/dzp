<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>
<body>
<!--<?php if(is_array($list)): $i = 0; $__LIST__ = array_slice($list,0,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($vo["name"]); ?>:<?php echo ($vo["password"]); ?></br><?php endforeach; endif; else: echo "" ;endif; ?>-->
<!--<?php if(is_array($list)): foreach($list as $k=>$vo): echo ($k); ?>:<?php echo ($vo["name"]); ?><br><?php endforeach; endif; ?>-->
<!--<?php $__FOR_START_1195__=1;$__FOR_END_1195__=101;for($i=$__FOR_START_1195__;$i < $__FOR_END_1195__;$i+=1){ echo ($i); ?></br><?php } ?>-->
<!--<?php switch($list): case "1": ?>value1<?php break;?>
    <?php case "2": ?>value2<?php break;?>
    <?php default: ?>default<?php endswitch;?>-->
<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><!--<?php if(($vo["name"]) == "1"): echo ($vo["name"]); endif; ?>-->
<?php if(($vo["name"]) == "1"): echo ($vo["name"]); endif; endforeach; endif; else: echo "" ;endif; ?>
</body>
</html>