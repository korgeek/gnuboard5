<?php
if (!defined('_GNUBOARD_')) exit;

function latest_headline($skin_dir='', $rows=10, $subject_len=100, $cache_time=1)
{
    $bo_table = "business";
    global $g5;
    $write_prefix = $g5['write_prefix'];// . $bo_table; // 게시판 테이블 전체이름
    
    $sql = "
        (
         select 'business' as bo_table, b.* from {$write_prefix}business b 
         where wr_is_comment = 0 and wr_10 = 'H' 
            and wr_datetime > (CURDATE()-INTERVAL 30 DAY)
            and wr_opendatetime > (CURDATE()-INTERVAL 10 DAY)
            and wr_opendatetime < now() 
            and now() < wr_enddatetime 
        ) 
        union
        (
         select 'economy' as bo_table, e.* from {$write_prefix}economy e 
         where wr_is_comment = 0 and wr_10 = 'H' 
            and wr_datetime > (CURDATE()-INTERVAL 30 DAY)
            and wr_opendatetime > (CURDATE()-INTERVAL 10 DAY)
            and wr_opendatetime < now() 
            and now() < wr_enddatetime 
        )
        union
        (
         select 'korean_news' as bo_table, k.* from {$write_prefix}korean_news k 
         where wr_is_comment = 0 and wr_10 = 'H' 
            and wr_datetime > (CURDATE()-INTERVAL 30 DAY)
            and wr_opendatetime > (CURDATE()-INTERVAL 10 DAY)
            and wr_opendatetime < now() 
            and now() < wr_enddatetime 
        )
    ORDER BY wr_opendatetime desc
    limit 0, {$rows}
    ";

    return latest_sql($skin_dir, $bo_table, $rows, $subject_len, $cache_time, $sql);
}

function latest_hotnews($skin_dir='', $rows=10, $subject_len=100, $cache_time=1)
{
    $bo_table = "business";
    global $g5;
    $write_prefix = $g5['write_prefix'];// . $bo_table; // 게시판 테이블 전체이름
    
    $sql = "
        (
         select 'business' as bo_table, b.* from {$write_prefix}business b 
         where wr_is_comment = 0 and wr_10 = 'T' 
            and wr_datetime > (CURDATE()-INTERVAL 30 DAY)
            and wr_opendatetime > (CURDATE()-INTERVAL 10 DAY)
            and wr_opendatetime < now() 
            and now() < wr_enddatetime 
        ) 
        union
        (
         select 'economy' as bo_table, e.* from {$write_prefix}economy e 
         where wr_is_comment = 0 and wr_10 = 'T' 
            and wr_datetime > (CURDATE()-INTERVAL 30 DAY)
            and wr_opendatetime > (CURDATE()-INTERVAL 10 DAY)
            and wr_opendatetime < now() 
            and now() < wr_enddatetime 
        )
        union
        (
         select 'korean_news' as bo_table, k.* from {$write_prefix}korean_news k 
         where wr_is_comment = 0 and wr_10 = 'T' 
            and wr_datetime > (CURDATE()-INTERVAL 30 DAY)
            and wr_opendatetime > (CURDATE()-INTERVAL 10 DAY)
            and wr_opendatetime < now() 
            and now() < wr_enddatetime 
        )
    ORDER BY wr_opendatetime desc
    limit 0, {$rows}
    ";
    return latest_sql($skin_dir, $bo_table, $rows, $subject_len, $cache_time, $sql);
}


function latest_hitnews($skin_dir='', $rows=10, $subject_len=100, $cache_time=1)
{
    $bo_table = "business";
    global $g5;
    $write_prefix = $g5['write_prefix'];// . $bo_table; // 게시판 테이블 전체이름
    
    $sql = "
        (
         select 'business' as bo_table, b.* from {$write_prefix}business b 
            where wr_is_comment = 0 
            and wr_datetime > (CURDATE()-INTERVAL 10 DAY)
            and wr_opendatetime < now() 
            and now() < wr_enddatetime 
        ) 
        union
        (
         select 'economy' as bo_table, e.* from {$write_prefix}economy e 
            where wr_is_comment = 0 
            and wr_datetime > (CURDATE()-INTERVAL 10 DAY)
            and wr_opendatetime < now() 
            and now() < wr_enddatetime 
        )
        union
        (
         select 'korean_news' as bo_table, k.* from {$write_prefix}korean_news k 
            where wr_is_comment = 0 
            and wr_datetime > (CURDATE()-INTERVAL 10 DAY)
            and wr_opendatetime < now() 
            and now() < wr_enddatetime 
        )  
    ORDER BY wr_hit desc
    limit 0, {$rows}
    ";
    return latest_sql($skin_dir, $bo_table, $rows, $subject_len, $cache_time, $sql);
}

function latest_news($skin_dir='', $bo_table, $rows=10, $subject_len=100, $cache_time=1)
{
    global $g5;
    $tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
    $sql = " select * from {$tmp_write_table} where wr_is_comment = 0 
                    and wr_opendatetime < now() and now() < wr_enddatetime 
                    and wr_10 <> 'H'
                    order by wr_opendatetime desc limit 0, {$rows} ";
    /*
    $sql = " select * from {$tmp_write_table} where wr_is_comment = 0 
                    and wr_10 = ''
                    and wr_opendatetime < now() and now() < wr_enddatetime 
                    order by wr_num limit 0, {$rows} ";
    */
                    
    return latest_sql($skin_dir, $bo_table, $rows, $subject_len, $cache_time, $sql);
}

function latest_category($skin_dir='', $bo_table, $rows=10, $subject_len=100, $cache_time=1, $ca_name='')
{
    global $g5;
    $tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
    
    $sql = " select '{$bo_table}' as bo_table, a.* from {$tmp_write_table} a where wr_is_comment = 0 and wr_opendatetime < now() and now() < wr_enddatetime order by wr_num limit 0, {$rows} ";
    if(!empty($ca_name)){
        $sql = " select '{$bo_table}' as bo_table, a.* from {$tmp_write_table} a where wr_is_comment = 0 and ca_name = '{$ca_name}' and wr_opendatetime < now() and now() < wr_enddatetime order by wr_num limit 0, {$rows} ";
    }
    return latest_sql($skin_dir, $bo_table, $rows, $subject_len, $cache_time, $sql);
}

function latest_ads($skin_dir='', $bo_table, $rows=100, $subject_len=100, $cache_time=1)
{
    global $g5;
    $tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
    
    $sql = " select '{$bo_table}' as bo_table, a.* from {$tmp_write_table} a where wr_is_comment = 0 and wr_opendatetime < now() and now() < wr_enddatetime order by wr_8 asc limit 0, {$rows}  ";

    return latest_sql($skin_dir, $bo_table, $rows, $subject_len, $cache_time, $sql);
}

function latest_group($skin_dir='', $gr_id, $rows=10, $subject_len=100, $cache_time=1)
{

    global $g5;
    $write_prefix = $g5['write_prefix'];// . $bo_table; // 게시판 테이블 전체이름
    $bo_table = "";

    $sqlgroup = " select *  
        from {$g5['board_new_table']} a, {$g5['board_table']} b, {$g5['group_table']} c 
        where 
            a.bo_table = b.bo_table 
            and b.gr_id = '$gr_id' 
            and b.gr_id = c.gr_id 
            and b.bo_use_search = 1 
            order by bn_datetime desc limit 0, {$rows} ";

    
    $result = sql_query($sqlgroup);
    $sql = "";
    
    for ($i=0; $row = sql_fetch_array($result); $i++) {
        
        $bo_table = $row['bo_table'];
        $wr_id = $row['wr_id'];
        $sql = $sql."
        (
            select '$bo_table' as bo_table, $bo_table.* from {$write_prefix}$bo_table $bo_table  
            where wr_id = $wr_id 
        )
        ";
        if($i+1 < $rows ){
         $sql .= " union ";
        }
    }
    
    //echo $sql;

    return latest_sql($skin_dir, $bo_table, $rows, $subject_len, $cache_time, $sql);
}


function latest_sql($skin_dir='', $bo_table, $rows=10, $subject_len=40, $cache_time=1, $sql)
{
    global $g5;

    if (!$skin_dir) $skin_dir = 'basic';
    
    $time_unit = 3600;  // 1시간으로 고정

    if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
        if (G5_IS_MOBILE) {
            $latest_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
            if(!is_dir($latest_skin_path))
                $latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
            $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        } else {
            $latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
            $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        }
        $skin_dir = $match[1];
    } else {
        if(G5_IS_MOBILE) {
            $latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
            $latest_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
        } else {
            $latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
            $latest_skin_url  = G5_SKIN_URL.'/latest/'.$skin_dir;
        }
    }

    $caches = false;

    if(G5_USE_CACHE) {
        $cache_file_name = "latest-{$bo_table}-".md5($sql)."-{$skin_dir}-{$rows}-{$subject_len}-".g5_cache_secret_key();
        $caches = g5_get_cache($cache_file_name, (int) $time_unit * (int) $cache_time);
        $cache_list = isset($caches['list']) ? $caches['list'] : array();
        g5_latest_cache_data($bo_table, $cache_list);
    }

    if($caches === false ){

        $list = array();

        $board = get_board_db($bo_table, true);

        if( ! $board ){
            return '';
        }

        $bo_subject = get_text($board['bo_subject']);
        $result = sql_query($sql);

        for ($i=0; $row = sql_fetch_array($result); $i++) {
            try {
                unset($row['wr_password']);     //패스워드 저장 안함( 아예 삭제 )
            } catch (Exception $e) {
            }
            $row['wr_email'] = '';              //이메일 저장 안함
            if (strstr($row['wr_option'], 'secret')){           // 비밀글일 경우 내용, 링크, 파일 저장 안함
                $row['wr_content'] = $row['wr_link1'] = $row['wr_link2'] = '';
                $row['file'] = array('count'=>0);
            }
            

            if( $list[$i]['bo_table'] != $bo_table ){
                $tmp_board = get_board_db($list[$i]['bo_table'], true);
                $list[$i] = get_list($row, $tmp_board, $latest_skin_url, $subject_len); 
            }else{
                $list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
            }

            $list[$i]['files'] = get_board_file_db_array($bo_table, $row['wr_id'], '*', "and bf_type in (1, 2, 3, 18) ");

            if(! isset($list[$i]['icon_file'])) $list[$i]['icon_file'] = '';
        }

        g5_latest_cache_data($bo_table, $list);

        if(G5_USE_CACHE) {

            $caches = array(
                'list' => $list,
                'bo_subject' => sql_escape_string($bo_subject),
            );

            g5_set_cache($cache_file_name, $caches, (int) $time_unit * (int) $cache_time);
        }
    } else {
        $list = $cache_list;
        $bo_subject = (is_array($caches) && isset($caches['bo_subject'])) ? $caches['bo_subject'] : '';
    }

    ob_start();
    include $latest_skin_path.'/latest.skin.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}