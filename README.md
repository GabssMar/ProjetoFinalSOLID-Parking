# Parking System (SOLID & Clean Architecture)

Sistema de gerenciamento de estacionamento desenvolvido em PHP 8.2+, focado na aplicação estrita de SOLID, Clean Architecture e Object Calisthenics.

## Sobre o Projeto

Este projeto foi desenvolvido para a disciplina de Design Patterns e Clean Code, do 4º termo B do curso de Análise e Desenvolvimento de sistemas

## Integrantes do Grupo

Gabriele Martinez

Julia Capellini

Leonardo Santos

Ryan Rodrigues

## Tecnologias Utilizadas

PHP 8.2+

SQLite (Banco de dados embarcado)

Composer (Gerenciamento de dependências e Autoload PSR-4)

## Arquitetura e Design Patterns

O projeto segue uma estrutura modular baseada em Clean Architecture, dividindo responsabilidades em camadas concêntricas:

### 1. Domain (O Coração)

Contém as regras de negócio puras, sem dependência de bibliotecas externas ou banco de dados.

Entities: Parking, VehicleType e Vehicle (Modelagem rica e imutável).

Value Objects: Plate, Money, ParkingPeriod (Object Calisthenics: encapsulamento de tipos primitivos e validações).

Interfaces: ParkingRepository, PricingStrategy (Inversão de Dependência - DIP).

### 2. Application (Casos de Uso)

A ponte entre o mundo externo e o domínio. Orquestra as ações do usuário.

Use Cases: CheckInVehicle, CheckOutVehicle.

DTOs: Objetos simples (CheckInInputDTO, CheckOutInputDTO) para transporte de dados.

### 3. Infra (O Mundo Real)

Implementações concretas que tocam o "mundo externo".

Repository: SqliteParkingRepository (Implementação SQL da interface do Domain).

Database: Connection (Singleton para conexão PDO segura).

## Padrões SOLID Aplicados

SRP: Cada classe tem uma única responsabilidade (ex: PricingStrategy só calcula preço, não salva no banco).

OCP: Novas estratégias de preço (ex: Bicicleta) podem ser adicionadas criando novas classes, sem alterar o código existente.

LSP: As estratégias de preço respeitam a interface comum.

ISP: Interfaces focadas e específicas.

DIP: O sistema depende de abstrações (ParkingRepository), não de implementações concretas (Sqlite...).

## Como Rodar o Projeto

**Pré-requisitos**

PHP 8.2 ou superior instalado.

Composer instalado.

### Passo a Passo

**Clone o repositório:**

git clone [https://github.com/GabssMar/ProjetoFinalSOLID-Parking.git](https://github.com/GabssMar/ProjetoFinalSOLID-Parking.git)
cd ProjetoFinalSOLID-Parking


**Instale as dependências e gere o Autoload:**

composer install
composer dump-autoload


**Configure o Banco de Dados:**

Execute o script de setup para criar o arquivo database.sqlite e as tabelas:

```php setup_database.php```


**Inicie o Servidor:**

Você pode usar o servidor embutido do PHP:

php -S localhost:8000


Acesse:
Abra seu navegador em http://localhost:8000.

### Testando Manualmente (Backend)

Se quiser testar a lógica sem o Frontend, você pode criar um arquivo teste.php na raiz:
```
<?php

require 'vendor/autoload.php';

use App\Application\DTO\CheckInInputDTO;
use App\Application\UseCase\CheckInVehicle;
use App\Infra\Repository\SqliteParkingRepository;

// Simula uma entrada
$repo = new SqliteParkingRepository();
$useCase = new CheckInVehicle($repo);

$input = new CheckInInputDTO('ABC1234', 'car');
$result = $useCase->execute($input);

print_r($result);

```