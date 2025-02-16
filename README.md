# Champion Selection Manager

Champion Selection Manager é uma aplicação desenvolvida com **NativePHP** e **Electron**, criada para facilitar a **seleção e gerenciamento de campeões** no League of Legends. Com uma interface intuitiva, a ferramenta automatiza o processo de aceitação de partidas e configuração da seleção de campeão.

## ✨ Funcionalidades  

✅ **Aceitação Automática de Partidas**: Detecta e aceita partidas automaticamente no League of Legends.  
❌ **Gerenciamento de Seleção de Campeão**: Configure automaticamente bans, campeões preferidos por posição e feitiços de invocador. *(Em desenvolvimento)*  
✅ **Publicação Multi-Plataforma**: Disponível para Windows, macOS e Linux.  

## 🛠 Tecnologias Utilizadas  

- **NativePHP** – Framework PHP para desenvolvimento de aplicações desktop.  
- **Electron** – Framework para criação de aplicações desktop com tecnologias web.  
- **Laravel** – Framework PHP para o backend.  
- **Tailwind CSS** – Framework CSS para estilização.  
- **SQLite** – Banco de dados para armazenamento local.  

## 🚀 Como Executar  

1. Clone o repositório:  
    ```sh
    git clone https://github.com/seu-usuario/champion-selection-manager.git
    cd champion-selection-manager
    ```

2. Instale as dependências:  
    ```sh
    npm install
    composer install
    ```

3. Configure as variáveis de ambiente:  
    ```sh
    cp .env.example .env
    ```

4. Execute a aplicação em modo de desenvolvimento:  
    ```sh
    composer native:dev
    ```

5. Para construir a aplicação para produção:  
    ```sh
    php artisan native:build
    ```

## 📦 Publicação  

Para gerar a versão final da aplicação para diferentes sistemas operacionais, utilize:  

- **Windows**:  
    ```sh
    npm run publish:win
    ```
- **macOS**:  
    ```sh
    npm run publish:mac
    ```
- **Linux**:  
    ```sh
    npm run publish:linux
    ```

## 🔗 Download  

Você pode baixar a versão mais recente da aplicação [aqui](https://drive.google.com/file/d/1ppjlM0VYJEGUQwz6Pua9GxpDHxzEOl2z/view?usp=sharing).

## 🤝 Contribuição  

Contribuições são bem-vindas! Se encontrar bugs, tiver sugestões ou quiser colaborar com o desenvolvimento, abra uma **issue** ou envie um **pull request**.  