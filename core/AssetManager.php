<?php
namespace MyMovieDatabase;

class AssetManager
{
    CONST ASSETS_PUBLIC_PATH   = 'assets/';
    CONST PORT_PREFIX   = 'http://localhost:8080/';
    /**
     * Number of parent directories to go up to assets folder level
     */
    CONST LEVELS_UP_TO_ASSETS = 1;

    protected $assets_map;
    public $name;
    public $is_dev_mode;
    public $has_assets_map;
    public $js_file_path;
    public $css_file_path;

    public function __construct($name, $is_dev_mode)
    {
        $this->name = $name;
        if(!$this->is_dev_mode = $is_dev_mode) {
            if($this->assets_map = $this->get_assets_map()) {
                $this->has_assets_map = true;
            }
        }

        $this->js_file_path = $this->get_js_file_uri();
        $this->css_file_path = $this->get_css_file_uri();
    }

    protected function get_assets_map()
    {
        $assets_path = dirname(__FILE__, self::LEVELS_UP_TO_ASSETS) . '/' . self::ASSETS_PUBLIC_PATH;
        if (file_exists($assets_path . 'assets.json')) {
            return @json_decode(file_get_contents($assets_path .'assets.json'), true);
        }

        return false;
    }

    protected function get_js_file_uri()
    {
        return $this->get_file_uri();
    }

    protected function get_css_file_uri()
    {
        return $this->get_file_uri('css');
    }

    protected function get_file_uri($ext = 'js')
    {
        if(!$this->is_dev_mode) {
            $uri_prefix = '';
            $file_path = $this->get_file_uri_from_assets($ext);
        } else {
            $uri_prefix = self::PORT_PREFIX;
            $file_path = $this->get_file_uri_from_dev_server($ext);
        }

        return $file_path ? $uri_prefix . self::ASSETS_PUBLIC_PATH . $file_path : '';
    }

    protected function get_file_uri_from_assets($ext = 'js')
    {
        return isset($this->assets_map[$this->name][$ext]) ? $this->assets_map[$this->name][$ext] : null;
    }

    protected function get_file_uri_from_dev_server($ext = 'js')
    {
        return $ext . '/' . $this->name . '.' .  $ext;
    }
}
