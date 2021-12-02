$(function(){
		
	addMaskMeusDados();	
	fillFieldsAddressByZipCode();
	fillCitiesByState();
	validateMainFormMeusDados();

});


function addMaskMeusDados(){
	$('.form-alterar').find('.ipt-cpf').mask('999.999.999-00',{clearIfNotMatch:true});
	var translate_birthday = {translation: {'A': {pattern: /[0-3]/},'B': {pattern: /[0-1]/},'C': {pattern: /[1-2]/},'D': {pattern: /[0-08-9]/}},clearIfNotMatch:true};
	$('.form-alterar').find('.ipt-data-nascimento').mask('A9/B9/CD99',translate_birthday);
	$('.form-alterar').find('.ipt-cep').mask('99999-999',{clearIfNotMatch:true});	
	$('.form-alterar').find('.ipt-telefone').mask('(99) 9999-9999',{clearIfNotMatch:true});
	var _MaskBehavior = function (val) {
	  return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
	},
	_Options = {
	  onKeyPress: function(val, e, field, options) {
	      field.mask(_MaskBehavior.apply({}, arguments), options);
	  },
	  clearIfNotMatch:true
	};
	$('.form-alterar').find('.ipt-celular').mask(_MaskBehavior, _Options);
}

function fillFieldsAddressByZipCode(){
	$('.form-alterar').find('.ipt-cep').unbind("blur");
	$('.form-alterar').find('.ipt-cep').blur(function () {
		var valorCep = $(this).val();
		var valorCep = valorCep.substring(8);
		if (valorCep != '_') {
			var data = {};
			data['cep'] = $(this).val();
			Ssx.ajax("AjaxControl_getEnderecoByCep",data,'fillAddress');
		}
	});
}

function fillAddress(_obj){
	if(typeof _obj.success != 'undefined' && _obj.success && !_obj.endereco.erro){
		$('.form-alterar').find('.ipt-cep').val(_obj.endereco.cep);
		$('.form-alterar').find('.ipt-logradouro').val(_obj.endereco.logradouro);
		$('.form-alterar').find('.ipt-bairro').val(_obj.endereco.bairro);
		var _html_cidade = "<option value=''>-- Selecione a cidade</option>";
		_html_cidade += "<option value='"+_obj.endereco.localidade+"' selected>"+_obj.endereco.localidade+"</option>";
		$('.form-alterar').find('.ipt-estado').val(_obj.endereco.uf);
		$('.form-alterar').find('.ipt-cidade').empty();
		$('.form-alterar').find('.ipt-cidade').append(_html_cidade);
		$('.form-alterar').find('.ipt-cidade').removeAttr("disabled");
	}else{
		if($('.form-alterar').find(".ipt-estado").val() == ''){
			$('.form-alterar').find('.ipt-cidade').val('');
			$('.form-alterar').find('.ipt-cidade').attr("disabled","disabled");
		}
	}
	return false;
}

function fillCitiesByState(){
	$('.form-alterar').find('.ipt-estado').unbind('change')
	$('.form-alterar').find('.ipt-estado').change(function(){
		var _uf = $(this).val();
		if(_uf != ""){
			var data = {};
			data['uf'] = $(this).val();
			Ssx.ajax("AjaxControl_getAllCidadesByNomeUf",data,'fillCity');
		}else{
			var _html_cidade = "<option value=''>-- Selecione a cidade</option>";
			$('.form-alterar').find('.ipt-cidade').empty().append(_html_cidade);
			$('.form-alterar').find('.ipt-cidade').attr('disabled','disabled');
		}
	});
}

function fillCity(_obj){
	if(typeof _obj.success != 'undefined' && _obj.success){
		var _html = "<option value=''>-- Selecione a cidade</option>";
		for(var i=0;i<_obj.cidades.length;i++){
			_html += '<option value="'+_obj.cidades[i].nome+'">'+_obj.cidades[i].nome+'</option>';
		}
		$('.form-alterar').find('.ipt-cidade').empty();
		$('.form-alterar').find('.ipt-cidade').append(_html);
		$('.form-alterar').find('.ipt-cidade').removeAttr('disabled');
	}else{
		$('.form-alterar').find('.ipt-cidade').val('');
		$('.form-alterar').find('.ipt-cidade').attr("disabled","disabled");
	}

	return false;
}

var validatedformMeusDados = false;
var validatedhasemail = false;
var validatedhascpf = false;
var array_errors_meus_dados = [];

function validateMainFormMeusDados(){
	
	$('.form-alterar').unbind('submit');
	$('.form-alterar').submit(function(e){
		
		e.preventDefault();
		var count_validacoes = 0;
		var limit_necessary = 15;
		array_errors_meus_dados = [];

		var _nome = $('.form-alterar').find('.ipt-nome');
		if(_nome.val() == "" || _nome.val().length < 2){
			// array_errors_meus_dados.push('Nome');
			var msg = "Preencha o nome";
			addError( _nome ,msg);
		}else{
			count_validacoes++;
			removeError(_nome);
		}

		var _sobrenome = $('.form-alterar').find('.ipt-sobrenome');
		if(_sobrenome.val() == "" || _sobrenome.val().length < 2){
			// array_errors_meus_dados.push('Sobrenome');
			var msg = "Preencha o sobrenome";
			addError( _sobrenome ,msg);
		}else{
			count_validacoes++;
			removeError(_sobrenome);
		}

		var _rg = $('.form-alterar').find('.ipt-rg');
		if(_rg.val() == ""){
			array_errors_meus_dados.push('rg');
			var msg = "Preencha o RG";
			addError( _rg , msg);
		}else{
			count_validacoes++;
			removeError(_rg);
		}

		var _cpf = $('.form-alterar').find('.ipt-cpf');
		if(_cpf.val() == "" || !Ssx.isCpf(_cpf.val())){
			array_errors_meus_dados.push('Cpf');
			var msg = "Preencha um cpf válido";
			addError( _cpf , msg);
		}else{
			count_validacoes++;
			removeError(_cpf);
		}


		var _email = $('.form-alterar').find('.ipt-email');
		if(_email.val() == "" || !Ssx.isEmail(_email.val())){
			// array_errors_meus_dados.push('Email');
			var msg = "Preencha um email válido";
			addError( _email, msg );
		}else{
			count_validacoes++;
			removeError(_email);
		}		
		

		var _data_nascimento = $('.form-alterar').find('.ipt-data-nascimento');
		var d = _data_nascimento.val().split('/')[0];
		var m = _data_nascimento.val().split('/')[1];
		var y = _data_nascimento.val().split('/')[2];
		if( !Ssx.convertDateStrToDateObj(_data_nascimento.val()) || Ssx.validarData(d, m, y) != 1){
			var msg = "";
			if(Ssx.validarData(d, m, y) == 2){
				// array_errors_meus_dados.push('Data Nascimento | idade inválida');
				msg = "Preencha uma data de nascimento válida";
			}else{
				// array_errors_meus_dados.push('Data Nascimento');
				msg = "Preencha uma data de nascimento";
			}
			addError( _data_nascimento,msg );
		}else{
			count_validacoes++;
			removeError(_data_nascimento);
		}

		var _sexo = $('.form-alterar').find('.ipt-sexo');
		if(_sexo.val() == ""){
			array_errors_meus_dados.push('Sexo');
			var msg = "Selecione um sexo";
			addError( _sexo , msg);
		}else{
			count_validacoes++;
			removeError(_sexo);
		}

		var _telefone = $('.form-alterar').find('.ipt-telefone');
		if(_telefone.val() == ""){
			// array_errors_meus_dados.push('Telefone');
			var msg = "Preencha um número de telefone";
			addError( _telefone, msg);
		}else{
			count_validacoes++;
			removeError(_telefone);
		}

		var _celular = $('.form-alterar').find('.ipt-celular');
		if(_celular.val() == ""){
			// array_errors_meus_dados.push('Celular');
			var msg = "Preencha um número de celular";
			addError( _celular );
		}else{
			count_validacoes++;
			removeError(_celular);
		}

		var _cep = $('.form-alterar').find('.ipt-cep');
		if(_cep.val() == ""){
			// array_errors_meus_dados.push('Cep');
			var msg = "Preencha um cep";
			addError( _cep ,msg);
		}else{
			count_validacoes++;
			removeError(_cep);
		}

		var _logradouro = $('.form-alterar').find('.ipt-logradouro');
		if(_logradouro.val() == ""){
			// array_errors_meus_dados.push('Logradouro');
			var msg = "Preencha um endereço";
			addError( _logradouro, msg);
		}else{
			count_validacoes++;
			removeError(_logradouro);
		}

		var _numero = $('.form-alterar').find('.ipt-numero');
		if(_numero.val() == ""){
			// array_errors_meus_dados.push('Número');
			var msg = "Preencha o número do endereço";
			addError( _numero, msg);
		}else{
			count_validacoes++;
			removeError(_numero);
		}

		var _bairro = $('.form-alterar').find('.ipt-bairro');
		if(_bairro.val() == ""){
			// array_errors_meus_dados.push('Bairro');
			var msg = "Preencha um bairro";
			addError( _bairro ,msg);
		}else{
			count_validacoes++;
			removeError(_bairro);
		}

		var _cidade = $('.form-alterar').find('.ipt-cidade');
		if(_cidade.val() == ""){
			// array_errors_meus_dados.push('Cidade');
			var msg = "Selecione uma cidade";
			addError( _cidade, msg );
		}else{
			count_validacoes++;
			removeError(_cidade);
		}

		var _estado = $('.form-alterar').find('.ipt-estado');
		if(_estado.val() == ""){
			// array_errors_meus_dados.push('Estado');
			var msg = "Selecione um estado";
			addError( _estado, msg);
		}else{
			count_validacoes++;
			removeError(_estado);
		}

		var _senha = $('.form-alterar').find('.ipt-senha');
		var _conf_senha = $('.form-alterar').find('.ipt-conf-senha');
		var change_password = false;
		if(_senha.val() != "" || _conf_senha.val() != ""){
			limit_necessary++;
			if(_senha.val() != _conf_senha.val()){
				//array_errors_meus_dados.push('Senhas Divergentes');
				var msg = "Senhas divergentes";
				addError( _senha, msg );
				addError( _conf_senha, msg );	
			}else{
				count_validacoes++;
				change_password = true;
				removeError( _senha );
				removeError( _conf_senha );	
			}
		}else{
			removeError( _senha );
			removeError( _conf_senha );	
		}

		if(count_validacoes >= limit_necessary){
			validatedformMeusDados = true;
			checkHasEmail();
		}

		console.log(count_validacoes,limit_necessary);

	});
}

function checkHasEmail(){
	var _email = $('.form-alterar').find('.ipt-email').val();
	var data = {};
	data['email'] = _email;
	Ssx.ajax('AjaxControl_getEmail',data,'checkHasCpf');
}

function checkHasCpf(response){
	if(response.hasEmail == false){
		validatedhasemail = true;
		var _cpf = $('.form-alterar').find('.ipt-cpf').val();
		var dados = {cpf:_cpf};
		Ssx.ajax('AjaxControl_getCpf',dados,'submitMainFormMeusDados');
	}else{
		//array_errors_meus_dados.push('Email inválido!');
		var msg = "Email inválido";
		addError($('.form-alterar').find('.ipt-email'),msg);
	}
}

function submitMainFormMeusDados(response){
	if(response.hasCpf == false){
		validatedhascpf = true;
		if(validatedformMeusDados && validatedhascpf && validatedhasemail){
			$('.form-alterar')[0].submit();
			$('.form-alterar').unbind('submit');
			$('.form-alterar').submit(function(e){
				e.preventDefault();
			});
		}	
	}else{
		//array_errors_meus_dados.push('Cpf inválido!');
		var msg = "Cpf inválido";
		addError($('.form-alterar').find('.ipt-cpf'),msg);
	}	
}


function validarData(dia, mes,ano){
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
    if(age < 18){
    	validador = 2;
    }
	return validador;

}

function addError(_obj,msg){
	 $('html, body').scrollTop(_obj.offset().top-150);
	_obj.parent().find('.erro').text(msg);
	_obj.parent().addClass('has-error');
}

function removeError(_obj){
	_obj.parent().removeClass('has-error');
}
