var array = null;
$(document).ready(function(){
    selectEstadoOnChange();    
});

function selectEstadoOnChange(){
    $("#estadoLojas").unbind('change');
    $('#estadoLojas').change(function(){
        obterLojas();
    });
}

function obterLojas(){
    if(array == null){
        var dados = {};
        Ssx.ajax('AjaxControl_getAllLojas',dados,'callbackGetAllLojas');    
    }else{
        var response = {};
        response["lojas"] = array;
        callbackGetAllLojas(response);
    }
}

function callbackGetAllLojas(response) {

    var estadoAtual = null;
    array = response.lojas;
    var lista = document.getElementById('list');
    var estado = document.getElementById('estado');
    estadoAtual = $('#estadoLojas').val();

    $(lista).empty();
    estado.innerHTML = '';

    if (estadoAtual != 'estado') {

        var newObj = array[estadoAtual];
        estado.innerHTML  = estadoAtual;


        for (var x = 0; x < newObj.length; x++) {
            var cidade = newObj[x];
            var ul = document.createElement('ul');

            var li1 = document.createElement('li');
            cidade.NOME_LOJA = cidade.NOME_LOJA == "--" ? cidade.NOME_RAZAO : cidade.NOME_LOJA;
            li1.innerHTML = cidade.NOME_LOJA+'<br>'+cidade.NOME_RAZAO;

            li1.style.textTransform = 'uppercase';

            var li2 = document.createElement('li');
            li2.innerHTML = cidade.ENDERECO + ', ' + cidade.NUMERO + ' - ' + cidade.BAIRRO + ' - ' + cidade.CIDADE;

            lista.appendChild(ul);
            ul.appendChild(li1);
            ul.appendChild(li2);
        }
    }

}