<?php

namespace App\Http\Controllers\search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use App\Facades\teratailAPI;
use App\Facades\utils;

/**
 * teratailの記事の内容から検索したい内容を取り出す
 */
class GetMyArticlesController extends Controller
{
    public function searchArticle(Request $request) {
        $request->validate([
            'searchWord' => 'required',
            'accesstoken'=> 'required',
            'userID'=> 'required',
        ]);
        $requestParam = $request->all();
        $getArticle = $this->getMyArticles($requestParam);
        
        $response = new Response(view('searchResult', compact('getArticle','requestParam')));
        if(isset($requestParam['saveCookie'])){
            $response->withCookie(cookie()->forever('accesstoken', $requestParam['accesstoken']));
            $response->withCookie(cookie()->forever('userID', $requestParam['userID']));
        }else{
            Cookie::queue(Cookie::forget('accesstoken'));
            Cookie::queue(Cookie::forget('userID'));
        }
        return $response;
    }
    /***
     * APIを使って自分が回答した内容を検索する
     */
    private function getMyArticles(Array $requestParam){
        if($requestParam['answerOrQuestion']=='isAnswer'){
            $url = 'https://teratail.com/api/v1/users/'. $requestParam['userID'] .'/replies?limit=100';
            $category = 'replies';
        }else{
            $url = 'https://teratail.com/api/v1/users/'. $requestParam['userID'] .'/questions?limit=100';
            $category = 'questions';
        }
        $resultArray = teratailAPI::callAPI($requestParam,$url);
        $meta = $resultArray['meta'];
        //リクエストに失敗したら処理終了
        if($meta['message'] != 'success'){
            echo $meta['message'];
            return;
        }
        $searchArray = explode (' ',$requestParam['searchWord']);
        $returnQuestions = utils::searchWord($resultArray[$category], $searchArray);
        //質問もしくはを100件以上していたらページネーションして全記事を取得
        if($meta['hit_num'] > 100){
            $page = ceil($meta['hit_num'] / 100);
            for($i=2;$i<$page+1;$i++){
                $resultArrayAdds = teratailAPI::callAPI($requestParam,$url,$i);//2ページ目以降
                $returnQuestionsAdded =  utils::searchWord($resultArrayAdds[$category], $searchArray);
                $returnQuestions =  array_merge($returnQuestions, $returnQuestionsAdded);
            }
        }
        return $returnQuestions;
    }
}
