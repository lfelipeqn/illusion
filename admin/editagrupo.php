<?php
$idgrupo=$_GET['grupo'];
echo '<form action="edgrupo.php" method="post" id="formgrupo" name="formgrupo">
    <table>
        <thead>
            <tr>
                <th colspan="2">Nuevo Nombre del Grupo:</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input type="hidden" value="'.$idgrupo.'" name="idgrupo"/>
                    <input type="text" value="" id="nombregrupo" name="nombregrupo"/>
                </td>
                <td><input type="submit" value="Actualiza Nombre de Grupo" style="width:150px"/></td>
            </tr>
        </tbody>
    </table>
</form>';
?>