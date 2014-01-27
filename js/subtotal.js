function CalculaTotal(cant, dias, vunit, vtotal) {
		var n1=NumNormal(document.getElementById(cant).value)
		var n2=NumNormal(document.getElementById(dias).value)
		var n3=NumNormal(document.getElementById(vunit).value)
		var res
		res=n1*n2*n3
		var resul= new oNumero(res)
		document.getElementById(vtotal).value=resul.formato(2,true)
}

function CalculaST(){
	var st1=0
	var st2=0
	var st3=0
	var st4=0
	var filast11=document.getElementById('tteventmark').value
	var filast12=document.getElementById('ttrentsupp').value
	var filast21=document.getElementById('ttvideohd3d').value
	var filast22=document.getElementById('ttkeynote').value
	var filast23=document.getElementById('ttvisualex').value
	var filast24=document.getElementById('ttbranding').value
	var filast31=document.getElementById('ttperformance').value
	var filast32=document.getElementById('ttmanagement').value
	var filast33=document.getElementById('ttown').value
	var filast41=document.getElementById('ttproduccion').value
	
	for (var i=1;i<=4;i++){
		switch(i){
			case 1:
					for(var j=1;j<=filast11;j++){
						var filat = NCampo('eventmark')+'vt'+j
						var valor = NumNormal(document.getElementById(filat).value)
						st1+=valor
					}
					for(var k=1;k<=filast12;k++){
						var filat = NCampo('rentsupp')+'vt'+k
						var valor = NumNormal(document.getElementById(filat).value)
						st1+=valor
					}
				break;
			case 2:
					for(var j=1;j<=filast21;j++){
						var filat = NCampo('videohd3d')+'vt'+j
						var valor = NumNormal(document.getElementById(filat).value)
						st2+=valor
					}
					for(var k=1;k<=filast22;k++){
						var filat = NCampo('keynote')+'vt'+k
						var valor = NumNormal(document.getElementById(filat).value)
						st2+=valor
					}
					for(var l=1;l<=filast23;l++){
						var filat = NCampo('visualex')+'vt'+l
						var valor = NumNormal(document.getElementById(filat).value)
						st2+=valor
					}
					for(var m=1;m<=filast24;m++){
						var filat = NCampo('branding')+'vt'+m
						var valor = NumNormal(document.getElementById(filat).value)
						st2+=valor
					}
				break;
			case 3:
					for(var j=1;j<=filast31;j++){
						var filat = NCampo('performance')+'vt'+j
						var valor = NumNormal(document.getElementById(filat).value)
						st3+=valor
					}
					for(var k=1;k<=filast32;k++){
						var filat = NCampo('management')+'vt'+k
						var valor = NumNormal(document.getElementById(filat).value)
						st3+=valor
					}
					for(var l=1;l<=filast33;l++){
						var filat = NCampo('own')+'vt'+l
						var valor = NumNormal(document.getElementById(filat).value)
						st3+=valor
					}
				break;
			case 4:
					for(var j=1;j<=filast41;j++){
						var filat = NCampo('produccion')+'vt'+j
						var valor = NumNormal(document.getElementById(filat).value)
						st4+=valor
					}
				break;
		}
	}
	var subt1 = new oNumero(st1)
	document.getElementById('stecvt1').value=subt1.formato(2,true)
	
	var subt2 = new oNumero(st2)
	document.getElementById('stntvt2').value=subt2.formato(2,true)
	
	var subt3 = new oNumero(st3)
	document.getElementById('stesvt3').value=subt3.formato(2,true)
	
	var subt4 = new oNumero(st4)
	document.getElementById('stpevt4').value=subt4.formato(2,true)
}

function TT(actual, c1,c2,c3,c4){
	var total=0
	total=parseFloat(NumNormal(document.getElementById(c1).value))+parseFloat(NumNormal(document.getElementById(c2).value))+parseFloat(NumNormal(document.getElementById(c3).value))+parseFloat(NumNormal(document.getElementById(c4).value))
	var ttotal = new oNumero(total)
	document.getElementById(actual).value=ttotal.formato(2,true)
}

function TG(actual, c1,c2,c3){
	var total=0
	total=parseFloat(NumNormal(document.getElementById(c1).value))-parseFloat(NumNormal(document.getElementById(c2).value))+parseFloat(NumNormal(document.getElementById(c3).value))
	var ttotal = new oNumero(total)
	document.getElementById(actual).value=ttotal.formato(2,true)
}