# oei

# Solução para a API de Seleção de Cursos via Docker

## Estrutura do Projeto:

api/
├── app/
│   └── apiCursos.php	     (nosso código API PHP principal)
├── Dockerfile		         (Configuração do container PHP)
├── docker-compose.yml     (Orquestração dos serviços)

## Como Executar:

1. Construa e inicie o container:
cd api
docker-compose up -d --build

2. Execute os testes:
http://localhost:8888/apiCursos.php?cursos=[{"criteria":["closest","school-cooperacao"],"editions":[{"date": "2025-06-01","courses":[ {"name": "Especialista em cooperação internacional", "type": "cooperacao"},{"name":"Divulgação e cooperação da ciência","type":"divulgacao-cientifica"}]},{"date":"2025-09-01","courses":[{"name":"Compreendendo o tupari","type":"tupari"}]}]}]

onde o parametro "cursos" recebe formato JSON para seleção do curso

4. Para parar o serviço:
docker-compose down


## Funcionalidades Implementadas:

Recepção de Dados:
A API recebe a entrada JSON pelo parametro "cursos".

Critérios de Seleção:
- closest: Ordena as edições pela data e seleciona a mais próxima à data atual.
- latest: Ordena as edições pela data e seleciona a mais distante.
- type-name: Filtra os cursos pelo tipo especificado.
- school-name: Filtra os cursos com base na escola e suas temáticas associadas.

Evolução Futura:
A API está preparada para expansão adicionando novos critérios e escolas.

Resposta:
A API retorna um JSON com a edições e os cursos filtrados.
pela URL:
http://localhost:8888/apiCursos.php?cursos=[{"criteria":["closest","school-cooperacao"],"editions":[{"date": "2025-06-01","courses":[ {"name": "Especialista em cooperação internacional", "type": "cooperacao"},{"name":"Divulgação e cooperação da ciência","type":"divulgacao-cientifica"}]},{"date":"2025-09-01","courses":[{"name":"Compreendendo o tupari","type":"tupari"}]}]}]

Esta solução está pronta para ser implantada e passa em todos os casos de teste fornecidos.
