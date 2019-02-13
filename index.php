<DOCTYPE html>
    <html>
    <head>

        <title>Сокращатель ссылок</title>

    </head>
    <body>
    <form method="post">

        <input type="url" required placeholder="Введите ссылку..." autocomplete="off" name="url">


        <input type="submit" name="submit" value="Сократить">
    </form>

    <?php

    $rand = date_timestamp_get(date_create());
    $site = "http://example/";
    $url = $_POST['url'];
    $link = htmlspecialchars($_POST['link']);

    function connect_sql() {
    $SQLDatabase = 'url';
    $SQLusername = 'mikle';
    $SQLpassword = 'PassWord123!';
    $SQLhost = 	'localhost';

        $mysql_connect = mysqli_connect($SQLhost, $SQLusername, $SQLpassword);
        if(!$mysql_connect) {
            http_response_code(503);
            die('Ошибка бд');
        } else {
            mysqli_select_db($mysql_connect,$SQLDatabase);
            mysqli_query($mysql_connect,"SET NAMES 'utf8';");
            mysqli_query($mysql_connect,"SET CHARACTER SET 'utf8';");
            mysqli_query($mysql_connect,"SET SESSION collation_connection = 'utf8_general_ci';");
        }
        return $mysql_connect;
    }


    $mysql_connect = connect_sql();
    if ($url) {
        $url = strip_tags ($url);
        $site = strip_tags ($site);
        $result = $mysql_connect->query("INSERT INTO url (url, new_url) VALUES ('$url', '$rand')");
    echo "<a href='$site$rand' target='_blank'>$site$rand</a>";
    }

    $param = str_replace('/', '', $_SERVER['REQUEST_URI']);


    @$select = $mysql_connect->query(("SELECT `url` FROM 'url' WHERE 'new_url' = '".$param."'"));
    if ($select){
        $res=[
            'url'   => $select['url'],
            'key'  => $select['new_url'],
            'link'  =>
                'http://'.$_SERVER['HTTP_HOST'].'/-'.$select['new_url']
        ];
    }




    $key = htmlspecialchars($_GET['key']);
    if (!empty ($_GET['key'])){
        @$select =$mysql_connect->query("SELECT * FROM 'url' WHERE 'new_url' = '" . $key . "'");
        if ($select) {
            $res = ['url' => $select['url'],
                'key' => $select['new_url'],
            ];
            header('Location:' . $res['url']);
    }

    }




    ?>



</body>
</html>
