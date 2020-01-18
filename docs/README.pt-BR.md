# 🌟 Starter Site do FastSitePHP

**Obrigado pela visita!** 🌠👍

**Este é o principal Starter Site para FastSitePHP.** Inclui várias páginas de exemplos e fornece uma estrutura básica de diretório / arquivo. O site foi projetado para fornecer estrutura para conteúdo básico (JavaScript, CSS etc.), mantendo um tamanho pequeno, para facilitar a remoção de arquivos desnecessários e a personalização para o seu site.

## :rocket: Começando

**Começar a utilizar o PHP e o FastSitePHP é extremamente fácil.** Se você não possui o PHP instalado, consulte as instruções para Windows, macOS e Linux na página de introdução:

https://www.fastsitephp.com/pt-BR/getting-started

O Site Inicial não inclui o Framework, portanto você precisará executar o `scripts/install.php` para fazer o download e instalá-lo. Após a instalação, você pode iniciar um site a partir da linha de comando, conforme mostrado abaixo, ou, se você utiliza um Editor de Código ou IDE [Studio Code, GitHub Atom, etc], então poderá iniciar o site diretamente do seu editor. Veja a página de introdução acima para mais.

### Baixe e rode este site

~~~text
# Baixe este Repositório
cd {starter-site-root}
php ./scripts/install.php
php -S localhost:3000
~~~

### Crie um novo projeto utilizando o Composer (Gerenciador de Dependências e Pacotes PHP)

Além de baixar este repositório, você também pode iniciar um novo projeto utilizando o Composer.

~~~text
composer create-project fastsitephp/starter-site my-app
cd my-app
php -S localhost:3000
~~~

### Instale diretamente em um servidor

Um script bash está disponível para uma configuração rápida de um servidor Web (Apache ou nginx), PHP e FastSitePHP com um Site Inicial. Esse script funciona para uma configuração completa em um sistema operacional padrão quando não há nada instalado.

Sistemas Operacionais Suportados (mais serão adicionados no futuro):

* Ubuntu 18.04 LTS

~~~bash
wget https://www.fastsitephp.com/downloads/create-fast-site.sh
sudo bash create-fast-site.sh
~~~

### Versões suportadas do PHP

* O Site Inicial do FastSitePHP funciona com todas as versões do PHP da `5.4` a` 7.4`.
* O FastSitePHP Framework também suporta PHP 5.3.
* Se você precisar instalar o Site Inicial em um servidor com PHP 5.3, precisará fazer pequenas alterações, como substituir `[]` por `array ()` e evitar o uso de tags Curtas do PHP em modelos.

### Estrutura de Diretórios

```text
{root}
|
|   # Código PHP
├── app
|   ├── Controllers/*.php
|   ├── Middleware/*.php
|   ├── Models/*.php
|   ├── Views/*.php
│   └── app.php       # Arquivo principal da Aplicação
│
|   # Arquivos de Dados da Aplicação
├── app_data
│   └── i18n/*.json   # Arquivos JSON para Vários Idiomas
│
|   # Documentação
├── docs
│
|   # Pasta Raiz da Web
├── public
|   ├── css/*
|   ├── img/*
|   ├── js/*
│   └── index.php  # Ponto de entrada para raiz da web
│
|   # Scripts da Aplicação
├── scripts
│
|   # Arquivos de fornecedor (criados ao instalar dependências)
└── vendor
```

## :desktop_computer: Telas Capturadas do Site Inicial

![Página inicial do Site Inicial](https://raw.githubusercontent.com/fastsitephp/static-files/master/img/starter_site/2020-01-10/home-page.png)

![Página de exemplo do Site Inicial](https://raw.githubusercontent.com/fastsitephp/static-files/master/img/starter_site/2020-01-10/data-page.png)

![Página de login do Site Inicial](https://raw.githubusercontent.com/fastsitephp/static-files/master/img/starter_site/2020-01-10/login-page.png)

## :handshake: Contribuindo

* Se você encontrar um erro de digitação ou gramática, corrija e envie.
* Se você gostaria de ajudar com traduções, envie os arquivos JSON de idioma que estão em `app_data/i18n`.
* Se você deseja enviar outras alterações, por favor primeiro abra uma questão. O objetivo é ser um site mínimo, portanto, para adicionar mais código é necessário um bom motivo.

## :memo: Licença

Este projeto está licenciado sob a licença MIT - consulte o arquivo [LICENSE](../LICENSE) para detalhes.
