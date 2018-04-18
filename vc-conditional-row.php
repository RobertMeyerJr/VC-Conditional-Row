<?php 
/*
Plugin Name: VC Conditional Row
Author: Robert Meyer Jr
Description: Conditionally Show Visual Composer Row based on URL parameter Value
Version: 0.5
*/

if( function_exists('vc_add_param') ){	
	$vc_conditional_row = new VCConditionalRow();
}

class VCConditionalRow{
	public function __construct(){
		add_action('init', 					[$this,'init']);
		add_filter('shortcode_atts_vc_row', [$this, 'visibility']);
	}
	public function init(){		
		$settings = array(
			array(
				'group' 		=> 'URL Param Visibility',
				'type' 			=> 'textfield',
				'heading' 		=> 'Parameter Name',
				'param_name' 	=> 'vccr_show_param_name',
				'description' 	=> 'Name of URL parameter to Check',				
			),
			array(				
				'group' 		=> 'URL Param Visibility',
				'type'			=> 'textfield',
				'heading'		=> 'Parameter Value',
				'param_name' 	=> 'vccr_show_param_value',
				'description' 	=> 'Value of URL parameter when Row should be visible. (Leave empty for Default)',
			),
		);
		vc_add_params('vc_row', $settings);		
	}
	
	public function visibility($atts){
		if( isset( $atts['vccr_show_param_name'] ) && !empty($atts['vccr_show_param_name']) ){
			$name = $atts['vccr_show_param_name'];
			#If param name is set, but no value then it is the default
			if( empty($atts['vccr_show_param_value']) ){
				if( !empty($_GET[ $name ]) ){
					$atts['disable_element'] = 'yes';				
				}
			}
			else{			
				$value = $atts['vccr_show_param_value'];				
				if(!isset($_GET[ $name ]) || isset($_GET[ $name ]) && $_GET[ $name ] != $value ){				
					$atts['disable_element'] = 'yes';				
				}	
			}			
		}
		
		return $atts;
	}
}


