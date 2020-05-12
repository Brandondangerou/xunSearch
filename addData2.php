<?php
// 引入xs类文件
include __DIR__ . '/php/lib/XS.php';
$db = include __DIR__ . '/db.php';

// 申明一个xs对象
$xs = new XS('article');

// 给索引添加文档数据
// 给索引有一个索引对象
$index = $xs->index;

// 获取最后一次更新的id号
$sql = "select aid from article_xs_insert_id";
$lastid = $db->query($sql)->fetch()['aid'];



// 执行清空操作
// $index->clean();

// 读取数据表中的数据，添加到文档中，然后把文档添加到xunsearch搜引种
$sql = "select id,title,desn from article where id > $lastid order by id asc";
$data = $db->query($sql)->fetchAll();

// 把mysql的数据写到xunsearch的文档中
foreach($data as $item) {
    // 创建xunsearch文档
    $doc = new XSDocument($item);

    // 提交到索引中
    $xs->index->add($doc);

    // 更新最后写入xunsearch的数据的id
    $lastid = $item['id'];
}

// 刷新索引
$index->flushIndex();

// 更新最后更新的id数据
$sql = "update article_xs_insert_id set aid=$lastid where id=1";
$db->exec($sql);

echo 'ok';