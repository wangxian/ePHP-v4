<?php
 /**
 +------------------------------------------------------------------------------
 * test
 +------------------------------------------------------------------------------
 * @version 3.0
 * @author  WangXian
 * @email	<wo#wangxian.me>
 * @creation date 2011-3-25 下午04:59:59
 * @last modified 2011-3-25 下午04:59:59
 +------------------------------------------------------------------------------
 */

class testController
{
	function show_successAction()
	{
		echo '<a href="'.U('test/show_success1').'">show_success1，自动后退</a><br />';
		echo '<a href="'.U('test/show_success2').'">show_success2，指定成功后的url</a><br />';
		echo '<a href="'.U('test/show_success3').'">show_success3，操作成功3，不带跳转。</a><br />';
	}

	function show_errorAction()
	{
		echo '<a href="'.U('test/show_error1').'">show_error1，自动后退</a><br />';
		echo '<a href="'.U('test/show_error2').'">show_error2，指定成功后的url</a><br />';
		echo '<a href="'.U('test/show_error3').'">show_error3，操作成功3，不带跳转。</a><br />';
	}

	public function indexAction()
	{
		echo Http::sendRequest('http://121.101.217.104/re.php',$_SERVER,'POST');
	}

	public function errorAction()
	{
		fopen();
	}

	public function show_success1Action()
	{
		show_success('程序执行成功！！！！！');
	}

	public function show_success2Action()
	{
		show_success('程序执行成功！！！！！', U('test/show_success'),500);
	}

	public function show_success3Action()
	{
		show_success('操作成功提示语，不跳转。',false);
	}

	public function show_error1Action()
	{
		show_error('操作失败1，自动跳转');
	}

	public function show_error2Action()
	{
		show_error('操作失败2，指定跳url', U('test/show_error'),500);
	}

	public function show_error3Action()
	{
		show_error('操作失败3，强制不跳转。',false);
	}

	public function show_404Action()
    {
    	show_404();
    }


	/** 数据库操作。 **/
	public function dbAction()
	{
		$test = QM('test');

		$data1 = $test->limit(2)->findObjs();
		$data2 = $test->limit(0,2)->findAll();

		dump($data1 ,'findObjs()的数据格式');
		dump($data2, 'findAll()的数据格式');

		run_info();
	}

	/** 数据库操作2。 **/
	function db2Action()
	{
		/**
		 * 用$this->model对象的方式操作库的方式。前提是当前控制器继承controller
		 */
		dump($this->model->limit(3)->findAll( 't_test2' ) ,'查询三条');
		dump(  $this->model->findPage( 't_test' )  ,'查询一条');
	}

	/** 测试表单的提交。提交错误后保留表单内容 **/
	public function formAction()
	{
		$view = new view();
		$view->render();
	}

	/** 防止浏览器刷新。 **/
	public function limitRefreshAction()
	{
		Http::limitRefresh(5);
		echo date('现在时间:Y-m-d H:i:s');

		dump($_COOKIE);
	}

	/** 测试session。 **/
	public function sessionAction()
	{
		Session::init();//初始化
		Session::set('userinfo', array('name'=>'WangXian','age'=>22) );
		dump(Session::get());
		dump(Session::get('userinfo.age'));
	}

	/** 测试cookie。 **/
	public function cookieAction()
	{
		Cookie::set('yourname','王见');
		dump(Cookie::get());
	}

	/** 测试html扩展类。 **/
	public function html_helperAction()
	{
		echo Html::a('test/test1','菜单1')."<br />\n";
		echo Html::a('test/test2')."<br />\n";
		echo Html::img('http://code.google.com/p/php-framework-ephp/logo?cct=1289279165')."<br />\n";

		/** 仔细看生成的html。 **/
		echo Html::link_tag(STATIC_DIR.'/js/my.js')."\n";
		echo Html::link_tag(STATIC_DIR.'/css/header.css')."\n";
		echo Html::link_tag(STATIC_DIR.'/images/favicon.ico')."\n";

		/** 数据列表。 **/
		$arr = array('WangXian', '木頭', 'Bob', 'Locort', 'brongh', '老常');
		//echo Html::ul($arr);
		echo Html::ul($arr, array('id'=>'list1', 'class'=>'classname'));
		echo Html::ol($arr);
		//多维数组
		$arr2 = array('分组1'=>array('WangXian','木頭','mutou','xian366'), '分组2'=>array('老常','changboter','chy'));
		echo Html::ul($arr2);
		echo Html::ol($arr2);

		/** 输出n个空格or换行。 **/
		echo Html::br(5);
		echo Html::nbs(10);

		run_info();
	}

	public function html_tableAction()
	{
		// Html::talbe(第一个参数必须是二维数组，第二个参数为table的标题th项，第三个是属性设置id或class);
		// 说明该方法可以支持，td中再嵌套一个table
		$arr = array(array('WangXian1', '木頭1', 'Bob1', 'Locort1', 'brongh', '老常4'),
					 array('WangXian2', '木頭2', 'Bob2', 'Locort2', 'brongh', '老常5'),
					 array('WangXian3', '木頭3', 'Bob3', 'Locort3', 'brongh', '老常8'),
					 array('WangXian2', '木頭2', 'Bob2', 'Locort2', 'brongh', '老常5'),
					 array('WangXian3', '木頭3', 'Bob3', 'Locort3', 'brongh', '老常8'),
					 array('WangXian2', '木頭2', 'Bob2', 'Locort2', 'brongh', '老常5'),
					 array('wx'=>'tb_wx将作为该单元格的id', '木頭3', array(1,2,3,4), 'Locort3', 'brongh', array(array(11,21,31,41),array(42,22,32,41))),
			   );
		$title = array('标题1','标题2','标题3','标题4','标题5','标题6');
		$this->view->data = Html::table($arr,$title,array('class'=>'datalist','id'=>'yourid'));
		$this->view->render();
	}

	/** 测试Dir目录类。 **/
	public function dirAction()
	{
		dump( Dir::map('_app/models',1) );
	}

	/** 加密&解密。 **/
	public function encryptAction()
	{
		//第一种
		echo Encrypt::encryptG('your text').'<br />';
		echo Encrypt::decryptG('+U42e1AroofGkjKv6p9+hjkLe2B8Fj81G4f2+RbUgwM=').'<br /><br />';

		//第二种
		echo Encrypt::edcode('your text','ENCODE').'<br />';
		echo Encrypt::edcode('GtGVrn6LmhAHpI2qWN0ttxc', 'DECODE').'<br /><br />';

		//第三种,一种通用的加密方式，hmac_sha1非可逆，固定长度
		echo Encrypt::hmac_sha1('your text').'<br />';

	}

//	public function email2Action()
//	{
//		$email = new Email('','','');
//		echo $email->smail(array('xian366@qq.com'),'怎么就没附件呢，奇怪了啊!', array('e:/test.7z'));
//
//	}

	/** 测试curl超时。 **/
	public function sendRequestAction()
	{
		echo ( Http::sendRequest('http://121.101.217.104/re.php?name=wx',array('q'=>'ePHP3','id'=>1),'POST',1) );
	}

	/** 测试cache。 **/
	public function cacheAction()
	{
		// 默认采用文件缓存，支持memcache缓存，请在main.config.php中配置。
		//'cache_type' => 'FileCacheX', #可选,FileCacheX | MemCacheX 分别为文件缓存、MemCache缓存

/**
如果选择了，memcache缓存驱动，则需要在APP_PATH.'/conf/memcache.config.php'中配置memcache server信息。
配置格式如：
_app/conf/memcache.config.php
<?php
return array(
	array('host'=>'192.168.0.102','port'=>11211,'weight'=>3),
	array('host'=>'192.168.0.103','port'=>11211,'weight'=>3),
	array('host'=>'192.168.0.106','port'=>11211,'weight'=>4),
);
?>
*/
		$cache = Cache::init();

		//set/get缓存,第一种方式,默认长久有效
		dump( $cache->set('info', $_SERVER,10));
		dump( $cache->get('info') );

		//set/get缓存,第二种方式,默认长久有效
		$cache->name = 'My name is wx.';
		echo $cache->name;

		//删除一条缓存
		//dump($cache->delete('info'));

		//刷新缓存区，清空所有缓存。
		//Cache::init()->flush();exit;



	}

	public function xml_encodeAction()
	{
		header('Content-type: text/xml');

		$data = array('author1'=>array('name'=>'wangxian1','info'=>'wx'), 'author2'=>array('name'=>'wangxian2'));
		echo Xml::toXml((object)$data);
	}

	/** 测试解析indexAction生成的xml。 **/
	function xml_decodeAction()
	{
		dump( Xml::toArray( file_get_contents('http://svnhome.dev/ePHP/examples/9.xml/index.php') ) );
	}

	/** xss跨站攻击过滤。 **/
	public function xssAction()
	{
		$val = 'document.write("abc");';
		dump( Func::remove_xss($val) );
	}

	/** 断言测试。 **/
	public function assertAction()
	{
		true || $this->xml_decodeAction();
		0 || $this->xml_encodeAction();
	}

	/** request测试。 **/
	public function requestAction()
	{
		/**
		 * 这里演示的是用对象的方式获取数据。
		 * 前面已经用过getv() postv()等函数或静态类Session::get()的方式获取值。
		 * 这里用$this->request->xxxx()的方式和函数的方式是一样的。
		 *
		 * 支持这种方式，主要是为了多一种选择。
		 * 但前提是，如果你用这种方式，当前控制器必须继承了controller
		 *
		 * 个人建议用getv() postv requestv() Session::get()的方式。
		 * 理论上效率是一样的
		 */
		dump( $this->request->get() );
		dump( $this->request->get('action') );

		dump( $this->request->post('action') );

		dump( $this->request->server('HTTP_HOST') ,'server');

		dump( $this->request->env() ,'env');

		dump( $this->request->session() ,'session');
		dump( $this->request->cookie() ,'cookie');
	}

	/** 表单规则验证。 **/
	public function validateAction()
    {
    	/**
	     * Check
	     *
	     * $rules = array(
	     *     'required' => true if required , false for not
	     *     'password_confirm' confirm password
	     *     'type'     => var type, should be in ('email', 'url', 'ip', 'date', 'number', 'int', 'string')
	     *     'regex'    => regex code to match
	     *     'func'     => validate function, use the var as arg
	     *     'max'      => max number or max length
	     *     'min'      => min number or min length
	     *     'range'    => range number or range length
	     *     'message'  => error message,can be as an array
	     * )
	     */

        $data = array(
            'name' => 'wx',
            'password'  => '111',
            'nickname' => '',
            'age'  => 41
        );

        // 关于message，如果规则验证失败，都显示一种错误，message为string，
        // 如果要详细区分规则验证失败的原因，则message为array
        $rules = array(
            'name' => array('required' => true, 'max' => 16, 'min' => 4, 'message'=>array('max'=>'必须小于16位','min'=>'必须大于4位')),
            'password'  => array('required' => true, 'type' => 'string', 'range' => array(6, 16)),
            'nickname' => array('required' => true,'range' => array(5, 16)),
            'age'  => array('type' => 'int', 'range' => array(10,40), 'message' => '年龄范围不符合。')
        );

        dump($this->validate->check($data, $rules, true));
        dump($this->validate->error());
    }

    /** 结合view视图测试表单验证。 **/
    public function form_checkAction()
    {
    	$rules = array(
            'username' => array('required' => true, 'max' => 16, 'min' => 4, 'message'=>'用户名长度必须小于16位,必须大于4位'),
            'password'  => array('required' => true, 'type' => 'string', 'range' => array(6, 16), 'message'=>'密码必须大于6位，小于16位。'),
            'passconf' => array('required' => true, 'password_confirm' => 'password','message'=>'两次密码不一致！'),
            'email'  => array('type' => 'email', 'message' => 'email地址无效。')
        );

        if(postv('username'))
        {
        	if(! $this->validate->check($_POST, $rules))
        	{
        		// 验证错误以字符串的形式输出
        		show_error( implode($this->validate->error(), '<br />') );
        	}
        	else
        	{
        		echo 'success!';
        	}
        }
        $this->view->render();
    }

    public function form_createAction()
    {
    	echo Html::form_hidden('wx', '王见');

    	//设置多个
    	echo Html::form_hidden($_SERVER);

    	$arr = array('name'=>'wx','tt1'=>11111,'tt2'=>22222,'tt3'=>3333333,'nickname'=>'木頭','info'=>array(1,2,3));

    	// Html::form_select(select的name，option的名称和value，默认选中|可以是同时选中几个,额外参数如js等)
    	echo Html::form_select('select', $arr, 'tt3');
    	//echo Html::form_select('select', $arr, array('name','tt3'));

    	echo Html::br(3);
    	echo Html::form_checkbox('name', 'wx', true,'onclick="aa();"');

    	echo Html::br(3);
    	echo Html::form_prep('<br /><b>It\'s ok.</b>');
    }

    public function global_testAction()
    {
    	C('c_test','main','111111111111111111111');
    	printdie($GLOBALS);
    	run_info();
    }

	/**
	 * 汉字翻译成拼音
	 */
	public function pinyinAction()
	{
		$py = new Pinyin;
		echo $py->output('我是中文，I am English.');//输出
	}

	/**
	 * 测试socket
	 */
	public function socketAction()
	{
		$config = array(
			'host'			=> '127.0.0.1',
			'protocol'		=> 'tcp',
			'port'			=> 1234,
			'timeout'		=> 30,
			'persistent'	=> false,//持久
		);
		$socket = new Socket($config);
		$socket->write('ahh,this is a test.');
		echo $socket->read();
	}

	public function sendDataAction()
	{
		run_info();
		Http::sendRequest('http://www.baidu.com', array('wd'=>'keyword'), 'GET', array(), 1);
//		echo Http::sendRequest('http://'.$_SERVER['HTTP_HOST'].U('test/timeout'), array('wd'=>'keyword'), 'GET', array(), 1);
		run_info();
	}

	function timeoutAction()
	{
		sleep(29);echo 123;
	}

	/**
	 * 客户端ip地区
	 */
	public function clientAreaAction()
	{
		dump( Http::clientArea('202.106.0.20') );
	}

	public function dumpAction()
	{
		wlog('abc', 123);
		print_r($_GET);
		dump(array(null,false,0,$_GET));
	}
}