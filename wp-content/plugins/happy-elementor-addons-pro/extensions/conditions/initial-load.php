<?php

namespace Happy_Addons_Pro\Extensions\Conditions;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Browser
 * contain all element of browser condition
 * @package Happy_Addons_Pro\Extensions\Conditions
 */
class Initial_Load extends Condition {

	/**
	 * Get Condition Key
	 *
	 * @return string|void
	 */
	public function get_key_name () {
		return 'initial_load';
	}

	/**
	 * Get Condition Title
	 *
	 * @return string|void
	 */
	public function get_title () {
		return __( 'Initial Load', 'happy-addons-pro' );
	}

	/**
	 * Get Repeater Control Field Value
	 *
	 * @param array $condition
	 * @return array|void
	 */
	public function get_repeater_control ( array $condition ) {

		$default = date('d-m-Y', strtotime('+7 days'));
		return[
			'label' 		=> $this->get_title(),
			'show_label' 	=> false,
			'description' => __('Cookie auto remove after', 'happy-addons-pro'),
			'type' => Controls_Manager::DATE_TIME,
			'default' => $default,
			'label_block' => true,
			'picker_options' => [
				'enableTime'	=> false,
				'dateFormat' 	=> 'd-m-Y',
			],
			'condition'	=> $condition,
		];

	}

	/**
	 * Compare Condition value
	 *
	 * @param $settings
	 * @param $operator
	 * @param $value
	 * @return bool|void
	 */
	public function compare_value ( $settings, $operator, $value ) {
		$cookiearray = array();
		$to='';
		if(isset($settings['_ha_condition_to'])){
			$cookiearray[] = $settings['_ha_condition_to'];
			$to= $settings['_ha_condition_to'];
		}
		if(isset($settings['_ha_condition_relation'])){
			$cookiearray[] = $settings['_ha_condition_relation'];
		}
		if(isset($settings['_ha_time_zone'])){
			$cookiearray[] = $settings['_ha_time_zone'];
		}
		foreach($settings['_ha_condition_list'] as $key => $value){
			if($value['_ha_condition_key'] == $this->get_key_name() ){
				if(isset($value['_ha_condition_initial_load'])){
					$cookiearray[] = $value['_ha_condition_initial_load'];
				}
				if(isset($value['_ha_condition_operator'])){
					$cookiearray[] = $value['_ha_condition_operator'];
				}

				$expire_time = strtotime($value['_ha_condition_initial_load']);
				$cookie_name = "ha_initial_load_". get_the_ID()."_".$value['_id'];
				$cookie_value = "loaded";
				$today = hapro_get_server_time('d-m-Y');
				if( 'local' === $settings['_ha_time_zone'] ){
					$today = hapro_get_local_time('d-m-Y');
				}
				$today = strtotime($today);
				//if $today is equal to $expire_time or grater then $expire_time it return true otherwise false
				$result = ($today >= $expire_time );
				if(!$result){
					$cookiearray = implode(',', $cookiearray);
					$result = hapro_get_initial_load_cookie_value($cookie_name, $cookie_value,$expire_time,$cookiearray,$to);
				}
			}
		}
		return hapro_compare( $result, true, $operator );
	}
}
