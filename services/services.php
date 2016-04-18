<?php

return array(
    'models' => array(
        'DefaultValue' => function () {
            if (class_exists('\App\FormBuilder\Model\DefaultValue')) {
                return new \App\FormBuilder\Model\DefaultValue();
            } else {
                return new \Nails\FormBuilder\Model\DefaultValue();
            }
        },
        'Field' => function () {
            if (class_exists('\App\FormBuilder\Model\Field')) {
                return new \App\FormBuilder\Model\Field();
            } else {
                return new \Nails\FormBuilder\Model\Field();
            }
        },

        /**
         * Default Values
         */
        'DefaultValueCustom' => function () {
            if (class_exists('\App\FormBuilder\DefaultValue\Custom')) {
                return new \App\FormBuilder\DefaultValue\Custom();
            } else {
                return new \Nails\FormBuilder\DefaultValue\Custom();
            }
        },
        'DefaultValueNone' => function () {
            if (class_exists('\App\FormBuilder\DefaultValue\None')) {
                return new \App\FormBuilder\DefaultValue\None();
            } else {
                return new \Nails\FormBuilder\DefaultValue\None();
            }
        },
        'DefaultValueTimestamp' => function () {
            if (class_exists('\App\FormBuilder\DefaultValue\Timestamp')) {
                return new \App\FormBuilder\DefaultValue\Timestamp();
            } else {
                return new \Nails\FormBuilder\DefaultValue\Timestamp();
            }
        },
        'DefaultValueUserEmail' => function () {
            if (class_exists('\App\FormBuilder\DefaultValue\UserEmail')) {
                return new \App\FormBuilder\DefaultValue\UserEmail();
            } else {
                return new \Nails\FormBuilder\DefaultValue\UserEmail();
            }
        },
        'DefaultValueUserFirstName' => function () {
            if (class_exists('\App\FormBuilder\DefaultValue\UserFirstName')) {
                return new \App\FormBuilder\DefaultValue\UserFirstName();
            } else {
                return new \Nails\FormBuilder\DefaultValue\UserFirstName();
            }
        },
        'DefaultValueUserId' => function () {
            if (class_exists('\App\FormBuilder\DefaultValue\UserId')) {
                return new \App\FormBuilder\DefaultValue\UserId();
            } else {
                return new \Nails\FormBuilder\DefaultValue\UserId();
            }
        },
        'DefaultValueUserLastName' => function () {
            if (class_exists('\App\FormBuilder\DefaultValue\UserLastName')) {
                return new \App\FormBuilder\DefaultValue\UserLastName();
            } else {
                return new \Nails\FormBuilder\DefaultValue\UserLastName();
            }
        },
        'DefaultValueUserName' => function () {
            if (class_exists('\App\FormBuilder\DefaultValue\UserName')) {
                return new \App\FormBuilder\DefaultValue\UserName();
            } else {
                return new \Nails\FormBuilder\DefaultValue\UserName();
            }
        },

        /**
         * Field Types
         */
        'FieldTypeCheckbox' => function () {
            if (class_exists('\App\FormBuilder\FieldType\Checkbox')) {
                return new \App\FormBuilder\FieldType\Checkbox();
            } else {
                return new \Nails\FormBuilder\FieldType\Checkbox();
            }
        },
        'FieldTypeDate' => function () {
            if (class_exists('\App\FormBuilder\FieldType\Date')) {
                return new \App\FormBuilder\FieldType\Date();
            } else {
                return new \Nails\FormBuilder\FieldType\Date();
            }
        },
        'FieldTypeDateTime' => function () {
            if (class_exists('\App\FormBuilder\FieldType\DateTime')) {
                return new \App\FormBuilder\FieldType\DateTime();
            } else {
                return new \Nails\FormBuilder\FieldType\DateTime();
            }
        },
        'FieldTypeEmail' => function () {
            if (class_exists('\App\FormBuilder\FieldType\Email')) {
                return new \App\FormBuilder\FieldType\Email();
            } else {
                return new \Nails\FormBuilder\FieldType\Email();
            }
        },
        'FieldTypeFile' => function () {
            if (class_exists('\App\FormBuilder\FieldType\File')) {
                return new \App\FormBuilder\FieldType\File();
            } else {
                return new \Nails\FormBuilder\FieldType\File();
            }
        },
        'FieldTypeHidden' => function () {
            if (class_exists('\App\FormBuilder\FieldType\Hidden')) {
                return new \App\FormBuilder\FieldType\Hidden();
            } else {
                return new \Nails\FormBuilder\FieldType\Hidden();
            }
        },
        'FieldTypeNumber' => function () {
            if (class_exists('\App\FormBuilder\FieldType\Number')) {
                return new \App\FormBuilder\FieldType\Number();
            } else {
                return new \Nails\FormBuilder\FieldType\Number();
            }
        },
        'FieldTypePassword' => function () {
            if (class_exists('\App\FormBuilder\FieldType\Password')) {
                return new \App\FormBuilder\FieldType\Password();
            } else {
                return new \Nails\FormBuilder\FieldType\Password();
            }
        },
        'FieldTypeRadio' => function () {
            if (class_exists('\App\FormBuilder\FieldType\Radio')) {
                return new \App\FormBuilder\FieldType\Radio();
            } else {
                return new \Nails\FormBuilder\FieldType\Radio();
            }
        },
        'FieldTypeSelect' => function () {
            if (class_exists('\App\FormBuilder\FieldType\Select')) {
                return new \App\FormBuilder\FieldType\Select();
            } else {
                return new \Nails\FormBuilder\FieldType\Select();
            }
        },
        'FieldTypeTel' => function () {
            if (class_exists('\App\FormBuilder\FieldType\Tel')) {
                return new \App\FormBuilder\FieldType\Tel();
            } else {
                return new \Nails\FormBuilder\FieldType\Tel();
            }
        },
        'FieldTypeText' => function () {
            if (class_exists('\App\FormBuilder\FieldType\Text')) {
                return new \App\FormBuilder\FieldType\Text();
            } else {
                return new \Nails\FormBuilder\FieldType\Text();
            }
        },
        'FieldTypeTextarea' => function () {
            if (class_exists('\App\FormBuilder\FieldType\Textarea')) {
                return new \App\FormBuilder\FieldType\Textarea();
            } else {
                return new \Nails\FormBuilder\FieldType\Textarea();
            }
        },
        'FieldTypeTime' => function () {
            if (class_exists('\App\FormBuilder\FieldType\Time')) {
                return new \App\FormBuilder\FieldType\Time();
            } else {
                return new \Nails\FormBuilder\FieldType\Time();
            }
        },
        'FieldTypeUrl' => function () {
            if (class_exists('\App\FormBuilder\FieldType\Url')) {
                return new \App\FormBuilder\FieldType\Url();
            } else {
                return new \Nails\FormBuilder\FieldType\Url();
            }
        }
    )
);
