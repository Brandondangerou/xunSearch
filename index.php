<?php

if(!empty($_GET['kw'])) {
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
    // $kw = $_GET['kw'];
    $find = $search->search($_GET['kw']);
    // var_dump($find);die;
    // print_r(get_class_methods($find[0]));

    // 数据源
    $ret = [];
    foreach($find as $item) {
        $title = $search->highlight($item->title);
        // 文章查找到的id号
        $id = $item->id;
        
        // 根据id到数据表中查找对应的详情信息
        $sql = "SELECT * FROM article WHERE id = $id";
        $tmp = $db->query($sql)->fetch();
        $tmp['title'] = $title;
        $ret[] = $tmp;
    }

    // echo '<pre>';
    // var_dump($ret);die;
    // var_dump($find);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XunSearch</title>
    <style>
        body {
            font-size: 14px;
        }
        em {
            color: red;
            font-style: normal;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Xunsearch</h2>
    <form action="http://xunsearch.arceus.online/" method="get">
        <input type="text" name="kw" value="<?php echo $_GET['kw'];?>" id="search" onblur="lookup(this.value);" onblur="fill();"><input type="submit" value="搜索一下">
        <div class="associationBox" id="association" style="display: none;">
            <div class="association" id="associationsList">
            </div>
        </div>
    </div>
    </form>
    <div>
        <ul>
            <?php if(isset($ret)):?>
            <?php foreach($ret as $item):?>
            <li>
                <img src="<?php echo $item['pic']?>" style="width: 100px;" alt="">
                <span><?php echo $item['title']?></span><hr>
                <span><?php echo $item['desn']?></span>
            </li><br><br>
            <?php endforeach;?>
            <?php endif; ?>
        </ul>
    </div>
</body>
<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.js"></script>
<script type="text/javascript">
    function lookup(search) {
        // console.log(1111);
        if(search.trim().length == 0) {
            // console.log(22222);
            $('#association').hide();
        } else {
            $.post("search.php", {queryString: ""+search+""}, function(data){
                if(data.length >0) {
                    $('#association').show();
                    $('#associationsList').html(data);
                }
            });
        }
    }
    function fill(thisValue) {
        $('#search').val(thisValue);
        setTimeout("$('#association').hide();", 200);
    }
</script>
</html>



<!-- <form>
    <input type="text" size="30" value="" id="search" onkeyup="lookup(this.value);" onblur="fill();" />
    
</form> -->