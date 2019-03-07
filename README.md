# Just Another Theme

Just Another Theme is a lightweight theme good for small personal, business and organizational sites. It is optimized for the DIY site owner with basic CSS skills but who should not be left unattended with a color picker and infinite font choices. Based on Underscores.

## Features

 * One menu
 * Five widget areas
 * Header logo support
 * Multiple theme skins
 * Adjustable main navigation width
 * Adjustable pre-content widget area width
 * Adjustable primary sidebar width
 * Two-column custom page template
 * Optional two-column layout for blog, archive, single post, search and 404 pages.
 * Support for a selection of Google fonts
 * Support for Jetpack's Infinite Scroll
 * Responsive design
 * Accessibility friendly
 * Translation ready

## Gutenberg
 
This theme is not yet fully ready for Gutenberg, but it does contain some Gutenberg support. Custom font sizes and custom colors are disabled.

## Header Logo

The header is optimized for a horizontal logo containing text. The logo size should be 1000x180 pixels.

## Installation

Download the current release of this theme as a zip file. Make sure the file is named just-another-theme.zip.

* In the WordPress admin, go to Appearance > Themes > Add New. (In multisite, go to the network admin's Themes > Add New.)
* Click the Upload Theme button at the top of the page and browse for the zip file.
* Upload the zip file.
* Once the theme is installed, activate it. 

On multisite the theme must be network enabled before it can be activated on a site. To enable the theme on specific sites, go to Sites in the network admin, click the Edit link for the site where you want the theme enabled, choose the Themes tab and enable the theme.

## Credits

This theme would not be as good without the talented people whose work went into it:

* Underscores https://underscores.me/, (C) 2012-2017 Automattic, Inc., [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html)
* normalize.css https://necolas.github.io/normalize.css/, (C) 2012-2016 Nicolas Gallagher and Jonathan Neal, [MIT](https://opensource.org/licenses/MIT)

## Changelog

### 1.0.0

* New release

### 1.1

* Update CSS setting height of header when there is no logo.
* Delete unused instructions file from lang directory
* Add index.html files to prevent directory browsing

### 1.1.1

* Changed references to .sidebar-bottom class to .widgets-bottom in style.css for consistency.
* Fixed a hex number in kiddie-time.css

### 1.2

Updated style.css to add multiple improvements:

* Added flexbox rules for backwards compatibility.
* Changed the hamburger menu icon for mobile display of primary navigation.
* Adjusted header resizing rules for mobile.
* Adjusted right and left padding for screens narrower than 1040 pixels.
* Added the alignfull image style for Gutenberg compatibility.
* Changed a float clear on .widgets-bottom to .bottom-content.
* Tweaked the right and left padding rules for .widgets-bottom widgets.
* Consolidated media queries.

### 1.2.1

Added some useful text styles and set the width of tables in widgets.

### 1.2.2

Fixes Github URI data in style.css.

### 1.3

* Fixed an unclosed paragraph tag in header.php.
* Changed content class name in page files and style.css for clarity.
* Removed unused CSS from all CSS files.
* Formatted code and comments in template-tags.php.
* Added action hooks to header.php, footer.php and page files.
* Updated the translation template.

### 1.4

* Continued to consolidate CSS and remove unused styles.
* Added header styles to editor-style.css.
* Updated the semantic HTML structure in index.php, archive.php and search.php.
* Added selected widget styles for header widgets.
* Added a font-smoothing option to customizer.php.
* Updated the translation template.
* Added classes to selected header.php and footer.php elements to indicate colored backgrounds.
* Updated widgets registration to add classes to widgets indicating color styles and vertical or horizontal display.
* Renamed the template-tags.php file for clarity.
* Moved Customizer option arrays from functions.php to customizer.php.
* Updated comments in functions.php and template-functions.php.

### 1.5

* Added four new skins.
* Completed consolidation of styles.
* Added Customizer options to change the pre-content area widget width and the abiity to hide or show the home page title.
* Removed the core checkbox to display the site title and description and replaced it with a custom checkbox to hide or show the description.
* Extended translation support and updated the translation template.
* Added styling for core widgets.
* Added styling for widgets in the top bar.
* Tested and refined theme appearance on mobile devices.
* Updated code in header.php for better support of header widgets.
* Sharpened the toggle menu image and added a dark version for light-colored skins.
* Updated widget-title styles to make hidden titles available to screen readers.
* Commented functions.php and customizer.php code.

### 1.5.1

* Added custom body class .wp-template and updated body background styles in all CSS files to specify body.wp-template. Workaround for an editor bug that was loading body background colors in the editor.
* Updated a function to add inline editor styles to include a style for links with the class .gobutton. Workaround for an editor bug that was ignoring this style.
* Made the copyright statement font smaller in mobile.
* Adjusted the spacing of primary sidebar, bottom and footer widgets in mobile for consistency.
* Adjusted the background shading of the primary sidebar and bottom widget area in mobile.
* Adjusted the H2, H3 and H4 font sizes and line heights in mobile.

### 1.5.2

* Increased the line height for the menu, pages, archives, category and meta widgets lists.
* Adjusted the link styles for primary sidebar and bottom widget area links.