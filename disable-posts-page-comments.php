<?php
/**
 * Plugin Name: Disable Posts/Page Comments
 * Description: Desabilita comentários, posts e páginas, deixando apenas Custom Post Types no dashboard.
 * Version: 1.0
 * Author: Rangel
 */

// Aqui você adiciona os códigos fornecidos anteriormente
// Desabilitar suporte a comentários
function wpdev_disable_comments_post_types_support() {
    remove_post_type_support('post', 'comments');
    remove_post_type_support('page', 'comments');
}
add_action('admin_init', 'wpdev_disable_comments_post_types_support');

// Fechar comentários em mídias
function wpdev_disable_comments_status() {
    return false;
}
add_filter('comments_open', 'wpdev_disable_comments_status', 20, 2);
add_filter('pings_open', 'wpdev_disable_comments_status', 20, 2);

// Esconder seções existentes de comentários
function wpdev_disable_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'wpdev_disable_comments_admin_menu');

// Redirecionar qualquer usuário tentando acessar a página de comentários
function wpdev_disable_comments_admin_menu_redirect() {
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }
}
add_action('admin_init', 'wpdev_disable_comments_admin_menu_redirect');

// Remover comentários do dashboard
function wpdev_disable_comments_dashboard() {
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'wpdev_disable_comments_dashboard');

function wpdev_remove_menus(){
  
    // Remover Posts
    remove_menu_page('edit.php');
    
    // Remover Páginas
    remove_menu_page('edit.php?post_type=page');
    
    // Adicione aqui qualquer outro tipo de post que deseja remover
  }
  add_action('admin_menu', 'wpdev_remove_menus');

  function remove_items_from_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_node('new-content');
    $wp_admin_bar->remove_node('comments');
}
add_action('wp_before_admin_bar_render', 'remove_items_from_admin_bar');
