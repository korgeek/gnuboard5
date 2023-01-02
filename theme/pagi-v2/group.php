<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/group.php');
    return;
}

if(!$is_admin && $group['gr_device'] == 'mobile')
    alert($group['gr_subject'].' 그룹은 모바일에서만 접근할 수 있습니다.');

$g5['title'] = $group['gr_subject'];
include_once(G5_THEME_PATH.'/head.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
?>



<!-- 메인화면 최신글 시작 -->
<?php

$idx_wr = 0;

//  최신글
$sql = " select bo_table, bo_subject
            from {$g5['board_table']}
            where gr_id = '{$gr_id}'
              and bo_list_level <= '{$member['mb_level']}'
              and bo_device <> 'mobile' ";
if(!$is_admin)
    $sql .= " and bo_use_cert = '' ";
$sql .= " order by bo_order ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $lt_style = "";
    if ($i%3 !== 0) $lt_style = "margin-left:2%";
    else $lt_style = "";
?>

<?php if($row['bo_table'] == "notice" || $row['bo_table'] == "photo_news" || $row['bo_table'] == "photo_gallery" || $row['bo_table'] == "contribution" || $row['bo_table'] == "column"){ ?>
<div class="latest_wr" >
<?php }else{?>
<div class="latest_wr_50 idx_wr_<?php echo $idx_wr;?>" style="<?php echo ($idx_wr%2 == 0) ? "padding-right: 10px;" : "padding-left: 10px;" ;?>" >
<?php 
        $idx_wr++;
    }?>

    <div class="title_area_group" style="margin-top:12px;margin-bottom:12px">
        <div class="title_text">
             <a href="<?php echo get_pretty_url($row['bo_table']); ?>"><?php echo $row['bo_subject'] ?></a>
        </div>
    </div>
    <?php

    if($row['bo_table'] == "photo_news" || $row['bo_table'] == "photo_gallery"){
        echo latest('theme/pic_only', $row['bo_table'], 12, 200);
    }else if($row['bo_table'] == "notice"){
        echo latest('theme/title_date', $row['bo_table'], 7, 200);
    }else{

        if($gr_id == 'club'){
            echo latest('theme/hotnews', $row['bo_table'], 5, 200);    
        }else if($gr_id == 'opinion'){
            echo latest('theme/title_date', $row['bo_table'], 15, 200);
        }else{
            echo latest('theme/title_only', $row['bo_table'], 7, 200);
        }


    }

    ?>
</div>

<?php
}
$idx_wr = 0;
?>
<!-- 메인화면 최신글 끝 -->

    <div class="ad_680">
        <ins class="adsbygoogle"
             style="display:inline-block;width:680px;height:250px"
             data-ad-client="ca-pub-3036178456523392"
             data-ad-slot="9039295387"></ins>
        <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>

<?php
include_once(G5_THEME_PATH.'/tail.php');