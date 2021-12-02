 
{if isset($hasValeBrinde)}
<!-- Modal -->
<div class="modal fade modal-participacao modal-vale-brinde" id="modalValeBrinde" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
        
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>

                <i class="pers-modal-01"></i>
                <h3>Sua participação<br>está em uma posição premiada!</h3>
                <p>Aguarde o nosso contato por telefone ou e-mail para a entrega do 
                    seu prêmio. Guarde seu cupom fiscal  original, o qual será exigido 
                    como condição para entrega do prêmio.</p>
            </div>
        
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#modalValeBrinde").modal("show"); 
</script>
{/if}

<br /><br /><br /><br />
<div class="container-minha-area">
<div class="container">
<div class="row">
    <div class="col-md-12">
      <h1>Olá, {$usuario.nome}</h1>
      <p>Aqui você pode cadastrar um novo cupom, ter acesso aos seus dados de cadastro e visualizar seus números da sorte.</p>
    </div>
</div>
<div class="header">
  <div class="row">          
    <div class="col-md-4">
      <button id="btn-1">Cadastrar cupom</button>
    </div>
    <div class="col-md-4">
      <button id="btn-2">Meus dados</button>
    </div>
    <div class="col-md-4">
      <button id="btn-3">Números da sorte</button>
    </div>
  </div>
</div>

<div class="container-body-one">
  <div class="row">
      <h2>Adicionar cupom fiscal</h2>
      <form  method="POST" action="{$siteurl}adicionar-nota-fiscal" class="form form-nota" enctype="multipart/form-data">
        <input type="hidden" name="_csrfTokenNotaFiscal"value="{$csrfTokenNotaFiscal}"/>
      
        <div class="col-md-offset-4 col-md-4">
          <div class="file-upload">
              <label for="file-input" class="name-file" style="cursor: pointer;">
                <p>Selecione a imagem do seu cupom fiscal</p>
              </label>
              <input id="file-input" type="file" name="imagem" class="ipt-imagem" />
              <p class="erro"></p>
          </div>
          <small>(FORMATOS: PNG, JPEG, JPG OU PDF / <br> TAMANHO MÁXIMO: 10MB)</small>

          <div class="content-input  label-float">
            <input type="text" class="ipt-numero" name="numero" placeholder=" " required />
            <label for="numero">Número da nota fiscal</label>
            <img src="{$siteurl}themes/default/img/icon-help.png" data-toggle="modal" data-target="#myModal" class="position-icon" alt=""/>
            <p class="erro">Preencha o número da nota fiscal</p>
          </div>

          <div class="content-input  label-float">
            <input type="text" placeholder="" class="ipt-data-compra" name="data_compra" required/>
            <label for="data_compra">Data da compra</label>
            <p class="erro">Preencha a data de compra</p>
          </div>

          <div class="content-input  label-float">
            <input type="text" placeholder=" " class="ipt-cnpj" name="cnpj" required />
            <label for="cnpj">CNPJ do Estabelecimento</label>
            <p class="erro">Preencha o CNPJ do estabelecimento</p>
          </div>
        </div>

        <div class="col-md-offset-1 col-md-10">
          <p class="text">
            Insira as informações abaixo para cada kit existente na nota fiscal.
            Se houver mais de um produto, clique no botão “+” para adicionar.
          </p>
        </div>

      <div class="col-md-offset-4 col-md-4">
        
        <div class="content-produtos">

          <div class="content-produto">

            <div class="label-float label-tipo">
              <select class="ipt-tipo" name="tipo[]">
                  <option value="">--Selecione</option>
                  <option value="KIT">Kit</option>
                  <option value="INDIVIDUAL">Individual</option>
              </select>
              <label for="tipo">Tipo de produto</label>
              <p class="erro">Preencha o tipo de produto</p>
            </div>

            <div class="float-icon">
              <div class="content-input-three-up label-float">
                <input type="hidden" class="ipt-id-produto" name="id_produto[]" />
                <input type="text" class="input-left ipt-produto" name="produto[]" autocomplete="off" placeholder=" " required />
                <label for="produto">Produto</label>
                <div class="search-product" style="display: none;"></div>
                <p class="erro">Pesquise e selecione um produto</p>
              </div>
              <div class="content-input-three">
                <span style="cursor: pointer;" class="btn-mais-produto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="52" height="50" viewBox="0 0 52 50">
                        <g id="Grupo_200" data-name="Grupo 200" transform="translate(-868 -1020)">
                          <path id="Caminho_226" data-name="Caminho 226" d="M26,0C40.359,0,52,11.193,52,25S40.359,50,26,50,0,38.807,0,25,11.641,0,26,0Z" transform="translate(868 1020)" fill="#562c7b"/>
                          <g id="_" data-name="+" transform="translate(585 926)">
                            <path id="União_1" data-name="União 1" d="M-4613,16V9h-7V7h7V0h2V7h7V9h-7v7Z" transform="translate(4921 111)" fill="#fff"/>
                          </g>
                        </g>
                      </svg>
                </span>
              </div>
            </div>

            <div class="content-input-three label-float">
              <input type="text" placeholder=" " name="quantidade[]" class="ipt-quantidade" required/>
              <label for="quantidade">Quantidade</label>
              <p class="erro">Preencha a quatidade do produto(s)</p>
            </div>

          </div>

        </div>

        <button type="submit" class="margin" name="enviar">Enviar</button>

      </div>

    </form>
    </div><!-- row -->
  </div><!-- container -->

 <div class="container-body-two">
  <div class="row">
    <div class="col-md-offset-4 col-md-4">   
        <form method="POST" id="formalterar" class="form form-alterar" action="{$siteurl}alterar-dados">
            <input type="hidden" name="_csrfTokenAlterarDados" value="{$csrfTokenAlterarDados}">
            <div class="group-form-input">
                <div class="container-input label-float">    
                    <input type="text" placeholder="Nome" class="ipt-nome" name="nome" value="{$usuario.nome}">
                    <label>Nome</label>
                    <p class="erro">Preencha o Nome</p>
                </div>

                <div class="container-input label-float">
                    <input type="text" placeholder="Sobrenome" class="ipt-sobrenome" name="sobrenome" value="{$usuario.sobrenome}">
                    <label>Sobrenome</label>
                    <p class="erro">Preencha o Sobrenome</p>
                </div>

                <div class="container-input label-float">
                    <input type="text" placeholder="Data de Nascimento" class="ipt-data-nascimento"
                        name="data_nascimento" value="{$usuario.data_nascimento}">
                        <label>Data de Nascimento</label>
                    <p class="erro">Preencha a Data de Nascimento</p>
                </div>
                <div class="container-input label-float">
                    <input type="text" placeholder="RG" class="ipt-rg" name="rg" value="{$usuario.rg}">
                    <label>RG</label>
                    <p class="erro">Preencha o RG</p>
                </div>
                <div class="container-input label-float">
                    <input type="text" placeholder="CPF" class="ipt-cpf" name="cpf" value="{$usuario.cpf}" disabled>
                    <label>CPF</label>
                    <p class="erro">Preencha com um CPF válido</p>
                    <p class="erro-existe">
                        Este CPF já está cadastradom faça o 
                        <a href="/participe" title="Faça o login">login</a>
                    </p>
                </div>

                 <div class="container-input label-float">
                    <input type="text" class="ipt-email" name="email" placeholder="E-mail" value="{$usuario.email}">
                    <label>Email</label>
                    <p class="erro">Preencha o Email</p>
                    <p class="erro-existe">Este Email já está cadastrado</p>
                </div>     

                <div class="container-input label-float">
                    <select class="ipt-sexo" name="sexo">
                        <option value="">Selecione</option>
                        <option value="masculino" {if $usuario.sexo eq 'masculino'} selected {/if}>Masculino</option>
                        <option value="feminino" {if $usuario.sexo eq 'feminino'} selected {/if}>Feminino</option>
                    </select>
                    <label>Selecione</label>
                    <p class="erro">Preencha o Sexo</p>
                </div>                       
            </div>

            <div class="group-form">
                <div class="container-input label-float">
                    <input type="text" name="celular" class="ipt-celular" value="{$usuario.celular}">
                    <label>Celular</label>
                    <p class="erro">Preencha o celular</p>
                </div>  
            </div>

            <div class="group-form-input">
                <div class="container-input label-float">
                    <input type="text" placeholder="Telefone" class="ipt-telefone" name="telefone" value="{$usuario.telefone}">
                    <label>Telefone</label>
                    <p class="erro">Preencha o Telefone</p>
                </div>
            </div>

            <div class="group-form-input">
                <div class="container-input label-float">
                    <input type="text" class="ipt-cep" placeholder="Cep" name="cep" value="{$usuario.cep}">
                    <label>Cep</label>
                    <p class="erro">Preencha o cep</p>
                </div>

                <div class="container-input label-float">
                    <input type="text" class="ipt-logradouro" name="logradouro" placeholder="Endereço" value="{$usuario.logradouro}">
                    <label>Endereço</label>
                    <p class="erro">Preencha o Endereço</p>
                </div>

                <div class="container-input label-float">
                    <input type="text" class="ipt-numero" name="numero" placeholder="Número" value="{$usuario.numero}">
                    <label>Número</label>
                    <p class="erro">Preencha o número</p>
                </div>                            

                <div class="container-input label-float" >
                    <input type="text" class="ipt-complemento" name="complemento" placeholder="Complemento" value="{$usuario.complemento}">
                    <label>Complemento</label>
                    <p class="erro">Preencha o Complemento</p>
                </div>
                <div class="container-input label-float">
                    <input type="text" class="ipt-bairro" name="bairro" placeholder="Bairo" value="{$usuario.bairro}">
                    <label>Bairro</label>
                    <p class="erro">Preencha o Bairro</p>
                </div>                          
            </div>

            <div class="group-form">
                 <div class="container-input label-float">
                    <select class="ipt-estado" name="estado">
                        <option selected>Estado</option>
                        {foreach $estados as $estado}
                        <option value="{$estado.uf}" {if $usuario.uf eq $estado.uf} selected {/if}>{$estado.uf}</option>
                        {/foreach}
                    </select>
                    <label>Estado</label>
                    <p class="erro">Preencha o Estado</p>
                </div>
                <div class="container-input label-float">
                    <select class="ipt-cidade" name="cidade">
                        <option value="">Cidade</option>
                        <option value="{$usuario.cidade}" selected>{$usuario.cidade}</option>
                    </select>
                    <label>Cidade</label>
                    <p class="erro">Preencha a Cidade</p>
                </div>  
            </div>
            <div class="group-form-input margin">
                <div class="container-input label-float">
                    <input type="password" class="ipt-senha" name="senha" placeholder="Senha">
                    <label>Senha</label>
                    <p class="erro">Preencha a Senha</p>
                </div>
                <div class="container-input label-float">
                    <input type="password" placeholder="Confirmar Senha" class="ipt-conf-senha"
                        name="conf_senha">
                        <label> Confirmação de Senha</label>
                    <p class="erro">Preencha a Confirmação de Senha</p>
                    <p class="erro-existe">As senhas estão diferentes</p>
                </div>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="termos" checked class="ipt-termos" disabled>
                    <span>  Aceito os termos e serviços </span>
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="newsletter" class="ipt-newsletter" {if $usuario.newsletter eq 'SIM'} checked {/if}> Aceito receber a newsletter
                </label>
            </div>
            <button class="margin"  type="submit">Atualizar</button>
        </form>

      </div>
       
    </div>
</div>
<div class="container-body-three">
    <div class="row">
      <div class="col-md-offset-4 col-md-4">   
        <h3>Confira seus números da sorte de acordo com os cupons cadastrados:</h3>
        {if isset($numerosDaSorte) && $numerosDaSorte}
            {foreach $numerosDaSorte as $numeroDaSorte}
                <input type="text" disabled value="{$numeroDaSorte->{'numero_da_sorte'}} | {$numeroDaSorte->{'serie'}}">
            {/foreach}            
        {else}
            <h3>Você ainda não possui número da sorte</h3>
        {/if}
    </div>
</div>
</div> 
</div>
</div>
</div>

<!-- Modal -->
<div class="modal fade nota" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true"></span>
                </span></button>
        </div>
        <div class="modal-body">
            <h3 class="title">Onde está o número da nota fiscal?</h3>

            <p>
              O local do número varia de acordo com o tipo de nota ou cupom fiscal.<br>
              Confira abaixo qual o modelo de sua nota e veja onde está<br>
              localizado o número.
            </p>

            <img src="{$siteurl}themes/default/img/fiscal.png">
        </div>
        
    </div>
</div>
</div>    

<script>
$("#btn-1").addClass('active');
$(".container-body-two,.container-body-three").hide()
$("#btn-1").click(function(){
    $(this).addClass('active')
    $("#btn-2,#btn-3").removeClass('active')
    $(".container-body-one").show()
    $(".container-body-two,.container-body-three").hide()
})
$("#btn-2").click(function(){
    $(this).addClass('active')
    $("#btn-1,#btn-3").removeClass('active')
    $(".container-body-two").show()
    $(".container-body-one,.container-body-three").hide()
})
$("#btn-3").click(function(){
    $(this).addClass('active')
    $("#btn-1,#btn-2").removeClass('active')
    $(".container-body-three").show()
    $(".container-body-one,.container-body-two").hide()
})
</script>