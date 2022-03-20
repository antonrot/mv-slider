<?php

if (!class_exists('MV_Slider_Post_Type')) {

    class MV_Slider_Post_Type
    {

        function __construct()
        {
            add_action('init', [$this, 'create_post_type']);
            add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
            add_action('save_post', [$this, 'save_post'], 10, 2);
            add_filter('manage_mv-slider_posts_columns', [$this, 'mv_slider_cpt_columns']);
            add_action('manage_mv-slider_posts_custom_column', [$this, 'mv_slider_custom_columns'], 10, 2);
            add_filter('manage_edit-mv-slider_sortable_columns', [$this, 'mv_slider_sortable_columns']);
        }

        public function mv_slider_custom_columns($column, $post_id)
        {
            switch ($column) {
                case 'mv_slider_link_text':
                    echo esc_html(get_post_meta($post_id, 'mv_slider_link_text', true));
                    break;
                case 'mv_slider_link_url':
                    echo esc_url(get_post_meta($post_id, 'mv_slider_link_url', true));
                    break;
                case 'mv_slider_name':
                    echo esc_html(get_post_meta($post_id, 'mv_slider_name', true));
                    break;
            }
            return $column;
        }

        public function mv_slider_sortable_columns($columns)
        {
            $columns['mv_slider_name'] = 'mv_slider_name';
            return $columns;
        }


        public function mv_slider_cpt_columns($columns)
        {
            $columns['mv_slider_link_text'] = esc_html__('Link Text', 'mv-slider');
            $columns['mv_slider_link_url'] = esc_html__('Link URL', 'mv-slider');
            $columns['mv_slider_name'] = esc_html__('Slider Name', 'mv-slider');
            return $columns;
        }

        public function create_post_type()
        {
            register_post_type(
                'mv-slider',
                [
                    'label' => 'Slider',
                    'description' => 'Sliders',
                    'labels' => [
                        'name' => 'Sliders',
                        'singular_name' => 'Slider'
                    ],
                    'public' => true,
                    'supports' => ['title', 'editor', 'thumbnail'],
                    'hierarchical' => false,
                    'show_ui' => true,
                    'show_in_menu' => false,
                    'menu_position' => 5,
                    'show_in_admin_bar' => true,
                    'show_in_nav_menus' => true,
                    'can_export' => true,
                    'has_archive' => false,
                    'exclude_from_search' => false,
                    'publicly_queryable' => true,
                    'show_in_rest' => true,
                    'menu_icon' => 'dashicons-images-alt2',
                    //'register_meta_box_cb'  =>  array( $this, 'add_meta_boxes' )
                ]
            );
        }

        public function add_meta_boxes()
        {
            add_meta_box(
                'mv_slider_meta_box',
                'Link Options',
                [$this, 'add_inner_meta_boxes'], // callback that contains a form for metabox.
                'mv-slider',
                'normal',
                'high'
            );

            add_meta_box(
                'mv_slider_meta_box_slider_name',
                'Slider Name',
                [$this, 'add_inner_meta_boxes_slider_name_form'], // callback that contains a form for metabox.
                'mv-slider',
                'normal',
                'high'
            );
        }

        public function add_inner_meta_boxes($post)
        {
            require_once(MV_SLIDER_PATH . 'views/mv-slider_metabox.php');
        }

        public function add_inner_meta_boxes_slider_name_form(){
            require_once(MV_SLIDER_PATH . 'views/mv-slider_metabox_slider_name.php');
        }

        public function save_post($post_id)
        {

            if (isset($_POST['mv_slider_nonce'])) {
                if (!wp_verify_nonce($_POST['mv_slider_nonce'], 'mv_slider_nonce')) {
                    return;
                }
            }

            if (isset($_POST['action']) && $_POST['action'] == 'editpost') {

                $old_link_text = get_post_meta($post_id, 'mv_slider_link_text', true);
                $old_link_url = get_post_meta($post_id, 'mv_slider_link_url', true);
                $old_slider_name = get_post_meta($post_id, 'mv_slider_name', true);

                if (isset($_POST['mv_slider_link_text']) && !empty($_POST['mv_slider_link_text'])) {
                    $new_link_text = sanitize_text_field($_POST['mv_slider_link_text']);
                    update_post_meta($post_id, 'mv_slider_link_text', $new_link_text, $old_link_text);
                }

                if (isset($_POST['mv_slider_link_url']) && !empty($_POST['mv_slider_link_url'])) {
                    $new_link_url = sanitize_url($_POST['mv_slider_link_url']);
                    update_post_meta($post_id, 'mv_slider_link_url', $new_link_url, $old_link_url);
                }

                if (isset($_POST['mv_slider_name']) && !empty($_POST['mv_slider_name'])) {
                    $new_slider_name = sanitize_text_field($_POST['mv_slider_name']);
                    update_post_meta($post_id, 'mv_slider_name', $new_slider_name, $old_slider_name);
                }

            }
        }

    }
}