<?php
if($_POST) {
    // var_dump($_POST);die;
    // 引入xs类文件
    include __DIR__ . '/php/lib/XS.php';
    $db = include __DIR__ . '/db.php';

    // 申明一个xs对象
    $xs = new XS('article');
    // 搜索对象
    $search = $xs->search;

    // 搜索
    // setLimit用来做搜索分页，第二个参数意义是指的跳过搜索的前几个结果的个数
    // $find = $search->setLimit(2, 1)->search($_GET['kw']);
    // 正常搜索
    $search = $_POST['queryString'];

    $query = $db->query("SELECT title FROM article WHERE title LIKE '%$search%' LIMIT 10") ?? null;
    if($query) {
        while ($result = $query ->fetchObject()) {
            // var_dump($result->title);die;
            $title = $result->title;
            $position = mb_strpos($title, $search);
            // var_dump($position);die;
            $newTitle = mb_substr($title, $position-1, $position+1);
            // var_dump($newTitle);die;
            echo '<li onClick="fill(\''.$newTitle.'\');">'.$newTitle.'</li>';
        }
    } else {
        echo '暂无数据.';
    }
}