# Arquivos de linguagem do Laravel 5.6 - Português do Brasil

## Tradução das mensagens de erro padrão do Laravel 5.6 para PT-BR

Instalação:

1. Clone este projeto para uma pasta dentro de `resources/lang/`
  ```
  $ https://github.com/stinow/laravel-5.6-locale-pt-br.git ./pt-br
  ```
  
Você pode remover o `README.md` e o diretório oculto `.git` para poder incluir
e versionar os arquivos deste projeto no seu repositório.

  ```
  $ rm -rf pt-br/.git/ pt-br/README.md
  ```
  
2. Configure o framework para utilizar o português por padrão:

  ```
  // config/app.php
  'locale' => 'pt-br',
  ```