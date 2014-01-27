<?php
	//session_start();
	include('Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$npres=$_GET['seguimiento'];
	$stec=0;
	$stnt=0;
	$stes=0;
	$stpe=0;
	$conect=mysql_select_db($database_cnn,$cnn);
	$sqldg="SELECT presupuestos.IdPresupuesto, presupuestos.Presupuesto, presupuestos.Version,  presupuestos.IdCliente, presupuestos.IdProyecto, presupuestos.FechaPresentacion, presupuestos.Presentadopor, usuarios.Nombre, presupuestos.TipoCliente, presupuestos.FormaPago, presupuestos.SubEspectaculos, presupuestos.SubEventosCorp, presupuestos.SubNuevasTec, presupuestos.SubProduccion, presupuestos.Subtotal, presupuestos.Descuento, presupuestos.KnowHow, presupuestos.Total, presupuestos.Aprobabo FROM presupuestos INNER JOIN usuarios ON presupuestos.Presentadopor = usuarios.Usuario WHERE presupuestos.IdPresupuesto ='".$npres."'";
	$cltdg=mysql_query($sqldg,$cnn);
	$rsdg=mysql_fetch_assoc($cltdg);
    
    if (($_SESSION['usuario']==$rsdg['Presentadopor']) || ($_SESSION['perfil']=='Administrador')){
    
        echo '
        <div class="cuerpo">
                <form action="presupuestos/creapresup.php" method="post" id="formingreso">
            		<fieldset>
                    	<div class="menuheaders">
                		<div align="left"><h2>Datos <span>Generales</span></h2></div>
                        </div>
                        <ul class="menucontents">
                        <li>
        	          	<table>
                      	<tr>
        	              <td colspan="4">
                          </td>
                        </tr>
                        <tr>
                            <td><label>Fecha de Presentaci&oacute;n</label></td>
        	              <td><input id="fpresenta" type="text" READONLY id="fpresenta" name="fpresenta" value="'.ConvFecha($rsdg['FechaPresentacion']).'" title="MM/DD/YYYY" onClick="displayCalendar(this);"></td>
                        </tr>
        				<tr>
        	              <td><label> Cliente </label></td>
        	              <td>
                          	<select id="ncliente" name="ncliente" READONLY>';
                            
        					$sqlcliente="SELECT clientes.IdCliente, clientes.NombreCliente FROM clientes WHERE clientes.IdCliente =".$rsdg['IdCliente'];
        					$cltcliente=mysql_query($sqlcliente,$cnn);
        					$rscliente=mysql_fetch_assoc($cltcliente);
        					
        					echo '<option value="'.$rscliente['IdCliente'].'" selected>'.$rscliente['NombreCliente'].'</option>';
           					echo'</select>
                          </td>
        	              <td><label> Proyecto </label></td>
        	              <td>
        					<select id="pproy" name="pproy" READONLY>';
        					
        					$sqlproy="SELECT proyectos.IdProyecto, proyectos.NombreProyecto FROM proyectos WHERE proyectos.IdProyecto =".$rsdg['IdProyecto'];
        					$cltproy=mysql_query($sqlproy,$cnn);
        					$rsproy=mysql_fetch_assoc($cltproy);
        					
                            echo '<option value="'.$rsproy['IdProyecto'].'" selected>'.$rsproy['NombreProyecto'].'</option>';
           					echo '</select>
                          </td>
                        </tr>
                        </table>
                        </li>
                        </ul>
                        <div class="menuheaders">
                        <div align="left"><h2>Eventos <span>Corporativos</span></h2></div>
                        </div>
                        <ul class="menucontents">
                        <li>
                        <table id="eventmark" name="eventmark" >
                        <tr>
                        	<td colspan="5">
                            	<div align="center">EVENT MARKETING</div>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="2">
                            	<div align="center">OPCIONES</div>
                            </td>
                            <td>
                            	<div align="center">DESCRIPCI&Oacute;N</div>
                            </td>
                            <td>
                            	<div align="center">CANTIDAD</div>
                            </td>
                            <td>
                            	<div align="center">D&Iacute;AS</div>
                            </td>
                            <td>
                            	<div align="center">Vr. UNITARIO</div>
                            </td>
                            <td>
                            	<div align="center">Vr. TOTAL</div>
                            </td>
                        </tr>';
        				
        				$sqlem="SELECT pres_eventoscorporativos.IdPresupuesto, pres_eventoscorporativos.Tipo, pres_eventoscorporativos.Descripcion, pres_eventoscorporativos.Cantidad, pres_eventoscorporativos.Dias, pres_eventoscorporativos.VrUnitario, pres_eventoscorporativos.VrTotal FROM pres_eventoscorporativos WHERE pres_eventoscorporativos.IdPresupuesto =  '".$npres."' AND pres_eventoscorporativos.Tipo = 'Event Marketing'";
        				$cltem=mysql_query($sqlem,$cnn);
        				$flem=mysql_num_rows($cltem);
        				if($flem<=0){
        					echo'  
        		 		<tr>
                        	<input type="hidden" id="tteventmark" name="tteventmark" value=1 />
                        </tr>
        				<tbody>
                        <tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'eventmark\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'eventmark\', this), CalculaST()"/></td>
                        	<td><input type="text" id="emds1" name="emds1" size="50" /></td>
                            <td><input type="text" id="emcn1" name="emcn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'emcn1\', \'emdd1\', \'emvu1\', \'emvt1\')"/></td>
                            <td><input type="text" id="emdd1" name="emdd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'emcn1\', \'emdd1\', \'emvu1\', \'emvt1\')"/></td>
                            <td><input type="text" id="emvu1" name="emvu1" size="15" onblur="FormatoN(this)" onchange="CalculaTotal(\'emcn1\', \'emdd1\', \'emvu1\', \'emvt1\')"/></td>
                            <td><input type="text" id="emvt1" name="emvt1" size="15" value="0" READONLY /></td>
                        </tr>';	
        				}else{
        				echo '<tr>
                        	<input type="hidden" id="tteventmark" name="tteventmark" value="'.$flem.'" />
                        </tr>
                        <tbody>';
        					$i=1;
        					while($rsem=mysql_fetch_assoc($cltem)){
        						echo '
        						<tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'eventmark\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'eventmark\', this), CalculaST()"/></td>
                        	<td><input type="text" id="emds'.$i.'" name="emds'.$i.'" size="50" value="'.$rsem['Descripcion'].'"/></td>
                            <td><input type="text" id="emcn'.$i.'" name="emcn'.$i.'" size="15" value="'.$rsem['Cantidad'].'" onblur="CalculaST()" onchange="CalculaTotal(\'emcn'.$i.'\', \'emdd'.$i.'\', \'emvu'.$i.'\', \'emvt'.$i.'\')"/></td>
                            <td><input type="text" id="emdd'.$i.'" name="emdd'.$i.'" size="15" value="'.$rsem['Dias'].'" onblur="CalculaST()" onchange="CalculaTotal(\'emcn'.$i.'\', \'emdd'.$i.'\', \'emvu'.$i.'\', \'emvt'.$i.'\')"/></td>
                            <td><input type="text" id="emvu'.$i.'" name="emvu'.$i.'" size="15" value="'.aMoneda($rsem['VrUnitario']).'" onblur="FormatoN(this)" onchange="CalculaTotal(\'emcn'.$i.'\', \'emdd'.$i.'\', \'emvu'.$i.'\', \'emvt'.$i.'\')"/></td>
                            <td><input type="text" id="emvt'.$i.'" name="emvt'.$i.'" size="15" value="'.aMoneda($rsem['VrTotal']).'" READONLY /></td>
                        </tr>';
        					$stec+=$rsem['VrTotal'];
        					$i++;
        					}
        				}
                 echo'</tbody>
                       	</table> 
                        <table id="rentsupp" name="rentsupp" >
                        <tr>
                        	<td colspan="5">
                            	<div align="center">RENTAL & SUPPORT</div>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="2">
                            	<div align="center">OPCIONES</div>
                            </td>
                            <td>
                            	<div align="center">DESCRIPCI&Oacute;N</div>
                            </td>
                            <td>
                            	<div align="center">CANTIDAD</div>
                            </td>
                            <td>
                            	<div align="center">D&Iacute;AS</div>
                            </td>
                            <td>
                            	<div align="center">Vr. UNITARIO</div>
                            </td>
                            <td>
                            	<div align="center">Vr. TOTAL</div>
                            </td>
                        </tr>';
        				$sqlrs="SELECT pres_eventoscorporativos.IdPresupuesto, pres_eventoscorporativos.Tipo, pres_eventoscorporativos.Descripcion, pres_eventoscorporativos.Cantidad, pres_eventoscorporativos.Dias, pres_eventoscorporativos.VrUnitario, pres_eventoscorporativos.VrTotal FROM pres_eventoscorporativos WHERE pres_eventoscorporativos.IdPresupuesto =  '".$npres."' AND pres_eventoscorporativos.Tipo = 'Rental & Support'";
        				$cltrs=mysql_query($sqlrs,$cnn);
        				$flrs=mysql_num_rows($cltrs);
        				if($flrs<=0){
        					echo'<tr>
                        	<input type="hidden" id="ttrentsupp" name="ttrentsupp" value=1 />
                        </tr>
                        <tbody>
                        <tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'rentsupp\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'rentsupp\', this), CalculaST()"/></td>
                        	<td><input type="text" id="rsds1" name="rsds1" size="50" /></td>
                            <td><input type="text" id="rscn1" name="rscn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'rscn1\', \'rsdd1\', \'rsvu1\', \'rsvt1\')"/></td>
                            <td><input type="text" id="rsdd1" name="rsdd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'rscn1\', \'rsdd1\', \'rsvu1\', \'rsvt1\')"/></td>
                            <td><input type="text" id="rsvu1" name="rsvu1" size="15" onblur="CalculaST(), FormatoN(this)" onchange="CalculaTotal(\'rscn1\', \'rsdd1\', \'rsvu1\', \'rsvt1\')"/></td>
                            <td><input type="text" id="rsvt1" name="rsvt1" value="0" size="15" READONLY/></td>
                        </tr>';
        				}else{
        					echo '<tr>
                        	<input type="hidden" id="ttrentsupp" name="ttrentsupp" value="'.$flrs.'" />
                        </tr>
                        <tbody>';
        					$i=1;
        					while($rsrs=mysql_fetch_assoc($cltrs)){
        						echo '
        						<tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'rentsupp\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'rentsupp\', this), CalculaST()"/></td>
                        	<td><input type="text" id="rsds'.$i.'" name="rsds'.$i.'" size="50" value="'.$rsrs['Descripcion'].'"/></td>
                            <td><input type="text" id="rscn'.$i.'" name="rscn'.$i.'" size="15" value="'.$rsrs['Cantidad'].'" onblur="CalculaST()" onchange="CalculaTotal(\'rscn'.$i.'\', \'rsdd'.$i.'\', \'rsvu'.$i.'\', \'rsvt'.$i.'\')"/></td>
                            <td><input type="text" id="rsdd'.$i.'" name="rsdd'.$i.'" size="15" value="'.$rsrs['Dias'].'" onblur="CalculaST()" onchange="CalculaTotal(\'rscn'.$i.'\', \'rsdd'.$i.'\', \'rsvu'.$i.'\', \'rsvt'.$i.'\')"/></td>
                            <td><input type="text" id="rsvu'.$i.'" name="rsvu'.$i.'" size="15" value="'.aMoneda($rsrs['VrUnitario']).'" onblur="FormatoN(this)" onchange="CalculaTotal(\'rscn'.$i.'\', \'rsdd'.$i.'\', \'rsvu'.$i.'\', \'rsvt'.$i.'\')"/></td>
                            <td><input type="text" id="rsvt'.$i.'" name="rsvt'.$i.'" size="15" value="'.aMoneda($rsrs['VrTotal']).'" READONLY /></td>
                        </tr>';
        					$stec+=$rsrs['VrTotal'];
        					$i++;
        				}
        			}
        			echo'
        				</tbody>
                        </table>
                        <br  />
        				<br  />
                        <hr />
                        <div align="right">
                        <table>
                        <tr>
                            <td><b><label>SUBTOTAL EVENTOS CORPORATIVOS</label>&nbsp;&nbsp;</b></td>
                            <td><input type="text" id="stecvt1" name="stecvt1" value="'.aMoneda($stec).'" onfocus="CalculaST()" value="0" READONLY size="50"/></td>
                        </tr>
                        </table>
                        </div>
                        </li>
                        </ul>
                        <div class="menuheaders">
                        <div align="left"><h2>Nuevas <span>Tecnolog&iacute;as</span></h2></div>
                        </div>
                        <ul class="menucontents">
                        <li>
                        <table id="videohd3d" name="videohd3d">
                        <tr>
                        	<td colspan="5">
                            	<div align="center">VIDEO HD & 3D</div>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="2">
                            	<div align="center">OPCIONES</div>
                            </td>
                            <td>
                            	<div align="center">DESCRIPCI&Oacute;N</div>
                            </td>
                            <td>
                            	<div align="center">CANTIDAD</div>
                            </td>
                            <td>
                            	<div align="center">D&Iacute;AS</div>
                            </td>
                            <td>
                            	<div align="center">Vr. UNITARIO</div>
                            </td>
                            <td>
                            	<div align="center">Vr. TOTAL</div>
                            </td>
                        </tr>';
        				
        				$sqlvd="SELECT pres_nuevastecnologias.IdPresupuesto, pres_nuevastecnologias.Tipo, pres_nuevastecnologias.Descripcion, pres_nuevastecnologias.Cantidad, pres_nuevastecnologias.Dias, pres_nuevastecnologias.VrUnitario, pres_nuevastecnologias.VrTotal FROM pres_nuevastecnologias WHERE pres_nuevastecnologias.IdPresupuesto =  '".$npres."' AND pres_nuevastecnologias.Tipo = 'Video HD & 3D'";
        				$cltvd=mysql_query($sqlvd,$cnn);
        				$flvd=mysql_num_rows($cltvd);
        				if($flvd<=0){
        					echo'<tr>
                        	<input type="hidden" id="ttvideohd3d" name="ttvideohd3d" value=1 />
                        </tr>
                        <tbody>
                        <tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'videohd3d\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'videohd3d\', this), CalculaST()"/></td>
                        	<td><input type="text" id="vdds1" name="vdds1" size="50" /></td>
                            <td><input type="text" id="vdcn1" name="vdcn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'vdcn1\', \'vddd1\', \'vdvu1\', \'vdvt1\')"/></td>
                            <td><input type="text" id="vddd1" name="vddd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'vdcn1\', \'vddd1\', \'vdvu1\', \'vdvt1\')"/></td>
                            <td><input type="text" id="vdvu1" name="vdvu1" size="15" onblur="CalculaST(), FormatoN(this)" onchange="CalculaTotal(\'vdcn1\', \'vddd1\', \'vdvu1\', \'vdvt1\')"/></td>
                            <td><input type="text" id="vdvt1" name="vdvt1" value="0" size="15" READONLY/></td>
                        </tr>';
        				}else{
        					echo '<tr>
                        	<input type="hidden" id="ttvideohd3d" name="ttvideohd3d" value="'.$flvd.'" />
                        </tr>
                        <tbody>';
        					$i=1;
        					while($rsvd=mysql_fetch_assoc($cltvd)){
        						echo '
        						<tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'videohd3d\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'videohd3d\', this), CalculaST()"/></td>
                        	<td><input type="text" id="vdds'.$i.'" name="vdds'.$i.'" size="50" value="'.$rsvd['Descripcion'].'"/></td>
                            <td><input type="text" id="vdcn'.$i.'" name="vdcn'.$i.'" size="15" value="'.$rsvd['Cantidad'].'" onblur="CalculaST()" onchange="CalculaTotal(\'vdcn'.$i.'\', \'vddd'.$i.'\', \'vdvu'.$i.'\', \'vdvt'.$i.'\')"/></td>
                            <td><input type="text" id="vddd'.$i.'" name="vddd'.$i.'" size="15" value="'.$rsvd['Dias'].'" onblur="CalculaST()" onchange="CalculaTotal(\'vdcn'.$i.'\', \'vddd'.$i.'\', \'vdvu'.$i.'\', \'vdvt'.$i.'\')"/></td>
                            <td><input type="text" id="vdvu'.$i.'" name="vdvu'.$i.'" size="15" value="'.aMoneda($rsvd['VrUnitario']).'" onblur="FormatoN(this)" onchange="CalculaTotal(\'vdcn'.$i.'\', \'vddd'.$i.'\', \'vdvu'.$i.'\', \'vdvt'.$i.'\')"/></td>
                            <td><input type="text" id="vdvt'.$i.'" name="vdvt'.$i.'" size="15" value="'.aMoneda($rsvd['VrTotal']).'" READONLY /></td>
                        </tr>';
        					$stnt+=$rsvd['VrTotal'];
        					$i++;
        					}
        				}
                        echo'
                        </tbody>
                        </table>
                        <table id="keynote" name="keynote">
                        <tr>
                        	<td colspan="5">
                            	<div align="center">KEYNOTE</div>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="2">
                            	<div align="center">OPCIONES</div>
                            </td>
                            <td>
                            	<div align="center">DESCRIPCI&Oacute;N</div>
                            </td>
                            <td>
                            	<div align="center">CANTIDAD</div>
                            </td>
                            <td>
                            	<div align="center">D&Iacute;AS</div>
                            </td>
                            <td>
                            	<div align="center">Vr. UNITARIO</div>
                            </td>
                            <td>
                            	<div align="center">Vr. TOTAL</div>
                            </td>
                        </tr>';
        				
        				$sqlkn="SELECT pres_nuevastecnologias.IdPresupuesto, pres_nuevastecnologias.Tipo, pres_nuevastecnologias.Descripcion, pres_nuevastecnologias.Cantidad, pres_nuevastecnologias.Dias, pres_nuevastecnologias.VrUnitario, pres_nuevastecnologias.VrTotal FROM pres_nuevastecnologias WHERE pres_nuevastecnologias.IdPresupuesto =  '".$npres."' AND pres_nuevastecnologias.Tipo = 'Keynote'";
        				$cltkn=mysql_query($sqlkn,$cnn);
        				$flkn=mysql_num_rows($cltkn);
        				if($flkn<=0){
        					echo'<tr>
        					<input type="hidden" id="ttkeynote" name="ttkeynote" value=1 />
                        </tr>
                        <tbody>
                        <tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'keynote\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'keynote\', this), CalculaST()"/></td>
                        	<td><input type="text" id="knds1" name="knds1" size="50" /></td>
                            <td><input type="text" id="kncn1" name="kncn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'kncn1\', \'kndd1\', \'knvu1\', \'knvt1\')"/></td>
                            <td><input type="text" id="kndd1" name="kndd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'kncn1\', \'kndd1\', \'knvu1\', \'knvt1\')"/></td>
                            <td><input type="text" id="knvu1" name="knvu1" size="15" onblur="CalculaST(), FormatoN(this)" onchange="CalculaTotal(\'kncn1\', \'kndd1\', \'knvu1\', \'knvt1\')"/></td>
                            <td><input type="text" id="knvt1" name="knvt1" value="0" size="15" READONLY/></td>
                        </tr>';
        				}else{
        					echo '<tr>
                        	<input type="hidden" id="ttkeynote" name="ttkeynote" value="'.$flkn.'" />
                        </tr>
                        <tbody>';
        					$i=1;
        					while($rskn=mysql_fetch_assoc($cltkn)){
        						echo '
        						<tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'keynote\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'keynote\', this), CalculaST()"/></td>
                        	<td><input type="text" id="knds'.$i.'" name="knds'.$i.'" size="50" value="'.$rskn['Descripcion'].'"/></td>
                            <td><input type="text" id="kncn'.$i.'" name="kncn'.$i.'" size="15" value="'.$rskn['Cantidad'].'" onblur="CalculaST()" onchange="CalculaTotal(\'kncn'.$i.'\', \'kndd'.$i.'\', \'knvu'.$i.'\', \'knvt'.$i.'\')"/></td>
                            <td><input type="text" id="kndd'.$i.'" name="kndd'.$i.'" size="15" value="'.$rskn['Dias'].'" onblur="CalculaST()" onchange="CalculaTotal(\'kncn'.$i.'\', \'kndd'.$i.'\', \'knvu'.$i.'\', \'knvt'.$i.'\')"/></td>
                            <td><input type="text" id="knvu'.$i.'" name="knvu'.$i.'" size="15" value="'.aMoneda($rskn['VrUnitario']).'" onblur="FormatoN(this)" onchange="CalculaTotal(\'kncn'.$i.'\', \'kndd'.$i.'\', \'knvu'.$i.'\', \'knvt'.$i.'\')"/></td>
                            <td><input type="text" id="knvt'.$i.'" name="knvt'.$i.'" size="15" value="'.aMoneda($rskn['VrTotal']).'" READONLY /></td>
                        </tr>';
        					$stnt+=$rskn['VrTotal'];
        					$i++;
        					}
        				}
                        
                        echo'</tbody>
                        </table>
                        <table id="visualex" name="visualex">
                        <tr>
                        	<td colspan="5">
                            	<div align="center">VISSUAL EXPERIENCE</div>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="2">
                            	<div align="center">OPCIONES</div>
                            </td>
                            <td>
                            	<div align="center">DESCRIPCI&Oacute;N</div>
                            </td>
                            <td>
                            	<div align="center">CANTIDAD</div>
                            </td>
                            <td>
                            	<div align="center">D&Iacute;AS</div>
                            </td>
                            <td>
                            	<div align="center">Vr. UNITARIO</div>
                            </td>
                            <td>
                            	<div align="center">Vr. TOTAL</div>
                            </td>
                        </tr>
        				';
        				
        				$sqlve="SELECT pres_nuevastecnologias.IdPresupuesto, pres_nuevastecnologias.Tipo, pres_nuevastecnologias.Descripcion, pres_nuevastecnologias.Cantidad, pres_nuevastecnologias.Dias, pres_nuevastecnologias.VrUnitario, pres_nuevastecnologias.VrTotal FROM pres_nuevastecnologias WHERE pres_nuevastecnologias.IdPresupuesto =  '".$npres."' AND pres_nuevastecnologias.Tipo = 'Visual Experience'";
        				$cltve=mysql_query($sqlve,$cnn);
        				$flve=mysql_num_rows($cltve);
        				if($flve<=0){
        					echo'
                        <tr>
                        <input type="hidden" id="ttvisualex" name="ttvisualex" value=1 />
                        </tr>
                        <tbody>
                        <tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'visualex\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'visualex\', this), CalculaST()"/></td>
                        	<td><input type="text" id="veds1" name="veds1" size="50" /></td>
                            <td><input type="text" id="vecn1" name="vecn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'vecn1\', \'vedd1\', \'vevu1\', \'vevt1\')"/></td>
                            <td><input type="text" id="vedd1" name="vedd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'vecn1\', \'vedd1\', \'vevu1\', \'vevt1\')"/></td>
                            <td><input type="text" id="vevu1" name="vevu1" size="15" onblur="CalculaST(), FormatoN(this)" onchange="CalculaTotal(\'vecn1\', \'vedd1\', \'vevu1\', \'vevt1\')"/></td>
                            <td><input type="text" id="vevt1" name="vevt1" value="0" size="15" READONLY/></td>
                        </tr>';
        				}else{
        					echo '<tr>
                        	<input type="hidden" id="ttvisualex" name="ttvisualex" value="'.$flve.'" />
                        </tr>
                        <tbody>';
        					$i=1;
        					while($rsve=mysql_fetch_assoc($cltve)){
        						echo '
        						<tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'visualex\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'visualex\', this), CalculaST()"/></td>
                        	<td><input type="text" id="veds'.$i.'" name="veds'.$i.'" size="50" value="'.$rsve['Descripcion'].'"/></td>
                            <td><input type="text" id="vecn'.$i.'" name="vecn'.$i.'" size="15" value="'.$rsve['Cantidad'].'" onblur="CalculaST()" onchange="CalculaTotal(\'vecn'.$i.'\', \'vedd'.$i.'\', \'vevu'.$i.'\', \'vevt'.$i.'\')"/></td>
                            <td><input type="text" id="vedd'.$i.'" name="vedd'.$i.'" size="15" value="'.$rsve['Dias'].'" onblur="CalculaST()" onchange="CalculaTotal(\'vecn'.$i.'\', \'vedd'.$i.'\', \'vevu'.$i.'\', \'vevt'.$i.'\')"/></td>
                            <td><input type="text" id="vevu'.$i.'" name="vevu'.$i.'" size="15" value="'.aMoneda($rsve['VrUnitario']).'" onblur="FormatoN(this)" onchange="CalculaTotal(\'vecn'.$i.'\', \'vedd'.$i.'\', \'vevu'.$i.'\', \'vevt'.$i.'\')"/></td>
                            <td><input type="text" id="vevt'.$i.'" name="vevt'.$i.'" size="15" value="'.aMoneda($rsve['VrTotal']).'" READONLY /></td>
                        </tr>';
        					$stnt+=$rsve['VrTotal'];
        					$i++;
        					}
        				}
                        echo '</tbody>
                        </table>
                        <table id="branding" name="branding">
                        <tr>
                        	<td colspan="5">
                            	<div align="center">BRANDING INTERACTION</div>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="2">
                            	<div align="center">OPCIONES</div>
                            </td>
                            <td>
                            	<div align="center">DESCRIPCI&Oacute;N</div>
                            </td>
                            <td>
                            	<div align="center">CANTIDAD</div>
                            </td>
                            <td>
                            	<div align="center">D&Iacute;AS</div>
                            </td>
                            <td>
                            	<div align="center">Vr. UNITARIO</div>
                            </td>
                            <td>
                            	<div align="center">Vr. TOTAL</div>
                            </td>
                        </tr>';
        				
        				$sqlbi="SELECT pres_nuevastecnologias.IdPresupuesto, pres_nuevastecnologias.Tipo, pres_nuevastecnologias.Descripcion, pres_nuevastecnologias.Cantidad, pres_nuevastecnologias.Dias, pres_nuevastecnologias.VrUnitario, pres_nuevastecnologias.VrTotal FROM pres_nuevastecnologias WHERE pres_nuevastecnologias.IdPresupuesto =  '".$npres."' AND pres_nuevastecnologias.Tipo = 'Branding Integration'";
        				$cltbi=mysql_query($sqlbi,$cnn);
        				$flbi=mysql_num_rows($cltbi);
        				if($flbi<=0){
        					echo'<tr>
                        <input type="hidden" id="ttbranding" name="ttbranding" value=1 />
                        </tr>
                        <tbody>
                        <tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'branding\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'branding\', this), CalculaST()"/></td>
                        	<td><input type="text" id="bids1" name="bids1" size="50" /></td>
                            <td><input type="text" id="bicn1" name="bicn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'bicn1\', \'bidd1\', \'bivu1\', \'bivt1\')"/></td>
                            <td><input type="text" id="bidd1" name="bidd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'bicn1\', \'bidd1\', \'bivu1\', \'bivt1\')"/></td>
                            <td><input type="text" id="bivu1" name="bivu1" size="15" onblur="CalculaST(), FormatoN(this)" onchange="CalculaTotal(\'bicn1\', \'bidd1\', \'bivu1\', \'bivt1\')"/></td>
                            <td><input type="text" id="bivt1" name="bivt1" value="0" size="15" READONLY/></td>
                        </tr>';
        				}else{
        					echo '<tr>
                        	<input type="hidden" id="ttbranding" name="ttbranding" value="'.$flbi.'" />
                        </tr>
                        <tbody>';
        					$i=1;
        					while($rsbi=mysql_fetch_assoc($cltbi)){
        						echo '
        						<tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'branding\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'branding\', this), CalculaST()"/></td>
                        	<td><input type="text" id="bids'.$i.'" name="bids'.$i.'" size="50" value="'.$rsbi['Descripcion'].'"/></td>
                            <td><input type="text" id="bicn'.$i.'" name="bicn'.$i.'" size="15" value="'.$rsbi['Cantidad'].'" onblur="CalculaST()" onchange="CalculaTotal(\'bicn'.$i.'\', \'bidd'.$i.'\', \'bivu'.$i.'\', \'bivt'.$i.'\')"/></td>
                            <td><input type="text" id="bidd'.$i.'" name="bidd'.$i.'" size="15" value="'.$rsbi['Dias'].'" onblur="CalculaST()" onchange="CalculaTotal(\'bicn'.$i.'\', \'bidd'.$i.'\', \'bivu'.$i.'\', \'bivt'.$i.'\')"/></td>
                            <td><input type="text" id="bivu'.$i.'" name="bivu'.$i.'" size="15" value="'.aMoneda($rsbi['VrUnitario']).'" onblur="FormatoN(this)" onchange="CalculaTotal(\'bicn'.$i.'\', \'bidd'.$i.'\', \'bivu'.$i.'\', \'bivt'.$i.'\')"/></td>
                            <td><input type="text" id="bivt'.$i.'" name="bivt'.$i.'" size="15" value="'.aMoneda($rsbi['VrTotal']).'" READONLY /></td>
                        </tr>';
        					$stnt+=$rsbi['VrTotal'];
        					$i++;
        					}
        				}
        				echo '</tbody>
                        </table>
                        <br  />
        				<br  />
                        <hr />
                        <div align="right">
                        <table>
                        <tr>
                            <td><b><label>SUBTOTAL NUEVAS TECNOLOGIAS</label>&nbsp;&nbsp;</b></td>
                            <td><input type="text" id="stntvt2" name="stntvt2" value="'.aMoneda($stnt).'" READONLY size="50" /></td>
                        </tr>
                        </table>
                        </li>
                        </ul>
                        <div class="menuheaders">
                        <div align="left"><h2>Espe<span>ct&aacute;culos</span></h2></div>
                        </div>
                        <ul class="menucontents">
                        <li>
                        <table id="performance" name="performance">
                        <tr>
                        	<td colspan="5">
                            	<div align="center">PERFORMANCE</div>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="2">
                            	<div align="center">OPCIONES</div>
                            </td>
                            <td>
                            	<div align="center">DESCRIPCI&Oacute;N</div>
                            </td>
                            <td>
                            	<div align="center">CANTIDAD</div>
                            </td>
                            <td>
                            	<div align="center">D&Iacute;AS</div>
                            </td>
                            <td>
                            	<div align="center">Vr. UNITARIO</div>
                            </td>
                            <td>
                            	<div align="center">Vr. TOTAL</div>
                            </td>
                        </tr>';
        				
        				$sqlpf="SELECT pres_espectaculos.IdPresupuesto, pres_espectaculos.Tipo, pres_espectaculos.Descripcion, pres_espectaculos.Cantidad, pres_espectaculos.Dias, pres_espectaculos.VrUnitario, pres_espectaculos.VrTotal FROM pres_espectaculos WHERE pres_espectaculos.IdPresupuesto =  '".$npres."' AND pres_espectaculos.Tipo = 'Performance'";
        				$cltpf=mysql_query($sqlpf,$cnn);
        				$flpf=mysql_num_rows($cltpf);
        				if($flpf<=0){
        					echo'<tr>
                        	<input type="hidden" id="ttperformance" name="ttperformance" value=1 />
                        </tr>
                        <tbody>
                        <tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'performance\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'performance\', this), CalculaST()"/></td>
                        	<td><input type="text" id="pfds1" name="pfds1" size="50" /></td>
                            <td><input type="text" id="pfcn1" name="pfcn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'pfcn1\', \'pfdd1\', \'pfvu1\', \'pfvt1\')"/></td>
                            <td><input type="text" id="pfdd1" name="pfdd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'pfcn1\', \'pfdd1\', \'pfvu1\', \'pfvt1\')"/></td>
                            <td><input type="text" id="pfvu1" name="pfvu1" size="15" onblur="CalculaST(), FormatoN(this)" onchange="CalculaTotal(\'pfcn1\', \'pfdd1\', \'pfvu1\', \'pfvt1\')"/></td>
                            <td><input type="text" id="pfvt1" name="pfvt1" value="0" size="15" READONLY/></td>
                        </tr>';
        				}else{
        					echo '<tr>
                        	<input type="hidden" id="ttperformance" name="ttperformance" value="'.$flpf.'" />
                        </tr>
                        <tbody>';
        					$i=1;
        					while($rspf=mysql_fetch_assoc($cltpf)){
        						echo '
        						<tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'performance\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'performance\', this), CalculaST()"/></td>
                        	<td><input type="text" id="pfds'.$i.'" name="pfds'.$i.'" size="50" value="'.$rspf['Descripcion'].'"/></td>
                            <td><input type="text" id="pfcn'.$i.'" name="pfcn'.$i.'" size="15" value="'.$rspf['Cantidad'].'" onblur="CalculaST()" onchange="CalculaTotal(\'pfcn'.$i.'\', \'pfdd'.$i.'\', \'pfvu'.$i.'\', \'pfvt'.$i.'\')"/></td>
                            <td><input type="text" id="pfdd'.$i.'" name="pfdd'.$i.'" size="15" value="'.$rspf['Dias'].'" onblur="CalculaST()" onchange="CalculaTotal(\'pfcn'.$i.'\', \'pfdd'.$i.'\', \'pfvu'.$i.'\', \'pfvt'.$i.'\')"/></td>
                            <td><input type="text" id="pfvu'.$i.'" name="pfvu'.$i.'" size="15" value="'.aMoneda($rspf['VrUnitario']).'" onblur="FormatoN(this)" onchange="CalculaTotal(\'pfcn'.$i.'\', \'pfdd'.$i.'\', \'pfvu'.$i.'\', \'pfvt'.$i.'\')"/></td>
                            <td><input type="text" id="pfvt'.$i.'" name="pfvt'.$i.'" size="15" value="'.aMoneda($rspf['VrTotal']).'" READONLY /></td>
                        </tr>';
        					$stes+=$rspf['VrTotal'];
        					$i++;
        					}
        				}
        				
                        echo'</tbody>
                        </table>
                        <table id="management" name="management">
                        <tr>
                        	<td colspan="5">
                            	<div align="center">MANAGEMENT</div>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="2">
                            	<div align="center">OPCIONES</div>
                            </td>
                            <td>
                            	<div align="center">DESCRIPCI&Oacute;N</div>
                            </td>
                            <td>
                            	<div align="center">CANTIDAD</div>
                            </td>
                            <td>
                            	<div align="center">D&Iacute;AS</div>
                            </td>
                            <td>
                            	<div align="center">Vr. UNITARIO</div>
                            </td>
                            <td>
                            	<div align="center">Vr. TOTAL</div>
                            </td>
                        </tr>';
        				
        				$sqlmg="SELECT pres_espectaculos.IdPresupuesto, pres_espectaculos.Tipo, pres_espectaculos.Descripcion, pres_espectaculos.Cantidad, pres_espectaculos.Dias, pres_espectaculos.VrUnitario, pres_espectaculos.VrTotal FROM pres_espectaculos WHERE pres_espectaculos.IdPresupuesto =  '".$npres."' AND pres_espectaculos.Tipo = 'Management'";
        				$cltmg=mysql_query($sqlmg,$cnn);
        				$flmg=mysql_num_rows($cltmg);
        				if($flmg<=0){
        					echo'<tr>
                        	<input type="hidden" id="ttmanagement" name="ttmanagement" value=1 />
                        </tr>
                        <tbody>
                        <tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'management\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'management\', this), CalculaST()"/></td>
                        	<td><input type="text" id="mgds1" name="mgds1" size="50" /></td>
                            <td><input type="text" id="mgcn1" name="mgcn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'mgcn1\', \'mgdd1\', \'mgvu1\', \'mgvt1\')"/></td>
                            <td><input type="text" id="mgdd1" name="mgdd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'mgcn1\', \'mgdd1\', \'mgvu1\', \'mgvt1\')"/></td>
                            <td><input type="text" id="mgvu1" name="mgvu1" size="15" onblur="CalculaST(), FormatoN(this)" onchange="CalculaTotal(\'mgcn1\', \'mgdd1\', \'mgvu1\', \'mgvt1\')"/></td>
                            <td><input type="text" id="mgvt1" name="mgvt1" value="0" size="15" READONLY/></td>
                        </tr>';
        				}else{
        					echo '<tr>
                        	<input type="hidden" id="ttmanagement" name="ttmanagement" value="'.$flmg.'" />
                        </tr>
                        <tbody>';
        					$i=1;
        					while($rsmg=mysql_fetch_assoc($cltmg)){
        						echo '
        						<tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'management\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'management\', this), CalculaST()"/></td>
                        	<td><input type="text" id="mgds'.$i.'" name="mgds'.$i.'" size="50" value="'.$rsmg['Descripcion'].'"/></td>
                            <td><input type="text" id="mgcn'.$i.'" name="mgcn'.$i.'" size="15" value="'.$rsmg['Cantidad'].'" onblur="CalculaST()" onchange="CalculaTotal(\'mgcn'.$i.'\', \'mgdd'.$i.'\', \'mgvu'.$i.'\', \'mgvt'.$i.'\')"/></td>
                            <td><input type="text" id="mgdd'.$i.'" name="mgdd'.$i.'" size="15" value="'.$rsmg['Dias'].'" onblur="CalculaST()" onchange="CalculaTotal(\'mgcn'.$i.'\', \'mgdd'.$i.'\', \'mgvu'.$i.'\', \'mgvt'.$i.'\')"/></td>
                            <td><input type="text" id="mgvu'.$i.'" name="mgvu'.$i.'" size="15" value="'.aMoneda($rsmg['VrUnitario']).'" onblur="FormatoN(this)" onchange="CalculaTotal(\'mgcn'.$i.'\', \'mgdd'.$i.'\', \'mgvu'.$i.'\', \'mgvt'.$i.'\')"/></td>
                            <td><input type="text" id="mgvt'.$i.'" name="mgvt'.$i.'" size="15" value="'.aMoneda($rsmg['VrTotal']).'" READONLY /></td>
                        </tr>';
        					$stes+=$rsmg['VrTotal'];
        					$i++;
        					}
        				}
                        echo'</tbody>
                        </table>
                        
                        <table id="own" name="own">
                        <tr>
                        	<td colspan="5">
                            	<div align="center">OWN SHOWS</div>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="2">
                            	<div align="center">OPCIONES</div>
                            </td>
                            <td>
                            	<div align="center">DESCRIPCI&Oacute;N</div>
                            </td>
                            <td>
                            	<div align="center">CANTIDAD</div>
                            </td>
                            <td>
                            	<div align="center">D&Iacute;AS</div>
                            </td>
                            <td>
                            	<div align="center">Vr. UNITARIO</div>
                            </td>
                            <td>
                            	<div align="center">Vr. TOTAL</div>
                            </td>
                        </tr>';
        				
        				$sqlos="SELECT pres_espectaculos.IdPresupuesto, pres_espectaculos.Tipo, pres_espectaculos.Descripcion, pres_espectaculos.Cantidad, pres_espectaculos.Dias, pres_espectaculos.VrUnitario, pres_espectaculos.VrTotal FROM pres_espectaculos WHERE pres_espectaculos.IdPresupuesto =  '".$npres."' AND pres_espectaculos.Tipo = 'Own Shows'";
        				$cltos=mysql_query($sqlos,$cnn);
        				$flos=mysql_num_rows($cltos);
        				if($flos<=0){
        					echo'<tr>
                        <input type="hidden" id="ttown" name="ttown" value=1 />
                        </tr>
                        <tbody>
                        <tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'own\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'own\', this), CalculaST()"/></td>
                        	<td><input type="text" id="osds1" name="osds1" size="50" /></td>
                            <td><input type="text" id="oscn1" name="oscn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'oscn1\', \'osdd1\', \'osvu1\', \'osvt1\')"/></td>
                            <td><input type="text" id="osdd1" name="osdd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'oscn1\', \'osdd1\', \'osvu1\', \'osvt1\')"/></td>
                            <td><input type="text" id="osvu1" name="osvu1" size="15" onblur="CalculaST(), FormatoN(this)" onchange="CalculaTotal(\'oscn1\', \'osdd1\', \'osvu1\', \'osvt1\')"/></td>
                            <td><input type="text" id="osvt1" name="osvt1" value="0" size="15" READONLY/></td>
                        </tr>';
        				}else{
        					echo '<tr>
                        	<input type="hidden" id="ttown" name="ttown" value="'.$flos.'" />
                        </tr>
                        <tbody>';
        					$i=1;
        					while($rsos=mysql_fetch_assoc($cltos)){
        						echo '
        						<tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'own\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'own\', this), CalculaST()"/></td>
                        	<td><input type="text" id="osds'.$i.'" name="osds'.$i.'" size="50" value="'.$rsos['Descripcion'].'"/></td>
                            <td><input type="text" id="oscn'.$i.'" name="oscn'.$i.'" size="15" value="'.$rsos['Cantidad'].'" onblur="CalculaST()" onchange="CalculaTotal(\'oscn'.$i.'\', \'osdd'.$i.'\', \'osvu'.$i.'\', \'osvt'.$i.'\')"/></td>
                            <td><input type="text" id="osdd'.$i.'" name="osdd'.$i.'" size="15" value="'.$rsos['Dias'].'" onblur="CalculaST()" onchange="CalculaTotal(\'oscn'.$i.'\', \'osdd'.$i.'\', \'osvu'.$i.'\', \'osvt'.$i.'\')"/></td>
                            <td><input type="text" id="osvu'.$i.'" name="osvu'.$i.'" size="15" value="'.aMoneda($rsos['VrUnitario']).'" onblur="FormatoN(this)" onchange="CalculaTotal(\'oscn'.$i.'\', \'osdd'.$i.'\', \'osvu'.$i.'\', \'osvt'.$i.'\')"/></td>
                            <td><input type="text" id="osvt'.$i.'" name="osvt'.$i.'" size="15" value="'.aMoneda($rsos['VrTotal']).'" READONLY /></td>
                        </tr>';
        					$stes+=$rsos['VrTotal'];
        					$i++;
        					}
        				}
                        echo'</tbody>
                        </table>
                        <br  />
        				<br  />
                        <hr />
                        <div align="right">
                        <table>
                        <tr>
                            <td><b><label>SUBTOTAL ESPECTACULOS</label>&nbsp;&nbsp;</b></td>
                            <td><input type="text" id="stesvt3" name="stesvt3" value="'.aMoneda($stes).'" READONLY size="50" /></td>
                        </tr>
                        </table>
                        </li>
                        </ul>
                        </li>
                        </ul>
                        <div class="menuheaders">
                        <div align="left"><h2>Producci&oacute;n Ejecutiva y <span>de Campo</span></h2></div>
                        </div>
                        <ul class="menucontents">
                        <li>
                        <table id="produccion" name="produccion">
                        <tr>
                        	<td colspan="5">
                            	<div align="center">PRODUCCI&Oacute;N EJECUTIVA Y DE CAMPO</div>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="2">
                            	<div align="center">OPCIONES</div>
                            </td>
                            <td>
                            	<div align="center">DESCRIPCI&Oacute;N</div>
                            </td>
                            <td>
                            	<div align="center">CANTIDAD</div>
                            </td>
                            <td>
                            	<div align="center">D&Iacute;AS</div>
                            </td>
                            <td>
                            	<div align="center">Vr. UNITARIO</div>
                            </td>
                            <td>
                            	<div align="center">Vr. TOTAL</div>
                            </td>
                        </tr>';
        				
        				$sqlpe="SELECT pres_prodejecutivaycampo.IdPresupuesto, pres_prodejecutivaycampo.Tipo, pres_prodejecutivaycampo.Descripcion, pres_prodejecutivaycampo.Cantidad, pres_prodejecutivaycampo.Dias, pres_prodejecutivaycampo.VrUnitario, pres_prodejecutivaycampo.VrTotal FROM pres_prodejecutivaycampo WHERE pres_prodejecutivaycampo.IdPresupuesto =  '".$npres."' AND pres_prodejecutivaycampo.Tipo = 'Produccion Ejecutiva y de Campo'";
        				$cltpe=mysql_query($sqlpe,$cnn);
        				$flpe=mysql_num_rows($cltpe);
        				if($flpe<=0){
        					echo'<tr>
                        <input type="hidden" id="ttproduccion" name="ttproduccion" value=1 />
                        </tr>
                        <tbody>
                        <tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'produccion\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'produccion\', this), CalculaST()"/></td>
                        	<td><input type="text" id="peds1" name="peds1" size="50" /></td>
                            <td><input type="text" id="pecn1" name="pecn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'pecn1\', \'pedd1\', \'pevu1\', \'pevt1\')"/></td>
                            <td><input type="text" id="pedd1" name="pedd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'pecn1\', \'pedd1\', \'pevu1\', \'pevt1\')"/></td>
                            <td><input type="text" id="pevu1" name="pevu1" size="15" onblur="CalculaST(), FormatoN(this)" onchange="CalculaTotal(\'pecn1\', \'pedd1\', \'pevu1\', \'pevt1\')"/></td>
                            <td><input type="text" id="pevt1" name="pevt1" value="0" size="15" READONLY/></td>
                        </tr>';
        				}else{
        					echo '<tr>
                        	<input type="hidden" id="ttproduccion" name="ttproduccion" value="'.$flpe.'" />
                        </tr>
                        <tbody>';
        					$i=1;
        					while($rspe=mysql_fetch_assoc($cltpe)){
        						echo '
        						<tr>
                        	<td><img src="images/mas.png" onclick="NuevaFila(\'produccion\')"/></td>
                            <td><img src="images/menos.png" onclick="EliminaFila(\'produccion\', this), CalculaST()"/></td>
                        	<td><input type="text" id="peds'.$i.'" name="peds'.$i.'" size="50" value="'.$rspe['Descripcion'].'"/></td>
                            <td><input type="text" id="pecn'.$i.'" name="pecn'.$i.'" size="15" value="'.$rspe['Cantidad'].'" onblur="CalculaST()" onchange="CalculaTotal(\'pecn'.$i.'\', \'pedd'.$i.'\', \'pevu'.$i.'\', \'pevt'.$i.'\')"/></td>
                            <td><input type="text" id="pedd'.$i.'" name="pedd'.$i.'" size="15" value="'.$rspe['Dias'].'" onblur="CalculaST()" onchange="CalculaTotal(\'pecn'.$i.'\', \'pedd'.$i.'\', \'pevu'.$i.'\', \'pevt'.$i.'\')"/></td>
                            <td><input type="text" id="pevu'.$i.'" name="pevu'.$i.'" size="15" value="'.aMoneda($rspe['VrUnitario']).'" onblur="FormatoN(this)" onchange="CalculaTotal(\'pecn'.$i.'\', \'pedd'.$i.'\', \'pevu'.$i.'\', \'pevt'.$i.'\')"/></td>
                            <td><input type="text" id="pevt'.$i.'" name="pevt'.$i.'" size="15" value="'.aMoneda($rspe['VrTotal']).'" READONLY /></td>
                        </tr>';
        					$stpe+=$rspe['VrTotal'];
        					$i++;
        					}
        				}
        				
                        echo'</tbody>
                        </table>
                        <br  />
        				<br  />
                        <hr />
                        <div align="right">
                        <table>
                        <tr>
                            <td><b><label>SUBTOTAL PRODUCCION EJECUTIVA Y DE CAMPO</label>&nbsp;&nbsp;</b></td>
                            <td><input type="text" id="stpevt4" name="stpevt4" value="'.aMoneda($stpe).'" READONLY size="50" /></td>
                        </tr>
                        </table>
                        </li>
                        </ul>
                        <table>
                        <tr>
                            <td><label>SUBTOTAL PROYECTO</label></td>
                            <td><input type="text" id="stp" name="stp" value="0" READONLY onfocus="CalculaST(), TT(this, \'stecvt1\',\'stntvt2\',\'stesvt3\',\'stpevt4\')"/></td>
                            <td><img src="images/fleft.png" width="15" height="15" onclick="CalculaST(), TT(\'stp\', \'stecvt1\',\'stntvt2\',\'stesvt3\',\'stpevt4\')"/></td>
                        </tr>
                        <tr>
                            <td><label>DESCUENTO ESPECIAL</label></td>
                            <td><input type="text" id="dse" name="dse" value="0" onchange="FormatoN(this)" onblur="TT(\'stds\', \'stp\',\'dse\',\'knh\')" /></td>
                        </tr>
                        <tr>
                            <td><label>KNOW HOW</label></td>
                            <td><input type="text" id="knh" name="knh" value="0" onchange="FormatoN(this)" onblur="TT(\'stds\', \'stp\',\'dse\',\'knh\')" /></td>
                        </tr>
                        <tr>
                            <td><label>TOTAL CON DCTO.</label></td>
                            <td><input type="text" id="stds" name="stds" value="0" READONLY onfocus="TG(\'stds\', \'stp\',\'dse\',\'knh\')" onblur="TG(\'stds\', \'stp\',\'dse\',\'knh\')"/></td>
                            <td><img src="images/fleft.png" width="15" height="15" onclick="TG(\'stds\', \'stp\',\'dse\',\'knh\')"/></td>
                        </table>
                        <br  />
                       	<div align="left">
                        	<input type=button onclick="CalculaST(), TT(\'stp\',\'stecvt1\',\'stntvt2\',\'stesvt3\',\'stpevt4\'), TG(\'stds\', \'stp\',\'dse\',\'knh\'), validarform(\'formingreso\', \'presupuesto\')" name="enviar" value="Generar Nuevo Presupuesto Modificado">
                        </div>
                        <br  />
                        <div align="left">
                        <table>
                        <tr>
                        	<td colspan="6">
                            	</br>
                            	<div align="center">
                                ** A esta Cotizaci&oacute;n hay que sumarle el 16% de IVA **
                               	</div>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="6">
                            	<div align="center">NOTA:</div>
                                <div align="center">&nbsp;</div>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="6">
                            	<div align="left">
                                	<div>1. Antes de iniciar cualquier proyecto, es indispensable la orden de producción o el documento que se asemeje.</div>
                                   	<div>2. Entretenimiento sin Limites ltda, hará para cada proyecto aprobado un contrato comercial, el cual ira firmado por las compañías.</div>
                                    <div>3. los valores establecidos en el presente presupuesto pueden variar si las condiciones aquí plasmadas cambian.</div>
                                    <div>4. Entretenimiento sin Limites ltda, no  asume ningún ítem aquí no especificado.</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="6">
                            	<div align="center">&nbsp;</div>
                            	<div align="center">
                                	ILLUSION  es una marca de ENTRETENIMIENTO SIN LIMITES LTDA NIT. 900080749-6
                                </div>
                            </td>
                        </tr>
                      </table>
                      </div>
        			</fieldset>
        	    <form>
        </div>';
        
    }else{
        echo'
        <div class="cuerpo">
        	<h3>Presupuesto <span>Deshabilitado</span></h3>
        	<p>El presupuesto &uacute;nicamente puede ser modificado por su creador o por un administrador.</p>
        	<p class="p0">Si Desea realizar Modificaciones a este presupuesto, por favor consulte con el comercial responsable del mismo o un administrador</p>
        </div>';
    }
}
?>