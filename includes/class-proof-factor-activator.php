<?php

/**
 * Fired during plugin activation
 *
 * @link       https://prooffactor.com
 * @since      1.0.0
 *
 * @package    Proof_Factor
 * @subpackage Proof_Factor/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Proof_Factor
 * @subpackage Proof_Factor/includes
 * @author     Proof Factor LLC <enea@prooffactor.com>
 */
class Proof_Factor_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        $plugin_name = 'proof-factor';
        $options = get_option($plugin_name);

        $redirect_key = $plugin_name . '_do_activation_redirect';
        add_option($redirect_key, true);

        if (isset($options) && empty($options) == false) {
            $proof_account_id = $options['account_id'];
            $proof_user_id = $options['user_id'];
            $payload = [
                'url' => home_url(),
                'email' => get_option('admin_email'),
                'store_name' => get_option('blogname'),
                'account_id' => $proof_account_id,
                'user_id' => $proof_user_id
            ];
        } else {
            $payload = [
                'url' => home_url(),
                'email' => get_option('admin_email'),
                'store_name' => get_option('blogname')
            ];
        }

        Proof_Factor_Helper::remote_json_post("https://api.prooffactor.com/v1/partners/woo_commerce/activate", $payload);
    }
}
