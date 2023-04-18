<?php

namespace MyMovieDatabase\Lib;

class Validators {
    public static function sanitize_html_class_list( $classname, $fallback = '', $nbsp = '&nbsp;' ) {
        // Strip out any percent-encoded characters.
        $sanitized = preg_replace( '|%[a-fA-F0-9][a-fA-F0-9]|', '', $classname );

        // Limit to A-Z, a-z, 0-9, '_', '-'.
        $sanitized = preg_replace( '/[^A-Za-z0-9\s_-]/', '', $sanitized );

        // Remove non-single empty spaces and classes that start with a numeric value
        $arrayOfClasses = preg_split( '/\s/', $sanitized);
        $sanitized = '';
        foreach ($arrayOfClasses as $class) {
            if($class === '' || ctype_digit($class[0])) {
                continue;
            }
            $sanitized .= $class . $nbsp;
        }

        if ( '' === $sanitized && $fallback ) {
            return self::sanitize_html_class_list( $fallback );
        }

        return $sanitized;
    }
}
