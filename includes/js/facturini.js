function IsNumeric(data) {
    return parseFloat(data) == data;
}

function reset_error(campError) {
    var div = document.getElementById(campError);
    div.innerHTML = "";
}

function validar_formulari(form) {
    var form_ok = 1;
    if (!IsNumeric(form.factura.value)) {
        document.getElementById('facturaError').innerHTML = "El total ha de ser un valor numeric amb '.' per separar la part decimal.";
        form_ok = 0;
    }

    return (form_ok == 1);
}
