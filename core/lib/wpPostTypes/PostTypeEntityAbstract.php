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
     * The slug for the PostTypeEntity
     * @var string
     */
    public $slug;

    /**
     * The options for the PostTypeEntity
     * @var array
     */
    public $options;

    /**
     * Create a PostTypeEntity
     * @param mixed $names           A string for the name, or an array of names
     * @param array $options         The options for the PostTypeEntity
     */
    public function __construct($names, $options = [])
    {
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
     * Register the PostTypeEntity to WordPress
     *
     * @param $options
     *
     * @return void
     */
    abstract protected function wordpressRegistration($options);

    /**
     * Associates an already registered taxonomy to a post type.
     * Wrapper class for WP register_taxonomy_for_object_type
     *
     * Both children classes have this functionality built-in
     *
     * @return bool
     */
    abstract protected function registerTaxonomyToPostType();

    /**
     * Is the PostTypeEntity registered
     *
     * @return bool
     */
    abstract protected function isPostTypeEntityRegistered();

    /**
     * Callback to Register the PostTypeEntity with WordPress
     *
     * @return void
     */
    public function registerPosTypeEntity()
    {
        if (!$this->isPostTypeEntityRegistered()) {
            // register the Taxonomy with WordPress
            $this->wordpressRegistration($this->createOptions());
            $this->registerTaxonomyToPostType();
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

            // assign the name to the PostTypeEntity property
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
            'name' => $this->plural,
            'singular_name' => $this->singular,
            'menu_name' => $this->plural,
        ];
    }
}