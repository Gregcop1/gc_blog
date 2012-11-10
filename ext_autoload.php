<?php
/*
 * Register necessary class names with autoloader
 *
 * $Id: ext_autoload.php $
 */


 $extensionPath = t3lib_extMgm::extPath('gc_blog');
return array(
    'tx_gcblog_categoryList' => $extensionPath . 'class.tx_gcblog_categoryList.php',
    'tx_gcblog_postList' => $extensionPath . 'class.tx_gcblog_postList.php',
    'tx_gcblog_commentsListOfPost' => $extensionPath . 'class.tx_gcblog_commentsListOfPost.php',
    'tx_gcblog_commentForm' => $extensionPath . 'class.tx_gcblog_commentForm.php',
    'user_gcblog_utils' => $extensionPath . 'class.user_gcblog_utils.php',
);
unset($extensionPath);
?>
