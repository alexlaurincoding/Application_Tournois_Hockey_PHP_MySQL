<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Html
 *
 * @author moumene
 */
class Html {
    public static function getLinkToAction($link,$controlleur='Home',$action='Index',
            $attributs=array(),$queryString=NULL){
        $url = Util::PATH()."/$controlleur/$action";
        if ($queryString!=NULL) {
            $url .= "?$queryString";
        }
        $s = "<a href='$url'";
        foreach ($attributs as $attr => $val) {
            $s .= " $attr='$val'";
        }
        $s .= ">".$link."</a>";
        return $s;
    }
}
