<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-BR" xml:lang="pt-BR" xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Promoção Fini Pega Prêmios</title>

  <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png" />
  <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png" />
  <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png" />
  <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png" />
  <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png" />
  <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png" />
  <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png" />
  <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png" />
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png" />
  <link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png" />
  <link rel="manifest" href="/manifest.json" />
  <meta name="msapplication-TileColor" content="#ffffff" />
  <meta name="msapplication-TileImage" content="/ms-icon-144x144.png" />
  <meta name="theme-color" content="#ffffff" />

  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

  {$ssx_head}

  <meta property="og:title" content="Promoção Pega Prêmio Fini" />
  <meta property="og:description" content="" />
  <meta property="og:url" content="" />
  <meta property="og:image" content="" />
  <meta name="twitter:title" content="Promoção Pega Prêmio Fini" />
  <meta name="twitter:image" content="" />
  <meta name="twitter:url" content="" />
  <meta name="twitter:card" content="summary_large_image" />
</head>

<body>
  {if isset($flashMessage)}
  <div class="modal fade flashMessage {$flashMessage.class}" id="myModal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body text-center center">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          {if $flashMessage.status eq 'success'}

          <!-- <svg class="icon icon-ok" version="1.1" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 138 138" xml:space="preserve">
            <circle fill="#64AF36" cx="69" cy="69" r="64" />
            <path fill="#FFFFFF"
              d="M69,10c-32.5,0-59,26.5-59,59s26.5,59,59,59s59-26.5,59-59S101.5,10,69,10 M69,0c38.1,0,69,30.9,69,69 s-30.9,69-69,69S0,107.1,0,69S30.9,0,69,0z" />
            <polygon fill="#FFFFFF" points="106.2,42.2 60,88.4 32.1,61 22.2,70.9 60,108.8 116.1,52.1 " />
          </svg> -->

          <svg class="icon icon-ok" xmlns="http://www.w3.org/2000/svg" width="138" height="138" viewBox="0 0 138 138">
            <g id="Grupo_212" data-name="Grupo 212" transform="translate(-570 -312)">
              <circle id="Elipse_253" data-name="Elipse 253" cx="69" cy="69" r="69" transform="translate(570 312)"
                fill="#562c7b" />
              <g id="Yes" transform="translate(595 343)">
                <rect id="Retângulo_460" data-name="Retângulo 460" width="88.286" height="88.286"
                  transform="translate(0)" fill="none" />
                <path id="Checkbox" d="M35.01,60.887,0,25.877l7.1-7.1,27.907,27.4L81.183,0l7.1,7.1Z"
                  transform="translate(0 11.037)" fill="#fff" />
              </g>
            </g>
          </svg>

          {else}
          <!-- <svg class="icon icon-erro" version="1.1" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 138 138" xml:space="preserve">
            <circle fill="#E20714" cx="69" cy="69" r="64" />
            <path fill="#FFFFFF"
              d="M69,10c-32.5,0-59,26.5-59,59s26.5,59,59,59s59-26.5,59-59S101.5,10,69,10 M69,0c38.1,0,69,30.9,69,69 s-30.9,69-69,69S0,107.1,0,69S30.9,0,69,0z" />
            <polygon fill="#FFFFFF"
              points="104.2,42.7 94.8,33.4 68.8,59.5 42.7,33.4 33.4,42.7 59.5,68.8 33.4,94.8 42.7,104.2 68.8,78.1 94.8,104.2 104.2,94.8 78.1,68.8 " />
          </svg> -->

          <svg class="icon icon-erro" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            width="138" height="138" viewBox="0 0 138 138">
            <defs>
              <clipPath id="clip-path">
                <rect width="63.699" height="63.699" fill="none" />
              </clipPath>
            </defs>
            <g id="Grupo_50" data-name="Grupo 50" transform="translate(-570 -312)">
              <circle id="Elipse_253" data-name="Elipse 253" cx="69" cy="69" r="69" transform="translate(570 312)"
                fill="#562c7b" />
              <g id="Yes" transform="translate(595 343)">
                <rect id="Retângulo_460" data-name="Retângulo 460" width="88.286" height="88.286"
                  transform="translate(0)" fill="none" />
              </g>
              <g id="Cancel" transform="translate(606.929 348.929)" clip-path="url(#clip-path)">
                <path id="União_3" data-name="União 3"
                  d="M31.849,37.64,5.79,63.7,0,57.906,26.057,31.849,0,5.79,5.79,0,31.849,26.057,57.906,0,63.7,5.79,37.64,31.849,63.7,57.906,57.906,63.7Z"
                  fill="#fff" />
              </g>
            </g>
          </svg>
          {/if}

          <h4 class="modal-title {if $flashMessage.status eq 'success'} success{else}oops {/if}">
            {$flashMessage.text}
          </h4>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(".flashMessage").modal("show"); 
  </script>
  {/if}

  <nav id="mainNav" class="navbar navbar-fixed-top navbar-expand-lg menu large">
    <div class="container">
      <div class="navbar-header">
        
        <button class="nav-tgl navbar-toggle bt-burger" type="button" data-toggle="collapse" data-target="#menu-principal">
          <span aria-hidden="true"></span>
        </button>

        <a href="{$siteurl}" class="navbar-brand">
          <i class="logo"></i>
        </a>
      </div>

      <div class="collapse navbar-collapse" id="menu-principal">

        <ul class="nav navbar-nav principal">
          {if isset($isIndex) && !isset($usuario)}
          <!-- somente aparece na pagina index e se o usuario não estiver logado -->
          <li>
            <a id="menu-cmp" class="txt-menu" href="{$siteurl}como-participar">COMO PARTICIPAR</a>
          </li>
          <li>
            <a id="menu-cad" class="txt-menu" href="{$siteurl}cadastre-se">CADASTRE-SE</a>
          </li>
          <li>
            <a id="menu-reg" class="txt-menu" href="{$siteurl}regulamento">REGULAMENTO</a>
          </li>
          <li>
            <a id="menu-prod" class="txt-menu" href="{$siteurl}faq">FAQ</a>
          </li>
          <li>
            <a class="txt-menu" href="{$siteurl}contato">CONTATO</a>
          </li>
          <li>
            <a class="txt-menu" href="{$siteurl}ganhadores">GANHADORES</a>
          </li>
          <li class="btn-nav">
            <a href="{$GoogleUrlLogin}">
              ENTRAR
            </a>
          </li>
          {/if}
        </ul>

        <ul class="nav navbar-nav navbar-right ul-bar" style="display: none;">
          {if !isset($isIndex) && !isset($usuario)}
          <li>
            <a class="btn-nav" href="{$siteurl}" title="Fechar">Fechar</a>
          </li>
          {/if} {if isset($usuario)}
          <!-- caso o usuario estiver logado aparece menu no canto direito -->
          <!-- menu logado -->
          <li class="link-header">
            <!-- caso usuario estiver na pagina do regulamento logado mostrar minha area -->
            {if isset($onRegulamento)}
            <a href="{$siteurl}minha-area" style="color:#FFF !important;">Minha área</a>
            {else}
            <a href="{$siteurl}regulamento">REGULAMENTOS</a>
            {/if}
          </li>
          <li>
            <a class="btn-nav" href="{$siteurl}logout" title="Sair">Sair</a>
          </li>
          <!-- fim menu logado -->
          {/if}
        </ul>
        
      </div>
    </div>
  </nav>

  <!-- Modal Ganhadores-->
  <div class="modal fade modal-ganhadores" id="ganhadoresModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">GANHADORES</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>

        <div class="modal-body">
          {if isset($ganhadores)}
          <table>
            <tbody>
              <tr class="titulo-tabela">
                <td>NOME</td>
                <td>ESTADO</td>
                <td>PRÊMIO</td>
              </tr>
              {foreach $ganhadores as $ganhador}
              <tr>
                <td>{$ganhador.nome}</td>
                <td>{$ganhador.estado}</td>
                <td>{$ganhador.premio}</td>
              </tr>
              {/foreach}
            </tbody>
          </table>
          {else}
          <h3 class="text-center ganhadores">Não há ganhadores ainda.</h3>
          {/if}
        </div>

      </div>
    </div>
  </div>
 
  <div class="bg-padrao">
