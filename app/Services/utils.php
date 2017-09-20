<?php
namespace App\Services;

class utils{
    /**
     * 配列内から検索ワードに該当する質問IDを配列で返却
     * @param array $replies
     * @param String $searchWord
     * @return array
     */
    public function searchWord(Array $replies,Array $searchWords) {
        $articles = [];
        $isPush = false;
        foreach ($replies as $value) {
            foreach ($searchWords as $searchValue) {
                if(mb_stripos(mb_convert_kana($value['body']),mb_convert_kana($searchValue))){
                    $isPush=true;
                } else {
                    $isPush=false;
                }
            }
            if($isPush){
                array_push($articles, $value);
            }
        }
        return $articles;
    }
}

