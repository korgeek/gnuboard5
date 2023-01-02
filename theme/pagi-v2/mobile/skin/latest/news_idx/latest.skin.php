<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css?ver='.G5_CSS_VER.'">', 1);
$thumb_width = 138;
$thumb_height = 90;
$list_count = (is_array($list) && $list) ? count($list) : 0;

?>

<div class="ni">
    <a href="<?php echo get_pretty_url($bo_table); ?>" class="lt_title"><strong><?php echo $bo_subject; ?></strong></a>
    <div class="<?php echo $list_count ? 'latest-sel' : ''; ?>">
        <ul class="item">
            <?php
            for ($i=0; $i<$list_count; $i++) {
            $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, true, true);
            $img = $thumb['src'] ? $thumb['src'] : '';
            $img_content = $img ? '<img src="'.$img.'" alt="'.$thumb['alt'].'" >' : '';
            $wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);

            echo $echo_ul;
            ?>
            <li class="<?php echo ($i == 0) ? "thumb_li" : "text_li"; ?>">
                <?php
                //echo $list[$i]['icon_reply']." ";
                
                if( $i == 0 && $img_content ){
                    echo "<a href=\"".$wr_href."\" class=\"lt_thumb\">".run_replace('thumb_image_tag', $img_content, $thumb)."</a> ";
                }
                
                echo "<a href=\"".$wr_href."\" class=\"lt_tit\">";
                if ($list[$i]['icon_secret']) echo "<i class=\"fa fa-lock\" aria-hidden=\"true\"></i> ";
                if ($list[$i]['is_notice'])
                    echo "<strong>".$list[$i]['subject']."</strong>";
                else
                    echo $list[$i]['subject'];
                echo "</a>";
               
                if( $i == 0 ){
                ?>
                <div class="lt_info">
                    <span class="lt_date">
                        <?php echo date("Y-m-d", strtotime($list[$i]['wr_opendatetime'])) ?>
                    </span>
                </div>
                <?php } ?>
            </li>
            <?php }     //end for ?>
            <?php if ($list_count == 0) { //게시물이 없을 때 ?>
            <li class="empty_li">게시물이 없습니다.</li>
            <?php }     //end if ?>
        </ul>
    </div>

</div>