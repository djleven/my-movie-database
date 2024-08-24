=== My Movie Database ===

Contributors: djleven
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Y5DGNQGZU92N6
Tags: movie, movies, film, tv, television, television series, tv show, TMDb, cast, crew
Requires at least: 5.0.22
Requires PHP: 5.6
Tested up to: 6.6.1
Stable tag: 3.1.1
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

My Movie Database allows you to easily add detailed information about movies, tv shows and people you choose. The data comes from the Movie Database (TMDb).

== Description ==

My Movie Database enriches your content by allowing you to easily add detailed information about the movies, tv shows and people in the industry you choose.

You can use it via shortcodes or within WordPress post types and customize it to make it fit your theme and design.

Designed to be responsive, mobile friendly, intuitive and non-intrusive on your current WordPress theme. Carefully (re) written for very fast pageloads and minimal impact on your WordPress site.

= Widget Content Overview =

* Movie, tv show and person widgets come with overview, cast and crew credits sections.
* Movies also have a trailer section, while tv shows have a seasons section.
* People crew and cast sections each have credits listed for movies and tv shows separately.

Have a look at the demo video to see some features listed below and visit the [my movie database website](https://mymoviedb.org) for full details.

[youtube https://youtu.be/vUGGxX7maTg]

= Main Features / Options =

* Comes with two main templates, one using tabs and the other an accordion model to navigate between the sections.
* Easily customise background and text colors for the template header and body sections, respectively.
* Select image / column size for all lists (small, medium, large).
* Select sections to hide, the position of the widget inside your content as well as a transition effect.
* Person crew, cast and tv seasons sections have an overview description when hovering (or clicking for touch devices) over list items (optional).
* Ability to use your own TMDb API key if you wish (optional).
* Option to disable Gutenberg editor for plugin post types.


= External API Service Provider =

The data comes from [The Movie Database (TMDb)](https://www.themoviedb.org), the leading crowdsourced movie industry data initiative. Calls to the [TMDb api](https://www.themoviedb.org/documentation/api) are provided free of charge, and we are grateful for their tremendous generosity.
My Movie Database is no way endorsed or certified by TMDb.

= Documentation and support =

You can find documentation on [how to use the plugin](https://mymoviedb.org/how-to-use-the-mmdb-plugin/), [configuration and customization options](https://mymoviedb.org/plugin-configuration-mmdb-options-page/) and relevant [demos](https://mymoviedb.org/demos/) on the [my movie database website](https://mymoviedb.org).

If you cannot find the answer to your question in any of the documentation, check the [support forum](https://wordpress.org/support/plugin/my-movie-database/) on WordPress.org.
If you still cannot solve the issue you are having, feel free to open a new ticket.

= Join our mailing-list! =

[Join our mailing list](https://mymoviedb.org/join-our-mailing-list/) and receive news about upcoming developments. You may also occasionally receive an invitation to provide feedback.

We will not flood your email box! You can expect only about 5 to 10 emails per year.

Speaking of feedback, if you use this plugin, would you please follow the link in the plugin settings page to fill out our survey? We will love you for it!

== Screenshots ==

1. Tab template, main section for a movie.
2. Tab template, main section for a tv show, brightly colored.
3. Accordion template, main section for a tv show.
4. Cast section, accordion template (movie and tv shows cast sections are the same).
5. Person crew credits with medium size images and overview on hover.
6. Tv show seasons section with large size images.
7. Movie trailer section.
8. Search results. Note the TMDb Id is visible (needed if you use a shortcode). Also with Gutenberg editor disabled option.
9. Cast section in the admin backend (selected from search and saved).
10. The main settings for Movie (same for Tv Shows and Persons except for the hide section options)
11. The advanced settings section

== Installation ==

### Fast and easy install

#### From the WordPress admin

1. Log into your WordPress site and navigate to the admin area.
2. Go to: **Plugins &gt; Add New**.
3. Enter **"My Movie Database"** in the search field located at the top right corner of the page.
4. Once you find the plugin click on **"Install Now"**.
5. Select **"Install Now"**
6. After the installation success message, select **"Activate"** and you’re ready to go.

### Alternative installations

**Download a copy of the plugin and save it to your computer.** <br>
Now you can install it using the WordPress admin interface or by manually uploading it.

#### From the WordPress admin

1. Log into your WordPress site and navigate to the admin area.
2. Go to: **Plugins &gt; Add New**.
3. Select **"Upload Plugin"** from the top of the page.
4. Click on **"browse"** and locate the plugin you downloaded on your hard drive.
5. Select **"Install Now"**
6. After the installation success message, select **"Activate"** and you’re ready to go.

#### Manual upload

1. Manually upload the plugin to your WordPress plugins folder.
2. Extract the zip file
3. Navigate to your Wordpress admin area
4. Locate the plugin and select **"Activate"**

== Changelog ==

= Version 3.1.0 - AUG 22ND, 2024 =

**Features**

*  Added: Setting to hide overview section IMDB and homepage links respectively.
*  Added: Directors to movie overview section.

**Bugfixes**

* Delete cache not working on Gutenberg edit pages.

**Enhancements**

*  Added: Translation and development contribution credits on admin settings page.
*  Added: Spanish and Finnish translations.
*  Improved: German and French translation.
*  Added: PSR-4 autoloader implementation.


= Version 3.0.3 - MAY 19TH, 2023 =

**Bugfixes**

* Regression: Plugin post type taxonomy option not showing on Gutenberg edit pages.
* Regression: TMDb movie links broken.


= Version 3.0.2 - MAY 8TH, 2023 =

**Bugfixes**

* Correct the i18n JSON hash that failed to load js translations
* Place local non-locale specific i18n files last in the load order hierarchy.

**Enhancements**

* Minor styling improvements to settings page.

= Version 3.0.1 - MAY 4TH, 2023 =

**Bugfixes**

* Hotfix: TMDb id  not being saved in post type screen.
* Minor styling fix to accordion sub header padding and border color restore the look it had in v2.0.x.

**Enhancements**

* Improvement of WordPress readme and new updated screenshots.


= Version 3.0.0 - MAY 4TH, 2023 =

**Features**

* New image / column size configuration prefix options (small, medium, large).
* New template configuration options for the header and body text color.
* New user TMDb API key option, to use your own API key if you wish.
* New option to disable Gutenberg editor for plugin post types.
* Caching of TMDb data for even faster pageloads.
* Aggregated crew credits under maximum one image per list.
* Automatic responsive column layout (no need to select size prefix like before).
* Improved styling and cleaner css (removed the bootstrap library dependency).
* Improvement of js translation method, commitment to better overall language availability in the future.
* More performant js build (upgrade to Vue 3, added TypeScript and webpack bundling).
* Made plugin instance a Singleton to facilitate 3rd party integrations.
* Added debounce to TMDb search input.
* Added TMDb link and id on admin post type screens.

**Bugfixes**

* Failure in registering plugin script handle in some templates with earlier calls.
* Hover on overview setting was not working.
* Language bug that broke overview for some resource types (iso_639_1 data mismatch).
* Faulty ordering of crew and cast credits.

= For versions prior to 3.0.0 =

You can find the full [plugin changelog](https://mymoviedb.org/changelog/) on our website.

For developers: Check out the [project repository on github](https://github.com/djleven/my-movie-database/).
