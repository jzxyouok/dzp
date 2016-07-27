<?php
namespace Org\Util;
use Think\Controller;
class WeixinOAuth extends Controller{
    /*
     * 作用:返回授权地址链接
     */
    public function authorizeURL(){
        return "https://open.weixin.qq.com/connect/oauth2/authorize";
    }
    /* 作用 获取授权code码
     * Param  $appid,$url,$response_type,$scope,$state
     */
    public function  getOauthCode($appid = NULL,$url = NULL, $response_type = 'code', $scope = 'snsapi_userinfo', $state = NULL){
        
        if(empty($url)){
           
              /*
               * //可以将回调地址链接放到配置文件中,将$url=C('wx_redirecturi')开启，并在配置写上回调地址
               */
               // $url="http://scrm-stg.huntor.cn:9090/";  //汉拓科技授权回调地址
            
                $url="http://mscrm.huntor.cn/oauth/"; //汉拓研发中心授权回调地址
                //$url=C('wx_redirecturi');//微信回调地址
        }
        
        if(empty($state)){
            
            $state= U('Auth/authLogin',array('activeid'=>I('get.activeid')));//当$state参数为空时,默认跳转到授权页
            
        }
        $params = array();
        $params['appid'] = $appid;
        $params['redirect_uri'] = $url;
        $params['response_type'] = $response_type;
        $params['scope'] = $scope;
        $params['state'] = $this->getNewUrl($state);
        return $this->authorizeURL() . "?" .$this->formatBizQueryParaMap($params) . "#wechat_redirect ";
        
        
    }
    /*
     * 作用:格式化参数,授权地址用到
     */
    public function formatBizQueryParaMap($paraMap, $urlencode){
		$buff = "";
		ksort($paraMap);
		foreach ($paraMap as $k => $v)
		{
		    if($urlencode)
		    {
			   $v = urlencode($v);
			}
			//$buff .= strtolower($k) . "=" . $v . "&";
			$buff .= $k . "=" . $v . "&";
		}
		$reqPar;
		if (strlen($buff) > 0) 
		{
			$reqPar = substr($buff, 0, strlen($buff)-1);
		}
		return $reqPar;
	}
     /*
      * 作用:生成带http的state参数
      */
     public function getNewUrl($state){
         $param =  substr($state, 0, 4);
         if($param!="http"){
             
             $param="http://".$_SERVER['HTTP_HOST'].$state;
             
         }
         return $param;
     }
     /*
      * 作用  是通过code调用os的OAuth2.0接口获取粉丝信息
      */
     public function getFans($realid,$code){
         
            $data=array('publicuserid'=>$realid,'code'=>$code);
            $data=  json_encode($data);
            $url = 'http://10.6.28.125:10401/opensocial-gateway/GWService';//OpensocialVivo的入口地址,此入口地址可以写到配置文件中
            $postData ='accesscode=93f629348fce4a3855ad1a927b282c94&method=oauth2GetInfo&data='.$data;//OpensocialVivo请求时的参数

            //初始化curl
            $ch = curl_init();

            //设置超时
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //将exec的执行结果不立刻输出
            curl_setopt($ch, CURLOPT_POST, 1);//设置为POST方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);//POST数据

            //运行curl，结果以json形式返回
            $res = curl_exec($ch);
            curl_close($ch);
            //将粉丝信息以数组形式输出返回
            $data = json_decode($res,true);

            return $data; 
          
     }
    /*
     * 作用  返回流量id
     */
    public function getTrafficId($socialId,$code){
//            $data='realId='.$realId.'&socialId='.$socialId.'&code='.$code;
            $data='socialId='.$socialId.'&code='.$code;
            //$data=  json_encode($data);
            $url = 'http://10.6.28.125:10501/business-service-core/traffic/wechat/oauth2?'.$data;//调用BS提供的地址，需要跟BS同事要,此入口地址可以写到配置文件中
            
            //初始化curl
            $ch = curl_init();

            //设置超时
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, Array('User-Agent:activity'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //将exec的执行结果不立刻输出
            curl_setopt($ch,CURLOPT_USERAGENT,'dzp');
            //curl_setopt($ch, CURLOPT_POST, 1);//设置为POST方式
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//POST数据

            //运行curl，结果以jason形式返回
            $res = curl_exec($ch);
            curl_close($ch);
            //将粉丝信息以数组形式输出返回
            $data = json_decode($res,true);
            return $data;
        
    }
        /*
     * 作用 当流量id返回为空时，再次调用创建流量接口获取流量id
     */
    public function getReTrafficId($trafficRealId,$socialId){

            $data= 'trafficRealId='.$trafficRealId.'&socialId='.$socialId;
            //$data=  json_encode($data);
            $url = 'http://10.6.28.125:10501/business-service-core/traffic';//调用BS提供的地址，需要跟BS同事要,此入口地址可以写到配置文件中
            
            //初始化curl
            $ch = curl_init();

            //设置超时
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, Array('User-Agent:activity'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //将exec的执行结果不立刻输出
            curl_setopt($ch, CURLOPT_POST, 1);//设置为POST方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//POST数据

            //运行curl，结果以jason形式返回
            $res = curl_exec($ch);
            curl_close($ch);
            //将粉丝信息以数组形式输出返回
            $data = json_decode($res,true);

            return $data; 
        
    }
        /*
     * 作用  判断该粉丝是否已注册会员
     */
    public function getMembersId($realId,$socialType){
           
            $data='realId='.$realId.'&socialType='.$socialType;
            //$data=  json_encode($data);
            $url = 'http://10.6.28.125:10501/business-service-core/traffic/identity_recognition?'.$data;//调用BS提供的地址，需要跟BS同事要,此入口地址可以写到配置文件中
            
            //初始化curl
            $ch = curl_init();

            //设置超时
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, Array('User-Agent:activity'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //将exec的执行结果不立刻输出
//            curl_setopt($ch, CURLOPT_POST, 1);//设置为POST方式
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//POST数据

            //运行curl，结果以jason形式返回
            $res = curl_exec($ch);
            curl_close($ch);
            //将粉丝信息以数组形式输出返回
            $data = json_decode($res,true);
            return $data;
        
    }
}
?>
