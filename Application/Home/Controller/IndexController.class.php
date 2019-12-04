<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	phpinfo();die;
    	$ze=240;
        $sl=0.060000;
        $dj=round($ze/(1+$sl),8);
        $je=round($dj,2);
        $se=round($je*$sl,2);
        var_dump($dj);
        var_dump($je);
        var_dump($se);
        var_dump(round($ze/(1+$sl),2));
    }
}