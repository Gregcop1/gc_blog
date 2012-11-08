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
class tx_gcblog_commentsListOfPost extends tx_gclib_list {
    var $prefixId      = 'tx_gcblog_pi1';       // Same as class name
    var $scriptRelPath = 'pi1/class.tx_gcblog_commentsListOfPost.php';    // Path to this script relative to the extension dir.
    var $extKey        = 'gc_blog'; // The extension key.

    /**
     * The main method of the PlugIn
     *
     * @param   string      $content: The PlugIn content
     * @param   array       $conf: The PlugIn configuration
     * @return  The content that is displayed on the website
     */
    function main($conf, $tableName = 'tx_gcblog_comment') {
        parent::main($conf, $tableName);

        return $this->render( $this->config['templateFile'],
                                'TEMPLATE_COMMENTS_LIST_OF_POST',
                                $this->conf['displayCommentsListOfPost.'],
                                $this->results);
    }

    function initFilterQueryParts(){
        $this->query['SELECT'] .= ', MD5(LOWER('.$this->tableName.'.email)) as encodedEmail, c2.author as replyTo';
        $this->query['FROM'] .= ' LEFT OUTER JOIN tx_gcblog_comment c2 ON ('.$this->tableName.'.parent_comment = c2.uid) ';
        $this->query['ORDER BY'] = $this->tableName.'.crdate';
    }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gc_blog/pi1/class.tx_gcblog_commentsListOfPost.php'])    {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gc_blog/pi1/class.tx_gcblog_commentsListOfPost.php']);
}

?>
