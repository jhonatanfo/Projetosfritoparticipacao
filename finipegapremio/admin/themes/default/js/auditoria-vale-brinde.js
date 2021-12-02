var killScroll = false;
var limit_default = 30;
$(function(){

	var status = $('.ipt-status').val();
	
	$('.btn-next-results').click(function(){
		animateLoader('in');
		killScroll = true;
		var data = {};
		var limit = $('.panel').length;
		data['limit']  = limit_default;
		data['offset'] = limit;
		if($('.find-value').val() != ""){
			data['where_field'] = new Array( $('.where').val(), "status_premio" );
			data['where_value'] = new Array( $('.find-value').val(), status);
		}else{
			data['where_field'] = "status_premio";
			data['where_value'] = status;
		}
		data['orderby'] = $('.orderby').val();
		data['orderbyside'] = $('.orderbyside').val();
		Ssx.ajax('AdminAjaxControl_searchValeBrindes',data,'scrollpage');
	});

	$('.btn-find-value').click(function(){
		if($('.find-value').val() != ""){
			$(".loader-gif").show();
			$('.page-controls').hide();
			var data = {};
			data['limit']  = limit_default;
			data['offset'] = 0;
			data['orderby'] = $('.orderby').val();
			data['orderbyside'] = $('.orderbyside').val();
			data['where_field'] = new Array( $('.where').val(), "status_premio" );
			data['where_value'] = new Array( $('.find-value').val(), status);
			$(".panel-group").empty();
			$('.btn-next-results').show();
			$('.btn-clear-find').show();
			Ssx.ajax('AdminAjaxControl_searchValeBrindes',data,'scrollpage');
		}
	});

	$('.btn-to-top').click(function(){
		$("html, body").animate({ scrollTop: $('.form-search').offset().top-150 }, "slow");
	});

	$(".form-search").submit(function(e){
		e.preventDefault();
	});

	$('.btn-clear-find').click(function(){
		$('.orderbyside').removeClass('btn-danger').addClass('btn-success');
		$('.orderbyside .glyphicon').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
		$('.orderbyside').val('ASC');
		$(".panel-group").empty();
		$('.find-value').val('');
		$('.where').val($('.where option:first').val());
		// $('.orderby').val($('.orderby option:first').val()).trigger('change');
		var data = {};
		data['limit'] = 30;
		data['offset'] = 0;
		data['where_field'] = "status_premio";
		data['where_value'] = status;
		data['orderby'] = 'id_fini_vale_brinde';
		data['orderbyside'] = 'ASC';
		Ssx.ajax('AdminAjaxControl_searchValeBrindes',data,'scrollpage');
		$(this).hide();
	});

	managerStatusValeBrinde();

});


function scrollpage(result){
	if(result.success){
		$('.form-search').find(".badge").text(result.rowCount);
		var content = '';
		for(i = 0; i < result.dados.length;i++){
			var dados = result.dados[i];
			content += createHtmlAccordion(dados);
		}
		killScroll = false;
		$('.count-result').text(result.rowCount);
		animateLoader('out',content);
	}
	if(result.success == false || (result.isNext == false && result.success == false)){
		var _text = "<h4>A busca não encontrou resultados.</h4>";
		$('.count-result').text('0');
		$('.panel-group').html(_text);
		$(".loader-gif").fadeOut(400,'swing',function(){});
		$('.btn-clear-find').show();
	}
	if(result.hasNext == false){
		$(".loader-gif").fadeOut(400,'swing',function(){});
		$('.page-controls').hide();
	}else{
		$(".loader-gif").fadeOut(400,'swing',function(){});
		$('.page-controls').show();
	}
}

function createHtmlAccordion(dados){
	var statusNotaFiscal = dados.status_premio.toLowerCase();
	var numeroNF = dados.numero ? dados.numero : "--";
	var panel_class = "";
	switch(statusNotaFiscal){
		case 'em_avaliacao':
			panel_class = "warning";
		break;
		case 'concedido':
			panel_class = "success";
		break;
		case 'nao_concedido':
			panel_class = "danger";
		break;
		default:
			panel_class = "warning";
	}
	var html = '';
		html +='			<div class="panel panel-'+panel_class+' panel-id-'+dados.id_fini_vale_brinde+'">';
		html +='			    <div class="panel-heading" role="tab" id="heading'+dados.id_fini_vale_brinde+'">';
		html +='			      <h4 class="panel-title">';
		html +='			        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'+dados.id_fini_vale_brinde+'" aria-expanded="true" aria-controls="collapse'+dados.id_fini_vale_brinde+'" style="font-size:14px;">';
		html +='			         <span class="glyphicon glyphicon-list-alt"></span> ID Vale-brinde: '+dados.id_fini_vale_brinde+' | Data : '+dados.data_vb+' | Horário : '+dados.horario_vb+' | Número NF : '+numeroNF;
		html +='			        </a>';
		html +='			      </h4>';
		html +='			    </div>';
		html +='			    <div id="collapse'+dados.id_fini_vale_brinde+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'+dados.id_nota_fiscal+'">';
		html +='			      <div class="panel-body">';
		html +='				   <div class="table-responsive">';
		html +='			        <table class="table table-bordered table-usuarios">';
		html +='						<tbody>';
											if(statusNotaFiscal != "em_avaliacao" || statusNotaFiscal == "em_avaliacao" && dados.id_fini_nota_fiscal){
		html +='							<tr>';
		html +='								<td>ID Vale-brinde</td>';
		html +='								<td>'+dados.id_fini_vale_brinde+'</td>';
		html +='							</tr>';
		html +='							<tr>';
		html +='	                            <td>';
		html +='	                               		Data/Horário Vale-brinde';
		html +='	                            </td>';
		html +='	                            <td>';
		html +='	                        		'+dados.data_vb+' '+dados.horario_vb;
		html +='	                           	</td>';
		html +='	                        </tr>';
		html +='							<tr>';
		html +='                                <td>Número NF</td>';
		html +='                                <td>';
		html +='                                 	<a href="'+_ssx_siteurl+'fini/cadastros-de-notas-fiscais?wf=id_fini_nota_fiscal&wv='+dados.id_nota_fiscal+'" target="_blank">';
		html +='                                   		'+dados.numero;
		html +='                                   	</a>';
		html +='                                </td>';
		html +='                            </tr>';
		html +='							<tr>';
		html +='								<td>CNPJ NF</td>';
		html +='								<td>';
		html +='									<a href="'+_ssx_siteurl+'fini/cadastros-de-notas-fiscais?wf=cnpj&wv='+dados.cnpj+'">';
		html +='									'+dados.cnpj;
		html +='								</td>';
		html +='							</tr>';
		html +='							<tr>';
		html +='								<td>Produtos NF</td>';
		html +='								<td>';
		html +='								'+dados.produtos;
		html +='								</td>';
		html +='							</tr>';
		html +='							<tr>';
		html +='								<td>Data Compra NF</td>';
		html +='								<td>';
		html +='									'+dados.data;
		html +='								</td>';
		html +='							</tr>';
		html +='							<tr>';
		html +='								<td>Cpf Usuário</td>';
		html +='								<td>';
		html +='									<a href="'+_ssx_siteurl+'fini/cadastros-de-usuarios?wf=cpf&wv='+dados.cpf+'">';
		html +='										'+dados.cpf;
		html +='									</a>';
		html +='								</td>';
		html +='							</tr>';
		html +='							<tr>';
		html +='				              <td colspan="2" class="text-center">';
		html +='				                <a href="'+_ssx_projecturl+'files/notas-fiscais/'+dados.imagem+'" data-extension="'+dados.imagem_extension+'" target="_blank">';
												  if(dados.imagem_extension == 'pdf'){
		html +='				                  	'+dados.imagem;
												  }else{
		html +='				                  	<img src="'+_ssx_projecturl+'files/notas-fiscais/'+dados.imagem+'" style="width:200px">';
												  }
		html +='				                </a>';
		html +='				              </td>';
		html +='				            </tr>';
		html +='							<tr>';
		html +='								<td>Data Cadastro NF</td>';
		html +='								<td>'+dados.data_criacao+'</td>';
		html +='							</tr>';
											if(statusNotaFiscal == 'em_avaliacao'){
		html +='							<tr>';
		html +='					        	<td colspan="2">';
		html +='					        		<div>';
		html +='					        			<button class="btn btn-success btn-premiar" data-vale-brinde-id="'+dados.id_fini_vale_brinde+'">';
		html +='					        				<i class="glyphicon glyphicon-ok"></i>';
		html +='					            			Conceder';
		html +='					            		</button>	';
		html +='					            		<button class="btn btn-danger btn-recusar" data-vale-brinde-id="'+dados.id_fini_vale_brinde+'">';
		html +='					            			<i class="glyphicon glyphicon-remove"></i>';
		html +='					            			Não Conceder';
		html +='					            		</button>	';
		html +='					            		<img src="'+_ssx_siteurl+'themes/default/img/loading.gif" class="loader-status hide">	';
		html +='					        		</div>';
		html +='					        	</td>';
		html +='					        </tr>';
											}	
											}else{
		html +='					        <tr>';
		html +='					        	<h3>Não houve nota fiscal premiada ainda.</h3>';
		html +='					        </tr>';										
											}

		html +='						</tbody>';
		html +='					</table>';
		html +='				  </div>';
		html +='				 </div>';
		html +='			    </div>';
		html +='			  </div>';
	return html;
}

function animateLoader(type,content){
	if(type == 'in'){
		$(".loader-gif").show();
		$('.page-controls').hide();
	}
	if(type == 'out'){
		$(".loader-gif").fadeOut(600,'swing',function(){
			$(".panel-group").append(content);
			managerStatusValeBrinde();
		});
	}
}


function managerStatusValeBrinde(){
	
	$('.btn-premiar').unbind();
	$('.btn-premiar').click(function(){
		var idValeBrinde = $(this).attr('data-vale-brinde-id');		
		var _btn = $(this);
		var callbackFunction = function(_btn){
			_btn.parent().find('button').addClass('hide');
			var _loader = _btn.parent().find('.loader-status');
			_loader.removeClass('hide');
		}
		// var msg = "Deseja realmente <b>CONCEDER</b>(enviar email da contemplação do vale-brinde) para o vale-brinde de ID: <b>"+idValeBrinde+"</b> ?";
		var msg = "Deseja realmente <b>CONCEDER</b> para o vale-brinde de ID: <b>"+idValeBrinde+"</b> ?";
		Modal(msg,false,'premiarVb',idValeBrinde,callbackFunction,_btn);
	});

	$('.btn-reavaliar').unbind();
	$('.btn-reavaliar').click(function(){
		var idValeBrinde = $(this).attr('data-vale-brinde-id');
		var _btn = $(this);
		var callbackFunction = function(_btn){
			_btn.parent().find('button').addClass('hide');
			var _loader = _btn.parent().find('.loader-status');
			_loader.removeClass('hide');
		}
		var msg ="Deseja realmente <b>REAVALIAR</b> a nota fiscal de ID: <b>"+ idValeBrinde+"</b> ?";
		Modal(msg,false,'reavaliarVb', idValeBrinde,callbackFunction,_btn);
	});	

	$('.btn-recusar').unbind();
	$('.btn-recusar').click(function(){
		var idValeBrinde = $(this).attr('data-vale-brinde-id');
		var _btn = $(this);
		var callbackFunction = function(_btn){
			_btn.parent().find('button').addClass('hide');
			var _loader = _btn.parent().find('.loader-status');
			_loader.removeClass('hide');
		}
		// var msg = "Deseja realmente <b>NÃO CONCECER</b>(enviar email informando da não contemplação) o vale-brinde de ID: <b>"+ idValeBrinde+"</b> ?";
		var msg = "Deseja realmente <b>NÃO CONCECER</b> o vale-brinde de ID: <b>"+ idValeBrinde+"</b> ?";
			// ACRESCENTAR CAMPO COM MOTIVO
			msg += "<br>";
			msg += "<textarea class='ipt-mensagem form-control' placeholder='Diga o motivo ou deixe em branco ...' style='margin-top:15px;'>";
			msg += "</textarea>";
		Modal(msg,false,'recusarVb', idValeBrinde,callbackFunction,_btn);
	});
	
}

function premiarVb(idValeBrinde){
	var dados = {};
	dados['id_vale_brinde'] = idValeBrinde;
	dados['status'] = 'concedido';
	Ssx.ajax('AdminAjaxControl_managerStatusValeBrinde',dados,'callbackPremiarVb');
}

function reavaliarVb(idValeBrinde){
	var dados = {};
	dados['id_vale_brinde'] = idValeBrinde;
	dados['status'] = 'avaliacao';
	Ssx.ajax('AdminAjaxControl_managerStatusValeBrinde',dados,'callbackReavaliarVb');	
}

function recusarVb(idValeBrinde){
	var dados = {};
	dados['id_vale_brinde'] = idValeBrinde;
	dados['status'] = 'nao_concedido';
	dados['motivo'] = $('.ipt-mensagem').val();
	Ssx.ajax('AdminAjaxControl_managerStatusValeBrinde',dados,'callbackRecusarVb');
}

function callbackPremiarVb(response){
	if(response.success){
		$('.panel-id-'+response.id_vale_brinde).fadeOut(600,'swing',function(){
			$(this).remove();
			$('.total-avaliada').text("("+response.total_vale_brinde.em_avaliacao+")");
			$('.total-concedidos').text("("+response.total_vale_brinde.concedido+")");
			$('.total-nao-concedidos').text("("+response.total_vale_brinde.nao_concedido+")");
			Modal("Nota fiscal está na aba de <b>Concedido(s)</b> agora!",true);
		});
	}else if(response.success ==false && response.error == 'vale_brinde_em_processo'){
		$('.btn-premiar[data-vale-brinde-id='+response.id_vale_brinde+'],.btn-recusar[data-vale-brinde-id='+response.id_vale_brinde+']').removeClass('hide');
		var _loader = $('.btn-premiar[data-vale-brinde-id='+response.id_vale_brinde+']').parent().find('.loader-status');
		_loader.addClass('hide');
		Modal("Problemas ao processar vale-brinde, pois já a um processo em andamento nesta mesma nota fiscal!",true);
	}else if(response.success ==false && response.error == 'email_nao_enviado'){
		$('.btn-premiar[data-vale-brinde-id='+response.id_vale_brinde+'],.btn-recusar[data-vale-brinde-id='+response.id_vale_brinde+']').removeClass('hide');
		var _loader = $('.btn-premiar[data-vale-brinde-id='+response.id_vale_brinde+']').parent().find('.loader-status');
		_loader.addClass('hide');
		Modal("Problemas ao enviar email de recusa pra <b>"+response.email+"</b> ,talvez seja um problema temporário, tente novamente mais tarde!");	
	}else if(response.success == false && response.error == 'nota_fiscal_nao_encontrada'){
		$('.btn-premiar[data-vale-brinde-id='+response.id_vale_brinde+'],.btn-recusar[data-vale-brinde-id='+response.id_vale_brinde+']').removeClass('hide');
		var _loader = $('.btn-premiar[data-vale-brinde-id='+response.id_vale_brinde+']').parent().find('.loader-status');
		_loader.addClass('hide');
		Modal("Problemas ao obter do vale-brinde nota fiscal!",true);				
	}else{
		$('.btn-premiar[data-vale-brinde-id='+response.id_vale_brinde+'],.btn-recusar[data-vale-brinde-id='+response.id_vale_brinde+']').removeClass('hide');
		var _loader = $('.btn-premiar[data-vale-brinde-id='+response.id_vale_brinde+']').parent().find('.loader-status');
		_loader.addClass('hide');
		Modal("Problemas processar vale-brinde da nota fiscal!",true);
	}
}

function callbackReavaliarVb(response){
	if(response.success){
		$('.panel-id-'+response.id_nota_fiscal).fadeOut(600,'swing',function(){
			$(this).remove();
			$('.total-avaliada').text("("+response.total_vale_brinde.em_avaliacao+")");
			$('.total-concedidos').text("("+response.total_vale_brinde.concedido+")");
			$('.total-nao-concedidos').text("("+response.total_vale_brinde.nao_concedido+")");
			Modal("Vale-brinde de ID: <b>"+response.id_vale_brinde+"</b> está na aba de avaliação agora!",true);
		});
	}else{
		$('.btn-premiar[data-vale-brinde-id='+response.id_vale_brinde+'],.btn-recusar[data-vale-brinde-id='+response.id_vale_brinde+']').removeClass('hide');
		var _loader = $('.btn-reavaliar[data-vale-brinde-id='+response.id_vale_brinde+']').parent().find('.loader-status');
		_loader.addClass('hide');
		Modal("Problemas processar vale-brinde da nota fiscal!");
	}
}

function callbackRecusarVb(response){
	if(response.success){
		var html = "<h3>Não houve nota fiscal premiada ainda.</h3>";
		$('.panel-id-'+response.id_vale_brinde).find('tbody').empty();
		$('.panel-id-'+response.id_vale_brinde).find('.table-responsive').prepend(html);
		$('.panel-id-'+response.id_vale_brinde).find('.numero-nf').empty().append('--');
		$('#collapse'+response.id_vale_brinde).collapse('hide');
		$('.total-avaliada').text("("+response.total_vale_brinde.em_avaliacao+")");
		$('.total-concedidos').text("("+response.total_vale_brinde.concedido+")");
		$('.total-nao-concedidos').text("("+response.total_vale_brinde.nao_concedido+")");
		Modal("Nota fiscal está na aba de <b>Não concedido(s)</b> agora!");
	}else{
		$('.btn-premiar[data-vale-brinde-id='+response.id_vale_brinde+'],.btn-recusar[data-vale-brinde-id='+response.id_vale_brinde+']').removeClass('hide');
		var _loader = $('.btn-recusar[data-vale-brinde-id='+response.id_vale_brinde+']').parent().find('.loader-status');
		_loader.addClass('hide');
		Modal("Problemas ao não conceder vale-brinde, talvez seja um problema temporário, tente novamente mais tarde!");	
	}
}

function Modal(msg,notificationMode,functionToCall,parameterToFunctionCall,callbackFunction,parameterToCallbackFunction){

	$(document).on('shown.bs.modal', '.modal', function () {
		$(".modal-backdrop").not(':last').remove();
	});

	$('.defaultModal').find('.modal-footer').removeClass('hide');
	
	if(msg && $('.defaultModal').find('.modal-body').length > 0){
		var _body = $('.defaultModal').find('.modal-body');
		_body.html(msg);	
	}else{
		console.log('Body modal not found.');
	}
	
	if(typeof notificationMode == 'undefined'){
		notificationMode = true;
	}

	if(notificationMode == true &&  $('.defaultModal').find('.modal-footer').length > 0){
		$('.defaultModal').find('.modal-footer').addClass('hide');
	}else{
		console.log('Footer on modal not found.')
	}	

	$('.defaultModal').modal('show');

	if(typeof functionToCall == 'undefined'){

	}else if(typeof window[functionToCall] == 'function'){
		$('.btn-submit-function').unbind('click');
		$('.btn-submit-function').click(function(){
			window[functionToCall](parameterToFunctionCall);	
			callbackFunction(parameterToCallbackFunction);
			$('.defaultModal').modal('hide');
			return true;
		});
	}else{
		console.log('Function to call not exists.');	
		return false;
	}				
	
}
