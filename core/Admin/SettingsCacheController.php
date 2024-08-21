<?php
/**
 * Orchestrates the option page cache management.
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
use MyMovieDatabase\Interfaces\ActionHookSubscriberInterface;
use MyMovieDatabase\Lib\OptionsGroup;

class SettingsCacheController implements ActionHookSubscriberInterface {

    /**
     * An instance of the options helper class loaded with the cache setting values.
     *
     * @since    3.0.0
     * @access   protected
     * @var      OptionsGroup    $cacheSettings
     */
    protected $cacheSettings;


    public $admin_notice_message;

    /**
     * Initialize the class and set its properties.
     *
     * @since    3.0.0
     */
    public function __construct() {
        $this->cacheSettings = new OptionsGroup(Constants::CACHE_MANAGER_OPTION_GROUP_NAME);
        $this->clearCache();
    }

    /**
     * Get the action hooks to be registered.
     *
     * @since    3.0.0
     * @access   public
     */
    public function getActions()
    {
        $actions = [];

        if($this->admin_notice_message) {
            $actions['admin_notices'] = 'show_admin_notice';
        }

        return $actions;
    }

    /**
     * Clear cached data if needed
     *
     * @since     3.0.0
     * @return    void
     */
    private function clearCache() {

        $data_id = $this->cacheSettings->getOption(Constants::CACHE_MANAGER_DELETE_ID);
        $data_type = $this->cacheSettings->getOption(Constants::CACHE_MANAGER_DELETE_TYPE);

        if($data_id === '' && $data_type === '') {
            return;
        }
        $this->admin_notice_message = sprintf(
            /* translators: 1: Resource type, ex: movie, tv show or person, 2: Numeric TMDb id, 3: Locale code, ex: en-US. */
            esc_html__( 'The cache for the %1$s with TMDb id %2$s and locale %3$s was deleted.', 'my-movie-database'),
            esc_html__($data_type),
            $data_id,
            get_locale()
        );

        $error_msg = esc_html__( 'An error has occurred.', 'my-movie-database');
        if(!$this->cacheSettings->deleteOption()) {
            $this->admin_notice_message = $error_msg;
        }

        $cache_manager = new CacheManager($data_type, $data_id);
        if(!$cache_manager->deleteCachedData()) {
            if($cache_manager->deleteCachedData() === false) {
                $this->admin_notice_message = sprintf(
                    /* translators: 1: Resource type, ex: movie, tv show or person, 2: Numeric TMDb id, 3: Locale code, ex: en-US. */
                    esc_html__( 'The cache for the %1$s with TMDb id %2$s and locale %3$s was not found.', 'my-movie-database'),
                    esc_html__($data_type),
                    $data_id,
                    get_locale()
                );
            }
        }
    }

    public function show_admin_notice() {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><strong><?php echo $this->admin_notice_message; ?></strong></p>
        </div>
        <?php
    }
}
