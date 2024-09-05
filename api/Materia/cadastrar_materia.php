<?php
function alterar_materia(){

    $codigoMateriaAlterar = $_POST["codigo"];    
    $turma       = $_POST["turma"];
    $descricao         = $_POST["descricao"];
    
    $dadosMaterias = @file_get_contents("materia.json");
    $arDadosMaterias = json_decode($dadosMaterias, true);

    $arDadosMateriasNovo = array();
    foreach($arDadosMaterias as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoMateriaAlterar == $codigoAtual){
            $aDados["descricao"] = $descricao;
            $aDados["turma"] = (int)$turma;
        }

        $arDadosMateriasNovo[] = $aDados;
    }

    // Gravar os dados no arquivo
    file_put_contents("materia.json", json_encode($arDadosMateriasNovo));
}

function excluir_materia(){
    $codigoMateriaExcluir = $_GET["codigo"];

    $dadosMaterias = @file_get_contents("materia.json");
    $arDadosMaterias = json_decode($dadosMaterias, true);

    $arDadosMateriasNovo = array();
    foreach($arDadosMaterias as $aDados){
        $codigoAtual = $aDados["codigo"];
        if($codigoMateriaExcluir == $codigoAtual){
            continue;
        }

        $arDadosMateriasNovo[] = $aDados;
    }

    // Gravar os dados no arquivo
    file_put_contents("materia.json", json_encode($arDadosMateriasNovo));
}

function incluir_materia(){
    $arDadosMaterias = array();

    // Primeiro, verifica se existe dados no arquivo json
    // @ na frente do metodo, remove o warning
    $dadosMaterias = @file_get_contents("materia.json");
    if($dadosMaterias){
        // transforma os dados lidos em ARRAY, que estavam em JSON
        $arDadosMaterias = json_decode($dadosMaterias, true);
    }

    // Armazenar os dados do turma atual, num array associativo

    $aDadosMateriaAtual = array();
    $aDadosMateriaAtual["codigo"] = getProximoCodigo($arDadosMaterias);

    $aDadosMateriaAtual["turma"]       = $_POST["turma"];
    $aDadosMateriaAtual["descricao"]         = $_POST["descricao"];
    
    // Pega os dados atuais do turma e armazena no array que foi lido
    $arDadosMaterias[] = $aDadosMateriaAtual;

    // Gravar os dados no arquivo
    file_put_contents("materiai.json", json_encode($arDadosMaterias));
}

function getProximoCodigo($arDadosMaterias){
    $ultimoCodigo = 0;
    foreach($arDadosMaterias as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoAtual > $ultimoCodigo){
            $ultimoCodigo = $codigoAtual;
        }      
    }

    return $ultimoCodigo + 1;
}

// echo "<pre>" . print_r($_POST, true) . "</pre>";return true;

// Verificar se esta setado o $_POST
if(isset($_POST["ACAO"])){
    $acao = $_POST["ACAO"];
    if($acao == "INCLUIR"){
        incluir_materia();

        // Redireciona para a pagina de consulta de turma
        header('Location: consulta_materia.php');
    } else if($acao == "ALTERAR"){        
        alterar_materia();

        // Redireciona para a pagina de consulta de turma
        header('Location: consulta_materia.php');
    }
} else if(isset($_GET["ACAO"])){
    $acao = $_GET["ACAO"];
    if($acao == "EXCLUIR"){
        excluir_materia();
        
        // Redireciona para a pagina de consulta de turma
        header('Location: consulta_materia.php');
    } else if($acao == "ALTERAR"){
        // CAMEL CASE
        $codigoMateriaAlterar = $_GET["codigo"];
        
        // Redireciona para a pagina de turma
        header('Location: materia.php?ACAO=ALTERAR&codigo=' . $codigoMateriaAlterar);
    }
} else {
    // Redireciona para a pagina de consulta de turma
    header('Location: consulta_materia.php');
}
