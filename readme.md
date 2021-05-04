# Contact Form 7: CMS Integration

Contributors: lsvh  
Donate link: https://github.com/LSVH/wp-contact-form-7-cms  
Tags: users, administration  
Requires at least: 5.0  
Requires PHP: 7.2.5  
Tested up to: 5.7  
Stable tag: 0.1.1  
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

This section describes how to install and configure the plugin.

1. Install and activate the [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) plugin if you didn't already.
2. Add the plugin to your wordpress environment.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Add or edit an CF7 form by going to forms page by clicking on the 'Contact' menu item. 
5. Configure your form inputs to make use of the `name`'s as described in the table below.
6. Use the same name in combination with the `default:` attribute to load in the default value (note: this only works if an already existing object is being modified).
7. In the 'Additional Settings' tab of the form editor add one of the included [features](#features) to enable the corresponding action's functionality.

#### User entity

The fields in the table below only work with the feature: `edit_profile`.

| Field           | Description                                                                                                                                |
|-----------------|--------------------------------------------------------------------------------------------------------------------------------------------|
| `user_login`    | The user's login username. This field cannot be modified.                                                                                  |
| `user_nicename` | The URL-friendly user name.                                                                                                                |
| `user_pass`     | The plain-text user password.                                                                                                              |
| `user_url`      | The user URL.                                                                                                                              |
| `user_email`    | The user email address.                                                                                                                    |
| `display_name`  | The user's display name. Default is the user's username.                                                                                   |
| `nickname`      | The user's nickname. Default is the user's username.                                                                                       |
| `first_name`    | The user's first name. For new users, will be used to build the first part of the user's display name if  `display_name` is not specified. |
| `last_name`     | The user's last name. For new users, will be used to build the second part of the user's display name if  `display_name` is not specified. |
| `description`   | The user's biographical description.                                                                                                       |
| `locale`        | User's locale. Default empty.                                                                                                              |
| `user_meta_*`   | Any custom user meta data, where `*` is the key name of the meta data.                                                                     |

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

<!-- changelog -->
