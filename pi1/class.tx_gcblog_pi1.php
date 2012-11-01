<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Grégory Copin <typo3@inouit.com>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */



/**
 * Plugin 'Category List' for the 'gc_blog' extension.
 *
 * @author	Grégory Copin <typo3@inouit.com>
 * @package	TYPO3
 * @subpackage	tx_gcblog
 */
class tx_gcblog_pi1 extends tx_gclib {
	var $prefixId      = 'tx_gcblog_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_gcblog_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gc_blog';	// The extension key.

	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content,$conf) {
		parent::main($conf);

		$this->initPlugin();

		$content = '';
		switch($this->config['CODE']) {
			case 'postList': {
				//$content = $this->makeInstance(t3lib_extMgm::extPath($this->extKey).'pi1/class.tx_gcblog_list.php', 'tx_gcblog_list', $this->conf);
			}break;
			case 'categoryList':
				$content = $this->makeInstance(t3lib_extMgm::extPath($this->extKey).'pi1/class.tx_gcblog_categoryList.php', 'tx_gcblog_categoryList', $this->conf);
			break;
			case 'tagList':
				//$content = $this->makeInstance(t3lib_extMgm::extPath($this->extKey).'pi1/class.tx_gcblog_search.php', 'tx_gcblog_search', $this->conf);
			break;
		}

		return $this->pi_wrapInBaseClass($content);
	}

	function initPlugin() {
		//init array of cats and tag
		if(!isset($GLOBALS['TSFE']->gc_blog)){

			//embedValue
			if(isset($this->piVars['category'])) {
				$GLOBALS['TSFE']->gc_blog['current'] = array(
						'category' => $this->piVars['category']
					);
			}elseif($GLOBALS['TSFE']->page['doktype'] == 150) {
				$GLOBALS['TSFE']->gc_blog['current'] = array(
						'category' => $GLOBALS['TSFE']->page['tx_gcblog_category'],
						'tag' => $GLOBALS['TSFE']->page['tx_gcblog_tag'],
					);
			}
		}
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gc_blog/pi1/class.tx_gcblog_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gc_blog/pi1/class.tx_gcblog_pi1.php']);
}

?>
