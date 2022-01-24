	-- MAGNUS BLOG SYSTEM --
-----------------------------------------------
Current Version: 0.1.9b (Beta) 28 - September - 2008
Last stable version: 0.1.9b
PHP Version: PHP 4.x / PHP 5.x
   - WORK IN PROGRESS -
-----------------------------------------------

MBS - Magnus Blog System

MBS es un sistema de blogging en español. Tan solo necesitas una
plantilla web donde "incrustar" el archivo main.php, ¡Y lísto!
Tambien necesitas cambiar el nombre de usuario y la contraseña
de MySQL, así como la base de datos donde piensa alojar su blog,
en el archivo connect.php que se encuentra dentro de la carpeta
'res', en el mismo directorio del blog.

res/connect.php

Ademas hay que poner los datos de tu blog en rssvar.php

res/rssvar.php

Una vez hecho esto, es necesario ejecutar el archivo install.php
en tu navegador para crear las tablas MySQL necesarias para almacenar
la información del blog. Recuerde que debe borrar este archivo tras
instalarlo, por seguridad.

Para acceder al panel de control, en su navegador acceda al archivo

conf/main.php

Para poder usar este blog con una plantilla web, consiga una buena plantilla PHP donde colocar su blog,
e inserte la siguiente línea donde quiere que se cargue su blog:

<?php include("main.php"); ?>

Guarde el documento con el nombre blog.php, subalo a su servidor, y ejecutelo. A continuación verá
sus entradas y los comentarios en su plantilla, y con el estilo CSS que usted
haya seleccionado. Recuerde que en su archivo CSS debe venir declarado "bquote", de la siguiente
manera:

bquote {
display: block;
background-image: url('img/bg_blockquote.gif');
background-repeat:no-repeat;
background-color: #FFFACD;
font-size: 10pt;
font-family : arial,helvetica;
font-style: italic;
text-indent: 1cm
}

Naturalmente, puede cambiar los parametros por los que usted desee, o incluso no especificarlo.
Si no lo especifica, no podrá usar las etiquetas bquote para resaltar citas de texto.

La pagina debe estar en el mismo directorio que el blog. De estar en otro directorio,
deberá especificarlo. Por ejemplo, si lo tengo en una subcarpeta llamada "blog" en
el mismo directorio que mi pagina, en mi pagina debería poner:

<?php include("blog/main.php"); ?>

Y así sucesivamente.

-- FAQ --

Q: He subido los archivos a mi servidor, pero aparece un mensaje en rojo que dice "Connection
with SQL database failed!"

A: ¿Ha colocado correctamente los datos de tu servidor en el archivo res/connect.php? De no ser
asi, reviselos y asegurese de que los datos son los correctos.

Q: El blog aparece, pero no mis entradas, ¡Y si que hay entradas!

A: Asegurese de que la base de datos especificada en res/connect.php es la correcta.

Q: El RSS solo muestra 1 entrada, o ninguna.

A: En algunos servidores, especialmente los gratuitos, algunos archivos PHP no funcionan
correctamente. En especial el del RSS, y los de modificar el karma en los comentarios.
En teoría deberían funcionar, pues donde yo he desarrollado este blog si lo hace, pero
si no lo hace en el suyo, pruebe (si puede) a actualizar su versión de PHP, MySQL y
otros programas relacionados que esté usando a la última versión.

Q: Me dice que mi contraseña no es correcta...

A: Revise la contraseña especificada en res/connect.php

Q: ¿Es seguro colocar los datos en el archivo res/connect.php? ¿Podría robar alguien
mis contraseñas desde ahi?

A: Es seguro. Los archivos .php son procesados por el servidor antes de llegar al usuario.
Incluso aunque intentase descargar el archivo, lo único que veria es el resultado de
procesar todas las instrucciones, pero nunca el código en si. No obstante, hay gente
con bastante tiempo libre capaz de colarse en un servidor usando bruteforcers y otros
hack tools para modificar todos tus archivos via FTP. Normalmente suelen borrar todo
el contenido y subir alguna pagina indicando que has sido hackeado, pero es posible que
pudieran robar tus contraseñas y hacer lo mismo en la base de datos. En cualquier caso,
si alojas el blog en un servidor con buenos sistemas de seguridad, el riesgo de que esto
pase se reduce a un mínimo, pero no a un imposible (incluso microsoft es hackeable).

[ PARA CUALQUIER COMENTARIO O REPORTE DE BUGS, ESCRIBA A kotiteoliisus@hotmail.com ]
-- Developed and still being developed by Magnus --
