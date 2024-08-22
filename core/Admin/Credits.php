<?php
/**
 * Defines the plugin credits data.
 *
 * @link       https://e-leven.net/
 * @since      3.0.4
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/admin
 * @author     Kostas Stathakos <info@e-leven.net>
 */

namespace MyMovieDatabase\Admin;

use MyMovieDatabase\I18nConstants;

class Credits {

    CONST translation_credits = [
        'sv_SE' => [
            [
                'name' => 'Tor-Bjorn Fjellner',
                'handle' => 'tobifjellner',
                'slack' => 'tobifjellner',
                'editor' => true
            ],
            [
                'name' => 'Fredrik',
                'handle' => 'elbogen',
                'slack' => 'fredrik',
                'editor' => true
            ]
        ],
        'fr_FR' => [
            [
                'name' => 'ISeeTWizard',
                'handle' => 'datateam',
                'slack' => '',
            ],
            [
                'name' => 'Thomas',
                'handle' => 'thmsgrmd ',
                'slack' => '',
            ],
            [
                'name' => 'docfred234499968',
                'handle' => 'docfred234499968',
                'slack' => '',
            ],
        ],
        'de_DE' => [
            [
                'name' => 'ISeeTWizard',
                'handle' => 'datateam',
                'slack' => '',
            ],
            [
                'name' => 'Florenz Villegas',
                'handle' => 'flovi',
                'slack' => 'Florenz Villegas',
            ],
            [
                'name' => 'Jens Ratzel',
                'handle' => 'jensratzel',
                'slack' => 'jensratzel',
                'editor' => true
            ],
        ],
        'es_ES' => [
            [
                'name' => 'chiflaos',
                'handle' => 'chiflaos',
                'slack' => '',
            ],
        ],
        'es_EC' => [
            [
                'name' => 'tecnologicssite',
                'handle' => 'tecnologicssite',
                'slack' => '',
            ],
        ],
        'fi' => [
            [
                'name' => 'Katynen',
                'handle' => 'katynen',
                'slack' => '',
            ],
        ],
        'pt_BR' => [
            [
                'name' => 'darkuriel',
                'handle' => 'darkuriel',
                'slack' => '',
            ],
            [
                'name' => 'ORIONFreitas',
                'handle' => 'nineorion',
                'slack' => '',
            ],
        ],
        'it_IT' => [
            [
                'name' => 'pandasekh',
                'handle' => 'pandasekh',
                'slack' => '@Alessio',
            ],
        ],
        'nl_BE' => [
            [
                'name' => 'bezootje',
                'handle' => 'bezootje',
                'slack' => '',
            ],
            [
                'name' => 'Pieterjan Deneys',
                'handle' => 'nekojonez',
                'slack' => 'NekoJonez',
            ],
        ],
        'ja' => [
            [
                'name' => 'hyzeen2020',
                'handle' => 'hyzeen2020',
                'slack' => '',
            ],
            [
                'name' => 'Naoko Takano',
                'handle' => 'nao',
                'slack' => 'nao',
            ],
        ],
        'tr_TR' => [
            [
                'name' => 'Emre Erkan',
                'handle' => 'emre',
                'slack' => 'emre',
            ],
            [
                'name' => 'alperheper',
                'handle' => 'alperheper',
                'slack' => '',
            ],
        ],
    ];

    CONST TRANSLATION_STAND_INS = [
        'es_EC' => 'es_ES',
        'pt_BR' => 'pt_PT',
        'nl_BE' => 'nl_NL',
    ];

    CONST TRANSLATIONS_COMPLETE = [
        'sv_SE'
    ];

    CONST LOCALE_PTE = [];

    /**
     * @since    3.0.4
     * @return   string
     */
    public static function getLanguages()
    {
        $html = self::getDescription();
        $html .= '<div class="translation-credits">';
        $translations = wp_get_available_translations();
        foreach (static::translation_credits as $language => $contributors) {
            if(!array_key_exists($language, $translations)) {
                continue;
            }
            $translation = $translations[$language];
            $html .= '<h3>';
            $html .= $translation['english_name'] . '-' . $translation['native_name'];
            if(in_array($language, static::TRANSLATIONS_COMPLETE)) {
                $html .= ' ✓';
            }

            $html .= '<span>';
            $html .= static::getStandInLanguageText($language, $translations);
            $html .= '</span>';
            $html .= '</h3>';

            $html .= '<h4>';
            /* translators: Acronym for the term 'Project Translation Editor' of the WordPress translation system. */
            $html .= esc_html__('PTE:', 'my-movie-database');
            $html .= ' <span>';
            $html .= in_array($language, static::LOCALE_PTE) ? static::LOCALE_PTE[$language] : esc_html__('The role is currently vacant. Apply to be our PTE!');
            $html .= '</span>';
            $html .= '</h4>';

            $html .= '<h4>';
            $html .= __(I18nConstants::I18n_CORE_CONTRIBUTORS);
            $html .= '</h4>';

            $html .= '<ul>';
            foreach ($contributors as $contributor) {
                $html .= '<li>';
                $html .= static::getAuthorText($contributor);
                $html .= '</li>';
            }
            $html .= '</ul>';
        }
        $html .= '</div>';

        return    $html;
    }

    /**
     * @since    3.0.4
     * @return   string
     */
    public static function getAuthorText($contributor) {
        $html = '';
        if($contributor['name']){
            $html .= $contributor['name'];
            $html .= ': ';
        }

        $html .= '<a href="https://profiles.wordpress.org/' . $contributor['handle'] . '" target="_blank" rel="noopener noreferrer">' . $contributor['handle'] . '</a>';

        if($contributor['slack']) {
            $html .= ', <a href="https://make.wordpress.org/chat/" target="_blank" rel="noopener noreferrer">Slack:</a> @' . $contributor['handle'];

        }
        return $html;

    }

    /**
     * @since    3.0.4
     * @return   string
     */
    public static function getStandInLanguageText($language, $translations) {
        $html = '';

        if(array_key_exists($language, static::TRANSLATION_STAND_INS)) {
            $stand_in_for_language = $translations[static::TRANSLATION_STAND_INS[$language]];
            $html .='<div style="font-style: oblique ">';
            $html .= sprintf(
            /* translators: %s: Language name, ex: French */
                esc_html__('Part or all of this translation is being used for %s', 'my-movie-database' ),
                $stand_in_for_language['english_name'] . '-' . $stand_in_for_language['native_name']
            );
            $html .='</div>';
        }

        return $html;
    }

    /**
     * @since    3.0.4
     * @return   string
     */
    public static function getDescription() {
        return esc_html__('Big thank to all our translation contributors! Completed translations on translate.wordpress.org are automatically shipped by WordPress (✓).
            We are in need of Project Translation Editors (PTEs)!  
            A PTE is a person who has access to validate and approve strings added by translation contributors on translate.wordpress.org, for a language locale of the plugin.
            If want to become the plugin\'s PTE for your language locale, please email us at:',
            'my-movie-database'
            , 'my-movie-database' ) . ' info@e-leven.net';
    }

}
