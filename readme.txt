=== Devllo Wine Essentials ===


Contributors: devllo, femiyb
Tags: woocommerce, wine, product, comparison
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds wine profile fields, simple recommendations, and a two-item comparison flow for WooCommerce products.

== Description ==

Devllo Wine Essentials adds simple, opinionated wine profiles to WooCommerce
products – perfect for small wine shops who want better product storytelling
without complex configuration.

Features:

- Wine profile block with highlights, type, grape, region, body, sweetness, aroma.
- Winery / producer, drinking style, ABV and food pairing fields.
- “Similar Wines” section based on matching grape varietal.
- Lightweight 2‑item comparison table powered by a shortcode.
- Clean admin UI for wine details and global settings.

== Installation ==
1. Upload the plugin files to `/wp-content/plugins/devllo-wine-essentials/` or install via the Plugins screen.
2. Activate the plugin through the "Plugins" screen.
3. Open any product and fill out the **Wine Details** tab fields.
4. Add the `[dwe_compare]` shortcode to a page and select it under WooCommerce → Settings → Wine Essentials.

== Frequently Asked Questions ==

= How are similar wines selected? =

Similar wines are chosen by matching the "Grape varietal" meta on other
products. The current product is excluded, and you can control how many
similar wines are shown in the plugin settings.

= Will non‑wine products appear in Similar Wines? =

No. Only products that have wine details saved (such as grape varietal) are
considered for the Similar Wines section.

= How do I set up the comparison page? =

Create a normal WordPress page, add the [dwe_compare] shortcode to the
content, then choose that page under "Comparison page" in the plugin
settings.

= Does this plugin create custom tables or taxonomies? =

No. All data is stored in standard `postmeta` using simple meta keys, which
keeps the plugin light and portable.

== Screenshots ==

1. Wine details tab inside the WooCommerce product editor.
2. Wine profile block on the single product page.
3. Similar Wines section with matching grape varietal.
4. Two‑product comparison table showing key wine attributes.
5. Settings screen for toggling profile, similar wines and compare behavior.

== Changelog ==
= 1.0.0 =
* Initial release with wine profile, similar wines, and comparison table.
