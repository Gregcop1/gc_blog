<?php

class user_gcblog_utils {
    var $cObj;

    function init() {
        $this->cObj = t3lib_div::makeInstance("tslib_cObj");
        $this->config = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_gcblog_pi1.']['config.'];
    }

    function end($content, $conf) {
        return $content ? $this->cObj->stdWrap($content, $conf) : '';
    }

    function getCatList($content, $conf) {
        $this->init();
        $cont = '';

        if($content!='') {
            $cats = explode(',', $content);
            if(count($cats)) {
                foreach($cats as $item) {
                    $cat = $GLOBALS['TSFE']->gc_blog['category'][$item];
                    if($cont!='') {
                        $cont .= $conf['separator'];
                    }

                    $link = '';
                    if($cat['page']){
                        $link = $cat['page'];
                    }elseif ($this->config['listPage']){
                        $link = $this->config['listPage'];
                    }

                    $cont .= $this->cObj->stdWrap($cat['title'],
                        array(
                            'typolink.' => array(
                                'parameter' => $link,
                                'additionalParams' => '&tx_gcblog_pi1[category]='.$cat['uid']
                            )
                        ));
                }
            }
        }

        return $this->end($cont, $conf);
    }

    function getTagList($content, $conf) {
        $this->init();
        $cont = '';

        if($content!='') {
            $tags = explode(',', $content);
            if(count($tags)) {
                foreach($tags as $item) {
                    $tag = $GLOBALS['TSFE']->gc_blog['tag'][$item];
                    if($cont!='') {
                        $cont .= $conf['separator'];
                    }

                    $link = '';
                    if ($this->config['listPage']){
                        $link = $this->config['listPage'];
                    }

                    $cont .= $this->cObj->stdWrap($tag['title'],
                        array(
                            'typolink.' => array(
                                'parameter' => $link,
                                'additionalParams' => '&tx_gcblog_pi1[tag]='.$tag['uid']
                            )
                        ));
                }
            }
        }

        return $this->end($cont, $conf);
    }

    function getClasses($content, $conf) {
        $this->init();

        $tags = explode(',', $content);
        $cont = '';
        if(count($tags)) {
            foreach($tags as $item) {
                $cont .= ' '.$conf['classPrefix'].$item;
            }
        }

        return $this->end($cont, $conf);
    }
}

?>