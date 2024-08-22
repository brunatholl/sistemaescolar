<?php
function alterar_Escola(){
    $codigoEscolaAlterar = $_POST["codigo"];
    $nome = $_POST["nome"];
    $cidade = $_POST["cidade"];
    $email = $_POST["email"];
    
    $dadosEscola = @file_get_contents("Escola.json");
    $arDadosEscola = json_decode($dadosEscola, true);

    $arDadosEscolaNovo = array();
    foreach($arDadosEscola as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoEscolaAlterar == $codigoAtual){
            $aDados["nome"] = $nome;
            $aDados["cidade"] = $cidade;
            $aDados["email"] = $email;
        }

        $arDadosEscolaNovo[] = $aDados;
    }

    // Gravar os dados no arquivo
    file_put_contents("Escola.json", json_encode($arDadosEscolaNovo));
}

function excluir_Escola(){
    $codigoEscolaExcluir = $_GET["codigo"];

    $dadosEscola = @file_get_contents("Escola.json");
    $arDadosEscola = json_decode($dadosEscola, true);

    $arDadosEscolaNovo = array();
    foreach($arDadosEscola as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoEscolaExcluir == $codigoAtual){
            // ignora e vai para o proximo registro
            continue;
        }

        $arDadosEscolaNovo[] = $aDados;
    }

    // Gravar os dados no arquivo
    file_put_contents("Escola.json", json_encode($arDadosEscolaNovo));
}

function incluir_Escola(){
    $arDadosEscola = array();

    // Primeiro, verifica se existe dados no arquivo json
    // @ na frente do metodo, remove o warning
    $dadosEscola = @file_get_contents("Escola.json");
    if($dadosEscola){
        // transforma os dados lidos em ARRAY, que estavam em JSON
        $arDadosEscola = json_decode($dadosEscola, true);
    }

    // Armazenar os dados do Escola atual, num array associativo

    $aDadosEscolaAtual = array();
    $aDadosEscolaAtual["codigo"] = getProximoCodigo($arDadosEscola);
    $aDadosEscolaAtual["nome"] = $_POST["nome"];
    $aDadosEscolaAtual["cidade"] = $_POST["cidade"];
    $aDadosEscolaAtual["email"] = $_POST["email"];
    // $aDadosEscolaAtual["senha"] = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    // Pega os dados atuais do Escola e armazena no array que foi lido
    $arDadosEscola[] = $aDadosEscolaAtual;

    // Gravar os dados no arquivo
    file_put_contents("Escola.json", json_encode($arDadosEscola));
}

function getProximoCodigo($arDadosEscola){
    $ultimoCodigo = 0;
    foreach($arDadosEscola as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoAtual > $ultimoCodigo){
            $ultimoCodigo = $codigoAtual;
        }      
    }

    return $ultimoCodigo + 1;
}

// PROCESSAMENTO DA PAGINA
// echo "<pre>" . print_r($_POST, true) . "</pre>";return true;
// echo "<pre>" . print_r($_GET, true) . "</pre>";return true;

// Verificar se esta setado o $_POST
if(isset($_POST["ACAO"])){
    $acao = $_POST["ACAO"];
    if($acao == "INCLUIR"){
        incluir_Escola();

        // Redireciona para a pagina de consulta de Escola
        header('Location: consulta_Escola.php');
    } else if($acao == "ALTERAR"){        
        alterar_Escola();

        // Redireciona para a pagina de consulta de Escola
        header('Location: consulta_Escola.php');
    }
} else if(isset($_GET["ACAO"])){
    $acao = $_GET["ACAO"];
    if($acao == "EXCLUIR"){
        excluir_Escola();
        
        // Redireciona para a pagina de consulta de Escola
        header('Location: consulta_Escola.php');
    } else if($acao == "ALTERAR"){
        $codigoEscolaAlterar = $_GET["codigo"];

        // Redireciona para a pagina de Escola
        header('Location: Escola.php?ACAO=ALTERAR&codigo=' . $codigoEscolaAlterar);
    }
} else {
    // Redireciona para a pagina de consulta de Escola
    header('Location: consulta_Escola.php');
}
