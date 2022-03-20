<?php
global $post;
$mv_slider_name = get_post_meta( $post->ID, 'mv_slider_name', true );
?>
<table class="form-table mv-slider-metabox">
    <input type="hidden" name="mv_slider_nonce" value="<?php echo wp_create_nonce('mv_slider_nonce')?>">
    <tr>
        <th>
            <label for="mv_slider_name">Slider Name</label>
        </th>
        <td>
            <input
                type="text"
                name="mv_slider_name"
                id="mv_slider_name"
                class="regular-text link-text"
                value="<?php echo $mv_slider_name ?>"
                required
            >
        </td>
    </tr>
</table>