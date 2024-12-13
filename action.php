<?php

use dokuwiki\Extension\ActionPlugin;
use dokuwiki\Extension\EventHandler;
use dokuwiki\Extension\Event;

/**
 * DokuWiki Plugin iconify (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author Tokano <contact@tokano.fr>
 */
class action_plugin_iconify extends ActionPlugin
{
    /** @inheritDoc */
    public function register(EventHandler $controller)
    {
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, 'add_iconify_resources');
    }

    /**
     * Event handler for TPL_METAHEADER_OUTPUT
     *
     * @param Event $event Event object
     * @return void
     */
    public function add_iconify_resources(Event $event)
    {
        // Check if the user wants to use a local file
        $useLocal = $this->getConf('use_local');
        
        if ($useLocal) {
            // Use local file path
            $localPath = DOKU_INC . 'lib/plugins/iconify/local/iconify.min.js';

            if (file_exists($localPath)) {
                $event->data["script"][] = [
                    "type" => "text/javascript",
                    "src" => DOKU_BASE . 'lib/plugins/iconify/local/iconify.min.js',
                    "defer" => "defer"
                ];
            } else {
                // If the local file is missing, log an error
                msg('Iconify: Local file not found. Please upload iconify.min.js to the plugin\'s local folder.', -1);
            }
        } else {
            // Use the online option and get the version from the plugin configuration
            $version = $this->getConf('iconify_version');

            // If version is not set, fetch the latest version dynamically
            if (!$version || $version === 'latest') {
                $version = $this->fetchLatestVersion();
            }

            // Build the script URL
            $url = "https://cdnjs.cloudflare.com/ajax/libs/iconify/$version/iconify.min.js";

            // Add the Iconify script
            $event->data["script"][] = [
                "type" => "text/javascript",
                "src" => $url,
                "defer" => "defer"
            ];
        }
    }

    private function fetchLatestVersion() {
        $apiUrl = "https://api.cdnjs.com/libraries/iconify";
        $response = file_get_contents($apiUrl);

        if ($response === false) {
            // Fall back to a default version in case of an error
            return "3.1.1";
        }

        $data = json_decode($response, true);

        if (isset($data['version'])) {
            return $data['version'];
        }

        // Fall back to a default version if the API response is not as expected
        return "3.1.1";
    }
}
