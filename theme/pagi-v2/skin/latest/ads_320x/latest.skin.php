<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$GLOBALS['ads_array'] = is_array($GLOBALS['ads_array']) ? $GLOBALS['ads_array'] : array(); 
$list_count = (is_array($list) && $list) ? count($list) : 0;

if( $list_count > 0){
$wr_id = 0;
shuffle($list);
?>

<div class="pagi_ads_area">
    <?php
    for ($i=0; $i<$list_count; $i++) {
        
        $wr_id = $list[$i]['wr_id'];
        $wr_id_key = 'ads_'.$wr_id;

        if(!array_key_exists($wr_id_key, $GLOBALS['ads_array'])){
        $file_count = (is_array($list[$i]['files']) && $list[$i]['files']) ? count($list[$i]['files']) : 0;
            for ($idx=0; $idx<$file_count; $idx++) {

                $bf_file = "/data/file/_ads/".$list[$i]['files'][$idx]['bf_file'];
                $bf_content = $list[$i]['files'][$idx]['bf_content'];
                
                $link_href = $list[$i]['link_href'][1];
                if($is_mobile && $list[$i]['link'][2]){
                    $link_href = $list[$i]['link_href'][2];
                }
                $link_href = str_replace('bo_table=', 'bo_table=_ads',$link_href);

                if( !empty($bf_file) && !empty($bf_file) && substr( $bf_content, 0, 4 ) === "320x"){
                    echo "<a href='$link_href' target='_target'><img src='$bf_file' class='pagi_ads_img_320x' id='ads_$wr_id'></a>";
                    $idx = $file_count;
                    $i = $list_count;
                    $GLOBALS['ads_array'][$wr_id_key] = $bf_content;
                }
            }
        }
    }    
    ?>
    <!--
    <?php 
    var_dump($GLOBALS['ads_array']); 
    if($wr_id > 0){
        sql_query(" update {$g5['write_prefix']}{$bo_table} set wr_hit = wr_hit + 1 where wr_id = '{$wr_id}' ");
    }
    ?>
    -->
</div>
<?php } ?>