function NuevaFila(tabla) {

	var tbl = document.getElementById(tabla);

	var lastRow = tbl.rows.length;

	var iteration = lastRow;

	var row = tbl.insertRow(lastRow);

	var tot='tt'+tbl.id

	iteration-=3

	iteration++

	for (var i=0; i<7;i++){

		var cell = row.insertCell(i);

		if (i==0){

			var el = document.createElement('img')

			el.src='images/mas.png'

			el.setAttribute('onclick','NuevaFila("'+ tbl.id +'")')

		}else if(i==1){

			var el = document.createElement('img')

			el.src='images/menos.png'

			el.setAttribute('onclick','EliminaFila("'+ tbl.id +'", this), CalculaST()')

		}else{

			var el = document.createElement('input');

			el.type = 'text';

			switch(i){

				case 2:

					el.name = NCampo(tabla) + 'ds' + iteration;

					el.id = NCampo(tabla) + 'ds' + iteration;

					el.size=50

					el.setAttribute('onchange', 'CalculaTotal("' + NCampo(tabla) + 'cn' + iteration + '", "' + NCampo(tabla) + 'dd' + iteration + '", "' + NCampo(tabla) + 'vu' + iteration + '", "' + NCampo(tabla) + 'vt' + iteration + '")')

					break

				case 3:

					el.name = NCampo(tabla) + 'cn' + iteration;

					el.id = NCampo(tabla) + 'cn' + iteration;

					el.size=15

					el.setAttribute('onblur','CalculaST()')

					el.setAttribute('onchange', 'CalculaTotal("' + NCampo(tabla) + 'cn' + iteration + '", "' + NCampo(tabla) + 'dd' + iteration + '", "' + NCampo(tabla) + 'vu' + iteration + '", "' + NCampo(tabla) + 'vt' + iteration + '")')

					break

				case 4:

					el.name = NCampo(tabla) +'dd' + iteration;

					el.id = NCampo(tabla) +'dd' + iteration;

					el.size=15

					el.setAttribute('onblur','CalculaST()')

					el.setAttribute('onchange', 'CalculaTotal("' + NCampo(tabla) + 'cn' + iteration + '", "' + NCampo(tabla) + 'dd' + iteration + '", "' + NCampo(tabla) + 'vu' + iteration + '", "' + NCampo(tabla) + 'vt' + iteration + '")')

					break

				case 5:

					el.name = NCampo(tabla) + 'vu' + iteration;

					el.id = NCampo(tabla) + 'vu' + iteration;

					el.size=15

					el.value=0

					el.setAttribute('onblur', 'FormatoN(this), CalculaST()')

					el.setAttribute('onchange', 'CalculaTotal("' + NCampo(tabla) + 'cn' + iteration + '", "' + NCampo(tabla) + 'dd' + iteration + '", "' + NCampo(tabla) + 'vu' + iteration + '", "' + NCampo(tabla) + 'vt' + iteration + '")')

					break

				case 6:

					el.name = NCampo(tabla) + 'vt' + iteration;

					el.id = NCampo(tabla) + 'vt' + iteration;

					el.value=0

					el.size=15

					el.readOnly=true

					break

			}

		}

		cell.appendChild(el);

	}

	document.getElementById(tot).value=iteration

}





function EliminaFila(tabla,control){

	var tbl = document.getElementById(tabla);

	var lastRow = tbl.rows.length;

	var tot='tt'+tbl.id

	if (lastRow <= 4){

		alert('No Puede Eliminar Esta Fila, Es la Última disponible')

	}else{

		document.getElementById(tot).value-=1

		while ( (control = control.parentNode)  && control.tagName !="TR");

         	control.parentNode.removeChild(control);

		TipoElimina(tbl.id)

	}

}



function SinNumero(cad){

	var resultado=''

	if(cad.length>=1){

		for (var i=0;i<cad.length;i++){

			if ((cad.substr(i,1)!=0) && (cad.substr(i,1)!=1) && (cad.substr(i,1)!=2) && (cad.substr(i,1)!=3) && (cad.substr(i,1)!=4) && (cad.substr(i,1)!=5) && (cad.substr(i,1)!=6) && (cad.substr(i,1)!=7) && (cad.substr(i,1)!=8) && (cad.substr(i,1)!=9)) resultado+=cad.substr(i,1)

		}

	}

	return resultado

}



/*function EliminaFila(tabla){

	var tbl = document.getElementById(tabla);

	var lastRow = tbl.rows.length;

	var tot='tt'+tbl.id

	if (lastRow <= 4){

		alert('No Puede Eliminar Esta Fila, Es la Última disponible')

	}else{

		document.getElementById(tot).value-=1

		var current = window.event.srcElement;

		while ( (current = current.parentElement)  && current.tagName !="TR");

         	current.parentElement.removeChild(current);

		TipoElimina(tbl.id)

	}

}*/





function TipoElimina(tabla){

	campos = document.getElementsByTagName("input");

	var banderaem=false

	var cnem=1

	var banderars=false

	var cnrs=1

	var banderavd=false

	var cnvd=1

	var banderakn=false

	var cnkn=1

	var banderave=false

	var cnve=1

	var banderabi=false

	var cnbi=1

	var banderapf=false

	var cnpf=1

	var banderamg=false

	var cnmg=1

	var banderaos=false

	var cnos=1

	var banderape=false

	var cnpe=1

	

	var banderatt=false

	var cntt=1

	var banderaim=false

	var cnim=1

	var banderapr=false

	var cnpr=1

	var banderaec=false

	var cnec=1

	var banderant=false

	var cnnt=1

	var banderaes=false

	var cnes=1



    for (var i = 0; i < campos.length; i++){

		var nombre=campos[i].id

		var tipo = nombre.substr(0,2)

		var cels= nombre.substr(2,2)

		

		if(tipo=='em'){

				switch(cels){

					case 'ds':

						banderaem=false

						campos[i].id=tipo+cels+cnem

						campos[i].name=tipo+cels+cnem

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnem + '", "' + tipo + 'dd' + cnem + '", "' + tipo + 'vu' + cnem + '", "' + tipo + 'vt' + cnem + '")')

						break

					case 'cn':

						campos[i].id=tipo+cels+cnem

						campos[i].name=tipo+cels+cnem

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnem + '", "' + tipo + 'dd' + cnem + '", "' + tipo + 'vu' + cnem + '", "' + tipo + 'vt' + cnem + '")')

						break

					case 'dd':

						campos[i].id=tipo+cels+cnem

						campos[i].name=tipo+cels+cnem

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnem + '", "' + tipo + 'dd' + cnem + '", "' + tipo + 'vu' + cnem + '", "' + tipo + 'vt' + cnem + '")')

						break

					case 'vu':

						campos[i].id=tipo+cels+cnem

						campos[i].name=tipo+cels+cnem

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnem + '", "' + tipo + 'dd' + cnem + '", "' + tipo + 'vu' + cnem + '", "' + tipo + 'vt' + cnem + '")')

						break

					case 'vt':

						campos[i].id=tipo+cels+cnem

						campos[i].name=tipo+cels+cnem

						banderaem=true

						break

				}

		}

		if (banderaem) cnem+=1

		if (tipo=='rs'){

			switch(cels){

					case 'ds':

						banderars=false

						campos[i].id=tipo+cels+cnrs

						campos[i].name=tipo+cels+cnrs

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnrs + '", "' + tipo + 'dd' + cnrs + '", "' + tipo + 'vu' + cnrs + '", "' + tipo + 'vt' + cnrs + '")')

						break

					case 'cn':

						campos[i].id=tipo+cels+cnrs

						campos[i].name=tipo+cels+cnrs

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnrs + '", "' + tipo + 'dd' + cnrs + '", "' + tipo + 'vu' + cnrs + '", "' + tipo + 'vt' + cnrs + '")')

						break

					case 'dd':

						campos[i].id=tipo+cels+cnrs

						campos[i].name=tipo+cels+cnrs

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnrs + '", "' + tipo + 'dd' + cnrs + '", "' + tipo + 'vu' + cnrs + '", "' + tipo + 'vt' + cnrs + '")')

						break

					case 'vu':

						campos[i].id=tipo+cels+cnrs

						campos[i].name=tipo+cels+cnrs

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnrs + '", "' + tipo + 'dd' + cnrs + '", "' + tipo + 'vu' + cnrs + '", "' + tipo + 'vt' + cnrs + '")')

						break

					case 'vt':

						campos[i].id=tipo+cels+cnrs

						campos[i].name=tipo+cels+cnrs

						banderars=true

						break

				}

		}

		if (banderars) cnrs+=1

		if (tipo=='vd'){

			switch(cels){

					case 'ds':

						banderavd=false

						campos[i].id=tipo+cels+cnvd

						campos[i].name=tipo+cels+cnvd

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnvd + '", "' + tipo + 'dd' + cnvd + '", "' + tipo + 'vu' + cnvd + '", "' + tipo + 'vt' + cnvd + '")')

						break

					case 'cn':

						campos[i].id=tipo+cels+cnvd

						campos[i].name=tipo+cels+cnvd

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnvd + '", "' + tipo + 'dd' + cnvd + '", "' + tipo + 'vu' + cnvd + '", "' + tipo + 'vt' + cnvd + '")')

						break

					case 'dd':

						campos[i].id=tipo+cels+cnvd

						campos[i].name=tipo+cels+cnvd

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnvd + '", "' + tipo + 'dd' + cnvd + '", "' + tipo + 'vu' + cnvd + '", "' + tipo + 'vt' + cnvd + '")')

						break

					case 'vu':

						campos[i].id=tipo+cels+cnvd

						campos[i].name=tipo+cels+cnvd

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnvd + '", "' + tipo + 'dd' + cnvd + '", "' + tipo + 'vu' + cnvd + '", "' + tipo + 'vt' + cnvd + '")')

						break

					case 'vt':

						campos[i].id=tipo+cels+cnvd

						campos[i].name=tipo+cels+cnvd

						banderavd=true

						break

				}

		}

		if (banderavd) cnvd+=1

		if (tipo=='kn'){

			switch(cels){

					case 'ds':

						banderakn=false

						campos[i].id=tipo+cels+cnkn

						campos[i].name=tipo+cels+cnkn

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnkn + '", "' + tipo + 'dd' + cnkn + '", "' + tipo + 'vu' + cnkn + '", "' + tipo + 'vt' + cnkn + '")')

						break

					case 'cn':

						campos[i].id=tipo+cels+cnkn

						campos[i].name=tipo+cels+cnkn

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnkn + '", "' + tipo + 'dd' + cnkn + '", "' + tipo + 'vu' + cnkn + '", "' + tipo + 'vt' + cnkn + '")')

						break

					case 'dd':

						campos[i].id=tipo+cels+cnkn

						campos[i].name=tipo+cels+cnkn

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnkn + '", "' + tipo + 'dd' + cnkn + '", "' + tipo + 'vu' + cnkn + '", "' + tipo + 'vt' + cnkn + '")')

						break

					case 'vu':

						campos[i].id=tipo+cels+cnkn

						campos[i].name=tipo+cels+cnkn

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnkn + '", "' + tipo + 'dd' + cnkn + '", "' + tipo + 'vu' + cnkn + '", "' + tipo + 'vt' + cnkn + '")')

						break

					case 'vt':

						campos[i].id=tipo+cels+cnkn

						campos[i].name=tipo+cels+cnkn

						banderakn=true

						break

				}

		}

		if (banderakn) cnkn+=1

		if (tipo=='ve'){

			switch(cels){

					case 'ds':

						banderave=false

						campos[i].id=tipo+cels+cnve

						campos[i].name=tipo+cels+cnve

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnve + '", "' + tipo + 'dd' + cnve + '", "' + tipo + 'vu' + cnve + '", "' + tipo + 'vt' + cnve + '")')

						break

					case 'cn':

						campos[i].id=tipo+cels+cnve

						campos[i].name=tipo+cels+cnve

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnve + '", "' + tipo + 'dd' + cnve + '", "' + tipo + 'vu' + cnve + '", "' + tipo + 'vt' + cnve + '")')

						break

					case 'dd':

						campos[i].id=tipo+cels+cnve

						campos[i].name=tipo+cels+cnve

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnve + '", "' + tipo + 'dd' + cnve + '", "' + tipo + 'vu' + cnve + '", "' + tipo + 'vt' + cnve + '")')

						break

					case 'vu':

						campos[i].id=tipo+cels+cnve

						campos[i].name=tipo+cels+cnve

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnve + '", "' + tipo + 'dd' + cnve + '", "' + tipo + 'vu' + cnve + '", "' + tipo + 'vt' + cnve + '")')

						break

					case 'vt':

						campos[i].id=tipo+cels+cnve

						campos[i].name=tipo+cels+cnve

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnve + '", "' + tipo + 'dd' + cnve + '", "' + tipo + 'vu' + cnve + '", "' + tipo + 'vt' + cnve + '")')

						banderave=true

						break

				}

		}

		if (banderave) cnve+=1

		if (tipo=='bi'){

			switch(cels){

					case 'ds':

						banderabi=false

						campos[i].id=tipo+cels+cnbi

						campos[i].name=tipo+cels+cnbi

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnbi + '", "' + tipo + 'dd' + cnbi + '", "' + tipo + 'vu' + cnbi + '", "' + tipo + 'vt' + cnbi + '")')

						break

					case 'cn':

						campos[i].id=tipo+cels+cnbi

						campos[i].name=tipo+cels+cnbi

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnbi + '", "' + tipo + 'dd' + cnbi + '", "' + tipo + 'vu' + cnbi + '", "' + tipo + 'vt' + cnbi + '")')

						break

					case 'dd':

						campos[i].id=tipo+cels+cnbi

						campos[i].name=tipo+cels+cnbi

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnbi + '", "' + tipo + 'dd' + cnbi + '", "' + tipo + 'vu' + cnbi + '", "' + tipo + 'vt' + cnbi + '")')

						break

					case 'vu':

						campos[i].id=tipo+cels+cnbi

						campos[i].name=tipo+cels+cnbi

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnbi + '", "' + tipo + 'dd' + cnbi + '", "' + tipo + 'vu' + cnbi + '", "' + tipo + 'vt' + cnbi + '")')

						break

					case 'vt':

						campos[i].id=tipo+cels+cnbi

						campos[i].name=tipo+cels+cnbi

						banderabi=true

						break

				}

		}

		if (banderabi) cnbi+=1

		if (tipo=='pf'){

			switch(cels){

					case 'ds':

						banderapf=false

						campos[i].id=tipo+cels+cnpf

						campos[i].name=tipo+cels+cnpf

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnpf + '", "' + tipo + 'dd' + cnpf + '", "' + tipo + 'vu' + cnpf + '", "' + tipo + 'vt' + cnpf + '")')

						break

					case 'cn':

						campos[i].id=tipo+cels+cnpf

						campos[i].name=tipo+cels+cnpf

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnpf + '", "' + tipo + 'dd' + cnpf + '", "' + tipo + 'vu' + cnpf + '", "' + tipo + 'vt' + cnpf + '")')

						break

					case 'dd':

						campos[i].id=tipo+cels+cnpf

						campos[i].name=tipo+cels+cnpf

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnpf + '", "' + tipo + 'dd' + cnpf + '", "' + tipo + 'vu' + cnpf + '", "' + tipo + 'vt' + cnpf + '")')

						break

					case 'vu':

						campos[i].id=tipo+cels+cnpf

						campos[i].name=tipo+cels+cnpf

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnpf + '", "' + tipo + 'dd' + cnpf + '", "' + tipo + 'vu' + cnpf + '", "' + tipo + 'vt' + cnpf + '")')

						break

					case 'vt':

						campos[i].id=tipo+cels+cnpf

						campos[i].name=tipo+cels+cnpf

						banderapf=true

						break

				}

		}

		if (banderapf) cnpf+=1

		if (tipo=='mg'){

			switch(cels){

					case 'ds':

						banderamg=false

						campos[i].id=tipo+cels+cnmg

						campos[i].name=tipo+cels+cnmg

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnmg + '", "' + tipo + 'dd' + cnmg + '", "' + tipo + 'vu' + cnmg + '", "' + tipo + 'vt' + cnmg + '")')

						break

					case 'cn':

						campos[i].id=tipo+cels+cnmg

						campos[i].name=tipo+cels+cnmg

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnmg + '", "' + tipo + 'dd' + cnmg + '", "' + tipo + 'vu' + cnmg + '", "' + tipo + 'vt' + cnmg + '")')

						break

					case 'dd':

						campos[i].id=tipo+cels+cnmg

						campos[i].name=tipo+cels+cnmg

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnmg + '", "' + tipo + 'dd' + cnmg + '", "' + tipo + 'vu' + cnmg + '", "' + tipo + 'vt' + cnmg + '")')

						break

					case 'vu':

						campos[i].id=tipo+cels+cnmg

						campos[i].name=tipo+cels+cnmg

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnmg + '", "' + tipo + 'dd' + cnmg + '", "' + tipo + 'vu' + cnmg + '", "' + tipo + 'vt' + cnmg + '")')

						break

					case 'vt':

						campos[i].id=tipo+cels+cnmg

						campos[i].name=tipo+cels+cnmg

						banderamg=true

						break

				}

		}

		if (banderamg) cnmg+=1

		if (tipo=='os'){

			switch(cels){

					case 'ds':

						banderaos=false

						campos[i].id=tipo+cels+cnos

						campos[i].name=tipo+cels+cnos

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnos + '", "' + tipo + 'dd' + cnos + '", "' + tipo + 'vu' + cnos + '", "' + tipo + 'vt' + cnos + '")')

						break

					case 'cn':

						campos[i].id=tipo+cels+cnos

						campos[i].name=tipo+cels+cnos

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnos + '", "' + tipo + 'dd' + cnos + '", "' + tipo + 'vu' + cnos + '", "' + tipo + 'vt' + cnos + '")')

						break

					case 'dd':

						campos[i].id=tipo+cels+cnos

						campos[i].name=tipo+cels+cnos

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnos + '", "' + tipo + 'dd' + cnos + '", "' + tipo + 'vu' + cnos + '", "' + tipo + 'vt' + cnos + '")')

						break

					case 'vu':

						campos[i].id=tipo+cels+cnos

						campos[i].name=tipo+cels+cnos

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnos + '", "' + tipo + 'dd' + cnos + '", "' + tipo + 'vu' + cnos + '", "' + tipo + 'vt' + cnos + '")')

						break

					case 'vt':

						campos[i].id=tipo+cels+cnos

						campos[i].name=tipo+cels+cnos

						banderaos=true

						break

				}

		}

		if (banderaos) cnos+=1

		if (tipo=='pe'){

			switch(cels){

					case 'ds':

						banderape=false

						campos[i].id=tipo+cels+cnpe

						campos[i].name=tipo+cels+cnpe

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnpe + '", "' + tipo + 'dd' + cnpe + '", "' + tipo + 'vu' + cnpe + '", "' + tipo + 'vt' + cnpe + '")')

						break

					case 'cn':

						campos[i].id=tipo+cels+cnpe

						campos[i].name=tipo+cels+cnpe

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnpe + '", "' + tipo + 'dd' + cnpe + '", "' + tipo + 'vu' + cnpe + '", "' + tipo + 'vt' + cnpe + '")')

						break

					case 'dd':

						campos[i].id=tipo+cels+cnpe

						campos[i].name=tipo+cels+cnpe

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnpe + '", "' + tipo + 'dd' + cnpe + '", "' + tipo + 'vu' + cnpe + '", "' + tipo + 'vt' + cnpe + '")')

						break

					case 'vu':

						campos[i].id=tipo+cels+cnpe

						campos[i].name=tipo+cels+cnpe

						campos[i].setAttribute('onchange', 'CalculaTotal("' + tipo + 'cn' + cnpe + '", "' + tipo + 'dd' + cnpe + '", "' + tipo + 'vu' + cnpe + '", "' + tipo + 'vt' + cnpe + '")')

						break

					case 'vt':

						campos[i].id=tipo+cels+cnpe

						campos[i].name=tipo+cels+cnpe

						banderape=true

						break

				}

		}

		if (banderape) cnpe+=1

		

		

		if (tipo=='ec'){

			switch(cels){

					case 'pv':

						campos[i].id=tipo+cels+cnec

						campos[i].name=tipo+cels+cnec

						var fila=campos[i].parentNode

						fila.id=tipo+'fl'+cnec

						campos[i].setAttribute('onclick','DetalleProv(\''+tabla+'\', \''+tipo+'cn'+cnec+'\', '+cnec+', \''+tipo+'fl'+cnec+'\', this), Proveedor(\'prove'+tipo+'fl'+cnec+'\')')

						break

					case 'ds':

						campos[i].id=tipo+cels+cnec

						campos[i].name=tipo+cels+cnec

						break

					case 'cn':

						campos[i].id=tipo+cels+cnec

						campos[i].name=tipo+cels+cnec

						campos[i].setAttribute('onchange','CambiaEstado(\''+tipo+cnec+'\', \''+tipo+'fl'+cnec+'\'), CalculaTotal(\''+tipo+'cn'+cnec+'\',\''+tipo+'dd'+cnec+'\',\''+tipo+'vu'+cnec+'\',\''+tipo+'vt'+cnec+'\' ), CalculaProd()')

						break

					case 'dd':

						campos[i].id=tipo+cels+cnec

						campos[i].name=tipo+cels+cnec

						campos[i].setAttribute('onchange','CalculaTotal(\''+tipo+'cn'+cnec+'\',\''+tipo+'dd'+cnec+'\',\''+tipo+'vu'+cnec+'\',\''+tipo+'vt'+cnec+'\' ), CalculaProd()')

						break

					case 'vu':

						campos[i].id=tipo+cels+cnec

						campos[i].name=tipo+cels+cnec

						campos[i].setAttribute('onchange','CalculaTotal(\''+tipo+'cn'+cnec+'\',\''+tipo+'dd'+cnec+'\',\''+tipo+'vu'+cnec+'\',\''+tipo+'vt'+cnec+'\' )')

						break

					case 'vt':

						campos[i].id=tipo+cels+cnec

						campos[i].name=tipo+cels+cnec

						campos[i].setAttribute('onchange','CalculaTotal(\''+tipo+'cn'+cnec+'\',\''+tipo+'dd'+cnec+'\',\''+tipo+'vu'+cnec+'\',\''+tipo+'vt'+cnec+'\' ), CalculaProd()')

						banderaec=true

						break

				}

		}

		if (banderaec) {

			cnec+=1

			banderaec=false

		}

		

		if (tipo=='tt'){

			switch(cels){

					case 'pv':

						campos[i].id=tipo+cels+cntt

						campos[i].name=tipo+cels+cntt

						var fila=campos[i].parentNode

						fila.id=tipo+'fl'+cntt

						campos[i].setAttribute('onclick','DetalleProv(\''+tabla+'\', \''+tipo+'cn'+cntt+'\', '+cntt+', \''+tipo+'fl'+cntt+'\', this), Proveedor(\'prove'+tipo+'fl'+cntt+'\')')

						break

					case 'ds':

						campos[i].id=tipo+cels+cntt

						campos[i].name=tipo+cels+cntt

						break

					case 'cn':

						campos[i].id=tipo+cels+cntt

						campos[i].name=tipo+cels+cntt

						campos[i].setAttribute('onchange','CambiaEstado(\''+tipo+cntt+'\', \''+tipo+'fl'+cntt+'\'), CalculaTotal(\''+tipo+'cn'+cntt+'\',\''+tipo+'dd'+cntt+'\',\''+tipo+'vu'+cntt+'\',\''+tipo+'vt'+cntt+'\' ), CalculaProd()')

						break

					case 'dd':

						campos[i].id=tipo+cels+cntt

						campos[i].name=tipo+cels+cntt

						campos[i].setAttribute('onchange','CalculaTotal(\''+tipo+'cn'+cntt+'\',\''+tipo+'dd'+cntt+'\',\''+tipo+'vu'+cntt+'\',\''+tipo+'vt'+cntt+'\' ), CalculaProd()')

						break

					case 'vu':

						campos[i].id=tipo+cels+cntt

						campos[i].name=tipo+cels+cntt

						campos[i].setAttribute('onchange','CalculaTotal(\''+tipo+'cn'+cntt+'\',\''+tipo+'dd'+cntt+'\',\''+tipo+'vu'+cntt+'\',\''+tipo+'vt'+cntt+'\' )')

						break

					case 'vt':

						campos[i].id=tipo+cels+cntt

						campos[i].name=tipo+cels+cntt

						campos[i].setAttribute('onchange','CalculaTotal(\''+tipo+'cn'+cntt+'\',\''+tipo+'dd'+cntt+'\',\''+tipo+'vu'+cntt+'\',\''+tipo+'vt'+cntt+'\' ), CalculaProd()')

						banderatt=true

						break

				}

		}

		if (banderatt){

			cntt+=1

			banderatt=false

		}

		if (tipo=='im'){

			switch(cels){

					case 'pv':

						campos[i].id=tipo+cels+cnim

						campos[i].name=tipo+cels+cnim

						var fila=campos[i].parentNode

						fila.id=tipo+'fl'+cnim

						campos[i].setAttribute('onclick','DetalleProv(\''+tabla+'\', \''+tipo+'cn'+cnim+'\', '+cnim+', \''+tipo+'fl'+cnim+'\', this), Proveedor(\'prove'+tipo+'fl'+cnim+'\')')

						break

					case 'ds':

						campos[i].id=tipo+cels+cnim

						campos[i].name=tipo+cels+cnim

						break

					case 'cn':

						campos[i].id=tipo+cels+cnim

						campos[i].name=tipo+cels+cnim

						campos[i].setAttribute('onchange','CambiaEstado(\''+tipo+cnim+'\', \''+tipo+'fl'+cnim+'\'), CalculaTotal(\''+tipo+'cn'+cnim+'\',\''+tipo+'dd'+cnim+'\',\''+tipo+'vu'+cnim+'\',\''+tipo+'vt'+cnim+'\' ), CalculaProd()')

						break

					case 'dd':

						campos[i].id=tipo+cels+cnim

						campos[i].name=tipo+cels+cnim

						campos[i].setAttribute('onchange','CalculaTotal(\''+tipo+'cn'+cnim+'\',\''+tipo+'dd'+cnim+'\',\''+tipo+'vu'+cnim+'\',\''+tipo+'vt'+cnim+'\' ), CalculaProd()')

						break

					case 'vu':

						campos[i].id=tipo+cels+cnim

						campos[i].name=tipo+cels+cnim

						campos[i].setAttribute('onchange','CalculaTotal(\''+tipo+'cn'+cnim+'\',\''+tipo+'dd'+cnim+'\',\''+tipo+'vu'+cnim+'\',\''+tipo+'vt'+cnim+'\' )')

						break

					case 'vt':

						campos[i].id=tipo+cels+cnim

						campos[i].name=tipo+cels+cnim

						campos[i].setAttribute('onchange','CalculaTotal(\''+tipo+'cn'+cnim+'\',\''+tipo+'dd'+cnim+'\',\''+tipo+'vu'+cnim+'\',\''+tipo+'vt'+cnim+'\' ), CalculaProd()')

						banderaim=true

						break

				}

		}

		if (banderaim){

			cnim+=1

			banderaim=false

		}

		if (tipo=='nt'){

			switch(cels){

					case 'pv':

						campos[i].id=tipo+cels+cnnt

						campos[i].name=tipo+cels+cnnt

						var fila=campos[i].parentNode

						fila.id=tipo+'fl'+cnnt

						campos[i].setAttribute('onclick','DetalleProv(\''+tabla+'\', \''+tipo+'cn'+cnnt+'\', '+cnnt+', \''+tipo+'fl'+cnnt+'\', this), Proveedor(\'prove'+tipo+'fl'+cnnt+'\')')

						break

					case 'ds':

						campos[i].id=tipo+cels+cnnt

						campos[i].name=tipo+cels+cnnt

						break

					case 'cn':

						campos[i].id=tipo+cels+cnnt

						campos[i].name=tipo+cels+cnnt

						campos[i].setAttribute('onchange','CambiaEstado(\''+tipo+cnnt+'\', \''+tipo+'fl'+cnnt+'\'), CalculaTotal(\''+tipo+'cn'+cnnt+'\',\''+tipo+'dd'+cnnt+'\',\''+tipo+'vu'+cnnt+'\',\''+tipo+'vt'+cnnt+'\' ), CalculaProd()')

						break

					case 'dd':

						campos[i].setAttribute('onchange','CalculaTotal(\''+tipo+'cn'+cnnt+'\',\''+tipo+'dd'+cnnt+'\',\''+tipo+'vu'+cnnt+'\',\''+tipo+'vt'+cnnt+'\' ), CalculaProd()')

						campos[i].id=tipo+cels+cnnt

						campos[i].name=tipo+cels+cnnt

						break

					case 'vu':

						campos[i].id=tipo+cels+cnnt

						campos[i].name=tipo+cels+cnnt

						campos[i].setAttribute('onchange','CalculaTotal(\''+tipo+'cn'+cnnt+'\',\''+tipo+'dd'+cnnt+'\',\''+tipo+'vu'+cnnt+'\',\''+tipo+'vt'+cnnt+'\' )')

						break

					case 'vt':

						campos[i].id=tipo+cels+cnnt

						campos[i].name=tipo+cels+cnnt

						campos[i].setAttribute('onchange','CalculaTotal(\''+tipo+'cn'+cnnt+'\',\''+tipo+'dd'+cnnt+'\',\''+tipo+'vu'+cnnt+'\',\''+tipo+'vt'+cnnt+'\' ), CalculaProd()')

						banderant=true

						break

				}

		}

		if (banderant){

			cnnt+=1

			banderant=false

		}

		if (tipo=='es'){

			switch(cels){

					case 'pv':

						campos[i].id=tipo+cels+cnes

						campos[i].name=tipo+cels+cnes

						var fila=campos[i].parentNode

						fila.id=tipo+'fl'+cnes

						campos[i].setAttribute('onclick','DetalleProv(\''+tabla+'\', \''+tipo+'cn'+cnes+'\', '+cnes+', \''+tipo+'fl'+cnes+'\', this), Proveedor(\'prove'+tipo+'fl'+cnes+'\')')

						break

					case 'ds':

						campos[i].id=tipo+cels+cnes

						campos[i].name=tipo+cels+cnes

						break

					case 'cn':

						campos[i].id=tipo+cels+cnes

						campos[i].name=tipo+cels+cnes

						campos[i].setAttribute('onchange','CambiaEstado(\''+tipo+cnes+'\', \''+tipo+'fl'+cnes+'\'), CalculaTotal(\''+tipo+'cn'+cnes+'\',\''+tipo+'dd'+cnes+'\',\''+tipo+'vu'+cnes+'\',\''+tipo+'vt'+cnes+'\' ), CalculaProd()')

						break

					case 'dd':

						campos[i].id=tipo+cels+cnes

						campos[i].name=tipo+cels+cnes

						campos[i].setAttribute('onchange','CalculaTotal(\''+tipo+'cn'+cnes+'\',\''+tipo+'dd'+cnes+'\',\''+tipo+'vu'+cnes+'\',\''+tipo+'vt'+cnes+'\' ), CalculaProd()')

						break

					case 'vu':

						campos[i].id=tipo+cels+cnes

						campos[i].name=tipo+cels+cnes

						campos[i].setAttribute('onchange','CalculaTotal(\''+tipo+'cn'+cnes+'\',\''+tipo+'dd'+cnes+'\',\''+tipo+'vu'+cnes+'\',\''+tipo+'vt'+cnes+'\' )')

						break

					case 'vt':

						campos[i].id=tipo+cels+cnes

						campos[i].name=tipo+cels+cnes

						campos[i].setAttribute('onchange','CalculaTotal(\''+tipo+'cn'+cnes+'\',\''+tipo+'dd'+cnes+'\',\''+tipo+'vu'+cnes+'\',\''+tipo+'vt'+cnes+'\' ), CalculaProd()')

						banderaes=true

						break

				}

		}

		if (banderaes){

			cnes+=1

			banderaes=false

		}

		

		if (tipo=='pr'){

			switch(cels){

					case 'cn':

						campos[i].id=tipo+cels+cnpr

						campos[i].name=tipo+cels+cnpr

						campos[i].setAttribute('onchange','CalculaTotal(\'prcn'+cnpr+'\',\'prdd'+cnpr+'\',\'prvu'+cnpr+'\',\'prvt'+cnpr+'\' ), CalculaProd()')

						break

					case 'dd':

						campos[i].id=tipo+cels+cnpr

						campos[i].name=tipo+cels+cnpr

						campos[i].setAttribute('onchange','CalculaTotal(\'prcn'+cnpr+'\',\'prdd'+cnpr+'\',\'prvu'+cnpr+'\',\'prvt'+cnpr+'\' ), CalculaProd()')

						break

					case 'vu':

						campos[i].id=tipo+cels+cnpr

						campos[i].name=tipo+cels+cnpr

						campos[i].setAttribute('onchange','CalculaTotal(\'prcn'+cnpr+'\',\'prdd'+cnpr+'\',\'prvu'+cnpr+'\',\'prvt'+cnpr+'\' ), CalculaProd()')

						break

					case 'vt':

						campos[i].id=tipo+cels+cnpr

						campos[i].name=tipo+cels+cnpr

						campos[i].setAttribute('onchange','CalculaTotal(\'prcn'+cnpr+'\',\'prdd'+cnpr+'\',\'prvu'+cnpr+'\',\'prvt'+cnpr+'\' ), CalculaProd()')

						banderapr=true

						break

				}

		}

		if (banderapr){

			cnpr+=1

			banderapr=false

		}

	

	}

	

	listas = document.getElementsByTagName("select");

	banderapersona=false

	cnpersona=1

	for (var j = 0; j < listas.length; j++){

		var nlist=listas[j].id

		var tipol = nlist.substr(0,9)

		if (tipol=='especiali'){

			listas[j].id=tipol+cnpersona

			listas[j].name=tipol+cnpersona

			listas[j].setAttribute('onfocus','Cargos(\'especiali'+cnpersona+'\')')

			listas[j].setAttribute('onchange','Personas(\'especiali'+cnpersona+'\', \'npersonas'+cnpersona+'\')')

		}

		if (tipol=='npersonas'){

			listas[j].id=tipol+cnpersona

			listas[j].name=tipol+cnpersona

			listas[j].setAttribute('onfocus','Personas(\'especiali'+cnpersona+'\', \'npersonas'+cnpersona+'\')')

			banderapersona=true

		}

		if(banderapersona){

			cnpersona+=1

			banderapersona=false

		}

	}

}





function NCampo(tabla){

	var a

	var tbl = document.getElementById(tabla);

	if (tbl.id=='eventmark') a='em'

	if (tbl.id=='rentsupp') a='rs'

	if (tbl.id=='videohd3d') a='vd'

	if (tbl.id=='keynote') a='kn'

	if (tbl.id=='visualex') a='ve'

	if (tbl.id=='branding') a='bi'

	if (tbl.id=='performance') a='pf'

	if (tbl.id=='management') a='mg'

	if (tbl.id=='own') a='os'

	if (tbl.id=='produccion') a='pe'

	if (tbl.id=='transport') a='tt'

	if (tbl.id=='imprevistos') a='im'

	if (tbl.id=='personal') a='pr'

	if (tbl.id=='eventocorporativo') a='ec'

	if (tbl.id=='nvatecnologia') a='nt'

	if (tbl.id=='espectaculo') a='es'

	if (tbl.id=='equiposesl') a='es'

	if (tbl.id=='gastosprod') a='gp'

	return a

}



function Porcentaje(vcomise, vcomesl, vcompra,resultado){

	var n1=document.getElementById(vcomise)

	var n2=document.getElementById(vcomesl)

	var n3=document.getElementById(vcompra)

	var valcompra=NumNormal(n3.value)

	n1.value='$ '+FormatoNum(valcompra*0.02)

	n2.value='$ '+FormatoNum(valcompra*0.05)

	document.getElementById(resultado).value=''

	document.getElementById(resultado).value=0.07

}



function NumNormal(val){

	var res = val.replace('$','')

	res=res.replace('%','')

	res=res.replace(/,/g,'')

	res=parseFloat(res)

	return res

}



function FormatoN(elem){

	var cad = elem.value

	var val= new oNumero(cad.replace('$ ',''))

	elem.value=val.formato(2,true)

}



function FormatoNum(elem){

	var val= new oNumero(elem)

	var cad=val.formato(2,true)

	return cad.replace('$ ','')

}





function oNumero(numero){

//Propiedades

this.valor = numero || 0

this.dec = -1;

//Métodos

this.formato = numFormat;

this.ponValor = ponValor;

//Definición de los métodos

function ponValor(cad){

	if (cad =='-' || cad=='+') return

	if (cad.length ==0) return

	if (cad.indexOf('.') >=0) this.valor = parseFloat(cad);

	else

    	this.valor = parseInt(cad);

	}



function numFormat(dec, miles,tipo){

	var num = this.valor, signo=3, expr;

	var cad = ""+this.valor;

	var ceros = "", pos, pdec, i;

	for (i=0; i < dec; i++)

		ceros += '0';

	pos = cad.indexOf('.')

	if (pos < 0) cad = cad+"."+ceros;

	else{

    	pdec = cad.length - pos -1;

    if (pdec <= dec){

        for (i=0; i< (dec-pdec); i++)

            cad += '0';

        }

    else{

        num = num*Math.pow(10, dec);

        num = Math.round(num);

        num = num/Math.pow(10, dec);

        cad = new String(num);

    }

	}

	pos = cad.indexOf('.')

	if (pos < 0) pos = cad.lentgh

	if (cad.substr(0,1)=='-' || cad.substr(0,1) == '+') signo = 4;

	if (miles && pos > signo)

    	do{

        	expr = /([+-]?\d)(\d{3}[\.\,]\d*)/

        	cad.match(expr)

        	cad=cad.replace(expr, RegExp.$1+','+RegExp.$2)

        }while (cad.indexOf(',') > signo)

    if (dec<0) cad = cad.replace(/\./,'')

		if (tipo=='n'){

			return cad;

		}else{

			return '$ '+cad;

		}

		

	}

}



function HabilitaP(control,lista){

		if(control.checked){

			document.getElementById(lista).disabled=false

		}else{

			var cellt = document.getElementById(lista)

			if ( cellt.hasChildNodes() ){

				while ( cellt.childNodes.length >= 1 ){

					cellt.removeChild( cellt.firstChild )

				} 

			}

			document.getElementById(lista).disabled=true

		}

}



function DetalleProv(ntabla, total, cant, en, control){

	var numfilas=document.getElementById(total).value

	if ((numfilas==0)||(numfilas=='')){

		alert('Debe Ingresar una Cantidad Válida de Elementos')

		control.checked=false

	}else{

		var tabla=document.createElement('table')

		tabla.id='listprov'+en

		if(control.checked){

			var fila=document.createElement('tr')

			var columna=document.createElement('td')

			columna.innerHTML='<select id=\"prove'+en+'\" name=\"prove'+en+'\" onchange=\"CalculaProd()\"  /></select>'

			fila.appendChild(columna)

			fila.id='detprov'+en

			tabla.appendChild(fila)

			document.getElementById(en).appendChild(tabla)

		}else{

			var borrar=document.getElementById('listprov'+en)

			document.getElementById(en).removeChild(borrar)

		}

	}

}



function ListaXML(elm, archivo, vacio){

	var lista = document.getElementById(elm)

	if (lista.childNodes.length<=1){

		var xmlDoc=CargaXML(archivo)

		var cero = document.createElement('option')

		cero.value='0'

		cero.text=vacio

		lista.appendChild(cero)

		for (var i=0;xmlDoc.childNodes[0].childNodes.length;i++){

			var idc = xmlDoc.childNodes[0].childNodes[i].attributes[0].nodeValue

			var nombre = xmlDoc.childNodes[0].childNodes[i].attributes[1].nodeValue

			var opcion = document.createElement('option')

			opcion.value=idc

			opcion.text=nombre

			lista.appendChild(opcion)

		}

	}

}



function ContactoXML(lista, elm, archivo){

	var lista = document.getElementById(lista)

	var control = document.getElementById(elm)

	var xmlDoc=CargaXML(archivo)

	for (var i=0;xmlDoc.childNodes[0].childNodes.length;i++){

		var idc = xmlDoc.childNodes[0].childNodes[i].attributes[0].nodeValue

		if(lista.value==idc){

			control.ncontac.value=utf8_decode(xmlDoc.childNodes[0].childNodes[i].attributes[1].nodeValue)

			control.ntelcontac.value=xmlDoc.childNodes[0].childNodes[i].attributes[2].nodeValue	

			control.nmail.value=xmlDoc.childNodes[0].childNodes[i].attributes[3].nodeValue	

			return 0

		}else{

			control.ncontac.value=''

			control.ntelcontac.value=''

			control.nmail.value=''

		}

	}

}





function CargaXML(url){

    if(window.XMLHttpRequest){

        var Loader = new XMLHttpRequest();

        Loader.open("GET", url ,false); 

        Loader.send(null);

        return Loader.responseXML;

    }else if(window.ActiveXObject){

        var Loader = new ActiveXObject("Msxml2.DOMDocument.3.0");

        Loader.async = false;

        Loader.load(url);

        return Loader;

    }

}



function ArbolXML(xmlNode,ident){

    var treeTxt="";

    for(var i=0;i<xmlNode.childNodes.length;i++){

  		if(xmlNode.childNodes[i].nodeType == 1){

   			treeTxt = treeTxt + ident + xmlNode.childNodes[i].nodeName + ": "

   			if(xmlNode.childNodes[i].childNodes.length==0){

    			treeTxt = treeTxt + xmlNode.childNodes[i].nodeValue 

    			for(var z=0;z<xmlNode.childNodes[i].attributes.length;z++){

     				var atrib = xmlNode.childNodes[i].attributes[z];

     				treeTxt = treeTxt + " (" + atrib.nodeName + " = " + atrib.nodeValue + ")";

    			}

    			treeTxt = treeTxt + "<br />\n";

   			}else if(xmlNode.childNodes[i].childNodes.length>0){

    			treeTxt = treeTxt + xmlNode.childNodes[i].firstChild.nodeValue;

    			for(var z=0;z<xmlNode.childNodes[i].attributes.length;z++){

    				var atrib = xmlNode.childNodes[i].attributes[z];

    				treeTxt = treeTxt + " (" + atrib.nodeName + " = " + atrib.nodeValue + ")";

    			}

    			treeTxt = treeTxt + "<br />\n" + ArbolXML(xmlNode.childNodes[i],ident + "> > ");

   			}	

      	}

    }

    return treeTxt;

}



function utf8_decode(utftext) {

		var string = "";

		var i = 0;

		var c = c1 = c2 = 0;

 

		while ( i < utftext.length ) {

			c = utftext.charCodeAt(i);

			if (c < 128) {

				string += String.fromCharCode(c);

				i++;

			}

			else if((c > 191) && (c < 224)) {

				c2 = utftext.charCodeAt(i+1);

				string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));

				i += 2;

			}

			else {

				c2 = utftext.charCodeAt(i+1);

				c3 = utftext.charCodeAt(i+2);

				string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));

				i += 3;

			}

		}

		return string;

}



function SumaMonedas(val1, val2, val3, destino){

	var tot

	var nval1

	var nval2

	var nval3

	nval1=NumNormal(document.getElementById(val1).value)

	nval2=NumNormal(document.getElementById(val2).value)

	nval3=NumNormal(document.getElementById(val3).value)

	tot=nval1+nval2+nval3

	var resultado = document.getElementById(destino)

	resultado.value='$ '+FormatoNum(tot)

}



function ValorNeto(val1, val2, val3, destino){

	var tot

	var nval1

	var nval2

	var nval3

	nval1=NumNormal(document.getElementById(val1).value)

	nval2=NumNormal(document.getElementById(val2).value)

	nval3=NumNormal(document.getElementById(val3).value)

	tot=nval1+nval2-nval3

	var resultado = document.getElementById(destino)

	resultado.value='$ '+FormatoNum(tot)

}



function CalculaIva(tarifa, filas){

	var campo

	var valor

	var resultado=0

	var totaliva=0

	var tfilas=document.getElementById(filas).value

	var vtarifa=document.getElementById(tarifa).value

	var valiva=vtarifa/100	

	for (var i=1;i<=tfilas;i++){

		var nombre = 'iva'+i

		var total = 'vt'+i

		valor=document.getElementById(total)

		campo=document.getElementById(nombre)

		resultado=NumNormal(valor.value)*valiva

		campo.value='$'+FormatoNum(resultado)

		totaliva+=resultado

	}

	var campototal=document.getElementById('totiva')

	campototal.value='$'+FormatoNum(totaliva)

}



function ReteIVA(control){

	var campo=document.getElementById(control)

	var viva=NumNormal(campo.totord.value)

	var rete=NumNormal(campo.triva.value)/100

	var resul=viva*rete

	campo.reteiva.value=' $ '+FormatoNum(resul)

}



function ReteICA(control){

	var campo=document.getElementById(control)

	var valc=NumNormal(campo.totord.value)

	var rete=NumNormal(campo.trica.value)/100

	var resul=valc*rete

	campo.reteica.value=' $ '+FormatoNum(resul)

}



function ReteFTE(control){

	var campo=document.getElementById(control)

	var valc=NumNormal(campo.totord.value)

	var rete=NumNormal(campo.trfte.value)/100

	var resul=valc*rete

	campo.retefte.value=' $ '+FormatoNum(resul)

}



function suma(control1, control2){

	var a=document.getElementById(control1).value

	var b=document.getElementById(control2).value

	var resul =NumNormal(a)+NumNormal(b)

	return resul

}