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
        $this->pi_loadLL();
        if(!$GLOBALS['TSFE']->page['tx_gcblog_blockComment']) {
            parent::main($conf, $id, $method, $enctype, $action);

            $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);
            if($extConf['includeJQuery']) {
                $GLOBALS['TSFE']->additionalHeaderData['jquery'] = '<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>';
            }

            $GLOBALS['TSFE']->additionalHeaderData['gc_blog'] = '<script type="text/javascript" src="'.t3lib_extMgm::siteRelPath($this->extKey).'res/js/form.js"></script>
            ';

            return $this->render($this->config['templateFile'], 'TEMPLATE_COMMENT_FORM',  $this->conf['displayCommentForm.']);
        }else {
            return $this->flashMessage = $this->pi_getLL('error.commentDisabled');
        }
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
                'comment' => $this->piVars['message'],
                'remote_addr' => $_SERVER['REMOTE_ADDR'],
                'parent_comment' => $this->piVars['replyTo']
                ))) {
                $this->flashMessage = $this->pi_getLL('valid.commentInsert');

                // sending confirmation email
                $emails = $this->getAdminRecipients();
                if(count($emails)) {
                    $from = t3lib_utility_Mail::getSystemFrom();
                    $mail = t3lib_div::makeInstance('t3lib_mail_Message');
                    $mail->setFrom($from);
                    foreach($emails as $item) {
                        $mail->setTo(trim($item));
                    }
                    $mail->setSubject(sprintf($this->pi_getLL('mail.subject'),
                                        $GLOBALS['TSFE']->page['title']));
                    $mail->setBody(sprintf($this->pi_getLL('mail.body'),
                                        $GLOBALS['TSFE']->page['title'],
                                        'http://'.$_SERVER['HTTP_HOST'].'/typo3/index.php?redirect_url=mod.php%3F%26M%3Dweb_list%26id%3D'.$GLOBALS['TSFE']->id
                    ));
                    $mail->send();

                }

            }else {
                $this->flashMessage = $this->pi_getLL('error.badCommentInsert');
            }
        }
    }

    function getAdminRecipients() {
        if($this->config['commentAdminMails']) {
            $emails = explode(';', $this->config['commentAdminMails']);
        }else {
            $emails = array();
        }

        //find cruser email
        $cruser = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
            'be_users.email',
            'be_users',
            'be_users.uid="'.$GLOBALS['TSFE']->page['cruser_id'].'"',
            '',
            '',
            '1'
        );
        if($cruser && count($cruser)) {
            array_push($emails, $cruser[0]['email']);
            return array_unique($emails);
        }

        return $emails;
    }

    function buildFields() {
        parent::buildFields();

        $this->fields['doNotFill'] = $this->setField('text', 'doNotFill', '', '', 'mustBeEmpty', 'doNotFill' );
        $this->fields['replyTo'] = $this->setField('hidden', 'replyTo', '', '', '', 'replyTo' );
        $this->fields['name'] = $this->setField('text', 'name', '', $this->pi_getLL('template.commentForm.name'), 'required' );
        $this->fields['email'] = $this->setField('text', 'email', '', $this->pi_getLL('template.commentForm.email'), 'required,email' );
        $this->fields['website'] = $this->setField('text', 'website', '', $this->pi_getLL('template.commentForm.website') );
        $this->fields['message'] = $this->setField('textarea', 'message', '', $this->pi_getLL('template.commentForm.message'), 'required' );
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
