<?php
/*
  Copyright 2010 Scott MacVicar

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.

	Original can be found at https://github.com/scottmac/opengraph/blob/master/OpenGraph.php

*/

class OpenGraph implements Iterator
{
  /**
   * There are base schema's based on type, this is just
   * a map so that the schema can be obtained
   *
   */
	public static $TYPES = array(
		'activity' => array('activity', 'sport'),
		'business' => array('bar', 'company', 'cafe', 'hotel', 'restaurant'),
		'group' => array('cause', 'sports_league', 'sports_team'),
		'organization' => array('band', 'government', 'non_profit', 'school', 'university'),
		'person' => array('actor', 'athlete', 'author', 'director', 'musician', 'politician', 'public_figure'),
		'place' => array('city', 'country', 'landmark', 'state_province'),
		'product' => array('album', 'book', 'drink', 'food', 'game', 'movie', 'product', 'song', 'tv_show'),
		'website' => array('blog', 'website'),
	);

  /**
   * Holds all the Open Graph values we've parsed from a page
   *
   */
	private $_values = array();

  /**
   * Fetches a URI and parses it for Open Graph data, returns
   * false on error.
   *
   * @param $URI    URI to page to parse for Open Graph data
   * @return OpenGraph
   */
	static public function fetch($URI) {
    $cookie_path = 'cookie.txt';
    if ( defined('COOKIE_PATH_FOR_CURL') && !empty(COOKIE_PATH_FOR_CURL) ){
      $cookie_path = COOKIE_PATH_FOR_CURL;
    }
    $curl = curl_init($URI);

    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 15);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_USERAGENT, "facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)");
    //The following 2 set up lines work with sites like www.nytimes.com
    curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_path); //you can change this path to whetever you want.
    curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_path); //you can change this path to whetever you want.

    $response = mb_convert_encoding(curl_exec($curl), 'HTML-ENTITIES', 'UTF-8');

    curl_close($curl);

    if (!empty($response)) {
        return self::_parse($response);
    } else {
        return false;
    }
	}
	
	static public function parse($HTML){
		if ( empty( $HTML ) ){
			return false;
		}
		$response = mb_convert_encoding($HTML, 'HTML-ENTITIES', 'UTF-8');
		return self::_parse($response);
	}

  /**
   * Parses HTML and extracts Open Graph data, this assumes
   * the document is at least well formed.
   *
   * @param $HTML    HTML to parse
   * @return OpenGraph
   */
	static private function _parse($HTML) {
		$old_libxml_error = libxml_use_internal_errors(true);

		$doc = new DOMDocument();
		$doc->loadHTML($HTML);

		libxml_use_internal_errors($old_libxml_error);

		$tags = $doc->getElementsByTagName('meta');
		if (!$tags || $tags->length === 0) {
			return false;
		}

		$page = new self();

		$nonOgDescription = null;

		foreach ($tags AS $tag) {
			if ($tag->hasAttribute('property') && strpos($tag->getAttribute('property'), 'og:') === 0) {
				$key = strtr(substr($tag->getAttribute('property'), 3), '-', '_');

		        if( array_key_exists($key, $page->_values) ){
					if ( !array_key_exists($key.'_additional', $page->_values) ){
						$page->_values[$key.'_additional'] = array();
					}
		        	$page->_values[$key.'_additional'][] = $tag->getAttribute('content');
		        }else{
		        	$page->_values[$key] = $tag->getAttribute('content');
		        }
			}

			//Added this if loop to retrieve description values from sites like the New York Times who have malformed it.
			if ($tag->hasAttribute('value') && $tag->hasAttribute('property') &&
			    strpos($tag->getAttribute('property'), 'og:') === 0) {
				$key = strtr(substr($tag->getAttribute('property'), 3), '-', '_');
				$page->_values[$key] = $tag->getAttribute('value');
			}
			//Based on modifications at https://github.com/bashofmann/opengraph/blob/master/src/OpenGraph/OpenGraph.php
			if ($tag->hasAttribute('name') && $tag->getAttribute('name') === 'description') {
                $nonOgDescription = $tag->getAttribute('content');
            }

			if ($tag->hasAttribute('property') &&
			    strpos($tag->getAttribute('property'), 'twitter:') === 0) {
				$key = strtr($tag->getAttribute('property'), '-:', '__');
				$page->_values[$key] = $tag->getAttribute('content');
			}

			if ($tag->hasAttribute('name') &&
				strpos($tag->getAttribute('name'), 'twitter:') === 0) {
				$key = strtr($tag->getAttribute('name'), '-:', '__');
				if( array_key_exists($key, $page->_values) ){
					if (!array_key_exists($key.'_additional', $page->_values)){
						$page->_values[$key.'_additional'] = array();
					}
					$page->_values[$key.'_additional'][] = $tag->getAttribute('content');
				} else {
					$page->_values[$key] = $tag->getAttribute('content');
				}
			}

			// Notably this will not work if you declare type after you declare type values on a page.
			if ( array_key_exists('type', $page->_values) ){
				$meta_key = $page->_values['type'].':';
				if ($tag->hasAttribute('property') && strpos($tag->getAttribute('property'), $meta_key) === 0) {
					$meta_key_len = strlen($meta_key);
					$key = strtr(substr($tag->getAttribute('property'), $meta_key_len), '-', '_');
					$key = $page->_values['type'].'_'.$key;

					if( array_key_exists($key, $page->_values) ){
						if ( !array_key_exists($key.'_additional', $page->_values) ){
							$page->_values[$key.'_additional'] = array();
						}
						$page->_values[$key.'_additional'][] = $tag->getAttribute('content');
					}else{
						$page->_values[$key] = $tag->getAttribute('content');
					}
				}
			}
		}

		//Based on modifications at https://github.com/bashofmann/opengraph/blob/master/src/OpenGraph/OpenGraph.php
		if (!isset($page->_values['title'])) {
            $titles = $doc->getElementsByTagName('title');
            if ($titles->length > 0) {
                $page->_values['title'] = $titles->item(0)->textContent;
            }
        }
        if (!isset($page->_values['description']) && $nonOgDescription) {
            $page->_values['description'] = $nonOgDescription;
        }

        //Fallback to use image_src if ogp::image isn't set.
        if (!isset($page->_values['image'])) {
            $domxpath = new DOMXPath($doc);
            $elements = $domxpath->query("//link[@rel='image_src']");

            if ($elements->length > 0) {
                $domattr = $elements->item(0)->attributes->getNamedItem('href');
                if ($domattr) {
                    $page->_values['image'] = $domattr->value;
                    $page->_values['image_src'] = $domattr->value;
                }
            } else if (!empty($page->_values['twitter_image'])){
				$page->_values['image'] = $page->_values['twitter_image'];
			} else {
				$elements = $doc->getElementsByTagName("img");
				foreach ( $elements as $tag ){
					if ($tag->hasAttribute('width') && ( ($tag->getAttribute('width') > 300) || ($tag->getAttribute('width') == '100%') ) ){
						$page->_values['image'] = $tag->getAttribute('src');
						break;
					}
				}
			}
        }

		if (empty($page->_values)) { return false; }

		return $page;
	}

  /**
   * Helper method to access attributes directly
   * Example:
   * $graph->title
   *
   * @param $key    Key to fetch from the lookup
   */
	public function __get($key) {
		if (array_key_exists($key, $this->_values)) {
			return $this->_values[$key];
		}

		if ($key === 'schema') {
			foreach (self::$TYPES AS $schema => $types) {
				if (array_search($this->_values['type'], $types)) {
					return $schema;
				}
			}
		}
	}

  /**
   * Return all the keys found on the page
   *
   * @return array
   */
	public function keys() {
		return array_keys($this->_values);
	}

  /**
   * Helper method to check an attribute exists
   *
   * @param $key
   */
	public function __isset($key) {
		return array_key_exists($key, $this->_values);
	}

  /**
   * Will return true if the page has location data embedded
   *
   * @return boolean Check if the page has location data
   */
	public function hasLocation() {
		if (array_key_exists('latitude', $this->_values) && array_key_exists('longitude', $this->_values)) {
			return true;
		}

		$address_keys = array('street_address', 'locality', 'region', 'postal_code', 'country_name');
		$valid_address = true;
		foreach ($address_keys AS $key) {
			$valid_address = ($valid_address && array_key_exists($key, $this->_values));
		}
		return $valid_address;
	}

  /**
   * Iterator code
   */
	private $_position = 0;
	public function rewind() { reset($this->_values); $this->_position = 0; }
	public function current() { return current($this->_values); }
	public function key() { return key($this->_values); }
	public function next() { next($this->_values); ++$this->_position; }
	public function valid() { return $this->_position < sizeof($this->_values); }
}
















if (!defined('_GNUBOARD_')) exit; // Unable to access direct pages

//return;

add_replace('html_process_add_meta', 'add_open_graph_meta_tag', 10, 1);

function add_open_graph_meta_tag($add_meta_tag=''){

    if( defined('G5_IS_ADMIN') ) return;

    global $config, $board, $write;
    
    // https://developers.facebook.com/docs/sharing/webmasters?locale=ko_KR
    // http://blog.ab180.co/open-graph-as-a-website-preview/
    // https://futurecreator.github.io/2016/06/16/opengraph-social-meta-tag/
    
    $metas = array();

    $og_type = 'website';
    $site_title = get_text($config['cf_title']);

    //사이트 설명을 입력해 주세요.
    $description  = '자카르타경제신문: 인도네시아 경제, 산업, 투자 관련 각종 법령 전달, 동포사회 동정 전달';

    if( ! $description ){
        $description = $site_title;
    }

    $site_url   = G5_URL;
    $site_name  = get_text($config['cf_title']);
    $site_image = (defined('G5_THEME_PATH') && file_exists(G5_THEME_PATH.'/img/pagi/pagi_logo_og.png')) ? G5_THEME_IMG_URL.'/pagi/pagi_logo_og.png' : G5_IMG_URL.'/theme/pagi-v2/img/pagi/pagi_logo_og.png';         // 로고 이미지
    $meta_keywords = '';
    
    $thumb_max_width = '600';      // 게시글 썸네일 MAX width 사이즈 지정
    $thumb_max_height = '400';      // 게시글 썸네일 MAX height 사이즈 지정

    if(isset($board['bo_table']) && $board['bo_table']) {
        if(isset($write['wr_id']) && $write['wr_id'] && !strstr($write['wr_option'], 'secret')) {
            $og_type = 'article';
            $site_title  = get_text($write['wr_subject']).' - '.get_text($board['bo_subject']);
            $site_url = get_pretty_url($board['bo_table'], $write['wr_id']);
            $description   = strip_tags(get_text(cut_str(strip_tags($write['wr_content']), 200), 1))." ".$write['wr_1'];
            
            $keywords = get_text(array($board['bo_1_subj'], $write['ca_name'], $write['wr_subject']));
            $meta_keywords = implode(', ', array_filter($keywords)).", ".$write['wr_1'];
            
            if(function_exists('get_list_thumbnail')){
                $thumb = get_list_thumbnail($board['bo_table'], $write['wr_id'], $thumb_max_width, $thumb_max_height, false, true);

                if( isset($thumb['src']) && $thumb['src'] ){
                    $site_image = $thumb['src'];
                }
                
                // 원본 사진으로 하려고 한다면 아래 주석을 풀고 사용해 주세요.
                //if( isset($thumb['ori']) && $thumb['ori'] ){
                    //$site_image = $thumb['ori'];
                //}
            }
        } else {
            $site_title = get_text($board['bo_subject']).' > '.get_text($config['cf_title']);
            $site_url   = get_pretty_url($board['bo_table']);
            $description = $site_title;
        }
    }

    $metas[] = '<meta name="description" content="'.$description.'" />';
    if( $meta_keywords ) $metas[] = '<meta name="keywords" content="웃긴짤, 예능짤, 방송짤, '.$meta_keywords.'" />';
    $metas[] = '<meta property="og:type" content="'.$og_type.'" />';
    $metas[] = '<meta property="og:title" content="'.$site_title.'" />';
    $metas[] = '<meta property="og:description" content="'.$description.'" />';
    $metas[] = '<meta property="og:url" content="'.$site_url.'" />';
    $metas[] = '<meta property="og:site_name" content="'.$site_name.'" />';
    $metas[] = '<meta property="og:image" content="'.$site_image.'" />';
    $metas[] = '<meta property="og:image:width" content="'.$thumb_max_width.'" />';
    $metas[] = '<meta property="og:image:height" content="'.$thumb_max_height.'" />';
    $metas[] = '<meta name="twitter:card" content="summary" />';
    $metas[] = '<meta name="twitter:image" content="'.$site_image.'" />';
    $metas[] = '<meta name="twitter:title" content="'.$site_title.'" />';
    $metas[] = '<meta name="twitter:description" content="'.$description.'" />';

    $add_meta_tag .= implode(PHP_EOL, $metas);

    return $add_meta_tag;
}
?>