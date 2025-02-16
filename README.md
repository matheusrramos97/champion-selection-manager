# Champion Selection Manager

Champion Selection Manager é uma aplicação desenvolvida com NativePHP e Electron. Esta ferramenta permite a seleção e gerenciamento de campeões de forma eficiente e intuitiva.

## Funcionalidades  

✅ **Aceitação Automática de Partidas**: Detecta e aceita partidas automaticamente no League of Legends.  
❌ **Gerenciamento de Seleção de Campeão**: Configure automaticamente bans, campeões preferidos por posição e feitiços de invocador. *(Em desenvolvimento)*   
✅ **Publicação Multi-Plataforma**: Publique a aplicação para Windows, macOS e Linux.


## Tecnologias Utilizadas

- **NativePHP**: Framework PHP para desenvolvimento de aplicações desktop.
- **Electron**: Framework para criação de aplicações desktop utilizando tecnologias web.
- **Tailwind CSS**: Framework CSS para estilização.
- **Laravel**: Framework PHP para backend.
- **SQLite**: Banco de dados utilizado para armazenamento de dados.

## Como Executar

1. Clone o repositório:
    ```sh
    git clone https://github.com/seu-usuario/champion-selection-manager.git
    ```

2. Instale as dependências:
    ```sh
    cd champion-selection-manager
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

## Publicação

Para publicar a aplicação, utilize os seguintes comandos:

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

## Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues e pull requests.

## Licença

Este projeto está licenciado sob a licença MIT.