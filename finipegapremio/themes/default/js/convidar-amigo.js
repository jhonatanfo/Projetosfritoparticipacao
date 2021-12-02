$(function(){
	validarMainFormConvidar();
});

var validateformConvidar = false;
function validarMainFormConvidar(){
	$('.form-convidar').unbind('submit');
	$('.form-convidar').submit(function(e){

		e.preventDefault();

		var count_validacoes = 0;

		var _nome = $('.form-convidar').find('.ipt-nome');
		if(_nome.val() == "" || _nome.val().length < 2){
			addErrorLabel(_nome);
		}else{
			count_validacoes++;
			removeErrorLabel(_nome);
		}

		var _email = $('.form-convidar').find('.ipt-email');
		if(_email.val() == "" || !Ssx.isEmail(_email.val())){
			addErrorLabel(_email);
		}else{
			count_validacoes++;
			removeErrorLabel(_email);
		}

		if(count_validacoes >= 2){
			validateformConvidar=true;
			submitMainFormConvidar();
		}

	});
}

function submitMainFormConvidar(){
	if(validateformConvidar){
		$('.form-convidar').find('.btn-send').text('Enviando ...');
		$('.form-convidar')[0].submit();
		$('.form-convidar').unbind('submit');
		$('.form-convidar').submit(function(e){
			e.preventDefault();
		});
	}
}

function addErrorLabel(_obj){
	_obj.parent().addClass('has-error');
}

function removeErrorLabel(_obj){
	_obj.parent().removeClass('has-error');
}

