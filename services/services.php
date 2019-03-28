<?php

return [
    'services'  => [
        'DefaultValue' => function () {
            if (class_exists('\App\FormBuilder\Service\DefaultValue')) {
                return new \App\FormBuilder\Service\DefaultValue();
            } else {
                return new \Nails\FormBuilder\Service\DefaultValue();
            }
        },
        'FieldType'    => function () {
            if (class_exists('\App\FormBuilder\Service\FieldType')) {
                return new \App\FormBuilder\Service\FieldType();
            } else {
                return new \Nails\FormBuilder\Service\FieldType();
            }
        },
    ],
    'models'    => [
        'Form'            => function () {
            if (class_exists('\App\FormBuilder\Model\Form')) {
                return new \App\FormBuilder\Model\Form();
            } else {
                return new \Nails\FormBuilder\Model\Form();
            }
        },
        'FormField'       => function () {
            if (class_exists('\App\FormBuilder\Model\FormField')) {
                return new \App\FormBuilder\Model\FormField();
            } else {
                return new \Nails\FormBuilder\Model\FormField();
            }
        },
        'FormFieldOption' => function () {
            if (class_exists('\App\FormBuilder\Model\FormFieldOption')) {
                return new \App\FormBuilder\Model\FormFieldOption();
            } else {
                return new \Nails\FormBuilder\Model\FormFieldOption();
            }
        },
    ],
    'factories' => [
        /**
         * Default Values
         *  Silly namespace to avoid collision between app provided field types and app overrides.
         */
        'DefaultValueCustom'        => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\DefaultValue\Custom')) {
                return new \App\FormBuilder\FormBuilder\DefaultValue\Custom();
            } else {
                return new \Nails\FormBuilder\FormBuilder\DefaultValue\Custom();
            }
        },
        'DefaultValueNone'          => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\DefaultValue\None')) {
                return new \App\FormBuilder\FormBuilder\DefaultValue\None();
            } else {
                return new \Nails\FormBuilder\FormBuilder\DefaultValue\None();
            }
        },
        'DefaultValueTimestamp'     => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\DefaultValue\Timestamp')) {
                return new \App\FormBuilder\FormBuilder\DefaultValue\Timestamp();
            } else {
                return new \Nails\FormBuilder\FormBuilder\DefaultValue\Timestamp();
            }
        },
        'DefaultValueUserEmail'     => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\DefaultValue\UserEmail')) {
                return new \App\FormBuilder\FormBuilder\DefaultValue\UserEmail();
            } else {
                return new \Nails\FormBuilder\FormBuilder\DefaultValue\UserEmail();
            }
        },
        'DefaultValueUserFirstName' => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\DefaultValue\UserFirstName')) {
                return new \App\FormBuilder\FormBuilder\DefaultValue\UserFirstName();
            } else {
                return new \Nails\FormBuilder\FormBuilder\DefaultValue\UserFirstName();
            }
        },
        'DefaultValueUserId'        => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\DefaultValue\UserId')) {
                return new \App\FormBuilder\FormBuilder\DefaultValue\UserId();
            } else {
                return new \Nails\FormBuilder\FormBuilder\DefaultValue\UserId();
            }
        },
        'DefaultValueUserLastName'  => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\DefaultValue\UserLastName')) {
                return new \App\FormBuilder\FormBuilder\DefaultValue\UserLastName();
            } else {
                return new \Nails\FormBuilder\FormBuilder\DefaultValue\UserLastName();
            }
        },
        'DefaultValueUserName'      => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\DefaultValue\UserName')) {
                return new \App\FormBuilder\FormBuilder\DefaultValue\UserName();
            } else {
                return new \Nails\FormBuilder\FormBuilder\DefaultValue\UserName();
            }
        },

        /**
         * Field Types
         * Silly namespace to avoid collision between app provided field types and app overrides.
         */
        'FieldTypeCaptcha'          => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Captcha')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Captcha();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\Captcha();
            }
        },
        'FieldTypeCheckbox'         => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Checkbox')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Checkbox();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\Checkbox();
            }
        },
        'FieldTypeDate'             => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Date')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Date();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\Date();
            }
        },
        'FieldTypeDateTime'         => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\DateTime')) {
                return new \App\FormBuilder\FormBuilder\FieldType\DateTime();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\DateTime();
            }
        },
        'FieldTypeEmail'            => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Email')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Email();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\Email();
            }
        },
        'FieldTypeFile'             => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\File')) {
                return new \App\FormBuilder\FormBuilder\FieldType\File();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\File();
            }
        },
        'FieldTypeHidden'           => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Hidden')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Hidden();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\Hidden();
            }
        },
        'FieldTypeLikert'           => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Likert')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Likert();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\Likert();
            }
        },
        'FieldTypeLikertFrequency'  => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\LikertFrequency')) {
                return new \App\FormBuilder\FormBuilder\FieldType\LikertFrequency();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\LikertFrequency();
            }
        },
        'FieldTypeLikertImportance' => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\LikertImportance')) {
                return new \App\FormBuilder\FormBuilder\FieldType\LikertImportance();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\LikertImportance();
            }
        },
        'FieldTypeLikertInterest'   => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\LikertInterest')) {
                return new \App\FormBuilder\FormBuilder\FieldType\LikertInterest();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\LikertInterest();
            }
        },
        'FieldTypeLikertLikelihood' => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\LikertLikelihood')) {
                return new \App\FormBuilder\FormBuilder\FieldType\LikertLikelihood();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\LikertLikelihood();
            }
        },
        'FieldTypeLikertUsefulness' => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\LikertUsefulness')) {
                return new \App\FormBuilder\FormBuilder\FieldType\LikertUsefulness();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\LikertUsefulness();
            }
        },
        'FieldTypeNumber'           => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Number')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Number();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\Number();
            }
        },
        'FieldTypePassword'         => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Password')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Password();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\Password();
            }
        },
        'FieldTypeRadio'            => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Radio')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Radio();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\Radio();
            }
        },
        'FieldTypeScale'            => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Scale')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Scale();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\Scale();
            }
        },
        'FieldTypeSelect'           => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Select')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Select();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\Select();
            }
        },
        'FieldTypeTel'              => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Tel')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Tel();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\Tel();
            }
        },
        'FieldTypeText'             => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Text')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Text();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\Text();
            }
        },
        'FieldTypeTextarea'         => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Textarea')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Textarea();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\Textarea();
            }
        },
        'FieldTypeTime'             => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Time')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Time();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\Time();
            }
        },
        'FieldTypeUrl'              => function () {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Url')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Url();
            } else {
                return new \Nails\FormBuilder\FormBuilder\FieldType\Url();
            }
        },
    ],
];
