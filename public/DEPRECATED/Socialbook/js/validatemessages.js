/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery.extend(jQuery.validator.messages, {
    required: "<br/>^ Éste campo es requerido",
    remote: "<br/>^ Valor no valido",
    email: "<br/>^ La dirección de correo tiene un formato invalido",
    url: "<br/>^ La URL tiene un formato invalido",
    date: "<br/>^ La fecha introducida no es válida",
    dateISO: "<br/>^ La fecha debe tener un formato ISO",
    number: "<br/>^ Introduzca un número",
    digits: "<br/>^ Sólo digitos en éste campo",
    creditcard: "<br/>^ El número de tarjeta es erroneo",
    equalTo: "<br/>^ La contraseña no coincide",
    accept: "<br/>^ Extension no válida",
    maxlength: jQuery.validator.format("<br/>^ El valor introducido sobrepasa los {0} caracteres permitidos"),
    minlength: jQuery.validator.format("<br/>^ El valor introducido tiene menos de {0} caracteres"),
    rangelength: jQuery.validator.format("<br/>^ Introduzca entre {0} y {1} caracteres"),
    range: jQuery.validator.format("<br/>^ Introduzca un número entre {0} y {1}"),
    max: jQuery.validator.format("<br/>^ Introduzca un valor no superior a {0}"),
    min: jQuery.validator.format("<br/>^ Introduzca un valor no inferior a {0}.")
});