<?php

namespace App\Http\Controllers\search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;
use App\Facades\teratailAPI;
use App\Facades\utils;

/**
 * teratailの記事の内容から検索したい内容を取り出す
 */
class GetMyArticlesController extends Controller
{
    public function searchArticle(Request $request) {
        $requestParam = $request->all();
        $validator = Validator::make($requestParam,[
            'searchWord' => 'required',
            'accesstoken'=> 'required',
            'userID'=> 'required',
        ]);
        $getArticle = $this->getMyArticles($requestParam);
        $validator->after(function($validator) use($getArticle){
            if(!is_array($getArticle)){
                $validator->errors()->add('searchWord','不正なリクエストです:'.$getArticle);
            }
        });
        if($validator->fails()){
            return redirect('/')
                        ->withErrors($validator)
                        ->withInput();
        }
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
    /**
     * リクエスト内容を元に、teratailから記事を取得する
     * @param array $requestParam ユーザーID,
     * @return type
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
        //リクエストに失敗したらエラーメッセージを残して処理終了
        if($meta['message'] != 'success'){
            return $meta['message'];
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
