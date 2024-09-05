<?php

function getNomeTurma($codigoTurma){    
    $arDadosTurmas = array();
    $dadosTurmas = @file_get_contents("../turma/turma.json");
    if($dadosTurmas){
        $arDadosTurmas = json_decode($dadosTurmas, true);
    }

    $nome = "Nome invalido!";
    //  preencher com php - mais options de ESCOLA
    foreach($arDadosTurmas as $aDados){
        if($aDados["codigo"] == $codigoTurma){
            $nome = $aDados["descricao"];
        }
    }

    return $nome;    
}

function getAcaoExcluirMateria($codigo){
    $sHTML = "<a id='acaoExcluir' href='http://localhost/sistemaescolar/api/materia/cadastrar_materia.php?ACAO=EXCLUIR&codigo=" . $codigo . "'>Excluir</a>";
    return $sHTML;
}

function getAcaoAlterarMateria($codigo){
    $sHTML = "<a id='acaoAlterar' href='http://localhost/sistemaescolar/api/materia/cadastrar_materia.php?ACAO=ALTERAR&codigo=" . $codigo . "'>Alterar</a>";
    return $sHTML;
}

require_once("../core/header.php");

echo '<h3 style="text-align:center;">CONSULTA DE Materia</h3>';

$htmlTabelaMaterias = "<a href='materia.php'><button class='button' type='button'>Incluir<button></a>";
$htmlTabelaMaterias .= "<table border='1'>";

// HEADER DA TABLE
$htmlTabelaMaterias .= "<head>";

// TITULOS DA TABLE
$htmlTabelaMaterias .= "<tr>";
$htmlTabelaMaterias .= "  <th>Código</th>";
$htmlTabelaMaterias .= "  <th>Turma</th>";// Nome da Escola - buscar pelo codigo
$htmlTabelaMaterias .= "  <th>Descrição</th>";
$htmlTabelaMaterias .= "</tr>";

$htmlTabelaMaterias .= "</head>";
$htmlTabelaMaterias .= "<tbody>";

$arDadosMaterias = array();

$dadosMaterias = @file_get_contents("materias.json");
if($dadosMaterias){
    $arDadosMaterias = json_decode($dadosMaterias, true);
}

foreach($arDadosMaterias as $aDados){
    // ABRIR UMA NOVA LINHA
    $htmlTabelaMaterias .= "<tr>";
    $htmlTabelaMaterias .= "<td align='center'>" . $aDados["codigo"] . "</td>";

    $codigoTurma = $aDados["turma"];
    $nomeTurma = getNomeTurma($codigoTurma);
    $htmlTabelaMaterias .= "<td align='left'>" . $nomeTurma . "</td>";

    $htmlTabelaMaterias .= "<td align='left'>" . $aDados["descricao"] . "</td>";
    
    // Adiciona a ação de excluir materia
    $codigo = $aDados["codigo"];

    $htmlTabelaMaterias .= '<td>';
    $htmlTabelaMaterias .= getAcaoExcluirMateria($codigo);
    $htmlTabelaMaterias .= '</td>';

    $htmlTabelaMaterias .= '<td>';
    $htmlTabelaMaterias .= getAcaoAlterarMateria($codigo);
    $htmlTabelaMaterias .= '</td>';

    // FECHAR A LINHA ATUAL
    $htmlTabelaMaterias .= "</tr>";
}

$htmlTabelaMaterias .= "</tbody>";
$htmlTabelaMaterias .= "</table>";

echo $htmlTabelaMaterias;

require_once("../core/footer.php");
