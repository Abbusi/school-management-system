<?php

namespace App\Http\Helpers;

class Form
{
    public static function select($name, $options = [], $value = null, $attributes = [])
    {
        // Extract placeholder if exists
        $placeholder = null;
        if (isset($attributes['placeholder'])) {
            $placeholder = $attributes['placeholder'];
            unset($attributes['placeholder']);
        }

        $select = html()->select($name, $options, $value);

        if ($placeholder) {
            $select = $select->placeholder($placeholder);
        }

        // Apply remaining attributes
        if (is_array($attributes)) {
            foreach ($attributes as $key => $val) {
                if ($val === 'true' || $val === true) {
                    $select = $select->attribute($key);
                } elseif ($val === 'false' || $val === false) {
                    // skip
                } else {
                    $select = $select->attribute($key, $val);
                }
            }
        }

        return $select;
    }

    public static function checkbox($name, $value = 1, $checked = null, $attributes = [])
    {
        $checkbox = html()->checkbox($name, (bool)$checked, $value);

        // Apply remaining attributes
        if (is_array($attributes)) {
            foreach ($attributes as $key => $val) {
                if ($val === 'true' || $val === true) {
                    $checkbox = $checkbox->attribute($key);
                } elseif ($val === 'false' || $val === false) {
                    // skip
                } else {
                    $checkbox = $checkbox->attribute($key, $val);
                }
            }
        }

        return $checkbox;
    }
}


