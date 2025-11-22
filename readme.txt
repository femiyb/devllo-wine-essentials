=== Devllo Wine Essentials ===


Contributors: devllo
Tags: woocommerce, wine, product, comparison
Requires at least: 6.0
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds wine profile fields, simple recommendations, and a two-item comparison flow for WooCommerce products.

== Description ==
Devllo Wine Essentials extends WooCommerce with a Wine Details tab, frontend wine profile display, lightweight recommendations based on grape varietal, and a two-item comparison table via the `[dwe_compare]` shortcode. No custom tables are created; all data is stored using post meta and WooCommerce settings.

== Installation ==
1. Upload the plugin files to `/wp-content/plugins/devllo-wine-essentials/` or install via the Plugins screen.
2. Activate the plugin through the "Plugins" screen.
3. Open any product and fill out the **Wine Details** tab fields.
4. Add the `[dwe_compare]` shortcode to a page and select it under WooCommerce → Settings → Wine Essentials.

== Frequently Asked Questions ==
= Where is data stored? =
All wine information is stored as standard WooCommerce product meta fields with `_dwe_` prefixes.

= How do I override the templates? =
Copy the templates from `public/templates/` into `yourtheme/devllo-wine-essentials/` and adjust as needed.

== Changelog ==
= 1.0.0 =
* Initial release with wine profile, similar wines, and comparison table.
