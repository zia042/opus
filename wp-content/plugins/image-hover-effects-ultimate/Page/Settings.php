<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Page;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Description of Settings
 *
 * @author $biplob018
 */
class Settings {

    use \OXI_IMAGE_HOVER_PLUGINS\Helper\CSS_JS_Loader;

    public $roles;
    public $saved_role;
    public $license;
    public $status;
    public $oxi_fixed_header;
    public $fontawesome;
    public $getfontawesome = [];

    /**
     * Constructor of Oxilab tabs Home Page
     *
     * @since 9.3.0
     */
    public function __construct() {
        $this->admin();
        $this->css_loader();
        $this->Render();
    }

    public function admin() {
        global $wp_roles;
        $this->roles = $wp_roles->get_names();
        $this->saved_role = get_option('oxi_addons_user_permission');
        $this->license = get_option('image_hover_ultimate_license_key');
        $this->status = get_option('image_hover_ultimate_license_status');
    }

    public function Render() {
        ?>
        <div class="wrap">
            <?php
            apply_filters('oxi-image-hover-plugin/admin_menu', TRUE);
            ?>
            <div class="oxi-addons-row oxi-addons-admin-settings">
                <h2>General</h2>
                <p>Settings for Image Hover Effects Ultimate.</p>
                <form method="post">

                    <table class="form-table" role="presentation">
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <label for="oxi_addons_user_permission">Who Can Edit?</label>
                                </th>
                                <td>
                                    <fieldset>
                                        <select name="oxi_addons_user_permission" id="oxi_addons_user_permission">
                                            <?php foreach ($this->roles as $key => $role) { ?>
                                                <option value="<?php echo esc_attr($key); ?>" <?php selected($this->saved_role, $key); ?>>
                                                    <?php echo esc_html($role); ?></option>
                                                <?php } ?>
                                        </select>
                                        <span class="oxi-addons-settings-connfirmation oxi_addons_user_permission"></span>
                                        <br>
                                        <p class="description"><?php _e('Select the Role who can manage This Plugins.'); ?> <a
                                                target="_blank"
                                                href="https://codex.wordpress.org/Roles_and_Capabilities#Capability_vs._Role_Table">Help</a>
                                        </p>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="image_hover_ultimate_mobile_device_key">Mobile or Touch Device Behaviour</label>
                                </th>
                                <td>
                                    <fieldset>
                                        <label for="image_hover_ultimate_mobile_device_key[yes]">
                                            <input type="radio" class="radio" id="image_hover_ultimate_mobile_device_key[yes]"
                                                   name="image_hover_ultimate_mobile_device_key" value=""
                                                   <?php checked('', get_option('image_hover_ultimate_mobile_device_key'), true); ?>>Yes</label>
                                        <label for="image_hover_ultimate_mobile_device_key[normal]">
                                            <input type="radio" class="radio"
                                                   id="image_hover_ultimate_mobile_device_key[normal]"
                                                   name="image_hover_ultimate_mobile_device_key" value="normal"
                                                   <?php checked('normal', get_option('image_hover_ultimate_mobile_device_key'), true); ?>>No
                                        </label>
                                        <span
                                            class="oxi-addons-settings-connfirmation image_hover_ultimate_mobile_device_key"></span>
                                        <br>
                                        <p class="description">Select option as Effects first with second tap to open link or
                                            works normally as click to open link.</p>
                                    </fieldset>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">
                                    <label for="oxi_addons_font_awesome">Font Awesome Support</label>
                                </th>
                                <td>
                                    <fieldset>
                                        <label for="oxi_addons_font_awesome[]">
                                            <input type="radio" class="radio" id="oxi_addons_font_awesome[yes]"
                                                   name="oxi_addons_font_awesome" value=""
                                                   <?php checked('yes', get_option('oxi_addons_font_awesome'), true); ?>>Yes</label>
                                        <label for="oxi_addons_font_awesome[no]">
                                            <input type="radio" class="radio" id="oxi_addons_font_awesome[no]"
                                                   name="oxi_addons_font_awesome" value="no"
                                                   <?php checked('', get_option('oxi_addons_font_awesome'), true); ?>>No
                                        </label>
                                        <span class="oxi-addons-settings-connfirmation oxi_addons_font_awesome"></span>
                                        <br>
                                        <p class="description">Load Font Awesome CSS at shortcode loading, If your theme already
                                            loaded select No for faster loading</p>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="oxi_addons_way_points">Waypoints Support</label>
                                </th>
                                <td>
                                    <fieldset>
                                        <label for="oxi_addons_way_points[yes]">
                                            <input type="radio" class="radio" id="oxi_addons_way_points[yes]"
                                                   name="oxi_addons_way_points" value=""
                                                   <?php checked('', get_option('oxi_addons_way_points'), true); ?>>Yes</label>
                                        <label for="oxi_addons_way_points[no]">
                                            <input type="radio" class="radio" id="oxi_addons_way_points[no]"
                                                   name="oxi_addons_way_points" value="no"
                                                   <?php checked('no', get_option('oxi_addons_way_points'), true); ?>>No
                                        </label>
                                        <span class="oxi-addons-settings-connfirmation oxi_addons_way_points"></span>
                                        <br>
                                        <p class="description">Load Way Points at shortcode loading while animated, If your
                                            theme already loaded select No for faster loading</p>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="oxi_addons_google_font">Google Font Support</label>
                                </th>
                                <td>
                                    <fieldset>
                                        <label for="oxi_addons_google_font[yes]">
                                            <input type="radio" class="radio" id="oxi_addons_google_font[yes]"
                                                   name="oxi_addons_google_font" value=""
                                                   <?php checked('', get_option('oxi_addons_google_font'), true); ?>>Yes</label>
                                        <label for="oxi_addons_google_font[no]">
                                            <input type="radio" class="radio" id="oxi_addons_google_font[no]"
                                                   name="oxi_addons_google_font" value="no"
                                                   <?php checked('no', get_option('oxi_addons_google_font'), true); ?>>No
                                        </label>
                                        <span class="oxi-addons-settings-connfirmation oxi_addons_google_font"></span>
                                        <br>
                                        <p class="description">Load Google font from Google while loading shortcode, If you
                                            already load those locally select No for faster loading</p>
                                    </fieldset>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">
                                    <label for="oxi_addons_custom_parent_class">Custom Parent Class</label>
                                </th>
                                <td class="valid">
                                    <input type="text" class="regular-text" id="oxi_addons_custom_parent_class"
                                           name="oxi_addons_custom_parent_class"
                                           value="<?php echo esc_attr(get_option('oxi_addons_custom_parent_class')); ?>">
                                    <span class="oxi-addons-settings-connfirmation oxi_addons_custom_parent_class "></span>
                                    <p class="description">Add custom panrent Class as Avoid Conflict with Theme or Plugins.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <h2><?php _e('License Activation'); ?></h2>
                    <p>Activate your copy to get direct plugin updates and official support.</p>
                    <table class="form-table" role="presentation">
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <label for="image_hover_ultimate_license_key">License Key</label>
                                </th>
                                <td class="valid">
                                    <input type="text" class="regular-text" id="image_hover_ultimate_license_key"
                                           name="image_hover_ultimate_license_key" value="<?php echo ($this->status == 'valid' && empty($this->license)) ? '****************************************' : esc_attr($this->license); ?>">
                                    <span class="oxi-addons-settings-connfirmation image_hover_ultimate_license_massage">
                                        <?php
                                        if ($this->status == 'valid' && empty($this->license)) :
                                            echo '<span class="oxi-confirmation-success"></span>';
                                        elseif ($this->status == 'valid' && !empty($this->license)) :
                                            echo '<span class="oxi-confirmation-success"></span>';
                                        elseif (!empty($this->license)) :
                                            echo '<span class="oxi-confirmation-failed"></span>';
                                        else :
                                            echo '<span class="oxi-confirmation-blank"></span>';
                                        endif;
                                        ?>
                                    </span>
                                    <span class="oxi-addons-settings-connfirmation image_hover_ultimate_license_text">
                                        <?php
                                        if ($this->status == 'valid' && empty($this->license)) :
                                            echo '<span class="oxi-addons-settings-massage">Pre Active</span>';
                                        elseif ($this->status == 'valid' && !empty($this->license)) :
                                            echo '<span class="oxi-addons-settings-massage">Active</span>';
                                        elseif (!empty($this->license)) :
                                            echo '<span class="oxi-addons-settings-massage">' . esc_html($this->status) . '</span>';
                                        else :
                                            echo '<span class="oxi-addons-settings-massage"></span>';
                                        endif;
                                        ?>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </form>
            </div>
        </div>
        <?php
    }

    public function css_loader() {
        $this->admin_css_loader();
        wp_enqueue_script('oxi-image-hover-settings', OXI_IMAGE_HOVER_URL . '/assets/backend/js/settings.js', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
    }

}
