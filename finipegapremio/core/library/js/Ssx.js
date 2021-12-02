function SsxJs()
{
	this.uploadBoxOpen = false;
	
	this.jqueryLoaded = function()
	{
		if(!$)
			return false;
		return true;
	};
	
	this.ajax = function(function_to_call, data, callback)
	{
		if(!this.jqueryLoaded())
		{
			console.log('Ssx Ajax: Jquery not found');
			return false;
		}
		
		if(this.isNull(function_to_call))
		{
			console.log("Ssx Ajax Error: function to call is null");
			return false;
		}
		
		var dataToSend = {
			'function_call' : function_to_call,
			'function_data' : data,
			'function_callback' : callback,
			'output' : 'json',
			'ad' : (ad)?true:false
		};
		
		$.ajax({
			  url: _ssx_ajaxurl,
			  timeout:20000,// 10 segundos para disparar o erro de timout
			  data : dataToSend,
			  type: "POST",
			  dataType: 'json',
			  success : function(data){
					if(data.errors)
					{
					    console.log(data.errors);
					    return;
					}
					if(data.callback)
					{
						if(typeof window[data.callback] == 'function')
							window[data.callback](data.result);
						else
							console.log('Ssx Ajax: function callback not exists.');
					}
			  },
			  error : function(log,t)
			  {
				    //console.log("error " + log);
				    if(t==="timeout"){
				    	alert("Problemas com o servidor. Tempo de requisição esgotado.");
				    }
			  }
			  
		});
	};
		
	this.isEmpty = function(value)
	{
		if(value == "")
			return true;
		return false;
	};
	
	this.isNull = function(value)
	{
		if(value == null)
			return true;
		return false;
	};


	
	this.isEmail = function(value)
	{
		  if(this.isEmpty(value))
			  return false;
		
		  var pattern='([\\w-+]+(?:\\.[\\w-+]+)*@(?:[\\w-]+\\.)+[a-zA-Z]{2,7})';

	      var p = new RegExp(pattern,["i"]);
	      var m = p.exec(value);
	      
	      if(m != null)
	    	  return true;
	      return false;
	};

	this.isCnpj = function(cnpj) 
	{
	    cnpj = cnpj.replace(/[^\d]+/g,'');

	    if(cnpj == '') return false;

	    if (cnpj.length != 14)
	        return false;

	    // LINHA 10 - Elimina CNPJs invalidos conhecidos
	    if (cnpj == "00000000000000" || 
	        cnpj == "11111111111111" || 
	        cnpj == "22222222222222" || 
	        cnpj == "33333333333333" || 
	        cnpj == "44444444444444" || 
	        cnpj == "55555555555555" || 
	        cnpj == "66666666666666" || 
	        cnpj == "77777777777777" || 
	        cnpj == "88888888888888" || 
	        cnpj == "99999999999999")
	        return false; // LINHA 21

	    // Valida DVs LINHA 23 -
	    tamanho = cnpj.length - 2
	    numeros = cnpj.substring(0,tamanho);
	    digitos = cnpj.substring(tamanho);
	    soma = 0;
	    pos = tamanho - 7;
	    for (i = tamanho; i >= 1; i--) {
	      soma += numeros.charAt(tamanho - i) * pos--;
	      if (pos < 2)
	            pos = 9;
	    }
	    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	    if (resultado != digitos.charAt(0))
	        return false;

	    tamanho = tamanho + 1;
	    numeros = cnpj.substring(0,tamanho);
	    soma = 0;
	    pos = tamanho - 7;
	    for (i = tamanho; i >= 1; i--) {
	      soma += numeros.charAt(tamanho - i) * pos--;
	      if (pos < 2)
	            pos = 9;
	    }
	    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	    if (resultado != digitos.charAt(1))
	          return false; // LINHA 49

	    return true; // LINHA 51
	};
	
	this.isCpf = function(cpf)
	{
	  cpf = cpf.replace(/\D/g,'');
	  var numeros, digitos, soma, i, resultado, digitos_iguais;
	  
      digitos_iguais = 1;
      
      if (cpf.length < 11)
            return false;
      
      for (i = 0; i < cpf.length - 1; i++)
              if (cpf.charAt(i) != cpf.charAt(i + 1))
              {
            	 digitos_iguais = 0;
            	 break;
              }
      
        if (!digitos_iguais)
        {
            numeros = cpf.substring(0,9);
            digitos = cpf.substring(9);
            soma = 0;
            for (i = 10; i > 1; i--)
                  soma += numeros.charAt(10 - i) * i;
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0))
                  return false;
            numeros = cpf.substring(0,10);
            soma = 0;
            for (i = 11; i > 1; i--)
                  soma += numeros.charAt(11 - i) * i;
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1))
                  return false;
            return true;
        }
        else
            return false;
	};
	
	this.isEquals = function(objA, objB)
	{
		if(this.isNull(objA) || this.isNull(objB))
			return false;
		
		if(objA == objB)
			return true;
		return false;
	};
	
	this.charCount = function(value, qtd)
	{		
		if(value.length >= qtd)
			return true;
		return false;
	};
	
	this.isString = function(obj)
	{
		if(typeof obj == 'string')
			return true;
		return false;
	};
	
	this.isNumber = function(obj)
	{
		if(typeof obj == 'number')
			return true;
		return false;
	};

	this.monthDescriptionByNumber = function(monthNumber){
		var monthDescription = false;
		switch(monthNumber){
	        case '01':
	            monthDescription = 'January';
	        break;
	        case '02':
	            monthDescription = 'February';
	        break;
	        case '03':
	            monthDescription = 'March';
	        break;
	        case '04':
	            monthDescription = 'April';
	        break;
	        case '05':
	            monthDescription = 'May';
	        break;
	        case '06':
	            monthDescription = 'June';
	        break;
	        case '07':
	            monthDescription = 'July';
	        break;
	        case '08':
	            monthDescription = 'August';
	        break;
	        case '09':
	            monthDescription = 'September';
	        break;
	        case '10':
	            monthDescription = 'October';
	        break;
	        case '11':
	            monthDescription = 'November';
	        break;
	        case '12':
	            monthDescription = 'December';
	        break;
	        default:
	        	return false;
	        break;
    	}
    	return monthDescription;
	};

	this.convertDateStrToDateObj = function (dateStr){
	    var isNotValid = 0;
	    isNotValid = typeof dateStr != 'string' ? (isNotValid + 1) : isNotValid;
	    if (isNotValid) {
	        return false;
	    }
	    var datePieces = dateStr.split('/');
	    isNotValid = datePieces.length < 3 ? (isNotValid + 1) : isNotValid;
	    if (isNotValid > 0) {
	        return false;
	    }
	    var day = datePieces[0];
	    var month = NaN;
	    monthDescription = this.monthDescriptionByNumber(datePieces[1]);

	    var monthNumber = datePieces[1];
	    var year = datePieces[2];

	    var objDate = new Date(monthDescription+" "+day+", "+year+" 00:00:00");
	    if (objDate == "Invalid Date") {
	        return false;
	    } else if (parseInt(objDate.getFullYear()) != parseInt(year)) {
	        return false;
	    } else if (parseInt(objDate.getMonth() + 1) != parseInt(monthNumber)) {
	        return false;
	    } else if (parseInt(objDate.getDate()) != parseInt(day)){
	        return false;
	    }
	    return objDate;
	};

	this.validarData = function(dia, mes,ano){
		var validador = 1;
		if(mes==1 || mes==3 || mes==5 || mes==7 || mes==8 || mes==10 || mes==12){
			if(dia > 31) {
				//Dia incorreto !!! O mês especificado contém no exatamente 31 dias.
				validador = 0;
			}
		}
		if(mes==4 || mes==6 || mes==9 || mes==11){
			if(dia > 30) {
				//Dia incorreto !!! O mês especificado contém no máximo 30 dias.
				validador = 0;
			}
		}
		if(mes==2) {
			if(dia > 28 && ano%4!=0) {
				//Dia incorreto !!! O mês especificado contém no máximo 28 dias.
				validador = 0;
			}
			if(dia > 29 && ano%4==0) {
				//Dia incorreto !!! O mês especificado contém no máximo 29 dias.
				validador = 0;
			}

		}

		if(mes==0 || dia == 0 || ano == 0){
			validador=0;
		}

		var today = new Date();
	    var birthDate = new Date(ano, mes - 1, dia);
	    var age = today.getFullYear() - birthDate.getFullYear();
	    var m = today.getMonth() - birthDate.getMonth();
	    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
	        age--;
	    }
	    if(age == 17){
	    	if(today.getMonth() == birthDate.getMonth() && today.getDate() >= birthDate.getDate()){
	    		age = 18;
	    	}
	    }
	    if(age < 15){ // IMPORTANTE IDADE MÍNIMA 15 ANOS
	    	validador = 2;
	    }
		return validador;
	};
	
}

var Ssx = new SsxJs();

