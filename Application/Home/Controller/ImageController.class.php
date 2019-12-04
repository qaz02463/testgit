<?php
namespace Home\Controller;
use Think\Controller;
set_time_limit(0);

class ImageController extends Controller {
    public function index(){
    	select count(openid) abc,openid from fd_oyly38hb  group by openid order by abc desc
    	var_dump('aaa');die;
    	/*for($page=756;$page<=840;$page+=42){
    		$arr=$this->get_url("https://gelbooru.com/index.php?page=post&s=list&tags=sakimichan&pid=".$page);
        	$this->get_img_url($arr,$page);
    	}*/
    	//$this->http_down('https://gelbooru.com/index.php?page=post&s=list&tags=sakimichan&pid=420');
    }
	function ely(){
		$arr=array('1882782','1841786','1803899','1749543','1782308');
		$arr1=array('1765900','1735770','1730819','1177758','1139396');
		$arr2=array('1101068','1120171','1113112','1081915','1070766');
		$arr3=array('957704','924408','915360','882331','907494');
		$arr4=array('873834','848407','850748','834775','825466');
		$arr5=array('819120','641018','622311','618349','586664');
		$arr6=array('609268','612992','581131','502941','468099');
		$arr7=array('479838','414509','253639','325696','276346','253616');
		$arr20=array('628144','442885','407854');//daily
		foreach($arr20 as $k=>$v){
		    $content = file_get_contents('https://bcy.net/daily/detail/'.$v);
		    //$p='/class=[\'|\"]detail_std detail_clickable[\'|\"] src=[\'|\"](.*?)[\'|\"]/';
		    //$p='/https:\/\/img\d\.bcyimg\.com\/coser\/47815\/post\/(.*?)\.jpg/';
		    $p='/https:\/\/img\d\.bcyimg\.com\/user\/768355\/daily\/(.*?)\.jpg/';
		    preg_match_all($p,$content,$matches);

		    foreach ($matches[1] as $url) {
		        //$img = file_get_contents("https://img5.bcyimg.com/coser/47815/post/".$url.".jpg");
		        $img = file_get_contents("https://img9.bcyimg.com/user/768355/daily/".$url.".jpg");
		        $url = str_replace('/','-',$url);
		        file_put_contents('./save1/'.basename($url).".jpg",$img);
		    }
		}
		var_dump('全部完成');
	}
	function get_url($u=''){
		$content = file_get_contents($u);
		$p='/href=\"\/\/gelbooru.com\/index.php\?page=post\&amp\;s=view\&amp\;id=(.*?)\"/';
		preg_match_all($p,$content,$matches);
		return $matches[1];
	}
	function get_img_url($arr,$page){
		$u="https://gelbooru.com/index.php?page=post&s=view&id=";
		foreach($arr as $k=>$v){
			$content = file_get_contents($u.$v);
			$p='/href=\"https\:\/\/simg3.gelbooru.com\/\/images\/(.*?)\"/';
			preg_match_all($p,$content,$matches);
			$name=trim(strrchr($matches[1][0], '/'),'/');
			$url="https://simg3.gelbooru.com//images/".$matches[1][0];
			$db=M('img')->add(array('name'=>$name,'url'=>$url,'type'=>'0','page'=>$page,'gid'=>$v));
			echo '第'.$page.'页  第'.$k.'个  完成&nbsp;&nbsp;<br>';
			ob_flush();
		    flush();
		    sleep(1);
		}
		echo "第".$page."页&nbsp;全部完成";
	}
	//获取图片
	function http_down($url, $filename, $timeout = 0) {
	    $fp = fopen("/save/".$filename, 'w');
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_FILE, $fp);
	    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
	    curl_exec($ch);
	    curl_close($ch);
	    fclose($fp);
	}
}