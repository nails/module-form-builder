<?php

/**
 * This class provides the "File" field type
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\FormBuilder\FieldType;

use Nails\Cdn\Service\Cdn;
use Nails\Common\Service\View;
use Nails\Factory;
use Nails\FormBuilder\Exception\FieldTypeException;
use Nails\FormBuilder\FieldType\Base;

class File extends Base
{
    const LABEL = 'File';

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     *
     * @param array $aData The field's data
     *
     * @return string
     */
    public function render($aData)
    {
        /** @var View $oView */
        $oView = Factory::service('View');
        $sOut  = $oView->load('formbuilder/fields/open', $aData, true);
        $sOut  .= $oView->load('formbuilder/fields/body-file', $aData, true);
        $sOut  .= $oView->load('formbuilder/fields/close', $aData, true);

        return $sOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Validate and clean the user's entry
     *
     * @param mixed     $mInput The form input's value
     * @param \stdClass $oField The complete field object
     *
     * @throws FieldTypeException
     * @return mixed
     */
    public function validate($mInput, $oField)
    {
        if (!isset($_FILES['field']['error'][$oField->id]) && $oField->is_required) {
            throw new FieldTypeException('This field is required.', 1);
        }

        /** @var Cdn $oCdn */
        $oCdn = Factory::service('Cdn', \Nails\Cdn\Constants::MODULE_SLUG);

        if (isset($_FILES['field']['error'][$oField->id]) && $_FILES['field']['error'][$oField->id] !== UPLOAD_ERR_OK) {

            switch ($_FILES['field']['error'][$oField->id]) {

                case UPLOAD_ERR_INI_SIZE:

                    $maxFileSize = function_exists('ini_get') ? ini_get('upload_max_filesize') : null;

                    if (!is_null($maxFileSize)) {

                        $maxFileSize = $oCdn->returnBytes($maxFileSize);
                        $maxFileSize = $oCdn->formatBytes($maxFileSize);

                        $sError = 'The file exceeds the maximum size accepted by this server (which is ' . $maxFileSize . ').';

                    } else {

                        $sError = 'The file exceeds the maximum size accepted by this server.';
                    }
                    break;

                case UPLOAD_ERR_FORM_SIZE:

                    $sError = 'The file exceeds the maximum size accepted by this server.';
                    break;

                case UPLOAD_ERR_PARTIAL:

                    $sError = 'The file was only partially uploaded.';
                    break;

                case UPLOAD_ERR_NO_FILE:

                    //  If the field is not required then don't error
                    $sError = $oField->is_required ? 'No file was uploaded.' : null;
                    break;

                case UPLOAD_ERR_NO_TMP_DIR:

                    $sError = 'This server cannot accept uploads at this time.';
                    break;

                case UPLOAD_ERR_CANT_WRITE:

                    $sError = 'Failed to write uploaded file to disk, you can try again.';
                    break;

                case UPLOAD_ERR_EXTENSION:

                    $sError = 'The file failed to upload due to a server configuration.';
                    break;

                default:

                    $sError = 'The file failed to upload.';
                    break;
            }

            if (!emptY($sError)) {
                throw new FieldTypeException($sError, 1);
            }
        }

        //  Upload the file and return the Object ID
        $sPath = !empty($_FILES['field']['tmp_name'][$oField->id]) ? $_FILES['field']['tmp_name'][$oField->id] : null;
        $sName = !empty($_FILES['field']['name'][$oField->id]) ? $_FILES['field']['name'][$oField->id] : null;

        if (!empty($sPath)) {

            $oResult = $oCdn->objectCreate(
                $sPath,
                [
                    'slug'      => 'formbuilder-file-upload',
                    'is_hidden' => true,
                ],
                ['filename_display' => $sName]
            );

            if (!$oResult) {
                throw new FieldTypeException('Failed to upload file. ' . $oCdn->lastError(), 1);
            }

            return $oResult->id;

        } else {
            return null;
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Extracts the TEXT component of the response
     *
     * @param string $sKey   The answer's key
     * @param string $mValue The answer's value
     *
     * @return integer
     */
    public function extractText($sKey, $mValue)
    {
        $oCdn = Factory::service('Cdn', \Nails\Cdn\Constants::MODULE_SLUG);
        $oObj = $oCdn->getObject($mValue);

        $sOut = $oObj->file->name->human . ' (' . $oObj->file->size->human . ')';
        $sOut .= '<a href="' . cdnServe($oObj->id, true) . '" class="btn btn-xs btn-primary pull-right">Download</a>';

        return $sOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Extracts any DATA which the Field Type might want to store
     *
     * @param string $sKey   The answer's key
     * @param string $mValue The answer's value
     *
     * @return integer
     */
    public function extractData($sKey, $mValue)
    {
        return $mValue;
    }
}
