<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css?ver='.G5_CSS_VER.G5_THEME_URL.'">', 0);
$thumb_width = 200;
$thumb_height = 150;
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>


<div class="latest_headline">
    <?php
    for ($i=0; $i<$list_count; $i++) {
        
        $img_link_html = '';
        $wr_href = get_pretty_url($list[$i]['bo_table'], $list[$i]['wr_id']);

        $thumb = get_list_thumbnail($list[$i]['bo_table'], $list[$i]['wr_id'], $thumb_width*($i == 0 ? 2 : 1), $thumb_height*($i == 0 ? 2 : 1), false, true);

        if(isset($thumb['src']) && $thumb['src']) {
            $img = $thumb['src'];
        } else {
            $img = G5_IMG_URL.'/no_img.png';
            $thumb['alt'] = '이미지가 없습니다.';
        }
        $img_content = '<img src="'.$img.'" alt="'.$thumb['alt'].'" >';
        $img_link_html = '<a href="'.$wr_href.'" class="lt_img" >'.run_replace('thumb_image_tag', $img_content, $thumb).'</a>';

        if( $i === 0 ) {

        ?>
        <div class="big_card">
          <div class="big_card_image">
             <?php echo $img_link_html ;?>
          </div>
        </div>
        <div class="big_card_body">
            <h2 class="big_card_title">
                <a href="<?php echo $wr_href; ?>" target="_self"><?php echo $list[$i]['subject']; ?></a>
            </h2>
             <p class="big_card_description"><a href="<?php echo $wr_href; ?>" target="_self">
             <?php
                $wr_description = strip_tags($list[$i]['wr_content']); 
                echo mb_substr($wr_description, 0, 200, 'utf-8');
             ?>
             </a></p>
        </div>
        <?php
        }
    }
    ?>
</div>



