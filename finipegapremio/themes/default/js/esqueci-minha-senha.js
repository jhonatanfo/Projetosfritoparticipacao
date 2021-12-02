$(function(){
	addMaskEsqueci();
	validateMainFormEsqueci();
	managerContentEsqueci();
});

function managerContentEsqueci(){
	$("#hideMail").hide()
    $(".pass").click(function () {
      $("#hideMail").show(800)
      $("#groupHide1,#groupHide2,#groupHide3,.pass").hide(800)
    });

    $(".back-to-login").click(function () {
    	$('#hideMail').hide(800);
    	$("#groupHide1,#groupHide2,#groupHide3,.pass").show(800)
    });
}

function addMaskEsqueci(){
	$('.ipt-cpf-esqueci').mask('999.999.999-99',{clearIfNotMatch:true});
}

var validateformesqueci = false;
function validateMainFormEsqueci(){
	
	$('.form-esqueci-minha-senha').unbind('submit');
	$('.form-esqueci-minha-senha').submit(function(e){
		e.preventDefault();
		var count_validations = 0;
		
		_cpf = $('.ipt-cpf-esqueci');
		if(_cpf.val() == "" || !Ssx.isCpf(_cpf.val())){
			addErrorLabelEsqueci(_cpf);
		}else{
			count_validations++;
			removeErrorLabelEsqueci(_cpf);
		}

		if(count_validations >= 1){
			validateformesqueci = true;
			submitMainFormEsqueci();
		}
	});
}

function submitMainFormEsqueci(){
	if(validateformesqueci){
		$('.form-esqueci-minha-senha')[0].submit();
		$('.form-esqueci-minha-senha').unbind('submit');
		$('.form-esqueci-minha-senha').submit(function(e){
			e.preventDefault();
		});
	}
}

function addErrorLabelEsqueci(_obj){
	_obj.parent().find('.erro').css('display','block');
}

function removeErrorLabelEsqueci(_obj){
	_obj.parent().find('.erro').css('display','none');
}
