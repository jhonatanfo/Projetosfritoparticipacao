<div class="cadastre-se bg">

  <div class="container">

    <div class="row">
      <div class="page-header">
        <h1>Cadastre-se</h1>
        <i class="arrow"></i>
      </div>
    </div>

    <div class="row">
      <div class="page-header" data-aos="fade-down" data-aos-duration="1000">
        <div class="col-md-6">
          <a href="{FacebookModel::getUrlCadastro()}" class="option-cadastre left">
            <i class="icon-facebook"></i>
            Cadastrar com Facebook
          </a>
        </div>
        <div class="col-md-6">
          <a href="{GoogleModel::getUrlCadastro()}" class="option-cadastre right">
            <i class="icon-gmail"></i>
            Cadastrar com Google
          </a>
        </div>
      </div>

      <div class="col-md-12">
        <p class="ou">OU</p>
      </div>
    </div>

    <div class="row" data-aos="zoom-in" data-aos-duration="1800">
      <div class="col-md-12">

        <form method="POST">

          <div class="form">

            <input type="hidden" name="_csrfTokenCadastro" value="{$csrfTokenCadastro}">

            <div class="group-form">

              <div class="group-input col-xs-12 col-md-4">
                <label>Nome*</label>
                <input type="text" class="ipt-nome" name="nome"
                  value="{if isset($usuarioSocialNetwork)}{$usuarioSocialNetwork.nome}{/if}" />
                <p class="erro">Preencha o Nome</p>
              </div>

              <div class="group-input col-xs-12 col-md-4">
                <label>Sobrenome*</label>
                <input type="text" class="ipt-sobrenome" name="sobrenome"
                  value="{if isset($usuarioSocialNetwork)}{$usuarioSocialNetwork.sobrenome}{/if}" />
                <p class="erro">Preencha o Sobrenome</p>
              </div>

              <div class="group-input col-xs-12 col-md-4">
                <label>Data de Nascmento*</label>
                <input type="text" class="ipt-data-nascimento" name="data_nascimento" />
                <p class="erro">Preencha a Data de Nascimento</p>
              </div>

              <div class="group-input col-xs-12 col-md-6">
                <label for="email">E-mail</label>
                <input type="text" class="ipt-email" name="email" placeholder=" "
                  value="{if isset($usuarioSocialNetwork)}{$usuarioSocialNetwork.email}{/if}" />
                <p class="erro">Preencha o Email</p>
                <p class="erro-existe">Este Email já está cadastrado</p>
              </div>

              <div class="group-input col-xs-12 col-md-6">
                <label for="email">Confirmar e-mail*</label>
                <input type="text" class="ipt-email" name="email" placeholder=" "
                  value="{if isset($usuarioSocialNetwork)}{$usuarioSocialNetwork.email}{/if}" />
                <p class="erro">Preencha o Email</p>
                <p class="erro-existe">Este Email já está cadastrado</p>
              </div>

              {if !isset($usuarioSocialNetwork)}
              <div class="group-input col-xs-12 col-md-6">
                <label>Senha</label>
                <input type="password" class="ipt-senha" name="senha" placeholder="" />
                <p class="erro">Preencha a Senha</p>
              </div>
              <div class="group-input col-xs-12 col-md-6">
                <label for="conf_senha"> Confirmar de Senha</label>
                <input type="password" class="ipt-conf-senha" name="conf_senha" />
                <p class="erro">Preencha a confirmação de senha</p>
              </div>
              {/if}



            </div>

            <!-- <div class="group-form margin">
            <div class="group-input">
              <label>RG</label>
              <input type="text" class="ipt-rg" name="rg" placeholder=" " />
              <p class="erro">Preencha o RG</p>
            </div>
            <div class="group-input">
              <label>CPF</label>
              <input type="text" class="ipt-cpf" name="cpf" />
              <p class="erro">Preencha o CPF</p>
            </div>
            
          </div>

          <div class="group-form">
            <div class="group-input">
              <label>Sexo</label>
              <select class="ipt-sexo" name="sexo" value="">
                <option value="">Selecione</option>
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>
              </select>
              <p class="erro">Preencha o Sexo</p>
            </div>
            <div class="group-input">
              <label for="celular">Celular</label>
              <input type="text" name="celular" class="ipt-celular" placeholder=" " />
              <p class="erro">Preencha o Celular</p>
            </div>
            <div class="group-input">
              <label for="telefone">Telefone</label>
              <input type="text" class="ipt-telefone" name="telefone" placeholder=" " />
              <p class="erro">Preencha o Telefone</p>
            </div>
          </div>

          <div class="group-form margin">
            <div class="group-input">
              <label for="CEP">CEP</label>
              <input type="text" class="ipt-cep" name="cep" placeholder=" " />
              <p class="erro">Preencha o Cep</p>
            </div>
            <div class="group-input">
              <label for="logradouro">Endereço</label>
              <input type="text" class="ipt-logradouro" name="logradouro" placeholder=" " />
              <p class="erro">Preencha o Endereço</p>
            </div>
            <div class="group-input">
              <label for="numero">Número</label>
              <input type="text" name="numero" class="ipt-numero" placeholder=" " />
              <p class="erro">Preencha o Número</p>
            </div>
          </div>

          <div class="group-form ">
            <div class="group-input">
              <label for="Complemento">Complemento</label>
              <input type="text" class="ipt-complemento" name="complemento" placeholder=" " />
              <p class="erro">Preencha o Complemento</p>
            </div>
            <div class="group-input">
              <label for="bairro">Bairro</label>
              <input type="text" class="ipt-bairro" name="bairro" placeholder=" " />
              <p class="erro">Preencha o Bairro</p>
            </div>
            <div class="group-input">
              <label for="estado">Estado</label>
              <select class="ipt-estado" name="estado">
                <option value="">Estado</option>
                {foreach $estados as $estado}
                <option value="{$estado.uf}">{$estado.uf}</option>
                {/foreach}
              </select>
              <p class="erro">Preencha o Estado</p>
            </div>
          </div>

          <div class="group-form">
            <div class="group-input">
              <label for="cidade">Cidade</label>
              <select class="ipt-cidade" name="cidade">
                <option value="">Cidade</option>
              </select>
              <p class="erro">Preencha a Cidade</p>
            </div>

            
          </div> -->

          </div>

          <div class="checkbox">

            <label class="padrao col-md-4">
              <input type="checkbox" id="termos" name="termos" value="termos">
              <label for="termos" class="check">Li e aceito os termos do regulamento.</label>
            </label>

            <label class="padrao col-md-4">
              <input type="checkbox" id="newsletter" name="newsletter" value="newsletter" class="ipt-newsletter">
              <label for="newsletter" class="check">Quero receber informações por e-mail.</label>
            </label>

            <p class="col-md-4">*campos obrigatórios</p>
          </div>

          <button class="btn-cadastra" type="submit">Cadastrar</button>
        </form>

      </div>

    </div>

  </div>

</div>