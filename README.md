# CODELINK - Sistema de Intranet

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php)
![Filament](https://img.shields.io/badge/Filament-3.x-F59E0B?style=flat-square)
![Livewire](https://img.shields.io/badge/Livewire-3.x-FB70A9?style=flat-square)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-38BDF8?style=flat-square&logo=tailwindcss)

Sistema de intranet moderno e completo desenvolvido com Laravel, Filament e Livewire. O CODELINK oferece uma plataforma centralizada para gerenciamento de unidades organizacionais, sistema de notícias, reservas de recursos e links personalizados.

## 🚀 Funcionalidades

### 📋 Principais Recursos
- **Gerenciamento de Unidades**: Cadastro e administração de unidades organizacionais com informações completas de endereço e contato
- **Sistema de Notícias**: Publicação e gestão de avisos e notícias por unidade
- **Sistema de Reservas**: Agendamento de recursos com controle de horários, equipamentos de TI e status
- **Links Personalizados**: Gestão de links úteis por usuário e por unidade
- **Autenticação Completa**: Sistema de login, registro e controle de permissões
- **Painel Administrativo**: Interface administrativa completa com Filament
- **Dashboard Intuitivo**: Painel principal com visão geral do sistema

### 🔧 Tecnologias Utilizadas
- **Backend**: Laravel 12.x com PHP 8.2+
- **Frontend**: Livewire 3.x + TailwindCSS 3.x
- **Admin Panel**: Filament 3.x
- **Banco de Dados**: SQLite (padrão) / MySQL (opcional)
- **Gerenciamento de Permissões**: Spatie Laravel Permission
- **Localização**: Português do Brasil
- **Development Tools**: Laravel Pint, PHPStan, Debugbar

## 📋 Pré-requisitos

Antes de iniciar, certifique-se de ter instalado:

- **PHP 8.2 ou superior**
- **Composer**
- **Node.js 18+ e npm**
- **SQLite** (ou MySQL se preferir)
- **Git**

### Verificação dos Pré-requisitos
```bash
# Verificar versão do PHP
php --version

# Verificar Composer
composer --version

# Verificar Node.js e npm
node --version
npm --version
```

## 🛠️ Instalação

### 1. Clone o Repositório
```bash
git clone <url-do-repositorio>
cd intranet
```

### 2. Instalação das Dependências PHP
```bash
# Instalar dependências do Composer
composer install
```

### 3. Instalação das Dependências Node.js
```bash
# Instalar dependências do npm
npm install
```

### 4. Configuração do Ambiente
```bash
# Copiar arquivo de configuração
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate
```

### 5. Configuração do Banco de Dados

#### Opção A: SQLite (Padrão - Mais Simples)
```bash
# Criar arquivo do banco SQLite
touch database/database.sqlite
```
O arquivo `.env` já vem configurado para SQLite.

#### Opção B: MySQL (Opcional)
Se preferir usar MySQL, altere no arquivo `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=intranet
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 6. Executar Migrações
```bash
# Executar migrações do banco de dados
php artisan migrate

# (Opcional) Executar seeders se disponíveis
php artisan db:seed
```

### 7. Configurações do Filament
```bash
# Criar usuário administrador para o Filament
php artisan make:filament-user
```

## 🚀 Executando o Projeto

### Modo de Desenvolvimento Completo
O projeto inclui um script que executa todos os serviços necessários simultaneamente:
```bash
# Executa servidor Laravel, queue, logs e Vite simultaneamente
composer run dev
```

Este comando iniciará:
- **Servidor Laravel** (http://localhost:8000)
- **Sistema de Filas** (queue:listen)
- **Logs em tempo real** (pail)
- **Vite para assets** (hot reload)

### Executar Serviços Individualmente

#### Servidor Laravel
```bash
php artisan serve
# Acesse: http://localhost:8000
```

#### Assets (CSS/JS) - Desenvolvimento
```bash
npm run dev
```

#### Assets (CSS/JS) - Produção
```bash
npm run build
```

#### Sistema de Filas
```bash
php artisan queue:work
```

## 🐳 Docker (Opcional)

O projeto inclui configuração Docker para MySQL e phpMyAdmin:

```bash
# Iniciar containers
docker-compose up -d

# Parar containers
docker-compose down
```

**Serviços disponíveis:**
- **MySQL**: porta 3306
- **phpMyAdmin**: http://localhost:8080
  - Usuário: `root`
  - Senha: `root`

## 📁 Estrutura do Projeto

```
intranet/
├── app/
│   ├── Filament/           # Recursos do painel administrativo
│   │   ├── Pages/          # Páginas personalizadas
│   │   └── Resources/      # Recursos CRUD
│   ├── Livewire/           # Componentes Livewire
│   │   ├── Auth/           # Autenticação
│   │   └── Reservation/    # Sistema de reservas
│   └── Models/             # Modelos Eloquent
├── database/
│   └── migrations/         # Migrações do banco
├── resources/
│   ├── views/              # Templates Blade
│   └── css/                # Estilos CSS
└── routes/
    └── web.php             # Rotas da aplicação
```

## 🔐 Acesso ao Sistema

### Usuários Finais
- **URL**: http://localhost:8000
- **Registro**: http://localhost:8000/register
- **Login**: http://localhost:8000/login

### Painel Administrativo
- **URL**: http://localhost:8000/admin
- **Acesso**: Use o usuário criado com `php artisan make:filament-user`

## 🧪 Testes

```bash
# Executar todos os testes
composer run test
# ou
php artisan test

# Executar testes com coverage
php artisan test --coverage
```

## 🔧 Comandos Úteis

### Artisan Commands
```bash
# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Gerar recursos
php artisan make:model NomeModel -m
php artisan make:livewire NomeComponent
php artisan make:filament-resource NomeResource

# Migrações
php artisan migrate:fresh --seed
php artisan migrate:rollback
```

### Code Quality
```bash
# Formatação de código (Laravel Pint)
./vendor/bin/pint

# Análise estática (PHPStan)
./vendor/bin/phpstan analyse

# Formatação de templates Blade
npx prettier --write resources/views/**/*.blade.php
```

## 📊 Funcionalidades Detalhadas

### 🏢 Gerenciamento de Unidades
- Cadastro completo com endereço
- Informações de contato
- Vinculação com usuários e notícias
- Gerenciamento via Filament Admin

### 📰 Sistema de Notícias
- Publicação por unidade
- Upload de arquivos
- Status ativo/inativo
- Alertas para usuários
- Interface administrativa completa

### 📅 Sistema de Reservas
- Agendamento de recursos por data/hora
- Controle de equipamentos de TI
- Status de aprovação
- Observações e links de eventos
- Permissões de edição

### 🔗 Links Personalizados
- Links por usuário
- Links por unidade
- Links para visitantes
- Organização por categorias
- Ordenação customizável

## 🌐 Configurações de Produção

### Variáveis de Ambiente Importantes
```env
# Aplicação
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio.com

# Banco de Dados
DB_CONNECTION=mysql
DB_HOST=seu-host
DB_DATABASE=sua-base
DB_USERNAME=seu-usuario
DB_PASSWORD=sua-senha

# Cache e Performance
CACHE_STORE=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

# Email
MAIL_MAILER=smtp
MAIL_HOST=seu-servidor-smtp
MAIL_PORT=587
MAIL_USERNAME=seu-email
MAIL_PASSWORD=sua-senha
```

### Deploy
```bash
# Otimizar aplicação
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build dos assets
npm run build

# Executar migrações
php artisan migrate --force
```

## 🤝 Contribuindo

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

### Padrões de Código
- Use Laravel Pint para formatação: `./vendor/bin/pint`
- Siga as convenções do Laravel
- Adicione testes para novas funcionalidades
- Mantenha a documentação atualizada

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo `LICENSE` para mais detalhes.

## 🆘 Suporte

Se encontrar problemas:

1. **Verifique os logs**: `storage/logs/laravel.log`
2. **Limpe o cache**: `php artisan optimize:clear`
3. **Verifique as permissões**: chmod 755 storage/ bootstrap/cache/
4. **Reinstale dependências**: `composer install && npm install`

### Problemas Comuns

**Erro de permissões**:
```bash
sudo chown -R www-data:www-data storage/
sudo chown -R www-data:www-data bootstrap/cache/
```

**Erro de chave da aplicação**:
```bash
php artisan key:generate
```

**Problemas com assets**:
```bash
npm run build
php artisan optimize:clear
```

---

**Desenvolvido com ❤️ usando Laravel + Filament + Livewire**
