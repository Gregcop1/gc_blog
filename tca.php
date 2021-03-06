<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_gcblog_category'] = array (
	'ctrl' => $TCA['tx_gcblog_category']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,hidden,starttime,endtime,title'
	),
	'feInterface' => $TCA['tx_gcblog_category']['feInterface'],
	'columns' => array (
		'sys_language_uid' => array (
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l10n_parent' => array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_gcblog_category',
				'foreign_table_where' => 'AND tx_gcblog_category.pid=###CURRENT_PID### AND tx_gcblog_category.sys_language_uid IN (-1,0)',
			)
		),
		'l10n_diffsource' => array (
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'hidden' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'starttime' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'default'  => '0',
				'checkbox' => '0'
			)
		),
		'endtime' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'checkbox' => '0',
				'default'  => '0',
				'range'    => array (
					'upper' => mktime(3, 14, 7, 1, 19, 2038),
					'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
				)
			)
		),
		'title' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:gc_blog/locallang_db.xml:tx_gcblog.category.title',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		'parent_category' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:gc_blog/locallang_db.xml:tx_gcblog.category.parent_category',
			'config' => Array (
				'type' => 'select',
				'form_type' => 'user',
				'userFunc' => 'tx_gclib_TCAform_selectTree->renderTreeFields',
				'foreign_table' => 'tx_gcblog_category',
				'back' => 'tx_gcblog_category',
				'labelField' => 'title',
				'parentField' => 'parent_category',
				'autoSizeMax' => 50,
				'minitems' => 0,
				'maxitems' => 500,

			)
		),
		'page' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:gc_blog/locallang_db.xml:tx_gcblog.category.page',
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => '1',
				'maxitems' => '1',
				'minitems' => '0',
				'show_thumbs' => '1'
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title;;;;2-2-2,parent_category;;;;2-2-2,page;;;;2-2-2')
	),
	'palettes' => array (
		'1' => array('showitem' => 'starttime, endtime')
	)
);

$TCA['tx_gcblog_tag'] = array (
	'ctrl' => $TCA['tx_gcblog_tag']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,hidden,title'
	),
	'feInterface' => $TCA['tx_gcblog_tag']['feInterface'],
	'columns' => array (
		'sys_language_uid' => array (
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l10n_parent' => array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_gcblog_tag',
				'foreign_table_where' => 'AND tx_gcblog_tag.pid=###CURRENT_PID### AND tx_gcblog_tag.sys_language_uid IN (-1,0)',
			)
		),
		'l10n_diffsource' => array (
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'hidden' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'title' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:gc_blog/locallang_db.xml:tx_gcblog.tag.title',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title;;;;2-2-2')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);

$TCA['tx_gcblog_comment'] = array (
	'ctrl' => $TCA['tx_gcblog_comment']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,author,email,website,comment,parent_comment,remote_addr'
	),
	'feInterface' => $TCA['tx_gcblog_comment']['feInterface'],
	'columns' => array (
		'hidden' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'author' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:gc_blog/locallang_db.xml:tx_gcblog.comment.author',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		'email' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:gc_blog/locallang_db.xml:tx_gcblog.comment.email',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		'website' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:gc_blog/locallang_db.xml:tx_gcblog.comment.website',
			'config' => array (
				'type' => 'input',
				'size' => '30',
			)
		),
		'comment' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:gc_blog/locallang_db.xml:tx_gcblog.comment.comment',
			'config' => array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
				'wizards' => Array(
					'_PADDING' => 4,
					'RTE' => Array(
						'notNewRecords' => 1,
						'RTEonly' => 1,
						'type' => 'script',
						'title' => 'LLL:EXT:cms/locallang_ttc.php:bodytext.W.RTE',
						'icon' => 'wizard_rte2.gif',
						'script' => 'wizard_rte.php',
					),
				)
			)
		),
		'parent_comment' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:gc_blog/locallang_db.xml:tx_gcblog.comment.parent_comment',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_gcblog_comment',
				'autoSizeMax' => 50,
				'minitems' => 0,
				'maxitems' => 1,
				'items' => Array(
					Array('',0)
				),
				'readOnly' => 1,

			)
		),
		'remote_addr' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:gc_blog/locallang_db.xml:tx_gcblog.comment.remote_addr',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'readOnly' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1, author;;;;2-2-2, email;;;;2-2-2, website;;;;2-2-2, comment;;2;richtext:rte_transform[flag=rte_enabled|mode=ts];;;;2-2-2, parent_comment;;;;2-2-2, remote_addr;;;;2-2-2')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>