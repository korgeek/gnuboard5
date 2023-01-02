<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>


<div class="to_story_div">
    <ul class="to_story_list">

    <?php
    for ($i=0; $i<$list_count; $i++) {
        

        $wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);
        
    ?>
        <li class="to_card" <?php echo ($i+1 == $list_count) ? 'style="border-bottom: 0px;"' : '' ?> >
            <div class="to_card_body">

                <h2 class="headline" <?php echo (empty($thumb['src'])) ? "style='width:100%;'" : "" ?> >
                    <a href="<?php echo $wr_href; ?>"><?php echo $list[$i]['subject'] ?>
                    </a>
                </h2>
            </div>
        </li>

    <?php }  ?>
    <?php if ($list_count == 0) { //게시물이 없을 때  ?>
    <li class="empty_li">게시물이 없습니다.</li>
    <?php }  ?>

    <?php
    for ($i=0; $i<count($list); $i++) {
        if ($i%2==0) $lt_class = "even";
        else $lt_class = "";
    ?>


    <?php } ?>
    </ul>
</div>
