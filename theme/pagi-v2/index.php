<?php
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');
?>

<div class="latest_wr">
    <?php
    echo latest_headline('theme/headline', 1, 100);         // 헤드라인
    ?>
</div>

<div class="latest_wr">
    <?php 
    echo latest_news('theme/pic_list_idx', 'business', 4, 100);
    echo latest_news('theme/pic_list_idx', 'economy', 4, 100);
    echo latest_news('theme/pic_list_idx', 'korean_news', 4, 100);
    ?>
</div>

<div class="latest_wr">
    <div class="title_area">
        <div class="title_text">
             <a href="/bbs/board.php?bo_table=photo_news">포토뉴스</a>
        </div>
    </div>
    <?php
    echo latest_news('theme/pic_only', 'photo_news', 8, 100);
    ?>
</div>

<div class="latest_wr" style="display: flex;">
    <div style="width: 335px;margin-right: 15px;display: inline-grid;">
        <div class="title_area">
            <div class="title_text">
                 <a href="/bbs/board.php?bo_table=column">전문가 칼럼</a>
            </div>
        </div>
        <?php
        echo latest_news('theme/pic_title', 'column', 3, 100);
        ?>
    </div>
    <div style="width: 335px;">
        <div class="title_area">
            <div class="title_text">
                 <a href="/bbs/board.php?bo_table=recruit">구인∙구직</a>
            </div>
        </div>
        <?php
        echo latest_news('theme/title_only', 'recruit', 7, 200);
        ?>
    </div>
</div>


<?php
include_once(G5_THEME_PATH.'/tail.php');