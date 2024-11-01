=== Plugin Name ===
Contributors: ctomczyk
Tags: contact form 7,comments,spam,prevent,protection
Requires at least: 4.7
Tested up to: 6.4.3
Stable tag: 1.3.9
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Spam Prevention for WP Contact Form 7 (manage multiple contact forms) and WordPress Comments.

== Description ==

Spam Prevention for WP Contact Form 7 and WordPress Comments.
This plugin adds a small code snippet to determine page scroll and add dynamically a unique token.

If the token doesn't exists while submitting or call directly API then the incoming request will be rejected.

You can see how it works on [SiteLint](https://www.sitelint.com/) website.

== Installation ==

1. Upload `/contact-form-7-prevent-spam` folder to the `/wp-content/plugins/` directory or install "Spam Prevention for Contact Form 7 and WordPress Comments" plugin in WordPress.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. That's all.

== Changelog ==

= 1.3.9 =
* Adjusting and shortening link text to SiteLint

= 1.3.8 =
* Fixing "class SLSP_SiteLintSpamPreventionPublic does not have a method "handleWpCommentFormSubmitAction""

= 1.3.7 =
* Uploading version verified on WordPress 6.4.2

= 1.3.6 =
* Set lowest priority for adding SiteLint logo using PHP_INT_MAX

= 1.3.5 =
* Fixing reference to the method handleSubmitContactForm7FormAction

= 1.3.4 =
* Code formatting and updating version info; Tested up to: 6.3

= 1.3.3 =
* Use wp_print_footer_scripts instead of wp_footer to print <script> code

= 1.3.2 =
* Call add_action before function declaration

= 1.3.1 =
* Code formatting and updating version info

= 1.3 =
* Change add_action to do_action; return $submission in handleSubmitContactForm7FormAction function

= 1.2 =
* Replace empty string for "action" attribute in the <form> with a valid URL "#"

= 1.1 =
* Determine, if whole contact form is rendered within current browser viewport and if so then apply solution immediately

= 1.0 =
* Initial version of the Plugin
