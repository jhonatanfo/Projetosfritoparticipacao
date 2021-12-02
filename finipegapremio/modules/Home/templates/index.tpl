 <div class="bg-home">
    <div class="container">
        <div class="row">

            <div class="col-md-6">
                <img class="img-responsive ilustracao" src="./themes/default/img/ilustracao-pega.png">
            </div>

            <div class="col-md-6">
                <div class="box-info compre">
                    <i class="icon-compre"></i>
                    <h2>Compre</h2>
                    <p>a partir de <b>R$ 15</b> em produtos FINI.</p>
                </div>

                <div class="box-info cadastre">
                    <i class="icon-cadastre"></i>
                    <h2>Cadastre</h2>
                    <p>seu cupom fiscal e brinque com a garra para descobrir se ganhou, na hora, 1 par de ingressos de
                        cinema!</p>
                </div>

                <div class="box-info concorra">
                    <i class="icon-concorra"></i>
                    <h2>Concorra</h2>
                    <p>também a prêmios semanais de até R$ 500 e, no final:</p>
                    <ul>
                        <li class="viagem">
                            <img src="./themes/default/img/viagem.png">
                            <p>Viagem para a<br>Costa do Sauípe</p>
                        </li>
                        <li class="kit">
                            <img src="./themes/default/img/kit.png">
                            <p>Kit diversão</p>
                        </li>
                        <li class="smartphone">
                            <img src="./themes/default/img/smartphone.png">
                            <p>Smartphone</p>
                        </li>
                    </ul>
                </div>
            </div>
            
        </div>

        <div class="row">

            <div class="col-md-12 quero-participar">
                <a href="#">Quero participar!</a>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade participe-home" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

            <div class="modal-body text-center center">

                <h4 class="modal-title" id="myModalLabel">
                    Participe agora
                </h4>

                <div class="group-input">
                    <label for="email">E-mail</label>
                    <input type="text" class="ipt-email" name="email" placeholder=" "
                    value="{if isset($usuarioSocialNetwork)}{$usuarioSocialNetwork.email}{/if}" />
                    <p class="erro">Preencha o Email</p>
                    <p class="erro-existe">Este Email já está cadastrado</p>
                </div>

                <div class="group-input">
                    <label>Senha</label>
                    <input type="password" class="ipt-senha" name="senha" placeholder="" />
                    <p class="erro">Preencha a Senha</p>
                </div>

                <p class="esqueceu-senha">Esqueceu sua senha?</p>

                <a href="#" class="participe-entrar">Entrar</a>

            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $('.participe-home').modal('show');
</script> 