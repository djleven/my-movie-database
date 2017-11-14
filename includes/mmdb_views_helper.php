<?php
/**
 * MMDB for WP - helper
 *
 * @since 0.7
 */
if (!function_exists('mmdb_get_name_list')) {
    function mmdb_get_name_list($movie, $type) {

        if ($type == 'genre' || $type == 'companies') {
            if ($type == 'genre') {
                $results = $movie->getGenres();
            }
            if ($type == 'companies') {
                $results = $movie->getCompanies();
            }
            $the_results = array();
            foreach($results as $result) {
                $the_results[] = $result->getName();
            }
            $result = implode(", ", $the_results);
            return $result;
        }
        else if ($type == 'networks' || $type == 'some') {
            $results = $movie->get($type);
            $the_results = array();
            foreach($results as $result) {
                $the_results[] = $result['name'];
            }
            $result = implode(", ", $the_results);
            return $result;
        }
    }
}

if (!function_exists('mmdb_get_cast_list')) {
    function mmdb_get_cast_list($movie, $limit = NULL, $del = ', ') {

        $results = $movie->getCast();
        $the_results = array();
        $i = 1;
        foreach($results as $result) {
            if (isset($limit)) {
                if ($i <= $limit) {
                    $the_results[] = $result['name'];
                }
                $i++;
            }
            else {
                $the_results[] = $result['name'];
            }
        }
        $result = implode("$del", $the_results);
        return $result;
    }
}

if (!function_exists('mmdb_get_csv_list')) {
    function mmdb_get_csv_list($array, $key, $limit = NULL, $delimeter = ', ') {

        $the_results = array();
        $i = 1;
        foreach($array as $result) {
            if (isset($limit)) {
                if ($i <= $limit) {
                    $the_results[] = $result[$key];
                }
                $i++;
            }
            else {
                $the_results[] = $result[$key];
            }
        }
        $result = implode("$delimeter", $the_results);

        return $result;
    }
}

if (!function_exists('mmdb_get_object_csv_list')) {
    function mmdb_get_object_csv_list($object, $method, $limit = NULL, $delimeter = ', ') {

        $the_results = array();
        foreach($object as $result) {
            $the_results[] = $result->$method();
        }
        $result = implode("$delimeter", $the_results);

        return $result;
    }
}

if (!function_exists('mmdb_get_type_attr')) {
    function mmdb_get_type_attr($type) {

        if ($type == 'post') {
            $mmdb_type = 'movie';
        }
        else {
            $mmdb_type = $type;
        }

        return $mmdb_type;
    }
}

if (!function_exists('mmdb_get_desc')) {
    function mmdb_get_desc($string, $limit) {

        $string = (strlen($string) > $limit) ? $string = substr($string, 0, $limit) . '...' : $string;

        return $string;
    }
}

if (!function_exists('mmdbFormatDate')) {
    function mmdbFormatDate($format, $date) {
        if($format === null) {
            $format = get_option( 'date_format' );
        }

        return date($format, strtotime($date));
    }
}
