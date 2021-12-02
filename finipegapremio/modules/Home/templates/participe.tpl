<div class="container-participe">

  <i class="pers-01" data-aos="fade-up-left" data-aos-duration="1600"></i>
  <i class="pers-02" data-aos="fade-up-right" data-aos-duration="1800"></i>

  <div class="container">
    <div class="row">
      <div class="page-header">
        <a href="{FacebookModel::getUrlLogin()}" class="btn btn-sm" style="padding: 0;width: auto;margin: 15% 34% 0 34%;">Logar com Facebook</a>
        <a href="{GoogleModel::getUrlLogin()}" class="btn btn-sm" style="padding: 0;width: auto;margin: 2% 35%;">Logar com Google</a>  
        <p class="text-center">OU</p>
        <h1 class="center txt-participar txt-title" data-aos="fade-down" data-aos-duration="1000">Login</h1>
      </div>
    </div>

    <div class="row" data-aos="fade-up" data-aos-duration="1500">
      <div class="col-md-offset-4 col-md-4">
        <form class="form form-login" method="POST" action="{$siteurl}login">
          <input type="hidden" name="_csrfTokenLogin" value="{$csrfTokenLogin}" />
          
            <div class="group-input" id="groupHide1">
              <label for="cpf">CPF</label>
              <input placeholder=" " class="ipt-cpf-login" name="cpf" />
              <p class="erro">
                Preencha o CPF
              </p>
            </div>
            <div class="group-input" id="groupHide2">
              <label for="senha">Senha</label>
              <input type="password" placeholder=" " class="ipt-senha-login" name="senha" />
              <p class="erro">
                Preencha a senha
              </p>
            </div>
            <p class="pass">Esqueci a minha senha</p>

            <div class="group-input" id="groupHide3">
                <button type="submit" class="btn-login">Entrar</button>            
            </div>  

        </form>
        <form class="form form-esqueci-minha-senha" method="POST" action="{$siteurl}esqueci-minha-senha">
          <input type="hidden" name="_csrfTokenEsqueci" value="{$csrfTokenEsqueci}" />
          <div class="group-input" id="hideMail">
              <label for="Cpf">Informe o seu CPF</label>
              <input type="text" id="Cpf" name="cpf" class="ipt-cpf-esqueci"/>
               <p class="erro">CPF inválido ou em branco.</p>
               <p class="back-to-login">Voltar</p>
               <button type="submit" class="btn-enviar-esqueci">Enviar</button>
          </div>
        </form>
      </div>
    </div>
  </div>