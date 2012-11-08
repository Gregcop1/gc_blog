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
class tx_gcblog_commentForm extends tx_gclib_form {
    var $prefixId      = 'tx_gcblog_pi1';       // Same as class name
    var $scriptRelPath = 'pi1/class.tx_gcblog_commentForm.php';    // Path to this script relative to the extension dir.
    var $extKey        = 'gc_blog'; // The extension key.

    var $flashMessage   = '';

    function main($conf, $id = '', $method = 'POST', $enctype = 'multipart/form-data', $action = '') {
        parent::main($conf, $id, $method, $enctype, $action);
        $GLOBALS['TSFE']->additionnalHeaderData['gc_blog'] = '<script type="text/javascript" src="'.t3lib_extMgm::siteRelPath($this->extKey).'res/js/form.js"></script>

            <script type="text/javascript">alert("bla");</script>
        ';
//t3lib_utility_Debug::debug( $GLOBALS['TSFE']->additionnalHeaderData);

        return $this->render($this->config['templateFile'], 'TEMPLATE_COMMENT_FORM',  $this->conf['displayCommentForm.']);
    }

    function valideForm(){
        $this->pi_loadLL();

        if($this->piVars['submit'] && $this->isFormValid()) {
            //insertion du commentaire en BDD
            if($GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_gcblog_comment',array(
                'pid' => $GLOBALS['TSFE']->id,
                'tstamp' => time(),
                'crdate' => time(),
                'hidden' => 1,
                'author' => $this->piVars['name'],
                'email' => $this->piVars['email'],
                'website' => $this->piVars['website'],
                'comment' => $this->piVars['messagelo'],
                'remote_addr' => $_SERVER['REMOTE_ADDR'],
                'parent_comment' => $this->piVars['replyTo']
                ))) {
                $this->flashMessage = $this->pi_getLL('valid.commentInsert');
            }else {
                $this->flashMessage = $this->pi_getLL('error.badCommentInsert');
            }
        }
    }

    function isFormValid() {
        return true;
    }

    function buildFields() {
        $this->valideForm();
        parent::buildFields();

        $this->fields['doNotFill'] = $this->setField('text', 'doNotFill', '', '', '', 'doNotFill' );
        $this->fields['replyTo'] = $this->setField('hidden', 'replyTo' );
        $this->fields['name'] = $this->setField('text', 'name', '', $this->pi_getLL('template.commentForm.name') );
        $this->fields['email'] = $this->setField('text', 'email', '', $this->pi_getLL('template.commentForm.email') );
        $this->fields['website'] = $this->setField('text', 'website', '', $this->pi_getLL('template.commentForm.website') );
        $this->fields['message'] = $this->setField('textarea', 'message', '', $this->pi_getLL('template.commentForm.message') );
        $this->fields['submit'] = $this->setField('submit', 'submit', $this->pi_getLL('template.commentForm.send') );
    }

    function buildRender($template = array(), $config = array(), $results = array()) {
        $subpartArray = parent::buildRender( $template, $config, $results );

        $subpartArray['###FLASH_MESSAGE###'] = $this->flashMessage;

        return $subpartArray;
    }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gc_blog/pi1/class.tx_gcblog_commentForm.php'])    {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gc_blog/pi1/class.tx_gcblog_commentForm.php']);
}

?>
