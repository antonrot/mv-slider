<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <?php
        $active_tab = $_GET['tab'] ?? 'settings';
    ?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=mv_slider_settings&tab=settings" class="nav-tab <?php echo  $active_tab == 'settings' ? 'nav-tab-active' : ''?> ">Settings</a>
        <a href="?page=mv_slider_settings&tab=options" class="nav-tab <?php echo  $active_tab == 'options' ? 'nav-tab-active' : ''?> ">Options</a>
    </h2>
    <form action="options.php" method="post">
        <?php
        if ( $active_tab === 'settings' ) {
            settings_fields( 'mv-slider-group' );
            do_settings_sections( 'mv_slider_settings_page_1' );
        } else {
            settings_fields( 'mv-slider-group' );
            do_settings_sections( 'mv_slider_settings_page_2' );
            submit_button('Save Settings');
        }

        ?>
    </form>
</div>