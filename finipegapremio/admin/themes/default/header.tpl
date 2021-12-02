<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xml:lang="pt-br" xmlns="http://www.w3.org/1999/xhtml">

<head>

    <title>{$ssx_theme_title}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> {$ssx_head} {$ssx_footer}
</head>

<body>

    {if isset($flashMessage)}
    <div class="modal fade flashMessage {$flashMessage.class}" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    <h4 class="modal-title {if $flashMessage.status eq 'success'} success{else}oops {/if}" id="myModalLabel">
                        {if $flashMessage.status eq 'success'} Sucesso! {else} Oops... {/if}
                    </h4>
                </div>
                <div class="modal-body text-center center">
                    {$flashMessage.text}
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.flashMessage').modal('show');
    </script>
    {/if} {$plugin_menu}
    <div class="modal fade bs-example-modal-sm main-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Informação</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger first-btn-main-modal" data-dismiss="modal">Sair</button>
                    <button type="button" class="btn btn-primary second-btn-main-modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row no-space">
            <div class="col-sm-2 col-md-2 col-lg-2 sidebar">
                <!-- <ul class="nav nav-sidebar">
	    			<li class="active"><a href="#">teste1</a></li>
	    			<li class=""><a href="#">teste 2</a></li>
	    			<li class=""><a href="#">teste 3</a></li>
	    		</ul> -->
                {$plugin_menu_sidebar}
            </div>
            <div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 main">
                {* variavel necessaria para o plugin ser exibido, caso ele seja chamado *}