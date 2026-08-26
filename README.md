# 🦁 Orlando City Shop

E-commerce fictício desenvolvido como projeto de estudo, inspirado na identidade visual do Orlando City. O projeto simula uma loja completa: catálogo de produtos, carrinho de compras, cálculo de frete e finalização de pedido com baixa de estoque.

🔗 **Demo online:** [orlandocity.infinityfree.io/index](https://orlandocity.infinityfree.io/index)

---

## 📸 Preview

> ![alt text](image.png)

---

## ✨ Funcionalidades

- Catálogo de produtos com destaque para promoções e mais buscados
- Página de detalhes do produto
- Carrinho de compras dinâmico (adicionar, remover, atualizar quantidade)
- Cálculo de frete e prazo de entrega por CEP
- Finalização de compra com baixa automática de estoque
- Layout responsivo com menu mobile

---

## 🛠️ Tecnologias utilizadas

| Camada | Tecnologia |
|---|---|
| Front-end | Angular 1.8, jQuery, Bootstrap, Owl Carousel |
| Back-end | PHP 7+, [Slim Framework 2](https://www.slimframework.com/) |
| Banco de dados | MySQL |

---

## 🚀 Rodando o projeto localmente

### Pré-requisitos
- PHP 7 ou superior com extensão `mysqli`
- Servidor MySQL
- Servidor web (Apache/Nginx) ou o servidor embutido do PHP

### Passo a passo

```bash
# 1. Clone o repositório
git clone https://github.com/JoaoGabrielRLP/Orlando-City.io.git
cd Orlando-City.io

# 2. Extraia as dependências PHP
unzip inc/Slim-2.x.zip -d inc/

# 3. Crie o banco de dados
# Importe o arquivo .sql disponível no repositório no seu MySQL local

# 4. Configure a conexão
# Edite inc/configuration.php com o host, usuário, senha e nome do seu banco

# 5. Suba um servidor local
php -S localhost:8000
```

Acesse `http://localhost:8000/index` no navegador.

---

## ☁️ Deploy em hospedagem gratuita

Este projeto está hospedado no [InfinityFree](https://infinityfree.com), uma das poucas hospedagens gratuitas com suporte real a PHP + MySQL. Algumas adaptações foram feitas para funcionar em plano gratuito:

- **Stored Procedures → funções PHP:** o plano gratuito não permite `CREATE ROUTINE`/`ALTER ROUTINE` no MySQL, então toda a lógica que estava em stored procedures (carrinho, listagem de produtos, etc.) foi reescrita em PHP puro.
- **Cálculo de frete simulado:** hospedagens gratuitas geralmente bloqueiam conexões de saída para APIs externas (como Correios), então o frete é calculado com uma fórmula fictícia baseada em peso e CEP, só para fins de demonstração.

---

## 📄 Licença

Projeto de estudo, sem fins comerciais. Marca e identidade visual do Orlando City SC usadas apenas para fins educacionais/portfólio.

---

## 👤 Autor

Desenvolvido por **João Gabriel** — [GitHub](https://github.com/JoaoGabrielRLP)