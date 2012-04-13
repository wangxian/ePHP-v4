<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE;?>/css/common.css">

<h1>正则配置类 -- Regexp</h1>
<p>Regexp类，提供了几个简单的严重规则，你也可以自定义正则规则。</p>

<pre>
[说明]
email    => 是否为有效的Email地址
numeric  => 是否为全是数字的字符串(可以是 "0" 开头的数字串)
qq       => 腾讯QQ号
idCard   => 身份证号码
china    => 是否为中文
zip      => 邮政编码
phone    => 固定电话(区号可有可无)
mobile   => 手机号码
mobilePhone => 手机和固定电话

[示例]
------------------- 使用示例代码如下 -------------------
echo Regexp::check('Email','aaa@aa.com') ? '邮箱地址正确' : '邮箱地址错误';
echo Regexp::check('/aaa/','aaabbb') ? '字符串aaa存在' : '不存在';
echo Regexp::check('/\d{15}|\d{18}/','aaaa@162.com');
------------------------------------------------------
</pre>