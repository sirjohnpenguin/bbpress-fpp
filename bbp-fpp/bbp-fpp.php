<?php
/**
* Plugin Name: bbpress-fpp
* Plugin URI: https://github.com/sirjohnpenguin/bbpress-fpp
* Description: Change maximun forums per page in bbPress
* Version: 1.0.0
* Author: Nicolás
* Author URI: https://github.com/sirjohnpenguin/bbpress-fpp
* License: GPL2
*/


if ( is_admin() ){

add_action( 'admin_menu', 'bbp_fpp_add_admin_menu' );
add_action( 'admin_init', 'bbp_fpp_settings_init' );

}

function bbp_fpp_add_admin_menu(  ) { 

	add_options_page( 'bbp-fpp', 'bbp-fpp', 'manage_options', 'bbp-fpp', 'bbp_fpp_options_page' );

}


function bbp_fpp_settings_init(  ) { 

	register_setting( 'pluginPage', 'bbp_fpp_settings' );

	add_settings_section(
		'bbp_fpp_pluginPage_section', 
		__( 'bbPress forums per page', 'wordpress' ), 
		'bbp_fpp_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'bbp_fpp_text_field_0', 
		__( 'Forums per page (ex: 100)', 'wordpress' ), 
		'bbp_fpp_text_field_0_render', 
		'pluginPage', 
		'bbp_fpp_pluginPage_section' 
	);


}


function bbp_fpp_text_field_0_render(  ) { 

	$options = get_option( 'bbp_fpp_settings' );
	?>
	<input type='text' name='bbp_fpp_settings[bbp_fpp_text_field_0]' value='<?php echo $options['bbp_fpp_text_field_0']; ?>'>
	<?php

}


function bbp_fpp_settings_section_callback(  ) { 

	echo __( 'Change max forums per page', 'wordpress' );

}


function bbp_fpp_options_page(  ) { 
$fpp_number = get_option( 'bbp_fpp_settings' );

if ($fpp_number["bbp_fpp_text_field_0"] == ""){
	//echo "NADA";
    $default_options = array('bbp_fpp_text_field_0' => '150' );
	update_option( 'bbp_fpp_settings', $default_options );
	
}


//echo $fpp_number["bbp_fpp_text_field_0"];


	?>
	<form action='options.php' method='post'>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

	</form>
	<?php

}





// forums per page bbpress 


add_filter ('bbp_before_has_forums_parse_args', 'rew_number_of_forums') ;

function rew_number_of_forums ($args) {
	$fpp_number = get_option( 'bbp_fpp_settings' );

	if ($fpp_number["bbp_fpp_text_field_0"] == ""){
		$default_options = array('bbp_fpp_text_field_0' => '150' );
		update_option( 'bbp_fpp_settings', $default_options );
		
	}
	$args['posts_per_page'] = $fpp_number["bbp_fpp_text_field_0"];
return $args ;
}

?>
