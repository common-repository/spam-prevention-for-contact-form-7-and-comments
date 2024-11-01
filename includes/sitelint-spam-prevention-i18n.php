<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for SiteLint plugin
 * so that it is ready for translation.
 *
 * @link       https://www.sitelint.com
 * @since      1.0.0
 *
 * @package    SLSP_SiteLint_Plugin_Name_i18n
 * @subpackage SiteLintSpamPrevention/includes
 */

class SLSP_SiteLint_Plugin_Name_i18n {

	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sitelintsp',
			false,
			dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
		);

	}



}
