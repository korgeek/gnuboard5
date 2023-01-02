<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);

$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="latest_hitnews">
    <ul>
    <?php
    for ($i=0; $i<$list_count; $i++) {
        
        $wr_href = get_pretty_url($list[$i]['bo_table'], $list[$i]['wr_id']);
    ?>
        <li <?php echo ($i  == ($list_count-1)) ? "style='border-bottom: 0px;'" : "" ;?> >
            <a href="<?php echo $wr_href; ?>" target="_self">
                <span class="square_number"><?php echo ($i+1); ?></span><?php echo $list[$i]['subject']; ?>
            </a>
        </li>
    <?php
    }
    ?>
    </ul>
</div>