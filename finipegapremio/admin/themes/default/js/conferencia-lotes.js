$(function(){
	
	btnEmailClick();

});

function btnEmailClick(){
	$('.btn-email').unbind('click');
	$('.btn-email').click(function(){
		var _id_usuario  = $(this).attr('data-id-usuario');
		var _id_codigo_uber = $(this).attr('data-id-codigo-uber');
		var _old_voucher = $(this).attr('data-old-voucher');
		$('.ipt-old-voucher').empty().val(_old_voucher);
		showModalNewVoucher();		
		setBtnSubmitEnvioEmail(_id_codigo_uber);
		var _new_voucher = $('.ipt-novo-voucher').val();
	});
}

function showModalNewVoucher(){
	$('.defaultModal').modal('show');
}

function hideModalNewVoucher(){
	$('.defaultModal').modal('hide');
}

function setBtnSubmitEnvioEmail(id_codigo_uber){
	var _id_usuario  = $('.btn-email-'+id_codigo_uber).attr('data-id-usuario');
	var _id_codigo_uber = $('.btn-email-'+id_codigo_uber).attr('data-id-codigo-uber');
	var _old_voucher = $('.btn-email-'+id_codigo_uber).attr('data-old-voucher');
	$('.btn-submit-function').attr('data-id-usuario',_id_usuario);
	$('.btn-submit-function').attr('data-id-codigo-uber',_id_codigo_uber);
	$('.btn-submit-function').attr('data-old-voucher',_old_voucher);
	btnSubmitFormNewVoucher();
}

function btnSubmitFormNewVoucher(){
	$('.btn-submit-function').unbind('click');
	$('.btn-submit-function').click(function(){
		var data = {};
		var _new_voucher = $('.ipt-novo-voucher').val();
		data['id_codigo_uber'] = $(this).attr('data-id-codigo-uber');
		data['id_usuario'] = $(this).attr('data-id-usuario');
		data['new_voucher_link'] = _new_voucher;
		data['old_voucher_link'] = $(this).attr('data-old-voucher');
		changeVoucherLinkAndSendEmailToUser(data);		
		hideModalNewVoucher();
	});
}

function changeVoucherLinkAndSendEmailToUser(data){
	Ssx.ajax('AdminAjaxControl_changeVoucherLinkAndSendEmailToUser',data,'callbackChangeVoucherLinkAndSendEmailToUser');
}

function callbackChangeVoucherLinkAndSendEmailToUser(result){
	if(result.success){
		var _id_codigo_uber = result.parameters.id_codigo_uber;
		var msg = "Email enviado com sucesso!";
		showModalInformacaoCallback(msg);
	}
}

function showModalInformacaoCallback(msg){
	$('.informacao-callback').find('.modal-body').empty();
	$('.informacao-callback').find('.modal-body').append(msg);
	$('.informacao-callback').modal('show');
	$('.informacao-callback').on('hidden.bs.modal', function () {
    	window.location = _ssx_siteurl+'nazca/conferencia-lotes';
	});
}

