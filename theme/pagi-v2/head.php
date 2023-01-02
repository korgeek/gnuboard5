<?php
if (!defined('_INDEX_')) define('_INDEX_', false);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    define('G5_IS_COMMUNITY_PAGE', true);
    include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
    return;
}
include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/latest.ext.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
?>

<!-- 상단 시작 { -->
<div id="hd">
    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>
    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
    }
    ?>
    <div id="tnb">
    	<div class="inner">
            
    		<ul id="hd_define">
    			<li class="active"><a href="<?php echo G5_URL ?>/">자카르타경제신문</a></li>
    			<li><a href="<?php echo G5_URL ?>/"><?php echo date('Y월 m월 d일', time());?></a></li>
    		</ul>
            <ul id="hd_top" style="float: left;margin-left: 40px;margin-top: 5px;">
                <li>
                    <img src="<?php echo G5_THEME_URL ?>/img/pagi/pagi_top.jpg" width="600" height="40">
                </li>
            </ul>
			<ul id="hd_qnb">
	            
                <?php if ($is_member) {  ?>

                <li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php">정보수정</a></li>
                <li><a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a></li>
                <?php if ($is_admin) {  ?>
                <li><a href="<?php echo G5_BBS_URL ?>/new.php">새글</a></li>
                <li class="tnb_admin"><a href="<?php echo get_pretty_url('_ads'); ?>">광고관리</a></li>
                <li class="tnb_admin"><a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>">관리자</a></li>
                <?php }  ?>
                <?php } else {  ?>
                <li><a href="<?php echo G5_BBS_URL ?>/register.php">회원가입</a></li>
                <li><a href="<?php echo G5_BBS_URL ?>/login.php">로그인</a></li>
                <?php }  ?>
	        </ul>
		</div>
    </div>
    <div id="hd_wrapper">

        <div id="logo">
            <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_THEME_URL ?>/img/pagi/pagi_logo.png" alt="<?php echo $config['cf_title']; ?>"></a>
        </div>

        <div class="ad_728" style="margin-top: 20px;margin-left: 15px;">
            <?php 
                echo latest_ads('theme/ads_728x', '_ads', 100, 100);
            ?>
        </div>
    
        <div class="hd_sch_wr">
            <fieldset id="hd_sch">
                <legend>사이트 내 전체검색</legend>
                <form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);">
                <input type="hidden" name="sfl" value="wr_subject||wr_content">
                <input type="hidden" name="sop" value="and">
                <label for="sch_stx" class="sound_only">검색어 필수</label>
                <input type="text" name="stx" id="sch_stx" maxlength="20" placeholder="검색어를 입력해주세요">
                <button type="submit" id="sch_submit" value="검색"><i class="fi fi-rs-search"></i><span class="sound_only">검색</span></button>
                </form>

                <script>
                function fsearchbox_submit(f)
                {
                    if (f.stx.value.length < 2) {
                        alert("검색어는 두글자 이상 입력하십시오.");
                        f.stx.select();
                        f.stx.focus();
                        return false;
                    }

                    // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
                    var cnt = 0;
                    for (var i=0; i<f.stx.value.length; i++) {
                        if (f.stx.value.charAt(i) == ' ')
                            cnt++;
                    }

                    if (cnt > 1) {
                        alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                        f.stx.select();
                        f.stx.focus();
                        return false;
                    }

                    return true;
                }
                </script>
            </fieldset>

        </div>
    </div>
    
    <nav id="gnb">
        <h2>메인메뉴</h2>
        <div class="gnb_wrap">
            <ul id="gnb_1dul">
                <li class="gnb_1dli gnb_mnal"><button type="button" class="gnb_menu_btn" title="전체메뉴"><i class="fi fi-rs-burger-menu"></i><span class="sound_only">전체메뉴열기</span></button></li>
                <?php
				$menu_datas = get_menu_db(0, true);
				$gnb_zindex = 999; // gnb_1dli z-index 값 설정용
                $i = 0;
                foreach( $menu_datas as $row ){
                    if( empty($row) ) continue;
                    $add_class = (isset($row['sub']) && $row['sub']) ? 'gnb_al_li_plus' : '';
                ?>
                <li class="gnb_1dli <?php echo $add_class; ?>" style="z-index:<?php echo $gnb_zindex--; ?>">
                    <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da"><?php echo $row['me_name'] ?></a>
                    <?php
                    $k = 0;
                    foreach( (array) $row['sub'] as $row2 ){

                        if( empty($row2) ) continue; 

                        if($k == 0)
                            echo '<span class="bg">하위분류</span><div class="gnb_2dul"><ul class="gnb_2dul_box">'.PHP_EOL;
                    ?>
                        <li class="gnb_2dli"><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" class="gnb_2da"><?php echo $row2['me_name'] ?></a></li>
                    <?php
                    $k++;
                    }   //end foreach $row2

                    if($k > 0)
                        echo '</ul></div>'.PHP_EOL;
                    ?>
                </li>
                <?php
                $i++;
                }   //end foreach $row

                if ($i == 0) {  ?>
                    <li class="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></li>
                <?php } ?>
            </ul>
            <div id="gnb_all">
                <h2>전체메뉴</h2>
                <ul class="gnb_al_ul">
                    <?php
                    
                    $i = 0;
                    foreach( $menu_datas as $row ){
                    ?>
                    <li class="gnb_al_li">
                        <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_al_a"><?php echo $row['me_name'] ?></a>
                        <?php
                        $k = 0;
                        foreach( (array) $row['sub'] as $row2 ){
                            if($k == 0)
                                echo '<ul>'.PHP_EOL;
                        ?>
                            <li><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>"><?php echo $row2['me_name'] ?></a></li>
                        <?php
                        $k++;
                        }   //end foreach $row2

                        if($k > 0)
                            echo '</ul>'.PHP_EOL;
                        ?>
                    </li>
                    <?php
                    $i++;
                    }   //end foreach $row

                    if ($i == 0) {  ?>
                        <li class="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <br><a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></li>
                    <?php } ?>
                </ul>
                <button type="button" class="gnb_close_btn"><i class="fi fi-rs-cross"></i></button>
            </div>
            <div id="gnb_all_bg"></div>
        </div>
    </nav>
    <script>
    
    $(function(){
        $(".gnb_menu_btn").click(function(){
            $("#gnb_all, #gnb_all_bg").show();
        });
        $(".gnb_close_btn, #gnb_all_bg").click(function(){
            $("#gnb_all, #gnb_all_bg").hide();
        });
    });

    </script>
</div>
<!-- } 상단 끝 -->


<hr>

<!-- 콘텐츠 시작 { -->
<div id="wrapper">
<div id="container_wr">
   
    <div id="bside">
        <div id="bside_group_menu" style="margin-top:10px;">
    <?php
    //  최신글
    $bside_bo_table = clean_xss_tags($_GET['bo_table']);
    $bside_gr_id = clean_xss_tags($_GET['gr_id']);

    $sql = " select bo_table, gr_id, bo_subject from `{$g5['board_table']}` ";

    if(!empty($bside_bo_table)){
        $sql .= " where gr_id = (select gr_id from `{$g5['board_table']}` where bo_table = '$bside_bo_table' ) ";
        $sql .= " order by bo_order ";
    }else if(!empty($bside_gr_id)){
        $sql .= " where gr_id = '{$bside_gr_id}' ";
        $sql .= " order by bo_order ";
    }else{
        $sql = "";        
    }

    if(!empty($sql)){
        $result = sql_query($sql);
        for ($i=0; $row=sql_fetch_array($result); $i++) {

            echo "<div class='".( ($bside_bo_table == $row['bo_table']) ? "grp_btn_select" : "grp_btn" )."'><a href='".get_pretty_url($row['bo_table'])."'>".$row['bo_subject']."</a></div>";

            if($bside_bo_table == $row['bo_table']){
                echo "<div id='bside_bo_cate'></div>";
            }
        }        
    }
    ?>
        </div>
        <div class="ad_180"><?php 
                echo latest_ads('theme/ads_180x', '_ads', 100, 100);
            ?></div>
        <div class="ad_180"><?php 
                echo latest_ads('theme/ads_180x', '_ads', 100, 100);
            ?></div>
        <div class="ad_180"><?php 
                echo latest_ads('theme/ads_180x', '_ads', 100, 100);
            ?></div>
        <div class="ad_180"><?php 
                echo latest_ads('theme/ads_180x', '_ads', 100, 100);
            ?></div>
        <?php 
        if( isset($bo_table) ){

            
            if( $bo_table != "notice" ) echo "<div class='text_box'>".latest('theme/title_left', 'notice', 4, 100)."</div>";
            if( $bo_table != "addnotic" ) echo "<div class='text_box'>".latest('theme/title_left', 'addnotic', 4, 100)."</div>";
            
            if( $bo_table != "indonesia_life" ) echo "<div class='text_box'>".latest('theme/title_left', 'indonesia_life', 4, 100)."</div>";
            if( $bo_table != "covid19" ) echo "<div class='text_box'>".latest('theme/title_left', 'covid19', 4, 100)."</div>";

        }else if( isset($gr_id) ){

            if($gr_id != "community") echo "<div class='text_box'>".latest('theme/title_left', 'notice', 4, 100)."</div>";
            if($gr_id != "info") echo "<div class='text_box'>".latest('theme/title_left', 'addnotic', 4, 100)."</div>";
            if($gr_id != "info") echo "<div class='text_box'>".latest('theme/title_left', 'indonesia_document', 4, 100)."</div>";
            if($gr_id != "info") echo "<div class='text_box'>".latest('theme/title_left', 'covid19', 4, 100)."</div>";

        }else{
            echo "<div class='text_box'>".latest('theme/title_left', 'notice', 4, 100)."</div>";
            echo "<div class='text_box'>".latest('theme/title_left', 'addnotic', 4, 100)."</div>";
            echo "<div class='text_box'>".latest('theme/title_left', 'indonesia_document', 4, 100)."</div>";
            echo "<div class='text_box'>".latest('theme/title_left', 'covid19', 4, 100)."</div>";
        }
        ?>

        <div class="ad_180"><?php 
                echo latest_ads('theme/ads_180x', '_ads', 100, 100);
            ?></div>
        <div class="ad_180"><?php 
                echo latest_ads('theme/ads_180x', '_ads', 100, 100);
            ?></div>
        <div class="ad_180"><?php 
                echo latest_ads('theme/ads_180x', '_ads', 100, 100);
            ?></div>
        <div class="ad_180"><?php 
                echo latest_ads('theme/ads_180x', '_ads', 100, 100);
            ?></div>
        <div class="ad_180">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3036178456523392"
                 crossorigin="anonymous"></script>
            <!-- pagi-web-left-180-200 -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:180px;height:200px"
                 data-ad-client="ca-pub-3036178456523392"
                 data-ad-slot="5816357946"></ins>
            <script>
                 (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>

    </div>
    <div id="container">