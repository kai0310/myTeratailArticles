<?php
namespace App\Services;
class teratailAPI{
    /**
     * 実際にAPIを実行する処理。取得結果を配列にデコードして返却
     * @param array $requestParam ユーザID,アクセストークンを利用
     * @param string $url
     * @param int $page
     * @return type
     */
    public function callAPI(Array $requestParam, string $url,int $page=0) {
        $access_token = $requestParam['accesstoken'];
        if($page){
            $url .= '&page='.$page;
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$access_token));

        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result,true);
    }
}