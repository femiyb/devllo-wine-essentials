=== Devllo Wine Toolkit for WooCommerce ===
Contributors: devllo
Tags: woocommerce, wine, product details, wine profile, wine comparison
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

The complete wine toolkit for WooCommerce. Add wine profiles, similar wine recommendations, and side-by-side comparison to your wine shop.

== Description ==

Devllo Wine Toolkit for WooCommerce adds everything a wine shop needs to present products properly and help customers make informed purchase decisions.

**Wine Profile**
Add detailed wine information to any WooCommerce product — grape varietal, vintage, region, winery, appellation, body, sweetness, aroma, ABV, drinking style, producer, and food pairings. All fields are optional and individually toggleable from the settings page.

**Similar Wine Recommendations**
Automatically show similar wines on each product page based on shared grape varietal. Configure how many wines to show (1–3) and how they are sorted.

**Wine Comparison**
Let shoppers add up to two wines to a comparison list and view them side by side on a dedicated comparison page. Works via a simple shortcode or Gutenberg block. No page builders required.

**Wine Badges**
Highlight products with contextual badges — New, Best Seller, Award Winning, or Limited Stock — displayed on shop listings and single product pages.

**Theme Friendly**
The plugin outputs minimal structural CSS only. Typography, colours, and spacing inherit from your active theme. A single CSS custom property (--dwe-accent) is available as a styling override point.

= Features =

* Custom wine product data tab in the WooCommerce product editor
* 14 wine-specific fields — all individually toggleable
* Configurable profile position (before summary, after summary, after tabs)
* Similar wines section based on grape varietal match
* Session-based wine comparison list (max 2 wines)
* Comparison table shortcode [devllowine_compare]
* Gutenberg block for the comparison table
* Wine badges on shop and product pages
* React-powered settings UI with auto-save
* Theme-safe CSS — no hardcoded colours
* Translation ready

= Who is this for? =

Any WooCommerce store selling wine that wants to present products with proper detail and give customers the tools to compare and discover wines.

== Installation ==

1. Upload the plugin folder to /wp-content/plugins/
2. Activate the plugin through the Plugins menu in WordPress
3. Go to WooCommerce > Wine Essentials to configure settings
4. Create a page for the comparison table and add the [devllowine_compare] shortcode to it
5. Select that page under WooCommerce > Wine Essentials > Comparison page
6. Add wine details to any product via the Wine Details tab in the product editor

== Frequently Asked Questions ==

= Does this work with any WooCommerce theme? =
Yes. The plugin outputs layout-only CSS and inherits typography and colours from your active theme.

= Can I control which fields appear in the wine profile? =
Yes. Every field can be individually toggled on or off from WooCommerce > Wine Essentials > Show in Wine Profile.

= How does the similar wines feature work? =
It queries other published products that share the same grape varietal value. It matches on exact text, so consistent data entry is important.

= How many wines can be compared at once? =
Two wines at a time. Adding a third automatically replaces the oldest.

= Can I override the plugin templates? =
Yes. Place your custom templates in your theme under devllo-wine-essentials/ and they will take priority over the plugin defaults. This follows the standard WooCommerce template override system.

= Does it work with the block editor? =
Yes. A Wine Comparison block is available in the Gutenberg block inserter as an alternative to the shortcode.

== Screenshots ==

1. Wine profile displayed on a single product page
2. Wine Details tab in the WooCommerce product editor
3. Similar wines section below the product summary
4. Side-by-side wine comparison table
5. Plugin settings page under WooCommerce

== Changelog ==

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.0 =
Initial release — no upgrade steps required.