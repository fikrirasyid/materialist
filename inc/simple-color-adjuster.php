<?php
/**
 * A library for manipulating color: do SCSS' lighten() and darken() using PHP easily
 * Purposely made for WordPress theming due to scss.inc.php which triggers too much alert on theme-check
 * 
 * @author Fikri Rasyid
 * 
 * Simple Color Adjuster is developed by modifying following resources:
 * 
 * scssphp library - http://leafo.net/scssphp/
 * License: Distributed under the terms of GNU General Public License v3
 * Copyright: Leaf Corcoran, http://leafo.net/
 * 
 * Twenty Fifteen - https://wordpress.org/themes/twentyfifteen
 * License: Distributed under the terms of GNU General Public License
 * Copyright: The WordPress team, http://wordpress.org
 * 
 * Opus - http://fikrirasy.id/portfolio/opus
 * License: Distributed under the terms of GNU General Public License
 * Copyright: Fikri Rasyid, http://fikrirasy.id
 */
class Materialist_Simple_Color_Adjuster{

	/**
	 * Method for lightening
	 * 
	 * @param string 	hexacode
	 * @param float 	0 - 100 (percentage)
	 * 
	 * @return string 	hexacode
	 */
	public function lighten( $hex, $amount ){

		return $this->adjust_color( $hex, $amount );
	}

	/**
	 * Method for darkening
	 * 
	 * @param string 	hexacode
	 * @param float 	0 - 100 (percentage)
	 * 
	 * @return string 	hexacode
	 */
	public function darken( $hex, $amount ){

		$amount = 0 - $amount;

		return $this->adjust_color( $hex, $amount );		
	}

	/**
	 * Darken/Lighten color based on hexacode and percentage given
	 * The code is based on Leaf Corcoran's SCSS compiler based on PHP which is released under GPL v3
	 * 
	 * @param string 	hexacode
	 * @param float 	lighten / darken percentage -100 - 100
	 * 
	 * @return string 	hexacode
	 */
	public function adjust_color( $hex, $amount ){

	 	// Translate hexacode into RGB
		$rgb = $this->hex_to_rgb( $hex );

		// Translate RBG to HSL
		$hsl = $this->rgb_to_hsl( $rgb[0], $rgb[1], $rgb[2] );

		// Darkening / Lightening
		$hsl[2] += $amount;

		// Translate HSL to RGB
		$color = $this->hsl_to_rgb( $hsl[0], $hsl[1], $hsl[2] );

		// Translate RGB to hex
		$adjusted_color = $this->rgb_to_hex( $color );

		return $adjusted_color;
	}

	/**
	 * Convert hexacode color into array of RGB
	 * The code is based on Twenty Fifteen's twentyfifteen_hex2rgb() which is released under GPL v2
	 * 
	 * @param string 	hexacode
	 * @return array 	rgb value
	 */
	public function hex_to_rgb( $hex ){
		$color = trim( $hex, '#' );

		if ( strlen( $color ) == 3 ) {
			$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
			$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
			$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
		} else if ( strlen( $color ) == 6 ) {
			$r = hexdec( substr( $color, 0, 2 ) );
			$g = hexdec( substr( $color, 2, 2 ) );
			$b = hexdec( substr( $color, 4, 2 ) );
		} else {
			return array();
		}

		return array( $r, $g, $b );
	}

	/**
	 * Convert array of RGB into hexacode color
	 * The code is based on Opus Theme's Opus_Customizer->adjust_brightness() which is released under GPL v2
	 * 
	 * @param array 	rgb value
	 * @return param 	string hexacode
	 */
	public function rgb_to_hex( $rgb ){
		$hex = "#";
		$hex .= str_pad( dechex($rgb[0] ), 2, "0", STR_PAD_LEFT );
		$hex .= str_pad( dechex($rgb[1] ), 2, "0", STR_PAD_LEFT );
		$hex .= str_pad( dechex($rgb[2] ), 2, "0", STR_PAD_LEFT );

		return $hex;
	}

	/**
	 * Convert RGB into HSL
	 * The code is based on Leaf Corcoran's SCSS compiler based on PHP which is released under GPL v3
	 * 
	 * @param int 	red of RGB
	 * @param int 	green of RGB
	 * @param int 	blue of RGB
	 * 
	 * @return array of HSL value
	 */
	public function rgb_to_hsl( $red, $green, $blue ){
		$r = $red / 255;
		$g = $green / 255;
		$b = $blue / 255;

		$min = min($r, $g, $b);
		$max = max($r, $g, $b);
		$d = $max - $min;
		$l = ($min + $max) / 2;

		if ($min == $max) {
			$s = $h = 0;
		} else {
			if ($l < 0.5)
				$s = $d / (2 * $l);
			else
				$s = $d / (2 - 2 * $l);

			if ($r == $max)
				$h = 60 * ($g - $b) / $d;
			elseif ($g == $max)
				$h = 60 * ($b - $r) / $d + 120;
			elseif ($b == $max)
				$h = 60 * ($r - $g) / $d + 240;
		}

		return array( fmod($h, 360), $s * 100, $l * 100);	
	}

	/**
	 * Convert HUE into RGB
	 * The code is based on Leaf Corcoran's SCSS compiler based on PHP which is released under GPL v3
	 */
	public function hue_to_rgb( $m1, $m2, $h ){
			if ($h < 0)
				$h += 1;
			elseif ($h > 1)
				$h -= 1;

			if ($h * 6 < 1)
				return $m1 + ($m2 - $m1) * $h * 6;

			if ($h * 2 < 1)
				return $m2;

			if ($h * 3 < 2)
				return $m1 + ($m2 - $m1) * (2/3 - $h) * 6;

			return $m1;	
	}

	/**
	 * Convert HSL to RGB
	 * The code is based on Leaf Corcoran's SCSS compiler based on PHP which is released under GPL v3
	 * 
	 * @param float 	hue
	 * @param float 	saturation
	 * @param float 	lightenss
	 * 
	 * @return array 	RGB color
	 */
	public function hsl_to_rgb( $hue, $saturation, $lightness ){
		if ($hue < 0) {
			$hue += 360;
		}

		$h = $hue / 360;
		$s = min(100, max(0, $saturation)) / 100;
		$l = min(100, max(0, $lightness)) / 100;

		$m2 = $l <= 0.5 ? $l * ($s + 1) : $l + $s - $l * $s;
		$m1 = $l * 2 - $m2;

		$r = $this->hue_to_rgb($m1, $m2, $h + 1/3) * 255;
		$g = $this->hue_to_rgb($m1, $m2, $h) * 255;
		$b = $this->hue_to_rgb($m1, $m2, $h - 1/3) * 255;

		$out = array($r, $g, $b);

		return $out;	
	}	
}