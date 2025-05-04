<?php
header('Content-Type: application/json; charset=utf-8');

// Configuração das escolas e suas temáticas
$schools = [
    'educacao' => ['infantil', 'competencias-digitais', 'governanca'],
    'linguas' => ['aymara', 'nheengatu', 'quechua', 'tupari'],
    'ciencia-e-cultura' => ['educacao-artistica', 'divulgacao-cientifica'],
    'cooperacao' => ['cooperacao']
];

// Função para processar os critérios
function processCriteria($criteriaList, $editions, $schools) {
    $filteredEditions = [];
    $currentDate = new DateTime();
    
    // Primeiro filtramos as edições com base nos critérios temporais
    $temporalCriteria = array_filter($criteriaList, function($c) {
        return in_array($c, ['closest', 'latest']);
    });
    
    // Se não houver critério temporal, consideramos todas as edições
    $editionsToConsider = $editions;
    
    if (!empty($temporalCriteria)) {
        $temporalCriterion = reset($temporalCriteria);
        
        // Ordenamos as edições por data
        usort($editions, function($a, $b) {
            $dateA = new DateTime($a['date']);
            $dateB = new DateTime($b['date']);
            return $dateA <=> $dateB;
        });
        
        if ($temporalCriterion === 'closest') {
            // Encontramos a próxima edição após a data atual
            $closestEdition = null;
            foreach ($editions as $edition) {
                $editionDate = new DateTime($edition['date']);
                if ($editionDate >= $currentDate) {
                    $closestEdition = $edition;
                    break;
                }
            }
            $editionsToConsider = $closestEdition ? [$closestEdition] : [];
        } elseif ($temporalCriterion === 'latest') {
            // Pegamos a edição mais distante no futuro
            $editionsToConsider = !empty($editions) ? [end($editions)] : [];
        }
    }
    
    // Agora filtramos os cursos com base nos outros critérios
    foreach ($editionsToConsider as $edition) {
        $filteredCourses = [];
        
        foreach ($edition['courses'] as $course) {
            $includeCourse = true;
            
            foreach ($criteriaList as $criterion) {
                if (strpos($criterion, 'type-') === 0) {
                    $type = substr($criterion, 5);
                    if ($course['type'] !== $type) {
                        $includeCourse = false;
                        break;
                    }
                } elseif (strpos($criterion, 'school-') === 0) {
                    $school = substr($criterion, 7);
                    if (!isset($schools[$school]) || !in_array($course['type'], $schools[$school])) {
                        $includeCourse = false;
                        break;
                    }
                }
            }
            
            if ($includeCourse) {
                $filteredCourses[] = $course['name'];
            }
        }
        
        if (!empty($filteredCourses)) {
            $filteredEditions[] = [
                'date' => $edition['date'],
                'courses' => $filteredCourses
            ];
        }
    }
    
    return $filteredEditions;
}

// Obter o input JSON
//$input = file_get_contents('php://input');
//$input = '[{"criteria":["closest","school-cooperacao"],"editions":[{"date": "2025-06-01","courses":[ {"name": "Especialista em cooperação internacional", "type": "cooperacao"},{"name":"Divulgação e cooperação da ciência","type":"divulgacao-cientifica"}]},{"date":"2025-09-01","courses":[{"name":"Compreendendo o tupari","type":"tupari"}]}]}]';

//$input = file_get_contents('test_cases.JSON');

$input = $_REQUEST['cursos'];

$data = json_decode($input, true);

if (json_last_error() !== JSON_ERROR_NONE || !isset($data[0]['criteria']) || !isset($data[0]['editions'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input format']);
    exit;
}

// Processar cada requisição
$response = [];
foreach ($data as $request) {
    $criteria = $request['criteria'];
    $editions = $request['editions'];
    
    $result = processCriteria($criteria, $editions, $schools);
    $response = array_merge($response, $result);
}


echo json_encode($response);

?>