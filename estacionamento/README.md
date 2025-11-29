# Controle de Estacionamento Inteligente

Projeto em PHP 8.2 + SQLite que registra entradas/saídas de veículos, calcula tarifas por hora e gera relatórios. Estrutura modular seguindo SOLID, Clean Code, PSR-4 e PSR-12.

## Requisitos
- PHP >= 8.2
- SQLite (extensão PDO)
- Composer

## Instalação
1. Clone o repositório
2. `composer install`
3. Crie o schema:
   `php src/Infra/Migracao/CriarSchema.php`
   (vai gerar `banco.db` a partir de `banco.sql`)
4. Rode o servidor local:
   `php -S localhost:8000 -t publico`
5. Acesse `http://localhost:8000`

## Arquitetura
- `src/Aplicacao` — DTOs, serviços de aplicação, exceções (SRP, DIP)
- `src/Dominio` — Entidades, enums, regras e estratégias de precificação (OCP, LSP)
- `src/Infra` — Repositórios SQLite, fábrica de conexão, migração
- `publico` — Interface mínima em HTML/PHP

## Regras de Negócio
- Tipos: carro (R$5/h), moto (R$3/h), caminhão (R$10/h)
- Tempo arredondado para cima (hora cheia). Mínimo 1 hora.
- Relatório consolida por tipo e total geral.

## Como estender
- Para adicionar novo tipo de veículo: criar `EstrategiaPrecificacao` e registrar na injeção no `registrar_saida.php` (seguir DIP/OCP)
- Repositórios implementam interfaces (ISP)

## Testes
- Exemplo com PHPUnit pode ser adicionado em `tests/`

## Observações
- Projeto minimalista para demonstração de arquitetura; em produção aplique autenticação, validações mais robustas e camadas de DTO/validação adicionais.
