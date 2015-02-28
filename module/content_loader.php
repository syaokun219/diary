<?php

require_once('module/db_driver.php');

//view class
class Page{
    
    const DB_NAME = 'myblog';
    const TITLE_TABLE       = 'myblog_title';
    const CONTENT_TABLE     = 'myblog_content';

    public function __construct() {

    }


    public function buildContent($intPageNum, $intPageCount) {
        $objDb = new Db('localhost', '3306', 'root', '1111', self::DB_NAME);
        $intOffset = $intPageNum-1;
        $strSql = "select
            t.blog_id, t.blog_title, c.blog_content, t.create_time
            from myblog_title as t , myblog_content as c where t.blog_id = c.blog_id ORDER BY t.blog_id LIMIT $intOffset, $intPageCount";
        $arrData = $objDb->query($strSql);

        $intContentCount = count($arrData);
        $strContent = '';
        for($i=0; $i<$intContentCount; $i++) {
            $strContent .= "<div class='panel panel-default'>";
            $strContent .= "<div class='panel-heading'>";
            $strContent .= "<h4>" . $arrData[$i]['blog_title'] . "</h4>";
            $strContent .= "<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>";
            $strContent .= "<button type='button' class='btn btn-primary btn-xs'>" . $arrData[$i]['create_time'] . "</button>";
            $strContent .= "";
            $strContent .= "</div>";
            $strContent .= "<div class='panel-body'><h5>" . $arrData[$i]['blog_content'] . "</h5></div>";
            $strContent .= '</div>';
        }
        echo $strContent;

        $strSql = "SELECT count(blog_id) as total_count from myblog_title";
        $arrData = $objDb->query($strSql);
        $intTotalCount = (int)$arrData[0]['total_count'];
        return $intTotalCount;
    }

    public function buildPageNumNav($intTotalCount, $intPerPage, $intPageNum) {
        $intTotalPage = (int)(ceil((float)$intTotalCount/(float)$intPerPage));
        $strHtml = "<nav><ul class='pagination'>";
        $strHtml .= "<li><a href='#' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
        for ($i=1; $i<=$intTotalPage; $i++) {
            $strHtml .= "<li";
            if ($i === $intPageNum) {
                $strHtml .= " class='active'";
            }
            $strHtml .= "><a href='index.php?pn=$i&rn=$intPerPage'>$i</a>";
        }
        $strHtml .= "<li><a href='#' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";

        $strHtml .= "</ul></nav>";
        echo $strHtml;
    }
}


?>
