<?php
    define("DB_NAME", 'myblog');
    define("TITLE_TABLE", 'myblog_title');
    define("CONTENT_TABLE", 'myblog_cotent');

    $g_errmsg   = "";
    $g_errno    = 0;

    require_once("../module/db_driver.php");
    
    $title      = $_POST['title'];
    $content    = $_POST['content'];
    //$uid = 

    $objDb = new Db("localhost", 3306, 'root', '1111', DB_NAME);
    if (!$objDb->isConnected()) {
        $g_errmsg   = 'connect db fail!';
        $g_errno    = -1;
        echo json_encode(array($g_errno, $g_errmsg));
        return false;
    }
    
    $arrTitleData = array(
        'title'     => $title,
    );
    $title_id = $objDb->insert($arrTitleData, TITLE_TABLE);

    if (0 >= $title_id) {
        $g_errno = -2;
        $g_errmsg = 'add title failed!';
        echo json_encode(array($g_errno, $g_errmsg));
        return false;
    }

    $arrContentData = array(
        'content' => $content,
    );

    $content_id = $objDb->insert($arrContentData, CONTENT_TABLE);
    if (0 >= $content_id) {
        return false;
    }
    echo json_encode(array($g_errno, $g_errmsg));
    return true;

?>
