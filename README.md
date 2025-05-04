# oei
<br>
# Solução para a API de Seleção de Cursos via Docker
<br><br>
## Estrutura do Projeto:
<br>
api/ <br>
├── app/ <br>
│   └── apiCursos.php	     (nosso código API PHP principal) <br>
├── Dockerfile		         (Configuração do container PHP) <br>
├── docker-compose.yml     (Orquestração dos serviços) <br>
<br>
## Como Executar:
<br>
1. Construa e inicie o container:<br>
cd api<br>
docker-compose up -d --build<br>
<br>
2. Execute os testes:<br>
http://localhost:8888/apiCursos.php?cursos=[{"criteria":["closest","school-cooperacao"],"editions":[{"date": "2025-06-01","courses":[ {"name": "Especialista em cooperação internacional", "type": "cooperacao"},{"name":"Divulgação e cooperação da ciência","type":"divulgacao-cientifica"}]},{"date":"2025-09-01","courses":[{"name":"Compreendendo o tupari","type":"tupari"}]}]}]
<br>
onde o parametro "cursos" recebe formato JSON para seleção do curso
<br><br>
3. Para parar o serviço:<br>
docker-compose down<br>
<br>
## Funcionalidades Implementadas:
<br>
Recepção de Dados:<br>
A API recebe a entrada JSON pelo parametro "cursos".<br>
<br>
Critérios de Seleção:<br>
- closest: Ordena as edições pela data e seleciona a mais próxima à data atual.<br>
- latest: Ordena as edições pela data e seleciona a mais distante.<br>
- type-name: Filtra os cursos pelo tipo especificado.<br>
- school-name: Filtra os cursos com base na escola e suas temáticas associadas.<br>
<br>
Evolução Futura:<br>
A API está preparada para expansão adicionando novos critérios e escolas.<br>
<br>
Resposta:<br>
A API retorna um JSON com as edições e os cursos filtrados.<br>
pela URL:<br>
http://localhost:8888/apiCursos.php?cursos=[{"criteria":["closest","school-cooperacao"],"editions":[{"date": "2025-06-01","courses":[ {"name": "Especialista em cooperação internacional", "type": "cooperacao"},{"name":"Divulgação e cooperação da ciência","type":"divulgacao-cientifica"}]},{"date":"2025-09-01","courses":[{"name":"Compreendendo o tupari","type":"tupari"}]}]}]
<br><br>
Evidência de teste:<br>
![image](https://github.com/user-attachments/assets/d3a1962c-9fe5-4cbe-8497-8508e37af997)
<br><br>
Esta solução está pronta para ser implantada e passa em todos os casos de teste fornecidos.
