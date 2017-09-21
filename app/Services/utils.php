<?php
namespace App\Services;

class utils{
    /**
     * 配列内から検索ワードに該当する質問IDを配列で返却
     * @param array $replies
     * @param Array $searchWords
     * @return array
     */
    public function searchWord(Array $replies,Array $searchWords) {
        $filter = function($replies) use ($searchWords){
            return $this->wordMatching($replies, $searchWords);
        };
        return array_filter($replies, $filter);
    }
    /**
     * 配列内から全角・半角・大文字・小文字を無視して一致する内容を返却する。
     * @param Array $searchObject 検索対象
     * @param Array $searchWords 探したい文字配列
     * @return Array
     */
    private function wordMatching(Array $searchObject,Array $searchWords){
        $stringMatching = function($searchValue) use ($searchObject){
            if(mb_stripos(mb_convert_kana($searchObject['body']),mb_convert_kana($searchValue))!==false){
                return true;
            }            
            return false;
        };
        return array_filter($searchWords, $stringMatching);
    }
}