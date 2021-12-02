<div class="bg contato">

  <div class="container">

    <div class="row">
      <div class="page-header">
        <h1>Contato</h1>
        <i class="arrow"></i>
      </div>
    </div>

    <div class="row">

      <form method="POST" class="form form-home" action="{$siteurl}contato">
        <input type="hidden" name="_csrfTokenContato" value="{$csrfTokenContato}" />

        <div class="form-cont">
          <div class="col-md-6 col-esq">
            <div class="form-group col-md-12">
              <label for="exampleInputEmail1">Nome completo*</label>
              <input type="text" name="nome" class="form-control ipt-nome" id="nome">
              <p class="erro" style="display: none;">Preencha o nome</p>
            </div>

            <div class="form-group col-md-12">
              <label for="exampleInputEmail1">CPF*</label>
              <input type="text" name="cpf" class="form-control ipt-cpf" id="cpf">
              <p class="erro" style="display: none;">Preencha o CPF</p>
            </div>

            <div class="form-group col-md-12">
              <label for="exampleInputEmail1">Telefone*</label>
              <input type="tel" name="telefone" class="form-control ipt-telefone" id="telefone">
              <p class="erro" style="display: none;">Preencha o telefone</p>
            </div>

            <div class="form-group col-md-12">
              <label for="exampleInputEmail1">E-mail*</label>
              <input type="email" name="email" class="form-control ipt-email" id="email">
              <p class="erro" style="display: none;">Preencha o e-mail</p>
            </div>
          </div>

          <div class="col-md-6 col-dir">
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Mensagem*</label>
              <textarea style="resize: none" name="mensagem" class="form-control ipt-mensagem" id="mensagem" rows="10"></textarea>
              <p class="erro" style="display: none;">Preencha a mensagem</p>
            </div>
            <br>
            <span>* campos obrigatórios</span>
          </div>
        </div>

        <button type="submit">Enviar</button>
      </form>

    </div>

  </div>