<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 环信-服务器端REST API
 * @author    limx <limx@xiaoneimimi.com>
 */
class HXController extends Controller {

    private $client_id='YXA6ef0hcJSyEeWlQg0wFqthDQ';
    private $client_secret='YXA6dd1GuLATzkHcqqTI3OIgLExnOiI';
    private $org_name='ipa361';
    private $app_name='cg';
    private $url = 'https://a1.easemob.com/ipa361/cg/';

    /**
     * 初始化参数
     *
     * @param array $options
     * @param $options['client_id']
     * @param $options['client_secret']
     * @param $options['org_name']
     * @param $options['app_name']
     */
    /* public function __construct($options) {
        $this->client_id = isset ( $options ['client_id'] ) ? $options ['client_id'] : '';
        $this->client_secret = isset ( $options ['client_secret'] ) ? $options ['client_secret'] : '';
        $this->org_name = isset ( $options ['org_name'] ) ? $options ['org_name'] : '';
        $this->app_name = isset ( $options ['app_name'] ) ? $options ['app_name'] : '';
        if (! empty ( $this->org_name ) && ! empty ( $this->app_name )) {
            $this->url = 'https://a1.easemob.com/' . $this->org_name . '/' . $this->app_name . '/';
        }
    } */
    /**
     * 开放注册模式
     *
     * @param $options['username'] 用户名
     * @param $options['password'] 密码
     * 设置密码为账号+_ipa做加密运算
     */
    public function openRegister($username) {
        $options['username']=$username;
        //$tripldes =new TripledesModel();
        $tripldes =D("Tripledes");
        $pass= $tripldes->encrypt($username.'_ipa');

        $options['password']=$pass;
        //$options['password']=123456;
        $url = $this->url . "users";
        $result = $this->postCurl ( $url, $options, $head = 0 );
        //echo $result ;exit;
        $info = json_decode($result,true);
        //dump($info);
        //echo $info ;exit;
        if(isset($info['entities'])){
            return '1';
        }else{
            return '0';
        }
    }

    public function test(){
        $des =D("Tripledes");

        echo $ret = $des->encrypt("123") . "\n";
        echo $des->decrypt($ret) . "\n";

        $info = array(
            'msg'=>'成功',
            'code'=>200,
            'ret'=>$ret,
            'des'=>$des);
        echo json_encode($info);

    }

    /**
     * 授权注册模式 || 批量注册
     *
     * @param $options['username'] 用户名
     * @param $options['password'] 密码
     *          批量注册传二维数组
     */
    public function accreditRegister($options) {
        $url = $this->url . "users";
        $access_token = $this->getToken ();
        $header [] = 'Authorization: Bearer ' . $access_token;
        $result = $this->postCurl ( $url, $options, $header );
        //return $result;
        echo $result;
    }

    /**
     * 获取指定用户详情
     *
     * @param $username 用户名
     */
    public function userDetails($username) {
        $url = $this->url . "users/" . $username;
        $access_token = $this->getToken ();
        //print_r($access_token);exit;
        $header [] = 'Authorization: Bearer ' . $access_token;
        $result = $this->postCurl ( $url, '', $header, $type = 'GET' );

        $info = json_decode($result,true);
        //print_r($info);
        if(isset($info['entities'])){
            return '1';
        }else{
            return '0';
        }
    }

    /**
     * 重置用户密码
     *
     * @param $options['username'] 用户名
     * @param $options['password'] 密码
     * @param $options['newpassword'] 新密码
     */
    public function editPassword($options) {
        $url = $this->url . "users/" . $options ['username'] . "/password";
        $access_token = $this->getToken ();
        $header [] = 'Authorization: Bearer ' . $access_token;
        $result = $this->postCurl ( $url, $options, $header, $type = 'PUT');
        return $result;
    }
    /**
     * 删除用户
     *
     * @param $username 用户名
     */
    public function deleteUser($username) {
        $url = $this->url . "users/" . $username;
        $access_token = $this->getToken ();
        $header [] = 'Authorization: Bearer ' . $access_token;
        $result = $this->postCurl ( $url, '', $header, $type = 'DELETE' );
    }

    /**
     * 批量删除用户
     * 描述：删除某个app下指定数量的环信账号。上述url可一次删除300个用户,数值可以修改 建议这个数值在100-500之间，不要过大
     *
     * @param $limit="300" 默认为300条
     * @param $ql 删除条件
     *          如ql=order+by+created+desc 按照创建时间来排序(降序)
     */
    public function batchDeleteUser($limit = "300", $ql = '') {
        $url = $this->url . "users?limit=" . $limit;
        if (! empty ( $ql )) {
            $url = $this->url . "users?ql=" . $ql . "&limit=" . $limit;
        }
        $access_token = $this->getToken ();
        $header [] = 'Authorization: Bearer ' . $access_token;
        $result = $this->postCurl ( $url, '', $header, $type = 'DELETE' );
    }

    /**
     * 给一个用户添加一个好友
     *
     * @param
     *          $owner_username
     * @param
     *          $friend_username
     */
    public function addFriend($owner_username, $friend_username) {
        $url = $this->url . "users/" . $owner_username . "/contacts/users/" . $friend_username;
        $access_token = $this->getToken ();
        $header [] = 'Authorization: Bearer ' . $access_token;
        $result = $this->postCurl ( $url, '', $header );
    }

    /**
     * 删除好友
     *
     * @param
     *          $owner_username
     * @param
     *          $friend_username
     */
    public function deleteFriend($owner_username, $friend_username) {
        $url = $this->url . "users/" . $owner_username . "/contacts/users/" . $friend_username;
        $access_token = $this->getToken ();
        $header [] = 'Authorization: Bearer ' . $access_token;
        $result = $this->postCurl ( $url, '', $header, $type = "DELETE" );
    }
    /**
     * 查看用户的好友
     *
     * @param
     *          $owner_username
     */
    public function showFriend($owner_username) {
        $url = $this->url . "users/" . $owner_username . "/contacts/users/";
        $access_token = $this->getToken ();
        $header [] = 'Authorization: Bearer ' . $access_token;
        $result = $this->postCurl ( $url, '', $header, $type = "GET" );
    }
    // +----------------------------------------------------------------------
    // | 聊天相关的方法
    // +----------------------------------------------------------------------
    /**
     * 查看用户是否在线
     *
     * @param
     *          $username
     */
    public function isOnline($username) {
        $url = $this->url . "users/" . $username . "/status";
        $access_token = $this->getToken ();
        $header [] = 'Authorization: Bearer ' . $access_token;
        $result = $this->postCurl ( $url, '', $header, $type = "GET" );
        //return $result;
        echo $result;
    }
    /**
     * 发送消息
     *
     * @param string $from_user
     *          发送方用户名
     * @param array $username
     *          array('1','2')
     * @param string $target_type
     *          默认为：users 描述：给一个或者多个用户(users)或者群组发送消息(chatgroups)
     * @param string $content
     * @param array $ext
     *          自定义参数
     */
    function yy_hxSend($from_user = "admin", $username, $content, $target_type = "users", $ext) {
        $option ['target_type'] = $target_type;
        $option ['target'] = $username;
        $params ['type'] = "txt";
        $params ['msg'] = $content;
        $option ['msg'] = $params;
        $option ['from'] = $from_user;
        $option ['ext'] = $ext;
        $url = $this->url . "messages";
        $access_token = $this->getToken ();
        $header [] = 'Authorization: Bearer ' . $access_token;
        $result = $this->postCurl ( $url, $option, $header );
        return $result;
    }
    /**
     * 获取app中所有的群组
     */
    public function chatGroups() {
        $url = $this->url . "chatgroups";
        $access_token = $this->getToken ();
        $header [] = 'Authorization: Bearer ' . $access_token;
        $result = $this->postCurl ( $url, '', $header, $type = "GET" );
        return $result;
    }
    /**
     * 创建群组
     *
     * @param $option['groupname'] //群组名称,
     *          此属性为必须的
     * @param $option['desc'] //群组描述,
     *          此属性为必须的
     * @param $option['public'] //是否是公开群,
     *          此属性为必须的 true or false
     * @param $option['approval'] //加入公开群是否需要批准,
     *          没有这个属性的话默认是true, 此属性为可选的
     * @param $option['owner'] //群组的管理员,
     *          此属性为必须的
     * @param $option['members'] //群组成员,此属性为可选的
     */
    public function createGroups($option) {
        $url = $this->url . "chatgroups";
        $access_token = $this->getToken ();
        $header [] = 'Authorization: Bearer ' . $access_token;
        $result = $this->postCurl ( $url, $option, $header );
        return $result;
    }
    /**
     * 获取群组详情
     *
     * @param
     *          $group_id
     */
    public function chatGroupsDetails($group_id) {
        $url = $this->url . "chatgroups/" . $group_id;
        $access_token = $this->getToken ();
        $header [] = 'Authorization: Bearer ' . $access_token;
        $result = $this->postCurl ( $url, '', $header, $type = "GET" );
        return $result;
    }
    /**
     * 删除群组
     *
     * @param
     *          $group_id
     */
    public function deleteGroups($group_id) {
        $url = $this->url . "chatgroups/" . $group_id;
        $access_token = $this->getToken ();
        $header [] = 'Authorization: Bearer ' . $access_token;
        $result = $this->postCurl ( $url, '', $header, $type = "DELETE" );
        return $result;
    }
    /**
     * 获取群组成员
     *
     * @param
     *          $group_id
     */
    public function groupsUser($group_id) {
        $url = $this->url . "chatgroups/" . $group_id . "/users";
        $access_token = $this->getToken ();
        $header [] = 'Authorization: Bearer ' . $access_token;
        $result = $this->postCurl ( $url, '', $header, $type = "GET" );

        $info = json_decode($result,true);

        if(isset($info['data'])){
            return $info['data'];
        }else{
            return '0';
        }
        return $result;
    }
    /**
     * 群组添加成员
     *
     * @param
     *          $group_id
     * @param
     *          $username
     */
    public function addGroupsUser($group_id, $username) {
        $url = $this->url . "chatgroups/" . $group_id . "/users/" . $username;
        $access_token = $this->getToken ();
        $header [] = 'Authorization: Bearer ' . $access_token;
        $result = $this->postCurl ( $url, '', $header, $type = "POST" );
        return $result;
    }
    /**
     * 群组删除成员
     *
     * @param
     *          $group_id
     * @param
     *          $username
     */
    public function delGroupsUser($group_id, $username) {
        $url = $this->url . "chatgroups/" . $group_id . "/users/" . $username;
        $access_token = $this->getToken ();
        $header [] = 'Authorization: Bearer ' . $access_token;
        $result = $this->postCurl ( $url, '', $header, $type = "DELETE" );
        return $result;
    }
    /**
     * 聊天消息记录
     *
     * @param $ql 查询条件如：$ql
     *          = "select+*+where+from='" . $uid . "'+or+to='". $uid ."'+order+by+timestamp+desc&limit=" . $limit . $cursor;
     *          默认为order by timestamp desc
     * @param $cursor 分页参数
     *          默认为空
     * @param $limit 条数
     *          默认20
     */
    public function chatRecord($ql = '', $cursor = '', $limit = 20) {
        $ql = ! empty ( $ql ) ? "ql=" . $ql : "order+by+timestamp+desc";
        $cursor = ! empty ( $cursor ) ? "&cursor=" . $cursor : '';
        $url = $this->url . "chatmessages?" . $ql . "&limit=" . $limit . $cursor;
        $access_token = $this->getToken ();
        $header [] = 'Authorization: Bearer ' . $access_token;
        $result = $this->postCurl ( $url, '', $header, $type = "GET " );
        return $result;
    }

    //判断某个字段是否存在
    public function checkField($jsons){
        if($jsons->activated==true){
            print_r('11111');
            return true;
        }else{
            print_r('22222');
            return false;
        }
    }

    /**
     * 获取Token
     */
    public function getToken() {
        //print_r($url);exit;
        $option ['grant_type'] = "client_credentials";
        $option ['client_id'] = $this->client_id;
        $option ['client_secret'] = $this->client_secret;
        $url = $this->url . "token";
        $fp = @fopen ( "easemob.txt", 'r' );
        if ($fp) {
            $arr = unserialize ( fgets ( $fp ) );
            if ($arr ['expires_in'] < time ()) {
                $result = $this->postCurl ( $url, $option, $head = 0 );
                //$result ['expires_in'] = $result ['expires_in'] + time ();
                @fwrite ( $fp, serialize ( $result ) );
                $myArr=json_decode($result, true);
                $token=$myArr['access_token'];
                return  $token;
                fclose ( $fp );
                exit ();
            }
            return $arr ['access_token'];
            fclose ( $fp );
            exit ();
        }
        $result = $this->postCurl ( $url, $option, $head = 0 );
        $result = json_decode($result);
        $result ['expires_in'] = $result ['expires_in'] + time ();
        $fp = @fopen ( "easemob.txt", 'w' );
        @fwrite ( $fp, serialize ( $result ) );
        return $result ['access_token'];
        fclose ( $fp );
    }

    /**
     * CURL Post
     */
    private function postCurl($url, $option, $header = 0, $type = 'POST') {
        $curl = curl_init (); // 启动一个CURL会话
        curl_setopt ( $curl, CURLOPT_URL, $url ); // 要访问的地址
        curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE ); // 对认证证书来源的检查
        curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, FALSE ); // 从证书中检查SSL加密算法是否存在
        curl_setopt ( $curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)' ); // 模拟用户使用的浏览器
        if (! empty ( $option )) {
            $options = json_encode ( $option );
            curl_setopt ( $curl, CURLOPT_POSTFIELDS, $options ); // Post提交的数据包
        }
        curl_setopt ( $curl, CURLOPT_TIMEOUT, 30 ); // 设置超时限制防止死循环
        curl_setopt ( $curl, CURLOPT_HTTPHEADER, $header ); // 设置HTTP头
        curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 ); // 获取的信息以文件流的形式返回
        curl_setopt ( $curl, CURLOPT_CUSTOMREQUEST, $type );
        $result = curl_exec ( $curl ); // 执行操作
        //$res = object_array ( json_decode ( $result ) );
        //$res ['status'] = curl_getinfo ( $curl, CURLINFO_HTTP_CODE );
        //pre ( $res );
        curl_close ( $curl ); // 关闭CURL会话
        return $result;
    }

    //登录成功后自动检测帐户信息，如果没有创建则创建
    public function autoRegister($username){
        $hasAccount= $this->userDetails($username) ;
        if($hasAccount){
            return '1';
        }else{

        }

    }

    //登录
    public function  login(){
        session_start();
        $sessionid = session_id();//得到sessionid
        //echo $sessionid ;
        //声明一个json数组
        $value=array();
        $username=trim($_REQUEST['username']);
        $password=trim($_REQUEST['password']);

        // $DH=$db->get_one("select * from $thistable where  (username='".trim($username)."' or mobile='".trim($username)."' or (email='".trim($username)."' and email_yz=1)) and del=0 ");

        $islogin=loginaddpoint($username,$password,$type="");

        $user_id = $islogin;
        if($islogin>0){

            //数据库获取用户所有信息
            $umodel = M('user','jo2_');
            $U=$umodel -> where("userid='".$user_id."'") -> find();
            //var_dump($U);
            $_SESSION["userid"]=$U["userid"];
            $_SESSION["username"]=$U["username"];
            $_SESSION["usertype"]=$U["type"];
            $_SESSION["sessionid"]=$sessionid;
            $U['face']=$siteurl.$U['face'];
            $U['face_s']=$U['face_s']?$siteurl.$U['face_s']:'';
            $value['sessionid']=$sessionid;
            $value['account'] = $U['username'];
            $value['user_id'] = $U['userid'];
            $value['msg'] = "登陆成功！";
            $value['code'] = "200";

            if($_GET[isdz]=="1"){
                $json=json_encode($U);
            }else{
                $json=json_encode($value);
            }
            echo $json;

        }else if($islogin == -2){
            $value['msg'] = "密码错误！";
            $value['code'] = "101";
            $json=json_encode($value);
            echo $json;
        }else if($islogin == -1){
            $value['msg'] = "用户名和密码不能为空！";
            $value['code'] = "102";
            $json=json_encode($value);
            echo $json;
        }else if($islogin === 0){
            $value['msg'] = "账号不存在！";
            $value['code'] = "103";
            $json=json_encode($value);
            echo $json;
        }

    }
}
