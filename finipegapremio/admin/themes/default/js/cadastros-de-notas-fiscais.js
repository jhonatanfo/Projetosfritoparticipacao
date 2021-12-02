var killScroll = false;
var limit_default = 30;
$(function(){

  $('.btn-next-results').click(function(){
    animateLoader('in');
    killScroll = true;
    var data = {};
    var limit = $('.panel').length;
    data['limit']  = limit_default;
    data['offset'] = limit;
    if($('.find-value').val() != ""){
      data['where_field'] = $('.where').val();
      data['where_value'] = $('.find-value').val();
    }
    data['orderby'] = $('.orderby').val();
    data['orderbyside'] = $('.orderbyside').val();
    Ssx.ajax('AdminAjaxControl_searchNotas',data,'scrollpage');
  });

  $('.orderby').change(function(){
    animateLoader('in');
    $(".panel-group").empty();
    var data = {};
    data['limit']  = limit_default;
    data['offset'] = 0;
    if($('.find-value').val() != ""){
      data['where_field'] = $('.where').val();
      data['where_value'] = $('.find-value').val();
    }
    data['orderby'] = $(this).val();
    data['orderbyside'] = $('.orderbyside').val();
    $('.btn-next-results').show();
    $('.btn-clear-find').show();
    Ssx.ajax('AdminAjaxControl_searchNotas',data,'scrollpage');
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
      data['where_field'] = $('.where').val();
      data['where_value'] = $('.find-value').val();
      $(".panel-group").empty();
      $('.btn-next-results').show();
      $('.btn-clear-find').show();
      Ssx.ajax('AdminAjaxControl_searchNotas',data,'scrollpage');
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
    $('.orderby').val($('.orderby option:first').val()).trigger('change');
    $(this).hide();
    

  });
  $('.orderbyside').click(function(){
    if($(this).val() == 'ASC'){
      animateLoader('in');
      $(this).removeClass('btn-success').addClass('btn-danger');
      $('.orderbyside .glyphicon').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
      $(this).val('DESC');
      var data = {};
      data['limit']  = limit_default;
      data['offset'] = 0;
      data['orderby'] = $('.orderby').val();
      data['orderbyside'] = $('.orderbyside').val();
      data['where_field'] = $('.where').val();
      data['where_value'] = $('.find-value').val();
      $(".panel-group").empty();
      $('.btn-next-results').show();
      $('.btn-clear-find').show();
      Ssx.ajax('AdminAjaxControl_searchNotas',data,'scrollpage');

    }else{
      animateLoader('in');
      $(this).removeClass('btn-danger').addClass('btn-success');
      $('.orderbyside .glyphicon').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
      $(this).val('ASC');
      var data = {};
      data['limit']  = limit_default;
      data['offset'] = 0;
      data['orderby'] = $('.orderby').val();
      data['orderbyside'] = $('.orderbyside').val();
      data['where_field'] = $('.where').val();
      data['where_value'] = $('.find-value').val();
      $(".panel-group").empty();
      $('.btn-next-results').show();
      $('.btn-clear-find').show();
      Ssx.ajax('AdminAjaxControl_searchNotas',data,'scrollpage');
    }
  });

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
	
	var html = '';
		html +='			<div class="panel panel-default panel-id-'+dados.id_nota_fiscal+'">';
		html +='			    <div class="panel-heading" role="tab" id="heading'+dados.id_nota_fiscal+'">';
		html +='			      <h4 class="panel-title">';
		html +='			        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'+dados.id_nota_fiscal+'" aria-expanded="true" aria-controls="collapse'+dados.id_nota_fiscal+'" style="font-size:14px;">';
		html +='			         <span class="glyphicon glyphicon-list-alt"></span> ID: '+dados.id_nota_fiscal+' | Número: '+dados.numero+' | CNPJ: '+dados.cnpj+' | Data Compra: '+dados.data+' | CPF: '+dados.cpf;
		html +='			        </a>';
		html +='			      </h4>';
		html +='			    </div>';
		html +='			    <div id="collapse'+dados.id_nota_fiscal+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'+dados.id_nota_fiscal+'">';
		html +='			      <div class="panel-body">';
		html +='				   <div class="table-responsive">';
		html +='			        <table class="table table-bordered table-usuarios">	';
		html +='						<tbody>';
		html +='							<tr>';
		html +='								<td>ID</td>';
		html +='								<td>'+dados.id_nota_fiscal+'</td>';
		html +='							</tr>';
		html +='							<tr>';
		html +='								<td>Número</td>';
		html +='								<td>'+dados.numero+'</td>';
		html +='							</tr>';
		html +='							<tr>';
		html +='								<td>CNPJ</td>';
		html +='								<td>';
		html +='									<a href="'+_ssx_siteurl+'fini/cadastros-de-notas-fiscais?wf=cnpj&wv='+dados.cnpj+'">';
		html +='									'+dados.cnpj;
		html +='								</td>';
		html +='							</tr>';
		html +='							<tr>';
		html +='								<td>Produtos</td>';
		html +='								<td>';
		html +='								'+dados.produtos;
		html +='								</td>';
		html +='							</tr>';
		html +='							<tr>';
		html +='								<td>Data Compra</td>';
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
		html +='								<td>Data Cadastro</td>';
		html +='								<td>'+dados.data_criacao+'</td>';
		html +='							</tr>';
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

		});
	}
}
