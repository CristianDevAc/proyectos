import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


// SELECT2
import $ from 'jquery';
import 'select2';
import 'select2/dist/css/select2.css';

// Ejecutar al cargar el DOM
$(document).ready(function () {
    $('#proveedor_id').select2({
        placeholder: "Buscar proveedor...",
        width: '100%'
    });
});