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
 * @author  Grégory Copin <typo3@inouit.com>
 * @package TYPO3
 * @subpackage  tx_gcblog
 */
class tx_gcblog_postList extends tx_gclib_list {
    var $prefixId      = 'tx_gcblog_pi1';       // Same as class name
    var $scriptRelPath = 'pi1/class.tx_gcblog_postList.php';    // Path to this script relative to the extension dir.
    var $extKey        = 'gc_blog'; // The extension key.

    /**
     * The main method of the PlugIn
     *
     * @param   string      $content: The PlugIn content
     * @param   array       $conf: The PlugIn configuration
     * @return  The content that is displayed on the website
     */
    function main($conf, $tableName = 'pages') {
        parent::main($conf, $tableName);

        return $this->render( $this->config['templateFile'],
                                'TEMPLATE_POSTS',
                                $this->conf['displayPosts.'],
                                $this->results);
    }

    function initFilterQueryParts($currentParent = 0){
        $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);
        $this->query['WHERE'] .= ' AND '.$this->tableName.'.doktype="'.$extConf['postCType'].'"';

        if($this->piVars['category']) {
            $this->query['WHERE'] .= ' AND "'.$this->piVars['category'].'" in ('.$this->tableName.'.tx_gcblog_category)';
        }

        if($this->piVars['tag']) {
            $this->query['WHERE'] .= ' AND "'.$this->piVars['tag'].'" in ('.$this->tableName.'.tx_gcblog_tag)';
        }

        if($this->piVars['author']) {
            $this->query['WHERE'] .= ' AND "'.$this->piVars['author'].'" =  '.$this->tableName.'.cruser_id';
        }
    }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gc_blog/pi1/class.tx_gcblog_postList.php'])    {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gc_blog/pi1/class.tx_gcblog_postList.php']);
}

?>
