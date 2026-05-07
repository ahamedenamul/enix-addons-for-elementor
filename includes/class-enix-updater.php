<?php
/**
 * Plugin Update Checker for Enix Addons
 * 
 * @package EnixAddons
 */

if (!defined('ABSPATH')) {
    exit;
}

class Enix_Addons_Updater {
    
    private $plugin_file;
    private $plugin_slug;
    private $update_url;
    private $version;
    
    public function __construct() {
        $this->plugin_file = ENIX_ADDONS_BASENAME;
        $this->plugin_slug = 'enix-addons-for-elementor';
        $this->update_url = 'https://api.github.com/repos/ahamedenamul/enix-addons-for-elementor/releases/latest';
        $this->version = ENIX_ADDONS_VERSION;
        
        // Add update check hooks
        add_filter('pre_set_site_transient_update_plugins', array($this, 'check_for_update'));
        add_filter('plugins_api', array($this, 'plugin_info'), 10, 3);
        add_action('in_plugin_update_message-' . $this->plugin_file, array($this, 'update_message'), 10, 2);
    }
    
    /**
     * Check for plugin updates
     */
    public function check_for_update($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }
        
        // Get remote version
        $remote_version = $this->get_remote_version();
        
        if ($remote_version && version_compare($this->version, $remote_version, '<')) {
            $plugin_data = array(
                'slug' => $this->plugin_slug,
                'new_version' => $remote_version,
                'url' => 'https://github.com/ahamedenamul/enix-addons-for-elementor',
                'package' => 'https://github.com/ahamedenamul/enix-addons-for-elementor/releases/latest/download/enix-addons-for-elementor-v' . $remote_version . '.zip',
                'icons' => array(
                    '1x' => 'https://raw.githubusercontent.com/ahamedenamul/enix-addons-for-elementor/main/assets/images/enix-logo.png',
                    '2x' => 'https://raw.githubusercontent.com/ahamedenamul/enix-addons-for-elementor/main/assets/images/enix-logo.png'
                )
            );
            
            $transient->response[$this->plugin_file] = (object) $plugin_data;
        }
        
        return $transient;
    }
    
    /**
     * Get remote version from GitHub
     */
    private function get_remote_version() {
        $response = wp_remote_get($this->update_url, array(
            'headers' => array(
                'User-Agent' => 'Enix-Addons-Plugin/' . $this->version
            )
        ));
        
        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            return false;
        }
        
        $body = wp_remote_retrieve_body($response);
        $release_data = json_decode($body, true);
        
        if (isset($release_data['tag_name'])) {
            return ltrim($release_data['tag_name'], 'v');
        }
        
        return false;
    }
    
    /**
     * Plugin information for WordPress
     */
    public function plugin_info($false, $action, $response) {
        if ($action !== 'plugin_information' || $response !== $this->plugin_slug) {
            return $false;
        }
        
        $remote_version = $this->get_remote_version();
        
        return array(
            'name' => 'Enix Addons – Advanced Addons for Elementor',
            'slug' => $this->plugin_slug,
            'version' => $remote_version,
            'author' => '<a href="https://github.com/ahamedenamul">Enamul Islam</a>',
            'author_profile' => 'https://github.com/ahamedenamul',
            'url' => 'https://github.com/ahamedenamul/enix-addons-for-elementor',
            'homepage' => 'https://github.com/ahamedenamul/enix-addons-for-elementor',
            'requires' => '5.8',
            'tested' => '6.5',
            'requires_php' => '7.4',
            'download_link' => 'https://github.com/ahamedenamul/enix-addons-for-elementor/releases/latest/download/enix-addons-for-elementor-v' . $remote_version . '.zip',
            'sections' => array(
                'description' => 'A premium collection of advanced widgets for Elementor with professional design and functionality.',
                'changelog' => $this->get_changelog()
            ),
            'icons' => array(
                '1x' => 'https://raw.githubusercontent.com/ahamedenamul/enix-addons-for-elementor/main/assets/images/enix-logo.png',
                '2x' => 'https://raw.githubusercontent.com/ahamedenamul/enix-addons-for-elementor/main/assets/images/enix-logo.png'
            )
        );
    }
    
    /**
     * Get changelog from GitHub
     */
    private function get_changelog() {
        $response = wp_remote_get('https://raw.githubusercontent.com/ahamedenamul/enix-addons-for-elementor/main/CHANGELOG.md');
        
        if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
            $changelog = wp_remote_retrieve_body($response);
            // Convert Markdown to simple HTML for WordPress
            $changelog = preg_replace('/^### (.*?)$/m', '<h3>$1</h3>', $changelog);
            $changelog = preg_replace('/^\*\*([^:]+):\*\*/m', '<strong>$1:</strong>', $changelog);
            $changelog = preg_replace('/^\* (.*)$/m', '<li>$1</li>', $changelog);
            $changelog = preg_replace('/(<li>.*<\/li>)/s', '<ul>$1</ul>', $changelog);
            return $changelog;
        }
        
        return 'Check <a href="https://github.com/ahamedenamul/enix-addons-for-elementor/releases">GitHub releases</a> for detailed changelog.';
    }
    
    /**
     * Custom update message
     */
    public function update_message($plugin_data, $response) {
        if (isset($response->upgrade_notice)) {
            echo '<br>' . wp_kses_post($response->upgrade_notice);
        }
        
        echo '<br><strong>' . esc_html__('Important:', 'enix-addons') . '</strong> ' . 
             esc_html__('Please backup your site before updating.', 'enix-addons');
    }
}

// Initialize the updater
new Enix_Addons_Updater();
