<?php
/*
 * Register necessary class names with autoloader
 *
 * $Id: ext_autoload.php $
 */


 $extensionPath = t3lib_extMgm::extPath('gc_blog');
return array(
    'tx_gcblog_categoryList' => $extensionPath . 'class.tx_gcblog_categoryList.php',
	'ux_t3lib_tree_pagetree_dataprovider' => $extensionPath . 'class.ux_t3lib_tree_pagetree_dataprovider.php',
);
unset($extensionPath);
?>
