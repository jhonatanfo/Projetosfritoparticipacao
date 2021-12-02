$(function(){

	addMask();
	fillFieldsAddressByZipCode();
	fillCitiesByState();
	validateMainForm();

	$('.carrossel-cadastro').slick({
		// adaptiveHeight: true,
		dots: true,
		infinite: false,
		arrows: false,
		slideToShow: 1,
		slideToScroll: 1,
		draggable: false,
		respondTo: 'slider',
		swipe: false,
		touchMove: false,
	}).on('setPosition', function (event, slick) {
		slick.$slides.css('height', slick.$slideTrack.height() + 'px');
	})

	$('.btn-proximo').click(function(e){
		e.preventDefault();
		var currentStep = $(this).attr('current-step');
		validateStep(currentStep);
	})

	$('.slick-dots li button').on('click', function(e){
	    e.stopPropagation(); // use this
	});

});

function addMask(){
	$('.ipt-cpf').mask('999.999.999-00',{clearIfNotMatch:true});
	var translate_birthday = {translation: {'A': {pattern: /[0-3]/},'B': {pattern: /[0-1]/},'C': {pattern: /[1-2]/},'D': {pattern: /[0-08-9]/}},clearIfNotMatch:true};
	$('.ipt-data-nascimento').mask('A9/B9/CD99',translate_birthday);
	$('.ipt-cep').mask('99999-999',{clearIfNotMatch:true});
	$('.ipt-telefone').mask('(99) 9999-9999',{clearIfNotMatch:true});
	var _MaskBehavior = function (val) {
	  return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
	},
	_Options = {
	  onKeyPress: function(val, e, field, options) {
	      field.mask(_MaskBehavior.apply({}, arguments), options);
	  },
	  clearIfNotMatch:true
	};
	$('.ipt-celular').mask(_MaskBehavior, _Options);
}

function fillFieldsAddressByZipCode(){
	$('.ipt-cep').unbind("blur");
	$('.ipt-cep').blur(function () {
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
		$('.ipt-cep').val(_obj.endereco.cep);
		$('.ipt-logradouro').val(_obj.endereco.logradouro);
		$('.ipt-bairro').val(_obj.endereco.bairro);
		var _html_cidade = "<option value=''>-- Selecione a cidade</option>";
		_html_cidade += "<option value='"+_obj.endereco.localidade+"' selected>"+_obj.endereco.localidade+"</option>";
		$('.ipt-estado').val(_obj.endereco.uf);
		$('.ipt-cidade').empty();
		$('.ipt-cidade').append(_html_cidade);
	}else{
		if($(".ipt-estado").val() == ''){
			$('.ipt-cidade').val('');
		}
	}
	return false;
}

function fillCitiesByState(){
	$('.ipt-estado').unbind('change')
	$('.ipt-estado').change(function(){
		var _uf = $(this).val();
		if(_uf != ""){
			var data = {};
			data['uf'] = $(this).val();
			Ssx.ajax("AjaxControl_getAllCidadesByNomeUf",data,'fillCity');
		}else{
			var _html_cidade = "<option value=''>-- Selecione a cidade</option>";
			$('.ipt-cidade').empty().append(_html_cidade);
		}
	});
}

function fillCity(_obj){
	if(typeof _obj.success != 'undefined' && _obj.success){
		var _html = "<option value=''>-- Selecione a cidade</option>";
		for(var i=0;i<_obj.cidades.length;i++){
			_html += '<option value="'+_obj.cidades[i].nome+'">'+_obj.cidades[i].nome+'</option>';
		}
		$('.ipt-cidade').empty();
		$('.ipt-cidade').append(_html);
	}else{
		$('.ipt-cidade').val('');
	}

	return false;
}

var validatedform = false;
var validatedhasemail = false;
var validatedhascpf = false;
var array_errors = [];

function validateMainForm() {
	$('.form').unbind('submit');
	$('.form').submit(function(e){

		e.preventDefault();
		var count_validacoes = 0;
		array_errors = [];

		var _nome = $('.ipt-nome');
		if(_nome.val() == "" || _nome.val().length < 2){
			array_errors.push('Nome');
			addError( _nome );
		}else{
			count_validacoes++;
			removeError(_nome);
		}

		var _sobrenome = $('.ipt-sobrenome');
		if(_sobrenome.val() == "" || _sobrenome.val().length < 2){
			array_errors.push('Sobrenome');
			addError( _sobrenome );
		}else{
			count_validacoes++;
			removeError(_sobrenome);
		}

		var _email = $('.ipt-email');
		if(_email.val() == "" || !Ssx.isEmail(_email.val())){
			array_errors.push('Email');
			addError( _email );
		}else{
			count_validacoes++;
			removeError(_email);
		}

		var _rg = $('.ipt-rg');
		if(_rg.val() == ""){
			array_errors.push('Rg');
			addError( _rg );
		}else{
			count_validacoes++;
			removeError(_rg);
		}

		var _cpf = $('.ipt-cpf');
		if(_cpf.val() == "" || !Ssx.isCpf(_cpf.val())){
			array_errors.push('Cpf');
			addError( _cpf );
		}else{
			count_validacoes++;
			removeError(_cpf);
		}

		var _data_nascimento = $('.ipt-data-nascimento');
		var d = _data_nascimento.val().split('/')[0];
		var m = _data_nascimento.val().split('/')[1];
		var y = _data_nascimento.val().split('/')[2];
		if( !Ssx.convertDateStrToDateObj(_data_nascimento.val()) || Ssx.validarData(d, m, y) != 1){
			if(Ssx.validarData(d, m, y) == 2){
				array_errors.push('Data Nascimento | idade inválida');
			}else{
				array_errors.push('Data Nascimento');
			}
			addError( _data_nascimento );
		}else{
			count_validacoes++;
			removeError(_data_nascimento);
		}

		var _sexo = $('.ipt-sexo');
		if(_sexo.val() == ""){
			array_errors.push('Sexo');
			addError( _sexo );
		}else{
			count_validacoes++;
			removeError(_sexo);
		}

		// var _telefone = $('.ipt-telefone');
		// if(_telefone.val() == ""){
		// 	array_errors.push('Telefone');
		// 	addError( _telefone );
		// }else{
		// 	count_validacoes++;
		// 	removeError(_telefone);
		// }

		var _celular = $('.ipt-celular');
		if(_celular.val() == ""){
			array_errors.push('Celular');
			addError( _celular );
		}else{
			count_validacoes++;
			removeError(_celular);
		}

		var _cep = $('.ipt-cep');
		if(_cep.val() == ""){
			array_errors.push('Cep');
			addError( _cep );
		}else{
			count_validacoes++;
			removeError(_cep);
		}

		var _logradouro = $('.ipt-logradouro');
		if(_logradouro.val() == ""){
			array_errors.push('Logradouro');
			addError( _logradouro );
		}else{
			count_validacoes++;
			removeError(_logradouro);
		}

		var _numero = $('.ipt-numero');
		if(_numero.val() == ""){
			array_errors.push('Número');
			addError( _numero );
		}else{
			count_validacoes++;
			removeError(_numero);
		}


		var _bairro = $('.ipt-bairro');
		if(_bairro.val() == ""){
			array_errors.push('Bairro');
			addError( _bairro );
		}else{
			count_validacoes++;
			removeError(_bairro);
		}

		var _cidade = $('.ipt-cidade');
		if(_cidade.val() == ""){
			array_errors.push('Cidade');
			addError( _cidade );
		}else{
			count_validacoes++;
			removeError(_cidade);
		}

		var _estado = $('.ipt-estado');
		if(_estado.val() == ""){
			array_errors.push('Estado');
			addError( _estado );
		}else{
			count_validacoes++;
			removeError(_estado);
		}

		var _senha = $('.ipt-senha');
		if(_senha.val() == ""){
			array_errors.push('Senha');
			addError( _senha );
		}else{
			count_validacoes++;
			removeError(_senha);
		}

		var _conf_senha = $('.ipt-conf-senha');
		if(_conf_senha.val() == ""){
			array_errors.push('Telefone');
			addError( _conf_senha );
		}else{
			count_validacoes++;
			removeError(_conf_senha);
		}

		if(_senha.val() != "" && _conf_senha.val() != ""){
			if(_senha.val() != _conf_senha.val()){
				array_errors.push('Senhas Divergentes');
				addError( _senha );
				addError( _conf_senha );
			}else{
				count_validacoes++;
				removeError( _senha );
				removeError( _conf_senha );
			}
		}

		var _termos  = $('.ipt-termos');
		if(_termos.prop('checked') == false){
			array_errors.push('Termos do regulamento');
			_termos.parent().css('color','#ff4848');
		}else{
			count_validacoes++;
			_termos.parent().css('color','#333');
		}

		if(count_validacoes >= 18){
			validatedform = true;
			checkHasEmail();
		}

		console.log(count_validacoes);

	});
}



function validateStep(currentStep) {
	switch (currentStep) {
		case '1':
			var count_validacoes_step1 = 0;
			array_errors = [];

			var _nome = $('.ipt-nome');
			if(_nome.val() == "" || _nome.val().length < 2){
				array_errors.push('Nome');
				addError( _nome );
			}else{
				count_validacoes_step1++;
				removeError(_nome);
			}

			var _sobrenome = $('.ipt-sobrenome');
			if(_sobrenome.val() == "" || _sobrenome.val().length < 2){
				array_errors.push('Sobrenome');
				addError( _sobrenome );
			}else{
				count_validacoes_step1++;
				removeError(_sobrenome);
			}

			var _cpf = $('.ipt-cpf');
			if(_cpf.val() == "" || !Ssx.isCpf(_cpf.val())){
				array_errors.push('Cpf');
				addError( _cpf );
			}else{
				count_validacoes_step1++;
				removeError(_cpf);
			}

			var _data_nascimento = $('.ipt-data-nascimento');
			var d = _data_nascimento.val().split('/')[0];
			var m = _data_nascimento.val().split('/')[1];
			var y = _data_nascimento.val().split('/')[2];
			if( !Ssx.convertDateStrToDateObj(_data_nascimento.val()) || Ssx.validarData(d, m, y) != 1){
				if(Ssx.validarData(d, m, y) == 2){
					array_errors.push('Data Nascimento | idade inválida');
				}else{
					array_errors.push('Data Nascimento');
				}
				addError( _data_nascimento );
			}else{
				count_validacoes_step1++;
				removeError(_data_nascimento);
			}

			var _sexo = $('.ipt-sexo');
			if(_sexo.val() == ""){
				array_errors.push('Sexo');
				addError( _sexo );
			}else{
				count_validacoes_step1++;
				removeError(_sexo);
			}


			if(count_validacoes_step1 >= 5){
				checkHasCpfInline();
			}


		break;
		case '2':

			var count_validacoes_step2 = 0;
			array_errors = [];

			var _email = $('.ipt-email');
			if(_email.val() == "" || !Ssx.isEmail(_email.val())){
				array_errors.push('Email');
				addError( _email );
			}else{
				count_validacoes_step2++;
				removeError(_email);
			}

			/*
			var _telefone = $('.ipt-telefone');
			if(_telefone.val() == ""){
				array_errors.push('Telefone');
				addError( _telefone );
			}else{
				count_validacoes_step2++;
				removeError(_telefone);
			}
			*/

			var _celular = $('.ipt-celular');
			if(_celular.val() == ""){
				array_errors.push('Celular');
				addError( _celular );
			}else{
				count_validacoes_step2++;
				removeError(_celular);
			}

			if(count_validacoes_step2 >= 2){
				checkHasEmailInline();
			}

		break;
		case '3':
			var count_validacoes_step3 = 0;
			array_errors = [];

			var _cep = $('.ipt-cep');
			if(_cep.val() == ""){
				array_errors.push('Cep');
				addError( _cep );
			}else{
				count_validacoes_step3++;
				removeError(_cep);
			}

			var _logradouro = $('.ipt-logradouro');
			if(_logradouro.val() == ""){
				array_errors.push('Logradouro');
				addError( _logradouro );
			}else{
				count_validacoes_step3++;
				removeError(_logradouro);
			}

			var _numero = $('.ipt-numero');
			if(_numero.val() == ""){
				array_errors.push('Número');
				addError( _numero );
			}else{
				count_validacoes_step3++;
				removeError(_numero);
			}

			var _bairro = $('.ipt-bairro');
			if(_bairro.val() == ""){
				array_errors.push('Bairro');
				addError( _bairro );
			}else{
				count_validacoes_step3++;
				removeError(_bairro);
			}

			var _cidade = $('.ipt-cidade');
			if(_cidade.val() == ""){
				array_errors.push('Cidade');
				addError( _cidade );
			}else{
				count_validacoes_step3++;
				removeError(_cidade);
			}

			var _estado = $('.ipt-estado');
			if(_estado.val() == ""){
				array_errors.push('Estado');
				addError( _estado );
			}else{
				count_validacoes_step3++;
				removeError(_estado);
			}

			if(count_validacoes_step3 >= 6){
				gotoSlide(3)
			}

		break;
		case '4':
			var count_validacoes_step4 = 0;
			array_errors = [];

			var _senha = $('.ipt-senha');
			if(_senha.val() == ""){
				array_errors.push('Senha');
				addError( _senha );
			}else{
				count_validacoes_step4++;
				removeError(_senha);
			}

			var _conf_senha = $('.ipt-conf-senha');
			if(_conf_senha.val() == ""){
				array_errors.push('Telefone');
				addError( _conf_senha );
			}else{
				count_validacoes_step4++;
				removeError(_conf_senha);
			}

			if(_senha.val() != "" && _conf_senha.val() != ""){
				if(_senha.val() != _conf_senha.val()){
					array_errors.push('Senhas Divergentes');
					addError( 'senhas-diferentes' );
				}else{
					count_validacoes_step4++;
					removeError( _senha );
					removeError( _conf_senha );
				}
			}

			if(count_validacoes_step4 >= 3){
				gotoSlide(4)
			}

		break;

	}
}

function gotoSlide(slide) {
	$('.carrossel-cadastro').slick('slickGoTo', slide);
}

function checkHasCpfInline(){
	var _cpf = $('.ipt-cpf').val();
	var dados = {cpf:_cpf};
	Ssx.ajax('AjaxControl_getCpf',dados,'checkHasCpfInlineResponse');
}

function checkHasCpfInlineResponse(response){
	if(response.hasCpf == false){
		gotoSlide(1);
	}else{
		array_errors.push('Cpf inválido!');
		addError('cpf-cadastrado');
	}
}

function checkHasEmailInline(){
	var _email = $('.ipt-email').val();
	var data = {};
	data['email'] = _email;
	Ssx.ajax('AjaxControl_getEmail',data,'checkHasEmailInlineResponse');
}

function checkHasEmailInlineResponse(response) {
	if(response.hasEmail == false){
		validatedhasemail = true;
		gotoSlide(2);
	}else{
		array_errors.push('Email inválido!');
		addError('email-cadastrado');
	}
}

function checkHasEmail(){
	var _email = $('.ipt-email').val();
	var data = {};
	data['email'] = _email;
	Ssx.ajax('AjaxControl_getEmail',data,'checkHasCpf');
}

function checkHasCpf(response){
	if(response.hasEmail == false){
		validatedhasemail = true;
		var _cpf = $('.ipt-cpf').val();
		var dados = {cpf:_cpf};
		Ssx.ajax('AjaxControl_getCpf',dados,'submitMainForm');
	}else{
		array_errors.push('Email inválido!');
		addError($('.ipt-email'));
	}
}

function submitMainForm(response){
	if(response.hasCpf == false){
		validatedhascpf = true;
		if(validatedform && validatedhascpf && validatedhasemail){
			$('.form')[0].submit();
		}
	}else{
		array_errors.push('Cpf inválido!');
		addError($('.ipt-cpf'));
	}
}

function addError(_obj) {
	if (_obj == "email-cadastrado") {
		$('.ipt-email').parent().addClass('has-error-existe');
	} else if (_obj == "cpf-cadastrado") {
		$('.ipt-cpf').parent().addClass('has-error-existe');
	} else if (_obj == 'senhas-diferentes') {
		$('.ipt-conf-senha').parent().addClass('has-error-existe');
	} else {
		_obj.parent().addClass('has-error');
	}
}

function removeError(_obj){
	_obj.parent().removeClass('has-error');
}
