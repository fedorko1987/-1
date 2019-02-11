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
    $result =  $mysql_connect->query("INSERT INTO url (url, new_url) VALUES ('$url', '$site$rand')");
    if (isset($_POST)){
        mysqli_close($result);
    }



    ?>



</body>
</html>
