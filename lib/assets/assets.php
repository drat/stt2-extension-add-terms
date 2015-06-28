<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function stt2extat_admin_enqueu_scripts() {
	global $stt2extat_settings, $wp_version, $tinymce_version, $concatenate_scripts, $compress_scripts;
	
	if ( ! isset( $concatenate_scripts ) ) {
			script_concat_settings();
		}
	
	$compressed =
			$compress_scripts &&
			$concatenate_scripts &&
			isset( $_SERVER['HTTP_ACCEPT_ENCODING'] ) &&
			false !== stripos( $_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || file_exists( dirname( __FILE__ ) . '/.gitignore' ) ? '' : '.min';
	$mce_suffix = false !== strpos( $wp_version, '-src' ) ? '' : '.min';
	
	$compressed =
			$compress_scripts &&
			$concatenate_scripts &&
			isset( $_SERVER['HTTP_ACCEPT_ENCODING'] ) &&
			false !== stripos( $_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip' );

		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || file_exists( dirname( __FILE__ ) . '/.gitignore' ) ? '' : '.min';
			$mce_suffix = false !== strpos( $wp_version, '-src' ) ? '' : '.min';

			if ( $compressed ) {
				wp_enqueue_script( 'stt2extat-tinymce', includes_url( 'js/tinymce' ) . '/wp-tinymce.php?c=1', array(), $tinymce_version, true );
			} else {
				wp_enqueue_script( 'stt2extat-tinymce', includes_url( 'js/tinymce' ) . '/tinymce' . $mce_suffix . '.js', array(), $tinymce_version, true );
				wp_enqueue_script( 'stt2extat-tinymce-compat3x', includes_url( 'js/tinymce' ) . '/plugins/compat3x/plugin' . $suffix . '.js', array( 'stt2extat-tinymce' ), $tinymce_version, true );
			}

    $currentscreen = get_current_screen();
    $stt2screen = searchterms_tagging2_screen_id();
    $plugin_url = plugin_dir_url( __FILE__ );
    $includes_url = includes_url('/css/editor.min.css');
	$nonce = wp_create_nonce('stt2extat_action');
	$maxchar = $stt2extat_settings['stt2extat_max_char'];
    if($currentscreen->id == $stt2screen ) :
		wp_enqueue_script( 'jquery-stt2extat', $plugin_url . 'js/jquery-stt2extat.js' , array('jquery'),STT2EXTAT_VER,true );
		wp_enqueue_script( 'googlesuggest-stt2extat', $plugin_url . 'js/jquery-google-suggest-autocomplete.js', array('jquery'),STT2EXTAT_VER,true );
		wp_enqueue_script( 'jquery-ui', $plugin_url . 'js/jquery-ui.min.js', array('jquery'),STT2EXTAT_VER,true );
		wp_enqueue_style( 'jqui',$plugin_url . 'css/jquery-ui.min.css',array('editor-styles'),STT2EXTAT_VER,false );
		wp_enqueue_style( 'editor-styles',$includes_url);
		wp_enqueue_script('postbox');
		wp_localize_script('jquery-stt2extat', 'stt2extatL10n',
        array(
            1 => $nonce,
			2 => __( 'Remove Irrelevant Search Terms' ),
			3 => __( 'Incoming search terms: Empty!' ),
			4 => __( 'Oops! Fail to update' ),
			5 => __( 'Contain Badwords!' ),
			6 => __( 'Preview:' ),
			7 => __( 'Irrelevant!' ),
			8 => __( 'Oops! No Post Selected!' ),
			9 => __( 'Oops! No Terms Input!' ),
			10 => __( 'Olala.. you don&#39;t have permission' ),
			11 => __( 'Oops! Error!.' ),
			12 => __( 'No results found' ),
			13 => __( '...' ),
			14 => __( 'Remove' ),
			15 => __( 'Add' ),
			16 => __( 'Too Short. Min 4 character (A-Z,a-z,0-9)' ),
			17 => __( 'Too Long. Max {$maxchar} character (A-Z,a-z,0-9)' ),
			18 => __( 'Success add to field' ),		
			19 => __( 'Your browser does not support for this plugin! Compatible for latest version Firefox, Safari, or Chrome.' ),
			20 => __( 'Collapse Tab' ),
			21 => $maxchar,
			22 => __( 'Success Updated!' ),
			23 => __( 'Loading...' ),
            )
	    );
	
		$bgspinner = '"'.admin_url( '/images/spinner.gif').'"';
		$stt2extat_css = '
							input.ui-autocomplete-loading {
							  background: url('.$bgspinner.') center right no-repeat;
							}

							#searchtermpost {
							  padding: 10px 0;
							}

							#wp-link .link-search-wrapper span.existlink {
							  position: relative;
							  float: right;
							  font: 400 20px/1 dashicons;
							  speak: none;
							  padding: 0;
							  -webkit-font-smoothing: antialiased;
							  -moz-osx-font-smoothing: grayscale;
							  background-image: none!important;
							  margin: 0;
							}

							span.existlink:before {
							  text-decoration: none;
							  content: "\f139";
							}

							#gsuggestPopup,#notmatchfeatPopup,#brocatPopup,#thehint,#screen-meta-links,#fullpost,#loading {
							  display: none;
							}

							.postbox .inside.stt2-extat {
							  margin: 0;
							}

							#stt2extat-form {
							  width: 100%;
							  display: table;
							}

							.more {
							  font-size: 41px;
							  color: #ccc;
							  text-align: center;
							  width: 100%;
							  display: inline-block;
							  margin: 0;
							  padding: 0;
							}

							i.termlist:hover,i.termcnt:hover,.more:hover,.view-fullpost:hover,.alltag:hover {
							  color: #0073aa;
							  cursor: pointer;
							}

							a i.dashicons {
							  text-decoration: none;
							}

							.termadd,.closebtn {
							  float: left;
							}

							#ins-btn {
							  line-height: 27px;
							}

							#loading {
							  position: fixed;
							  width: 300px;
							  height: 20px;
							  z-index: 1000;
							  background-color: #ffd700;
							  left: 50%;
							  top: 40px;
							  padding: 5px;
							  text-align: center;
							  border-radius: 4px;
							  font-weight: 600;
							  box-shadow: 1px 6px 6px 0px #ccc;
							  z-index: 2;
							}

							.key-inline {
							  padding: 5px;
							  background: #f5f5f5;
							  color: #0073aa;
							  position: absolute;
							  display: none;
							  padding: 5px;
							  border-radius: 2px;
							  line-height: 21px;
							  margin-bottom: 8px;
							  border: 1px solid #0073aa;
							}

							.btn-key {
							  float: right;
							  margin-left: 4px !important;
							}

							.key {
							  text-decoration: underline;
							  padding: 0 2px 0 2px;
							}

							div.key-inline.key-inline-active {
							  transition: top 0.1s ease-out,
									left 0.1s ease-out,
									opacity 0.1s ease-in-out;
							  opacity: 1;
							}

							.key-inline.key-arrow-up:before,.key-inline.key-arrow-up:after,.key-inline.key-arrow-down:before,.key-inline.key-arrow-down:after {
							  position: absolute;
							  left: 50%;
							  display: block;
							  width: 0;
							  height: 0;
							  border-style: solid;
							  border-color: transparent;
							  content: "";
							}

							.key-inline.key-arrow-down:before,.key-inline.key-arrow-up:before {
							  border-width: 9px;
							  margin-left: -9px;
							}

							.key-inline.key-arrow-down:after,.key-inline.key-arrow-up:after {
							  border-width: 8px;
							  margin-left: -8px;
							}

							.key-inline.key-arrow-down:before {
							  bottom: -18px;
							  border-top-color: #0073aa;
							}

							.key-inline.key-arrow-down:after {
							  bottom: -16px;
							  border-top-color: #f5f5f5;
							}

							.key-inline.key-arrow-up:before {
							  top: -18px;
							  border-bottom-color: #0073aa;
							}

							.key-inline.key-arrow-up:after {
							  top: -16px;
							  border-bottom-color: #f5f5f5;
							}

							.contextual-help-sidebar {
							  word-wrap: break-word;
							}

							#stt2extat-form a:focus {
							  box-shadow: none;
							}

							#tog {
							  z-index: 1;
							  position: absolute;
							  top: 170px;
							  left: -137px;
							  color: #ddd;
							  cursor: pointer;
							}

							#tog:hover {
							  color: #0073aa;
							}

							.tab-arrow-right:before,.tab-arrow-right:after,.tab-arrow-left:before,.tab-arrow-left:after {
							  width: 0;
							  height: 0;
							  border-style: solid;
							  border-color: transparent;
							  content: "";
							  display: block;
							  top: 0;
							  z-index: -1;
							  position: absolute;
							  border-width: 8px;
							}

							.tab-arrow-left:before {
							  border-left-color: #e1e1e1;
							  left: 137px;
							}

							.tab-arrow-left:hover:before {
							  border-left-color: #00A0D2;
							}

							.tab-arrow-left:after {
							  border-left-color: #FFF;
							  left: 136px;
							}

							.tab-arrow-right:before {
							  border-right-color: #e1e1e1;
							  left: 120px;
							}

							.tab-arrow-right:after {
							  border-right-color: #F6FBFD;
							  left: 121px;
							}
							';
        wp_add_inline_style( 'editor-styles', $stt2extat_css );
        add_thickbox();
    endif;
}

function stt2extat_inline_js() {
   $currentscreen = get_current_screen();
   $stt2screen = searchterms_tagging2_screen_id();
	
   if($currentscreen->id == $stt2screen ) :
   delete_option('stt2exat_admin_notice_goto');
   stt2extat_footer();
?>
<script type="text/javascript">
jQuery(document).ready(function($) {
var tb_pathToImage = thickboxL10n.loadingAnimation,
	idForm = "stt2extat-form";
 	imgLoader = new Image();
	imgLoader.src = tb_pathToImage;
    $("div.wrap > div.postbox-container:last").before($('<div>',{id:idForm,html:$('<img>',{src: imgLoader.src,width: 208})}));
    data = {action: 'stt2extat_action',stt2extat_nonce: stt2extatL10n[1],};
	$.post(ajaxurl, data, function(response) {
		$("#"+idForm).html(response);
		$.stt2extat.extatTab();
		$.stt2extat.searchPost();
		$.stt2extat.insertTerm();
		$(".if-js-closed").removeClass("if-js-closed").addClass("closed");
		postboxes.add_postbox_toggles( "apmbt");
	});
});
</script>
<?php 
endif;
}
?>