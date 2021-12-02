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
    Ssx.ajax('AdminAjaxControl_searchUsers',data,'scrollpage');
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
    Ssx.ajax('AdminAjaxControl_searchUsers',data,'scrollpage');
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
      Ssx.ajax('AdminAjaxControl_searchUsers',data,'scrollpage');
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
      Ssx.ajax('AdminAjaxControl_searchUsers',data,'scrollpage');

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
      Ssx.ajax('AdminAjaxControl_searchUsers',data,'scrollpage');
    }
  });

});

  function scrollpage(response){
    if(response.success){
      $('.form-search').find(".badge").text(response.rowCount);
      var content = '';
      for(i = 0; i < response.dados.length;i++){
        var dados = response.dados[i];
        content += createHtmlAccordion(dados);
      }
      killScroll = false;
      $('.count-result').text(response.rowCount);
      animateLoader('out',content);
    }
    if(response.success == false || (response.isNext == false && response.success == false)){
      var _text = "<h4>A busca não encontrou resultados.</h4>";
      $('.count-result').text('0');
      $('.panel-group').html(_text);
      $(".loader-gif").fadeOut(400,'swing',function(){});
      $('.btn-clear-find').show();
    }
    if(response.hasNext == false){
      $(".loader-gif").fadeOut(400,'swing',function(){});
      $('.page-controls').hide();
    }else{
      $(".loader-gif").fadeOut(400,'swing',function(){});
      $('.page-controls').show();
    }
  }

function createHtmlAccordion(dados){
	
	dados['complemento'] = dados['complemento'] != '' ? ' , '+dados['complemento'] : '';

	var html = '';
			html+='	  <div class="panel panel-default panel-id-'+dados.id_usuario+'">';
			html+='	    <div class="panel-heading" role="tab" id="heading'+dados.id_usuario+'">';
			html+='	      <h4 class="panel-title">';
			html+='	        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'+dados.id_usuario+'" aria-expanded="true" aria-controls="collapse'+dados.id_usuario+'" style="font-size:14px;">';
			html+='	         <span class="glyphicon glyphicon-list-alt"></span> ID: '+dados.id_usuario+' Nome :  '+dados.nome+'  '+dados.sobrenome+' | Cpf : '+dados.cpf+' | Total NF : '+dados.tot_not;
			html+='		        </a>';
			html+='		      </h4>';
			html+='		    </div>';
			html+='		    <div id="collapse'+dados.id_usuario+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'+dados.id_usuario+'">';
			html+='		      <div class="panel-body">';
			html+='		       <div class="table-responsive">';
			html+='		        <table class="table table-bordered table-usuarios">';
			html+='					<tbody>';
			html+='						<tr class="row-id-usuario-'+dados.id_usuario+'">';
			html+='							<td>Nome</td>';
			html+='							<td>'+dados.nome+'</td>';
			html+='						</tr>';
			html+='						<tr>';
			html+='							<td>Sobrenome</td>';
			html+='							<td>';
			html+='								'+dados.sobrenome;
			html+='							</td>';
			html+='						</tr>';
			html+='						<tr>';
			html+='							<td>Data Nascimento</td>';
			html+='							<td>';
			html+='								'+dados.data_nascimento;
			html+='							</td>';
			html+='						</tr>';
			html+='						<tr>';
			html+='							<td>Cpf</td>';
			html+='							<td>'+dados.cpf+'</td>';
			html+='						</tr>';
      html+='           <tr>';
      html+='             <td>Sexo</td>';
      html+='             <td>'+dados.sexo+'</td>';
      html+='           </tr>';
			html+='						<tr>';
			html+='							<td>Telefone</td>';
			html+='							<td>'+dados.telefone+'</td>';
			html+='						</tr>';
			html+='						<tr>';
			html+='							<td>Celular</td>';
			html+='							<td>'+dados.celular+'</td>';
			html+='						</tr>';
			html+='						<tr>';
			html+='							<td>Email</td>';
			html+='							<td>'+dados.email+'</td>';
			html+='						</tr>';

			html+='						<tr>';
			html+='							<td>Cep</td>';
			html+='							<td>'+dados.cep+'</td>';
			html+='						</tr>';
			html+='						<tr>';
			html+='							<td>Endereço</td>';
			html+='							<td>';
			html+='								'+dados.logradouro+' , '+dados.numero+' '+dados.complemento+', '+dados.bairro+' , '+dados.cidade+' - '+dados.uf;
			html+='							</td>';
			html+='						</tr>';
      
			html+='						<tr>';
			html+='							<td>Termos</td>';
			html+='							<td>'+dados.termos+'</td>';
			html+='						</tr>';
			html+='						<tr>';
			html+='							<td>Newsletter</td>';
			html+='							<td>'+dados.newsletter+'</td>';
			html+='						</tr>';
			html+='						<tr>';
			html+='							<td>Total Notas Cadastradas</td>';
			html+='							<td>';
											if(parseInt(dados.tot_not) > 0){
			html+='								<a href="'+_ssx_siteurl+'fini/cadastros-de-notas-fiscais?wf=cpf&wv='+dados.cpf+'">';
			html+='									'+dados.tot_not;
			html+='								</a>';
											}else{
			html+='									'+dados.tot_not;									
											}				
			html+='							</td>';
			html+='						</tr>';
			html+='						<tr>';
			html+='							<td>Data Criação</td>';
			html+='							<td>'+dados.data_criacao+'</td>';
			html+='						</tr>';					
      html+='           <tr>';
      html+='             <td>Data Alteração</td>';
      html+='             <td>'+dados.data_alteracao+'</td>';
      html+='           </tr>';         
			html+='				</tbody>';
			html+='			</table>';
			html+='		   </div>';
			html+='		  </div>';
			html+='	    </div>';
			html+='	  </div>';
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