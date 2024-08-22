<?php
require_once("../core/header.php");

function getDadosEscola($codigoEscolaAlterar){
    $descricao = "";
    $cidade = "";

    // VAI BUSCAR OS DADOS DE Escola.JSON
    $dadosEscola = @file_get_contents("Escola.json");

    // TRANSFORMAR EM ARRAY
    $arDadosEscola = json_decode($dadosEscola, true);

    $encontrouEscola = false;
    foreach($arDadosEscola as $aDados){
        $codigoAtual = $aDados["codigo"];
        if($codigoEscolaAlterar == $codigoAtual){
            $encontrouEscola = true;
            $descricao = $aDados["descricao"];
            $cidade = $aDados["cidade"];

            // para a execução do loop
            break;
        }
    }

    return array($descricao, $cidade, $encontrouEscola);
}

// Verificar se existe acao
$codigo = "";
$descricao = "";
$cidade = "";
$display = "block;";

$encontrouEscola = false;
$mensagemEscolaNaoEncontrado = "Não foi encontrado nenhum Escola para o codigo informado!Código: ";

$acaoFormulario = "INCLUIR";
if(isset($_GET["ACAO"])){
    $acao = $_GET["ACAO"];
    if($acao == "ALTERAR"){
        $acaoFormulario = "ALTERAR";

        $display = "none;";
        $codigo = $_GET["codigo"];
        list($descricao, $cidade, $encontrouEscola) = getDadosEscola($codigo);

        if($encontrouEscola){
            // Limpa a mensagem de erro
            $mensagemEscolaNaoEncontrado = "";
        } else {
            // Adiciona o codigo do Escola no fim
            $mensagemEscolaNaoEncontrado .= $codigoEscola;
        }
    }
}

$sHTML = '<div> <link rel="stylesheet" href="../css/formulario.css">';

// FORMULARIO DE CADASTRO DE Escola
$sHTML .= '<h2 style="text-align:center;">Formulário de Escola</h2>
    <h3>' . $mensagemEscolaNaoEncontrado . '</h3>
    <form action="cadastrar_Escola.php" method="POST">
        <input type="hidden" id="ACAO" name="ACAO" value="' . $acaoFormulario . '">

        <label for="codigo">Código:</label>
        <input type="hidden" id="codigo" name="codigo" value="' . $codigo . '" required>
        <input type="text" id="codigoTela" name="codigoTela" value="' . $codigo . '" disabled>

        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" required value="' . $descricao . '">

        <label for="cidade">Cidade:</label>
        <select id="cidade" name="cidade">
            <option value="1">Rio do Sul</option>
            <option value="2">Ibirama</option>
            <option value="3">Ituporanga</option>
            <option value="4">Joinvile</option>
            <option value="5">Florianópolis</option>
            <option value="6">Blumenau</option>
        </select> 
        <br>      
        <br>      
        
        <label for="">Tipo Ensino:</label>
        
        <div style="display:flex;width:85%;flex-wrap:wrap;">
            <label for="tipo_ensino_creche">Creche:</label>
            <input type="checkbox" id="tipo_ensino_creche" name="tipo_ensino_creche" value="">
            
            <label for="tipo_ensino_basico">Básico:</label>
            <input type="checkbox" id="tipo_ensino_basico" name="tipo_ensino_basico" value="">
            
            <label for="tipo_ensino_fundamental">Fundamental:</label>
            <input type="checkbox" id="tipo_ensino_fundamental" name="tipo_ensino_fundamental" value="">
                        
            <label for="tipo_ensino_medio">Médio:</label>
            <input type="checkbox" id="tipo_ensino_medio" name="tipo_ensino_medio" value="">
            
            <label for="tipo_ensino_profissional">Profissional:</label>
            <input type="checkbox" id="tipo_ensino_profissional" name="tipo_ensino_profissional" value="">
            
            <label for="tipo_ensino_tecnico">Técnico:</label>
            <input type="checkbox" id="tipo_ensino_tecnico" name="tipo_ensino_tecnico" value="">

            <label for="tipo_ensino_superior">Superior:</label>
            <input type="checkbox" id="tipo_ensino_superior" name="tipo_ensino_superior" value="">
        <div>

        <br>      
        <br> 

        <input type="submit" value="Enviar">
    </form>';

// CONSULTA DE Escola
$sHTML .= '</div>';

echo $sHTML;

require_once("../core/footer.php");
