=== My Movie Database ===

Contributors: djleven
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Y5DGNQGZU92N6
Tags: movie, movies, tv, television series, tv show, TMDb, mmdb, cast, crew
Requires at least: 4.6
Tested up to: 5.4.1
Stable tag: 2.0.7
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

My Movie Database allows you to easily add detailed information about movies, tv shows and people you choose. The data comes from the Movie Database (TMDb).

== Description ==

The My Movie Database plugin compliments your content by adding information about the movies, the television shows and the people in the industry you choose.

The plugin was developed to enrich your movie or tvshow content / review by 'automatically' adding the related information and allowing you to focus on your writing instead.

You can use it via shortcodes or the standard posts method, see below for more info and/or the <a target="_blank" href="https://mymoviedatabase.cinema.ttic.ca/shortcode-default-parameters">live demo page</a>.

The data comes from the <a target="_blank" href="https://www.themoviedb.org">Movie Database (TMDb)</a>, the leading crowdsourced movie industry information community. This means that this plugin will make calls to the <a target="_blank" href="https://www.themoviedb.org/documentation/api"> TMDb api</a> (in other words their 'website service') to retrieve the requested data. The TMDb API service is provided free of charge.
- The My-Movie-Database plugin uses the TMDb API but is in no way endorsed or certified by TMDb.

## New version 2 of the plugin is here!

Version 2 brings many changes, new features and improvements. A big part of the plugin was rewritten from scratch.

**Improvements**

1. Javascript asynchronous template rendering (using VueJS)
2. Improved page load speed and overall user experience (your pages won't wait for the movie data to load)
3. Overview (description) on hover (configurable option) for person credits and tvshow seasons
4. Transition effect configurable option when switching between sections / tabs
5. Enhanced admin search UI and preview resembling the frontend output based on selected settings
6. Rearrangement of person credit sections with improved section consistency (crew / cast credits)
7. Fixed a few bugs

**Breaking changes**

While the overall styling of the two main templates (tabs and accordion) and all previous settings have been preserved, there are some breaking changes:

* Removed: PHP based templates

    This means that previous templates are no longer compatible. This will be a problem if you have made modifications to your templates.

    **If you have copied your templates folder inside your theme, you must delete the copied folder for the plugin to work.**


* Removed: Support for Internet Explorer prior to version 11

    Please note that as of version 2.0 of the plugin, support for the Internet Explorer browser is limited to version 11 only.


* Removed: Section 4 for persons

    The person template has been rearranged, most users should not have a problem with this as it was previously not very nice.

== Installation ==

### Fast and easy install

#### From the wordpress admin

1. Log into your WordPress site and navigate to the admin area.
2. Go to: **Plugins &gt; Add New**.
3. Enter **"My Movie Database"** in the search field located at the top right corner of the page.
4. Once you find the plugin click on **"Install Now"**.
5. Select **"Install Now"**
6. After the installation success message, select **"Activate"** and you’re ready to go.

### Alternative installations

**Download a copy of the plugin and save it to your computer.** <br>
Now you can install it using the wordpress admin interface or by manually uploading it.

#### From the wordpress admin

1. Log into your WordPress site and navigate to the admin area.
2. Go to: **Plugins &gt; Add New**.
3. Select **"Upload Plugin"** from the top of the page.
4. Click on **"browse"** and locate the plugin you downloaded on your hard drive.
5. Select **"Install Now"**
6. After the installation success message, select **"Activate"** and you’re ready to go.

#### Manual upload

1. Manually upload the plugin to your wordpress plugins folder.
2. Extract the zip file
3. Navigate to your Wordpress admin area
4. Locate the plugin and select **"Activate"**

## How to use the plugin

The My-Movie-Database (mmdb) plugin can be used via shortcodes or inside wordpress posts (and post types).

After installing the plugin three custom post types are created in wordpress: Movies, TvShows and Persons.

You can disable any one of them (or all of them if you want to use this plugin <em>only</em> via shortcode) by going into the Advanced options tab of the Movie Database options and selecting "No" for the post types you don't want.

The shortcode method will always be available for all resource types (Movies, TvShows, etc) regardless of the state of the mmdb options for each post type.

Below is an outline of the two methods: Wordpress posts and shortcodes


### Using the plugin with Wordpress posts

So as was mentioned above, by default the plugin will create three custom post types in wordpress: Movies, TvShows and Persons.

These custom post types behave just like your regular wordpress post type except that they have an mmdb section to configure.

##### Adding a New Movie (or editing a Movie post):
Below the content textarea of your Movie post you will find the mmdb search for a movie field.

1. Enter the title of the movie you are looking for.

2. You will then be presented with the search results. Hover over them for further info and click on the desired movie.

   (screenshot 4)

3. Once you have made your selection you must save the post.

That's it! Now if you navigate to the url of your post (front-end), the movie information will be displayed.

**Configuration and customization of display**

From the plugin option page you can configure:

1. which template will be used to display your resource
2. if this should appear before or after the post content
3. select from a predetermined set of width combinations for multiple column arrangements as seen on sections like cast and crew.
4. which sections to display/hide
5. the header and body colors for the available templates
6. the CSS transition to use when switching sections

For the Movie posts only (in the advanced configuration option tab) :

1. You have the option of using the default wordpress posts instead of a new custom post type.</li>
2. You also have the option of renaming the default WP posts into movies or leaving them as is ('Posts').</li>

See the <a target="_blank" href="https://mymoviedatabase.cinema.ttic.ca/plugin-configuration-mmdb-options-page/"> configuration documentation page</a> for more detailed info.

>All the of the above apply for TvShows and Persons as well.

### Using the plugin with shortcodes

The plugin shortcode is [my_movie_db] . The parameters that can be set are:

1. The basic parameters that you need to set are  <strong>id</strong>  and <strong>type</strong>.
2. Optional parameters to override the global plugin settings are :<strong> template, </strong><strong>size, body </strong>(color) and<strong> header </strong>(color).

**1-) id**
The most important parameter is the id of the movie, tvshow or person info you wish to display.  This parameter corresponds to the unique id of the resource at the <a target="_blank" href="https://www.themoviedb.org">TMDb website</a>.

You can find the id by searching for the movie, tvshow or person:

- In the respective custom post type edit screen in your wordpress backend See 'Adding a New Movie (or editing a Movie post)' above (visible on screenshot 4)

- At the TMDb website:

Once you find the desired id you use it like this:

[my_mοvie_db id=yοur_id]

If you don't specify an id the id of 655 will be used.

**2-) type**
The type parameter corresponds to the type of resource you are looking for. Possible acceptable values are **movie**, **tvshow** or **person**

So for example if you are looking to display a tvshow your shortcode should look like this:

[my-mοvie-db id=yοur_id type=tvshow]

The default type value is "movie" so if you don't specify the type, the movie type will be used.

**3-) template (optional - override)**

The template parameter defines the mmdb template you wish to use to display your resource.

<ul>
 	<li>Current templates available that ship with the plugin  are **tabs** and **accordion.**</li>
</ul>

So if for example you want to use the accordion template file your shortcode will look like this:

[my-mοvie-db id=your_id type=yοur_type template=accordion]

The default template value is "tabs" so if you don't specify the template, the tabs template will be used.

If you want to make/use your own template, and/or edit the existing templates refer to <a target="_blank" href="https://mymoviedatabase.cinema.ttic.ca/plugin-configuration-mmdb-options-page/"> the configuration documentation</a> under 'Choosing the template to use'.

**4-) size (optional - override)**

Depending on the width setup/style of your target page, you can select from a predetermined set of width combinations for a best fit. This setting only affects bootstrap multiple column arrangements (for now) as seen on sections like cast and crew.

So if you have a full-width area with a no sidebar layout you would choose ‘large‘, ‘medium‘ if you have one sidebar and ‘small‘ for a two sidebar area. The default value is ‘medium’.

[my-mοvie-db id=your_id type=yοur_type size=large]

See the <a target="_blank" href="https://mymoviedatabase.cinema.ttic.ca/width-setting/"> width setting demo example on the plugin site page</a>.

**5-) header and body (optional - override)**

The background color for the 'body' and 'header' area of the templates.

These two settings combine to give 2 color schemes to your tabs and accordion templates.

In the case of tabs, the selected and the hovered tabs will get the 'header' color as well.

Using a valid css color for these settings, your shortcode will look like this:

[my-mοvie-db id=your_id type=yοur_type size=large header=#265a88 body=#122a40]


**Shortcode examples**

See the <a target="_blank" href="https://mymoviedatabase.cinema.ttic.ca/shortcode-default-parameters"> demo shortcode examples on the plugin site page</a> for more info.

**Configuration and customization of display**

From the plugin options page you can select which sections to display/hide, default templates, predefined widths, body and header colors, etc.

See the <a target="_blank" href="https://mymoviedatabase.cinema.ttic.ca/plugin-configuration-mmdb-options-page/"> configuration documentation page</a>  for more detailed info.

== Screenshots ==

1. The accordion template, main section.
2. The accordion template, cast section.
3. The tabs template, main tab.
4. Your search results. Note the TMDb Id is visible (Needed if you use a shortcode).
5. The main settings for TvShow (Same for Movies and Persons except for the hide section labels)
6. The advanced settings section

== Changelog ==

= 2.0.7 =
* Fixed bug: Date to local time conversion inaccuracy

= 2.0.6 =
* Added: French and Italian (via @PandaSekh) translations
* Added: Updated languages files to v2.x of plugin
* Fixed bug: Translation not working (regression)
* Added: Option to make plugin taxonomies non-hierarchical
* Added: Wordpress tags alongside categories for mmdb post types
* Added: Made all columns sortable on post type admin list view
* Added-dev: Refactored PostTypes for plugin needs

= 2.0.5 =
* Fixed-bug: PHP warning from Jetpack's Publicize and Sharing conflict fix

= 2.0.4 =
* Added: Add support for 'my-movie-db' shortcode (without underscores, closer to wp convention)
* Added: Publicize and wpcom-markdown support for custom post types
* Fixed-bug: Conflict with Jetpack's Publicize connections and Sharing buttons
* Minor: Remove forgotten .vue files and update 'Tested up to' version 5.3

= 2.0.3 =
* Fixed bug: Cast / crew hide sections bug.

= 2.0.2 =
* Added: Display (existing) file read errors only if wp debug display, plugin and wp debug mode are turned on. Always log these errors if possible.
* Added-dev: Refactor file structure and class / variable naming to optimise code readability. Split dependencies for admin vs public and load only when necessary.
* Added: Flush permalinks after plugin activation (so it won't have to be done manually) to get custom post type pages to appear immediately.

= 2.0.1 =
* Fixed-bug: Remove experimental SFC (and httpVueLoader) in favor of component template literals transpiled inline by babel

= 2.0.0 =
* Added: Javascript asynchronous template rendering (using VueJS)
*        Improved page load speed and overall user experience
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
* Fixed bug: When Gutenberg is used thickbox stylesheet is no longer loaded by wp
= 1.3.1 =
* Added: Custom post types archive enabled
*        https://wordpress.org/support/topic/post-type-archive-slug/
* Fixed bug: various issues relating to unavailable content
* Fixed bug: bug when tmdb servers are unavailable / down

= 1.2.1 =
* Added: Ability to associate wordpress categories to movies, tvshows and persons
* Added: Dates now appear with wordpress settings format by default
* Added: Date methods now accept custom date format argument (templating)
* Added: Ability to remove associated movie, tvshow, person from post
* Fixed bug: custom type taxonomy not appearing in menu
* Fixed bug: screen errors when wordpress post as movie lacks tmdbID

= 1.1.1 =
* First release.

