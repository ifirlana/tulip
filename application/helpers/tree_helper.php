<?php 
function category_tree($tree){
    if(!is_array($tree)) return '';
    $output = '<ul>';
    foreach($tree as $node){
        $output .= '<li>';
        $output .= $node['item']->strnama_dealer;
        $output .= category_tree($node['child']);
        $output .= '</li>';
    }
    return $output . '</ul>';
}

?>