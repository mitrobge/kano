<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

function smarty_modifier_highlight($content, $search) {
        if(is_array($search)){
            foreach ( $search as $word )
            {
                $content = str_ireplace($word, '<mark style="background-color:#FFCCCC;">'.$word.'</mark>', $content);
            }
        } else {
            $content = str_ireplace($search, '<mark style="background-color:#FFCCCC;">'.$search.'</mark>', $content);
        }
        return $content;
}

?>
