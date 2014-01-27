function Pago(valor, origen,destino){
	var pres = NumNormal(document.getElementById(valor).value)
	var actual=document.getElementById(origen).value
	var real = document.getElementById(destino)
	real.value='$ '+FormatoNum(pres*(actual/100))
}

function Contenido(elm){
	var lista = document.getElementById(elm)
	if (lista.childNodes.length<=1){
		var xmlDoc=CargaXML('negocios.xml')
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
	
	document.getElementById('plugar').value=''
	document.getElementById('nnit').value=''
	document.getElementById('ndv').value=''
	document.getElementById('pptipoe').value=''
	document.getElementById('mailn').value=''
	
	
	var xmlDoc=CargaXML('negocios.xml')
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
			cero.id='0'
			cero.text='-- Elija un Proyecto --'
			dest.appendChild(cero)
			for (var j=0; cliente.childNodes.length;j++){
				var ip = cliente.childNodes[j].attributes[0].nodeValue
				var np = utf8_decode(cliente.childNodes[j].attributes[4].nodeValue)
				var opcion = document.createElement('option')
				opcion.value=ip
				opcion.text=np
				dest.appendChild(opcion)
			}
		}		
	}
}
	
function DProyecto(origen){
	var cual=document.getElementById(origen)
	document.getElementById('plugar').value=''
	document.getElementById('mailn').value=''

	var xmlDoc=CargaXML('proyectos.xml')

	for (var i=0;i<=xmlDoc.childNodes[0].childNodes.length;i++){
		var proyecto = xmlDoc.childNodes[0].childNodes[i]
		var idp = proyecto.attributes[0].nodeValue
		if(cual.value==idp){
				document.getElementById('plugar').value=proyecto.attributes[1].nodeValue
				document.getElementById('mailn').value=proyecto.attributes[3].nodeValue
				var tpres = proyecto.childNodes.length
				if (tpres<=0){
					document.getElementById('consp').value=0
					document.getElementById('totp').value=0
					document.getElementById('porcpago').value='0 %'
					document.getElementById('tienepres').value=0
					alert('Este Proyecto No Tiene Presupuestos Aprobados')
				}else{
				var presupuesto = proyecto.childNodes[0]
				document.getElementById('consp').value=presupuesto.attributes[8].nodeValue
				document.getElementById('totp').value='$ '+FormatoNum(presupuesto.attributes[7].nodeValue)
				document.getElementById('tienepres').value=1
				}
		}
	}
}