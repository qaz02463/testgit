<?php
namespace Home\Controller;
use Think\Controller;
class YbpController extends Controller {
    public function index(){
    	/*ob_start();
        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"
        xmlns:w="urn:schemas-microsoft-com:office:word"
        xmlns="http://www.w3.org/TR/REC-html40">';
        $data=file_get_contents("http://localhost/tp/index.php/home/ybp");
        var_dump($data);die;
        echo "</html>";
        $data = ob_get_contents();
        ob_end_clean();

        $fp=fopen($fp,"wb");
        fwrite($fp,$data);
        fclose($fp);*/
    	$this->display();
    }
    public function down(){
		$fileName = 'new_file.doc';
        $c = curl_init();
        $url = "http://localhost/tp/index.php/home/ybp/index.html";
        curl_setopt($c, CURLOPT_URL, $url); 
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($c);curl_close($c);
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=$fileName");
        $html = '<html xmlns:v="urn:schemas-microsoft-com:vml"
             xmlns:o="urn:schemas-microsoft-com:office:office"
             xmlns:w="urn:schemas-microsoft-com:office:word" 
             xmlns:m="http://schemas.microsoft.com/office/2004/12/omml" 
             xmlns="http://www.w3.org/TR/REC-html40">';
        $html .= '<head><meta charset="UTF-8" /><xml><w:WordDocument><w:View>Print</w:View></xml></head><body>';
        $html .="$result";
        $html .= '</body></html>';
        var_dump($html);
    }
    function base64_image_content(){
		$base64_image_content=$_POST['img'];
		if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
			$type = $result[2];
			$new_file = "Uploads/".date('Ymd',time())."/";
			$new_file = $new_file.time().".{$type}";
			if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
				$this->ajaxReturn($new_file);
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	 
	//echo base64_image_content($base64_img,"uploads/");
}