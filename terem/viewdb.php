<?php
/**
 * viewdb.php
 *
 * view data of MySQL table
 *
 * @author     byNickSan
 * @copyright  2021 Nikolay
 * @license    https://mit-license.org  MIT License
 */
?><html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" href="style.css" />
</head>
<body>
<div class="container">
    <div class="row">
<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$GLOBALS['APPLICATION']->RestartBuffer();

$APPLICATION->SetAdditionalCSS("/terem/style.css");
use Bitrix\Main\Application;
use Bitrix\Main\Diag\Debug;

function paginate($reload, $page, $tpages) {
    $adjacents = 2;
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $out = "";
// previous
    if ($page == 1) {
        $out.= "<span>".$prevlabel."</span>\n";
    } elseif ($page == 2) {
        $out.="<li><a href=\"".$reload."\">".$prevlabel."</a>\n</li>";
    } else {
        $out.="<li><a href=\"".$reload."&amp;page=".($page - 1)."\">".$prevlabel."</a>\n</li>";
    }
    $pmin=($page>$adjacents)?($page - $adjacents):1;
    $pmax=($page<($tpages - $adjacents))?($page + $adjacents):$tpages;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $page) {
            $out.= "<li class=\"active\"><a href=''>".$i."</a></li>\n";
        } elseif ($i == 1) {
            $out.= "<li><a href=\"".$reload."\">".$i."</a>\n</li>";
        } else {
            $out.= "<li><a href=\"".$reload. "&amp;page=".$i."\">".$i. "</a>\n</li>";
        }
    }

    if ($page<($tpages - $adjacents)) {
        $out.= "<a style='font-size:11px' href=\"" . $reload."&amp;page=".$tpages."\">" .$tpages."</a>\n";
    }
// next
    if ($page < $tpages) {
        $out.= "<li><a href=\"".$reload."&amp;page=".($page + 1)."\">".$nextlabel."</a>\n</li>";
    } else {
        $out.= "<span style='font-size:11px'>".$nextlabel."</span>\n";
    }
    $out.= "";
    return $out;
}

$sqldrv = Application::getConnection();

$per_page = 20;         // number of results to show per page

$max = $sqldrv->query("SELECT COUNT(*) FROM csv_terem")->fetch();

$total_results = intval($max["COUNT(*)"]);
$total_pages = ceil($total_results / $per_page);

if (isset($_GET['page'])) {
    $show_page = $_GET['page']; //current page
    if ($show_page > 0 && $show_page <= $total_pages) {
        $start = ($show_page - 1) * $per_page;
        $end = $start + $per_page;
    } else {
        // error - show first set of results
        $start = 0;
        $end = $per_page;
    }
} else {
    $start = 0;
    $end = $per_page;
}
// display pagination
$page = intval($_GET['page']);
$tpages=$total_pages;
if ($page <= 0)
    $page = 1;

if($show_page == NULL) $show_page = 1;
if($page > 1){
    $mmend = intval($show_page)*$per_page;
    $mmstart = $mmend - $per_page + 1;
}else{
    $mmend = intval($show_page)*$per_page;
    $mmstart = 1;
}
echo "($show_page) $mmstart to $mmend";
$offset = $mmstart - 1;
$iq = 'SELECT * FROM csv_terem ORDER BY id ASC LIMIT 20 OFFSET '.$offset;
$result = $sqldrv->query($iq)->fetchAll();

$reload = $_SERVER['PHP_SELF'] . "?";
$paginateme = '<div class="pagination"><ul>';
if ($total_pages > 1) {
    $paginateme .= paginate($reload, $show_page, $total_pages);
}
$paginateme .= "</ul></div>";
echo $paginateme;
// display data in table
echo "<table class='table table-bordered'>";
echo "<thead><tr>";
foreach(array_keys($result[0]) as $k => $v){
    echo '<th>';
    echo $v;
    echo '</th>';
}
echo "</tr></thead>";
// loop through results of database query, displaying them in the table
foreach($result as $k => $v){
    echo '<tr data-row="'.$k.'">';;
    foreach ($v as $key => $val){
        echo '<td data-col="'.$key.'">'. $val . '</td>';
    }
    echo '</tr>';;
}
echo "</table>";
// pagination
echo $paginateme;?>

        </div>
    </div>
</body>
</html>
