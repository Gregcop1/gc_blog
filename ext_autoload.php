<?php
/*
 * Register necessary class names with autoloader
 *
 * $Id: ext_autoload.php $
 */

 
 $extensionPath = t3lib_extMgm::extPath('gc_blog');
return array(
	'tx_gcblog_categoryList' => $extensionPath . 'class.tx_gcblog_categoryList.php',
);
unset($extensionPath); 
?>
