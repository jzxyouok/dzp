<?php
namespace Home\Controller;
use Think\Controller;
class PollController extends Controller {
   
    
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
     * 作用:循环输出各代理人的信息,并参与投票,包括到搜索代理人信息
     */
    
    public function index(){
        
        //通过活动id查找出代理人信息
        $value=I('post.search_key');
        if(empty($value)){
        $poll = M('app_activities');
        $pollRes = $poll->field('app_activities.name,app_activities.regulation,app_activities.logo_url,app_activity_employee.id,app_activity_employee.total_num,app_activity_employee.employee_num,bd_users.name as empname,bd_users.photo_url')
                    ->join('app_activity_employee on app_activities.id=app_activity_employee.activity_id','LEFT')->join('bd_users on bd_users.id=app_activity_employee.employee_id','LEFT')->where('app_activities.id=%d and app_activities.publish_status=1',array(I('get.activeid')))->select();
        }else{
        $poll = M('app_activities');
        $map['app_activity_employee.employee_num|bd_users.name']=array('like','%'.I('post.search_key').'%');
        $map['app_activity_employee.publish_status']=array('eq','1');
        $pollRes = $poll->field('app_activities.name,app_activities.regulation,app_activities.logo_url,app_activity_employee.id,app_activity_employee.total_num,app_activity_employee.employee_num,bd_users.name as empname,bd_users.photo_url')
                    ->join('app_activity_employee on app_activities.id=app_activity_employee.activity_id','LEFT')->join('bd_users on bd_users.id=app_activity_employee.employee_id','LEFT')->where($map)->select();
        }
        //计算出各个代理人的名次并循环输出各个代理人的信息
        $emphtml="";
        foreach($pollRes as $k=>$v){
            
            //计算各代理人的名次
            $employee = M('app_activity_employee');
            $empcount = $employee->where('total_num>%d and publish_status=1',array($v['total_num']))->order('total_num desc')->count();
            $empcount = $empcount+1;
            $emphtml.='<div style="float:left;width: 50%;position:relative">
                      <div><img style="width:90%;padding-left:8px;" src="/tp_activity/Public/images/member_bg.png" /></div>
                      <div style="position:absolute;top:58px;left:96px;"><a href="'.U('poll/details',array('openid'=>I('request.openid'),'activeid'=>I('get.activeid'),'empid'=>$v['id'],'trafficid'=>I('get.trafficid'))).'"><img width="136" height="136" style="border-radius:68px;" src="'.$v['photo_url'].'" /></a></div>
                      <div style="position:absolute;top:226px;left:92px;font-size:26px;color:#151d50; font-weight: bold;width:60px;text-align:center;">'.$v['employee_num'].'号</div>
                      <div style="position:absolute;top:212px;left:140px;font-size:26px;color:#151d50; font-weight: bold;width:120px;text-align:center;">'.$v['empname'].'</div>
                      <div style="margin-top:8px;text-align:center;"><span style="color:#FFF;font-size:18px;">排名：'.$empcount.'票数：'.$v['total_num'].'</span></div>
                      <div style="margin-top:8px;margin-left:40px;letter-spacing:6px;" class="infobtn"><a href="'.U('poll/details',array('openid'=>I('request.openid'),'activeid'=>I('request.activeid'),'empid'=>$v['id'],'trafficid'=>I('get.trafficid'))).'" class="btn">投Ta一票</a></div>
		      </div>';
            
            
            
        }
        //assign方法是给变量赋值,具体使用方法可参考TP文档
        $this->assign('emphtml',$emphtml);
        $this->assign('name',$pollRes[0]['name']);
        $this->assign('logo',$pollRes[0]['logo_url']);
        $this->assign('regulation',$pollRes[0]['regulation']);
        $this->assign('openid',I('request.openid'));
        $this->assign('trafficid',I('request.trafficid'));
        $this->assign('activeid',I('request.activeid'));
        $this->display('poll');   
    }



    /*
     * 作用:代理人投票详情页,点击投票按钮对该代理人投票
     */
    public function details(){
        
        //通过代理人的id查出代理人的信息
        
        $agent = M('app_activities');
        
        $agentMes = $agent->field('app_activities.name,app_activities.logo_url,app_activity_employee.employee_num,app_activity_employee.total_num,bd_users.photo_url')->join('app_activity_employee on app_activity_employee.activity_id=app_activities.id','LEFT')
                ->join('bd_users on bd_users.id=app_activity_employee.employee_id','LEFT')->where('app_activity_employee.id=%d and app_activity_employee.publish_status=1',array(I('get.empid')))->find();
        
        //查出该导购名次
        $emp = M('app_activity_employee');
        $empcount = $emp->where('total_num>%d and publish_status=1',array($agentMes['total_num']))->order('total_num desc')->count();
        $empcount = $empcount+1;
        $this->assign('name',$agentMes['name']);
        $this->assign('logo_url',$agentMes['logo_url']);
        $this->assign('employee_num',$agentMes['employee_num']);
        $this->assign('total',$agentMes['total_num']);
        $this->assign('photo',$agentMes['photo_url']);
        $this->assign('empcount',$empcount);
        $this->assign('openid',I('request.openid'));
        $this->assign('empid',I('request.empid'));
        $this->assign('activeid',I('request.activeid'));
        $this->assign('trafficid',I('request.trafficid'));
        $this->display('detail');
        
    }
    /*
     * 作用:点击投票按钮进行投票
     * 
     * 
     */
    public function draw(){
        
        
        //查询代理人活动信息
        $polltime = M('app_activities');
        
        $polldata = $polltime->field('start_at,end_at,status')->where('id=%d and publish_status=1',array(I('request.activeid')))->find();
        //判断活动是否在进行中
        if($polldata['status']==1){
            
            $this->ajaxReturn(array('status'=>'disable','info'=>'活动已禁用哦~'));
        }
        //判断活动是否已过期
        if($polldata['start_at']>date('Y-m-d H:i:s',time()) || $polldata['end_at']<date('Y-m-d H:i:s',time())){
           if($activeStatus['status']==0 || $activeStatus['status']==1){
               $polltime->status='2';
               $polltime->where('id=%d',array(I('request.activeid')))->save();
            }
        $this->ajaxReturn(array('status'=>"overdue",'info'=>'活动已过期哦~~')); 
        }
        //判断是否还有投票机会,投票机会默认三次
        $pollDetail = M('app_activity_employee_details');
        
        //计算投票次数
        $pollchage = $pollDetail->where('traffic_id="%s" and activity_id=%d and publish_status=1',array(I('request.trafficid'),I('request.activeid')))->count();
        $pollchage = $pollchage+1;
        $pollchage = 3-$pollchage;
        if($pollchage>=0){
        //对代理人投票
        $pollemp = M('app_activity_employee');
        //这里需要将该代理人的总票数
        $polltotal =$pollemp->field('total_num')->where('id=%d and publish_status=1',array(I('request.empid')))->find();
        $total['total_num']=$pollemp->total_num + 1;
        
        $pollemp->where('id=%d and publish_status=1',array(I('request.empid')))->save($total);
        
        //将投票记录提交到数据库中
        $log['activity_id']=I('request.activeid');
        $log['employee_select_id']=I('request.empid');
        $log['traffic_id']=I('request.trafficid');
        $log['created_at']=date('Y-m-d H:i:s',time());
        
        $pollDetail->data($log)->add();
   

        $this->ajaxReturn(array('status'=>1,'num'=>$pollchage));
        }
        
        
    }
        
        
        
   

}
