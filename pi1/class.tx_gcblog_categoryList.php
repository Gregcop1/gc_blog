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
class tx_gcblog_categoryList extends tx_gclib_list {
	var $prefixId      = 'tx_gcblog_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_gcblog_categoryList.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gc_blog';	// The extension key.

	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($conf, $tableName = 'tx_gcblog_category') {
	 	parent::main($conf, $tableName);

		return $this->render( $this->config['templateFile'],
								'TEMPLATE_CAT',
								$this->conf['displayCat.'],
								$this->results);
	}

	function initFilterQueryParts($currentParent = 0){
		$this->query['WHERE'] .= ' AND '.$this->tableName.'.parent_category="'.$currentParent.'"';
	}

	function buildRender($template = array(), $configuration = array(), $results = array(), $currentLevel = 0) {
		$template['item'] = $this->cObj->getSubpart($template['total'], '###ITEM###');
		$out = '';

		if( $results && count($results) ) {
			foreach($results as $item) {
				$markerArray=array();
				$currentParent = $item['parent_category'];
				//build children
			 	$this->initStaticQueryParts();
			 	$this->initFilterQueryParts($item['uid']);
			 	$results = $this->execQuery( $this->query );
			 	if(count($results) && ($this->config['categoryRecursive'] && intval($this->config['categoryRecursive'])>$currentLevel)) {
				 	$markerArray['###CHILDREN###'] = $this->render( $this->config['templateFile'],
									'TEMPLATE_CAT',
									$this->conf['displayCat.'],
									$results, $currentLevel+1);
				}else {
					$markerArray['###CHILDREN###'] = '';
				}


				$this->cObj->start( $item, $this->tableName );
				$this->applyMarkers ( $configuration['markers.'], $markerArray );
				$out .= $this->cObj->substituteMarkerArrayCached($template['item'],$markerArray);
			}
		}

		$subpartArray['###CLASS###'] = ' level-'.$currentLevel.' parent-'.$currentParent;
		$subpartArray['###CONTENT###'] = $out;
		$this->applyMarkers ( $configuration['markers.'], $subpartArray );

		return $subpartArray;
	}

	function render($templateFile = '', $subPart = '', $configuration = array(), $results = array(), $currentLevel= 0 ) {
		$templateCode = $this->cObj->fileResource($templateFile);
		if ($templateCode) {
			$template = array();
			$template['total'] = $this->cObj->getSubpart($templateCode, '###'.$subPart.'###');

			$subpartArray = $this->buildRender( $template, $configuration, $results, $currentLevel );

			return $this->cObj->substituteMarkerArrayCached($template['total'], array(),$subpartArray);
		} else {
			return $this->pi_getLL('error.noTemplateFound');
		}
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gc_blog/pi1/class.tx_gcblog_categoryList.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gc_blog/pi1/class.tx_gcblog_categoryList.php']);
}

?>
