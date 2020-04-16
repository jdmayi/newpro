<?php
/**
 * User: liujufu
 * Date: 2017/9/4
 * Time: 13:00
 */
require '../../init.php';
require '../../service/ProductService.php';
//echo getSession('user_mobile');


if($channel==$channelArr['aibao']){
    $opid = !empty($_SESSION['open_id'])?$_SESSION['open_id']:'';
}else{
    $opid = '';
}
$needLogin=true;
if(in_array($channel,$notLoginChannels)){
    $needLogin=false;
}
$customerMobile= requestGet('customermobile');
if($channel== $channelArr['aihuanji'] && !empty($customerMobile) && !isLogin()){
    $param=[
            'mobile'=>$customerMobile,
    ];
    $resp= mUtil::callApi(customersvc_callurl,'CustomerDynamicLogin',$param);
    if(!empty($resp) && isset($resp->result) && $resp->result==1){
        setloginsuccess(1,$resp->customerid,"mobile_phone");
    }
}
if(!isLogin() && $needLogin){
    if(!loginByWeiXin()) {
        saveLoginRedirectUrl();
        gotoLogin();
    }
}
saveLoginRedirectUrl();
//echo $channel;die;
$headerTitle = '自助卡激活';
$bgImg='bg_login.jpg';
if(!empty($channel)&& $channel==$channelArr['baobao']){
    $bgImg='bg_fillcard.jpg';
}elseif (!empty($channel)&& ($channel==$channelArr['aibao']||$channel==$channelArr['yihaoji'])){
    $bgImg='bg_fillcard_aibao.jpg';
}elseif (!empty($channel)&& ($channel==$channelArr['xzl'])){
    $bgImg='bg_login_xzl.jpg';
}
$page_title = get_page_title(array("自助卡激活"));
$page_keywords = get_page_keywords(array());
$page_description = get_page_description(array());


$userMobile=getSession('user_mobile');
$pid = requestGet('pid');
$product = getProductById($pid, $yaoxiaoProduct);
include '../template/header.tpl.php';

?>
    <script src="/static/js/lib/length_conversion.js?v=<?= time()?>"></script>
    <link rel="stylesheet" href="/static/css/search.css?dw=<?php echo time();?>">
    <div class="banner" style="background: url('../../static/images/searchno/jhbg.jpg');background-size: 100%;">
        <!--    <div class="Backpic">-->
        <!--        &lt;-->
        <!--    </div>-->
        <!--    <div class="Using">-->
        <!--        使用记录-->
        <!--    </div>-->
    </div>
    <div class="infobox">
        <div class="infotit">
            自助卡激活
        </div>
        <div class="cardnobox">
            <div class="CardPic">

            </div>
            <div class="inpbox">
                <input type="text" value=""  style="font-size: 16px;" class="cardno" id="card" placeholder="请输入卡密" maxlength="14"  onkeyup="vfUtil.fomatnumber_4(this)">
            </div>
        </div>

        <div class="suresearch vf-btn1">
            激活/验证
        </div>
        <div class="userinfos">
            当前账号：<span class=""><?php echo $userMobile?></span>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/mview/user/login.php" class="btn-switch" style="color:blue;">切换账号</a>
        </div>
    </div>
    <div class="shili">

    </div>
<style>
    html, body {
        background: white !important;
        height: 100%;
        width: 100%;
    }
</style>
<?php
$channelTZ = !empty($_SESSION['channelTZ'])?$_SESSION['channelTZ']:'';
if($channel==$channelArr['yihaoji'] && $channelTZ ==''){
    //include template2('doc/notice_yihaoji');
    saveSession('channelTZ','1');
}
?>
    <script src="/static/js/insure/mobileinsurefillcard.js?v=<?= time()?>"></script>

<?php include '../template/footer.tpl.php'; ?>