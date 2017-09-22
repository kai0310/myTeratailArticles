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
            return redirect('/')->withErrors($validator)->withInput();
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
     * TeratailAPIをページネーションしながら呼び出し、全ての記事を取得する。
     * @param array $requestParam
     * @return type
     */
    private function getMyArticles(Array $requestParam){
        $category = $requestParam['answerOrQuestion']==='isAnswer'?'replies':'questions';
        $url = 'https://teratail.com/api/v1/users/'. $requestParam['userID'] .'/'.$category.'?limit=100';
        $resultArray = teratailAPI::callAPI($requestParam,$url);
       if($resultArray['meta']['message'] != 'success'){ //metaの内容を確認してエラーがあったら終了
            return $resultArray['meta']['message'];
        }
        $searchArray = explode(' ',$requestParam['searchWord']);
        $articles = utils::searchWord($resultArray[$category], $searchArray);

        for ($i=2;$i<=$resultArray['meta']['total_page'];$i++){//2ページ目から最終ページまでを取得する
            $nextResultArray = teratailAPI::callAPI($requestParam,$url,$i);
            if($nextResultArray['meta']['message'] != 'success'){ //metaの内容を確認してエラーがあったら終了
                 return $nextResultArray['meta']['message'];
             }
            $articles = array_merge($articles, utils::searchWord($nextResultArray[$category], $searchArray));
        }
        return $articles;
    }
}
