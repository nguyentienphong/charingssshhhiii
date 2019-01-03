<?php

Class ChargingAPIServices
{
    //private $config_;
    public function ChargingAPIServices()
    {
        //$this->config_ = $config_;
    }

   
    public function charging($info)
    {	
        //{"partnerId":1001,"partner_username":"dev_test","cardPin":"1234567890","cardSerial":"12345678900","requestId":"1001_1528094181945","remark":"Thanh toan","providerCode":"VNP"}
        //{"partnerId":0,"partner_username":null,"cardPin":null,"cardSerial":null,"requestId":null,"receiveDate":null,"remark":null,"providerCode":null,"status":"04","cardAmount":null,"queryResult":null,"message":"PARSE REQUEST FAIL"}
        // $partnerId = $this->config->item('PARTNER_ID');
        $configs = include('application/config/config_charging.php');
        $partnerId = $configs['PARTNER_ID'];
        
		$requestId = $partnerId."_". date("YmdHis") . rand(1, 99999);
		$payment_data = array(
                    'partnerId' => $partnerId,
					'cardSerial' => $info['cardSerial'],
					'cardPin' => $info['cardPin'],
					'requestId' => $requestId,
					'providerCode' => $info['telcoCode'],
					'partner_username' => $configs['PARTNER_USERNAME'],
                    'remark' => "Thanh toan don hang:".$requestId,
                    'cardPrintAmount' => $info['cardAmount']
                );		
                
        $url = $configs['URLPAYMENT'];
        
		$url = $url .'request='.urlencode(json_encode($payment_data));
        
		//print_r($url);die;
        $response = $this->get_curl($url);	

		//$response = file_get_contents($json_url);		
        if($response){
		$input = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($response));		
        $json = json_decode($input, true);
        
        $status = $json['status'];
        
			//$datajson = json_decode($data, true);
			// echo $datajson['status'];die;	
			//print_r($json);
            if($status){
                return $json;
            }else{
                return 'Tham số truyền về không đúng định dạng. Mời bạn liên hệ với nhà cung cấp dịch vụ để biết thêm chi tiết'; die;
            }
        }else{
			//print_r($response);
            return 'Gạch thẻ không thành công. Mời bạn kiểm tra lại đường truyền và bật các extendsion cần thiết.'; die;
        }
    }

 
    private function signature_hash($transId, $config, $data)
    {
        return md5($config['partnerId'].'&'.$data['cardSerial'].'&'.$data['cardPin'].'&'.$transId.'&'.$data['telcoCode'].'&'.md5($config['password']));
    }

  
    private function get_transid($config)
    {
        return $config['partnerId'].'_'.date('YmdHis').'_'.rand(0, 999);
    }

    
    private function parseArray($response)
    {
        $return = array();
        $response = explode('&', $response);
        if(!empty($response)){
            foreach($response as $key => $value){
                $data = explode('=', $value);
                if(!empty($data[1])){
                    $return[$data[0]] = $data[1];
                }
            }
            return $return;
        }else{
            return array();
        }
    }

    /*
     * function get curl
     * author: Vu Dinh Phuong
     * date: 13/12/2016
     */
    private function get_curl($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);

        $str = curl_exec($curl);
        if(empty($str)) $str = $this->curl_exec_follow($curl);
        curl_close($curl);
        
        return $str;
    }
    
    /*
     * function dùng curl gọi đến link
     * author: Vu Dinh Phuong
     * date: 13/12/2016
     */
    private function curl_exec_follow($ch, &$maxredirect = null)
    {
        var_dump($ch);
        try{
        $user_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5)".
            " Gecko/20041107 Firefox/1.0";
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent );

        $mr = $maxredirect === null ? 5 : intval($maxredirect);

        if (ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off')) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $mr > 0);
            curl_setopt($ch, CURLOPT_MAXREDIRS, $mr);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        } else {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);

            if ($mr > 0)
            {
                $original_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
                $newurl = $original_url;

                $rch = curl_copy_handle($ch);

                curl_setopt($rch, CURLOPT_HEADER, true);
                curl_setopt($rch, CURLOPT_NOBODY, true);
                curl_setopt($rch, CURLOPT_FORBID_REUSE, false);
                do
                {
                    curl_setopt($rch, CURLOPT_URL, $newurl);
                    $header = curl_exec($rch);
                    if (curl_errno($rch)) {
                        $code = 0;
                    } else {
                        $code = curl_getinfo($rch, CURLINFO_HTTP_CODE);
                        if ($code == 301 || $code == 302) {
                            preg_match('/Location:(.*?)\n/', $header, $matches);
                            $newurl = trim(array_pop($matches));

                            if(!preg_match("/^https?:/i", $newurl)){
                                $newurl = $original_url . $newurl;
                            }
                        } else {
                            $code = 0;
                        }
                    }
                } while ($code && --$mr);

                curl_close($rch);

                if (!$mr)
                {
                    if ($maxredirect === null)
                        trigger_error('Too many redirects.', E_USER_WARNING);
                    else
                        $maxredirect = 0;

                    return false;
                }
                curl_setopt($ch, CURLOPT_URL, $newurl);
            }
        }
        return curl_exec($ch);
        }catch(Exception $e)
        {
            return 'Co mot loi j do';
        }
    
    }

}
?>