<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
    return;
}

?>
    </div>
</div>

        <div class="ad_mobile_mid 320x"><?php 
                echo latest_ads('theme/ads_320x', '_ads', 100, 100);
            ?></div>


        <div id="pagi-hit-news">
            <div class="title_area">
                <div class="title_text">
                     많이 본 뉴스
                </div>
            </div>
            <div style="padding-left: 18px; padding-right: 18px;">
            <?php
            echo latest_hitnews('theme/hitnews', 10, 100);         // 조회수
            ?>
            </div>

        </div>

        <div class="ad_mobile_bottom"><?php 
                echo latest_ads('theme/ads_300x', '_ads', 100, 100);
            ?></div>


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

        <div class="ad_300" style="margin-left: auto;margin-right: auto;width: 300px;margin-top: 10px;margin-bottom: 10px;">
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

        <?php 
                echo latest('theme/list_idx', 'notice', 5, 100);
        ?>

        <div class="ad_mobile_bottom"><?php 
                echo latest_ads('theme/ads_300x', '_ads', 100, 100);
            ?></div>

        <?php if(!_INDEX_){ ?>
        <div id="pagi-column" style="margin-top: 16px;margin-bottom: 16px;">
            <div class="title_area">
                <div class="title_text">
                     <a href="/bbs/board.php?bo_table=addnotic">코트라 K-MOVE 센터</a>
                </div>
            </div>
            <?php
            echo latest('theme/nopic_title', 'addnotic', 5, 100);
            ?>
        </div>
        <?php } ?>

        <div class="ad_mobile_bottom"><?php 
                echo latest_ads('theme/ads_300x', '_ads', 100, 100);
            ?></div>

        <div class="ad_300" style="margin-left: auto;margin-right: auto;width: 300px;margin-top: 10px;margin-bottom: 10px;">
            <!-- pagi-web-right-300-100 -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:300px;height:100px"
                 data-ad-client="ca-pub-3036178456523392"
                 data-ad-slot="8389129513"></ins>
            <script>
                 (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>

<div id="ft">
    <div id="ft_copy">
        <div id="ft_company">
            <a href="<?php echo get_pretty_url('content', 'company'); ?>">회사소개</a>
            <a href="<?php echo get_pretty_url('content', 'privacy'); ?>">개인정보처리방침</a>
            <a href="<?php echo get_pretty_url('content', 'provision'); ?>">서비스이용약관</a>
        </div>
    </div>
    <div class="ft_cnt">
        <p  class="ft_info">
            Copyright &copy; PT. Inko Sinar Media. All rights reserved.
        </p>
    </div>
    <button type="button" id="top_btn"><i class="fa fa-arrow-up" aria-hidden="true"></i><span class="sound_only">상단으로</span></button>
    <?php
    if(G5_DEVICE_BUTTON_DISPLAY && G5_IS_MOBILE) { ?>
    <a href="<?php echo get_device_change_url(); ?>" id="device_change">PC 버전으로 보기</a>
    <?php
    }

    if ($config['cf_analytics']) {
        echo $config['cf_analytics'];
    }
    ?>
</div>
<script>
jQuery(function($) {

    $( document ).ready( function() {

        // 폰트 리사이즈 쿠키있으면 실행
        font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
        
        //상단고정
        if( $(".top").length ){
            var jbOffset = $(".top").offset();
            $( window ).scroll( function() {
                if ( $( document ).scrollTop() > jbOffset.top ) {
                    $( '.top' ).addClass( 'fixed' );
                }
                else {
                    $( '.top' ).removeClass( 'fixed' );
                }
            });
        }

        //상단으로
        $("#top_btn").on("click", function() {
            $("html, body").animate({scrollTop:0}, '500');
            return false;
        });

    });
});

$("#bo_v_con a[href^='http']").attr('target','_blank');

</script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="fluid"
     data-ad-layout-key="-ic-n+4-4i+e8"
     data-ad-client="ca-pub-3036178456523392"
     data-ad-slot="4155861725"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<?php
include_once(G5_THEME_PATH."/tail.sub.php");