<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>


<div class="npt_story_div">
    <ul class="npt_story_list">

    <?php
    for ($i=0; $i<$list_count; $i++) {
        

        $wr_href = get_pretty_url($list[$i]['bo_table'], $list[$i]['wr_id']);
    ?>
        <li class="npt_card">
            <div class="npt_card_body">

                <h3 class="headline">
                    <a href="<?php echo $wr_href ?>"><?php echo $list[$i]['ca_name'] ?></a>
                </h2>
                <h2 class="headline">
                    <a href="<?php echo $wr_href ?>"><?php echo $list[$i]['subject'] ?>
                    </a>
                </h2>
                <?php if ($is_checkbox) { ?>
                <div class="meta">
                    <div class="adm_input">
                        <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>" class="">
                    </div>
                </div>
                <?php } ?>
            </div>
        </li>

    <?php }  ?>
    <?php if ($list_count == 0) { //게시물이 없을 때  ?>
    <li class="empty_li">게시물이 없습니다.</li>
    <?php }  ?>

    </ul>
</div>
