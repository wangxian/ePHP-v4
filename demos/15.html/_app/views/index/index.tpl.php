<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_DIR;?>/css/common.css">

<h1>html伪静态化和url路由</h1>
<p>如果要进行seo的优化，你可以用简单的html伪静态加上后缀，或更深层次的url改变，url路由。</p>

<h2>html伪静态 - 加后缀</h2>
<p>如果要简单的在url上带上后缀比如.html .shtml等，只要修改一下main.config.php中的
<samp>'html_url_suffix'	=> '.html',	#伪静态后缀设置</samp> 然后用U()函数生成的url就会带上后缀。<br />
这样比较简单，效率也是最高的。
</p>

<h2>隐藏入口文件，比如隐藏index.php</h2>
<p>如果感觉只带上后缀不够的话，你还可以隐藏入口文件，一般入口文件是index.php。那么你可以这样做。把main.config.php中的
<samp>'url_type' => 'SEO',	#url类型PATH_INFO|GET|SEO, SEO模式采用PATH_INFO但无入口index.php等；</samp>设置为SEO，<br />
这样你再用U()方法生成url就没有入口文件index.php了。
当然，这样你需要些rewrtie规则了。不然url就无效了。<br />
下面是apache 和 nginx的规则，把请求重写到入口文件上。
</p>

<dfn>apache rewrite规则，提示在项目根目录写一个.htaccess即可。</dfn>
<pre>
RewriteEngine on
RewriteCond $1 !^(index\.php|assets|robots\.txt)
RewriteRule ^(.*)$ index.php/$1 [L]
</pre>

<dfn>nginx规则</dfn>
<pre>
注释下面几行
#location ~ .*\.(php|php5)?$
#{
#	fastcgi_pass  unix:/tmp/php-cgi.sock;
#	fastcgi_index index.php;
#	include fcgi.conf;
#}

替换为如下内容：
if ($request_uri !~* "^/(index\.php|robots\.txt$|assets)"){
       rewrite ^/(.*)$ /index.php?$1 last;
}


location ~ \.php {

        fastcgi_pass  unix:/tmp/php-cgi.sock;
        include fcgi.conf;

		#支持path_info
        set $path_info "";
        set $real_script_name $fastcgi_script_name;
        if ($fastcgi_script_name ~ "^(.+?\.php)(/.+)$")
        {
            set $real_script_name $1;
            set $path_info $2;
        }

        fastcgi_param PATH_INFO $path_info;
        fastcgi_param  SCRIPT_NAME        $real_script_name;

        fastcgi_param  SCRIPT_FILENAME  $document_root$real_script_name;
}

</pre>

<h2>url路由</h2>
<p>如果你感觉url还是不符合你的要求，那么你可以用url路由的方法，重写url，你可以随心所欲的定制你的url了。</p>
<p>首先开启url_router,设置<dfn>'url_router' => true, #是否启用url路由功能</dfn> 然后系统会载入conf/router.config.php</p>

<p>下面主要说一下router.config.php的规则：</p>
<pre>
return array(
	//一个路由模块中，可有多个规则，优先匹配第一个规则。
	'test'=> //index.php后，/之前，的第一个字符串
	 array
	 (
		array('|/test/(\d+)|','/test/test/your_type/$1'),
	 ),
	 //规则：http://host/index.php/test/15 重写到：http://host/index.php/test/test/your_type/15

	'archives'=>
	 array
	 (
		array('|^/archives/(\d+).html$|','/index/test/your_id/$1.html'),
	 ),
	 //规则：http://host/index.php/archives/15.html 重写到：http://host/index.php/index/test/your_id/15.html
	 //如果url_type => 'SEO' 那么，规则：http://host/archives/15.html 重写到：http://host/index/test/your_id/15.html

);
</pre>

<p class="important">上面的url规则，如果设置了url_type => 'SEO'那么,规则中的入口文件index.php就没有了。</p>

<h2>伪静态新的出路</h2>
<p>如果你要把你的url变成这样http://hostname/book/archives/15.html 一定需要路由重写吗？</p>
<p>当然答案是否定的，你可以用U('book/archives/15')直接生成这样的url,用getp(3)就可以拿到15，这个book_id了。 关于U()的使用请 <a href="../17.U/">查看这里</a>。</p>
<p>这样来处理伪静态，效率最高，不存在应能消耗，和用PATH_INFO的方式是一样的。</p>

<h2>伪静态,无目录方式的url</h2>
<p>如果你需要http://hostname/book-archives-15.html</p>
<p>你可以这样做，设置'url_type'=>'NODIR',这样U('book/archives/15),就会生成上面的URL.</p>
<br /><br />