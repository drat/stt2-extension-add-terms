<?php
if ( ! defined( 'ABSPATH' ) ) exit;
function stt2extat_get_search_terms_db_callback() {
    $id =  $_POST["id"];
    $nonce = $_REQUEST['wpnonce'];

    if ( ! wp_verify_nonce( $nonce, 'stt2extat_action' ) ) 
       wp_die( __( 'Security check' ) );

    if (wp_verify_nonce( $nonce, 'stt2extat_action' )  && check_admin_referer( 'stt2extat_action', 'wpnonce' ) ) 
        stt2extat_search_terms_list($id,$nonce);
	wp_die();
}
add_action('wp_ajax_stt2extat_get_search_terms_db_list', 'stt2extat_get_search_terms_db_callback');