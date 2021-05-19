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

In general this plugin extends CF7 with the following features:

- [Data handling](#data-handling): Process data using the capabilities of the WordPress back-end.
- [Data sourcing](#data-sourcing): Dynamically load data lists into fields with options (checkboxes, radio buttons and menus).
- [Default values](#default-values): Load a default value for field.

These features can be enabled for whatever CF7 form you specify, check out [usage](#usage) to learn more.

### Capabilities

All available actions can only be executed by users whom have the right capabilities. The capability that the user needs for execution of the desired action is the same as the one that is required by the similar action in the [WordPress Admin Dashboard](https://wordpress.com/support/dashboard/).

### Usage

This section describes how to install and configure the plugin. The configuration differs per entity and will be further specified in one of the sections below. In general the plugin can be used as described in the following steps, showing how to configure a form what allows you to edit the currently logged-in user's profile:

1. Install and activate the [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) plugin if you didn't already.
2. Add the plugin to your WordPress environment.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Add or edit an CF7 form by going to forms page by clicking on the 'Contact' menu item. 
5. In the form editor add form tag what will create an input for editing the user meta `favorite_page`:
   1. Use the special name `cms_user_meta_favorite_page` to tell WordPress what field should be saved as the email.
   2. Define the default value for the input by adding `default:user_meta_favorite_page` to the form tag.
   3. Add the source for the list of items the user can choose from.

   This will result in a form tag like:
   ```
   [select cms_user_meta_favorite_page default:user_meta_favorite_page data:wp_post?post_type=page&order=ASC&orderby=title]
   ```
6. Last but not least enable the data handling feature, also tweak some CF7 features (read more [here](https://contactform7.com/additional-settings/)):
   ```
   edit_profile: on

   # CF7 feature tweaks
   skip_mail: on
   subscribers_only: on
   ```
#### Data handling

The following tables all have a "field name" column which should be applied to the name part of the form tag in the form editor.

- The field names in the table below only will be processed if you enable the `edit_profile` feature.

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

#### Data sourcing

Note that the creator of the CF7 plugin also created another plugin called "Listo". This plugin supports several data sources to be loaded into inputs with options (checkboxes, radio buttons and select menus). Read more about it [here](https://contactform7.com/listo/) to understand how to use it.

The source names in the table below can be used in combination with the `data` key to load in a particular data source into the options of the input, for example: 

```
[checkboxes my-input data:<source_name>]
```

Where `<source_name>` is one of the values from the "Source name" column from the table below. 

| Source name      | Description
|------------------|------------
| `wp_post?<args>` | Get a list of posts, labeled with the `post_title` attribute. Customize the [query string](https://developer.wordpress.org/reference/functions/wp_parse_args/) `<args>` using any [WP_Query parameter](https://developer.wordpress.org/reference/classes/wp_query/#parameters) that doesn't require square brackets (`[`, `]`). For example to get a list of all pages you can use `[select my-input data:wp_post?post_type=page]`.
| `wp_term?<args>` | Get a list of terms, labeled with the `name` attribute. Customize the [query string](https://developer.wordpress.org/reference/functions/wp_parse_args/) `<args>` using any [WP_Term_Query parameter](https://developer.wordpress.org/reference/classes/wp_term_query/__construct/#parameters) that doesn't require square brackets (`[`, `]`). For example to get a list of all categories you can use `[select my-input data:wp_term?taxonomy=category]`.
| `wp_user?<args>` | Get a list of users, labeled with the `user_login` attribute. Customize the [query string](https://developer.wordpress.org/reference/functions/wp_parse_args/) `<args>` using any [WP_User_Query parameter](https://developer.wordpress.org/reference/classes/WP_User_Query/prepare_query/#parameters) that doesn't require square brackets (`[`, `]`). For example to get a list of all subscribers you can use `[select my-input data:wp_user?role=subscriber]`.

#### Default values

Note that CF7 already partly supports loading default values:

- [Getting default values from the context](https://contactform7.com/getting-default-values-from-the-context/)
- [Setting default values to the logged-in user](https://contactform7.com/setting-default-values-to-the-logged-in-user/)
- [Getting default values from shortcode attributes](https://contactform7.com/getting-default-values-from-shortcode-attributes/)

This plugin extends the above list with the default values described in the table below. The value names in the table below can be used in combination with the `default` key, just like as described in the article of CF7 (see list above this paragraph), for example:

```
[text my-input default:<value_name>]
```

Where `<value_name>` is one of the values from the "Value name" column from the table below. 

| Value name             | Description
|------------------------|------------
| `user_meta_<key_name>` | Any custom user meta data, where `<key_name>` is the key name of the meta data.
## Frequently Asked Questions

TBD

## Issues & Contributions

Please submit issues or your contributions for this plugin on the [Github Repository](https://github.com/LSVH/wp-contact-form-7-cms).

## Changelog

%%CHANGELOG%%
