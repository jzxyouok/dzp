<?php
namespace Home\Controller;
use Think\Controller;
use Org\Util\WeixinOAuth;
//ThinkPHP/Library自定义class文件存放目录
class AuthController extends Controller{
    /*
     * 作用:授权登陆后,跳转到活动页面
     */
    public function authLogin(){
        //实例化WeixinOAuth,返回授权地址链接
        $oauth= new WeixinOAuth();
        
//        if(!I('cookie.openid')){
        //获取code
        $code=I('get.code');
    //    print_r($code); 
        //获取活动id
        $activeId=I('get.activeid');
        //使用M方法实例化socials表
        $social = M('app_activities');
        //查询出appid和团队id
        $data=$social -> field('app_activities.type,app_activities.is_member_activity,soc_socials.appkey,soc_socials.id,soc_socials.social_type,soc_socials.real_id')->join('soc_socials on app_activities.social_id=soc_socials.id') -> where('app_activities.id=%d and app_activities.publish_status=1',array($activeId)) -> find();

        if(empty($code)){
            redirect($oauth->getOauthCode($data['appkey'], '', 'code'));
        }else{
            //调用接口获取粉丝信息
            //$fans=$oauth->getFans($data['real_id'], $code);
            //打印输出当前得到的粉丝信息
//            print_r($fans);
//            exit;
//            将openid和昵称存入cookie
//            cookie('openid',$fans['openId'],3600);
//            cookie('nickname',$fans['user']['nickname'],3600);
            //调用接口返回流量id

            $trafficid=$oauth->getTrafficId($data['id'], $code);
            $trafficid = array('code'=>$trafficid['code'],'id'=>$trafficid['trafficInfo']['trafficId']);
//            if($trafficid['code']!='0'){
//                //如果流量返回为空，则调用新增流量接口,新增粉丝后再返回流量id
//                 $trafficid=$oauth->getReTrafficId($fans['data']['openId'], $data['id']);
//            }
            //调用返回会员id接口判断是否是会员,如果是会员,则让其参加活动,如果不是会员,则提示不是会员或者跳到会员注册页面
            if($data['is_member_activity']==1){

            //$memberid=$oauth->getMembersId($fans['data']['openId'],$data['social_type']);
           
            //当identified返回为true时,是会员,继续参加活动
//            if($memberid['identified']=='true'){

            //然后将获取到的粉丝的openid传到活动页面中
            if($data['type']==1){
                //如果type类型是1,则跳到大转盘活动
//                $this->redirect('Dzp/index',array('openid'=>$fans['data']['openId'],'activeid'=>$activeId,'trafficid'=>$trafficid['id']));
                $this->redirect('Dzp/index',array('activeid'=>$activeId,'trafficid'=>$trafficid['id']));

            }elseif($data['type']==2){
                //如果type类型是1,则跳到优秀代理人评选活动
                $this->redirect('Poll/index',array('activeid'=>$activeId,'trafficid'=>$trafficid['id']));

            }elseif($data['type']==3){
                //如果type类型是3,则跳到桃花签活动
                $this->redirect('Thq/index',array('activeid'=>$activeId,'trafficid'=>$trafficid['id']));

            }
   /*         }elseif($memberid['identified']=='false'){
                //跳到会员注册页面,此链接方式可以写到配置文件中,然后在这里读取过来
                redirect('URL地址');
            }*/
         
        }else{
             //然后将获取到的粉丝的openid传到活动页面中
            if($data['type']==1){
              
                //如果type类型是1,则跳到大转盘活动
                $this->redirect('Dzp/index',array('activeid'=>$activeId,'trafficid'=>$trafficid['id']));

            }elseif($data['type']==2){
                //如果type类型是1,则跳到优秀代理人评选活动
                $this->redirect('poll/index',array('activeid'=>$activeId,'trafficid'=>$trafficid['id']));

            }elseif($data['type']==3){
                //如果type类型是3,则跳到桃花签活动
                $this->redirect('thq/index',array('activeid'=>$activeId,'trafficid'=>$trafficid['id']));

            }
            
        }
        }
        
       // }else{
//            
     //       $this->redirect('Dzp/index',array('openid'=>I('cookie.openid'),'nickname'=>I('cookie.nickname'),'activeid'=>I('get.activeid')));

       // }   
    
        }
}
