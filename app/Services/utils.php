<?php
namespace App\Services;

class utils{
    /**
     * 配列内から検索ワードに該当する質問IDを配列で返却(AND条件)
     * 全角・半角、大文字・小文字の違いは無視する。
     * @param Array $articles 検索対象の記事
     * @param Array $searchWords 検索文言
     * @return Array
     */
    public function searchWord(Array $articles,Array $searchWords) {
        $filter = function($searchObject) use ($searchWords){
            foreach ($searchWords as $searchWord) {
                if(mb_stripos(mb_convert_kana($searchObject['body']),mb_convert_kana($searchWord))===false){
                    return false;
                }
            }
            return true;
        };
        return array_filter($articles, $filter);
    }
}