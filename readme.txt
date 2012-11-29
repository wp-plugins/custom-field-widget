=== Custom Field Widget ===
CONTRIBUTORS: plaintxt.org
DONATE LINK: http://www.plaintxt.org/about/#donate
TAGS: custom field, custom value, custom key, field, value, key, post meta, meta, get_post_meta, widget, sidebar, multiple widgets
REQUIRES AT LEAST: 2.5
TESTED UP TO: 2.6.1
STABLE TAG: 0.1

The Custom Field Widget displays values of custom field keys, allowing post- and page-specific meta sidebar content with limitless applications.

== Description ==

The Custom Field Widget displays values of custom field keys, allowing post- and page-specific meta sidebar content with limitless applications.

Custom Field Widget is for WordPress 2.6.x and features:

* Multiple widget instances possible
* Widget-specific optional title and text
* Conditional functionality, i.e., without a matching key, the widget is not displayed
* Practically unlimited possible uses

== Installation ==

This plugin is installed just like any other WordPress plugin. More [detailed installation instructions](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins "Installing Plugins - WordPress Codex") are available on the WordPress Codex.

1. Download Custom Field Widget
2. Extract the `/custom-field-widget/` folder from the archive
3. Upload this folder to `../wp-contents/plugins/`
4. Activate the plugin in *Dashboard > Plugins*
5. Customize from the *Design > Widgets* menu
7. Enjoy. And then consider donating

In other words, just upload the `/custom-field-widget/` folder and its contents to your plugins folder.

== Use ==

If you are unfamiliar with custom fields, you should first read about them on the [WordPress Codex](http://codex.wordpress.org/Using_Custom_Fields "Using Custom Fields - WordPress Codex").

Custom fields are added to posts and pages from the  *Write > Page* and *Write > Post* menus, just below the main editor area. You may add as many custom fields to a post/page as you like.

There are two separate fields for each custom field: the *key* and its *value*. The Custom Field Widget finds a specified *key* and then displays its corresponding *value* in the sidebar. Without a matching *key*, nothing is displayed.

The Custom Field Widget doesn't necessarily 'do' anything, but it enables an advanced (and often overlooked) feature built-in to WordPress. For example, see [28 Ways to Use WordPress Custom Fields](http://performancing.com/wordpress-tips/jazz-your-site-28-ways-use-wordpress-custom-fields "Jazz Up Your Site: 28 Ways To Use WordPress Custom Fields") for a small picture of possibilities.

I developed this plugin for my own use. I wanted to display a small table of contents for certain pages (which are without categories) in the sidebar dynamically. Without a widget, I would have to edit the sidebar file(s) for each theme I used.

Because each table of contents (a short `ol` of items) varied from page to page, it also had to be specific to each page. So I created a custom field key of `toc` and added the `ol` of items to its value. Enabling the plugin, I had a table of contents appear in the sidebar for each page with a custom field key of `toc`.

The uses and applications of WordPress custom fields are infinite. Just [search for WordPress custom fields](http://www.google.com/search?q=wordpress+custom+fields "Google Search: wordpress custom fields") for thousands of results on this subject.

== License ==

Custom Field Widget, a plugin for WordPress, (C) 2008 by Scott Allan Wallick, is licensed under the [GNU General Public License](http://www.gnu.org/licenses/gpl.html "GNU General Public License").

Custom Field Widget is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

Custom Field Widget is distributed in the hope that it will be useful, but **without any warranty**; without even the implied warranty of **merchantability** or **fitness for a particular purpose**. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with Custom Field Widget. If not, see [http://www.gnu.org/licenses/](http://www.gnu.org/licenses/ "GNU General Public Licenses").

== Frequently Asked Questions ==

= What does this plugin do? =

Custom Field Widget displays the custom field values of a specified custom field key in your sidebar.

= I have no idea what your answer means. =

That's fine. Read the *Use* section for more information on using custom fields and possible applications of this plugin.

= Fine. Can you give me one example of what I could do with this plugin? =

You could use it to display a graphic in the sidebar that you set on a per-post and/or per-page basis. Say you want certain posts/pages to include a graphic that aren't necessarily categorized together. Create a custom field with a common key and this widget will display the corresponding values in the sidebar.

= That's pretty slick. Give me another example. =

No. See the *Use* section and let your imagination run wild.

= I'd like to modify this plugin in some way unavailable through the widget options panel. Will you help me? =

No. I apologize as I am unable to help with modifications with any of my plugins.

= Well, thanks for nothing. =

Not even thanks for the plugin?

= Sure. Thanks for the plugin. =

You're welcome. Enjoy.

== Screenshots ==

1. Custom Field Widget is a multiple-instance widget that shows custom field values matching specified keys in your sidebar.
