function stopRKey(evt) {
    var evt = (evt) ? evt : ((event) ? event : null);
    var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
    if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}

document.onkeypress = stopRKey;

function confirmar(control) {
    if (confirm ("¿Está seguro de que desea Continuar?")) {        
        document.getElementById(control).submit()
    }
}

function FAction(url){
	document.reportes.action=url
}

function EnviaForm(control) {
	document.getElementById(control).submit()
}

function ValidaAccion(direccion){
	if(confirm("¿Está seguro de que desea Continuar?")){
		window.location=direccion
	}else{
		alert('Ha Cancelado la Acción, No se Realizarán Cambios')
	}
}

function validarform(control, tipo){
	var cual = document.getElementById(control)
	switch(tipo){
		case 'cliente':
			if(cual.ncliente.value==''){
				alert('Debe Registrar El Nombre del Cliente')
				return 0
			}

			if((!cual.ntempresa1.checked)&&(!cual.ntempresa2.checked)&&(!cual.ntempresa3.checked)){
				alert('Debe Elegir el Tipo de Cliente')
				return 0
			}

			if(cual.nident.value==''){
				alert('Debe Registrar la Identificación del Cliente')
				return 0
			}

			if(cual.ntelcont.value==''){
				alert('Debe Registrar El Telefono de Contacto')
				return 0
			}

			if(cual.nmail.value==''){
				alert('Debe Registrar El E-Mail Corporativo')
				return 0
			}

			if(cual.ndir.value==''){
				alert('Debe Registrar la Dirección')
				return 0
			}

			confirmar(control)
			break

		case 'proveedor':
            if ((cual.ntpersona1.checked==false) && (cual.ntpersona2.checked==false)){
				alert('Debe Elegir el Tipo de Persona')
				return 0
			}

			if (cual.nproveedor.value==''){
				alert('Debe Incluir el Nombre de Proveedor')
				return 0
			}

			if (cual.tipoi.value==0){
				alert('Seleccione el Tipo de Identificación')
				return 0
			}

			if (cual.nnit.value==0){
				alert('El Número de Identificación es Requerido')
				return 0
			}

			if (cual.nciudad.value==0){
				alert('Ingrese la Ciudad')
				return 0
			}

			if (cual.npais.value==0){
				alert('Ingrese el País')
				return 0
			}

			if (cual.ndir.value==0){
				alert('Debe Ingresar una Dirección Válida')
				return 0
			}

			if (cual.ntel.value==0){
				alert('Registro el Número de Teléfono')
				return 0
			}

			if (cual.ncorreo.value==0){
				alert('Ingrese una Dirección de Correo Electrónico')
				return 0
			}

			if ((cual.ntcontrib1.checked==false) && (cual.ntcontrib2.checked==false)){
				alert('Es Gran Contribuyente ?')
				return 0
			}

			if ((cual.niva1.checked==false) && (cual.niva2.checked==false)){
				alert('Es Responsable de IVA ?')
				return 0
			}

			if ((cual.naret1.checked==false) && (cual.naret2.checked==false)){
				alert('Es Autoretenedor ?')
				return 0
			}

			if ((cual.nica1.checked==false) && (cual.nica2.checked==false)){
				alert('Es responsable de ICA ?')
				return 0
			}

			if(cual.tiva.value==''){
				alert('Ingrese El Porcentaje de IVA')
				return 0	
			}
			if(cual.triva.value==''){
				alert('Ingrese El Porcentaje ReteIva')
				return 0		
			}
            
			if(cual.trica.value==''){
				alert('Ingrese El Porcentaje ReteIca')
				return 0
			}

			if(cual.trfte.value==''){
				alert('Ingrese El Porcentaje ReteFuente')
				return 0
			}

			if (cual.ncodac.value==''){
				alert('Ingrese El Código de Actividad Económica')
				return 0
			}

			if (cual.nactiv.value==''){
				alert('Ingrese la Actividad Económica')
				return 0
			}

			if (cual.nciiu.value==''){
				alert('Ingrese El Código CIIU')
				return 0
			}

			if (cual.nciiu.value==''){
				alert('Ingrese El Código CIIU')
				return 0
			}

			if (cual.ntarifa.value==''){
				alert('Ingrese El Valor de Tarifa x 1000')
				return 0

			}

			
			if ((cual.nmedio1.checked==false) && (cual.nmedio2.checked==false)){
				alert('Debe Elegir el Medio de Pago')
				return 0
			}

			if (cual.nmedio1.checked==true){
				if (cual.ncuenta.value==''){
					alert('Ingrese el Numero de Cuenta Bancaria')
					return 0
				}

				if ((cual.ntipoc1.checked==false) && (cual.ntipoc2.checked==false)){
					alert('Seleccione el Tipo de Cuenta Bancaria')
					return 0
				}

				if (cual.nentidad.value==''){
					alert('Digite el Nombre de la Entidad Bancaria')
					return 0
				}
			}else if(cual.nmedio2.checked==true){
				if (cual.ncheque.value==''){
					alert('Ingrese el Nombre para los Cheques')
					return 0
				}
			}

			if (cual.npcontacto.value==0){
				alert('Ingrese el Nombre del Contacto para Pagos')
				return 0
			}

			if ((cual.ntipop1.checked==false) && (cual.ntipop2.checked==false) && (cual.ntipop3.checked==false)&& (cual.ntipop4.checked==false)&& (cual.ntipop5.checked==false)&& (cual.ntipop6.checked==false)&& (cual.ntipop7.checked==false)&& (cual.ntipop8.checked==false)&& (cual.ntipop9.checked==false)){
				alert('Debe Elegir el Tipo de Proveedor')
				return 0
			}

			if ((cual.nfpago1.checked==false) && (cual.nfpago2.checked==false) && (cual.nfpago3.checked==false) && (cual.ofpago.value=='')){
				alert('Elija el Tiempo de Pago al proveedor')
				return 0
			}

			if ((cual.ndprontop1.checked==false) && (cual.ndprontop2.checked==false)){
				alert('Elija Si el Proveedor tiene Descuento por Pronto Pago')
				return 0
			}
			confirmar(control)
			break

		case 'proyecto':
			if (cual.scliente.value==0){
			     alert('Debe Elegir Cliente del Proyecto')
			     return 0
			}

			if (cual.nproy.value==''){
			     alert('Debe Registrar El Nombre del Proyecto')
			     return 0
			}

			if (cual.ncontac.value==''){
			     alert('Debe Registrar el Nombre del Contacto')
			     return 0
			}

			if (cual.ntelcontac.value==''){
                alert('Debe Registrar El Teléfono del Contacto')
                return 0
			}

			if (cual.nmail.value==''){
			     alert('Debe Registrar la(s) Ciudad(es)')
			     return 0
			}

			if (cual.ncity.value==''){
				alert('Debe Registrar la Ciudad del Evento')
				return 0
			}

			if (cual.nlugar.value==''){
				alert('Debe Registrar El lugar del Evento')
				return 0
			}

			if (cual.nfechae.value==''){
				alert('Debe Registrar La Fecha del Evento')
				return 0
			}

			if (cual.nfecham.value==''){
				alert('Debe Registrar La Fecha de Montaje')
				return 0
			}

			if (cual.nfechad.value==''){
				alert('Debe Registrar La Fecha de Desmontaje')
				return 0
			}

			var fechae = new Date(cual.nfechae.value)
			var fecham = new Date(cual.nfecham.value)
			var fechad = new Date(cual.nfechad.value)

			if(fecham>fechad){
				alert('La Fecha de Desmontaje no puede ser Inferior a la de Montaje')
				return 0
			}

			if((fechae<fecham)||(fechae>fechad)){
				alert('La Fecha del Evento no es consistente con las fechas Montaje / Desmontaje')
				return 0
			}
			confirmar(control)
			break

		case 'mproyecto':
			if (cual.nproy.value==''){
					alert('Debe Registrar El Nombre del Proyecto')
					return 0
			}

			if (cual.ncontac.value==''){
				alert('Debe Registrar el Nombre del Contacto')
				return 0
			}

			if (cual.ntelcontac.value==''){
				alert('Debe Registrar El Teléfono del Contacto')
				return 0
			}

			if (cual.nmail.value==''){
				alert('Debe Registrar la(s) Ciudad(es)')
				return 0
			}

			if (cual.ncity.value==''){
				alert('Debe Registrar la Ciudad del Evento')
				return 0
			}

			if (cual.nlugar.value==''){
				alert('Debe Registrar El lugar del Evento')
				return 0
			}

			if (cual.nfechae.value==''){
    			alert('Debe Registrar La Fecha del Evento')
    			return 0
			}
			confirmar(control)
			break

		case 'presupuesto':
				/*if (cual.pppresentado.value==0){
					alert('Debe Registrar El Nombre de Quien Presenta el Presupuesto')
					return 0
				}*/

				/*if(cual.fpresenta.value==''){
					alert('Debe Ingresar la fecha de Presentacion')
					return 0
				}*/

				/*if(cual.pppres.value==0){
					alert('Debe Elegir el Consecutivo del Presupuesto')
					return 0
				}

				if(cual.ppvers.value==0){
					alert('Debe Elegir el Consecutivo de la Versión')
					return 0
				}*/

				if(cual.ncliente.value==0){
					alert('Debe Elegir el Cliente')
					return 0
				}

				if(cual.pproy.value==0){
					alert('Debe Elegir el Proyecto')
					return 0
				}

				if(NumNormal(cual.knh.value)==0){
					alert('Se Requiere el Valor del Know How')
					return 0
				}

				if(NumNormal(cual.stp.value)==0){
					alert('Debe Elegir Calcular el Subtotal del Proyecto')
					return 0
				}

				if(NumNormal(cual.stds.value)==0){
					alert('Debe Calcular el Subtotal con Descuento')
					return 0
				}
			confirmar(control)
			break

		case 'negocio':
			if (cual.tienepres.value==0){
				alert('Este Proyecto No Tiene Presupuestos Aprobados')
				return 0
			}

			if(cual.ncliente.value==0){
				alert('Debe Elegir el Cliente')
				return 0
			}

			if(cual.pproy.value==0){
				alert('Debe Elegir el Proyecto')
				return 0
			}

			if(NumNormal(cual.totp.value)==0){
				alert('El presupuesto no tiene Valor')
				return 0
			}

			if((!cual.nplazon1.checked)&&(!cual.nplazon2.checked)&&(!cual.nplazon3.checked)&&(!cual.nplazon4.checked)&&(!cual.nplazon5.checked)){
				alert('Debe Elegir el Plazo de Pago')
				return 0
			}

			if((cual.padm.value==0)&&(cual.pdg.value==0)&&(cual.pbm.value==0)){
				alert('Por Favor revise el valor de las Comisiones')
				return 0
			}

			confirmar(control)
			break

		case 'asigna':
			if(cual.sprod.value==0){
				alert('Debe Asignar el Productor')
				return 0	
			}
			confirmar(control)
			break

		case 'produccion':
			confirmar(control)
			break

		case 'compra':
			SumaMonedas('reteiva', 'reteica', 'retefte', 'reten')
			ValorNeto('totord', 'totiva', 'reten', 'neto')
			if((!cual.plpago1.checked) && (!cual.plpago2.checked) && (!cual.plpago3.checked) && (!cual.plpago4.checked) && (!cual.plpago5.checked) && (!cual.plpago6.checked)){
				alert('Debe Elegir el plazo de Pago')
				return 0
			}
			confirmar(control)
			break

		case 'inicio':
			if(cual.usuario.value==''){
				alert('Digite su Nombre de Usuario')
				return 0
			}

			if(cual.password.value==''){
				alert('Ingrese su Contraseña')
				return 0
			}

			if(cual.sunidad.value==''){
				alert('Por Favor Seleccione la Unidad de Negocio')
				return 0
			}
			EnviaForm(control)
			break;

		case 'factura':
			var fechae=new Date(cual.femi.value)
			var fechav=new Date(cual.fven.value)
			if((cual.nfact.value=='')||(cual.nfact.value==0)){
				alert('Debe registrar el Numero de Factura')
				return 0
			}

			if((fechae=='Invalid Date')||(fechav=='Invalid Date')){
				alert('Debe registrar las Fecha de Vencimiento y Emisión')
				return 0
			}

			if(fechae>=fechav){
				alert('La fecha de Vencimiento No puede ser inferior a la fecha de Emisión')
				return 0
			}

			if((cual.ncliente.value==0)||(cual.pproy.value==0)){
				alert('Debe Seleccionar un cliente y un proyecto Validos')
				return 0
			}

			if((cual.subt.value==0)||(cual.subt.value=='')){
				alert('Debe Ingresar el valor del Subtotal')
				return 0
			}

			if((cual.iva.value==0)||(cual.iva.value=='')){
				alert('Debe Ingresar el valor del IVA')
				return 0
			}

			if((cual.tot.value==0)||(cual.tot.value=='')){
				alert('Debe Ingresar el valor del Total')
				return 0
			}
			confirmar(control)
			break;
	}
}

function Verifica(control){
	var cnt = document.getElementById(control)
	var digit = document.getElementById('ndigit')
	if (cnt.value=='3'){
		digit.value=""
		digit.disabled=true
	}else{
		if (digit.value!=''){
			digit.disabled=false
		}else{
			digit.value=""
			digit.disabled=false
		}
	}
}

function ValidaPago(control){
	var cnt = document.getElementById(control)
	var cheque = document.getElementById('ncheque')
	var ahorro = document.getElementById('ntipoc1')
	var corriente = document.getElementById('ntipoc2')
	var cuenta = document.getElementById('ncuenta')
	var banco = document.getElementById('nentidad')

	if (cnt.value=='1'){
		cheque.value=""
		cheque.disabled=true
		ahorro.disabled=false
		corriente.disabled=false
		cuenta.value=""
		cuenta.disabled=false
		banco.disabled=false
	}else{
		cheque.value=""
		cheque.disabled=false
		ahorro.disabled=true
		corriente.disabled=true
		cuenta.value=""
		cuenta.disabled=true
		banco.disabled=true
	}
}

function OtroPago(){
	var op1 = document.getElementById('nfpago1')
	var op2 = document.getElementById('nfpago2')
	var op3 = document.getElementById('nfpago3')
	
	op1.checked=false
	op2.checked=false
	op3.checked=false
}

function PagoNormal(){
	var op1 = document.getElementById('ofpago')	
	op1.value=""
}

// Funciones de Control de Negocios

function Habilitar(control){
	var cnt=document.getElementById(control)
	if (cnt.checked){
		document.formingreso.nantic.disabled=false
	}else{
		document.formingreso.nantic.disabled=true
		document.formingreso.vanicipo.value=0
	}
}

function CalculaPorcentaje(compra,valor, resultado){
	var cm = NumNormal(document.getElementById(compra).value)
	var vl = document.getElementById(valor).value
	var res = document.getElementById(resultado)
	
	res.value='$ '+FormatoNum((cm*vl)/100)
}