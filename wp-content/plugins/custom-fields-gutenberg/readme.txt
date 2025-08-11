=== Custom Fields for Gutenberg ===

Plugin Name: Custom Fields for Gutenberg Block Editor
Plugin URI: https://perishablepress.com/custom-fields-gutenberg/
Description: Restores the Custom Field meta box for the Gutenberg Block Editor.
Tags: gutenberg, custom fields, meta box, blocks
Author: Jeff Starr
Author URI: https://plugin-planet.com/
Donate link: https://monzillamedia.com/donate.html
Contributors: specialk
Requires at least: 4.7
Tested up to: 6.8
Stable tag: 2.4.3
Version:    2.4.3
Requires PHP: 5.6.20
Text Domain: custom-fields-gutenberg
Domain Path: /languages
License: GPL v2 or later

Restores the Custom Field meta box for the Gutenberg Block Editor.



== Description ==

Restores the Custom Field meta box for the Gutenberg Block Editor.

__Update:__ This plugin currently is not needed, as WordPress version 5.0+ displays Custom Fields natively. Just click the settings button (three dots) and go to Options, where you will find the option to display the Custom Fields meta box. So this plugin still works great, but it is recommended to use native WP custom fields instead. For more information, read [this post](https://wordpress.org/support/topic/please-read-7/).


**Features**

* Easy to use
* Clean code
* Built with the WordPress API
* Lightweight, fast and flexible
* Works great with other WordPress plugins
* Plugin options configurable via settings screen
* Focused on flexibility, performance, and security
* One-click restore plugin default options
* Translation ready


**Options**

* Specify the post types that should display custom fields
* Exclude custom fields that are protected/hidden
* Exclude custom fields with empty values
* Exclude specific custom fields by name


**Planned Features**

* Ajaxify adding of new Custom Fields
* Ajax method to Delete custom fields


**Privacy**

This plugin does not collect or store any user data. It does not set any cookies, and it does not connect to any third-party locations. Thus, this plugin does not affect user privacy in any way.

Custom Fields for Gutenberg is developed and maintained by [Jeff Starr](https://x.com/perishable), 15-year [WordPress developer](https://plugin-planet.com/) and [book author](https://books.perishablepress.com/).


**Support development**

I develop and maintain this free plugin with love for the WordPress community. To show support, you can [make a donation](https://monzillamedia.com/donate.html) or purchase one of my books:

* [The Tao of WordPress](https://wp-tao.com/)
* [Digging into WordPress](https://digwp.com/)
* [.htaccess made easy](https://htaccessbook.com/)
* [WordPress Themes In Depth](https://wp-tao.com/wordpress-themes-book/)
* [Wizard's SQL Recipes for WordPress](https://books.perishablepress.com/downloads/wizards-collection-sql-recipes-wordpress/)

And/or purchase one of my premium WordPress plugins:

* [BBQ Pro](https://plugin-planet.com/bbq-pro/) - Super fast WordPress firewall
* [Blackhole Pro](https://plugin-planet.com/blackhole-pro/) - Automatically block bad bots
* [Banhammer Pro](https://plugin-planet.com/banhammer-pro/) - Monitor traffic and ban the bad guys
* [GA Google Analytics Pro](https://plugin-planet.com/ga-google-analytics-pro/) - Connect WordPress to Google Analytics
* [Head Meta Pro](https://plugin-planet.com/head-meta-pro/) - Ultimate Meta Tags for WordPress
* [Simple Ajax Chat Pro](https://plugin-planet.com/simple-ajax-chat-pro/) - Unlimited chat rooms
* [USP Pro](https://plugin-planet.com/usp-pro/) - Unlimited front-end forms

Links, tweets and likes also appreciated. Thanks! :)



== Screenshots ==

1. Plugin Settings Screen (showing default options)
2. Custom Fields displayed on Gutenberg screen



== Installation ==

**Installing the plugin**

1. Upload the plugin to your blog and activate
2. Configure the plugin settings as desired
3. Enable theme switcher via settings or shortcode

[More info on installing WP plugins](https://wordpress.org/support/article/managing-plugins/#installing-plugins)


**Usage**

Works just like the original "Custom Fields" meta box, except:

* __Edit custom field__     &mdash; make any changes and then click the Post "Update" or "Publish" button
* __Add new custom field__  &mdash; add new custom field, click "Update" or "Publish", and then reload the page
* __Delete custom field__   &mdash; set the field custom field Key/Name to a blank value, click "Update" or "Publish", then reload the page


**Uninstalling**

This plugin cleans up after itself. All plugin settings will be removed from your database when the plugin is uninstalled via the Plugins screen. Custom Fields will NOT be removed.


**Like the plugin?**

If you like Custom Fields for Gutenberg, please take a moment to [give a 5-star rating](https://wordpress.org/support/plugin/custom-fields-gutenberg/reviews/?rate=5#new-post). It helps to keep development and support going strong. Thank you!



== Upgrade Notice ==

To upgrade this plugin, remove the old version and replace with the new version. Or just click "Update" from the Plugins screen and let WordPress do it for you automatically.

Note: uninstalling the plugin from the WP Plugins screen results in the removal of all settings and data from the WP database. Custom Fields will NOT be removed.



== Frequently Asked Questions ==

**Is this plugin needed with WP 5.0 and beyond?**

No. As of WordPress 5.0, Custom Fields are natively supported, so this plugin is not needed to view custom fields on posts (via the "Edit Post" screen). Understand however that custom fields may not be supported after 2022, so this plugin may again be useful if/when that happens. For more information, check out [this post](https://wordpress.org/support/topic/please-read-7/).


**Got a question?**

Send any questions or feedback via my [contact form](https://plugin-planet.com/support/#contact)



== Changelog ==

If you like Custom Fields for Gutenberg, please take a moment to [give a 5-star rating](https://wordpress.org/support/plugin/custom-fields-gutenberg/reviews/?rate=5#new-post). It helps to keep development and support going strong. Thank you!


**2.4.3 (2025/03/18)**

* Removes `load_i18n()` function
* Bumps minimum required WP version
* Adds uninstall option `g7g-cfg-dismiss-notice`
* Updates plugin settings page
* Generates new language template
* Tests on WordPress 6.8 (beta)


Full changelog @ [https://plugin-planet.com/wp/changelog/custom-fields-gutenberg.txt](https://plugin-planet.com/wp/changelog/custom-fields-gutenberg.txt)
