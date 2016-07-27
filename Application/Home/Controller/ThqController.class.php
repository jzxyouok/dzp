<?php
namespace Home\Controller;
use Think\Controller;
class ThqController extends Controller{
    
       /*
     * 作用:当执行其他方法时,先执行该方法,判断是否有openid和流量id
     */
    public function __construct(){
        parent::__construct();
        $openid=I('request.openid');
        $trafficid=I('request.trafficid');
        if(empty($openid)||empty($trafficid)){
        $this->redirect('Auth/authLogin',array('activeid'=>I('get.activeid')));
        }
    }
    /*
     * 作用:输出桃花签的页面元素
     */
    public function index(){
        //通过活动id查询出活动相关信息
        $thq = M('app_activities');
        $thqRes = $thq ->field('app_activities.name,app_activities.logo_url,app_activities.regulation,app_activity_thq_details.is_open')->join('app_activity_thq_details on app_activity_thq_details.activity_id=app_activities.id','LEFT')->where('app_activities.id=%d and app_activities.publish_status=1',array(I('get.activeid')))->find();
        //通过活动id查看生成签的日期是否跟当前日期相同,不相同重新生成签,相同则不生成
        $thqDeta =M('app_activity_thq');
        $thqMes=$thqDeta->field('app_activity_thq.label_detail_everyday,app_activity_thq.maximum_label,app_activity_thq.repeat_num,app_activities.start_at,app_activities.end_at,app_activities.status')->join('app_activities on app_activities.id=app_activity_thq.activity_id')->where('app_activity_thq.activity_id=%d and app_activity_thq.publish_status=1',array(I('request.activeid')))->find();
        $thqNum=unserialize($thqMes['label_detail_everyday']);
        
        //判断当前日期跟生成签的日期是否相同,不相同则生成新的签数
        if(date('Y-m-d',time())!=date('Y-m-d',$thqNum['updatetime'])){
            
            //生成签数
	for ($i= 1;$i<=$thqMes['maximum_label'];$i++){
		
            if($thqMes['repeat_num']==1){
		$taohuaqian_rand_db_temp[] = $i;
            }else if($thqMes['repeat_num']==2){
                $taohuaqian_rand_db_temp[] = $i;
                $taohuaqian_rand_db_temp[] = $i;
            }else if($thqMes['repeat_num']==3){
                $taohuaqian_rand_db_temp[] = $i;
                $taohuaqian_rand_db_temp[] = $i;
                $taohuaqian_rand_db_temp[] = $i;
            }else if($thqMes['repeat_num']==4){
                $taohuaqian_rand_db_temp[] = $i;
                $taohuaqian_rand_db_temp[] = $i;
                $taohuaqian_rand_db_temp[] = $i;
                $taohuaqian_rand_db_temp[] = $i;
            }else if($thqMes['repeat_num']==5){
                $taohuaqian_rand_db_temp[] = $i;
                $taohuaqian_rand_db_temp[] = $i;
                $taohuaqian_rand_db_temp[] = $i;
                $taohuaqian_rand_db_temp[] = $i;
                $taohuaqian_rand_db_temp[] = $i;
            }
		
	}
       $taohuaqian_rand_db_sql = serialize(array('rand' => $taohuaqian_rand_db_temp, 'updatetime' => date('Y-m-d H:i:s',time())));
       $data['label_detail_everyday']=$taohuaqian_rand_db_sql;
       $thqDeta->where('activity_id=%d and publish_status=1',array(I('request.activeid')))->save($data);
            
        }
        
        $this->assign('name',$thqRes['name']);
        $this->assign('logo',$thqRes['logo_url']);
        $this->assign('regulation',$thqRes['regulation']);
        $this->assign('activeid',I('get.activeid'));
        $this->assign('trafficid',I('get.trafficid'));
        $this->assign('is_open',$thqRes['is_open']);
        $this->assign('openid',I('get.openid'));
        $this->display('thq');
    }
    /*
     * 作用:摇晃手机后摇出签的逻辑方法
     */
    public function rock(){
        
        //根据活动id查询出总共的签数
        $thq =M('app_activity_thq');
        $thqMes=$thq->field('app_activity_thq.label_detail_everyday,app_activity_thq.maximum_label,app_activity_thq.repeat_num,app_activities.start_at,app_activities.end_at,app_activities.status')->join('app_activities on app_activities.id=app_activity_thq.activity_id')->where('app_activity_thq.activity_id=%d and app_activity_thq.publish_status=1',array(I('request.activeid')))->find();
        $thqNum=unserialize($thqMes['label_detail_everyday']);
        $num_rand_num = rand(0,count($thqNum['rand']));
        $num_rand = $thqNum['rand'][$num_rand_num];
        //清除抽走的签
        array_splice($thqNum['rand'],$num_rand_num,1);
        //将剩余签存到数据库中
        $newThqNum = serialize(array('rand' => $thqNum['rand'], 'updatetime' => date('Y-m-d H:i:s',time())));
        $data['label_detail_everyday']=$newThqNum;
        $thq->where('activity_id=%d and publish_status=1',array(I('request.activeid')))->save($data);
        if($thqMes['status']==1){
          
           $this->ajaxReturn(array('status'=>"disable",'info'=>'活动已被禁用哦~~')); 
            
        }
        //查看活动是否已过期
        
        if($thqMes['start_at']>date('Y-m-d H:i:s',time()) || $thqMes['end_at']<date('Y-m-d H:i:s',time())){
           if($thqMes['status']==0 || $thqMes['status']==1){
               $thqMes->status='2';
               $thqMes->where('id=%d and publish_status=1',array(I('request.activeid')))->save();
           }
        $this->ajaxReturn(array('status'=>"overdue",'info'=>'活动已过期哦~~')); 
        }
        //判断是否还有摇签机会
         $thqDetail = M('app_activity_thq_details');
         $thqCount = $thqDetail->where('activity_id=%d and traffic_id="%s" and publish_status=1',array(I('request.activeid'),I('request.trafficid')))->count('traffic_id');
         if($thqCount>=3){
             
             $this->ajaxReturn(array('status'=>"chance",'info'=>'您的机会已用完，请下次再来哦~~'));
         }
        //如果当天前已经抽完,则返回提示
        if(!$num_rand){
	//输出结果到前台页面
	$this->ajaxReturn(array('status' => 'fail', 'msg' => '今日的桃花签已抽完，明天再来吧'));
	}
        $num_txt = $this->cny($num_rand);

       //记录桃花签数据
       
        $detail['activity_id']=I('request.activeid');
        $detail['traffic_id']=I('request.trafficid');
        $detail['label_num']=$num_rand;
        $detail['open_time']=date('Y-m-d H:i:s',time());
        $detail['created_at']=date('Y-m-d H:i:s',time());
        $thqInsert = $thqDetail->data($detail)->add();

        //将抽中的签数输出到前端页面
        $this->ajaxReturn(array('status' => 'success', 'msg' => '第<br/>' . $num_txt . '签'));


        
        
    }
    /*
     * 作用:解签方法
     * 
     */
    public function jieqian(){
        
        //解签
        $jieqian = M('app_activity_thq_details');
        $data['is_open']='1';
        $data['open_time']=date('Y-m-d H:i:s',time());
        $jieqian->where('activity_id=%d and traffic_id="%s" and publish_status=1',array(I('get.activeid'),I('get.trafficid')))->order('created_at desc')->save($data);
    }

    public function cny($ns) { 
    static $cnums=array("","一<br/>","二<br/>","三<br/>","四<br/>","五<br/>","六<br/>","七<br/>","八<br/>","九<br/>"), 
    $cnyunits=array("","",""), 
    $grees=array("十<br/>","","","","","","",""); 
    list($ns1,$ns2)=explode(".",$ns,2); 
    $ns2=array_filter(array($ns2[1],$ns2[0])); 
    $ret=array_merge($ns2,array(implode("",$this->cnyMapUnit(str_split($ns1),$grees)),"")); 
    $ret=implode("",array_reverse($this->cnyMapUnit($ret,$cnyunits))); 
    return str_replace(array_keys($cnums),$cnums,$ret); 
    }

   public function cnyMapUnit($list,$units) { 
    $ul=count($units); 
    $xs=array(); 
    foreach (array_reverse($list) as $x) { 
        $l=count($xs); 
        if ($x!="0" || !($l%4)) $n=($x=='0'?'':$x).($units[($l-1)%$ul]); 
        else $n=is_numeric($xs[0][0])?$x:''; 
        array_unshift($xs,$n); 
    } 
    return $xs; 
  }
}
