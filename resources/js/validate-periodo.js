$(document).ready(function() {
    $('#modal-registrar-periodo').on('shown.bs.modal', function () {
        $('#nombre-error').text('');
        $('#fecha_inicio-error').text('');
        $('#fecha_fin-error').text('');
       
    });

    $('#btn-guardar-periodo').click(function() {
        var nombre = $('#nombre-periodo').val();
        var f_inicio = $('#fecha-inicio').val();
        var f_fin = $('#fecha-fin').val();

        if (nombre === '') {
            $('#nombre-error').text('El campo Nombre del Periodo es obligatorio.');
            return false;
        }
       
        if (f_inicio === '') {
            $('#fecha_inicio-error').text('El campo Fecha Inicio es obligatorio.');
            return false;
        }

        if (f_fin === '') {
            $('#fecha_fin-error').text('El campo Fecha Fin es obligatorio.');
            return false;
        }

       
        // Si todos los campos están llenos, envía el formulario
        $('#form-registrar-periodo').submit();
    });

    $('#modal-registrar-periodo').on('hidden.bs.modal', function () {
        $('#nombre-error').text('');
        $('#fecha_inicio-error').text('');
        $('#fecha_fin-error').text('');
    });

    // Verificar si hay datos en el campo y limpiar el mensaje de error
    $('#nombre-periodo').on('input', function() {
        if ($(this).val() !== '') {
            $('#nombre-error').text('');
        }
    });

    $('#fecha-inicio').on('input', function() {
        if ($(this).val() !== '') {
            $('#fecha_inicio-error').text('');
        }
    });

    $('#fecha-fin').on('input', function() {
        if ($(this).val() !== '') {
            $('#fecha_fin-error').text('');
        }
    });
});