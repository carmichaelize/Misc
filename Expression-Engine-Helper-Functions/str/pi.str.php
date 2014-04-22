<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	//http://ellislab.com/expressionengine/user-guide/development/plugins.html

	$plugin_info = array(
			     'pi_name' => 'Scotts Helpers',
			     'pi_version' =>'1.0',
			     'pi_author' =>'Scott Carmichael',
			     'pi_author_url' => 'http://www.scottcarmichael.co.uk',
			     'pi_description' => 'Useful String Manipulations',
			     'pi_usage' => Str::usage()
			     );

	class Fw_cat {

		function usage(){
			
			ob_start();   
   			?>  
  
   			This is where our simplified documentation will go  
  
   			<?php  
   			
   			$buffer = ob_get_contents();  
  
   			ob_end_clean();   
  
   			return $buffer; 
		}

		public $return_data  = "";
		
		public function __construct($string = ''){

			$this->return_data = ee()->TMPL->fetch_param('value').'<br />';
			//echo 'test';
			//return 'test';
			//$this->EE =& get_instance();
		}

		public function bold()
	    {	
	    	if( isset($_GET['test']) ){
	    		return $_GET['test'];
	    	}
	    	return false;
	    	
	        return '<strong>'.$this->return_data = ee()->TMPL->fetch_param('value').'<strong>';
	    }



		/**
		* Convert a string to lowercase.
		*
		* @param  string  $string
		* @return string
		*
		*/

		public static function lower( $string = null ){
			$string = $string ? $string : ee()->TMPL->fetch_param('string');
			return strtolower(strip_tags( $string ));
		}

		/**
		* Convert a string to uppercase.
		*
		* @param  string  $string
		* @return string
		*
		*/

		public static function upper( $string = null ){
			$string = $string ? $string : ee()->TMPL->fetch_param('string');
			return strtoupper(strip_tags( $string ));
		}

		/**
		* Convert a string to title case (ucwords equivalent).
		*
		* @param  string  $string
		* @return string
		*
		*/

		public static function title( $string = null ){
			$string = $string ? $string : ee()->TMPL->fetch_param('string');
			return ucwords(strtolower(strip_tags( $string )));
		}

		/**
		* Get the length of a string.
		*
		* @param  string  $string
		* @return int
		*
		*/

		public static function length( $string = null ){
			$string = $string ? $string : ee()->TMPL->fetch_param('string');
			return  strlen(strip_tags( $string ));
		}

		/**
		* Limit the number of characters in a string.
		* @param  string  $string
		* @param  int     $limit
		* @param  string  $trail
		* @return string
		*
		*/

		public static function limit( $string = null, $limit = null, $trail = null ){

			$string = $string ? $string : ee()->TMPL->fetch_param('string');
			$limit = $limit ? $limit : ee()->TMPL->fetch_param('limit');
			$trail = $trail ? $trail : ee()->TMPL->fetch_param('trail');
			
			$string = trim(strip_tags($string));
			$trail = $trail ? $trail : '...';

			return static::length($string) <= $limit ? $string : substr($string, 0, $limit).$trail ;
		}

		/**
		* Limit the number of words in a string.
		*
		* @param  string  $string
		* @param  int     $limit
		* @param  string  $trail
		* @return string
		*
		*/

		public static function words($string = null, $limit = null, $trail = null){

			$string = $string ? $string : ee()->TMPL->fetch_param('string');
			$limit = $limit ? $limit : ee()->TMPL->fetch_param('limit');
			$trail = $trail ? $trail : ee()->TMPL->fetch_param('trail');

			$string = strip_tags($string);
			$trail = $trail ? $trail : '...';

			if ($string == ''){
				return '';
			}

			preg_match('/^\s*+(?:\S++\s*+){1,'.$limit.'}/u', $string, $matches);

			return rtrim($matches[0]).$trail;
		}

		/**
		* Add Span To Specified Letter.
		*
		* @param  string  $string
		* @param  string  $class_name
		* @param  array   $words
		* @return string
		*
		*/

		public function drop_letter($string = null, $class_name = null, $words = null){

			$string = $string ? $string : ee()->TMPL->fetch_param('string');
			$class_name = $class_name ? $class_name : ee()->TMPL->fetch_param('class_name');
			$words = $words ? $words : static::segments(ee()->TMPL->fetch_param('words'), '|');

			$class_name = $class_name ? $class_name : '';
			$words = $words ? $words : array(0);

			$word_array = str_split($string);
			$new_word = '';
			if(count($word_array) > 1){
				for($i=0;$i<count($word_array);$i++){
					if(in_array($i, $words)){
						$new_word .= '<span class="'.$class_name.'">'.$word_array[$i].'</span>';
					} else {
						$new_word .= $word_array[$i];
					}
				}
				return $new_word;
			}
			return '<span class="'.$class_name.'">'.$string.'</span> ';
		}

		/**
		* Add Span To Specified Word.
		*
		* @param  string  $string
		* @param  string  $class_name
		* @param  array   $words
		* @return string
		*
		*/

		public function drop_word($string = null, $class_name = null, $words = null ){

			$string = $string ? $string : ee()->TMPL->fetch_param('string');
			$class_name = $class_name ? $class_name : ee()->TMPL->fetch_param('class_name');
			$words = $words ? $words : static::segments(ee()->TMPL->fetch_param('words'), '|');

			$class_name = $class_name ? $class_name : '';
			$words = $words ? $words : array(0);

			$word_array = explode(' ', $string);
			$new_word = '';
			if(count($word_array) > 1){
				for($i=0;$i<count($word_array);$i++){
					if(in_array($i, $words)){
						$new_word .= '<span class="'.$class_name.'">'.$word_array[$i].'</span> ';
					} else {
						$new_word .= $word_array[$i].' ';
					}
				}
				return $new_word;
			}
			return '<span class="'.$class_name.'">'.$string.'</span> ';
		}

		/**
		* Generate a random alpha or alpha-numeric string.
		*
		* @param  int	  $length
		* @param  string  $type
		* @return string
		*
		*/

		public static function random( $length = null, $type = null){

			$length = $length ? $length : ee()->TMPL->fetch_param('length');
			$type = $type ? $type : ee()->TMPL->fetch_param('type');

			$type = $type ? $type : 'alpha_num';

			switch($type){
				case 'alpha':
					$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;

				case 'num':
					$pool = '1234567890';
				break;

				case 'alpha_num':
					$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			}

			return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);

		}

		/**
		* Generate a URL friendly "slug" from a given string.
		*
		* @param  string  $string
		* @param  string  $separator
		* @return string
		*
		*/
		public static function slug($string = null, $separator = null){

			$string = $string ? $string : ee()->TMPL->fetch_param('string');
			$separator = $separator ? $separator : ee()->TMPL->fetch_param('separator');

			$separator = $separator ? $separator : '-';
			
			// Remove all characters that are not the separator, letters, numbers, or whitespace.
			$string = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', static::lower($string));

			// Replace all separator characters and whitespace by a single separator
			$string = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $string);

			return trim($string, $separator);
		}

		/**
		* Return the "URI" style segments in a given string.
		*
		* @param  string  $string
		* @return array
		*
		*/

		public static function segments( $string = null, $separator = null ){
			$string = $string ? $string : ee()->TMPL->fetch_param('string');
			$separator = $separator ? $separator : ee()->TMPL->fetch_param('separator');
			return array_diff(explode($separator, trim($string, $separator)), array(''));
		}

		
	}

	
?>