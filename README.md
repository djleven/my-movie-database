# My Movie Database for WordPress

This is the development repository. If you just want to use the plugin head over to it's [WordPress plugin page](https://wordpress.org/plugins/my-movie-database/).


> My Movie Database enriches your content by allowing you to easily add detailed information about the movies, tv shows and people in the industry you choose.

> You can use it via shortcodes or within WordPress post types and customize it to make it fit your theme and design.  Have a look at this demo video to see the basics and visit the [my movie database website](https://mymoviedb.org) for more details.

[![My movie database plugin demo video](https://img.youtube.com/vi/vUGGxX7maTg/0.jpg)](https://www.youtube.com/watch?v=vUGGxX7maTg)


> The data comes from the API of [The Movie Database (TMDb)](https://www.themoviedb.org), the leading crowdsourced movie industry data initiative.
My Movie Database is no way endorsed or certified by TMDb.


## Documentation and user support

You can find documentation on [how to use the plugin](https://mymoviedb.org/how-to-use-the-mmdb-plugin/), [configuration and customization options](https://mymoviedb.org/plugin-configuration-mmdb-options-page/) and relevant [demos](https://mymoviedb.org/plugin-configuration-mmdb-options-page/) on the [my movie database website](https://mymoviedb.org).

If you cannot find the answer to your question in any of the documentation, check the [support forum](https://wordpress.org/support/plugin/my-movie-database/) on WordPress.org.
If you still cannot solve the issue you are having, feel free to open a new ticket.

## Repository contents

The repository is made up of two parts:

- the PHP code you would expect from any WordPress plugin
- the Vue js app (`vue-app` folder)

They don't talk to each other directly. The vue app js build (both dev and production versions) is generated inside the `/assets/js/app/` folder.
The PHP part picks then it up from there.

## Prerequisites

On your local machine (or docker container(s)) you need to have installed:

- [WordPress](https://wordpress.org/download/) (tested from version 4.6 to 6.2)
- [WordPress CLI](https://make.wordpress.org/cli/handbook/)
- [node](https://nodejs.org/en/download/package-manager/)

Minimum required PHP version is 5.6


## Installation

    git clone https://github.com/djleven/my-movie-database.git
    cd my-movie-database/vue-app
    npm install

## Development

Note: The first time around, better to build the language files based on a production build js bundle.
You will have less diffs. So follow the `Production Build` section. Then:

This will launch the hot reload dev environment

        npm run serve



## Production Build

Generate the js files:

    cd my-movie-database/vue-app
    npm run build

Then, to build the language files:

    cd ../
    .sh makePot


## Useful links

[Vue Docs](https://vuejs.org/guide/introduction.html)

[WordPress Plugin Handbook](https://developer.wordpress.org/plugins/)

[WordPress CLI i18n commands](https://developer.wordpress.org/cli/commands/i18n/)

## Contributing

Contributions, questions and comments are welcome.

## Donating

Thank you for considering [a donation to My Movie Database](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Y5DGNQGZU92N6)
