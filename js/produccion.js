function EliminaFilaP(tabla,control, cuerpo){
	var tbl = document.getElementById(tabla)
	var cntr = control.parentNode.parentNode
	var lastRow = document.getElementById(cuerpo)
	var tot = document.getElementById('tt'+tabla)
	if (lastRow.rows.length <= 1){
		alert('No Puede Eliminar Esta Fila, Es la Ultima disponible')
	}else{
		cntr.parentNode.removeChild(cntr);
		for (var i=0;i<lastRow.rows.length;i++){
			lastRow.childNodes.item(i).id=NCampo(tabla)+'fl'+(i+1)
			var cloneNode = lastRow.childNodes.item(i)
			for(var j=0;j<=8;j++){
				var elm = cloneNode.childNodes.item(j).childNodes[0]
				if(elm.id!=''){
					 elm.id=SinNumero(elm.id)+(i+1)
					 elm.name=SinNumero(elm.id)+(i+1)
				}
			}
		}
		tot.value=lastRow.rows.length;
	}
}

function CalculaTotalProd(control) {
		var fila = control.parentNode.parentNode
		var n1=0
		var n2=0
		var n3=0
		for (var i=0;i<fila.childNodes.length;i++){
			var elm = fila.childNodes[i].childNodes[0]
			var nombre = elm.id
			if(nombre.match(/[a-z]{2}[c]{1}[n]{1}/)) n1=NumNormal(elm.value)
			if(nombre.match(/[a-z]{2}[d]{2}/)) n2=NumNormal(elm.value)
			if(nombre.match(/[a-z]{2}[v]{1}[u]{1}/)) n3=NumNormal(elm.value)
			if(nombre.match(/[a-z]{2}[v]{1}[t]{1}/)) var total = elm
			
		}
		var res
		res=n1*n2*n3
		var resul= new oNumero(res)
		total.value=resul.formato(2,true)
}


function Contenido(elm, tipo){
//	var lista = document.getElementById(elm)
	if (elm.childNodes.length<=1){
		if(tipo=='Proveedor') var xmlDoc=CargaXML('proveedores.xml')
		if(tipo=='Profesional') var xmlDoc=CargaXML('profesionales.xml')
			
		for (var i=0;xmlDoc.childNodes[0].childNodes.length;i++){
			var idc = xmlDoc.childNodes[0].childNodes[i].attributes[0].nodeValue
			var nombre = xmlDoc.childNodes[0].childNodes[i].firstChild.nodeValue
			var opcion = document.createElement('option')
			opcion.value=idc
			opcion.text=nombre
			elm.appendChild(opcion)
		}
	}
}

function NuevaAdicional(tabla, fila) {
	var tbl = document.getElementById(tabla)
	var fl = fila.parentNode.parentNode
	var bod = fl.parentNode
	var indice = bod.rows.length+1
	//var row = fl.parentNode.insertRow(fl)
	var tot='tt'+tbl.id
	var clone = fl.cloneNode(true)
	clone.id=NCampo(tabla)+'fl'+indice
	for (var i=0;i<=8;i++){
		var cloneNode = clone.childNodes[i]
		var elm = cloneNode.childNodes[0]
			if(elm.id!=''){
				 elm.id=SinNumero(elm.id)+indice
				 elm.name=SinNumero(elm.id)+indice
			}
	}
	bod.appendChild(clone)	
	document.getElementById(tot).value=indice
}

function CalculaProd(){
	var a = document.getElementById('tteventocorporativo')
	var b = document.getElementById('ttnvatecnologia')
	var c = document.getElementById('ttequiposesl')
	var d = document.getElementById('ttgastosprod')
	var e = document.getElementById('ttimprevistos')
	var f = document.getElementById('ttpersonal')
	var categoria
	var cant=0
	var elemento
	var acum=0
	for (var k=1;k<=6;k++){
		var ntabla
		acum=0
		switch(k){
			case 1:
				cant=a.value
				ntabla='eventocorporativo'
				elemento='resec'
				break;
			case 2:
				cant=b.value
				ntabla='nvatecnologia'
				elemento='resnt'
				break;
			case 3:
				cant=c.value
				ntabla='equiposesl'
				elemento='resge'
				break;
			case 4:
				cant=d.value
				ntabla='gastosprod'
				elemento='respd'
				break;
			case 5:
				cant=e.value
				ntabla='imprevistos'
				elemento='resgi'
				break;
			case 6:
				cant=f.value
				ntabla='personal'
				elemento='respr'
				break;
		}
		for (var i=1; i<=cant;i++){
			var restot=NCampo(ntabla)+'vt'+i
			acum+=NumNormal(document.getElementById(restot).value)
			var racum=new oNumero(acum)
			document.getElementById(elemento).value=racum.formato(2,true)
		}
	}
		var tot
		tot=NumNormal(document.getElementById('resec').value)+NumNormal(document.getElementById('resnt').value)+NumNormal(document.getElementById('resge').value)+NumNormal(document.getElementById('respd').value)+NumNormal(document.getElementById('resgi').value)+NumNormal(document.getElementById('respr').value)
	
	var cons= new oNumero(tot)
	document.getElementById('resvt').value=cons.formato(2,true)
	
}

/*function Contenido(elm){
	var lista = document.getElementById(elm)
	if (lista.childNodes.length<=1){
		var xmlDoc=CargaXML('clientes.xml')
		var cero = document.createElement('option')
		cero.id='0'
		cero.text='-- Elija un Cliente --'
		lista.appendChild(cero)
		for (var i=0;xmlDoc.childNodes[0].childNodes.length;i++){
			var idc = xmlDoc.childNodes[0].childNodes[i].attributes[0].nodeValue
			var nombre = xmlDoc.childNodes[0].childNodes[i].attributes[4].nodeValue
			var opcion = document.createElement('option')
			opcion.value=idc
			opcion.text=nombre
			lista.appendChild(opcion)
		}
	}
}

function Actualiza(origen,destino){
	var cual
	var dest
	var nuevo
	cual=document.getElementById(origen)
	dest=document.getElementById(destino)
		
	document.getElementById('nnit').value=''
	document.getElementById('ndv').value=''
	document.getElementById('pptipoe').value=''
	document.getElementById('mailn').value=''
	document.getElementById('ncontactc').value=''
		
	var xmlDoc=CargaXML('clientes.xml')
	for (var i=0;xmlDoc.childNodes[0].childNodes.length;i++){
		var id = xmlDoc.childNodes[0].childNodes[i].attributes[0].nodeValue
		if(id==cual.value){
			var cliente = xmlDoc.childNodes[0].childNodes[i]
			document.getElementById('nnit').value=cliente.attributes[1].nodeValue
			document.getElementById('ndv').value=cliente.attributes[2].nodeValue
			document.getElementById('pptipoe').value=cliente.attributes[3].nodeValue
				
			if ( dest.hasChildNodes() ){
				while ( dest.childNodes.length >= 1 ){
					dest.removeChild( dest.firstChild )
				} 
			}
				
			var cero = document.createElement('option')
			cero.value='0'
			cero.text='-- Elija un Proyecto --'
			dest.appendChild(cero)
			for (var j=0; cliente.childNodes.length;j++){
				var ip = cliente.childNodes[j].attributes[0].nodeValue
				var np = cliente.childNodes[j].attributes[4].nodeValue
				var opcion = document.createElement('option')
				opcion.value=ip
				opcion.text=np
				dest.appendChild(opcion)
			}
		}		
	}
}

function ActualizaTabla(tabla,proyecto){
	var x=1
	var nombrecat
	var t
	var mitabla=document.getElementById(tabla)
	switch (proyecto){
		case 1:
			t='pres_eventoscorporativos'
			nombrecat='Eventos Corporativos'
			var nsprov=NCampo('eventocorporativo')+'pv'
			var ncat=NCampo('eventocorporativo')+'ct'
			var nfila=NCampo('eventocorporativo')+'fl'
			var ncan=NCampo('eventocorporativo')+'cn'
			var ndet=NCampo('eventocorporativo')+'ds'
			var ndia=NCampo('eventocorporativo')+'dd'
			var nvuni=NCampo('eventocorporativo')+'vu'
			var nvtt=NCampo('eventocorporativo')+'vt'
			break;
		case 2:
			t='pres_nuevastecnologias'
			nombrecat='Nuevas Tecnologias'
			var nsprov=NCampo('nvatecnologia')+'pv'
			var ncat=NCampo('nvatecnologia')+'ct'
			var nfila=NCampo('nvatecnologia')+'fl'
			var ncan=NCampo('nvatecnologia')+'cn'
			var ndet=NCampo('nvatecnologia')+'ds'
			var ndia=NCampo('nvatecnologia')+'dd'
			var nvuni=NCampo('nvatecnologia')+'vu'
			var nvtt=NCampo('nvatecnologia')+'vt'
			break;
		case 3:
			t='pres_espectaculos'
			nombrecat='Equipos ESL'
			var nsprov=NCampo('equiposesl')+'pv'
			var ncat=NCampo('equiposesl')+'ct'
			var nfila=NCampo('equiposesl')+'fl'
			var ncan=NCampo('equiposesl')+'cn'
			var ndet=NCampo('equiposesl')+'ds'
			var ndia=NCampo('equiposesl')+'dd'
			var nvuni=NCampo('equiposesl')+'vu'
			var nvtt=NCampo('equiposesl')+'vt'
			break;
		case 4:
			nombrecat='Gastos Produccion'
			var nsprov=NCampo('gastosprod')+'pv'
			var ncat=NCampo('gastosprod')+'ct'
			var nfila=NCampo('gastosprod')+'fl'
			var ncan=NCampo('gastosprod')+'cn'
			var ndet=NCampo('gastosprod')+'ds'
			var ndia=NCampo('gastosprod')+'dd'
			var nvuni=NCampo('gastosprod')+'vu'
			var nvtt=NCampo('gastosprod')+'vt'
			break;
		case 5:
			nombrecat='Gastos Imprevistos'
			var nsprov=NCampo('imprevistos')+'pv'
			var ncat=NCampo('imprevistos')+'ct'
			var nfila=NCampo('imprevistos')+'fl'
			var ncan=NCampo('imprevistos')+'cn'
			var ndet=NCampo('imprevistos')+'ds'
			var ndia=NCampo('imprevistos')+'dd'
			var nvuni=NCampo('imprevistos')+'vu'
			var nvtt=NCampo('imprevistos')+'vt'
			break;
	}
			
	var categoria=document.createElement('tr')
	var colcategoria=document.createElement('td')
	colcategoria.innerHTML='<h1>'+nombrecat+'</h1>'
	colcategoria.colSpan='6'
	categoria.appendChild(colcategoria)
	mitabla.appendChild(categoria)
	var ft=document.createElement('tr')
	for (var yy=0;yy<=6;yy++){
		var nct=document.createElement('td')
		switch(yy){
			case 0:
				nct.innerHTML='<label>Opciones</label>'
				break;
			case 1:
				if (nombrecat=='Eventos Corporativos'){
					nct.innerHTML='<label>Proveedor</label>'
				}
				break;
			case 2:
				nct.innerHTML='<label>Detalle</label>'
				break;
			case 3:
				nct.innerHTML='<label>Cantidad</label>'
				break;
			case 4:
				nct.innerHTML='<label>Dias</label>'
				break;
			case 5:
				nct.innerHTML='<label>Vr. Unitario</label>'
				break;
			case 6:
				nct.innerHTML='<label>Vr. Total</label>'
				break;
		}
		ft.appendChild(nct)
	}
	mitabla.appendChild(ft)
		
	var con=document.createElement('tr')
	var ob=document.createElement('td')
	var ff=x
	ob.innerHTML='<input type=\"hidden\" id=\"tt'+tabla+'\" name=\"tt'+tabla+'\" value=\"'+ff+'\"/>'
	con.appendChild(ob)
	mitabla.appendChild(con)
		
	var dft=document.createElement('tr')
	for (var l=0;l<=6;l++){
		var cft=document.createElement('td')
		switch(l){
			case 0:
				cft.id=nfila+x
				cft.innerHTML='<img src=\"images/mas.png\" onclick=\"NuevaAdicional(\''+tabla+'\')\"/><img src=\"images/menos.png\" onclick=\"EliminaFila(\''+tabla+'\',this)\"/>'
				break;
			case 1:
				if (nombrecat=='Eventos Corporativos'){
					cft.innerHTML='<select id="'+nsprov+x+'" name="'+nsprov+x+'" width="40" onfocus="Proveedor(\''+nsprov+x+'\')"><option value="0" selectedt="selected">--- Elija Proveedor ---</option></select>'
				}else{
					cft.innerHTML=''
				}
				break;
			case 2:
				cft.innerHTML='<input type=\"hidden\" id=\"'+ncat+x+'\" name=\"'+ncat+x+'\" value=\"'+nombrecat+'\"/><input type=\"text\" id=\"'+ndet+x+'\" name=\"'+ndet+x+'\" size=\"40\"/>'
				break;
			case 3:
				cft.innerHTML='<input type=\"text\" id=\"'+ncan+x+'\" name=\"'+ncan+x+'\" size=\"2\" onchange=\"CambiaEstado(\''+nsprov+x+'\', \''+nfila+x+'\'), CalculaTotal(\''+ncan+x+'\',\''+ndia+x+'\',\''+nvuni+x+'\',\''+nvtt+x+'\' ), CalculaProd()\"/>'
				break;
			case 4:
				cft.innerHTML='<input type=\"text\" id=\"'+ndia+x+'\" name=\"'+ndia+x+'\" size=\"2\" onchange=\"CalculaTotal(\''+ncan+x+'\',\''+ndia+x+'\',\''+nvuni+x+'\',\''+nvtt+x+'\' ), CalculaProd()\"/>'
				break;
			case 5:
				cft.innerHTML='<input type=\"text\" id=\"'+nvuni+x+'\" name=\"'+nvuni+x+'\" size=\"15\" value=\"0\" onchange=\"CalculaTotal(\''+ncan+x+'\',\''+ndia+x+'\',\''+nvuni+x+'\',\''+nvtt+x+'\' )\" onblur=\"FormatoN(this), CalculaProd()\"/>'
				break;
			case 6:
				cft.innerHTML='<input type=\"text\" id=\"'+nvtt+x+'\" name=\"'+nvtt+x+'\" size=\"15\" value=\"0\" READONLY/>'
				break;
		}
		dft.appendChild(cft)
	}
	mitabla.appendChild(dft)
}
	
function TPersona(tabla){
	var x=1
	var mitabla=document.getElementById(tabla)
	var personal=document.createElement('tr')
	var colpersonal=document.createElement('td')
	nombrecat='Gastos Personal'
	colpersonal.innerHTML='<h1>'+nombrecat+'</h1>'
	personal.appendChild(colpersonal)
	mitabla.appendChild(personal)
	var fp=document.createElement('tr')
	for (var yy=0;yy<=6;yy++){
		var cfp=document.createElement('td')
		switch(yy){
			case 0:
				cfp.innerHTML='<label>Opciones</label>'
				break;
			case 1:
				cfp.innerHTML='<label>Cargo</label>'
				break;
			case 2:
				cfp.innerHTML='<label>Nombre</label>'
				break;
			case 3:
				cfp.innerHTML='<label>Cantidad</label>'
				break;
			case 4:
				cfp.innerHTML='<label>Dias</label>'
				break;
			case 5:
				cfp.innerHTML='<label>Vr. Unitario</label>'
				break;
			case 6:
				cfp.innerHTML='<label>Vr. Total</label>'
				break;
		}
		fp.appendChild(cfp)
	}
	mitabla.appendChild(fp)
		
	var con=document.createElement('tr')
	var ob=document.createElement('td')
	var ff=x
	ob.innerHTML='<input type=\"hidden\" id=\"tt'+tabla+'\" name=\"tt'+tabla+'\" value=\"'+ff+'\"/>'
	con.appendChild(ob)
	mitabla.appendChild(con)
	
	var dpr=document.createElement('tr')
	for (var l=0;l<=6;l++){
		var cpr=document.createElement('td')
			switch(l){
				case 0:
					cpr.id='prfl'+x
					cpr.innerHTML='<img src=\"images/mas.png\" onclick=\"NuevaPersona(\''+tabla+'\')\"/><img src=\"images/menos.png\" onclick=\"EliminaFila(\''+tabla+'\', this)\"/>'
					break;
				case 1:
					cpr.innerHTML='<input type=\"hidden\" id=\"prct'+x+'\" name=\"prct'+x+'\" value=\"'+nombrecat+'\"/><select id=\"especiali'+x+'\" name=\"especiali'+x+'\" onfocus=\"Cargos(\'especiali'+x+'\')\"><option value=\"0\" selected=\"selected\">--- Elija Especialidad ---</option></select>'
					break;
				case 2:
					cpr.innerHTML='<select id=\"npersonas'+x+'\" name=\"npersonas'+x+'\" onfocus=\"Personas(\'especiali'+x+'\', \'npersonas'+x+'\')\"><option value=\"0\" selected=\"selected\">--- Elija Profesional ---</option></select>'
					break;
				case 3:
					cpr.innerHTML='<input type=\"text\" id=\"prcn'+x+'\" name=\"prcn'+x+'\" size=\"2\" onchange=\"CalculaTotal(\'prcn'+x+'\',\'prdd'+x+'\',\'prvu'+x+'\',\'prvt'+x+'\' ), CalculaProd()\"/>'
					break;
				case 4:
					cpr.innerHTML='<input type=\"text\" id=\"prdd'+x+'\" name=\"prdd'+x+'\" size=\"2\" onchange=\"CalculaTotal(\'prcn'+x+'\',\'prdd'+x+'\',\'prvu'+x+'\',\'prvt'+x+'\' ), CalculaProd()\"/>'
					break;
				case 5:
					cpr.innerHTML='<input type=\"text\" id=\"prvu'+x+'\" name=\"prvu'+x+'\" size=\"15\" value=\"0\" onchange=\"CalculaTotal(\'prcn'+x+'\',\'prdd'+x+'\',\'prvu'+x+'\',\'prvt'+x+'\' )\" onblur=\"FormatoN(this), CalculaProd()\"/>'
					break;
				case 6:
					cpr.innerHTML='<input type=\"text\" id=\"prvt'+x+'\" name=\"prvt'+x+'\" size=\"15\" value=\"0\" READONLY/>'
					break;
				}
				dpr.appendChild(cpr)
			}
	mitabla.appendChild(dpr)
}
	
function DProyecto(origen){
	var cual=document.getElementById(origen)
		
	document.getElementById('plugar').value=''
	document.getElementById('consevt').value=''
	document.getElementById('fechaevt').value=''
	document.getElementById('fechamon').value=''
	document.getElementById('fechades').value=''
	document.getElementById('dmont').value=''
	document.getElementById('ncontactc').value=''
	document.getElementById('mailn').value=''
	
	var xmlNego=CargaXML('infonegocio.xml')
	for (var j=0;j<=xmlNego.childNodes[0].childNodes.length;j++){
		var nproy=xmlNego.childNodes[0].childNodes[j]
		var idproy=nproy.attributes[0].nodeValue
		if(cual.value==idproy){
			var tnego = nproy.childNodes.length
			if (tnego<=0){
				alert('La Hoja de Negocio para Este Proyecto no Ha Sido Creada. No Puede Continuar')
				window.location='inicio.php?location='
			}else{
				var xmlDoc=CargaXML('infoproyecto.xml')

				for (var i=0;i<=xmlDoc.childNodes[0].childNodes.length;i++){
					var proyecto = xmlDoc.childNodes[0].childNodes[i]
					var idp = proyecto.attributes[0].nodeValue
					if(cual.value==idp){
						document.getElementById('plugar').value=proyecto.attributes[1].nodeValue
						document.getElementById('mailn').value=proyecto.attributes[3].nodeValue
						document.getElementById('consevt').value=proyecto.attributes[0].nodeValue
						document.getElementById('fechaevt').value=proyecto.attributes[5].nodeValue
						document.getElementById('fechamon').value=proyecto.attributes[6].nodeValue
						document.getElementById('fechades').value=proyecto.attributes[7].nodeValue
						document.getElementById('dmont').value=proyecto.attributes[1].nodeValue
						document.getElementById('ncontactc').value=proyecto.attributes[2].nodeValue
			
						var tpres = proyecto.childNodes.length
						if (tpres<=0){
							document.getElementById('totpres').value=''
							alert('Este Proyecto No Tiene Presupuestos Aprobados')
						}else{
							var presupuesto = proyecto.childNodes[0]
							document.getElementById('totpres').value='$ '+FormatoNum(presupuesto.attributes[7].nodeValue)
							ActualizaTabla('eventocorporativo',1)
							ActualizaTabla('nvatecnologia',2)
							ActualizaTabla('equiposesl',3)
							ActualizaTabla('gastosprod',4)
							ActualizaTabla('imprevistos',5)
							TPersona('personal')					
						}
					}
				}
			}
		}
	}
}

function NuevaAdicional(tabla) {
	var tbl = document.getElementById(tabla)
	var lastRow = tbl.rows.length
	var iteration = lastRow
	var row = tbl.insertRow(lastRow)
	var tot='tt'+tbl.id
	iteration-=3
	iteration++
	for (var i=0; i<=6;i++){
		var cell = row.insertCell(i)
		if (i>=2) {
			var el = document.createElement('input')
			el.type = 'text'
		}
		switch(i){
			case 0:
				var el1 = document.createElement('img')
				el1.src='images/mas.png'
				el1.setAttribute('onclick','NuevaAdicional("'+ tbl.id +'"), CalculaProd()')
				
				var el2 = document.createElement('img')
				el2.src='images/menos.png'
				el2.setAttribute('onclick','EliminaFila("'+ tbl.id +'", this), CalculaProd()')
				
				cell.appendChild(el1)
				cell.appendChild(el2)
				break
			case 1:
				if (tbl.id=='eventocorporativo'){
					var el3 = document.createElement('select')
					el3.name = NCampo(tabla)+'pv' + iteration
					el3.id = NCampo(tabla)+'pv' + iteration
					el3.setAttribute('onfocus','Proveedor(\''+NCampo(tabla)+'pv'+iteration+'\')')
					var opt = document.createElement('option')
					opt.value=0
					opt.text='--- Elija Proveedor ---'
					el3.appendChild(opt)
					cell.appendChild(el3)
				}
				break				
			case 2:
				el.name = NCampo(tabla)+'ds' + iteration
				el.id = NCampo(tabla)+'ds' + iteration
				el.size=40
				break
			case 3:
				el.name = NCampo(tabla)+'cn' + iteration
				el.id = NCampo(tabla)+'cn' + iteration
				el.setAttribute('onchange','CambiaEstado(\'pv'+iteration+'\', \''+NCampo(tabla)+'fl'+iteration+'\'), CalculaTotal(\''+NCampo(tabla)+'cn'+iteration+'\',\''+NCampo(tabla)+'dd'+iteration+'\',\''+NCampo(tabla)+'vu'+iteration+'\',\''+NCampo(tabla)+'vt'+iteration+'\' ), CalculaProd()')
				el.size=2
				break
			case 4:
				el.name = NCampo(tabla)+'dd' + iteration
				el.id = NCampo(tabla)+'dd' + iteration
				el.setAttribute('onchange','CalculaTotal(\''+NCampo(tabla)+'cn'+iteration+'\',\''+NCampo(tabla)+'dd'+iteration+'\',\''+NCampo(tabla)+'vu'+iteration+'\',\''+NCampo(tabla)+'vt'+iteration+'\' ), CalculaProd()')
				el.size=2
				break
			case 5:
				el.name = NCampo(tabla)+'vu' + iteration
				el.id = NCampo(tabla)+'vu' + iteration
				el.setAttribute('onchange','CalculaTotal(\''+NCampo(tabla)+'cn'+iteration+'\',\''+NCampo(tabla)+'dd'+iteration+'\',\''+NCampo(tabla)+'vu'+iteration+'\',\''+NCampo(tabla)+'vt'+iteration+'\' )')
				el.setAttribute('onblur','FormatoN(this), CalculaProd()')
				el.value=0
				el.size=15
				break
			case 6:
				el.name = NCampo(tabla)+'vt' + iteration
				el.id = NCampo(tabla)+'vt' + iteration
				el.setAttribute('onchange','CalculaTotal(\''+NCampo(tabla)+'cn'+iteration+'\',\''+NCampo(tabla)+'dd'+iteration+'\',\''+NCampo(tabla)+'vu'+iteration+'\',\''+NCampo(tabla)+'vt'+iteration+'\' )')
				el.size=15
				el.value=0
				el.readOnly=true
				break
		}
		if (i>=2) {
			cell.appendChild(el)
		}
	}
	document.getElementById(tot).value=iteration
}

function NuevaPersona(tabla) {
	var tbl = document.getElementById(tabla)
	var lastRow = tbl.rows.length
	var iteration = lastRow
	var row = tbl.insertRow(lastRow)
	var tot='tt'+tbl.id
	iteration-=3
	iteration++
	for (var i=0; i<=6;i++){
		var cell = row.insertCell(i)
		if (i>=3) {
			var el = document.createElement('input')
			el.type='text'
		}
		switch(i){
			case 0:
				var el1 = document.createElement('img')
				el1.src='images/mas.png'
				el1.setAttribute('onclick','NuevaPersona("'+ tbl.id +'")')
				
				var el2 = document.createElement('img')
				el2.src='images/menos.png'
				el2.setAttribute('onclick','EliminaFila("'+ tbl.id +'", this)')
				
				cell.appendChild(el1)
				cell.appendChild(el2)
				break
			case 1:
				var el = document.createElement('select')
				el.name = 'especiali' + iteration
				el.id = 'especiali' + iteration
				el.setAttribute('onfocus','Cargos(\'especiali'+iteration+'\')')
				el.setAttribute('onchange','Personas(\'especiali'+iteration+'\', \'npersonas'+iteration+'\')')
				var opt=document.createElement('option')
				opt.value=0
				opt.text='---  Elija Especialidad ---'
				el.appendChild(opt)
				break
			case 2:
				var el = document.createElement('select')
				el.name='npersonas'+iteration
				el.id='npersonas'+iteration
				el.setAttribute('onfocus','Personas(\'especiali'+iteration+'\', \'npersonas'+iteration+'\')')
				var opt=document.createElement('option')
				opt.value=0
				opt.text='---  Elija Profesional ---'
				el.appendChild(opt)
				break
			case 3:
				el.name = NCampo(tabla)+'cn' + iteration
				el.id = NCampo(tabla)+'cn' + iteration
				el.setAttribute('onchange','CalculaTotal(\'prcn'+iteration+'\',\'prdd'+iteration+'\',\'prvu'+iteration+'\',\'prvt'+iteration+'\' ), CalculaProd()')
				el.size=2
				break
			case 4:
				el.name = NCampo(tabla)+'dd' + iteration
				el.id = NCampo(tabla)+'dd' + iteration
				el.setAttribute('onchange','CalculaTotal(\'prcn'+iteration+'\',\'prdd'+iteration+'\',\'prvu'+iteration+'\',\'prvt'+iteration+'\' ), CalculaProd()')
				el.size=2
				break
			case 5:
				el.name = NCampo(tabla)+'vu' + iteration
				el.id = NCampo(tabla)+'vu' + iteration
				el.setAttribute('onchange','CalculaTotal(\'prcn'+iteration+'\',\'prdd'+iteration+'\',\'prvu'+iteration+'\',\'prvt'+iteration+'\' )')
				el.setAttribute('onblur','FormatoN(this), CalculaProd()')
				el.size=15
				break
			case 6:
				el.name = NCampo(tabla)+'vt' + iteration
				el.id = NCampo(tabla)+'vt' + iteration
				el.setAttribute('onchange','CalculaTotal(\'prcn'+iteration+'\',\'prdd'+iteration+'\',\'prvu'+iteration+'\',\'prvt'+iteration+'\' ), CalculaProd()')
				el.value=0
				el.size=15
				el.readOnly=true
				break
		}
		if (i>=1){
			cell.appendChild(el)
		}
	}
	document.getElementById(tot).value=iteration
}*/