<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}

$_EXTCONF = unserialize($_EXTCONF);	// unserializing the configuration so we can use it here:

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_gcblog_pi1.php', '_pi1', 'list_type', 1);



include_once(t3lib_extMgm::extPath($_EXTKEY).'lib/class.tx_gcblog_TCAform_selectTree.php');

?>
