function EliminaFila(tabla,control, cuerpo){
  var tbl = document.getElementById(tabla)
  var cntr = control.parentNode.parentNode
  var lastRow = document.getElementById(cuerpo)
  var tot = document.getElementById('nequipos')
  
  if (lastRow.rows.length <= 1){
	  alert('No Puede Eliminar Esta Fila, Es la Ultima disponible')
  }else{
  
	  cntr.parentNode.removeChild(cntr);
	  var fila=1;
	  for (var i=0;i<lastRow.childNodes.length;i++){
		  var cloneNode = lastRow.childNodes.item(i)
		  for(var j=0;j<cloneNode.childNodes.length;j++){
			  var elm = cloneNode.childNodes.item(j)
			  var cn = elm.firstChild
			  if(cn.id!=''){
				  cn.id=SinNumero(cn.id)+fila
				  cn.name=SinNumero(cn.name)+fila
			  }
		  }
		  fila++
	  }
	  tot.value=lastRow.rows.length;
  }
}

function EliminaFilaC(tabla,control, cuerpo){
  var tbl = document.getElementById(tabla)
  var cntr = control.parentNode.parentNode
  var lastRow = document.getElementById(cuerpo)
  var tot = document.getElementById('nequipos')
  
  if (lastRow.rows.length <= 1){
	  alert('No Puede Eliminar Esta Fila, Es la Ultima disponible')
  }else{
        
      var cotiz = document.getElementById('tevento')
      var sumtot=NumNormal(cotiz.value)
      var campo=cntr.childNodes.item(1)
      var nombre = campo.childNodes.item(0).id
      var itemvalue='v'+nombre.substr(1)
      sumtot-=NumNormal(document.getElementById(itemvalue).value)
      cotiz.value='$ '+FormatoNum(sumtot)
  
	  cntr.parentNode.removeChild(cntr);
	  var fila=1;
	  for (var i=0;i<lastRow.childNodes.length;i++){
		  var cloneNode = lastRow.childNodes.item(i)
		  for(var j=0;j<cloneNode.childNodes.length;j++){
			  var elm = cloneNode.childNodes.item(j)
			  var cn = elm.firstChild
			  if(cn.id!=''){
				  cn.id=SinNumero(cn.id)+fila
				  cn.name=SinNumero(cn.name)+fila
			  }
		  }
		  fila++
	  }
	  tot.value=lastRow.rows.length;
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

function ConNumero(cad){
  var resultado=''
  if(cad.length>=1){
	  for (var i=0;i<cad.length;i++){
		  if ((cad.substr(i,1)==0) || (cad.substr(i,1)==1) || (cad.substr(i,1)==2) || (cad.substr(i,1)==3) || (cad.substr(i,1)==4) || (cad.substr(i,1)==5) || (cad.substr(i,1)==6) || (cad.substr(i,1)==7) || (cad.substr(i,1)==8) || (cad.substr(i,1)==9)) resultado+=cad.substr(i,1)
	  }
  }
  return resultado
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

function CambiaLogo(imag){
  var im = document.getElementById(imag)
  var sel = document.getElementById('sunidad').value
  switch (sel){
	  case '0':
		  im.src='images/eslini.jpg'
		  break;
	  case '1':
		  im.src='images/corporativo.png'
		  break;
	  case '2':
		  im.src='images/digital.png'
		  break;
	  case '3':
		  im.src='images/agora.png'
		  break;
	  case '4':
		  im.src='images/saxo.png'
		  break;
  }
}

function CambiaEstilo(control,tipo){
  var elm = document.getElementById(control)
  switch(tipo){
	  case 'inicio':
		  elm.innerHTML='<ul><li><a href="index.php">Cerrar Sesi&oacute;n</a></li><li><a href="rental.php?location=manual">Manual del Usuario</a></li></ul>';
		  break;	
	  case 'cliente':
		  elm.innerHTML='<ul><li><a href="rental.php?location=ncclie">Registrar Clientes</a></li><li><a href="rental.php?location=clclie">Consultar Clientes</a></li></ul>';
		  break;
	  case 'proveedor':
		  elm.innerHTML='<ul><li><a href="rental.php?location=nprov">Registrar Proveedor</a></li><li><a href="rental.php?location=cltprov">Consultar Proveedores</a></li><li><a href="rental.php?location=costprov">Costos Proveedores</a></li></ul>';
		  break;
	  case 'inventario':
		  elm.innerHTML='<ul><li><a href="rental.php?location=nequip">Adicionar Inventario</a></li><li><a href="rental.php?location=invt">Consultar Inventario</a></li></ul>';
		  break;
      case 'proyecto':
		  elm.innerHTML='<ul><li><a href="rental.php?location=nproy">Nuevo Proyecto</a></li><li><a href="rental.php?location=bproy">Consultar Proyectos</a></li></ul>';
		  break;
      case 'cotizacion':
		  elm.innerHTML='<ul><li><a href="rental.php?location=cotiz">Elaborar Cotizacion</a></li><li><a href="rental.php?location=buscotiz">Consultar Cotizacion</a></li><li><a href="rental.php?location=addconc">Adicionar Conceptos</a></li></ul>';
		  break;  
	  case 'evento':
		  elm.innerHTML='<ul><li><a href="rental.php?location=als">Registrar Evento</a></li><li><a href="rental.php?location=busevento">Consultar Eventos</a></li></ul>';
		  break;
	  case 'factura':
		  elm.innerHTML='<ul><li><a href="rental.php?location=genfact">Registrar Factura</a></li><li><a href="rental.php?location=cltfact">Consultar Factura</a></li></ul>';
		  break;	
  }
}

function NuevoElemento(e,control,precio){    
  var codigo = control.value
  var cotiz = document.getElementById('tevento')
  var sumtot=NumNormal(cotiz.value)
  var valor = codigo.substr(1)
  var regex = /\d{5,11}/
  var tipop=document.getElementById(precio).value
  var total=document.getElementById('nequipos')
  var bandera=false
  if (e.keyCode==13){
	  if (regex.test(valor)){
		  var fl = control.parentNode.parentNode
		  var bod = fl.parentNode
		  var indice = bod.rows.length+1
		  var xmlDoc=CargaXML('eventos/inventario.xml')

		  for (var k=0;k<xmlDoc.childNodes[0].childNodes.length;k++){
			  var idc = xmlDoc.childNodes[0].childNodes[k].attributes[0].nodeValue
			  if(idc==valor){
				  for (var x=1;x<total.value;x++){
					  var nombre = 'ceq'+x
					  var validar = document.getElementById(nombre).value
                      var verifica=validar.substr(1)
					  if(verifica==valor){
						  alert('El Elemento ya ha sido Cargado, No Puede Continuar')
						  control.value=''
						  return 0
					  }
				  }
				  if((tipop=='Alianza')||(tipop=='2')){
					  var vaplica = xmlDoc.childNodes[0].childNodes[k].attributes[2].nodeValue
				  }else{
					  var vaplica = xmlDoc.childNodes[0].childNodes[k].attributes[1].nodeValue
				  }
                  sumtot+=NumNormal(vaplica)
                  cotiz.value='$ '+FormatoNum(sumtot)
				  var nombre = utf8_decode(xmlDoc.childNodes[0].childNodes[k].firstChild.nodeValue)
				  var equipo = 'neq'+(indice-1)
				  var cobro = 'veq'+(indice-1)
				  document.getElementById(equipo).value=nombre
				  document.getElementById(cobro).value='$ '+FormatoNum(vaplica)
				  total.value++
				  bandera=true
			  }
		  }

		  if (bandera==false){
			  alert('El Codigo Capturado no Pertenece a algún elemento del Inventario. Por Favor verifique el codigo o cargue el Elemento en el Inventario antes de Continuar')
			  return 
		  }
		  
		  //var row = fl.parentNode.insertRow(fl)
		  var clone = fl.cloneNode(true)
		  for (var i=0;i<4;i++){
			  var nombre = NCampo(i)+'eq'+indice
			  var cloneNode = clone.childNodes[i]
			  var elm = cloneNode.childNodes.item(0)
			  if(i>0){ 
				  elm.id=nombre
				  elm.name=nombre
				  elm.value=''
			  }
		  }

		  bod.appendChild(clone)
		  var enfoque = clone.childNodes[1]
		  var campo = enfoque.childNodes[0].focus()
	  }
  }
}

function NCampo(i){
  var r = ''
  switch(i){
	  case 1:
		  r='c'
		  break;
	  case 2:
		  r='n'
		  break;
	  case 3:
		  r='v'
		  break
  }
  return r
}

function Alistamiento(e,control,precio,t){
  var codigo = control.value
  var valor = codigo.substr(1)
  var regex = /\d{5,11}/
  var tipop=document.getElementById(precio).value
  var total=document.getElementById('nequipos')
  var bandera=false
  if (e.keyCode==13){
	  if (regex.test(valor)){
		  var fl = control.parentNode.parentNode
		  var bod = fl.parentNode
		  var indice = bod.rows.length+1
		  var xmlDoc=CargaXML('eventos/inventario.xml')

		  for (var k=0;k<xmlDoc.childNodes[0].childNodes.length;k++){
			  var idc = xmlDoc.childNodes[0].childNodes[k].attributes[0].nodeValue
			  if(idc==valor){
					  for (var x=1;x<total.value;x++){
						  var nombre = 'ceq'+x
						  var validar = document.getElementById(nombre).value
						  if(validar==valor){
							  alert('El Elemento ya ha sido Cargado, No Puede Continuar')
							  control.value=''
							  return 0
						  }
					  }
					  var estado = xmlDoc.childNodes[0].childNodes[k].attributes[3].nodeValue
					  if (t=='Salida'){
						  if(estado=='Mantenimiento'){
							  alert('El Equipo seleccionado se Encuentra en mantenimiento. No puede continuar')
							  control.value=''
							  return 0
						  }else if(estado=='Salida'){
							  alert('El Equipo Aparece registrado en Un Evento. No estara Disponible hasta tanto se registre la entrada de equipos del evento correspondiente')
							  control.value=''
							  return 0
						  }else{
							  if((tipop=='Alianza')||(tipop=='2')){
								  var vaplica = xmlDoc.childNodes[0].childNodes[k].attributes[2].nodeValue
							  }else{
								  var vaplica = xmlDoc.childNodes[0].childNodes[k].attributes[1].nodeValue
							  }
						  }
					  }else{
						  if((tipop=='Alianza')||(tipop=='2')){
							  var vaplica = xmlDoc.childNodes[0].childNodes[k].attributes[2].nodeValue
						  }else{
							  var vaplica = xmlDoc.childNodes[0].childNodes[k].attributes[1].nodeValue
						  }
					  }
  
					  var nombre = utf8_decode(xmlDoc.childNodes[0].childNodes[k].firstChild.nodeValue)
					  var equipo = 'neq'+(indice-1)
					  var cobro = 'veq'+(indice-1)
					  document.getElementById(equipo).value=nombre
					  document.getElementById(cobro).value='$ '+FormatoNum(vaplica)
					  total.value++
					  bandera=true
			  }
		  }

		  if (bandera==false){
			  alert('El Codigo Capturado no Pertenece a algún elemento del Inventario. Por Favor verifique el codigo o cargue el Elemento en el Inventario antes de Continuar')
			  return 
		  }

		  //var row = fl.parentNode.insertRow(fl)
		  var clone = fl.cloneNode(true)
          for (var i=0;i<4;i++){
			  var nombre = NCampo(i)+'eq'+indice
			  var cloneNode = clone.childNodes[i]
			  var elm = cloneNode.childNodes.item(0)
			  if(i>0){ 
				  elm.id=nombre
				  elm.name=nombre
				  elm.value=''
			  }
		  }

		  bod.appendChild(clone)
		  var enfoque = clone.childNodes[1]
		  var campo = enfoque.childNodes[0].focus()
	  }
  }
}

function EligeProveedor(origen, destino){
    var inicio = document.getElementById(origen)
    var fin = document.getElementById(destino)
    
    while ( fin.childNodes.length >= 1 ){
	  fin.removeChild( fin.firstChild )
    } 
    var cero = document.createElement('option')
    cero.value='0'
    cero.text='--- Elija el Proveedor ---'
    fin.appendChild(cero)
    
    var xmlDoc=CargaXML('proveedores/proveedores.xml')
    for (var i=0;xmlDoc.childNodes[0].childNodes.length;i++){
 	  var tipoprov = xmlDoc.childNodes[0].childNodes[i].attributes[1].nodeValue
 	  if(tipoprov==inicio.value){
		  var idc = xmlDoc.childNodes[0].childNodes[i].attributes[0].nodeValue
		  var nombre = xmlDoc.childNodes[0].childNodes[i].attributes[3].nodeValue
		  var opcion = document.createElement('option')
		  opcion.value=idc
		  opcion.text=nombre
		  fin.appendChild(opcion)	
 	  }
    }   
}

function CambiaLista(control, destino, especialidad, valor){
  var tipo = document.getElementById(control)
  var lista = document.getElementById(destino)
  var espec = document.getElementById(especialidad)
  var precio = document.getElementById(valor)
  
  while ( lista.childNodes.length >= 1 ){
	  lista.removeChild( lista.firstChild )
  } 
  var cero = document.createElement('option')
  cero.value='0'
  cero.text='--- Elija un Proveedor ---'
  lista.appendChild(cero)
  
  while ( espec.childNodes.length >= 1 ){
	  espec.removeChild( espec.firstChild )
  } 
  var cero = document.createElement('option')
  cero.value='0'
  cero.text='--- Elija Nivel ---'
  espec.appendChild(cero)
  
  precio.value=' $ '+FormatoNum(0)
  
  var xmlDoc=CargaXML('eventos/proveedores.xml')
  for (var i=0;xmlDoc.childNodes[0].childNodes.length;i++){
	  var tipoprov = xmlDoc.childNodes[0].childNodes[i].attributes[1].nodeValue
	  if(tipoprov==tipo.value){
		  var idc = xmlDoc.childNodes[0].childNodes[i].attributes[0].nodeValue
		  var nombre = xmlDoc.childNodes[0].childNodes[i].attributes[3].nodeValue
		  var opcion = document.createElement('option')
		  opcion.value=idc
		  opcion.text=nombre
		  lista.appendChild(opcion)	
	  }
  }
}

function CargaNivel(control, destino,valor){
  var origen=document.getElementById(control)
  var lista = document.getElementById(destino)
  var precio = document.getElementById(valor)
  precio.value=' $ '+FormatoNum(0)
  while ( lista.childNodes.length >= 1 ){
	  lista.removeChild( lista.firstChild )
  } 
  var cero = document.createElement('option')
  cero.value='0'
  cero.text='--- Elija Nivel ---'
  lista.appendChild(cero)
  if (control.value!=0){
	  var xmlDoc=CargaXML('eventos/niveles.xml')
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

function ValorProv(tipo, control, destino, supplier){
  var tipop=document.getElementById(tipo)
  var origen=document.getElementById(control)
  var lista=document.getElementById(destino)
  var horas=document.getElementById('horas')
  var prov=document.getElementById(supplier)
  
  
  var xmlDoc=CargaXML('eventos/costos.xml')
  for (var i=0;xmlDoc.childNodes[0].childNodes.length;i++){
	  var idnivel = xmlDoc.childNodes[0].childNodes[i].attributes[0].nodeValue
      var nnivel = xmlDoc.childNodes[0].childNodes[i].attributes[1].nodeValue
      var idtipo = xmlDoc.childNodes[0].childNodes[i].attributes[2].nodeValue
      var ntipo = xmlDoc.childNodes[0].childNodes[i].attributes[3].nodeValue
      var mediaj = xmlDoc.childNodes[0].childNodes[i].attributes[4].nodeValue
      var jornada = xmlDoc.childNodes[0].childNodes[i].attributes[5].nodeValue
      var extendida = xmlDoc.childNodes[0].childNodes[i].attributes[6].nodeValue
      var adic = xmlDoc.childNodes[0].childNodes[i].attributes[7].nodeValue
      var adicnoche = xmlDoc.childNodes[0].childNodes[i].attributes[8].nodeValue
      var idproveedor = xmlDoc.childNodes[0].childNodes[i].attributes[9].nodeValue
      
	  if ((idnivel==origen.value)&&(idtipo==tipop.value)){
        var valor=0
        if((idtipo!=2)&&(idtipo!=5)&&(idproveedor==prov.value)){
            if ((horas.value>0) && (horas.value<=6)) valor=mediaj 
            if ((horas.value>6) && (horas.value<=8)) valor=jornada
            if ((horas.value>8) && (horas.value<=12)) valor=extendida
            if ((horas.value>12) && (horas.value<=18)) {
                var diferencia
                diferencia=horas.value-12
                valor=extendida+(adic*diferencia)        
            }
            if (horas.value>18){
                var diferencia
                diferencia=horas.value-18
                valor=extendida+(6*adic)+(adicnoche*diferencia)
            }
            lista.value= ' $ '+FormatoNum(valor)
            return 0       
        }else{
            if ((horas.value>0) && (horas.value<=6)) valor=mediaj 
            if ((horas.value>6) && (horas.value<=8)) valor=jornada
            if ((horas.value>8) && (horas.value<=12)) valor=extendida
            if ((horas.value>12) && (horas.value<=18)) {
                var diferencia
                diferencia=horas.value-12
                valor=extendida+(adic*diferencia)        
            }
            if (horas.value>18){
                var diferencia
                diferencia=horas.value-18
                valor=extendida+(6*adic)+(adicnoche*diferencia)
            }
            lista.value= ' $ '+FormatoNum(valor)
            return 0
        }
	  }
     lista.value=' $ '+FormatoNum(0)
  }
}

function ValorProvC(control, destino){
  var origen=document.getElementById(control)
  var lista = document.getElementById(destino)
  var total = document.getElementById('tevento')
  var subt = NumNormal(total.value)
  var xmlDoc=CargaXML('eventos/niveles.xml')
  for (var i=0;xmlDoc.childNodes[0].childNodes.length;i++){
	  var idc = xmlDoc.childNodes[0].childNodes[i].attributes[0].nodeValue
	  if (idc==origen.value){
		  lista.value= ' $ '+FormatoNum(xmlDoc.childNodes[0].childNodes[i].attributes[2].nodeValue)
          subt+=NumNormal(lista.value)
          total.value='$ '+FormatoNum(subt)
		  return 0
	  }else{
		  lista.value=' $ '+FormatoNum(0)
	  }
  }
}

function NuevoProveedor(tabla, fila) {
  var tbl = document.getElementById(tabla)
  var fl = fila.parentNode.parentNode
  var bod = fl.parentNode
  var indice = bod.rows.length+1
  //var row = fl.parentNode.insertRow(fl)
  var tot='npersona'
  var clone = fl.cloneNode(true)
  //clone.id=NCampo(tabla)+'fl'+indice
  for (var i=0;i<=5;i++){
	  var cloneNode = clone.childNodes[i]
	  var elm = cloneNode.childNodes[0]
	  if(elm.id!=''){
		   elm.id=SinNumero(elm.id)+indice
		   elm.name=SinNumero(elm.id)+indice
		   switch (i){
			   case 2:
				  elm.setAttribute("onchange","CambiaLista(\'tipop"+indice+"\', \'prov"+indice+"\',\'esp"+indice+"\',\'val"+indice+"\')")
				  break;
			   case 3:
				  elm.setAttribute("onchange","CargaNivel(\'prov"+indice+"\', \'esp"+indice+"\',\'val"+indice+"\')")
				  break;
			   case 4:
				  elm.setAttribute("onchange","ValorProv(\'tipop"+indice+"\', \'esp"+indice+"\', \'val"+indice+"\', \'prov"+indice+"\')")
				  break;
		   }
	  }
  }
  bod.appendChild(clone)	
  document.getElementById(tot).value=indice
}

function NuevoProveedorC(tabla, fila) {
  var tbl = document.getElementById(tabla)
  var fl = fila.parentNode.parentNode
  var bod = fl.parentNode
  var indice = bod.rows.length+1
  //var row = fl.parentNode.insertRow(fl)
  var tot='npersona'
  var clone = fl.cloneNode(true)
  //clone.id=NCampo(tabla)+'fl'+indice
  for (var i=0;i<=4;i++){
	  var cloneNode = clone.childNodes[i]
	  var elm = cloneNode.childNodes[0]
	  if(elm.id!=''){
		   elm.id=SinNumero(elm.id)+indice
		   elm.name=SinNumero(elm.id)+indice
		   switch (i){
		      case 3:
			     elm.setAttribute("onchange","ValorProvC(\'esp"+indice+"\', \'val"+indice+"\')")
			     break;
              case 4:
                 elm.value='0'
                 break;
		   }
	  }
  }
  bod.appendChild(clone)	
  document.getElementById(tot).value=indice
}

function EliminaProveedor(tabla,control, cuerpo, total){
  var tbl = document.getElementById(tabla)
  var cntr = control.parentNode.parentNode
  var lastRow = document.getElementById(cuerpo)
  var tot = document.getElementById(total)

  if (lastRow.rows.length <= 1){
	  alert('No Puede Eliminar Esta Fila, Es la Ultima disponible')
  }else{
	  cntr.parentNode.removeChild(cntr);
	  var fila=0;
	  for (var i=0;i<lastRow.childNodes.length;i++){
		  var cloneNode = lastRow.childNodes.item(i)
		  for(var j=0;j<cloneNode.childNodes.length;j++){
			  var elm = cloneNode.childNodes.item(j)
			  var cn = elm.firstChild
			  if(cn.id!=''){
				  cn.id=SinNumero(cn.id)+fila
				  cn.name=SinNumero(cn.name)+fila
				  switch (j){
					   case 2:
						  cn.setAttribute("onchange","CambiaLista(\'tipop"+fila+"\', \'prov"+fila+"\',\'esp"+fila+"\',\'val"+fila+"\')")
						  break;
					   case 3:
						  cn.setAttribute("onchange","CargaNivel(\'prov"+fila+"\', \'esp"+fila+"\',\'val"+fila+"\')")
						  break;
					   case 4:
						  cn.setAttribute("onchange","ValorProv(\'esp"+fila+"\', \'val"+fila+"\')")
						  break;
				   }
			  }
		  }
		  fila++
	  }
	  tot.value=lastRow.rows.length;
  }
}

function EliminaProveedorC(tabla,control, cuerpo, total){
  var tbl = document.getElementById(tabla)
  var cntr = control.parentNode.parentNode
  var lastRow = document.getElementById(cuerpo)
  var tot = document.getElementById(total)
  
  
  if (lastRow.rows.length <= 1){
	  alert('No Puede Eliminar Esta Fila, Es la Ultima disponible')
  }else{
      var cotiz = document.getElementById('tevento')
      var sumtot=NumNormal(cotiz.value)
      var campo=cntr.childNodes.item(4)
      var nombre = campo.childNodes.item(0).id
      var itemvalue='val'+nombre.substr(3)
      sumtot-=NumNormal(document.getElementById(itemvalue).value)
      cotiz.value='$ '+FormatoNum(sumtot)

	  cntr.parentNode.removeChild(cntr);
	  var fila=0;
	  for (var i=0;i<lastRow.childNodes.length;i++){
		  var cloneNode = lastRow.childNodes.item(i)
		  for(var j=0;j<cloneNode.childNodes.length;j++){
			  var elm = cloneNode.childNodes.item(j)
			  var cn = elm.firstChild
			  if(cn.id!=''){
				  cn.id=SinNumero(cn.id)+fila
				  cn.name=SinNumero(cn.name)+fila
				  switch (j){
					   case 2:
						  cn.setAttribute("onchange","CambiaLista(\'tipop"+fila+"\', \'prov"+fila+"\',\'esp"+fila+"\',\'val"+fila+"\')")
						  break;
					   case 3:
						  cn.setAttribute("onchange","CargaNivel(\'prov"+fila+"\', \'esp"+fila+"\',\'val"+fila+"\')")
						  break;
					   case 4:
						  cn.setAttribute("onchange","ValorProv(\'esp"+fila+"\', \'val"+fila+"\')")
						  break;
				   }
			  }
		  }
		  fila++
	  }
	  tot.value=lastRow.rows.length;
  }
}

function ValDescuento(cotizacion){
    var ds=document.getElementById('sdesc'+cotizacion)
    var ln=document.getElementById('desc'+cotizacion)
    var cadena='cotizaciones/aplicadescuento.php?seguimiento='+cotizacion+'&descuento='+ds.value
    ln.href=cadena
    
}