<?php

include "config.php";

$conexao = mysqli_connect(BD_SERVIDOR, BD_USUARIO, BD_SENHA, BD_BANCO);

/*if (mysqli_connect_errno($conexao)) {
    echo "Problemas para conectar no banco. Verifique os dados!";
    die();
}
*/


function gravar_anexo($conexao, $anexo)
{
    $sqlGravar = "INSERT INTO anexos
        (tarefa_id, nome, arquivo)
        VALUES
        (
            {$anexo['tarefa_id']},
            '{$anexo['nome']}',
            '{$anexo['arquivo']}'
        )
    ";

    mysqli_query($conexao, $sqlGravar);
}

function buscar_anexo($conexao, $id)
{
    $sqlBusca = 'SELECT * FROM anexos WHERE id = ' . $id;
    $resultado = mysqli_query($conexao, $sqlBusca);
    return mysqli_fetch_assoc($resultado);
}

function remover_anexo($conexao, $id)
{
    $sqlRemover = "DELETE FROM anexos WHERE id = {$id}";

    mysqli_query($conexao, $sqlRemover);
}

function buscar_anexos($conexao, $tarefa_id)
{
    $sqlBusca = "SELECT * FROM anexos WHERE tarefa_id = {$tarefa_id}";
    $resultado = mysqli_query($conexao, $sqlBusca);

    $anexos = array();

    while ($anexo = mysqli_fetch_assoc($resultado)) {
        $anexos[] = $anexo;
    }

    return $anexos;
}

function buscar_tarefas($conexao)
{
    $sqlBusca = 'SELECT * FROM tarefa';
    $resultado = mysqli_query($conexao, $sqlBusca);

    $tarefas = array();

    while ($tarefa = mysqli_fetch_assoc($resultado)) {
        $tarefas[] = $tarefa;
    }

    return $tarefas;
}

function buscar_tarefa($conexao, $id)
{
    $sqlBusca = 'SELECT * FROM tarefa WHERE id = ' . $id;
    $resultado = mysqli_query($conexao, $sqlBusca);
    return mysqli_fetch_assoc($resultado);
}

function gravar_tarefa($conexao, $tarefa)
{
    $sqlGravar = "
        INSERT INTO tarefa
        (nome, descricao, prioridade, prazo, concluida)
        VALUES
        (
            '{$tarefa['nome']}',
            '{$tarefa['descricao']}',
            {$tarefa['prioridade']},
            '{$tarefa['prazo']}',
            {$tarefa['concluida']}
        )
    ";

    mysqli_query($conexao, $sqlGravar);
}

function editar_tarefa($conexao, $tarefa)
{
    $sqlEditar = "
        UPDATE tarefa SET
            nome = '{$tarefa['nome']}',
            descricao = '{$tarefa['descricao']}',
            prioridade = {$tarefa['prioridade']},
            prazo = '{$tarefa['prazo']}',
            concluida = {$tarefa['concluida']}
        WHERE id = {$tarefa['id']}
    ";

    mysqli_query($conexao, $sqlEditar);
}

function remover_tarefa($conexao, $id)
{
    $sqlRemover = "DELETE FROM tarefa WHERE id = {$id}";

    mysqli_query($conexao, $sqlRemover);
}
