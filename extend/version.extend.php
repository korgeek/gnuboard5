<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

date_default_timezone_set('Asia/Jakarta');

// 자바스크립트와 CSS 파일을 새로 다운로드 하도록 파일의 끝에 년월일 지정
// 예) https://도메인/css/default.css?ver=210618
// 예) https://도메인/js/common.js?ver=210618
//define('G5_CSS_VER', '210620');
//define('G5_JS_VER',  '210620');

define('G5_CSS_VER', time() );
define('G5_JS_VER',  time() );
