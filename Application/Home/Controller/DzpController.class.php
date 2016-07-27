<?php
namespace Home\Controller;
use Think\Controller;
use Org\Util\WeixinOAuth;
class DzpController extends Controller {
    
    
    /*
     * 作用:当执行其他方法时,先执行该方法
     */
    public function __construct(){
        parent::__construct();
        //获取openid和流量id
        $trafficid=I('request.trafficid');
        //判断openid和流量id是否为空，为空则走授权页面
        
        if(empty($trafficid)){
            $this->redirect('Auth/authLogin',array('activeid'=>I('get.activeid')));
        }
    }
    
    /*
     * 作用  渲染转盘活动页面
     */
    public function index(){
//        //实例化redis缓存
//        $redis= new \Think\Cache\Driver\Redis();
//        //查看缓存中是否存在该活动的配置信息
//        $activity_conf = $redis->hgetall('activity_conf_'.I('get.activeid'));
//
//        if(isset($activity_conf)){
//                
//            $activity_conf = $redis->hgetall('activity_conf_'.I('get.activeid'));
//        }else{
            //通过活动id查出活动的配置信息
            $activty = M('app_activities');
            $activity_conf= $activty->field('*')->where('id=%d and publish_status=1',array(I('get.activeid')))->find();
//            //活动存到redis
//            $redis->hmset('activity_conf_'.I('get.activeid'),$activity_conf);
//            $redis->expire('activity_conf_'.I('get.activeid'),60);
//        }
//        //分配每个粉丝的抽奖次数
//        $times=$redis->get('activity_fans_'.I('get.openid').I('get.activeid'));
//        
//        if($times==""){
//            $redis->setex('activity_fans_'.I('get.openid').I('get.activeid'),60,$activity_conf['times']);
//        }
//        //通过活动id查询出该活动的奖品等级个数
        $prizeNum = M('app_activity_dzp');
        $prizeGrade= $prizeNum->where('activity_id=%d and publish_status=1',array(I('get.activeid')))->count('prize_level');
        
        //判断奖品等级个数,填充自定义转盘扇形颜色
        if($prizeGrade == 2){
            //循环奖品等级名称
            $awardsName="[";
            for($i=0; $i<$prizeGrade; $i++){
                if($i==0){
                $awardsName.="\"一等奖\",";
                }else if($i==1){
                $awardsName.="\"谢谢参与\"";
                }
            }
            $awardsName.="]";
            //填充扇形颜色
            $colors='["#FFF4D6", "#FFFFFF"]';
        }else if($prizeGrade == 3){
            //循环奖品等级名称
            $awardsName='[';
            for($i=0; $i<$prizeGrade; $i++){
                if($i==0){
                $awardsName.="\"一等奖\",";
                $awardsName.="\"谢谢参与\",";
                }else if($i==1){
                $awardsName.="\"二等奖\",";
                }else if($i==2){
                $awardsName.="\"谢谢参与\"";
                }
            }
            $awardsName.=']';
            //填充扇形颜色
            $colors='["#FFF4D6", "#FFFFFF","#FFF4D6", "#FFFFFF"]';
        }else if($prizeGrade == 4){
               //循环奖品等级名称
            $awardsName='[';
            for($i=0; $i<$prizeGrade; $i++){
                if($i==0){
                $awardsName.="\"一等奖\",";
                $awardsName.="\"谢谢参与\",";
                }else if($i==1){
                $awardsName.="\"二等奖\",";
                $awardsName.="\"谢谢参与\",";
                }else if($i==2){
                $awardsName.="\"三等奖\",";
                }else if($i==3){
                $awardsName.="\"谢谢参与\"";
                }
            }
            $awardsName.=']';
            //填充扇形颜色
            $colors='["#FFF4D6", "#FFFFFF", "#FFF4D6", "#FFFFFF","#FFF4D6", "#FFFFFF"]';
        }else if($prizeGrade == 5){
                 //循环奖品等级名称
            $awardsName='[';
            for($i=0; $i<$prizeGrade; $i++){
                if($i==0){
                $awardsName.="\"一等奖\",";
                $awardsName.="\"谢谢参与\",";
                }else if($i==1){
                $awardsName.="\"二等奖\",";
                $awardsName.="\"谢谢参与\",";
                }else if($i==2){
                $awardsName.="\"三等奖\",";
                $awardsName.="\"谢谢参与\",";
                }else if($i==3){
                $awardsName.="\"四等奖\",";
                }else if($i==4){
                $awardsName.="\"谢谢参与\"";
                }
            }
            $awardsName.=']';
            //填充扇形颜色
            $colors='["#FFF4D6", "#FFFFFF", "#FFF4D6", "#FFFFFF","#FFF4D6", "#FFFFFF", "#FFF4D6", "#FFFFFF"]';
        }else if($prizeGrade == 6){
                    //循环奖品等级名称
            $awardsName='[';
            for($i=0; $i<$prizeGrade; $i++){
                if($i==0){
                $awardsName.="\"一等奖\",";
                $awardsName.="\"谢谢参与\",";
                }else if($i==1){
                $awardsName.="\"二等奖\",";
                $awardsName.="\"谢谢参与\",";
                }else if($i==2){
                $awardsName.="\"三等奖\",";
                $awardsName.="\"谢谢参与\",";
                }else if($i==3){
                $awardsName.="\"四等奖\",";
                $awardsName.="\"谢谢参与\",";
                }else if($i==4){
                $awardsName.="\"五等奖\",";
                }else if($i==5){
                $awardsName.="\"谢谢参与\"";
                }
            }
            $awardsName.=']';
            //填充扇形颜色
            $colors='["#FFF4D6", "#FFFFFF", "#FFF4D6", "#FFFFFF","#FFF4e6","#FFFFFF","#FFF4D6", "#FFFFFF", "#FFF4D6", "#FFFFFF","#FFF4e6","#FFFFFF"]';
        }
        $this->assign('name',$activity_conf['name']);
        //$this->assign('openid',I('get.openid'));
        $this->assign('nickname',I('get.nickname'));
        $this->assign('regulation',$activity_conf['regulation']);
        $this->assign('activeid',I('get.activeid'));
        $this->assign('logo',$activity_conf['logo_url']);
        $this->assign('colors',$colors);
        $this->assign('awardName',$awardsName);
        $this->assign('trafficid',I('get.trafficid'));
        $this->display('dzp');
    }


    /*
     * 作用:点击转盘抽奖按钮随机获取奖品等级
     * 注  此方法是点击转盘开始抽象按钮后的抽奖逻辑 方法中注释的部分为使用redis的内容
     * 以后使用redis可以将注释的代码启用
     */
    public function draw(){


//        //实例化redis缓存
//        $redis= new \Think\Cache\Driver\Redis();
//       
//        //缓存奖品概率
//        $prizePro= $this->totalNum();
//        
//        //将奖品数量存入redis
//        $this->prizeList();
//
//        //判断活动状态是否开启
//        $activeStatus = $redis->hgetall('activity_conf_'.I('get.activeid'))
        $activeConf=M('app_activities');
        $activeStatus = $activeConf->field('status,start_at,end_at,times')->where('id=%d and publish_status=1',array(I('post.activeid')))->find();
        if($activeStatus['status']==3){
            $this->ajaxReturn(array('status'=>"disable",'info'=>'活动已被禁用哦~~'));
        }
        //查看活动是否已过期

        if($activeStatus['end_at']<date('Y-m-d H:i:s',strtotime('-1 day'))){
           if($activeStatus['status']==0 || $activeStatus['status']==1){
               $activeConf->status='2';
               $activeConf->where('id=%d',array(I('post.activeid')))->save();
            }
        $this->ajaxReturn(array('status'=>"overdue",'info'=>'活动已过期哦~~')); 
        }
        if($activeStatus['start_at']>date('Y-m-d H:i:s',strtotime('+1 day'))){
            if($activeStatus['status']==0 || $activeStatus['status']==1){
                $activeConf->status='2';
                $activeConf->where('id=%d',array(I('post.activeid')))->save();
            }
            $this->ajaxReturn(array('status'=>"overdue",'info'=>'活动未开始~~'));
        }
        //是否有抽奖次数
        
        $activity = M('app_activity_dzp_details');
        $activityResult=$activity->where('activity_id=%d and traffic_id="%s" and publish_status=1',array(I('post.activeid'),I('post.trafficid')))->count();
        if($activityResult>=$activeStatus['times']){

            $this->ajaxReturn(array('status'=>"chance",'info'=>'您的机会已用完，请下次再来哦~~'));
        }
        //查看是否中奖
        $winRows=$activity->where('activity_id=%d and traffic_id="%s" and prize_level!=6 and publish_status=1',array(I('post.activeid'),I('post.trafficid')))->count();
        if(!empty($winRows)){
             $this->ajaxReturn(array('status'=>"winning",'info'=>'您已经中过奖哦~~'));
        }
        //查询出奖品概率
        $prize = M('app_activity_dzp');
        
        $prizeArray=$prize->field('prize_level,probability')->where('activity_id=%d and publish_status=1',array(I('post.activeid')))->select();
        
        foreach($prizeArray as $key=>$value){
            
              $prizePro[$value['prize_level']]=$value['probability']*100000;    
        }
        
        
        //根据概率抽奖
        
        $prize_level=$this->getRand($prizePro);
        
        //实例化中奖明细表
          $deails = M('app_activity_dzp_details');
        if($prize_level!=6){
            //判断当天奖品数量是否为0
            $daynum= M('app_activity_dzp');
            $dayprize = $daynum->field('day_num,total_num')->where('prize_level=%d and activity_id=%d and publish_status=1',array($prize_level,I('post.activeid')))->find();
            if($dayprize['day_num']!=0){
            $data['total_num']=$daynum->total_num-1;
            $data['day_num']=$daynum->day_num-1;
            $daynum->where('prize_level=%d and activity_id=%d and publish_status=1',array($prize_level,I('post.activeid')))->save($data);
            //将中奖信息添加的库中
            $data['activity_id']=I('post.activeid');
            $data['traffic_id']=I('post.trafficid');
            $data['created_at']=date('Y-m-d H:i:s',time());
            $participant= M('app_activity_participant');
            $participant->data($data)->add();
            $data['updated_at']=date('Y-m-d H:i:s',time());
            $data['prize_level']=$prize_level;
            $data['is_send_prize']='0';
            $deails->data($data)->add();
            
            }else{
                $prize_level=6;
                 $data['activity_id']=I('post.activeid');
            $data['traffic_id']=I('post.trafficid');
            $data['prize_level']=$prize_level;
            $data['is_send_prize']='2';
            $data['created_at']=date('Y-m-d H:i:s',time());
            $data['updated_at']=date('Y-m-d H:i:s',time());
            $deails->data($data)->add();
            }
        }else{
            $data['activity_id']=I('post.activeid');
            $data['traffic_id']=I('post.trafficid');
            $data['prize_level']=$prize_level;
            $data['is_send_prize']='2';
            $data['created_at']=date('Y-m-d H:i:s',time());
            $data['updated_at']=date('Y-m-d H:i:s',time());
            $deails->data($data)->add();
        }
        $this->ajaxReturn(array('prize_level'=>$prize_level));
//        
//        $times=$redis->get('active_fans_'.$openid.$_GET['activeId']);
//        if($times != 0){
//        //重新计算该粉丝的抽奖次数存入redis
//           $redis->setex('active_fans_'.I('get.openid').I('get.activeid'),60,$times-1);
//
//        }else{
//            
//           $this->ajaxReturn(array('status'=>"chance",'info'=>'您的机会已用完，请下次再来哦~~'));
//        
//        }
//        //通过概率判断是否有抽奖资格,90%是无抽奖资格,10%有抽奖资格
//        $ifQualification = $this->getRand(array('Y'=>'90000','N'=>'10000'));
//        if($ifQualification=='Y'){
//          //您已经中奖了，不要贪心哦~~
//            if($redis->get('active_fansAwardMsg_'.I('get.openid').I('get.activeid'))){
//                $prize_id=6;
//                //将没中奖的参与记录存入redis
//                $created_at= date('Y-m-d H:i:s',time());
//                $this->setRedisRows($traffic_id, $prize_id, I('get.activeid'),$created_at);
//
//            }else{
//
//                //获得中奖资格的人进队列
//                $redis->rpush('active_prizeWin_list'.I('get.activeid'),I('get.openid'));
//                //利用redis事务单进程抽奖
//                $redis->watch('active_prizeWin_list'.I('get.activeid'));
//                //开始事务
//                $redis->multi();
//                //取队列
//                $redis->lpop('active_prizeWin_list'.I('get.activeid'));
//                //获取抽中的奖品
//                $prize_id = $this->getRand($prizePro);
//                $ret_1 = $redis->exec();
//                //将没中奖的参与记录存入redis
//                $created_at= date('Y-m-d H:i:s',time());
//                if($prize_id==6){
//                     $this->setRedisRows($traffic_id, $prize_id, I('get.activeid'),$created_at);
//                }else{
//                    if($redis->llen("active_awardlist_".$current_time.I('get.activeid').$prize_id)>0){
//                    //用watch监控奖品队列发放
//                    $redis->watch("active_awardlist_".$current_time.I('get.activeid').$prize_id);
//                    //开始事务
//                    $redis->multi();
//                    //取出奖品并发放
//                    $redis->lpop("active_awardlist_".$current_time.I('get.activeid').$prize_id);
//                    //将库中的当天奖品数量和奖品总的剩余量-1
//                    $prize_num=M('app_activity_dzp');
//                    $prizeTotalNum['total_num']='total_num-1';
//                    $prizeTotalNum['day_num']='day_num-1';
//                    $prize_num->where('activity_id=%d',array(I('get.ativeid')))->save($prizeTotalNum);
//                    $redis->exec();
//                    }else{
//                    $prize_id=6;
//                    $this->setRedisRows($traffic_id, $prize_id, I('get.activeid'),$created_at);
//                    }
//                }
//          }
//     }else{
//         $prize_id=6;
//         //将没中奖的参与记录存入redis
//         $created_at= date('Y-m-d H:i:s',time());
//         $this->setRedisRows($traffic_id, $prize_id, I('get.activeid'),$created_at);
//
//     }
//     $this->ajaxReturn(array('prize_id'=>$prize_id));
//    
     
     
     }
     
 /*
  *作用： 提交中奖信息页面
  */    
 public function submit() {
     //实例化redis缓存
//     $redis= new \Think\Cache\Driver\Redis();
//     $conf = $redis->hgetall('activity_conf_'.I('get.activeid'));
     $conf = M('app_activities');
     $confResult = $conf->field('name,logo_url')->where('id=%d and publish_status=1',array(I('get.activeid')))->find();
     //通过流量id查询出用户的中奖信息
     $user = M('app_activity_dzp_details');
     $datames=$user->field('name,phone,address,prize_level')->where('traffic_id="%s" and prize_level!=6 and activity_id=%d and publish_status=1',array(I('get.trafficid'),I('get.activeid')))->order('created_at desc')->find();
     $this->assign('username',$datames['name']);
     $this->assign('phone',$datames['phone']);
     $this->assign('address',$datames['address']);
     $this->assign('name',$confResult['name']);
     $this->assign('grade',I('get.grade'));
     $this->assign('logo',$confResult['logo_url']);
     $this->assign('activeid',I('get.activeid'));
     $this->assign('trafficid',I('get.trafficid'));
     //$this->assign('openid',I('get.openid'));
     $totalNum=M('app_activity_dzp');
     $totalData = $totalNum->field('skip_url,url,prize_level')->where('activity_id=%d and publish_status=1',array(I('get.activeid')))->order('prize_level')->select();
     $this->assign('url',$totalData[$datames['prize_level']]['url']);
     $this->display('mes');
 }
 /*
  * 作用:提交中奖信息
  */
 public function post() {
    
     if(IS_POST){
            if(I('post.prizeid')=="一等奖"){
                $grade=1;
            }else if(I('post.prizeid')=="二等奖"){
                $grade=2;
            }else if(I('post.prizeid')=="三等奖"){
                $grade=3;
            }else if(I('post.prizeid')=="四等奖"){
                $grade=4;
            }else if(I('post.prizeid')=="五等奖"){
                $grade=5;
            }
         $message = M('app_activity_dzp_details');
         $data['name']=I('post.name');
         $data['phone']=I('post.phone');
         $data['address']=I('post.address');
        $message->where('prize_level=%d and activity_id=%d and publish_status=1 and traffic_id="%s"',array($grade,I('post.activeid'),I('post.trafficid')))->save($data);    
        $this->success('提交成功');
     }
 }
 
 /*
  * 展示用户的中奖信息
  */
 public function showMes(){
//     //实例化redis缓存
//     $redis= new \Think\Cache\Driver\Redis();
//     $activityconf = $redis->hgetall('activity_conf_'.I('get.activeid'));
     $conf = M('app_activities');
     $activityconf = $conf->field('name,logo_url')->where('id=%d and publish_status=1',array(I('get.activeid')))->find();
     //通过流量id查询出用户的中奖信息
     $user = M('app_activity_dzp_details');
     $datames=$user->field('name,phone,address,is_send_prize')->where('traffic_id="%s" and prize_level!=6 and activity_id=%d and publish_status=1',array(I('get.trafficid'),I('get.activeid')))->order('created_at desc')->find();
  
     $this->assign('username',$datames['name']);
     $this->assign('phone',$datames['phone']);
     $this->assign('address',$datames['address']);
     $this->assign('name',$activityconf['name']);
     $this->assign('logo',$activityconf['logo_url']);
     $this->assign('grade',I('get.grade'));
     $this->assign('is_send_prize',$datames['is_send_prize']);
     $this->assign('trafficid',I('get.trafficid'));
     $this->assign('activeid',I('get.activeid'));
     //$this->assign('openid',I('get.openid'));
     $this->display('success');
 }


 /*
  * 作用:缓存奖品概率
  */
    public function totalNum(){
        
        $prizePro=$redis->hgetall('active_prize_'.I('get.activeid'));
        if(isset($prizePro)){
            $prizePro=$redis->hgetall('active_prize_'.I('get.activeid'));
        }  else {
        //通过活动id查出奖品概率并缓存
            $prize=M('app_activity_dzp');
            $prizeData= $prize->field('prize_id,probability,total_num,day_num')->where('activity_id=%d and publish_status=1',array(I('get.activeid')))->order('prize_id')->select();
        //将查出的奖品等级和对应奖品概率拼成数组并缓存
            foreach($prizeData as $key=>$value){
                
                $prizePro[$value['prize_id']]= $value['probability'];
            }
            $redis->hmset('active_prize_'.I('get.activeid'),$prizePro);
            $redis->expire('active_prize_'.I('get.activeid'),60);
        }
        return $prizePro;
    
        
   }
    /*
     * 作用:将奖品加载到缓存队列中
     */
    public function prizeList(){
        $current_time=date('Y-m-d');

        $ptodaynum_1=$redis->hgetall('active_prizenum_'.$current_time.I('get.activeid').'1');

        if(isset($ptodaynum_1)){
           //缓存中没有奖品数量时加载奖品数量到缓存中
           $totalNum=M('app_activity_dzp');
           $totalData = $totalNum->field('name,prize_id,total_num,day_num,skip_url,url')->where('activity_id=%d and publish_status=1',array(I('get.activeid')))->order('prize_id')->select();
           foreach ($totalData as $key=>$value){
                $prizeParams=array('totalnum'=>$value['total_num'],'daynum'=>$value['day_num'],'name'=>$value['name'],'skipurl'=>$value['skip_url'],'url'=>$value['url']);
                $redis->hmset('active_prizenum_'.$current_time.I('get.activeid').$value['prize_id'],$prizeParams);
                $redis->expire('active_prizenum_'.$current_time.I('get.activeid').$value['prize_id'],60);
           }
            //将前一天的奖品剩余总数量和当天奖品数量删除
        $yestodaydate=date("Y-m-d",strtotime('-1 day'));//定义前一天的日期
         //统计奖项个数 
        $awardNum=M('app_activity_dzp');
        $awardNumData=$awardNum->where('activity_id=%d and publish_status=1',array(I('get.activeid')))->count('prize_id');
        $i=1;
        while($i<$awardNumData){
        $ydaynum=$redis->hgetall('active_prizenum_'.$yestodaydate.I('get.activeid').$i);

        if($ydaynum['daynum']){
          //删除前一天的奖品数
        $redis->del('active_prizenum_'.$yestodaydate.I('get.activeid').$i);

        }else{
        //判断当天各奖品队列是否为空
            if($redis->llen("active_awardlist_".$current_time.I('get.activeid').$i)==0){
                //判断当天各奖品数量字段是否为空
                $daynum=$redis->hgetall('active_prizenum_'.$current_time.I('get.activeid').$i);
            if(!$daynum['day_num']){
                //当天奖品数量字段为空时，将加载各奖品的剩余奖品数量到队列中
                $j=0;
                while($j<$daynum['total_num']){
                    $redis->rpush("active_awardlist_".$current_time.I('get.activeid').$i,$j."_".$daynum['name']);
                    //判断前一天的缓存队列是否存在
                    if($redis->llen("active_awardlist_".$yestodaydate.I('get.activeid').$i)>=0){
                        $redis->del("active_awardlist_".$yestodaydate.I('get.activeid').$i);
                    }
                    $j++;
                }
            }else{
            //当天奖品数量字段不为空时
            //判断当天个奖品数量是否大于等于各奖品总剩余数量
            if($daynum['daynum']<=$daynum['totalnum']){
               //将当天的各奖品数量加载到缓存队列中
                $k=0;
                while($k<$daynum['daynum'])
                {
                    $redis->rpush("active_awardlist_".$current_time.I('get.activeid').$i,$k."_".$daynum['name']);
                    //判断前一天的缓存队列是否存在
                    if($redis->llen("active_awardlist_".$yestodaydate.I('get.activeid').$i)>=0)
                    {
                        $redis->del("active_awardlist_".$yestodaydate.I('get.activeid').$i);
                    }
                    $k++;
                }

            }else{
            //当天奖品数量小于总的奖品剩余数量时,将各奖品总剩余量加载到缓存队列中
                $n=0;
                while($n<$daynum['totalnum']){
                    $redis->rpush("active_awardlist_".$current_time.I('get.activeid').$i,$n."_".$daynum['name']);
                    //判断前一天的缓存队列是否存在
                    if($redis->llen("active_awardlist_".$yestodaydate.I('get.activeid').$i)>=0){
                        $redis->del("active_awardlist_".$yestodaydate.I('get.activeid').$i);
                    }
                    $n++;
               }

            }
            }

           }
        }
             $i++;
        }
       }
    }

//中奖概率算法
public function getRand($proArr) { 
    $result = ''; 
 
    //概率数组的总概率精度 
    $proSum = array_sum($proArr); 
 
    //概率数组循环 
    foreach ($proArr as $key => $proCur) { 
        $randNum = mt_rand(1, $proSum); 
        if ($randNum <= $proCur) { 
            $result = $key; 
            break; 
        } else { 
            $proSum -= $proCur; 
        } 
    } 
    unset ($proArr); 
 
    return $result; 
}
/*
 * 将粉丝的openid,昵称等信息存入redis
 * Param:$traffic_id  流量id,流量表的主键id
 *       $$prize_id   奖品等级id
 *       $active_id   活动id
 */
    public function setRedisRows($traffic_id,$prize_id,$active_id,$created_at) {
        
        $fansMessage = array('traffic_id'=>$traffic_id,'prize_id'=>$prize_id,'activity_id'=>$active_id,'created_at'=>$created_at);
        $fansMess = json_encode($fansMessage);
        $redis->rpush('game_turntable',$fansMess);
    }
        
        
        
        
        
        
   

}
