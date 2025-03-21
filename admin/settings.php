<?php
if (!defined('ABSPATH')) {
    exit;
}

$options = get_option('construction_mode_settings');
?>

<div class="wrap">
    <h1><?php echo esc_html__('Construction Mode Settings', 'construction-mode'); ?></h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('construction_mode_settings');
        ?>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="construction_mode_enabled"><?php echo esc_html__('Enable Construction Mode', 'construction-mode'); ?></label>
                </th>
                <td>
                    <input type="checkbox" id="construction_mode_enabled" name="construction_mode_settings[enabled]" value="1" <?php checked(isset($options['enabled']) ? $options['enabled'] : false); ?> />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="construction_mode_title"><?php echo esc_html__('Page Title', 'construction-mode'); ?></label>
                </th>
                <td>
                    <input type="text" id="construction_mode_title" name="construction_mode_settings[title]" value="<?php echo esc_attr(isset($options['title']) ? $options['title'] : ''); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="construction_mode_description"><?php echo esc_html__('Description', 'construction-mode'); ?></label>
                </th>
                <td>
                    <textarea id="construction_mode_description" name="construction_mode_settings[description]" rows="5" class="large-text"><?php echo esc_textarea(isset($options['description']) ? $options['description'] : ''); ?></textarea>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="construction_mode_logo"><?php echo esc_html__('Logo', 'construction-mode'); ?></label>
                </th>
                <td>
                    <div class="logo-preview-wrapper">
                        <img id="logo-preview" src="<?php echo esc_url(isset($options['logo']) ? $options['logo'] : ''); ?>" style="max-width: 200px; <?php echo empty($options['logo']) ? 'display: none;' : ''; ?>">
                    </div>
                    <input type="hidden" id="construction_mode_logo" name="construction_mode_settings[logo]" value="<?php echo esc_attr(isset($options['logo']) ? $options['logo'] : ''); ?>" />
                    <button type="button" class="button" id="upload-logo"><?php echo esc_html__('Upload Logo', 'construction-mode'); ?></button>
                    <button type="button" class="button" id="remove-logo" <?php echo empty($options['logo']) ? 'style="display: none;"' : ''; ?>><?php echo esc_html__('Remove Logo', 'construction-mode'); ?></button>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="construction_mode_bg_color"><?php echo esc_html__('Background Color', 'construction-mode'); ?></label>
                </th>
                <td>
                    <input type="text" id="construction_mode_bg_color" name="construction_mode_settings[background_color]" value="<?php echo esc_attr(isset($options['background_color']) ? $options['background_color'] : '#000000'); ?>" class="color-picker" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="construction_mode_text_color"><?php echo esc_html__('Text Color', 'construction-mode'); ?></label>
                </th>
                <td>
                    <input type="text" id="construction_mode_text_color" name="construction_mode_settings[text_color]" value="<?php echo esc_attr(isset($options['text_color']) ? $options['text_color'] : '#ffffff'); ?>" class="color-picker" />
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>

<!-- JavaScript is now loaded from admin.js -->

<style>
.logo-preview-wrapper {
    margin-bottom: 10px;
}

#remove-logo {
    margin-left: 10px;
}
</style>