<?php
// 引入xs类文件
include __DIR__ . '/php/lib/XS.php';
$db = include __DIR__ . '/db.php';

// 申明一个xs对象
$xs = new XS('article');

// echo '<pre>';
// var_dump($xs);die;
// 给索引添加文档数据
// 给索引有一个索引对象
$index = $xs->index;

// 获取最后一次更新的id号
$sql = "select uid from article_xs_update";
$uidarr = $db->query($sql)->fetchAll();
// var_dump($uidarr);
// die;

// 执行清空操作
// $index->clean();

// 把mysql的数据写到xunsearch的文档中
foreach($uidarr as $id) {
    $id = $id['uid'];
    // 读取数据表中的数据，添加到文档中，然后把文档添加到xunsearch搜引种
    $sql = "select id,title,desn from article where id=$id";
    $data = $db->query($sql)->fetch();
    // var_dump($data);die;

    // $data = array(
    //     'id' => $id, // 此字段为主键，是进行文档替换的唯一标识
    //     'title' => $data['title'],
    //     'desn' => $data['desn']
    // );
    // die;
    // 创建文档对象
    $doc = new XSDocument;
    $doc->setFields($data);

    // 提交到索引中
    // $xs->index->add($doc);

    // 删除数据表更新的xunsearch的数据的id
    $sql = "delete from article_xs_update where uid=$id";
    $db->exec($sql);
}

// 刷新索引
$index->flushIndex();

echo 'ok';