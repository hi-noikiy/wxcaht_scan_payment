###SDK
体验地址
http://cornerpay.applinzi.com/money.php

![扫码体验](image/1463015116.png)

###快速搭建指南
1. 安装配置nginx+phpfpm+php
2. 建SDK解压到网站根目录
3. 修改lib/WxPay.Config.php为自己申请的商户号的信息（配置详见说明）
4. 下载证书替换cert下的文件
5. 搭建完成

###SDK目录结构
```
.
├── README.md
├── WxPay.JsApiPay.php
├── WxPay.MicroPay.php
├── WxPay.NativePay.php
├── cert
│   ├── apiclient_cert.pem
│   └── apiclient_key.pem
├── css
│   ├── pay.css
│   ├── warn.css
│   └── weui.css
├── image
│   └── 1463015116.png
├── index.php
├── js
│   └── jquery-1.12.3.min.js
├── lib
│   ├── WxPay.Api.php
│   ├── WxPay.Config.php
│   ├── WxPay.Data.php
│   ├── WxPay.Exception.php
│   └── WxPay.Notify.php
├── money.php
└── notify.php
```
### 目录功能简介
#### lib (API接口封装代码)
WxPay.Api.php 包括所有微信支付API接口的封装
WxPay.Config.php  商户配置
WxPay.Data.php   输入参数封装
WxPay.Exception.php  异常类
WxPay.Notify.php    回调通知基类

#### cert 
证书存放路径，证书可以登录商户平台https://pay.weixin.qq.com/index.php/account/api_cert下载

###配置指南
MCHID = '1225312702';
这里填开户邮件中的商户号

APPID = 'wx426b3015555a46be';
这里填开户邮件中的（公众账号APPID或者应用APPID）

KEY = 'e10adc3949ba59abbe56e057f20f883e'
这里请使用商户平台登录账户和密码登录http://pay.weixin.qq.com 平台设置的“API密钥”，为了安全，请设置为32字符串。

APPSECRET = '01c6d59a3f9024db6336662ac95c8e74'
改参数在JSAPI支付（open平台账户不能进行JSAPI支付）的时候需要用来获取用户openid，可使用APPID对应的公众平台登录http://mp.weixin.qq.com 的开发者中心获取AppSecret。
