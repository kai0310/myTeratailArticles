<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Facades\utils;

class UtilsTest extends TestCase
{
    /**
     * 文字検索をテストします。
     * (検索配列が1個の場合。大文字・小文字無視)
     * @return void
     */
    public function testsearchWordSingle()
    {
        $searchWords = ['xml'];
        $searchObject = [];
        $searchObject[]['body'] = 'Php';
        $searchObject[]['body'] = 'xml';
        $searchObject[]['body'] = 'Xml';
        $searchObject[]['body'] = 'XML';
        $searchObject[]['body'] = 'HTML';
        $searchObject[]['body'] = 'Is XML';
        
        $expected = [];
        $expected[]['body'] = 'xml';
        $expected[]['body'] = 'Xml';
        $expected[]['body'] = 'XML';
        $expected[]['body'] = 'Is XML';
        $this->assertEquals($expected,array_values(utils::searchWord($searchObject,$searchWords)));
    }
    /**
     * 文字検索をテストします。
     * (検索配列が1個の場合。全角無視)
     * @return void
     */
    public function testsearchWordZenkaku()
    {
        $searchWords = ['ゼンカク'];
        $searchObject = [];
        $searchObject[]['body'] = 'ゼンカク';
        $searchObject[]['body'] = 'ｾﾞﾝｶｸ';
        
        $expected = [];
        $expected[]['body'] = 'ゼンカク';
        $expected[]['body'] = 'ｾﾞﾝｶｸ';
        $this->assertEquals($expected,array_values(utils::searchWord($searchObject,$searchWords)));
    }
    /**
     * 文字検索をテストします。
     * (検索配列が1個の場合。半角無視)
     * @return void
     */
    public function testsearchWordHankaku()
    {
        $searchWords = ['ﾊﾝｶｸ'];
        $searchObject = [];
        $searchObject[]['body'] = 'ハンカク';
        $searchObject[]['body'] = 'ﾊﾝｶｸ';
        
        $expected = [];
        $expected[]['body'] = 'ハンカク';
        $expected[]['body'] = 'ﾊﾝｶｸ';
        $this->assertEquals($expected,array_values(utils::searchWord($searchObject,$searchWords)));
    }
    /**
     * 文字検索をテストします。
     * (検索配列が複数個の場合、AND条件になっていることを確認)
     * @return void
     */
    public function testsearchWordMulti()
    {
        $searchWords = ['xml','PHP'];
        $searchObject = [];
        $searchObject[]['body'] = 'Php';
        $searchObject[]['body'] = 'xml';
        $searchObject[]['body'] = 'Xml';
        $searchObject[]['body'] = 'XML contains php';
        $searchObject[]['body'] = 'HTML';
        $searchObject[]['body'] = 'Is XML';
        
        $expected = [];
        $expected[]['body'] = 'XML contains php';
        $this->assertEquals($expected,array_values(utils::searchWord($searchObject,$searchWords)));
    }
}
