<?php

use Nails\FormBuilder\FormBuilder\DefaultValue;
use Nails\FormBuilder\FormBuilder\FieldType;
use Nails\FormBuilder\Model;
use Nails\FormBuilder\Resource;
use Nails\FormBuilder\Service;

return [
    'services'  => [
        'DefaultValue' => function (): Service\DefaultValue {
            if (class_exists('\App\FormBuilder\Service\DefaultValue')) {
                return new \App\FormBuilder\Service\DefaultValue();
            } else {
                return new Service\DefaultValue();
            }
        },
        'FieldType'    => function (): Service\FieldType {
            if (class_exists('\App\FormBuilder\Service\FieldType')) {
                return new \App\FormBuilder\Service\FieldType();
            } else {
                return new Service\FieldType();
            }
        },
    ],
    'models'    => [
        'Form'            => function (): Model\Form {
            if (class_exists('\App\FormBuilder\Model\Form')) {
                return new \App\FormBuilder\Model\Form();
            } else {
                return new Model\Form();
            }
        },
        'FormField'       => function (): Model\FormField {
            if (class_exists('\App\FormBuilder\Model\FormField')) {
                return new \App\FormBuilder\Model\FormField();
            } else {
                return new Model\FormField();
            }
        },
        'FormFieldOption' => function (): Model\FormFieldOption {
            if (class_exists('\App\FormBuilder\Model\FormFieldOption')) {
                return new \App\FormBuilder\Model\FormFieldOption();
            } else {
                return new Model\FormFieldOption();
            }
        },
    ],
    'factories' => [
        /**
         * Default Values
         *  Silly namespace to avoid collision between app provided field types and app overrides.
         */
        'DefaultValueCustom'        => function (): DefaultValue\Custom {
            if (class_exists('\App\FormBuilder\FormBuilder\DefaultValue\Custom')) {
                return new \App\FormBuilder\FormBuilder\DefaultValue\Custom();
            } else {
                return new DefaultValue\Custom();
            }
        },
        'DefaultValueNone'          => function (): DefaultValue\None {
            if (class_exists('\App\FormBuilder\FormBuilder\DefaultValue\None')) {
                return new \App\FormBuilder\FormBuilder\DefaultValue\None();
            } else {
                return new DefaultValue\None();
            }
        },
        'DefaultValueTimestamp'     => function (): DefaultValue\Timestamp {
            if (class_exists('\App\FormBuilder\FormBuilder\DefaultValue\Timestamp')) {
                return new \App\FormBuilder\FormBuilder\DefaultValue\Timestamp();
            } else {
                return new DefaultValue\Timestamp();
            }
        },
        'DefaultValueUserEmail'     => function (): DefaultValue\UserEmail {
            if (class_exists('\App\FormBuilder\FormBuilder\DefaultValue\UserEmail')) {
                return new \App\FormBuilder\FormBuilder\DefaultValue\UserEmail();
            } else {
                return new DefaultValue\UserEmail();
            }
        },
        'DefaultValueUserFirstName' => function (): DefaultValue\UserFirstName {
            if (class_exists('\App\FormBuilder\FormBuilder\DefaultValue\UserFirstName')) {
                return new \App\FormBuilder\FormBuilder\DefaultValue\UserFirstName();
            } else {
                return new DefaultValue\UserFirstName();
            }
        },
        'DefaultValueUserId'        => function (): DefaultValue\UserId {
            if (class_exists('\App\FormBuilder\FormBuilder\DefaultValue\UserId')) {
                return new \App\FormBuilder\FormBuilder\DefaultValue\UserId();
            } else {
                return new DefaultValue\UserId();
            }
        },
        'DefaultValueUserLastName'  => function (): DefaultValue\UserLastName {
            if (class_exists('\App\FormBuilder\FormBuilder\DefaultValue\UserLastName')) {
                return new \App\FormBuilder\FormBuilder\DefaultValue\UserLastName();
            } else {
                return new DefaultValue\UserLastName();
            }
        },
        'DefaultValueUserName'      => function (): DefaultValue\UserName {
            if (class_exists('\App\FormBuilder\FormBuilder\DefaultValue\UserName')) {
                return new \App\FormBuilder\FormBuilder\DefaultValue\UserName();
            } else {
                return new DefaultValue\UserName();
            }
        },

        /**
         * Field Types
         * Silly namespace to avoid collision between app provided field types and app overrides.
         */
        'FieldTypeCaptcha'          => function (): FieldType\Captcha {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Captcha')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Captcha();
            } else {
                return new FieldType\Captcha();
            }
        },
        'FieldTypeCheckbox'         => function (): FieldType\Checkbox {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Checkbox')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Checkbox();
            } else {
                return new FieldType\Checkbox();
            }
        },
        'FieldTypeDate'             => function (): FieldType\Date {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Date')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Date();
            } else {
                return new FieldType\Date();
            }
        },
        'FieldTypeDateTime'         => function (): FieldType\DateTime {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\DateTime')) {
                return new \App\FormBuilder\FormBuilder\FieldType\DateTime();
            } else {
                return new FieldType\DateTime();
            }
        },
        'FieldTypeEmail'            => function (): FieldType\Email {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Email')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Email();
            } else {
                return new FieldType\Email();
            }
        },
        'FieldTypeFile'             => function (): FieldType\File {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\File')) {
                return new \App\FormBuilder\FormBuilder\FieldType\File();
            } else {
                return new FieldType\File();
            }
        },
        'FieldTypeHidden'           => function (): FieldType\Hidden {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Hidden')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Hidden();
            } else {
                return new FieldType\Hidden();
            }
        },
        'FieldTypeLikert'           => function (): FieldType\Likert {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Likert')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Likert();
            } else {
                return new FieldType\Likert();
            }
        },
        'FieldTypeLikertFrequency'  => function (): FieldType\LikertFrequency {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\LikertFrequency')) {
                return new \App\FormBuilder\FormBuilder\FieldType\LikertFrequency();
            } else {
                return new FieldType\LikertFrequency();
            }
        },
        'FieldTypeLikertImportance' => function (): FieldType\LikertImportance {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\LikertImportance')) {
                return new \App\FormBuilder\FormBuilder\FieldType\LikertImportance();
            } else {
                return new FieldType\LikertImportance();
            }
        },
        'FieldTypeLikertInterest'   => function (): FieldType\LikertInterest {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\LikertInterest')) {
                return new \App\FormBuilder\FormBuilder\FieldType\LikertInterest();
            } else {
                return new FieldType\LikertInterest();
            }
        },
        'FieldTypeLikertLikelihood' => function (): FieldType\LikertLikelihood {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\LikertLikelihood')) {
                return new \App\FormBuilder\FormBuilder\FieldType\LikertLikelihood();
            } else {
                return new FieldType\LikertLikelihood();
            }
        },
        'FieldTypeLikertQuality'    => function (): FieldType\LikertQuality {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\LikertQuality')) {
                return new \App\FormBuilder\FormBuilder\FieldType\LikertQuality();
            } else {
                return new FieldType\LikertQuality();
            }
        },
        'FieldTypeLikertUsefulness' => function (): FieldType\LikertUsefulness {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\LikertUsefulness')) {
                return new \App\FormBuilder\FormBuilder\FieldType\LikertUsefulness();
            } else {
                return new FieldType\LikertUsefulness();
            }
        },
        'FieldTypeNumber'           => function (): FieldType\Number {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Number')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Number();
            } else {
                return new FieldType\Number();
            }
        },
        'FieldTypePassword'         => function (): FieldType\Password {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Password')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Password();
            } else {
                return new FieldType\Password();
            }
        },
        'FieldTypeRadio'            => function (): FieldType\Radio {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Radio')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Radio();
            } else {
                return new FieldType\Radio();
            }
        },
        'FieldTypeScale'            => function (): FieldType\Scale {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Scale')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Scale();
            } else {
                return new FieldType\Scale();
            }
        },
        'FieldTypeSelect'           => function (): FieldType\Select {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Select')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Select();
            } else {
                return new FieldType\Select();
            }
        },
        'FieldTypeTel'              => function (): FieldType\Tel {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Tel')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Tel();
            } else {
                return new FieldType\Tel();
            }
        },
        'FieldTypeText'             => function (): FieldType\Text {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Text')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Text();
            } else {
                return new FieldType\Text();
            }
        },
        'FieldTypeTextarea'         => function (): FieldType\Textarea {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Textarea')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Textarea();
            } else {
                return new FieldType\Textarea();
            }
        },
        'FieldTypeTime'             => function (): FieldType\Time {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Time')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Time();
            } else {
                return new FieldType\Time();
            }
        },
        'FieldTypeUrl'              => function (): FieldType\Url {
            if (class_exists('\App\FormBuilder\FormBuilder\FieldType\Url')) {
                return new \App\FormBuilder\FormBuilder\FieldType\Url();
            } else {
                return new FieldType\Url();
            }
        },
    ],
    'resources' => [
        'DefaultValue' => function ($mObj): Resource\DefaultValue {
            if (class_exists('\App\FormBuilder\Resource\DefaultValue')) {
                return new \App\FormBuilder\Resource\DefaultValue($mObj);
            } else {
                return new Resource\DefaultValue($mObj);
            }
        },
        'FieldType'    => function ($mObj): Resource\FieldType {
            if (class_exists('\App\FormBuilder\Resource\FieldType')) {
                return new \App\FormBuilder\Resource\FieldType($mObj);
            } else {
                return new Resource\FieldType($mObj);
            }
        },
    ],
];
