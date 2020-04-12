<?php

namespace MyMovieDatabase\Lib\PostTypes;

/**
 * PostTypeEntity
 *
 * Abstract class for the creation of custom post types and taxonomies
 *
 * An adaptation based on the work of jjgrainger's PostTypes
 * @link    https://github.com/jjgrainger/PostTypes/
 */
abstract class PostTypeEntityAbstract
{
    /**
     * The name for the PostTypeEntity
     * @var string
     */
    public $name;

    /**
     * The singular for the PostTypeEntity
     * @var string
     */
    public $singular;

    /**
     * The plural name for the PostTypeEntity
     * @var string
     */
    public $plural;

    /**
     * The wp text domain to use for translation
     * @var string
     */
    public $i18nTxtDomain;

    /**
     * The localised singular name for the PostTypeEntity
     * @var string
     */
    public $singular_i18n;

    /**
     * The localised plural name for the PostTypeEntity
     * @var string
     */
    public $plural_i18n;

    /**
     * The slug for the PostTypeEntity
     * @var string
     */
    public $slug;

    /**
     * The options for the PostTypeEntity
     * @var string
     */
    public $options;

    /**
     * The column manager for the PostTypeEntity
     * @var mixed
     */
    public $columns;

    /**
     * Create a PostTypeEntity
     * @param mixed $names           A string for the name, or an array of names
     * @param string $i18nTxtDomain  The wp text domain to use for i18n
     * @param array $options         The options for the PostTypeEntity
     */
    public function __construct($names, $i18nTxtDomain, $options = [])
    {
        $this->i18nTxtDomain = $i18nTxtDomain;
        $this->options = $options;
        $this->setNames($names);
    }

    /**
     * Create options for PostTypeEntity
     *
     * @return array
     */
    abstract protected function createOptions();

    /**
     * Register the PostTypeEntity WordPress actions
     *
     * @return void
     */
    abstract public function registerActions();

    /**
     * Register the PostTypeEntity to WordPress
     *
     * @param $options
     *
     * @return void
     */
    abstract protected function wordpressRegistration($options);

    /**
     * Is the PostTypeEntity registered
     *
     * @return bool
     */
    abstract protected function isPostTypeEntityRegistered();

    /**
     * Register the PostTypeEntity
     *
     * @return void
     */
    public function registerPostTypeEntity()
    {
        if (!$this->isPostTypeEntityRegistered()) {
            $this->setI18nBaseLabels();
            // register the Taxonomy with WordPress
            $this->wordpressRegistration($this->createOptions());
        }
    }

    /**
     * Set the translated base labels
     *
     * @return void
     */
    public function setI18nBaseLabels()
    {
        $this->singular_i18n = __($this->singular, $this->i18nTxtDomain);
        $this->plural_i18n   = __($this->plural, $this->i18nTxtDomain);
    }

    /**
     * Register the Column related actions
     *
     * @return void
     */
    public function registerColumns()
    {
        if (isset($this->columns)) {
            // set custom sortable columns
            add_filter("manage_edit-{$this->name}_sortable_columns", [$this, 'setSortableColumns']);

            // run action that sorts columns on request
            add_action('parse_term_query', [$this, 'sortSortableColumns']);
        }
    }

    /**
     * Set the names for the PostTypeEntity
     *
     * @param  mixed $names A string for the name, or an array of names
     *
     * @return void
     */
    protected function setNames($names)
    {
        // only the post type name is passed
        if (is_string($names)) {
            $names = ['name' => $names];
        }

        // create names for the PostTypeEntity
        $this->createNames($names);
    }

    /**
     * Get the Column Manager for the PostTypeEntity
     *
     * @return Columns
     */
    public function columns()
    {
        if (!isset($this->columns)) {
            $this->columns = new Columns;
        }

        return $this->columns;
    }

    /**
     * Create the required names for the PostTypeEntity
     *
     * @param $names
     * @return void
     */
    protected function createNames($names)
    {
        // names required for the PostTypeEntity
        $required = [
            'name',
            'singular',
            'plural',
            'slug',
        ];

        foreach ($required as $key) {
            // if the name is set, assign it
            if (isset($names[$key])) {
                $this->$key = $names[$key];
                continue;
            }
            // if the key is not set
            if ($key === 'singular') {
                // create a human friendly name
                $name = ucwords(str_replace(['-', '_'], ' ', $names['name']));
            }

            if ($key === 'slug') {
                // create a slug friendly name
                $name = strtolower(str_replace([' ', '_'], '-', $names['name']));
            }

            if ($key === 'plural') {
                // if is plural append an 's' to singular
                $name = $this->singular . 's';
            }

            // asign the name to the PostTypeEntity property
            $this->$key = $name;
        }
    }

    /**
     * Create the labels for the PostTypeEntity
     *
     * @return array
     */
    protected function createLabels()
    {
        // default labels
        return [
            'name' => $this->singular_i18n,
            'singular_name' => $this->singular_i18n,
            'menu_name' => $this->plural_i18n,
            'all_items' => __('All ' . $this->plural, $this->i18nTxtDomain),
            'add_new_item' => __('Add New', $this->i18nTxtDomain) . ' - ' . $this->singular_i18n,
            'edit_item' => __('Edit') . ' - ' . $this->singular_i18n,
            'view_item' =>  __('View') . ' - ' . $this->singular_i18n,
            'search_items' => __('Search') . ' - ' . $this->plural_i18n,
            'not_found' => __('No ' . $this->plural .' found', $this->i18nTxtDomain),
            'parent_item_colon' => __('Parent'). ' - ' . $this->singular_i18n. ':',
        ];
    }

    /**
     * Make custom columns sortable
     *
     * @param array $columns Default WordPress sortable columns
     *
     * @return array
     */
    public function setSortableColumns($columns)
    {
        if (!empty($this->columns()->sortable)) {
            $columns = array_merge($columns, $this->columns()->sortable);
        }

        return $columns;
    }
}