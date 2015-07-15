# 建议项目部署路径

```
/
----/_app/              项目程序目录，此目录加上rewrite限制，不可访问。
----/_framework/        ephp核心库目录，禁止访问
----/assets/            资源目录,可访问
           /css/           
           /js/
           /images/
           /upload/
----/.htaccess          
apache的rewite规则，支持去掉index.php访问，nginx的规则写在nginx.conf中,详细见rewrite规则

----/index.php          ePHP程序的入口文件
```

    
当然上面的路径只是建议的，你也可以去把_app _framework拿到服务器webroot以外也是可以的，修改一下index.php即可，
如果按照以上部署，则不用修改index.php

如果有多个项目，那么再建一个_app_xxx的目录，你任意了。
然后修改rewrite规则。照葫芦画瓢就行了！~~~~~~~

如果不知道怎么修改，那就是网上搜索一下nginx和apache的rewrite的写法。
他们的rewrite规则还是不同的~~。。~~
