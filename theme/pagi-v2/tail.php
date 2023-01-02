<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/tail.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
    return;
}
?>

    </div>
    <div id="aside">

        <?php echo outlogin('theme/pagi'); ?>

        <div class="ad_300"><?php 
                echo latest_ads('theme/ads_301x', '_ads', 100, 100);
            ?></div>
        
        <div id="pagi-hit-news" style="margin-top: 16px;margin-bottom: 16px;">
            <div class="title_area">
                <div class="title_text">
                     많이 본 뉴스
                </div>
            </div>
            <div style="padding-left: 6px; padding-right: 6px;">
            <?php
            if(_INDEX_){
                echo latest_hitnews('theme/hitnews', 10, 100);         // 조회수
            }else{
                echo latest_hitnews('theme/hitnews', 5, 100);         // 조회수
            }
            ?>
            </div>
        </div>

        <?php if(!_INDEX_){ ?>
        <div id="pagi-hot-news" style="margin-top: 16px;margin-bottom: 16px;">
            <div class="title_area">
                <div class="title_text">
                     주요뉴스
                </div>
            </div>
            <div style="padding-left: 6px; padding-right: 6px;">
            <?php
            echo latest_headline('theme/hotnews', 3, 100);         // 조회수
            ?>
            </div>
        </div>
        <?php } ?>

        <div class="ad_300"><?php 
                echo latest_ads('theme/ads_300x', '_ads', 100, 100);
            ?></div>
        

        <div class="ad_300"><?php 
                echo latest_ads('theme/ads_300x', '_ads', 100, 100);
            ?></div>
        <div class="ad_300">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3036178456523392"
         crossorigin="anonymous"></script>
            <!-- pagi-web-right-300-100 -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:300px;height:100px"
                 data-ad-client="ca-pub-3036178456523392"
                 data-ad-slot="8389129513"></ins>
            <script>
                 (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
</div>

</div>
<!-- } 콘텐츠 끝 -->

<hr>

<!-- 하단 시작 { -->
<div id="ft">

    <div id="ft_wr">
        <div id="ft_link">
            <a href="<?php echo get_pretty_url('content', 'company'); ?>">회사소개</a>
            <a href="<?php echo get_pretty_url('content', 'privacy'); ?>">개인정보처리방침</a>
            <a href="<?php echo get_pretty_url('content', 'provision'); ?>">서비스이용약관</a>
            <a href="<?php echo get_device_change_url(); ?>">모바일버전</a>
        </div>

	</div>      
        <!-- <div id="ft_catch"><img src="<?php echo G5_IMG_URL; ?>/ft_logo.png" alt="<?php echo G5_VERSION ?>"></div> -->
        <div id="ft_copy">Copyright &copy; <b> PT. Inko Sinar Media.</b> All rights reserved.</div>
    
    
    <button type="button" id="top_btn">
    	<i class="fi fi-rs-chevron-double-up"></i><span class="sound_only">상단으로</span>
    </button>
    <script>
    $(function() {
        $("#top_btn").on("click", function() {
            $("html, body").animate({scrollTop:0}, '500');
            return false;
        });
    });
    </script>
</div>

<?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
<?php
}

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<!-- } 하단 끝 -->

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});

<?php
//메뉴에 밑줄 만들기
if( $group['gr_1'] && $group['gr_1'] == 99 ){
    echo "$($('.gnb_1da')[".($board['bo_1']-1)."]).css('border-bottom', 'solid 4px var(--color-normal-yellow)');";
}

if( $group['gr_1'] && $group['gr_1'] != 99 ){
    echo "$($('.gnb_1da')[".($group['gr_1']-1)."]).css('border-bottom', 'solid 4px var(--color-normal-yellow)');";
}
?>

<?php
//본문 a 태그는 팝업으로 처리
?>
$("#bo_v_con a[href^='http']").attr('target','_blank');

</script>

<?php
include_once(G5_THEME_PATH."/tail.sub.php");