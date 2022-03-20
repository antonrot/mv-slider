<?php

if ( ! class_exists( 'MV_Slider_Shortcode')) {
    class MV_Slider_Shortcode {
        public function __construct() {
            add_shortcode( 'mv-slider', [ $this, 'mv_slider_shortcode']);
        }

        public function mv_slider_shortcode( $atts = [], $content = null, $tag = '' ) {
            $atts = array_change_key_case( (array) $atts, CASE_LOWER );

            extract( shortcode_atts(
                [
                    'slider_name' => '',
                    'order_by' => 'date'
                ],
                $atts
            ));

            if( ! empty($id) ) {
                $id = array_map('absint', explode(',', $id));
            }

            ob_start();
            require(MV_SLIDER_PATH . 'views/mv-slider_shortcode.php');
            return ob_get_clean();
        }
    }
}