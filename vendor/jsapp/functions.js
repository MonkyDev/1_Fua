/* -------- function limpiar cadena -------- */
String.prototype.trim = 
function() { 
	return this.replace(/^\s+|\s+$/g, ""); 
}
; 
/* FIN function */


function calcularPeriodo (grado, ciclo, anio, modalidad){

	var periodos = new Array();
	periodos["sem"] = [null, "01-06", "08-12"];
	periodos["cua"] = [null, "01-04", "05-08", "09-12"];

	grado_actual = grado, anio_actual = anio, ciclo_actual = parseInt(ciclo), entry = 0;

	modalidad = modalidad;
	mod = modalidad.substring(0, 3);
	no_per =  (periodos[mod].length) - 1;


	switch (mod) {
		case "cua":
			if (ciclo_actual <= 1)
				indx_periodo = 1;
			else if (ciclo_actual > 1 && ciclo_actual < 9)
				indx_periodo = 2;
			else
				indx_periodo = 3;			
			break;

		case "sem":
			if (ciclo_actual <= 1)
				indx_periodo = 1;
			else 
				indx_periodo = 2;				
			break;

		default:
			indx_periodo = false;
			break;
	}

	for (var i = grado_actual; 1 <= i; i--) {

		if (no_per === 2) { 
			if (indx_periodo > 1){ //indx_periodo = 2
					periodo_actual = /*i+"=>"+*/periodos[mod][indx_periodo]+"-"+anio_actual;				
					indx_periodo = 1;
					entry = 0;

			} else { //indx_periodo = 1 			
				if (entry < 1){ //entry = 0
					periodo_actual = /*i+"=>"+*/periodos[mod][indx_periodo]+"-"+anio_actual--;
					indx_periodo = 2;
					entry++;
				}			
			}

		} else if(no_per === 3) {
			if (indx_periodo > 2) { //indx_periodo = 3
				if (entry > 0 && entry < 2) { //entry = 1
					periodo_actual = /*i+"=>"+*/periodos[mod][indx_periodo]+"-"+anio_actual;
					indx_periodo = 2;
					entry++;
				}	
			} else if (indx_periodo > 1 && indx_periodo < 3) { //indx_periodo = 2
				periodo_actual = /*i+"=>"+*/periodos[mod][indx_periodo]+"-"+anio_actual;
				indx_periodo = 1;
				entry = 0;

			} else { //indx_periodo = 1
				if (entry < 1) { //entry = 0
					periodo_actual = /*i+"=>"+*/periodos[mod][indx_periodo]+"-"+anio_actual--;
					indx_periodo = 3;
					entry++; 
				} 
			}

		} else 
			return null;
	}

return periodo_actual;
}


/* -------- valida un nombre completo y lo particiona function -------- */
function splitNameComplet(people) {			

 	nombre = people.trim();  /* limpiamos cadena a separar*/
 	okNombre = nombre.replace(/\s+/gi,' '); /*validamos con una expresion*/
	if (okNombre != "") {
		arregloNombre = okNombre.split(' '); /*Array del nombre con las palabras separadas en cada posición.*/
		fullName = []; /*Array que contendrá el nombre final.*/
		palabrasReservadas =['da', 'de', 'del', 'la', 'las', 'los', 'san', 'santa']; /*Palabras de apellidos y nombres compuestos, aquí podemos agregar más palabras en caso de ser necesario.*/
		auxPalabra = ""; /*Variable auxiliar para concatenar los apellidos compuestos.*/
		arregloNombre.forEach(function(name){ /*Iteramos el array del nombre.*/
		 nameAux = name.toLowerCase(); /*convertimos en minúscula la palabra que se esta iterando para poder hacer la búsqueda de esta palabra en nuestro arreglo de "palabrasReservadas".*/
		 if(palabrasReservadas.indexOf(nameAux)!=-1) /*Cuando la palabra existe dentro de nuestro array, la funcion "indexOf" nos arrojara un numero diferente de -1.*/
		 {
		 auxPalabra += name+' ' ; /*Concatenamos y guardamos en nuestra variable auxiliar la palabra detectada.*/
		 }
		 else { /*En caso de que la palabra no existe en nuestro array de palabras reservadas, hacemos un push a la variable "fullName" que contendrá el nombre final*/
		 fullName.push(auxPalabra+name);
		 auxPalabra = ""; /*Limpiamos la variable auxiliar*/
		 }
		 });
		 /*Al final de la iteración vamos a tener un array en el cual la posicion 0 y 1 contienen los apellidos Paterno y Materno respectivamente.*/
		 /*las siguientes posiciones despues de eso contendra el nombre*/
		console.log("Apellido paterno: "+fullName[0]); /*Apellido Paterno*/
		console.log("Apellido materno: "+fullName[1]); /*Apellido Materno*/
		delete fullName[0]; /*Eliminamos la posición del apellido paterno*/
		delete fullName[1]; /*Eliminamos la posición del apellido materno*/
		nombreCompleto = ""; /*Variable que contiene el puro nombre*/
		fullName.forEach(function(nombre){ /*Iteramos en caso de que la persona tenga un nombre compuesto, ejemplo: Juan Manuel */
		 if(nombre!="")
		 {
		 nombreCompleto += nombre+ " "; /*Concatenamos el nombre*/
		 }
		});
		console.log("Nombre completo: "+nombreCompleto);  /*Nombre completo sin apellidos*/
	}
}


/* Validate the form using generic validaing */
function trun(elmt, lng, typ){
	
	var frm = $('form').attr('class');
	val = $("."+frm+' #'+elmt).val();
	$("."+frm+' #'+elmt).attr("maxlength", lng);

	var regex;
	switch (typ) {
		case 1: /*any numbers*/
			regex = /^[0-9]+$/i;
			break;
		case 2: /*when is celular*/
			regex = /^\+?([0-9]|[-|' '])+$/i;
			break;
		case 3: /*when is numbers, acept slash and space*/
			regex = /^\+?([0-9]|[/|' '])+$/i;
			break;
		case 4: /*when is letras*/
            regex = /^([A-zÀ-ÿ\u00f1\u00d1]|[' '])+$/i;
			break;
		case 5: /*when is search*/
            regex = /^([A-z0-9À-ÿ\u00f1\u00d1]|[-' '])+$/i;
			break;

	}
	jsRegex = new RegExp(regex).test(val);
    if( val && !jsRegex ){
    	reval = val.substring(0,val.length-1);
 			$("."+frm+' #'+elmt).val(reval);
	  }
}

function clf (elmt, lng, typ){
	var frm = $('form').attr('class');
	val = $("."+frm+' #'+elmt).val();
	$("."+frm+' #'+elmt).attr("maxlength", lng);

	var regex = /^[0-9]+$/i;
	jsRegex = new RegExp(regex).test(val);

	if ( val.length < 2 || val == 10 ) {
		if( val && !jsRegex ){
    	reval = val.substring(0,val.length-1);
 			$("."+frm+' #'+elmt).val(reval);
		}
	} else {
 		$("."+frm+' #'+elmt).val("");
	}
 
}
