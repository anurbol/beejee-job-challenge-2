<?php

namespace Utils;

class Html {
    static function classList(array $classMap) {
        $validClassMap = array_filter($classMap, function($boolean_condition) {
            return $boolean_condition;
        });

        $classes = array_keys($validClassMap);

        return implode($classes);
    }
}