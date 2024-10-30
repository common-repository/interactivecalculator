<?php
  /**
   * Plugin Name: InteractiveCalculator
   * Plugin URI: https://www.interactivecalculator.com/wordpress-calculator-builder
   * Description: Add an InteractiveCalculator.com calculator on your WordPress website
   * Version: 1.0.1
   * Author: InteractiveCalculator
   * Author URI: https://www.interactivecalculator.com
   */

  if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

  function interactivecalculator_hook_javascript() {
    wp_enqueue_script("interactivecalculator-script", "https://embed.interactivecalculator.com/embed.js", array(), false, false);
  }

  add_action( 'wp_enqueue_scripts', 'interactivecalculator_hook_javascript' );
  
  function interactivecalculator_script_loader_tag($tag, $handle) {
	  if ($handle === 'interactivecalculator-script') {	  
      if (false === stripos($tag, 'async')) {
  		  $tag = str_replace(' src', ' async="async" src', $tag);
  	  }
  		
  		if (false === stripos($tag, 'defer')) {
  			$tag = str_replace('<script ', '<script defer ', $tag);
  		}
  	}
	
	 return $tag;
  }

  add_filter('script_loader_tag', 'interactivecalculator_script_loader_tag', 10, 2);

  function interactivecalculator_add_calculator($calculator_id) {
    echo embed_calculator(array('id' => $calculator_id));
  }

  function interactivecalculator_embed_calculator( $attrs ){
    if (!isset($attrs['id'])) {
      return '<div>You need to add an "id" to the "interactivecalculator" shortcode. You can find the calculator id in the <a href="https://www.interactivecalculator.com/app/">editor</a>.';
    }

    return '<span data-calculator-id="'. $attrs['id'] .'"></span><script data-calculator-id="'. $attrs['id'] .'"></script>';
  }

  add_shortcode( 'interactivecalculator', 'interactivecalculator_embed_calculator' );
?>