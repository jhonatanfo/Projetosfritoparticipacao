<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * 
 * 
 * Arquivo de definição de Erros posséveis de se ocorrer 
 *
 * 
 */
  defined("SSX") or die;

  define("SSX_ERROR_CORE_01", "Ssx Core Error: Pasta de controle do sistema não encontrada");
  define("SSX_ERROR_CORE_02", "Ssx Core Error: Arquivo de configura&ccedil;&otilde;es gerais inexistente.");
  define("SSX_ERROR_CORE_03", "Ssx Core Error: Configura&ccedil;&otilde;es gerais incorretas. Host ou tipo de banco de dados n&atilde;o informado.");
  
  define("SSX_ERROR_DB_00", "Configuração de Banco de Dados n&atilde;o definida.");
  define("SSX_ERROR_DB_01", "Tipo de Base da Dados não suportado.");
  define("SSX_ERROR_DB_02", "Não foi possível se conectar com o banco de dados. verifique Host, Usuário e senha.");  
  define("SSX_ERROR_DB_03", "Banco de Dados n&atilde;o encontrado");
  define("SSX_ERROR_DB_04", "Consulta SQL inv&aacute;lida."); 
  define("SSX_ERROR_DB_05", "Erro ao executar comando SQL"); 
  
  define("SSX_ERROR_THEME_01", "Tema não definido.");
  define("SSX_ERROR_THEME_02", "Tema não encontrado");
  define("SSX_ERROR_THEME_03", "Arquivo de fusão do tema não encontrado.");
  
  define("SSX_ERROR_PLUGIN_01", "Nome do plugin precisa ser informado");
  define("SSX_ERROR_PLUGIN_02", "Arquivo do plugin n&atilde;o encontrado");
  define("SSX_ERROR_PLUGIN_03", "Erro ao inicializar plugin, algum erro foi retornado pelo php relacionado ao arquivo do plugin");
  define("SSX_ERROR_PLUGIN_04", "Erro ao inicializar plugin. Plugin informado precisa ser um objeto");
  
  define("SSX_ERROR_MODULES_01", "SSX MODULES: O Modulo Home precisa existir");
  define("SSX_ERROR_MODULES_02", "SSX MODULES: Arquivo principal da pasta do tema  precisa existir");
  define("SSX_ERROR_MODULES_03", "SSX MODULES: O arquivo de template da Action  precisa existir");
  define("SSX_ERROR_MODULES_04", "SSX MODULES: O arquivo de template webservice.tpl precisa existir para tornar o Modulo um Webservice");
  define("SSX_ERROR_MODULES_05", "SSX MODULES: O arquivo de template feed.tpl precisa existir para ser exibido o conteúdo como feed");
  define("SSX_ERROR_MODULES_06", "SSX MODULES: Para o uso de SLUG &eacute; necess&aacute;rio que a action indicada como replace exista");
  define("SSX_ERROR_MODULES_07", "SSX MODULES: Arquivo de template da action de replace para uso de SLUG n&atilde;o existe");
  
  define("SSX_AJAX_ERROR_01", "SSX AJAX: Arquivo da Classe informada não existe");
  define("SSX_AJAX_ERROR_02", "SSX AJAX: Classe Ajax solicitada não existe");
  define("SSX_AJAX_ERROR_03", "SSX AJAX: Método solicitado não existe.");
  define("SSX_AJAX_ERROR_04", "SSX AJAX: Método não informado");
  
  define("SSX_EDIT_CONSTRUCT_ERROR_00", "Argumento para construção de campos inválidos");
  
  define("SSX_ERROR_PLUGIN_INSTALL_01", "Arquivo para instala&ccedil;&atilde;o inv&aacute;lido. Instalação cancelada.");
  define("SSX_ERROR_PLUGIN_INSTALL_02", "Plugin j&aacute; instalado ou j&aacute; existe um plugin com um nome identico. Instalação cancelada.");
  define("SSX_ERROR_PLUGIN_INSTALL_03", "Erro ao fazer upload do plugin. Provavelmente o erro foi gerado por falta de permissão de pasta. Instalação cancelada.");
  define("SSX_ERROR_PLUGIN_INSTALL_04", "Arquivo manifest.xml não foi encontrado dentro da pasta do plugin. Instalação cancelada.");
  define("SSX_ERROR_PLUGIN_INSTALL_05", "Plugin adicionado, mas não foi instalado corretamente, o arquivo de inicialização não foi encontrado, altere no arquivo manifest.xml e tente ativa-lo, para inicializar corretamente");