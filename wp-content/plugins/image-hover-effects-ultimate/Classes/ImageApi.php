<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Classes;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Description of Image Hover Rest API
 *
 * @author $biplob018
 */
class ImageApi {

    /**
     * Define $wpdb
     *
     * @since 9.3.0
     */
    public $wpdb;

    /**
     * Database Parent Table
     *
     * @since 9.3.0
     */
    public $parent_table;

    /**
     * Database Import Table
     *
     * @since 9.3.0
     */
    public $import_table;

    /**
     * Database Import Table
     *
     * @since 9.3.0
     */
    public $child_table;
    public $request;
    public $rawdata;
    public $styleid;
    public $childid;

    const API = 'https://oxilabdemos.com/image-hover/wp-json/imagehoverultimate/v2/';

    // instance container
    private static $instance = null;

    public static function instance() {
        if (self::$instance == null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Constructor of plugin class
     *
     * @since 9.3.0
     */
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->parent_table = $this->wpdb->prefix . 'image_hover_ultimate_style';
        $this->child_table = $this->wpdb->prefix . 'image_hover_ultimate_list';
        $this->import_table = $this->wpdb->prefix . 'oxi_div_import';
        $this->build_api();
    }

    public function build_api() {
        add_action('rest_api_init', function () {
            register_rest_route(untrailingslashit('ImageHoverUltimate/v1/'), '/(?P<action>\w+)/', array(
                'methods' => array('GET', 'POST'),
                'callback' => [$this, 'api_action'],
                'permission_callback' => array($this, 'get_permissions_check'),
            ));
        });

        add_action('wp_ajax_nopriv_image_hover_ultimate', array($this, 'ajax_action'));
        add_action('wp_ajax_image_hover_ultimate', array($this, 'ajax_action'));
    }

    public function get_permissions_check($request) {
        $user_role = get_option('oxi_addons_user_permission');
        $role_object = get_role($user_role);
        $first_key = '';
        if (isset($role_object->capabilities) && is_array($role_object->capabilities)) {
            reset($role_object->capabilities);
            $first_key = key($role_object->capabilities);
        } else {
            $first_key = 'manage_options';
        }
        return current_user_can($first_key);
    }

    public function ajax_action() {

        $wpnonce = sanitize_key(wp_unslash($_POST['_wpnonce']));
        if (!wp_verify_nonce($wpnonce, 'image_hover_ultimate')):
            return new \WP_REST_Request('Invalid URL', 422);
            die();
        endif;
        $classname = isset($_POST['class']) ? '\\' . str_replace('\\\\', '\\', sanitize_text_field($_POST['class'])) : '';
        if (strpos($classname, 'OXI_IMAGE_HOVER_PLUGINS') === false):
            return new \WP_REST_Request('Invalid URL', 422);
        endif;
        $functionname = isset($_POST['functionname']) ? sanitize_text_field($_POST['functionname']) : '';
        if ($functionname != '__rest_api_post'):
            return new \WP_REST_Request('Invalid URL', 422);
        endif;
        $rawdata = isset($_POST['rawdata']) ? sanitize_post($_POST['rawdata']) : '';
        $args = isset($_POST['args']) ? sanitize_post($_POST['args']) : '';
        $optional = isset($_POST['optional']) ? sanitize_post($_POST['optional']) : '';
        if (!empty($classname) && !empty($functionname) && class_exists($classname)):
            $CLASS = new $classname;
            $CLASS->__construct($functionname, $rawdata, $args, $optional);
        endif;
        die();
    }

    public function api_action($request) {

        $this->request = $request;
        $wpnonce = $request['_wpnonce'];
        if (!wp_verify_nonce($wpnonce, 'wp_rest')):
            return new \WP_REST_Request('Invalid URL', 422);
        endif;
        $this->rawdata = sanitize_post(addslashes($request['rawdata']));
        $this->styleid = (int) $request['styleid'];
        $this->childid = (int) $request['childid'];
        $action_class = strtolower($request->get_method()) . '_' . sanitize_key($request['action']);
        if (method_exists($this, $action_class)) {
            return $this->{$action_class}();
        }
    }

    public function allowed_html($rawdata) {
        $allowed_tags = array(
            'a' => array(
                'class' => array(),
                'href' => array(),
                'rel' => array(),
                'title' => array(),
            ),
            'abbr' => array(
                'title' => array(),
            ),
            'b' => array(),
            'br' => array(),
            'blockquote' => array(
                'cite' => array(),
            ),
            'cite' => array(
                'title' => array(),
            ),
            'code' => array(),
            'del' => array(
                'datetime' => array(),
                'title' => array(),
            ),
            'dd' => array(),
            'div' => array(
                'class' => array(),
                'title' => array(),
                'style' => array(),
                'id' => array(),
            ),
            'table' => array(
                'class' => array(),
                'id' => array(),
                'style' => array(),
            ),
            'button' => array(
                'class' => array(),
                'type' => array(),
                'value' => array(),
            ),
            'thead' => array(),
            'tbody' => array(),
            'tr' => array(),
            'td' => array(),
            'dt' => array(),
            'em' => array(),
            'h1' => array(),
            'h2' => array(),
            'h3' => array(),
            'h4' => array(),
            'h5' => array(),
            'h6' => array(),
            'i' => array(
                'class' => array(),
            ),
            'img' => array(
                'alt' => array(),
                'class' => array(),
                'height' => array(),
                'src' => array(),
                'width' => array(),
            ),
            'li' => array(
                'class' => array(),
            ),
            'ol' => array(
                'class' => array(),
            ),
            'p' => array(
                'class' => array(),
            ),
            'q' => array(
                'cite' => array(),
                'title' => array(),
            ),
            'span' => array(
                'class' => array(),
                'title' => array(),
                'style' => array(),
            ),
            'strike' => array(),
            'strong' => array(),
            'ul' => array(
                'class' => array(),
            ),
        );
        if (is_array($rawdata)):
            return $rawdata = array_map(array($this, 'allowed_html'), $rawdata);
        else:
            return wp_kses($rawdata, $allowed_tags);
        endif;
    }

    public function validate_post($data = '') {
        $rawdata = [];
        if (!empty($data)):
            $arrfiles = json_decode(stripslashes($data), true);
        else:
            $arrfiles = json_decode(stripslashes($this->rawdata), true);
        endif;
        if (is_array($arrfiles)):
            $rawdata = array_map(array($this, 'allowed_html'), $arrfiles);
        elseif (empty($data)):
            $rawdata = $this->allowed_html($this->rawdata);
        else:
            $rawdata = $this->allowed_html($data);
        endif;
        return $rawdata;
    }

    public function array_replace($arr = [], $search = '', $replace = '') {
        array_walk($arr, function (&$v) use ($search, $replace) {
            $v = str_replace($search, $replace, $v);
        });
        return $arr;
    }

    public function post_create_new() {

        $params = $this->validate_post();

        $files = OXI_IMAGE_HOVER_PATH . $params['style'];

        if (is_file($files)) {
            $rawdata = file_get_contents($files);
            $params = json_decode($rawdata, true);
            $style = $params['style'];
            $child = $params['child'];
            if (!empty($params['name'])):
                $style['name'] = $params['name'];
            endif;

            $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->parent_table} (name, style_name, rawdata) VALUES ( %s, %s, %s)", array($style['name'], $style['style_name'], $style['rawdata'])));
            $redirect_id = $this->wpdb->insert_id;
            if ($redirect_id > 0) :
                $raw = json_decode(stripslashes($style['rawdata']), true);
                $raw['image-hover-style-id'] = $redirect_id;
                $s = explode('-', $style['style_name']);
                $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($s[0]) . '\Admin\Effects' . $s[1];
                $C = new $CLASS('admin');
                $f = $C->template_css_render($raw);
                foreach ($child as $value) {
                    $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d,  %s)", array($redirect_id, $value['rawdata'])));
                }
                return admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$s[0]&styleid=$redirect_id");
            endif;
        }
        return;
    }

    public function post_layouts_clone() {

        $newName = $this->validate_post();

        $styleid = $this->styleid;

        $style = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM $this->parent_table WHERE id = %d", $styleid), ARRAY_A);
        $child = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $styleid), ARRAY_A);

        $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->parent_table} (name, style_name, rawdata) VALUES ( %s, %s, %s)", array($newName, $style['style_name'], $style['rawdata'])));
        $redirect_id = $this->wpdb->insert_id;
        if ($redirect_id > 0) :
            $raw = json_decode(stripslashes($style['rawdata']), true);
            $raw['image-hover-style-id'] = $redirect_id;
            $s = explode('-', $style['style_name']);
            $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($s[0]) . '\Admin\Effects' . $s[1];
            $C = new $CLASS('admin');
            $f = $C->template_css_render($raw);
            foreach ($child as $value) {
                $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d,  %s)", array($redirect_id, $value['rawdata'])));
            }
            return admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$s[0]&styleid=$redirect_id");
        endif;
    }

    public function post_json_import($params) {

        $style = $params['style'];
        $child = $params['child'];
        $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->parent_table} (name, style_name, rawdata) VALUES ( %s, %s, %s)", array($style['name'], $style['style_name'], $style['rawdata'])));
        $redirect_id = $this->wpdb->insert_id;
        if ($redirect_id > 0) :
            $raw = json_decode(stripslashes($style['rawdata']), true);
            $raw['image-hover-style-id'] = $redirect_id;
            $s = explode('-', $style['style_name']);
            $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($s[0]) . '\Admin\Effects' . $s[1];
            $C = new $CLASS('admin');
            $f = $C->template_css_render($raw);
            foreach ($child as $value) {
                $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d,  %s)", array($redirect_id, $value['rawdata'])));
            }
            return admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$s[0]&styleid=$redirect_id");
        endif;
    }

    public function post_shortcode_delete() {
        $styleid = (int) $this->styleid;
        if ($styleid) :
            $this->wpdb->query($this->wpdb->prepare("DELETE FROM {$this->parent_table} WHERE id = %d", $styleid));
            $this->wpdb->query($this->wpdb->prepare("DELETE FROM {$this->child_table} WHERE styleid = %d", $styleid));
            return 'done';
        else :
            return 'Silence is Golden';
        endif;
    }

    public function update_image_hover_plugin() {
        $stylelist = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->parent_table ORDER by id ASC"), ARRAY_A);
        foreach ($stylelist as $value) {
            $raw = json_decode(stripslashes($value['rawdata']), true);
            $raw['image-hover-style-id'] = $value['id'];
            $s = explode('-', $value['style_name']);
            $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($s[0]) . '\Admin\Effects' . $s[1];
            $C = new $CLASS('admin');
            $f = $C->template_css_render($raw);
        }
        update_option('image_hover_ultimate_update_complete', 'done');
    }

    /**
     * Generate safe path
     * @since v1.0.0
     */
    public function safe_path($path) {

        $path = str_replace(['//', '\\\\'], ['/', '\\'], $path);
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    }

    public function get_shortcode_export() {
        $styleid = (int) $this->styleid;
        if ($styleid > 0) :
            $style = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM $this->parent_table WHERE id = %d", $styleid), ARRAY_A);
            $child = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $styleid), ARRAY_A);
            $filename = 'image-hover-effects-ultimateand' . $style['id'] . '.json';
            $files = [
                'style' => $style,
                'child' => $child,
            ];
            $finalfiles = json_encode($files);
            $this->send_file_headers($filename, strlen($finalfiles));
            @ob_end_clean();
            flush();
            echo $finalfiles;
            die;
        else :
            return 'Silence is Golden';
        endif;
    }

    /**
     * Send file headers.
     *
     *
     * @param string $file_name File name.
     * @param int    $file_size File size.
     */
    private function send_file_headers($file_name, $file_size) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $file_name);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . $file_size);
    }

    public function post_shortcode_deactive() {
        $rawdata = $this->validate_post();

        $id = $rawdata . '-' . (int) $this->styleid;
        $effects = $rawdata . '-ultimate';
        if ($this->styleid > 0) :
            $this->wpdb->query($this->wpdb->prepare("DELETE FROM {$this->import_table} WHERE name = %s and type = %s", $id, $effects));
            return 'done';
        else :
            return 'Silence is Golden';
        endif;
    }

    public function post_shortcode_active() {
        $rawdata = $this->validate_post();
        $id = $rawdata . '-' . (int) $this->styleid;
        $effects = $rawdata . '-ultimate';

        if ($this->styleid > 0) :
            $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->import_table} (type, name) VALUES (%s, %s)", array($effects, $id)));
            return admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$rawdata#" . $id);
        else :
            return 'Silence is Golden';
        endif;
    }

    /**
     * Template Style Data
     *
     * @since 9.3.0
     */
    public function post_elements_template_style() {
        $settings = json_decode(stripslashes($this->rawdata), true);
        $StyleName = sanitize_text_field($settings['image-hover-template']);
        $stylesheet = '';
        if ((int) $this->styleid) :
            $this->wpdb->query($this->wpdb->prepare("UPDATE {$this->parent_table} SET rawdata = %s, stylesheet = %s WHERE id = %d", $this->rawdata, $stylesheet, $this->styleid));
            $name = explode('-', $StyleName);
            $cls = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . $name[0] . '\Admin\Effects' . $name[1];
            $CLASS = new $cls('admin');
            return $CLASS->template_css_render($settings);
        endif;
    }

    /**
     * Template Style Data
     *
     * @since 9.3.0
     */
    public function post_template_change() {
        $rawdata = $this->validate_post();

        if ((int) $this->styleid) :
            $this->wpdb->query($this->wpdb->prepare("UPDATE {$this->parent_table} SET style_name = %s WHERE id = %d", $rawdata, $this->styleid));
        endif;
        return 'success';
    }

    /**
     * Template Name Change
     *
     * @since 9.3.0
     */
    public function post_template_name() {
        $settings = $this->validate_post();
        $name = $settings['addonsstylename'];
        $id = $settings['addonsstylenameid'];
        if ((int) $id) :
            $this->wpdb->query($this->wpdb->prepare("UPDATE {$this->parent_table} SET name = %s WHERE id = %d", $name, $id));
            return 'success';
        endif;
    }

    /**
     * Template Name Change
     *
     * @since 9.3.0
     */
    public function post_elements_rearrange_modal_data() {
        if ((int) $this->styleid) :
            $child = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $this->styleid), ARRAY_A);
            $render = [];
            foreach ($child as $k => $value) {
                $data = json_decode(stripcslashes($value['rawdata']));
                $render[$value['id']] = $data;
            }
            return json_encode($render);
        endif;
    }

    /**
     * Template Name Change
     *
     * @since 9.3.0
     */
    public function post_elements_template_rearrange_save_data() {
        $params = explode(',', $this->validate_post());
        foreach ($params as $value) {
            if ((int) $value) :
                $data = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE id = %d ", $value), ARRAY_A);
                $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d, %s)", array($data['styleid'], $data['rawdata'])));
                $redirect_id = $this->wpdb->insert_id;
                if ($redirect_id == 0) {
                    return;
                }
                if ($redirect_id != 0) {
                    $this->wpdb->query($this->wpdb->prepare("DELETE FROM $this->child_table WHERE id = %d", $value));
                }
            endif;
        }
        return 'success';
    }

    /**
     * Template Modal Data
     *
     * @since 9.3.0
     */
    public function post_elements_template_modal_data() {

        if ((int) $this->styleid) :
            if ((int) $this->childid) :
                $this->wpdb->query($this->wpdb->prepare("UPDATE {$this->child_table} SET rawdata = %s WHERE id = %d", $this->rawdata, $this->childid));
            else :
                $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d, %s )", array($this->styleid, $this->rawdata)));
            endif;
        endif;
        return 'success';
    }

    /**
     * Template Rebuild Render
     *
     * @since 9.3.0
     */
    public function post_elements_template_rebuild_data() {
        $style = $this->wpdb->get_row($this->wpdb->prepare('SELECT * FROM ' . $this->parent_table . ' WHERE id = %d ', $this->styleid), ARRAY_A);
        $child = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $this->styleid), ARRAY_A);
        $style['rawdata'] = $style['stylesheet'] = $style['font_family'] = '';
        $name = explode('-', $style['style_name']);
        $cls = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($name[0]) . '\Render\Effects' . $name[1];
        $CLASS = new $cls;
        $CLASS->__construct($style, $child, 'admin');
        return 'success';
    }

    /**
     * Template Template Render
     *
     * @since 9.3.0
     */
    public function post_elements_template_render_data() {
        $settings = json_decode(stripslashes($this->rawdata), true);
        $child = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $this->styleid), ARRAY_A);
        $StyleName = $settings['image-hover-template'];
        $name = explode('-', $StyleName);
        ob_start();
        $cls = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . $name[0] . '\Render\Effects' . $name[1];
        $CLASS = new $cls;
        $styledata = ['rawdata' => $this->rawdata, 'id' => $this->styleid, 'style_name' => $StyleName, 'stylesheet' => ''];
        $CLASS->__construct($styledata, $child, 'admin');
        return ob_get_clean();
    }

    /**
     * Template Modal Data Edit Form
     *
     * @since 9.3.0
     */
    public function post_elements_template_modal_data_edit() {
        if ((int) $this->childid) :
            $listdata = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM {$this->child_table} WHERE id = %d ", $this->childid), ARRAY_A);
            $returnfile = json_decode(stripslashes($listdata['rawdata']), true);
            $returnfile['shortcodeitemid'] = $this->childid;
            return json_encode($returnfile);
        else :
            return 'Silence is Golden';
        endif;
    }

    /**
     * Template Modal Data Edit Form
     *
     * @since 9.3.0
     */
    public function post_elements_template_modal_data_clone() {
        if ((int) $this->childid) :
            $listdata = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM {$this->child_table} WHERE id = %d ", $this->childid), ARRAY_A);
            $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d,  %s)", array($listdata['styleid'], $listdata['rawdata'])));
            $redirect_id = $this->wpdb->insert_id;
            if ($redirect_id > 0) :
                return 'done';
            endif;
            return 'Silence is Golden';
        else :
            return 'Silence is Golden';
        endif;
    }

    /**
     * Template Child Delete Data
     *
     * @since 9.3.0
     */
    public function post_elements_template_modal_data_delete() {
        if ((int) $this->childid) :
            $this->wpdb->query($this->wpdb->prepare("DELETE FROM {$this->child_table} WHERE id = %d ", $this->childid));
            return 'done';
        else :
            return 'Silence is Golden';
        endif;
    }

    /**
     * Admin Notice API  loader
     * @return void
     */
    public function post_oxi_recommended() {
        $data = 'done';
        update_option('oxi_image_hover_recommended', $data);
        return $data;
    }

    /**
     * Admin Notice Recommended  loader
     * @return void
     */
    public function post_notice_dissmiss() {
        $notice = $this->request['notice'];
        if ($notice == 'maybe') :
            $data = strtotime("now");
            update_option('oxi_image_hover_activation_date', $data);
        else :
            update_option('oxi_image_hover_nobug', $notice);
        endif;
        return $notice;
    }

    /**
     * Admin Settings
     * @return void
     */
    public function post_oxi_addons_user_permission() {
        $rawdata = $this->validate_post();
        update_option('oxi_addons_user_permission', $rawdata['value']);
        return '<span class="oxi-confirmation-success"></span>';
    }

    /**
     * Admin Settings
     * @return void
     */
    public function post_image_hover_ultimate_mobile_device_key() {
        $rawdata = $this->validate_post();
        update_option('image_hover_ultimate_mobile_device_key', $rawdata['value']);
        return '<span class="oxi-confirmation-success"></span>';
    }

    /**
     * Admin Settings
     * @return void
     */
    public function post_oxi_addons_font_awesome() {
        $rawdata = $this->validate_post();
        update_option('oxi_addons_font_awesome', $rawdata['value']);
        return '<span class="oxi-confirmation-success"></span>';
    }

    /**
     * Admin Settings
     * @return void
     */
    public function post_oxi_addons_way_points() {
        $rawdata = $this->validate_post();
        update_option('oxi_addons_way_points', $rawdata['value']);
        return '<span class="oxi-confirmation-success"></span>';
    }

    /**
     * Admin Settings
     * @return void
     */
    public function post_oxi_addons_google_font() {
        $rawdata = $this->validate_post();
        update_option('oxi_addons_google_font', $rawdata['value']);
        return '<span class="oxi-confirmation-success"></span>';
    }

    /**
     * Admin Settings
     * @return void
     */
    public function post_oxi_addons_custom_parent_class() {
        $rawdata = $this->validate_post();
        update_option('oxi_addons_custom_parent_class', $rawdata['value']);
        return '<span class="oxi-confirmation-success"></span>';
    }

    /**
     * Admin License
     * @return void
     */
    public function post_oxi_license() {
        $rawdata = $this->validate_post();
        $new = $rawdata['license'];
        $old = get_option('image_hover_ultimate_license_key');
        $status = get_option('image_hover_ultimate_license_status');
        if ($new == '') :
            if ($old != '' && $status == 'valid') :
                $this->deactivate_license($old);
            endif;
            delete_option('image_hover_ultimate_license_key');
            $data = ['massage' => '<span class="oxi-confirmation-blank"></span>', 'text' => ''];
        else :
            update_option('image_hover_ultimate_license_key', $new);
            delete_option('image_hover_ultimate_license_status');
            $r = $this->activate_license($new);
            if ($r == 'success') :
                $data = ['massage' => '<span class="oxi-confirmation-success"></span>', 'text' => 'Active'];
            else :
                $data = ['massage' => '<span class="oxi-confirmation-failed"></span>', 'text' => $r];
            endif;
        endif;
        return $data;
    }

    public function activate_license($key) {
        $api_params = array(
            'edd_action' => 'activate_license',
            'license' => $key,
            'item_name' => urlencode('Image Hover Effects Ultimate'),
            'url' => home_url()
        );

        $response = wp_remote_post('https://www.oxilab.org', array('timeout' => 15, 'sslverify' => false, 'body' => $api_params));

        if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {
            if (is_wp_error($response)) {
                $message = $response->get_error_message();
            } else {
                $message = esc_html('An error occurred, please try again.');
            }
        } else {
            $license_data = json_decode(wp_remote_retrieve_body($response));

            if (false === $license_data->success) {

                switch ($license_data->error) {



                    case 'revoked':

                        $message = esc_html('Your license key has been disabled.');
                        break;

                    case 'missing':

                        $message = esc_html('Invalid license.');
                        break;

                    case 'invalid':
                    case 'site_inactive':

                        $message = esc_html('Your license is not active for this URL.');
                        break;

                    case 'no_activations_left':

                        $message = esc_html('Your license key has reached its activation limit.');
                        break;

                    default:

                        $message = esc_html('An error occurred, please try again.');
                        break;
                }
            }
        }

        if (!empty($message)) {
            return $message;
        }
        update_option('image_hover_ultimate_license_status', $license_data->license);
        return 'success';
    }

    public function deactivate_license($key) {
        $api_params = array(
            'edd_action' => 'deactivate_license',
            'license' => $key,
            'item_name' => urlencode('Image Hover Effects Ultimate'),
            'url' => home_url()
        );
        $response = wp_remote_post('https://www.oxilab.org', array('timeout' => 15, 'sslverify' => false, 'body' => $api_params));
        if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {

            if (is_wp_error($response)) {
                $message = $response->get_error_message();
            } else {
                $message = esc_html('An error occurred, please try again.');
            }
            return $message;
        }
        $license_data = json_decode(wp_remote_retrieve_body($response));
        if ($license_data->license == 'deactivated') {
            delete_option('image_hover_ultimate_license_status');
            delete_option('image_hover_ultimate_license_key');
        }
        return 'success';
    }

    public function fixed_data($agr) {
        return hex2bin($agr);
    }

    public function post_web_template() {

        $folder = $this->safe_path(OXI_IMAGE_HOVER_PATH . 'template/');
        if (!is_dir($folder)) :
            mkdir($folder, 0777);
        endif;
        $rawdata = $this->validate_post();
        $files = OXI_IMAGE_HOVER_PATH . 'template/' . $rawdata . '-' . $this->styleid . '.json';
        if (!file_exists($files)) :
            $this->download_web_files($files);
        endif;
        $template_data = json_decode(file_get_contents($files), true);

        $render = '';
        $vs = get_option($this->fixed_data('696d6167655f686f7665725f756c74696d6174655f6c6963656e73655f737461747573'));
        foreach ($template_data as $key => $value) {
            if ($vs == $this->fixed_data('76616c6964')) {
                $button = '<button type="button" class="btn btn-success oxi-addons-addons-web-template-import-button" web-data="' . $value['style']['style_name'] . '" web-template="' . $value['style']['id'] . '">Import</button>';
            } else {
                $button = '<button class="btn btn-warning oxi-addons-addons-style-btn-warning" title="Pro Only" type="submit" value="pro only" name="addonsstyleproonly">Pro Only</button>';
            }
            $render .= '<div class="oxi-addons-col-1">
                                    <div class="oxi-addons-style-preview">
                                        <div class="oxi-addons-style-preview-top oxi-addons-center">';
            $C = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($rawdata) . '\Render\Effects' . $this->styleid;

            ob_start();
            if (class_exists($C)) :
                new $C($value['style'], $value['child'], 'web');
            endif;
            $render .= ob_get_contents();
            ob_end_clean();

            $render .= '                </div>
                                        <div class="oxi-addons-style-preview-bottom">
                                            <div class="oxi-addons-style-preview-bottom-left">
                                                ' . $value['style']['name'] . '
                                            </div>
                                            <div class="oxi-addons-style-preview-bottom-right">
                                                ' . $button . '
                                            </div>
                                        </div>
                                    </div>
                                </div>';
        }
        return $render;
    }

    public function download_web_files($files) {

        $rawdata = $this->validate_post();
        $URL = self::API . $rawdata . '/' . $this->styleid;
        $request = wp_remote_request($URL);
        if (!is_wp_error($request)) {
            $response = json_decode(wp_remote_retrieve_body($request), true);
        } else {
            return $request->get_error_message();
        }

        $data = json_decode($response, true);
        if (file_put_contents($files, json_encode($data))) {
            
        }
    }

    public function post_web_import() {
        $rawdata = $this->validate_post();
        $files = OXI_IMAGE_HOVER_PATH . 'template/' . $rawdata . '.json';
        $params = json_decode(file_get_contents($files), true)[$this->styleid];

        $style = $params['style'];
        $child = $params['child'];
        $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->parent_table} (name, style_name, rawdata) VALUES ( %s, %s, %s)", array($style['name'], $style['style_name'], $style['rawdata'])));
        $redirect_id = $this->wpdb->insert_id;
        if ($redirect_id > 0) :
            $raw = json_decode(stripslashes($style['rawdata']), true);
            $raw['image-hover-style-id'] = $redirect_id;
            $s = explode('-', $style['style_name']);
            $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($s[0]) . '\Admin\Effects' . $s[1];
            $C = new $CLASS('admin');
            $f = $C->template_css_render($raw);
            foreach ($child as $value) {
                $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d,  %s)", array($redirect_id, $value['rawdata'])));
            }
            return admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$s[0]&styleid=$redirect_id");
        endif;
    }

}
