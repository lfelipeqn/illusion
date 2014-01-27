function validarform(control, tipo){
	var cual = document.getElementById(control)
	switch(tipo){
		case 'usuario':
			if(cual.idusuario.value==''){
				alert('Ingrese un Nombre Unico de Usuario')
				return 0
			}

			if(cual.nusuario.value==''){
				alert('Por Favor registre el Nombre de la Persona')
					return 0
			}

			if(cual.nmail.value==''){
				alert('Por Favor Ingrese una Direccion de Correo Válida')
					return 0
			}

			if((cual.pass.value=='') || (cual.cpass.value=='')){
				alert('Debe registrar la Clave y Confirmación')
				return 0
			}
            
            if (cual.pass.value!=cual.cpass.value){
                alert('La Clave y Confirmacion NO Coinciden')
				return 0
            }
            
            if(cual.sgrupo.value==0){
				alert('Elija los Privilegios del Usuario')
				return 0
			}
            
			confirmar(control);
			break;
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