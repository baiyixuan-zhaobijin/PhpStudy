<?php
require 'vendor/autoload.php';
use QL\QueryList;

ignore_user_abort();
set_time_limit(0);
for ($n = 1 ;$n <= 1;$n++) {
    $url = "https://jixi.58.com/ershouche/pn{$n}/?PGTID=0d100000-01c7-92a6-616f-3afaed1bae9c&ClickID=57";
    $html = file_get_contents($url);
    $ql = QueryList::html($html);
    $list = $ql->find('.info')->htmls();
    $result = [];
    $p = 0;
    foreach ($list as $item) {
        $query = QueryList::html($item);
        $result[$p]['title'] = trim($query->find('h2')->text());
        $content = trim($query->find('.info_params')->text());
        $contentList = explode('·', $content);
        $result[$p]['buyDate']  = trim(str_replace('上牌', '', $contentList[0]));
        if (count($contentList)>1) {
            $result[$p]['distance'] = trim(str_replace('万公里', '', $contentList[1]));
        }
        $result[$p]['price'] =  trim($query->find('.info--price')->text());
        //$price = trim($query->find('.info--price')->text());
        //$result[$p]['price']  = trim(str_replace('万','',$price));
        $p++;
    }
    print_r('<pre>');
    print_r($result);
}
