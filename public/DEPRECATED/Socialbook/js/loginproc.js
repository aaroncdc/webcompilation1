/* 
 *              - Comprobación de los datos de inicio de sesión -
 *                          Por Aarón C.d.C
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    //Colores CSS
    var defcolor = "#5E768D", errcolor = "#DD765E";
    //Banderas de error
    var noname = 0x1, nopssword = 0x2, badname = 0x4, badpssword = 0x8;
    var postpage = "test.html";
    
    /*
     * Comprueba si hay una bandera activada
     * @param {int} val (Valor a comprobar)
     * @param {int} flag (Bandera)
     * @returns (void)
     */
    function checkflag(val, flag) {
        return (val & flag);
    }
    
    /*
     * Comprueba si hay banderas activadas, y genera el correspondiente mensaje
     * de error a mostrar.
     * @param {int} val
     * @returns {String}
     */
    function check(val) {
        var errorstr = "Error:\n";
        if(checkflag(val, noname))
            errorstr += "\nDebe especificar un correo electrónico.";
        if(checkflag(val, nopssword))
            errorstr += "\nDebe especificar la contraseña asociada a la cuenta.";
        if(checkflag(val, badname))
            errorstr += "\nEl correo asociado contiene caraceres no validos, o no es un correo valido.";
        if(checkflag(val, badpssword))
            errorstr += "\nLa contraseña es incorrecta";
        return errorstr;
    }
    
    /*
     * Función principal
     * @param {type} param
     */
    $(document).ready(function(){
        $('.tooltip').tooltipster();
        $("#b1").click(function(){
            var errors = 0;
            if($("#nom1").val() == ""){
                $("#nom1").css("background-color", errcolor);
                errors |= noname;
            }
                
            if($("#pss1").val() == ""){
                $("#pss1").css("background-color", errcolor);
                errors |= nopssword;
            }
            if(errors > 0)
                alert(check(errors));
            else{
                loginform.submit();
                /*$.post(postpage,{nomb: $("#nom1").val(), pass: $("#pss1").val()},function(retval){
                    //alert("OK. " + retval);
                    
                });*/
            }
        });
        $("#nom1").hover(function(){
            $(this).css("background-color", defcolor);
        });
        $("#pss1").hover(function(){
            $(this).css("background-color", defcolor);
        });
    });