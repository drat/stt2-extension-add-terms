<?php
if ( ! defined( 'ABSPATH' ) ) exit;
function pk_stt2_admin_delete_searchterms_extat_callback(){
    $nonce = $_REQUEST['wpnonce'];
    if ( ! wp_verify_nonce( $nonce, 'stt2extat_action' )) {
       wp_die( __( '<div id="message" class="error"><p>Fail to delete! Try to reload your page.</p></div>' ) );
    }
	if (wp_verify_nonce( $nonce, 'stt2extat_action' )  && check_admin_referer( 'stt2extat_action', 'wpnonce' ) ) {
    pk_stt2_admin_delete_searchterms();
	}
    wp_die();
}
add_action('wp_ajax_pk_stt2_admin_delete_searchterms', 'pk_stt2_admin_delete_searchterms_extat_callback');