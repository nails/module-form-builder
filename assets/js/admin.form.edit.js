/* globals Mustache, console */
var _ADMIN_FORM_EDIT;
_ADMIN_FORM_EDIT = function(domElement, typeWithOptions, typeWithDefaultValue)
{
    /**
     * Avoid scope issues in callbacks and anonymous functions by referring to `this` as `base`
     * @type {Object}
     */
    var base = this;

    // --------------------------------------------------------------------------

    base.domElement           = domElement || null;
    base.tplField             = $('.js-template-field', base.domElement).html();
    base.tplOption            = $('.js-template-field-option', base.domElement).html();
    base.fieldsTable          = $('.form-builder__fields', base.domElement);
    base.fieldCount           = 0;
    base.typeWithOptions      = typeWithOptions || [];
    base.typeWithDefaultValue = typeWithDefaultValue || [];

    // --------------------------------------------------------------------------

    /**
     * Construct the class
     * @return {Void}
     */
    base.__construct = function()
    {
        //  Field bindings
        $(base.domElement).on('change', '.field-type', function() {
            base.fieldTypeChanged($(this));
        });

        $(base.domElement).on('change', '.field-default', function() {
            base.fieldDefaultChanged($(this));
        });

        $('.js-add-field', base.domElement).on('click', function() {
            base.addField();
            return false;
        });

        $(base.domElement).on('click', '.js-remove-field', function() {
            base.removeField($(this));
            return false;
        });

        $(base.domElement).on('click', '.js-add-option', function() {
            base.addOption($(this));
            return false;
        });

        $(base.domElement).on('click', '.js-manage-option', function() {
            base.manageOptions($(this));
            return false;
        });

        $(base.domElement).on('click', '.js-remove-option', function() {
            base.removeOption($(this));
            return false;
        });

        // --------------------------------------------------------------------------

        //  Initial states
        $('td.type .field-type, td.default .field-default', base.fieldsTable).each(function() {
            $(this).trigger('change');
        });

        base.fieldCount = $('tbody tr', base.fieldsTable).length-1;

        // --------------------------------------------------------------------------

        //  Sortables
        $(base.fieldsTable).sortable({
            'items': 'tbody',
            'handle': '.handle',
            'axis': 'y',
            'placeholder': 'placeholder',
            'helper': function(e, tbody) {

                var $originals = tbody.find('td');
                var $helper    = tbody.clone();

                // Set helper cell sizes to match the original sizes
                $helper.find('td').each(function(index) {
                    $(this).width($originals.eq(index).outerWidth());
                });

                //  Some helper styling for nice
                $helper.css({
                    'margin-left':'-1px',
                    'box-shadow': '0px 2px 5px rgba(0, 0, 0, 0.25)'
                });

                return $helper;
            },
            'start': function(e, ui) {

                ui.placeholder.append('<tr><td colspan="9"><div></div></td></tr>');
                ui.placeholder.find('td').height(ui.helper.outerHeight());
                ui.placeholder.find('td').width(ui.helper.outerWidth());
            }
        });
    };

    // --------------------------------------------------------------------------

    /**
     * Adds a new field to the table
     * @return {Object}
     */
    base.addField = function() {

        base.fieldCount++;

        base.log('Adding new field');

        var tpl, tplData;
        tplData = {
            'fieldNumber': base.fieldCount
        };
        tpl = Mustache.render(base.tplField, tplData);
        $('> tfoot', base.fieldsTable).before(tpl);

        //  Init the select2's
        $('> tbody', base.fieldsTable).last().find('.select2').select2();

        //  Init the field type and default value
        $('> tbody', base.fieldsTable).last().find('td.type .field-type').trigger('change');
        $('> tbody', base.fieldsTable).last().find('td.type .field-default').trigger('change');

        return base;
    };

    // --------------------------------------------------------------------------

    /**
     * Removes an existing field from the table
     * @param  {Object} elem The button which was clicked
     * @return {Object}
     */
    base.removeField = function(elem) {

        var fieldNumber = elem.data('field-number');
        base.log('Removing field: ' + fieldNumber);
        elem.closest('tbody').remove();
        $('.form-field-options-' + fieldNumber, base.domElement).remove();
        return base;
    };

    // --------------------------------------------------------------------------

    /**
     * Adds an option for fields which support multiple options
     * @param {Object} elem The button which was clicked
     * @return {Object}
     */
    base.addOption = function(elem) {

        var fieldNumber, optionCount, table, tpl, tplData;
        fieldNumber = elem.data('field-number');
        table       = elem.closest('table');
        optionCount = table.data('option-count') || 0;

        base.log('Adding Option for field: ' + fieldNumber);
        base.log('Number of existing options: ' + optionCount);

        tplData = {
            'fieldNumber': fieldNumber,
            'optionNumber': optionCount
        };
        tpl = Mustache.render(base.tplOption, tplData);
        table.find('tbody').append(tpl);

        optionCount++;

        base.log('New option count: ' + optionCount);
        table.data('option-count', optionCount);

        return base;
    };

    // --------------------------------------------------------------------------

    /**
     * Toggles the manage options view
     * @param  {Object} elem The button which was clicked
     * @return {Object}
     */
    base.manageOptions = function(elem) {

        var fieldNumber = elem.data('field-number');
        base.log('Managing options for field: ' + fieldNumber);

        var optionsRow = elem.closest('tr').next();

        if (optionsRow.hasClass('active')) {

            optionsRow.find('td > .form-field-options').stop().slideUp(null, function() {
                optionsRow.removeClass('active');
            });

        } else {
            optionsRow.addClass('active').find('td > .form-field-options').stop().slideDown();
        }
        return base;
    };

    // --------------------------------------------------------------------------

    /**
     * Removes an option
     * @param  {Object} elem The button which was clicked
     * @return {Object}
     */
    base.removeOption = function(elem) {

        var fieldNumber;
        fieldNumber = elem.data('field-number');
        base.log('Removing option for field: ' + fieldNumber);
        elem.closest('tr').remove();
        return base;
    };

    // --------------------------------------------------------------------------

    /**
     * Triggered when a field type is changed
     * @param  {Object} elem The field which changed
     * @return {Object}
     */
    base.fieldTypeChanged = function(elem) {

        base.log('Field type changed to: ' + elem.val());


        //  Supports options?
        if ($.inArray(elem.val(), base.typeWithOptions) >= 0) {
            base.log('Supports options; showing');
            elem.siblings('a').addClass('is-active');
        } else {
            base.log('Does not support options; hiding');
            elem.siblings('a').removeClass('is-active');
            elem.closest('tr').next().removeClass('active');
        }

        //  Supports default value?
        if ($.inArray(elem.val(), base.typeWithDefaultValue) >= 0) {
            base.log('Supports default value; showing');
            elem.closest('tr').find('td.default .js-supports-default-value').show();
            elem.closest('tr').find('td.default .js-no-default-value').hide();
        } else {
            base.log('Does not support default value; hiding');
            elem.closest('tr').find('td.default .js-supports-default-value').hide();
            elem.closest('tr').find('td.default .js-no-default-value').show();
        }

        return base;
    };

    // --------------------------------------------------------------------------

    /**
     * Triggered when a default value is changed
     * @param  {Object} elem The field which changed
     * @return {Object}
     */
    base.fieldDefaultChanged = function(elem) {

        base.log('Default value changed to: ' + elem.val());

        switch (elem.val()) {

            case 'CUSTOM' :
                elem.siblings('input').addClass('is-active');
                break;

            default :
                elem.siblings('input').removeClass('is-active');
                break;
        }

        return base;
    };

    // --------------------------------------------------------------------------

    /**
     * Write a log to the console
     * @param  {String} message The message to log
     * @param  {Mixed}  payload Any additional data to display in the console
     * @return {Void}
     */
    base.log = function(message, payload)
    {
        if (typeof(console.log) === 'function') {

            if (payload !== undefined) {

                console.log('Nails Form Builder:', message, payload);

            } else {

                console.log('Nails Form Builder:', message);
            }
        }
    };

    // --------------------------------------------------------------------------

    /**
     * Write a warning to the console
     * @param  {String} message The message to warn
     * @param  {Mixed}  payload Any additional data to display in the console
     * @return {Void}
     */
    base.warn = function(message, payload)
    {
        if (typeof(console.warn) === 'function') {

            if (payload !== undefined) {

                console.warn('Nails Form Builder:', message, payload);

            } else {

                console.warn('Nails Form Builder:', message);
            }
        }
    };

    // --------------------------------------------------------------------------

    return base.__construct();
};