# 🌟 FastSitePHP Starter Site

**Obrigado pela visita!** 🌠👍

**Este é o principal Starter Site para FastSitePHP.** Inclui várias páginas de exemplos e fornece uma estrutura básica de diretório / arquivo. O site foi projetado para fornecer estrutura para conteúdo básico (JavaScript, CSS etc.), mantendo um tamanho pequeno, para facilitar a remoção de arquivos desnecessários e a personalização para o seu site.

## :rocket: Getting Started

**A introdução ao PHP e ao FastSitePHP é extremamente fácil.** Se você não possui o PHP instalado, consulte as instruções para Windows, Mac e Linux na página de introdução:

https://www.fastsitephp.com/pt-BR/getting-started

O site inicial não inclui o Framework, portanto você precisará executar o `scripts/install.php` para fazer o download e instalá-lo. Após a instalação, você pode iniciar um site a partir da linha de comando, conforme mostrado abaixo, ou, se usar um Editor de Código ou IDE [Código do Visual Studio, GitHub Atom, etc], poderá iniciar o site diretamente do seu editor. Veja a página de introdução acima para mais.

### Faça o download e execute este site

~~~text
# Faça o download deste Repositório
cd {starter-site-root}
php ./scripts/install.php
php -S localhost:3000
~~~

### Crie um novo projeto usando o Composer (PHP Dependency / Package Manager)

Além de baixar este repositório, você também pode iniciar um novo projeto usando o Composer.

~~~text
composer create-project fastsitephp/starter-site my-app
cd my-app
php -S localhost:3000
~~~

### Instale diretamente em um servidor

Um script bash está disponível para uma configuração rápida de um servidor Web (Apache ou nginx), PHP e FastSitePHP com um site inicial. Esse script funciona para uma configuração completa em um sistema operacional padrão quando nada está instalado.

Sistemas operacionais suportados (mais serão adicionados no futuro):

* Ubuntu 18.04 LTS

~~~bash
wget https://www.fastsitephp.com/downloads/create-fast-site.sh
sudo bash create-fast-site.sh
~~~

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
│   └── app.php       # Arquivo principal do aplicativo
│
|   # Arquivos de dados do aplicativo
├── app_data
│   └── i18n/*.json   # Arquivos JSON para vários idiomas
│
|   # Documentação
├── docs
│
|   # Pasta raiz da Web
├── public
|   ├── css/*
|   ├── img/*
|   ├── js/*
│   └── index.php  # Ponto de entrada para raiz da we
│
|   # Scripts de aplicativo
├── scripts
│
|   # Arquivos de fornecedor (criados ao instalar dependências)
└── vendor
```

## :desktop_computer: Telas de impressão do site inicial (Capturas de tela)

![Página inicial do site inicial](https://raw.githubusercontent.com/fastsitephp/static-files/master/img/starter_site/2019-06-17/home-page.png)

![Página de exemplo do site inicial](https://raw.githubusercontent.com/fastsitephp/static-files/master/img/starter_site/2019-06-17/data-page.png)

## :handshake: Contribuindo

* Se você encontrar um erro de digitação ou gramática, corrija e envie.
* Se você gostaria de ajudar com traduções, envie os arquivos de idioma JSON em `app_data/i18n`.
* Se você deseja enviar outras alterações, abra um problema primeiro. O objetivo é ser um site mínimo, portanto, adicionar mais código precisa de um bom motivo.

## :memo: Licença

Este projeto está licenciado sob a licença MIT - consulte o arquivo [LICENSE](../LICENSE) para obter detalhes.
