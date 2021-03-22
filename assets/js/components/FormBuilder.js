class FormBuilder {
    constructor(adminController) {
        this.adminController = adminController;
        this.init();
    }

    // --------------------------------------------------------------------------

    init() {
        $('.form-builder')
            .each((index, element) => {

                let $container = $(element);

                $(element).data('instance', new Instance(
                    this.adminController,
                    $container
                ));
            });
    }
}

class Instance {

    constructor(adminController, $container) {

        this.adminController = adminController;
        this.$container = $container;
        this.tplField = $('.js-template-field', this.$container).html();
        this.tplOption = $('.js-template-field-option', this.$container).html();
        this.fieldsHeader = $('.form-builder__header', this.$container);
        this.fieldsTable = $('.form-builder__fields', this.$container);
        this.fieldCount = 0;

        //  Fetch types
        this.types = $container.data('field-types');

        //  Field bindings
        $(this.$container)
            .on('change', '.field-type', (e) => {
                this.fieldTypeChanged($(e.currentTarget));
            })
            .on('click', '.js-remove-field', (e) => {
                this.removeField($(e.currentTarget));
                return false;
            })
            .on('click', '.js-add-option', (e) => {
                this.addOption($(e.currentTarget));
                return false;
            })
            .on('click', '.js-manage-option', (e) => {
                this.manageOptions($(e.currentTarget));
                return false;
            })
            .on('click', '.js-remove-option', (e) => {
                this.removeOption($(e.currentTarget));
                return false;
            });

        $('.js-add-field', this.$container)
            .on('click', () => {
                this.addField();
                return false;
            });

        // --------------------------------------------------------------------------

        //  Initial states
        $('td.type .field-type', this.fieldsTable)
            .each((index, element) => {
                $(element).trigger('change');
            });

        this.fieldCount = $('tbody tr', this.fieldsTable).length - 1;

        // --------------------------------------------------------------------------

        //  Sortables
        $(this.fieldsTable)
            .sortable({
                'items': 'tbody',
                'handle': '.handle',
                'axis': 'y',
                'placeholder': 'sortable-placeholder',
                'helper': (e, tbody) => {

                    let $originals = tbody.find('td');
                    let $helper = tbody.clone();

                    // Set helper cell sizes to match the original sizes
                    $helper
                        .find('td')
                        .each(function(index) {
                            $(this).width($originals.eq(index).outerWidth());
                        });

                    //  Some helper styling for nice
                    $helper.css({
                        'margin-left': '-1px',
                        'box-shadow': '0px 2px 5px rgba(0, 0, 0, 0.25)'
                    });

                    return $helper;
                },
                'start': function(e, ui) {

                    ui.placeholder.append('<tr><td colspan="8"><div></div></td></tr>');
                    ui.placeholder.find('td').height(ui.helper.outerHeight());
                    // ui.placeholder.find('td').width(ui.helper.outerWidth());
                }
            });
    };

    // --------------------------------------------------------------------------

    /**
     * Adds a new field to the table
     * @return {Object}
     */
    addField() {

        this.fieldCount++;

        this.log('Adding new field');

        let tpl, tplData;
        tplData = {
            'fieldNumber': this.fieldCount
        };
        tpl = Mustache.render(this.tplField, tplData);
        $('> tfoot', this.fieldsTable).before(tpl);

        //  Init the select2's
        $('> tbody', this.fieldsTable).last().find('.select2').select2();

        //  Init the field type
        $('> tbody', this.fieldsTable).last().find('td.type .field-type').trigger('change');

        return this;
    };

    // --------------------------------------------------------------------------

    /**
     * Removes an existing field from the table
     * @param  {Object} elem The button which was clicked
     * @return {Object}
     */
    removeField(elem) {

        let fieldNumber = elem.data('field-number');
        this.log('Removing field: ' + fieldNumber);
        elem.closest('tbody').remove();
        $('.form-field-options-' + fieldNumber, this.$container).remove();
        return this;
    };

    // --------------------------------------------------------------------------

    /**
     * Adds an option for fields which support multiple options
     * @param {Object} elem The button which was clicked
     * @return {Object}
     */
    addOption(elem) {

        let fieldNumber, optionCount, table, tpl, tplData;
        fieldNumber = elem.data('field-number');
        table = elem.closest('table');
        optionCount = table.data('option-count') || 0;

        this.log('Adding Option for field: ' + fieldNumber);
        this.log('Number of existing options: ' + optionCount);

        tplData = {
            'fieldNumber': fieldNumber,
            'optionNumber': optionCount
        };
        tpl = Mustache.render(this.tplOption, tplData);
        table.find('tbody').append(tpl);

        optionCount++;

        this.log('New option count: ' + optionCount);
        table.data('option-count', optionCount);

        return this;
    };

    // --------------------------------------------------------------------------

    /**
     * Toggles the manage options view
     * @param  {Object} elem The button which was clicked
     * @return {Object}
     */
    manageOptions(elem) {

        let fieldNumber = elem.data('field-number');
        this.log('Managing options for field: ' + fieldNumber);

        let optionsRow = elem
            .closest('tr')
            .next();

        if (optionsRow.hasClass('active')) {

            optionsRow
                .find('td > .form-field-options')
                .stop()
                .slideUp(null, function() {
                    optionsRow.removeClass('active');
                });

        } else {

            optionsRow
                .addClass('active')
                .find('td > .form-field-options')
                .stop()
                .slideDown();
        }
        return this;
    };

    // --------------------------------------------------------------------------

    /**
     * Removes an option
     * @param  {Object} elem The button which was clicked
     * @return {Object}
     */
    removeOption(elem) {

        let fieldNumber;
        fieldNumber = elem.data('field-number');
        this.log('Removing option for field: ' + fieldNumber);
        elem.closest('tr').remove();
        return this;
    };

    // --------------------------------------------------------------------------

    /**
     * Triggered when a field type is changed
     * @param  {Object} elem The field which changed
     * @return {Object}
     */
    fieldTypeChanged(elem) {

        let slug = elem.val();

        this.log('Field slug changed to: ' + slug);

        //  Supports options?
        if (this.doesSupportOptions(slug)) {
            this.log('Supports options; showing');
            elem.siblings('a').addClass('is-active');
        } else {
            this.log('Does not support options; hiding');
            elem.siblings('a').removeClass('is-active');
            elem.closest('tr').next().removeClass('active');
        }

        //  Can the options be selected
        if (this.doesSupportOptionSelect(slug)) {
            this.log('Supports option selection; showing');
            elem.closest('tbody').find('tr.options table').addClass('is-selectable');
        } else {
            this.log('Does not support option selection; hiding');
            elem.closest('tbody').find('tr.options table').removeClass('is-selectable');
            elem.closest('tbody').find('tr.options .option-selected').prop('checked', false);
        }

        //  Can the options be disabled?
        if (this.doesSupportOptionDisable(slug)) {
            this.log('Supports option disabling; showing');
            elem.closest('tbody').find('tr.options table').addClass('is-disableable');
        } else {
            this.log('Does not support option disabling; hiding');
            elem.closest('tbody').find('tr.options table').removeClass('is-disableable');
            elem.closest('tbody').find('tr.options .option-disabled').prop('checked', false);
        }

        //  Supports default value?
        if (this.doesSupportDefaultValue(slug)) {
            this.log('Supports default value; showing');
            elem.closest('tr').find('td.default .js-supports-default-value').show();
            elem.closest('tr').find('td.default .js-no-default-value').hide();
        } else {
            this.log('Does not support default value; hiding');
            elem.closest('tr').find('td.default .js-supports-default-value').hide();
            elem.closest('tr').find('td.default .js-no-default-value').show();
        }

        //  Supports placeholder?
        if (this.doesSupportPlaceholder(slug)) {
            this.log('Supports placeholder; showing');
            elem.closest('tr').find('td.placeholder .js-supports-placeholder').show();
            elem.closest('tr').find('td.placeholder .js-no-placeholder').hide();
        } else {
            this.log('Does not support placeholder; hiding');
            elem.closest('tr').find('td.placeholder .js-supports-placeholder').hide();
            elem.closest('tr').find('td.placeholder .js-no-placeholder').show();
        }

        //  Supports required?
        if (this.doesSupportRequired(slug)) {
            this.log('Supports required; showing');
            elem.closest('tr').find('td.required .js-supports-required').show();
            elem.closest('tr').find('td.required .js-no-required').hide();
        } else {
            this.log('Does not support required; hiding');
            elem.closest('tr').find('td.required .js-supports-required').hide();
            elem.closest('tr').find('td.required .js-no-required').show();
        }

        //  Supports custom attributes
        if (this.doesSupportRequired(slug)) {
            this.log('Supports custom attributes; showing');
            elem.closest('tr').find('td.attributes .js-supports-attributes').show();
            elem.closest('tr').find('td.attributes .js-no-attributes').hide();
        } else {
            this.log('Does not support custom attributes; hiding');
            elem.closest('tr').find('td.attributes .js-supports-attributes').hide();
            elem.closest('tr').find('td.attributes .js-no-attributes').show();
        }

        return this;
    };

    // --------------------------------------------------------------------------

    /**
     * Determines whether a field type supports a particular behaviour
     * @param slug
     * @param behaviour
     * @returns {boolean}
     */
    doesSupportBehaviour(slug, behaviour) {
        try {
            return this.types.find(item => item.slug === slug)[behaviour];
        } catch (e) {
            return false;
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Determines whether a particular field type supports options
     * @param  {string} slug The field type's slug
     * @return {boolean}
     */
    doesSupportOptions(slug) {
        return this.doesSupportBehaviour(slug, 'supports_options');
    };

    // --------------------------------------------------------------------------

    /**
     * Determines whether a particular field type supports selected options
     * @param  {string} slug The field type's slug
     * @return {boolean}
     */
    doesSupportOptionSelect(slug) {
        return this.doesSupportBehaviour(slug, 'supports_options_selected');
    };

    // --------------------------------------------------------------------------

    /**
     * Determines whether a particular field type supports disabled options
     * @param  {string} slug The field type's slug
     * @return {boolean}
     */
    doesSupportOptionDisable(slug) {
        return this.doesSupportBehaviour(slug, 'supports_options_disabled');
    };

    // --------------------------------------------------------------------------

    /**
     * Determines whether a particular field type supports default values
     * @param  {string} slug The field type's slug
     * @return {boolean}
     */
    doesSupportDefaultValue(slug) {
        return this.doesSupportBehaviour(slug, 'supports_default_values');
    };

    // --------------------------------------------------------------------------

    /**
     * Determines whether a particular field type supports placeholders
     * @param  {string} slug The field type's slug
     * @return {boolean}
     */
    doesSupportPlaceholder(slug) {
        return this.doesSupportBehaviour(slug, 'supports_placeholder');
    };

    // --------------------------------------------------------------------------

    /**
     * Determines whether a particular field type supports being required
     * @param  {string} slug The field type's slug
     * @return {boolean}
     */
    doesSupportRequired(slug) {
        return this.doesSupportBehaviour(slug, 'supports_required');
    };

    // --------------------------------------------------------------------------

    /**
     * Determines whether a particular field type supports custom attributes
     * @param  {string} slug The field type's slug
     * @return {boolean}
     */
    doesSupportCustomAttributes(slug) {
        return this.doesSupportBehaviour(slug, 'supports_custom_attributes');
    };

    // --------------------------------------------------------------------------

    /**
     * Write a log to the console
     * @return {Void}
     */
    log() {
        this.adminController.log(...arguments);
    };

    // --------------------------------------------------------------------------

    /**
     * Write a warning to the console
     * @return {Void}
     */
    warn(message, payload) {
        this.adminController.warn(...arguments);
    };
};

export default FormBuilder;
