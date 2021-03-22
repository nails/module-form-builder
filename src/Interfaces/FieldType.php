<?php

namespace Nails\FormBuilder\Interfaces;

/**
 * Interface FieldType
 *
 * @package Nails\FormBuilder\Interfaces
 */
interface FieldType
{
    /**
     * Returns the field type's label
     *
     * @return string
     */
    public static function getLabel(): string;

    // --------------------------------------------------------------------------

    /**
     * Returns whether the field type supports options
     *
     * @return bool
     */
    public static function supportsOptions(): bool;

    // --------------------------------------------------------------------------

    /**
     * Returns whether the field type supports setting an option as selected
     *
     * @return bool
     */
    public static function supportsOptionsSelected(): bool;

    // --------------------------------------------------------------------------

    /**
     * Returns whether the field type supports setting an option as disabled
     *
     * @return bool
     */
    public static function supportsOptionsDisabled(): bool;

    // --------------------------------------------------------------------------

    /**
     * Returns whether the field type supports default values
     *
     * @return bool
     */
    public static function supportsDefaultValues(): bool;

    // --------------------------------------------------------------------------

    /**
     * Returns whether the field type supports placeholder values
     *
     * @return bool
     */
    public static function supportsPlaceholder(): bool;

    // --------------------------------------------------------------------------

    /**
     * Returns whether the field type supports being marked as required
     *
     * @return bool
     */
    public static function supportsRequired(): bool;

    // --------------------------------------------------------------------------

    /**
     * Returns whether the field type supports custom attributes values
     *
     * @return bool
     */
    public static function supportsCustomAttributes(): bool;

    // --------------------------------------------------------------------------

    /**
     * Returns whether the field type can be selected by human users
     *
     * @return bool
     */
    public static function isSelectable(): bool;

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     *
     * @param array $aConfig The config array
     *
     * @return string
     */
    public function render(array $aConfig): string;

    // --------------------------------------------------------------------------

    /**
     * Validate and clean the user's entry
     *
     * @param mixed     $mInput The form input's value
     * @param \stdClass $oField The complete field object
     *
     * @return mixed
     */
    public function validate($mInput, $oField);

    // --------------------------------------------------------------------------

    /**
     * Extracts the OPTION component of the response
     *
     * @param string $sKey   The answer's key
     * @param mixed  $mValue The answer's value
     *
     * @return int|null
     */
    public function extractOptionId(string $sKey, $mValue): ?int;

    // --------------------------------------------------------------------------

    /**
     * Extracts the TEXT component of the response
     *
     * @param string $sKey       The answer's key
     * @param mixed  $mValue     The answer's value
     * @param bool   $bPlainText Whether to force plaintext
     *
     * @return string
     */
    public function extractText(string $sKey, $mValue, bool $bPlainText = false): ?string;

    // --------------------------------------------------------------------------

    /**
     * Extracts any DATA which the Field Type might want to store
     *
     * @param string $sKey   The answer's key
     * @param mixed  $mValue The answer's value
     *
     * @return mixed
     */
    public function extractData(string $sKey, $mValue);

    // --------------------------------------------------------------------------

    /**
     * Takes responses for this field type and aggregates them into data suitable for stats/charting
     *
     * @param array $aResponses The array of responses from ResponseAnswer
     *
     * @return array[]
     */
    public function getStatsChartData(array $aResponses): array;

    // --------------------------------------------------------------------------

    /**
     * Takes responses for this field type and extracts all the text components
     *
     * @param array $aResponses The array of responses from ResponseAnswer
     *
     * @return string[]
     */
    public function getStatsTextData(array $aResponses): array;
}
