<?php 
ini_set('date.timezone','Asia/Shanghai');
require_once "lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
if(isset($_REQUEST["money"]) && $_REQUEST["money"] != ""){
	$tools = new JsApiPay();
	$openId = $tools->GetOpenid();
	$money = $_REQUEST["money"];
	$input = new WxPayUnifiedOrder();
	$input->SetBody("CORNER COFFEE & DRINK BAR");
	$input->SetAttach("CORNER COFFEE & DRINK BAR2");
	$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
	$input->SetTotal_fee(strval((int)$money * WxPayConfig::DISCOUNT));
	$input->SetTime_start(date("YmdHis"));
	$input->SetTime_expire(date("YmdHis", time() + WxPayConfig::EXPIRE_TIME));
	$input->SetGoods_tag("corner ");
	$input->SetNotify_url("http://cornerpay.applinzi.com/notify.php");
	$input->SetTrade_type("JSAPI");
	$input->SetOpenid($openId);
	$order = WxPayApi::unifiedOrder($input);
	$jsApiParameters = $tools->GetJsApiParameters($order);
}
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<link rel="stylesheet" type="text/css" href='css/weui.css' />
	<link rel="stylesheet" type="text/css" href='css/pay.css' />
	<script type="text/javascript" src="js/jquery-1.12.3.min.js"></script>
	<title>角落微信快速支付</title>
	<script type="text/javascript">
		$(document).ready(function(){
			if (typeof WeixinJSBridge == "undefined"){
				if( document.addEventListener ){
					document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
				}else if (document.attachEvent){
					document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
					document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
				}
			}else{
				onBridgeReady();
			}
			$('.button').attr('disabled',true);
			$('.button').addClass('weui_btn_disabled');
			var reg = new RegExp('^[0-9]+$');

			$('#money').keyup(function(){
				console.log(!reg.test($(this).val()))
				if($(this).val().length !=0 && reg.test($(this).val())){
					$('.button').attr('disabled',false);
					$('.button').removeClass('weui_btn_disabled');
					;}
					else{
						$('.button').attr('disabled',true);
						$('.button').addClass('weui_btn_disabled');
					}
				});

			
		});
		function onBridgeReady(){
			WeixinJSBridge.call('hideOptionMenu');
		}


	</script>
	<script type="text/javascript">
		function jsApiCall()
		{
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest',
				<?php echo $jsApiParameters; ?>,
				function(res){
					if(res.err_msg == "get_brand_wcpay_request：ok" ) {
						WeixinJSBridge.call('closeWindow');
					}else{
						WeixinJSBridge.call('closeWindow');
					}
				}
				)
		};

		function callpay()
		{
			if (typeof WeixinJSBridge == "undefined"){
				if( document.addEventListener ){
					document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
				}else if (document.attachEvent){
					document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
					document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
				}
			}else{
				jsApiCall();
			}
		}
	</script>
	<script type="text/javascript">	
		window.onload = function(){
			function is_weixin(){
				var ua = navigator.userAgent.toLowerCase();
				if(ua.match(/MicroMessenger/i)=="micromessenger") {
					return true;
				} else {
					return false;
				}
			}
			if( is_weixin() ) {
				$('#load').addClass('hidden');
				$('#payment').removeClass('hidden');  
			}else{
				window.location.href ="http://cornerpay.applinzi.com";
			}	
			var src;
			src = '<?=$money;?>';
			if(src) {
				document.getElementById("money").value  = '<?=$money;?>';
				if (typeof WeixinJSBridge == "undefined"){
					if( document.addEventListener ){
						document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
					}else if (document.attachEvent){
						document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
						document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
					}
				}else{
					jsApiCall();
				}
			}
		};
	</script>
</head>
<body class="container">
	<div class="loader" id="load">
		<div class="inner one"></div>
		<div class="inner two"></div>
		<div class="inner three"></div>
	</div>
	<div id="payment" class="hidden">
		<div class="weui_cells_title pay_title"><p>付款给 <span>西工大角落咖啡茶饮</span></p></div>
		<form action="#" method="post"> 
			<div class="weui_cells_title comsume">消费金额 <span> * 请询问店员后在下方输入</span></div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="money_symbol">¥</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input autofocus="true" type="text" pattern="\d*" maxLength="3" name="money"; id="money" class="weui_input money_input" />	
				</div>
			</div>		
			<div>
				<input type="submit" class="weui_btn weui_btn_primary button" value="确认支付" />
			</div>
		</form>
		<div class="footer">
			<i class="weui_icon_info_circle"></i>
			<p>本服务由<strong>角落咖啡</strong>提供前端支持</p>
			<p>Copyright © 2016 Hicorner Inc. All rights reserved.</p>
		</div>
	</div>

</body>
</html>