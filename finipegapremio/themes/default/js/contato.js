$(function () {
    addMask();
    validateMainForm();
});

function addMask() {
    var _MaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
        _Options = {
            onKeyPress: function (val, e, field, options) {
                field.mask(_MaskBehavior.apply({}, arguments), options);
            },
            clearIfNotMatch: true
        };
    // TELEFONE
    $('.ipt-telefone').mask(_MaskBehavior, _Options);
}

var validateform = false;

function validateMainForm() {
    $('.form').unbind('submit');
    $('.form').submit(function (e) {
        e.preventDefault();
        var count_validacoes = 0;

        // NOME
        var _nome = $('.ipt-nome');
        if (_nome.val() == "" || _nome.val().length < 2) {
            console.log('erro nome')
            addErrorLabel(_nome);
        } else {
            count_validacoes++;
            removeErrorLabel(_nome);
        }

        var _cpf = $('.ipt-cpf');
        if (_cpf.val() == "" || !Ssx.isCpf(_cpf.val())) {
            console.log('erro cpf')
            addErrorLabel(_cpf);
        } else {
            count_validacoes++;
            removeErrorLabel(_cpf);
        }

        // TELEFONE
        var _telefone = $('.ipt-telefone');
        if (_telefone.val() == "") {
            console.log('erro telefone')
            addErrorLabel(_telefone);
        } else {
            count_validacoes++;
            removeErrorLabel(_telefone);
        }

        // EMAIL
        var _email = $('.ipt-email');
        if (_email.val() == "" || !Ssx.isEmail(_email.val())) {
            console.log('erro email')
            addErrorLabel(_email);
        } else {
            count_validacoes++;
            removeErrorLabel(_email);
        }

        // MENSAGEM
        var _mensagem = $('.ipt-mensagem');
        if (_mensagem.val() == "") {
            console.log('erro mensagem')
            addErrorLabel(_mensagem);
        } else {
            count_validacoes++;
            removeErrorLabel(_mensagem);
        }

        if (count_validacoes >= 5) {
            validateform = true;
            submitMainForm();
        }

    });
}

function submitMainForm() {
    if (validateform) {
        console.log('aqui')
        $('.form')[0].submit();
        $('.form').unbind('submit');
        $('.form').submit(function (e) {
            e.preventDefault();
        });
    }
}


function addErrorLabel(_obj) {
    _obj.parent().addClass('has-error');
}

function removeErrorLabel(_obj) {
    _obj.parent().removeClass('has-error');
}
