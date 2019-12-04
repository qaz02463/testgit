<?php
namespace Think\Fp;
class Bsf
{
    private $iv = "lnhx2016lnhx2016";           //密钥偏移量IV，可自定义
    private $encryptKey = "TEST2019test2019";   //AESkey，可自定义
    /**
     * 电子发票接口
     */
    public function dianzifapiao($params = array(),$fpkj_xmxx = array(),$pushType = '0')
    {   
        // header("Content-type: text/xml");
        $xml_params = $this->paramsToString($params,$fpkj_xmxx);
        $result = base64_encode(openssl_encrypt($xml_params, 'aes-128-cbc',$this->encryptKey, true,$this->iv));
        $post_data = array(
            'xmlStr' => $result
        );
        $url = 'http://61.161.232.20:19510/aisino-peip/issueEI';
        $postdata = http_build_query($post_data);
        $data = $this->postXmlCurl($postdata,$pushType,$url); // pushType 推送方式
        if( $pushType == '0' ){  // 不用推送(推荐)返回提取码
            $jieguo = $this->jieguo_tuisong($data);
        }else if ($pushType == '1') {   // 电子发票（直接返回电子发票pdf文件）
            $jieguo = $this->jieguo_pdf($data);
        }else if ($pushType == '5') {   // 微信二维码(加密的提取码json的png)
            $jieguo = $this->jieguo_png($data);
        }else if ($pushType == '3') {   // 微信卡劵推送,返回插卡url
            $jieguo = $this->jieguo_url($data);
        }
        return $jieguo;
    }
 
    /**
     * 转换属性为XML字符串
     * @param array $params
     * @param string $xml_Name
     * @return string
     */
    protected function paramsToString($params = [], $fpkj_xmxx = [])
    {   
        // header("Content-type: text/xml"); 
        $xml = "<?xml version='1.0' encoding='GBK'?>";
        $xml .= "<REQUEST_FPKJ>";
        $xml .= "<FPKJ_FPT>"; 
        foreach ($params as $key=>$val){ 
            $xml.="<".$key.">".$val."</".$key.">"; 
        }
        $xml.="</FPKJ_FPT>"; 
        $xml.="<FPKJ_XMXXS>";
        $xml.="<FPKJ_XMXX>";
        foreach ($fpkj_xmxx as $key=>$val){
            $xml.="<".$key.">".$val."</".$key.">"; 
        }
        $xml.="</FPKJ_XMXX>";
        $xml.="</FPKJ_XMXXS>";
        $xml .= "</REQUEST_FPKJ>";
        return $xml;
    }

    // 处理返回数据
    public function jieguo_tuisong($data)
    {   
        $data_cg = [];
        if( strstr($data,'responseCode: 0000') ){   // 判断是否返回成功
            $data = explode("\n", $data);           // 已,分割为数组
            foreach ($data as $key => $value) {
                if( strstr($value,'invoiceNumber:') ){
                    $data_cg['电子发票号码'] = trim( str_replace('invoiceNumber:','',$value) );
                }elseif ( strstr($value,'invoiceCode:') ) {
                    $data_cg['电子发票代码'] = trim( str_replace('invoiceCode:','',$value) );
                }elseif ( strstr($value,'xsfBillNo:') ) {
                    $data_cg['外部网元请求流水号'] = trim( str_replace('xsfBillNo:','',$value) );
                }elseif ( strstr($value,'extractionCode:') ) {
                    $data_cg['电子发票提取码'] = trim( str_replace('extractionCode:','',$value) );
                }elseif ( strstr($value,'jym:') ) {
                    $data_cg['电子发票校验码'] = trim( str_replace('jym:','',$value) );
                }elseif ( strstr($value,'kprq:') ) {
                    $data_cg['电子发票开票日期'] = trim( str_replace('kprq:','',$value) );
                }elseif ( strstr($value,'jshj:') ) {
                    $data_cg['电子发票价税合计'] = trim( str_replace('jshj:','',$value) );
                }
            }
        }else{
            echo "信息错误";exit();
        }
        return $data_cg;
    }

    public function jieguo_pdf($data)
    {   
        if( empty($data) ){
            echo "信息错误";exit();
        }else{
            $data = $this->decrypt($data);
            $res = file_put_contents('demo.gz',$data,true);
            if( $res == 'false' ){
                echo "生成文件失败";exit();
            }else{
                echo "生成文件成功";exit();
            }
        }
    }

    public function jieguo_png($data)
    {   
        // var_dump($data);
        if( empty($data) ){
            echo "信息错误";exit();
        }else{
            $res = file_put_contents('demo1.png',$data,true);
            if( $res == 'false' ){
                echo "生成文件失败";exit();
            }else{
                echo "生成文件成功";exit();
            }
        }
    }

    public function jieguo_url($data)
    {
        if( strstr($data,'responseCode: 0000') ){   // 判断是否返回成功
            $data = explode("\n", $data);           // 已,分割为数组
            foreach ($data as $key => $value) {
                if( strstr($value,'WXURL:') ){
                    $data_url = trim( str_replace('invoiceNumber:','',$value) );
                }
            }
        }else{
            echo "信息错误";exit();
        }
        return $data_url;
    }

    // 解密
    public function decrypt($str)
    {
        //AES, 128 CBC模式解密数据
        $data = base64_decode($data);
        $res = openssl_decrypt($data, 'aes-128-cbc',$this->encryptKey, true,$this->iv);
        return $res;
    }
 
    /**
     * 作用：以post方式提交xml到对应的接口url
     * @param $data
     * @param $url
     * @return bool|mixed
     */
    public function postXmlCurl($data,$pushType,$url = 'http://61.161.232.20:19510/aisino-peip/issueEI')
    {   
        if( $pushType == '1' ){
            $status = 0;
        }else{
            $status = 1;
        }
        $headers = array(
            'Content-type:application/x-www-form-urlencoded;charset=UTF-8',
            'customerID:TEST0001',
            'pushType:'.$pushType,
        );
        try{
            // header("Content-type: text/html; charset=utf-8");
            $ch = curl_init();//初始化curl
            curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
            curl_setopt($ch, CURLOPT_HEADER, $status);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
            curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
            // $data = http_build_query($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $data = curl_exec($ch);//运行curl
            curl_close($ch);
            // var_dump($data);echo "<br><br><br>";
            return $data;
        }catch (\Exception $e) {
            return false;
        }
    }
 
 
}