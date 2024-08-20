<?php
/**
 * Provides the option page skeleton html and header info.
 *
 * @link       https://e-leven.net/
 * @since      3.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/admin
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase\Admin;

use MyMovieDatabase\Constants;
use MyMovieDatabase\I18nConstants;

trait SettingsHeader {

    /**
     * Get all the settings header data
     *
     * @since    2.0.7
     * @since    3.0.0 			moved in this here new file
     *
     * @return    array
     */
    private function getHeaderInfo() {

        return [
            [
                'title' => esc_html__( 'Get Help',  'my-movie-database' ),
                'span_class' => 'dashicons-sos',
                'rows' => [
                    [
                        'title' => __( I18nConstants::I18n_CORE_DOCUMENTATION ),
                        'span_class' => 'dashicons-editor-help',
                        'url' => 'https://mymoviedb.org/how-to-use-the-mmdb-plugin/',
                        'url-text' => esc_html__( 'How to use the plugin.',  'my-movie-database' )
                    ],
                    [
                        'title' => __( I18nConstants::I18n_CORE_DOCUMENTATION ),
                        'span_class' => 'dashicons-admin-settings',
                        'url' => 'https://mymoviedb.org/plugin-configuration-mmdb-options-page/',
                        'url-text' => esc_html__( 'Configuration options',  'my-movie-database' )
                    ],
                    [
                        'title' => __( I18nConstants::I18n_CORE_SUPPORT ),
                        'span_class' => 'dashicons-tickets-alt',
                        'url' => 'https://wordpress.org/support/plugin/my-movie-database/',
                        'text' => esc_html__( 'Still can\'t figure it out?',  'my-movie-database' ),
                        'url-text' => esc_html__( 'Open up a ticket.',  'my-movie-database' )
                    ],
                ],
            ],
            [
                'title' => esc_html__( 'Offer Help',  'my-movie-database' ) . ' - ' . esc_html__( 'Contribute',  'my-movie-database' ),
                'span_class' => 'dashicons-groups',
                'rows' => [
                    [
                        'title' => esc_html__( 'Review', 'my-movie-database' ),
                        'span_class' => 'dashicons-star-half',
                        'url' => 'https://wordpress.org/support/plugin/my-movie-database/reviews/',
                        'text' => esc_html__( 'It means a lot to us.',  'my-movie-database' ),
                        'url-text' => esc_html__( 'Please leave your review.',  'my-movie-database' ),
                    ],
                    [
                        'title' => esc_html__( 'Translate', 'my-movie-database' ),
                        'span_class' => 'dashicons-flag',
                        'url' => 'https://translate.wordpress.org/projects/wp-plugins/my-movie-database/',
                        'url-text' => esc_html__( 'Translate the plugin in your language.',  'my-movie-database' )
                    ],
                    [
                        'title' => esc_html__( 'Give feedback',  'my-movie-database' ),
                        'span_class' => 'dashicons-testimonial',
                        'url' => 'https://docs.google.com/forms/d/1BTZZqUn1DB84bUtmpU0tW1qABbngOapBuwMrYZfI8cM',
                        'text' => esc_html__( 'We\'ll love you for it!',  'my-movie-database'  ),
                        'url-text' => esc_html__( 'Fill out a brief survey.',  'my-movie-database'  )
                    ],
                ]
            ],
            [
                'title' => esc_html__( 'Connect',  'my-movie-database' ),
                'span_class' => 'dashicons-universal-access',
                'rows' => [
                    [
                        'title' => esc_html__( 'Newsletter', 'my-movie-database' ),
                        'span_class' => 'dashicons-email-alt',
                        'url' => 'https://mymoviedb.org/join-our-mailing-list/',
                        'text' => esc_html__( 'Stay in the loop!',  'my-movie-database' ),
                        'url-text' => esc_html__( 'Join our mailing list.',  'my-movie-database' ),
                    ],
                    [
                        'title' => esc_html__( 'Showcase', 'my-movie-database' ),
                        'span_class' => 'dashicons-superhero',
                        'url' => 'https://docs.google.com/forms/d/1PhyunzFStFevWS5EDHBTxYX8SyytCuGw1I4kUMDq5r4',
                        'url-text' => esc_html__( 'Add your website to our site showcase.',  'my-movie-database' )
                    ],
                    [
                        'title' => esc_html__( 'Development',  'my-movie-database' ),
                        'span_class' => 'dashicons-admin-tools',
                        'url' => 'mailto:info@e-leven.net',
                        'text' => esc_html__( 'Need a special feature?',  'my-movie-database'  ),
                        'url-text' => esc_html__( 'Contact us',  'my-movie-database'  )
                    ],
                ]
            ]
        ];
    }

    /**
     * Plugin option page html base
     *
     * @since    0.7.0
     * @since    3.0.0 			moved in this here new file
     *
     * @return  void
     */
    public function getSettingsPageHtml($version) {
        ?>
        <style>
            .mmdb_admin_header {
                display: flex;
                max-width: 1600px;
                /*padding: 25px 0 10px 40px;*/
                padding: 20px 0 10px 10px;
                align-items: center;
            }
            .mmdb_admin_header h1 {
                align-self: flex-end;
            }
            .mmdb_admin_header .admin-logo {
                padding: 0 20px 0 0;
            }
            .mmdb-row {
                display: flex;
                justify-content: space-between;
                /*justify-content: space-evenly;*/
                flex-wrap: wrap;
                max-width: 1600px;
                /*padding: 0 30px;*/
                padding: 10px 15px
            }
            .mmdb-row .mmdb-header-boxes {
                /*border: 3px solid black;*/
                /*padding: 0 15px;*/
                /*border-radius: 15px;*/
            }
            .version {
                font-size: 14px;
                padding: 8px 0 0;
            }
            .mmdb-row .mmdb-header-boxes li > span {
                padding-right: 5px;
            }
            .mmdb-row .mmdb-header-boxes h3 > span {
                padding-left: 5px;
            }
            /* Chrome, Safari, Edge, Opera */
            .mmdb_delete_cache_id input::-webkit-outer-spin-button,
            .mmdb_delete_cache_id input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            /* Firefox */
            .mmdb_delete_cache_id input[type=number] {
                -moz-appearance: textfield;
            }

            /* Translation Credits */
            .translation-credits h3 {
                margin: 1.6em 0 0;
            }
            .translation-credits h4 {
                margin: 1em 0 0.5em;
            }
            .translation-credits ul {
                margin-top: 0.5em;
            }
            .translation-credits span {
                font-weight: normal;
                font-size:12px;
            }
        </style>
        <div class="mmdb_admin_header">
            <img src="<?php echo MMDB_PLUGIN_URL ;?>assets/img/icon-64x64.png" class="admin-logo"/>
            <h1><?php echo __( 'My Movie Database',  'my-movie-database' ) ;?>
                <div class="version"><?php echo sprintf( __( I18nConstants::I18n_CORE_VERSION ), $version );?></div>
            </h1>
        </div>
        <div class="mmdb-row">
            <?php foreach($this->getHeaderInfo() as $info) :?>
                <div class="mmdb-header-boxes">
                    <h3><?php echo $info['title']?><span class="dashicons <?php echo $info['span_class']?>"></span></h3>
                    <ul>
                        <?php foreach($info['rows'] as $row) :?>
                            <li>
                                <span class="dashicons <?php echo $row['span_class']?>"></span><strong><?php echo $row['title']?>:</strong>
                                <?php $text = isset($row['text']) ? $row['text'] : ''; echo $text; ?>
                                <a href="<?php echo $row['url']?>" target="_blank" target="_blank" rel="noopener noreferrer">
                                    <?php echo $row['url-text']?>
                                </a>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            <?php endforeach;?>
        </div>

        <?php
    }
}

