<!-- Colunas
codigo
descricao
Curso - código do curso - COMBOBOX -->

<?php
require_once("../core/header.php");


function getComboTurma($codigoTurma = false){
    $arDadosTurmas = array();
    $dadosTurmas = @file_get_contents("../turma/turmas.json");
    if($dadosTurmas){
        // transforma os dados lidos em ARRAY, que estavam em JSON
        $arDadosTurmas = json_decode($dadosTurmas, true);
    }

    $html = '<div style="display:flex;gap:5px;flex-direction:row;">';

    $html .= '  <label for="turma">Turma:</label>';
    $html .= '  <select id="turma" name="turma">';
    $html .= '    <option value="0">Selecione</option>';

    //  preencher com php - mais options de ESCOLA
    foreach($arDadosTurmas as $aDados){
        $selected = "";
        if($codigoTurma == $aDados["codigo"]){
            $selected = " selected ";                    
        }

        $html .= '<option value="'. $aDados["codigo"] .'" ' . $selected .'>' . $aDados["nome"] . '</option>';
    }

    $html .= '</select>';
    $html .= '</div>';

    return $html;
}



function getDadosMateria($codigoMateriaAlterar){
    $codigoMateria = "";
    $descricao = "";

    // VAI BUSCAR OS DADOS DE Professor.JSON
    $dadosMaterias = @file_get_contents("materia.json");
    // TRANSFORMAR EM ARRAY
    $dadosMaterias = json_decode($dadosMaterias, true);
    // para testar
    // echo  "<pre>" . print_r($arDadosProfessor, true) . "</pre>";
    // return true;

    $encontrouMateria = false;
    foreach($dadosMaterias as $aDados){
        $codigoAtual = $aDados["codigo"];
        if($codigoMateriaAlterar == $codigoAtual){
            $encontrouMateria = true;
            $turma = $aDados["turma"];
            $descricao = $aDados["descricao"];
            // duvida sobre alterar combo box da turma selecionada

            // para a execução do loop
            break;
        }
    }

    return array(
        $descricao, 
        $turma, 
        $encontrouMateria
    );
}

// Verificar se existe acao
$codigoMateria = "";
$turma = "";
$descricao = "";
$display = "block;";

$encontrouMateria = false;
$mensagemMateriaNaoEncontrado = "";

$codigoTurma = false;
$acaoFormulario = "INCLUIR";
if(isset($_GET["ACAO"])){
    $acao = $_GET["ACAO"];
    if($acao == "ALTERAR"){
        $acaoFormulario = "ALTERAR";
        
        $display = "none;";
        $codigoMateria = $_GET["codigo"];
        list($codigoTurma, $codigoMateria, $descricao, $encontrouMateria) = getDadosMateria($codigoMateria);
        
        if($encontrouMateria){
            // Limpa a mensagem de erro
            $mensagemMateriaNaoEncontrado = "";
        } else {
            // Adiciona o codigo do Professor no fim
            $mensagemMateriaNaoEncontrado = "Não foi encontrado nenhuma Materia para o codigo informado! Código: ";
            $mensagemMateriaNaoEncontrado .= $codigo;
        }
    }
}

$sHTML = '<div> <link rel="stylesheet" href="../css/formulario.css">';

$comboTurma = getComboTurma($codigoTurma);

// FORMULARIO DE CADASTRO DE Materia
$sHTML .= '<h2 style="text-align:center;">Formulário de Materia</h2>
    <h3>' . $mensagemMateriaNaoEncontrado . '</h3>
    <form action="cadastrar_materia.php" method="POST">
        <input type="hidden" id="ACAO" name="ACAO" value="' . $acaoFormulario . '">

        
        <label for="codigo">Código:</label>
        <input type="hidden" id="codigo" name="codigo" value="' . $codigoMateria . '" required>
        <input type="text" id="codigoTela" name="codigoTela" value="' . $codigoMateria . '" disabled>
        
        ' . $comboTurma . '
<br>
        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" required value="' . $descricao . '">


        <div style="display:' . $display . ';">
        </div>

        <input type="submit" value="Enviar">
    </form>';

// CONSULTA DE ProfessorS
$sHTML .= '</div>';

echo $sHTML;

require_once("../core/footer.php");
