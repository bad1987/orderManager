<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// application/config/bootstrap_pagination.php
// $config['pagination']['full_tag_open'] = '<ul class="pagination pagination-small pagination-centered list-inline">';
// $config['pagination']['full_tag_close'] = '</ul>';
// $config['pagination']['first_tag_open'] = '<li class="list-inline-item">';
// $config['pagination']['first_tag_close'] = '</li>';
// $config['pagination']['last_tag_open'] = '<li class="list-inline-item">';
// $config['pagination']['last_tag_close'] = '</li>';
// $config['pagination']['next_tag_open'] = '<li class="list-inline-item">';
// $config['pagination']['next_tag_close'] = '</li>';
// $config['pagination']['prev_tag_open'] = '<li class="list-inline-item">';
// $config['pagination']['prev_tag_close'] = '</li>';
// $config['pagination']['cur_tag_open'] = '<li class="disabled"><span>';
// $config['pagination']['cur_tag_close'] = '</span></li>';
// $config['pagination']['num_tag_open'] = '<li class="list-inline-item">';
// $config['pagination']['num_tag_close'] = '</li>';

 // $config['pagination']['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
 // $config['pagination']['full_tag_close'] = '</ul></nav></div>';
 // $config['pagination']['num_tag_open'] = '<li class="page-item"><span class="page-link">';
 // $config['pagination']['num_tag_close'] = '</span></li>';
 // $config['pagination']['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
 // $config['pagination']['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
 // $config['pagination']['next_tag_open'] = '<li class="page-item"><span class="page-link">';
 // $config['pagination']['next_tag_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
 // $config['pagination']['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
 // $config['pagination']['prev_tag_close'] = '</span></li>';
 // $config['pagination']['first_tag_open'] = '<li class="page-item"><span class="page-link">';
 // $config['pagination']['first_tag_close'] = '</span></li>';
 // $config['pagination']['last_tag_open'] = '<li class="page-item"><span class="page-link">';
 // $config['pagination']['last_tag_close'] = '</span></li>'

$config['pagination_config'] = array(
    'full_tag_open' => '<nav aria-label="Page navigation example" style="clear:both;"><ul class="pagination">',
    'full_tag_close' => '</ul></nav>',
    'num_tag_open' => '<li class="page-item"><span class="page-link">',
    'num_tag_close' => '</span></li>',
    'cur_tag_open' => '<li class="page-item active"><a class="page-link" href="#">',
    'cur_tag_close' => '</a></li>',
    'prev_tag_open' => '<li class="page-item"><span class="page-link">',
    'prev_tag_close' => '</span></li>',
    'next_tag_open' => '<li class="page-item"><span class="page-link">',
    'next_tag_close' => '</span></li>',
    'prev_link' => '<i class="icon-backward"></i>',
    'next_link' => '<i class="icon-forward"></i>',
    'last_tag_open' => '<li class="page-item"><span class="page-link">',
    'last_tag_close' => '</span></li>',
    'first_tag_open' => '<li class="page-item"><span class="page-link">',
    'first_tag_close' => '</span></li>',
    // 'display_pages' => FALSE,
    'next_link' => 'Suivant',
    'prev_link' => 'Precedent',
    'first_link' => 'Debut',
    'last_link' => 'Fin',
    );
?>