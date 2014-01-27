function validarform(control, tipo){
    var cual = document.getElementById(control)
	switch(tipo){
		case 'cliente':
			if(cual.nident.value==''){
				alert('Debe Registrar la Identificación del Cliente')
				return 0
			}

			if(cual.ncliente.value==''){
				alert('Debe Registrar El Nombre del Cliente')
					return 0
			}

			if(cual.ntelcont.value==''){
				alert('Debe Registrar El Telefono de Contacto')
					return 0
			}

			if(cual.nmail.value==''){
				alert('Debe Registrar El E-Mail del cliente')
					return 0
			}

			confirmar(control);
			break;
			
		case 'accliente':
			if(cual.nident.value==''){
				alert('Debe Registrar la Identificación del Cliente')
					return 0
			}

			if(cual.ncliente.value==''){
				alert('Debe Registrar El Nombre del Cliente')
					return 0
			}

			if(cual.ntelcont.value==''){
				alert('Debe Registrar El Telefono de Contacto')
					return 0
			}

			if(cual.nmail.value==''){
				alert('Debe Registrar El E-Mail del cliente')
					return 0
			}

			confirmar(control);
			break;

		case 'evento':
			if (cual.scliente.value==0){
				alert('Por Favor Elija el Cliente')
				return 0
			}

			if (cual.sproy.value==''){
				alert('Elija el Proyecto Correspondiente. Debe tener una cotizacion aprobada')
				return 0
			}

			if (cual.nhoras.value==''){
				alert('Debe Indicar la duración (En Horas) del Evento')
				return 0
			}

			confirmar(control)
			break;

		case 'proveedor':
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

			if ((cual.ntipop1.checked==false) && (cual.ntipop2.checked==false) && (cual.ntipop3.checked==false)){
				alert('Debe Elegir el Tipo de Proveedor')
				return 0
			}

			if ((cual.nfpago1.checked==false) && (cual.nfpago2.checked==false) && (cual.nfpago3.checked==false) && (cual.nfpago4.checked==false)){
				alert('Elija el Tiempo de Pago al proveedor')
				return 0
			}

			if ((cual.ndprontop1.checked==false) && (cual.ndprontop2.checked==false)){
				alert('Elija Si el Proveedor tiene Descuento por Pronto Pago')
				return 0
			}
			
			confirmar(control)
			break;
			
		case 'cotizacion':
			if (cual.scliente.value=='0'){
				alert('Elija el Cliente al que va dirigida la cotización')
				return 0
			}
            if (cual.sproy.value==''){
				alert('Elija el proyecto para la cotización')
				return 0
			}
			if ((cual.tipop.value=='') || (cual.tipop.value==0)){
				alert('Por Favor seleccione el tipo de precio que se aplicará a la cotización')
				return 0
			}
            if ((cual.tdias.value=='')||(cual.tdias.value==0)){
                alert('Por Favor los días del evento a incluir en la cotizacion')
				return 0
            }
            if (cual.nequipos.value<=1){
                alert('Incluya Equipos en la Cotizacion para continuar.')
				return 0
            }
			confirmar(control)
			break;
        case 'factura':
            if (cual.nevento.value==0){
                alert('Seleccione el Evento sobre el cual se generará la Factura.')
				return 0
            }
            if (cual.fvencimiento.value==""){
                alert('Seleccione la Fecha de Vencimiento de la Factura.')
				return 0
            }
            confirmar(control)
            break;
        case 'costos':
            if(cual.stipo.value==0){
                alert('Seleccion el Tipo de Proveedor')
				return 0
            }
            
            if(cual.sprov==0){
                alert('Seleccione el Proveedor')
				return 0
            }
            confirmar(control)
	}
}

function EnviaForm(control) {
	document.getElementById(control).submit();
}

function ValidaAccion(direccion){
	if(confirm("¿Está seguro de que desea Continuar?")){
		window.location=direccion;
	}else{
		alert('Ha Cancelado la Acción, No se Realizarán Cambios');
	}
}

function confirmar(control) {
    if (confirm ("¿Está seguro de que desea Continuar?")) {
        document.getElementById(control).submit();
    }
}