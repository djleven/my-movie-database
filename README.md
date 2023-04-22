=== My Movie Database ===

Contributors: djleven
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Y5DGNQGZU92N6
Tags: movie, movies, film, tv, television, television series, tv show, TMDb, cast, crew
Requires at least: 4.6
Requires PHP: 5.6
Tested up to: 6.2
Stable tag: 3.0.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

My Movie Database allows you to easily add detailed information about movies, tv shows and people you choose. The data comes from the Movie Database (TMDb).

== Description ==

The My Movie Database plugin compliments your content by adding information about the movies, the television shows and the people in the industry.

The plugin was developed to enrich your movie or tvshow content / review by 'automatically' adding the related information and allowing you to focus on your writing instead.

You can use it via shortcodes or within WordPress post types and customize it to make it fit your theme and design. See the [my movie database website](https://mymoviedb.org) for full details.

The data comes from [The Movie Database (TMDb)](https://www.themoviedb.org), the leading crowdsourced movie industry information project. This means that the plugin will make calls to the [TMDb api](https://www.themoviedb.org/documentation/api) (in other words their 'website service') to retrieve the requested data. The TMDb API service is provided free of charge.
The My Movie Database plugin is in no way endorsed, affiliated to, nor certified by TMDb.

= Documentation and support =

You can find documentation on [how to use the plugin](https://mymoviedb.org/how-to-use-the-mmdb-plugin/), [configuration and customization options](https://mymoviedb.org/plugin-configuration-mmdb-options-page/) and relevant [demos](https://mymoviedb.org/plugin-configuration-mmdb-options-page/) on the [my movie database website](https://mymoviedb.org). If you cannot find the answer to your question in any of the documentation, check the [support forum](https://wordpress.org/support/plugin/my-movie-database/) on WordPress.org. If you still cannot solve the issue you are having, feel free to open a new ticket.

== Upgrade Notice ==

= 3.0.0 =

New features and bugfixes in this long overdue update

Features:
* New image / column size configuration option and automatic responsive column layout for lists (cast, crew and tv seasons sections)
* New template configuration options for the header and body text color.
* Caching of TMDb data for even faster pageloads and more performant js build.
* User TMDb API key option, to use your own API key if you wish.
* Cleaner plugin css removing the template bootstrap dependency.
* Improvement of js translation method, commitment to more and better language availability in the future. 
* Added TMDb link and id on admin post type screens.
* Added option to disable Gutenberg editor for plugin post types.
* Made plugin instance a Singleton to facilitate 3rd party integrations
* Added debounce to TMDb search input.

Bugfixes:
* Failure in registering plugin script handle in some templates with earlier calls.
* Hover on overview setting was not working.
* Language bug breaks overview for some resource types (iso_639_1 data mismatch).
* Faulty ordering of crew and cast credits.

== Screenshots ==

1. The accordion template, main section.
2. The accordion template, cast section.
3. The tabs template, main tab.
4. Your search results. Note the TMDb Id is visible (Needed if you use a shortcode).
5. The main settings for TvShow (Same for Movies and Persons except for the hide section labels)
6. The advanced settings section

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

= 3.0.0 =
* Added: Automatic responsive column layout for lists without need to set a preset option
* Added: New image / column size configuration option (small, medium, large) for lists (cast, crew and tv seasons sections)
* Removed: Responsive width presets configuration option (small, medium, large)
* Added: Add cache purge button, TMDb link and id on admin post type screens
* Added: User TMDb API key option
* Added: ~~Custom class list setting option for responsive column layout (cast and crew sections)~~
* Added: Use WordPress i18n for js to have POT files properly populated, committing to the translate.wordpress.org process.
* Added: New template configuration options for the header and body text color.
* Removed: mmdb_templates folder and only allow css file override in theme folder
* Removed: Bootstrap file and corresponding settings option.
* Changed: Refactored plugin css removing the template dependency on bootstrap file. 
* Bugfix: Failure in registering plugin script handle in some templates
* Added-dev: Update vue app to Vue3, composition API and Typescript
    - Fix all node dependency vulnerabilities
    - Make project Typescript and jest ready
    - Switch from direct Webpack setup to vue-cli-service

= 2.5.0 =
* Bugfix: Hover on overview setting not working
* Bugfix: Language bug breaks overview when iso_639_1 data mismatch
* Added: Add option to disable Gutenberg editor for plugin post types
* Added: Make plugin instance a Singleton to facilitate 3rd party integrations
* Added: Debounce to TMDb search input.
* Added: Caching of API responses from TMDb.
* Added: Transpiled js and webpack integration.

= 2.0.7 =
* Bugfix: Date to local time conversion inaccuracy

= 2.0.6 =
* Added: French and Italian (via @PandaSekh) translations
* Added: Updated languages files to v2.x of plugin
* Bugfix: Translation not working (regression)
* Added: Option to make plugin taxonomies non-hierarchical
* Added: Wordpress tags alongside categories for mmdb post types
* Added: Made all columns sortable on post type admin list view
* Added-dev: Refactored PostTypes for plugin needs

= 2.0.5 =
* Bugfix: PHP warning from Jetpack's Publicize and Sharing conflict fix

= 2.0.4 =
* Added: Add support for 'my-movie-db' shortcode
* Added: Publicize and wpcom-markdown support for custom post types
* Bugfix: Conflict with Jetpack's Publicize connections and Sharing buttons
* Minor: Remove forgotten .vue files and update 'Tested up to' version 5.3

= 2.0.3 =
* Bugfix: Cast / crew hide sections bug.

= 2.0.2 =
* Added: Display (existing) file read errors only if wp debug display, plugin and wp debug mode are turned on. Always log these errors if possible.
* Added-dev: Refactor file structure and class / variable naming to optimise code readability. Split dependencies for admin vs public and load only when necessary.
* Added: Flush permalinks after plugin activation (so it won't have to be done manually) to get custom post type pages to appear immediately.

= 2.0.1 =
* Bugfix: Remove experimental SFC (and httpVueLoader) in favor of component template literals transpiled inline by babel

= 2.0.0 =
* Added: Javascript asynchronous template rendering (using VueJS)
    -  Improved page load speed and overall user experience
* Added: Transition effect configurable option when switching between sections / tabs
* Added: Overview (description) on hover (configurable option) for person credits and tvshow seasons
* Added: Enhanced admin search UI and preview resembling the frontend output based on selected settings
* Added: Rearrangement of person credit sections with improved section consistency (crew / cast credits)
* Added-dev: Template setting to load desired VueJs components configurable via JSON
* Added-dev: JS template translation string setting configurable via JSON
* Preserved: Overall styling of the two main templates, tabs and accordion, and all previous settings
* Removed: PHP based templates and tmdb API library
* Removed: Section 4 for persons

= 1.3.2 =
* Bugfix: When Gutenberg is used thickbox stylesheet is no longer loaded by wp
= 1.3.1 =
* Added: Custom post types archive enabled
  - https://wordpress.org/support/topic/post-type-archive-slug/
* Bugfix: various issues relating to unavailable content
* Bugfix: bug when tmdb servers are unavailable / down

= 1.2.1 =
* Added: Ability to associate WordPress categories to movies, tvshows and persons
* Added: Dates now appear with WordPress settings format by default
* Added: Date methods now accept custom date format argument (templating)
* Added: Ability to remove associated movie, tvshow, person from post
* Bugfix: custom type taxonomy not appearing in menu
* Bugfix: screen errors when WordPress post as movie lacks tmdbID

= 1.1.1 =
* First release.
