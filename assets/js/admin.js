'use strict';

import '../sass/admin.scss';

import FormBuilder from './components/FormBuilder.js';

(function() {
    window.NAILS.ADMIN.registerPlugin(
        'nails/module-form-builder',
        'FormBuilder',
        function(controller) {
            return new FormBuilder(controller);
        }
    );
})();
