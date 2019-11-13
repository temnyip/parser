<?php

header ("Content-Type: text/html; charset=utf-8");

require_once "db.php";
$img_url = $_POST['img'];
$title = $_POST['name'];
$text = $_POST['text'];
$end_date = $_POST['date'];

$db = new dataBase("localhost", "root", "", "first");



require_once 'phpQuery/phpQuery/phpQuery.php';


function print_arr($arr) {
    echo '<pre>' . print_r($arr, true) . '</pre>';
}

function get_content($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}
function parser($url, $start, $end) {
    if($start < $end) {
        $file = get_content($url);
        $doc = phpQuery::newDocument($file);
        $stores = [];

        foreach ($doc->find('.page .media') as $article) {
            $store = [];

            $article = pq($article);
            $img = $article->find('.media-object img')->attr('src');
            $name = $article->find('.pod_brand')->html();
            $description = $article->find('.pod_description')->html();
            $date = $article->find('.pod_expiry')->html();
            $store['img'] = $img;
            $store['name'] = addslashes($name);
            $store['description'] = addslashes($description);
            $partsDate = explode('Exp: ', $date);
            $date = \DateTime::createFromFormat('m/d/y', $partsDate[1]);
            $store['date'] = $date->format('Y-m-d');
            $stores[] = $store;
        }
        return $stores;
    }
}
$url = 'https://www.coupons.com/store-loyalty-card-coupons/acme-coupons/';
$start = 0;
$end = 3;
$stores = parser($url, $start, $end);

    foreach ($stores as $store) {
        $db->query("INSERT INTO `cupons`(`shop_id`, `img_url`, `title`, `text`, `end_date`) VALUES ('1', '{$store['img']}', '{$store['name']}', '{$store['description']}', '{$store['date']}');");
}
?>
<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="script.js">

    </script>
</head>
<body>

</body>
</html>