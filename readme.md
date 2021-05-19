# Contact Form 7: CMS Integration

Contributors: lsvh  
Donate link: https://github.com/LSVH/wp-contact-form-7-cms  
Tags: users, administration  
Requires at least: 5.0  
Requires PHP: 7.3.0  
Tested up to: 5.7  
Stable tag: %%VERSION%%  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Manage entities of the CMS (WordPress) via Contact Form 7.

[![](https://img.shields.io/wordpress/plugin/installs/contact-form-7-cms?style=for-the-badge)](https://wordpress.org/plugins/contact-form-7-cms/)

## Description

Manage entities of the CMS (WordPress), like [users](https://learn.wordpress.org/workshop/user-management/), pages and posts, via [Contact Form 7 (CF7)](https://wordpress.org/plugins/contact-form-7/).

### Features

The plugin currently supports the following actions to be enabled for your CF7 form:

* Update the profile of the currently logged in user (`edit_profile`).

The plugin can be enabled for whatever CF7 form you specify, check out [usage](#usage) to learn more.

### Capabilities

All available actions can only be executed by users whom have the right capabilities. The capability that the user needs for execution of the desired action is the same as the one that is required by the similar action in the [WordPress Admin Dashboard](https://wordpress.com/support/dashboard/).

### Usage

This section describes how to install and configure the plugin. The configuration differs per entity and will be further specified in the section dedicated to it. In general this is how you can use this plugin:

1. Install and activate the [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) plugin if you didn't already.
2. Add the plugin to your WordPress environment.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Add or edit an CF7 form by going to forms page by clicking on the 'Contact' menu item. 
5. Make use one of the special field names, as described in the entity table(s) below, to configure your input in the CF7 form editor.
7. In the 'Additional Settings' tab of the form editor add one of the included [features](#features) to enable the corresponding action's functionality.

### Default values

Note that CF7 already partly supports loading default values:

- [Getting default values from the context](https://contactform7.com/getting-default-values-from-the-context/)
- [Setting default values to the logged-in user](https://contactform7.com/setting-default-values-to-the-logged-in-user/)
- [Getting default values from shortcode attributes](https://contactform7.com/getting-default-values-from-shortcode-attributes/)

#### Data sources

Note that the creator of the CF7 plugin also created another plugin called "Listo". This plugin supports several data sources to be loaded into inputs with options (checkboxes, radio buttons and select menus). Read more about it [here](https://contactform7.com/listo/) to understand how to use it.

The source names in the table below can be used in combination with the `data` key to load in a particular data source into the options of the input, for example: 

```
[checkboxes my-input data:<source_name>]
```

Where `<source_name>` is one of the values from the table below. 
| Source name      | Description
|------------------|------------
| `wp_post?<args>` | Get a list of posts, labeled with the `post_title` attribute. Customize the [query string](https://developer.wordpress.org/reference/functions/wp_parse_args/) `<args>` using any [WP_Query parameter](https://developer.wordpress.org/reference/classes/wp_query/#parameters) that doesn't require square brackets (`[`, `]`). For example to get a list of all pages you can use `[select my-input data:wp_post?post_type=page]`.
| `wp_term?<args>` | Get a list of terms, labeled with the `name` attribute. Customize the [query string](https://developer.wordpress.org/reference/functions/wp_parse_args/) `<args>` using any [WP_Term_Query parameter](https://developer.wordpress.org/reference/classes/wp_term_query/__construct/#parameters) that doesn't require square brackets (`[`, `]`). For example to get a list of all categories you can use `[select my-input data:wp_term?post_type=category]`.

#### User entity

The field names in the entity table below only work when you enable the `edit_profile` feature in the form. When applied to an input's name, then the plugin will update the corresponding attribute of the currently logged-in user after submission of the form.

| Field name                 | Description
|----------------------------|------------
| `cms_user_nicename`        | The URL-friendly user name.
| `cms_user_pass`            | The user's password.
| `cms_user_url`             | The user's URL.
| `cms_user_email`           | The user's email address.
| `cms_user_display_name`    | The user's display name. Default is the user's username.
| `cms_user_nickname`        | The user's nickname. Default is the user's username.
| `cms_user_first_name`      | The user's first name.
| `cms_user_last_name`       | The user's last name.
| `cms_user_description`     | The user's biographical description.
| `cms_user_meta_<key_name>` | Any custom user meta data, where `<key_name>` is the key name of the meta data.

## Screenshots

1. Example: edit profile form.  
   ![Example: edit profile form](.wordpress-org/screenshot-1.png)
2. Example: additional settings.  
   ![Example: additional settings](.wordpress-org/screenshot-2.png)

## Frequently Asked Questions

### Question

answer

## Issues & Contributions

Please submit issues or your contributions for this plugin on the [Github Repository](https://github.com/LSVH/wp-contact-form-7-cms).

## Changelog

%%CHANGELOG%%
