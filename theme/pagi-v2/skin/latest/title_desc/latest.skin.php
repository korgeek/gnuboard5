<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>


<div class="tt_story_div">
    <ul class="tt_story_list">

    <?php
    for ($i=0; $i<$list_count; $i++) {
        

        $wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);
        
    ?>
        <li class="tt_card" <?php echo ($i+1 == $list_count) ? 'style="border-bottom: 0px;"' : '' ?> >
            <div class="tt_card_body">

                <h2 class="headline" <?php echo (empty($thumb['src'])) ? "style='width:100%;'" : "" ?> >
                    <a href="<?php echo $wr_href; ?>"><?php echo $list[$i]['subject'] ?>
                    </a>
                </h2>
                <p class="description" <?php echo (empty($thumb['src'])) ? "style='width:100%;'" : "" ?> >
                    <a href="<?php echo $wr_href; ?>" >
                    <?php
                    $wr_description = strip_tags($list[$i]['wr_content']); 
                    echo mb_substr($wr_description, 0, 200, 'utf-8');
                    ?>
                    </a>
                </p>
                <div class="meta">
                    <?php
                    if ($is_category && $list[$i]['ca_name']) {
                    ?>
                    <p class="meta_cate_link">
                        <a href="<?php echo $list[$i]['ca_name_href'] ?>"><?php echo $list[$i]['ca_name'] ?></a>
                    </p>
                    <?php } ?>
                    <p class="date"><?php echo $list[$i]['datetime'] ?></p>
                    <?php if ($is_checkbox) { ?>
                    <div class="adm_input">
                        <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>" class="">
                    </div>
                    <?php } ?>
                </div>
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
