var urlAtual = "";

$(function () {
    $(".text").overlayScrollbars({
        className: "os-theme-thick-dark",
        scrollbars: {
            clickScrolling: true
        },
        nativeScrollbarsOverlaid: {
            showNativeScrollbars: false,
            initialize: true
        },
    });
});

$(function () {
    addMaskLogin();
    validateMainLoginForm();
    managerContentParticipe();
    AOS.init();

    $(window).load(function () {
        closeMenuMobile();
    })

    // MOUSE EFFECT HOME PAGE
    var currentX = '';
    var currentY = '';
    var movementConstant = .030;
    $(document).mousemove(function (e) {
        if (currentX == '') currentX = e.pageX;
        var xdiff = e.pageX - currentX;
        currentX = e.pageX;
        if (currentY == '') currentY = e.pageY;
        var ydiff = e.pageY - currentY;
        currentY = e.pageY;
        $('.parallax div').each(function (i, el) {
            var movement = (i + 1) * (xdiff * movementConstant);
            var movementy = (i + 1) * (ydiff * movementConstant);
            var newX = $(el).position().left + movement;
            var newY = $(el).position().top + movementy;
            $(el).css('left', newX + 'px');
            $(el).css('top', newY + 'px');
        });
    });
    // MOUSE EFFECT HOME PAGE

    function closeMenuMobile() {
        $(".navbar-nav li a").click(function () {
            $(".navbar-collapse").removeClass("in");
        })
    }

    var toggled = false;
    const nav = document.getElementsByClassName('navbar-nav')[0];
    const btn = document.getElementsByClassName('nav-tgl')[0];

    btn.onclick = function (evt) {

        if (!toggled) {
            toggled = true;
            nav.classList.add('active');
        } else {
            toggled = false;
            nav.classList.remove('active');
        }
    }

    $(".close").click(function () {
        if (!toggled) {
            toggled = true;
            nav.classList.add('active');
        } else {
            toggled = false;
            nav.classList.remove('active');
        }
    })

    /***/

    $(document).on("scroll", function () {
        if ($(document).scrollTop() > 140) {
            $(".menu").removeClass("large").addClass("small");
        } else {
            $(".menu").removeClass("small").addClass("large");
        }
    });

});

// VALIDAÇÃO E LOGADO
function addMaskLogin() {
    $('.ipt-cpf-login').mask('999.999.999-99', { clearIfNotMatch: true });
    $('.ipt-cpf').mask('999.999.999-99', { clearIfNotMatch: true });
}

var validatedform = false;

function validateMainLoginForm() {
    $('.form-login').unbind('submit');
    $('.form-login').submit(function (e) {
        e.preventDefault();

        var count_validacoes = 0;

        var _cpf = $('.ipt-cpf-login');
        if (_cpf.val() == "" || !Ssx.isCpf(_cpf.val())) {
            addErrorLogin(_cpf);
        } else {
            count_validacoes++;
            removeErrorLogin(_cpf);
        }

        var _senha = $('.ipt-senha-login');
        if (_senha.val() == "") {
            addErrorLogin(_senha);
        } else {
            count_validacoes++;
            removeErrorLogin(_senha);
        }

        if (count_validacoes >= 2) {
            validatedform = true;
            submitMainLoginForm();
        }

    });
}

function submitMainLoginForm() {
    if (validatedform) {
        $('.form-login')[0].submit();
    }
}

function addErrorLogin(_obj) {
    _obj.parent().find('.erro').css('display', 'block');
}

function removeErrorLogin(_obj) {
    _obj.parent().find('.erro').css('display', 'none');
}

function managerContentParticipe() {

    $('.btn-back-esqueci-minha-senha').unbind('click');
    $('.btn-back-esqueci-minha-senha').click(function (e) {
        e.preventDefault()
        $('.content-form-login').fadeOut(400, 'swing', function () {
            $('.content-form-esqueci').css('display', 'table');
        });
    });

    $('.btn-back-login').unbind('click');
    $('.btn-back-login').click(function (e) {
        e.preventDefault()
        $('.content-form-esqueci').fadeOut(400, 'swing', function () {
            $('.content-form-login').css('display', 'table');
        });
    });

}

$(document).ready(function () {
    //INPUT
    var input = document.getElementById("imagem");

    if (input != undefined) {
        input.onchange = function () {
            if (input.files && input.files[0]) {
                //console.log(input.files[0].name,Math.round(input.files[0].size/1000))
                var size_kb = Math.round(input.files[0].size / 1000) + " kb";
                $("#l-file span").html("Imagem selecionada: " + input.files[0].name);
            }
        };
    }
});
// VALIDAÇÃO E LOGADO