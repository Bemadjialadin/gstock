<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\ObjetHtml;



/**
 * Form est une classe permetant de generer du code HTML a la volet
 *
 * @author ANF5-PC
 */
class Form {

    /**
     * 
     * @param String $type
     * @param String $name
     * @param String $id
     * @param String $label
     * @param String $value
     * @return void
     */
    public function input($type, $name, $value = null, $id = null, $class = null, $style = null , $list = null , $min = null) {

        if ($type == "radio" || $type == "checkbox") {
            echo"
            <input type='$type' name='$name' value='$value' id='$id' class = '$class'>
            ";
        } else if ($type == "submit" || $type == "reset") {
            echo"
            <input type='$type' name='$name' value='$value' id='$id' class = '$class' style = '$style'>
            ";
        } else {
            echo"
            <input list = '$list' type='$type' name='$name' value='$value' id='$id' class = '$class' min = '$min' > 
            ";
        }

    }

    /**
     * 
     * @param String $label
     * @param String $id
     * @param Integer $col
     * @param Integer $rows
     * @param String $value
     * @param String $plcHld
     * @return void
     */
    public function textArea($label, $id, $col, $rows, $value = "", $plcHld = "") {
        echo $this->label ($id, $label)
        . "<textarea id='$id' col='$col' rows='$rows' placehorlder='$plcHld'>$value</textarea>";

    }

    /**
     * 
     * @param String $id
     * @param String $type
     * @param String $value
     * @return void
     */
    public function buttonMake($url , $type, $value = "button", $class = null , $id = null) {
        echo "<a href = '$url' type='$type' class='$class' id = '$id'>$value</a>";

    }

    /**
     * 
     * @param String $for
     * @param String $labelText
     * @return void
     */
    public function label($for, $labelText,$class=null,$id=null) {
        echo"<label for='$for' id ='$id' class='$class'>$labelText :</label>";

    }

    /**
     * 
     * @param String $tagName
     * @param String $htmlCode
     * @return void
     */
    public function entourer($tagName, $htmlCode = null) {
        echo '<' . $tagName . '>' . $htmlCode . '</' . $tagName . '>';

    }

    /**
     * 
     * @param String $method
     * @param String $action
     * @return void
     */
    public function formOpen($method = 'post', $action = '.' , $class = null , $style = null) {
        echo"<form method='$method' action='$action' class = '$class' style = '$style'>";

    }

    /**
     * 
     * @param String $tagName nom de la balise a ouvrir grace a cette fonction
     * @param String $id l'identifiant de la balise
     * @param String $class la classe de la balise
     * @return void
     */
    public function openTag($tagName = 'html',$class = null , $style = null, $id = null) {
        echo"<$tagName ".(isset($id)?" id='".$id."'":"")." "
                .(isset($class)?"class='".$class."'":"")." "
                .(isset($style)?"style='".$style."'":"").">";

    }
    
    /**
     * 
     * @param type $name
     * @param type $class
     * @param type $style
     * @param type $id
     */
     public function select($name ,$class = null , $style = null, $id = null) {
        echo"<select name ='$name' ".(isset($id)?" id='".$id."'":"")." "
                .(isset($class)?"class='".$class."'":"")." "
                .(isset($style)?"style='".$style."'":"").">";

    }
    /**
     * 
     * @param type $tagName
     * @param type $src
     * @param type $class
     * @param type $alt
     * @param type $style
     * @param type $id
     */
    public function img($tagName = 'img', $src, $class = null, $alt = null , $style = nul , $id = null) {
        echo"<$tagName src='$src' ".(isset($id)?" id='".$id."'":"")." "
                .(isset($class)?"class='".$class."'":"")." "
                .(isset($style)?"style='".$style."'":"").""
                .(isset($alt)?"alt='".$alt."'":"").
               ">";

    }

    /**
     * 
     * @param String $tagName fonction permetant de fermer une balise HTML 
     * @return void
     */
    public function closeTag($tagName = 'html') {
        echo"</$tagName>";

    }

}
