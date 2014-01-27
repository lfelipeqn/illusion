<?php

echo '<form enctype="multipart/form-data" action="uploader.php" method="POST">
<p>A Continuaci&oacute;n puede realizar la creaci&oacute;n de nuevas unidades de negocio.</p>
<br />
<table>
    <tr>
        <td>Nombre Unidad de Negocio:</td>
        <td><input type="text" id="nombre" name="nombre" /></td>
    </tr>
    <tr>
        <td>Elija el Logo:</td>
        <td>
            <input type="hidden" name="MAX_FILE_SIZE" value="60024" />
            <input name="imagen" type="file" />
        </td>
    </tr>
    <tr>
        <td colspan="2"><input type="submit" value="Crear Unidad de Negocio" /></td>
    </tr>
</table>
</form>';
?>