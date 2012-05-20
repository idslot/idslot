<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * IDSlot
 *
 * Orginal work by EllisLab Dev Team (CodeIgniter)
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 *
 * @package	IDSlot
 * @author	IDSlot Development Team
 * @copyright	Copyright (c) 2012, IDSlot Development Team
 * @license	http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link	http://idslot.org
 */

/*
| -------------------------------------------------------------------
| Foreign Characters
| -------------------------------------------------------------------
| This file contains an array of foreign characters for transliteration
| conversion used by the Text helper
|
*/
$foreign_characters = array(
	'/ä|æ|ǽ/' => 'ae',
	'/ö|œ/' => 'oe',
	'/ü/' => 'ue',
	'/Ä/' => 'Ae',
	'/Ü/' => 'Ue',
	'/Ö/' => 'Oe',
	'/À|Á|Â|Ã|Ä|Å|Ǻ|Ā|Ă|Ą|Ǎ|Α|Ά/' => 'A',
	'/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª|α|ά/' => 'a',
	'/Ç|Ć|Ĉ|Ċ|Č/' => 'C',
	'/ç|ć|ĉ|ċ|č/' => 'c',
	'/Ð|Ď|Đ|Δ/' => 'Dj',
	'/ð|ď|đ|δ/' => 'dj',
	'/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě|Ε|Έ/' => 'E',
	'/è|é|ê|ë|ē|ĕ|ė|ę|ě|έ|ε/' => 'e',
	'/Ĝ|Ğ|Ġ|Ģ|Γ/' => 'G',
	'/ĝ|ğ|ġ|ģ|γ/' => 'g',
	'/Ĥ|Ħ/' => 'H',
	'/ĥ|ħ/' => 'h',
	'/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ|Η|Ή|Ί|Ι|Ϊ/' => 'I',
	'/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı|η|ή|ί|ι|ϊ/' => 'i',
	'/Ĵ/' => 'J',
	'/ĵ/' => 'j',
	'/Ķ|Κ/' => 'K',
	'/ķ|κ/' => 'k',
	'/Ĺ|Ļ|Ľ|Ŀ|Ł|Λ/' => 'L',
	'/ĺ|ļ|ľ|ŀ|ł|λ/' => 'l',
	'/Ñ|Ń|Ņ|Ň|Ν/' => 'N',
	'/ñ|ń|ņ|ň|ŉ|ν/' => 'n',
	'/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ|Ο|Ό|Ω|Ώ/' => 'O',
	'/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º|ο|ό|ω|ώ/' => 'o',
	'/Ŕ|Ŗ|Ř|Ρ/' => 'R',
	'/ŕ|ŗ|ř|ρ/' => 'r',
	'/Ś|Ŝ|Ş|Ș|Š|Σ/' => 'S',
	'/ś|ŝ|ş|ș|š|ſ|σ|ς/' => 's',
	'/Ț|Ţ|Ť|Ŧ|τ/' => 'T',
	'/ț|ţ|ť|ŧ/' => 't',
	'/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ/' => 'U',
	'/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ|υ|ύ|ϋ/' => 'u',
	'/Ý|Ÿ|Ŷ|Υ|Ύ|Ϋ/' => 'Y',
	'/ý|ÿ|ŷ/' => 'y',
	'/Ŵ/' => 'W',
	'/ŵ/' => 'w',
	'/Ź|Ż|Ž|Ζ/' => 'Z',
	'/ź|ż|ž|ζ/' => 'z',
	'/Æ|Ǽ/' => 'AE',
	'/ß/'=> 'ss',
	'/Ĳ/' => 'IJ',
	'/ĳ/' => 'ij',
	'/Œ/' => 'OE',
	'/ƒ/' => 'f',
	'/ξ/' => 'ks',
	'/π/' => 'p',
	'/β/' => 'v',
	'/μ/' => 'm',
	'/ψ/' => 'ps',
);

/* End of file foreign_chars.php */
/* Location: ./application/config/foreign_chars.php */