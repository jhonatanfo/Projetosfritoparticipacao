$(function() {

    addMaskNota();
    addProduct();
    validateMainFormNota();
    searchProduct();
    managerEnableDisableProductInput();
    changeNameInputImageNotaFiscal();

});


function changeNameInputImageNotaFiscal(){
    $('.form-nota').find('.ipt-imagem').change(function(){
        var nameFile = "Selecione a imagem do seu cupom fiscal";
        if($(this).val() != ""){
            nameFile = document.getElementById("file-input").files[0].name;
            if(nameFile.length > 23){
                var startNameFile = nameFile.slice(0,10);
                var middleNameFile = "...";
                var endNameFile = nameFile.slice(-10);
                nameFile = startNameFile+middleNameFile+endNameFile;
            }
        }
        $('.form-nota').find('.name-file').text(nameFile);
    });
}


function addMaskNota() {
    $('.form-nota').find('.ipt-numero').mask('#');
    $('.form-nota').find('.ipt-cnpj').mask('00.000.000/0000-00', { clearIfNotMatch: true });
    $('.form-nota').find('.ipt-data-compra').mask('99/99/9999', { clearIfNotMatch: true });
    $('.form-nota').find('.ipt-quantidade').mask('99');
}

function addProduct() {
    $('.form-nota').find('.btn-mais-produto').unbind('click');
    $('.form-nota').find('.btn-mais-produto').click(function() {
        $('.content-produtos').append(createHtmlAddProduto());
        addMaskNota();
        removeProduct();
        searchProduct();
        managerEnableDisableProductInput();
    });
}

function removeProduct() {
    $('.form-nota').find('.btn-menos-produto').unbind('click');
    $('.form-nota').find('.btn-menos-produto').click(function() {
        var _div = $(this).parent().parent().parent();
        _div.fadeOut('slow', function() {
            _div.remove();
        });
    });
}

function managerEnableDisableProductInput(){
    $('.ipt-tipo').unbind('change');
    $('.ipt-tipo').change(function(){
        $(this).parent().parent().find('.ipt-produto').val('');
        $(this).parent().parent().find('.ipt-quantidade').val('');
        if($(this).val()){
            $(this).parent().parent().find('.ipt-produto').removeAttr('disabled');    
        }else{
            $(this).parent().parent().find('.ipt-produto').attr('disabled','disabled');
        }        
    });
}

function searchProduct() {
    addSearchOnFields();
    clearSearchBoxOnFields();
}

function addSearchOnFields() {
    $('.form-nota').find('.ipt-produto').unbind('keyup');
    $('.form-nota').find('.ipt-produto').keyup(function(e) {
        $(this).removeClass('search-active');
        $(this).addClass('search-active');
        $(this).parent().find('.ipt-id-produto').val("");
        var keyword = $(this).val();
        var type = $(this).parent().parent().parent().find('.ipt-tipo').val();
        var dados = {};
        dados['keyword'] = keyword;
        dados['type'] = type;
        Ssx.ajax('AjaxControl_searchProducts', dados, 'callbackSearchProduct');
    });
}

function clearSearchBoxOnFields() {
    $('.form-nota').find('.ipt-produto').unbind('blur');
    $('.form-nota').find('.ipt-produto').blur(function() {
        var _ipt = $(this);
        setTimeout(function() {
            if (_ipt.parent().find('.ipt-id-produto').val() == "") {
                _ipt.val('');
            }
            $('.search-product').empty().css('display', 'none');
            _ipt.removeClass('search-active');
        }, 200);
    });
}

function callbackSearchProduct(response) {
    if (response.success) {
        var produtos = response.produtos;
        var html = "";
        for (var i = 0; i < produtos.length; i++) {
            var produto = produtos[i];
            html += createHtmlSearchProduct(produto);
        }
        $('.form-nota').find('.search-active').parent().find('.search-product').empty().css('display', 'block').append(html);
        selectProduct();
        // putCursorOnProducts();
    } else {
        $('.form-nota').find('.search-active').parent().find('.search-product').empty().css('display', 'none');
    }
}


function createHtmlSearchProduct(produto) {

    var html = "";
    html += "<p data-id='" + produto.id + "' class='produto'><a href='javascript: void(0);' id='produto-id-"+produto.id+"' data-id='" + produto.id + "' class='produto-link'>" + produto.nome + "</a></p>";
    return html;
}

function selectProduct() {
    console.log('123');
    $('.form-nota').find('.produto').unbind('click');
    $('.form-nota').find('.produto').click(function() {
        var nome = $(this).text();
        var id = $(this).attr('data-id');
        console.log(nome,id);
        $(this).parent().parent().find('.ipt-id-produto').val(id);
        $(this).parent().parent().find('.ipt-produto').val(nome);
        $(this).parent().css('display', 'none');
    });
    // console.log(e);
}


function createHtmlAddProduto() {
    var html = '';

    html+= '<div class="content-produto">';
    html+= '    <div class="label-float label-tipo">';
    html+= '      <select class="ipt-tipo" name="tipo[]">';
    html+= '          <option value="">--Selecione</option>';
    html+= '          <option value="KIT">Kit</option>';
    html+= '          <option value="INDIVIDUAL">Individual</option>';
    html+= '      </select>';
    html+= '      <label for="tipo">Tipo de produto</label>';
    html+= '      <p class="erro">Preencha o tipo de produto</p>';
    html+= '    </div>';
    html+= '    <div class="float-icon">';
    html+= '      <div class="content-input-three-up label-float">';
    html+= '        <input type="hidden" class="ipt-id-produto" name="id_produto[]" />';
    html+= '        <input type="text" class="input-left ipt-produto" name="produto[]" autocomplete="off" placeholder=" " required />';
    html+= '        <label for="produto">Produto</label>';
    html+= '        <div class="search-product" style="display: none;"></div>';
    html+= '        <p class="erro">Pesquise e selecione um produto</p>';
    html+= '      </div>';
    html+= '      <div class="content-input-three">';
    html+= '        <span style="cursor: pointer;" class="btn-menos-produto">';
    html+= '<svg xmlns="http://www.w3.org/2000/svg" width="52" height="50" viewBox="0 0 52 50">';
    html+= '  <g id="Grupo_212" data-name="Grupo 212" transform="translate(-865 -1020)">';
    html+= '    <path id="Caminho_226" data-name="Caminho 226" d="M26,0C40.359,0,52,11.193,52,25S40.359,50,26,50,0,38.807,0,25,11.641,0,26,0Z" transform="translate(865 1020)" fill="#562c7b"/>';
    html+= '    <g id="_" data-name="+" transform="translate(585 927)">';
    html+= '      <path id="União_1" data-name="União 1" d="M-4604,7V9h-16V7Z" transform="translate(4918 111)" fill="#fff"/>';
    html+= '    </g>';
    html+= '  </g>';
    html+= '</svg>';
    html+= '        </span>';
    html+= '      </div>';
    html+= '    </div>';
    html+= '    <div class="content-input-three label-float">';
    html+= '      <input type="text" placeholder=" " name="quantidade[]" class="ipt-quantidade" required/>';
    html+= '      <label for="quantidade">Quantidade</label>';
    html+= '      <p class="erro">Preencha a quatidade do produto(s)</p>';
    html+= '    </div>';
    html+= '</div>';
    return html;
}

var validateformNota = false;
var validatenumeronf = false;
var validatecnpj = false;
var array_errors_nota = [];

function validateMainFormNota() {
    $('.form-nota').unbind('submit');
    $('.form-nota').submit(function(e){
        e.preventDefault();

        var count_validacoes = 0;
        var limit_necessary = 4;

        var _numero = $('.form-nota').find('.ipt-numero');
        if (_numero.val() == "") {
            var msg = "Preencha o número da nota fiscal";
            addErrorLabel(_numero,msg);
        } else {
            count_validacoes++;
            removeErrorLabel(_numero);
        }
        
        //Datas PRODUÇÃO
        // var _ini_promo_data = new Date('January 06, 2020 00:00:00');
        // var _fim_promo_data = new Date('February 14, 2020 23:59:59');
        
        /*
            Datas DESENVOLVIMENTO
        */
        var _ini_promo_data = new Date('November 20, 2019 00:00:00');
        var _fim_promo_data = new Date('February 14, 2020 23:59:59');

        var _data_compra_obj = $('.form-nota').find('.ipt-data-compra');
        var _atual_data = new Date();
        var _arr_data_nota = _data_compra_obj.val().split('/');
        var _data_compra = new Date(Ssx.monthDescriptionByNumber(_arr_data_nota[1])+" "+_arr_data_nota[0]+", "+ _arr_data_nota[2]);
        
        if (!Ssx.convertDateStrToDateObj(_data_compra_obj.val()) || _data_compra > _atual_data || _data_compra < _ini_promo_data || _data_compra > _fim_promo_data) {
            var msg = "Preencha uma data de compra válida";
            addErrorLabel(_data_compra_obj,msg);
        } else {
            count_validacoes++;
            removeErrorLabel(_data_compra_obj);
        }

        var _cnpj = $('.form-nota').find('.ipt-cnpj');
        if (_cnpj.val() == "" || !Ssx.isCnpj(_cnpj.val())) {
            var msg = "Preencha um CNPJ válido";
            addErrorLabel(_cnpj,msg);
        } else {
            count_validacoes++;
            removeErrorLabel(_cnpj);
        }

        var _imagem = $('.form-nota').find('.ipt-imagem');
        if (_imagem.val() == "") {
            var msg = "Selecione uma imagem | Tamanho máximo: 10MB. Formatos: JPG,JPEG";
            addErrorLabel(_imagem,msg);
        } else {
            count_validacoes++;
            removeErrorLabel(_imagem);
        }


        var total_kits = 0;
        var _total_produtos = $('.form-nota').find('.content-produto').length;

        limit_necessary = (limit_necessary + (_total_produtos*3));

        var _qtd={};
        _qtd['kit'] = 0;
        _qtd['individual'] = 0;

        for(var i=0;i<_total_produtos;i++){
            
            var _content_produto = $($('.form-nota').find('.content-produto')[i]);
            var _tipo_produto = _content_produto.find('.ipt-tipo');
            var _produto = _content_produto.find('.ipt-produto'); 
            var _quantidade = _content_produto.find('.ipt-quantidade');


            if(_tipo_produto.val() == ""){
                var msg = "Selecione um tipo de produto";
                addErrorLabel(_tipo_produto,msg);
            }else{
                count_validacoes++;
                removeErrorLabel(_tipo_produto);
            }

            if(_produto.val() == ""){
                var msg = "Pesquise e selecione um produto";
                addErrorLabel(_produto,msg);
            }else{
                count_validacoes++;
                removeErrorLabel(_produto);
            }                        


            if(_quantidade.val() == "" || parseInt(_quantidade.val()) <= 0){
                
                var msg = "Preencha a quantidade de produtos";
                addErrorLabel(_quantidade,msg);

            }else{  

                if(_tipo_produto.val() == 'KIT'){
                    _qtd['kit'] += parseInt(_quantidade.val());
                }else if(_tipo_produto.val() == 'INDIVIDUAL'){
                    _qtd['individual'] += parseInt(_quantidade.val());
                }
                
                count_validacoes++;
                removeErrorLabel(_quantidade);
            }

        }

        total_kits = (_qtd['kit']+Math.floor(_qtd['individual']/2));
        
        if(total_kits < 1){
            var msg = "Preencha a quantidade de produto(s) (mínima de 1 kit ou 2 produtos)";
            addErrorLabel($('.form-nota').find('.ipt-quantidade'),msg);
        }else if(total_kits > 100) {
            var msg = "Preencha entre as quantidades premitidas(mínimo de 1 kit ou 2 produtos ou máximo de 100 kit ou 200 produtos";
            addErrorLabel($('.form-nota').find('.ipt-quantidade'),msg);
        }else {
            count_validacoes++;
            removeErrorLabel($('.form-nota').find('.ipt-quantidade'));
        }
        if (count_validacoes >= limit_necessary) {
            validateformNota = true;
            checkNumeroNotaFiscal();
        }

        //console.log(count_validacoes, limit_necessary);
    });

}


function checkNumeroNotaFiscal() {
    if(validateformNota){
        var _numero = $('.form-nota').find('.ipt-numero').val();
        var _cnpj = $('.form-nota').find('.ipt-cnpj').val();
        var dados = {};
        dados['numero'] = _numero;
        dados['cnpj'] = _cnpj;
        Ssx.ajax("AjaxControl_validateHasNfAndCnpj", dados, "checkCnpjNotaFiscal");    
    }else{
        console.log('nota fiscal não validada!');
    }    
}

function checkCnpjNotaFiscal(response){
     if (response.success) {
        validatenumeronf = true;
        var _cnpj = $('.form-nota').find('.ipt-cnpj').val();
        var dados = {};
        dados['cnpj'] = _cnpj;
        Ssx.ajax("AjaxControl_validateHasCnpj", dados, "submitMainForm");   
    }else{
        var _numero = $('.form-nota').find('.ipt-numero');
        var msg = "Número de nota fiscal inválido!";
        addErrorLabel(_numero,msg);
    }
}

function submitMainForm(response) {
    if (response.success) {
        validatecnpj = true;
        if (validateformNota && validatenumeronf &&  validatecnpj) {
            $('.form-nota')[0].submit();
            $('.form-nota').unbind('submit');
            $('.form-nota').submit(function(e) {
                e.preventDefault();
            });
        }
    } else {
        var _cnpj = $('.form-nota').find('.ipt-cnpj');
        var msg = "CNPJ não participante da promoção.";
        addErrorLabel(_cnpj,msg);
    }
}

function addErrorLabel(_obj,msg){
     $('html, body').scrollTop($('.form-nota').offset().top-100);

     if(_obj.hasClass('ipt-imagem')){
        _obj.parent().find('.erro').attr('style','display:block;');
     }

     if(_obj.hasClass('ipt-numero')){
        _obj.parent().find('.infos-nf').css('top','35%');
     }

    _obj.parent().find('.erro').text(msg);
    _obj.parent().addClass('has-error');
}

function removeErrorLabel(_obj) {
    if(_obj.hasClass('ipt-imagem')){
        _obj.parent().find('.erro').removeAttr('style','display:block;');
     }
     if(_obj.hasClass('.ipt-numero')){
        _obj.parent().find('.infos-nf').css('top','50%');
     }
    _obj.parent().removeClass('has-error');
}