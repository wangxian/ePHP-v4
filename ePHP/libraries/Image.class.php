<?php
 /**
 +------------------------------------------------------------------------------
 * 图片生成、缩略图等
 * <code>
 * 验证码使用示例
 * 在view上添加图片：<img src="/?c=reg&a=code" onclick="this.src='/?c=reg&a=code'" />
 *
 * //控制器代码
 * public function registerAction()
 * {
 *     echo Image::chkVerify() ? '验证码正确' : '验证码错误';
 * }
 * public funciton codeAction()
 * {
 *     Image::imgVerify();
 * }
 *
 * //输出图片的信息
 * print_r(Image::getInfo('/home/a.jpg'));
 *
 * //使用gd生成缩略图
 * Image::thumbImg('a.jpg','a-thumb.jpg',100,120);//生成 a.jpg 的缩略图,宽度:100 高度:120
 *
 * </code>
 +------------------------------------------------------------------------------
 * @version 3.0
 * @author WangXian
 * @email admin@loopx.cn
 * @package  libraries
 * @creation_date 2010-10-17
 * @last_modified 2010-12-25 19:14:58
 +------------------------------------------------------------------------------
 */

class Image
{
    /**
     * 得到图片的信息
     * @param $imgFile 文件文件名
     * @return array
     */
    static public function getInfo($imgFile)
    {
        $imageInfo = getimagesize($imgFile);
        if( $imageInfo!== false)
        {
            $imageType = strtolower(substr(image_type_to_extension($imageInfo[2]),1));
            $imageSize = filesize($imgFile);
            $info = array(
                "width"=>$imageInfo[0],
                "height"=>$imageInfo[1],
                "type"=>$imageType,
                "size"=>$imageSize,
                "mime"=>$imageInfo['mime']
            );
            return $info;
        }
        else return false;
    }

     /**
      * 生成缩略图
      * 缩略图会根据源图的比例进行缩略的，生成的缩略图格式是JPG
      * @param $srcfile:源文件名
      * @param $dstfile:生成缩略图的文件名
      * @param $thumbWidth:缩略图最大宽度
      * @param $thumbHeight:缩略图最大高度
      */
     static public function thumbImg($srcfile,$dstfile,$thumbWidth,$thumbHeight)
     {
        $imageinfo = getimagesize($srcfile);
        if(empty($imageinfo)) throw new ephpException('只支持gif,jpg,png的图片');
        // dump($imageinfo);

        if($imageinfo[2] == 1) $im = imagecreatefromgif($srcfile);
        elseif( $imageinfo[2] == 2 ) $im = imagecreatefromjpeg($srcfile);
        elseif( $imageinfo[2] == 3 ) $im = imagecreatefrompng($srcfile);
        else
        {
            throw new ephpException('只支持gif,jpg,png的图片');
        }

        $w = $imageinfo[0];
        $h = $imageinfo[1];

        if( $thumbWidth/$thumbHeight > $w/$h )
        {
            $nh = $thumbHeight;
            $nw = ($w*$thumbHeight)/$h;
        }
        else
        {
            $nw = $thumbWidth;
            $nh = ($h*$thumbWidth)/$w;
        }
        // echo "w: $nw , h: $nh";exit;

        $ni = imagecreatetruecolor($nw, $nh);
        imagecopyresampled($ni, $im, 0, 0, 0, 0, $nw, $nh, $w, $h);
        imagejpeg($ni, $dstfile);
        imagedestroy($im);

        return file_exists($dstfile);
     }

     /**
      * 验证码
	  * 图片尺寸,50x24
      *
      * @param integer $length :验证码长度
      * @param integer $mode  : 0大小写字母，1数字，2大写字母，3小写字母,5大小写+数字
      * @param string $type :图片类型
	  * @param boolean $hasborder :图片边框有否
      * @return binary
      */
    static public function imgVerify($length=4,$mode=3,$type='png',$hasborder=true)
    {
        $randval = Func::randString($length,$mode);
        $_SESSION['imgVerifyCode']=md5(strtolower($randval));
        //dump($_SESSION);exit;

		$width=50;
		$height=24;

        $width = ($length*9+10)>$width ? $length*9+10 : $width;
        if ( $type!='gif' && function_exists('imagecreatetruecolor'))
            $im = @imagecreatetruecolor($width,$height);
        else $im = @imagecreate($width,$height);

        //$r = array(225,255,255,223);
        //$g = array(225,236,237,255);
        //$b = array(225,236,166,125);
        //$key = mt_rand(0,3);
        //$backColor = imagecolorallocate($im, $r[$key],$g[$key],$b[$key]);
		$backColor = imagecolorallocate($im, 252,252,252);		//背景色

		if($hasborder) $border_color = 238;
		else $border_color = 255;
		$borderColor = imagecolorallocate($im, $border_color,$border_color,$border_color);	//边框色
        $pointColor = imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));                 //点颜色

        @imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $backColor);
        @imagerectangle($im, 0, 0, $width-1, $height-1, $borderColor);
        $stringColor = imagecolorallocate($im,mt_rand(0,200),mt_rand(0,120),mt_rand(0,120));

        // 干扰
		for($i=0;$i<10;$i++)
		{
			$fontcolor=imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			imagearc($im,mt_rand(-10,$width),mt_rand(-10,$height),mt_rand(30,300),mt_rand(20,200),55,44,$fontcolor);
		}

		for($i=0;$i<25;$i++)
		{
			$fontcolor=imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			imagesetpixel($im,mt_rand(0,$width),mt_rand(0,$height),$pointColor);
		}

        @imagestring($im, 5, 5, 3, $randval, $stringColor);

        header("Content-type: image/".$type);
        $ImageFun='Image'.$type;
        $ImageFun($im);
        imagedestroy($im);
    }

    /**
     * 检测输入的验证码是否正确
     * @param $verifyCode 用户输入的验证码
     * @return boolean
     */
    static public function chkVerify($verifyCode)
    {
    	if(empty($_SESSION['imgVerifyCode'])) return false;
        return $_SESSION['imgVerifyCode'] == md5(strtolower($verifyCode));
    }

}
/* End of file Image.class.php */
/* Location: ./_framework/libraries/Image.class.php */