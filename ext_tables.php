<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
$TCA['tx_gcblog_category'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gc_blog/locallang_db.xml:tx_gcblog_category',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l10n_parent',	
		'transOrigDiffSourceField' => 'l10n_diffsource',	
		'sortby' => 'sorting',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'starttime' => 'starttime',	
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_gcblog_category.gif',
	),
);
$TCA['tx_gcblog_tag'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gc_blog/locallang_db.xml:tx_gcblog_tag',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l10n_parent',	
		'transOrigDiffSourceField' => 'l10n_diffsource',	
		'sortby' => 'title',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_gcblog_tag.gif',
	),
);

$tempColumns = array (
	'tx_gcblog_category' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:gc_blog/locallang_db.xml:tx_gcblog_category',		
		'config'      => array (
			'type'  => 'select',
			'items' => array (
				array('', 0),
			),
			'foreign_table'       => 'tx_gcblog_category',
			'foreign_table_where' => '',
		)
	),
	'tx_gcblog_tag' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:gc_blog/locallang_db.xml:tx_gcblog_tag',		
		'config'      => array (
			'type'  => 'group',
			'items' => array (
				array('', 0),
			),
			"internal_type" => "db",
            "allowed" => "tx_gcblog_tag",  
            "size" => 3,   
            "minitems" => 0,
            "maxitems" => 20,    
		)
	),
	'tx_gcblog_blockComment' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:gc_blog/locallang_db.xml:tx_gcblog.blockComment',		
		'config'      => array (
			'type'  => 'check',
		)
	),
);

t3lib_div::loadTCA('pages');
t3lib_extMgm::addTCAcolumns('pages',$tempColumns,1);
//t3lib_extMgm::addToAllTCAtypes('pages','','','after:doktype');



//Append a new type of pages : Post
t3lib_div::loadTCA('pages');
$newPageTypeOrder = 2;
$newPageTypeId = 150;
for($i=0; $i < $newPageTypeOrder; $i++) {
	$temp[$i] = $TCA['pages']['columns']['doktype']['config']['items'][$i];
}
for($i=$newPageTypeOrder; $i < count($TCA['pages']['columns']['doktype']['config']['items']); $i++) {
	$temp[$i+1] = $TCA['pages']['columns']['doktype']['config']['items'][$i];
}
$temp[$newPageTypeOrder] = array ('0' => "LLL:EXT:".$_EXTKEY."/locallang_db.xml:tx_gcblog_post",
									'1' => $newPageTypeId);
$TCA['pages']['columns']['doktype']['config']['items'] = $temp;
ksort($TCA['pages']['columns']['doktype']['config']['items']);
$PAGES_TYPES[$newPageTypeId] = Array('icon' => "EXT:".$_EXTKEY."/icon_tx_gcblog_post.gif",
									'allowedTables' => '*',);
$TCA['pages']['types'][$newPageTypeId]['showitem'] = '--palette--;LLL:EXT:cms/locallang_tca.xml:pages.palettes.standard;standard, tx_gcblog_category;LLL:EXT:gc_blog/locallang_db.xml:tx_gcblog_category,--palette--;LLL:EXT:gc_blog/locallang_tca.xml:pages.postInfo;postInfo, --palette--;LLL:EXT:cms/locallang_tca.xml:pages.palettes.title;title, --div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access, --palette--;LLL:EXT:cms/locallang_tca.xml:pages.palettes.visibility;visibility, --palette--;LLL:EXT:cms/locallang_tca.xml:pages.palettes.access;access, --div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.metadata, --palette--;LLL:EXT:cms/locallang_tca.xml:pages.palettes.abstract;abstract, --palette--;LLL:EXT:cms/locallang_tca.xml:pages.palettes.metatags;metatags, --palette--;LLL:EXT:cms/locallang_tca.xml:pages.palettes.editorial;editorial, --div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.appearance, --palette--;LLL:EXT:cms/locallang_tca.xml:pages.palettes.layout;layout, --palette--;LLL:EXT:cms/locallang_tca.xml:pages.palettes.module;module, --palette--;LLL:EXT:cms/locallang_tca.xml:pages.palettes.replace;replace, --div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.behaviour, --palette--;LLL:EXT:cms/locallang_tca.xml:pages.palettes.links;links, --palette--;LLL:EXT:cms/locallang_tca.xml:pages.palettes.caching;caching, --palette--;LLL:EXT:cms/locallang_tca.xml:pages.palettes.language;language, --palette--;LLL:EXT:cms/locallang_tca.xml:pages.palettes.miscellaneous;miscellaneous, --div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.resources, --palette--;LLL:EXT:cms/locallang_tca.xml:pages.palettes.media;media, --palette--;LLL:EXT:cms/locallang_tca.xml:pages.palettes.storage;storage, --palette--;LLL:EXT:cms/locallang_tca.xml:pages.palettes.config;config, --div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended';
$TCA['pages']['palettes']['postInfo'] = array(
	'showitem' => '  tx_gcblog_tag;LLL:EXT:gc_blog/locallang_db.xml:tx_gcblog_tag, --linebreak--, tx_gcblog_blockComment;LLL:EXT:gc_blog/locallang_db.xml:tx_gcblog.blockComment'
	);

t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gc_blog/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


// Adding flexform
$TCA["tt_content"]["types"]["list"]["subtypes_addlist"][$_EXTKEY."_pi1"]="pi_flexform"; 
t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:'.$_EXTKEY.'/pi1/flexform.xml');
?>
