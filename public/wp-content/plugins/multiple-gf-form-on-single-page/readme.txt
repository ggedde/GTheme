=== Gravity Forms: Multiple Form Instances Add On ===
Contributors: nikunj8866
Donate link: https://paytm.business/link/15669/LL_14630339
Tags: gravity, form, multiple, gravity forms
Requires at least: 4.5
Tested up to: 5.4.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows multiple instances of the same form to be run on a single page when using AJAX.

== Description ==

Gravity Forms: Multiple Form Instances is used in conjunction with the awesome Gravity Forms plugin.

Usually, when you use multiple Gravity Forms with AJAX enabled on the same page, this causes issues with multiple form submission & error display, infinite loading and other issues.

This plugin addresses this issue, allowing multiple forms to be displayed on the same page without any issues.

== Installation ==

1. Install Gravity Forms: Multiple Form Instances either via the WordPress.org plugin directory, or by uploading the files to your server.
1. Activate the plugin.
1. That's it. You're ready to go!

== Changelog ==

= 1.0 =
Initial version.

== Frequently Asked Questions ==

= Installation & Configuration =

This plugin does not need any customization.

Simply install and activate it, and it will do its magic with your Gravity Forms.

= How It Works =

In order for the magic to work, various occurences of the form ID are replaced with a random ID when rendering the form. This allows for multiple instances of the same form to be submitted without having the issue of submitting form B when submitting form A.

If a form has already been submitted, the submitted random ID will be preserved and used for the next submissions as well, otherwise a new unique ID is generated.

= Customization (actions & filters) =

The plugin uses the default gform_get_form_filter Gravity Forms filter for performing the replacement.

Additionally, the plugin offers the following actions & filters:

gform_multiple_instances_strings
$strings (array). An array of find => replace pairs. Occurences of "key" will be replaced with the corresponding "value".

$form_id (int). The original form id.

$random_id (int). The new, randomly generated form id.

This filter allows you to modify the default strings that will be replaced. The keys are the original strings, and the corresponding values are the strings that keys will be replaced with.


