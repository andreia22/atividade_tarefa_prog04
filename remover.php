<?php

include "banco.php";
include "config.php";

remover_tarefa($conexao, $_GET['id']);

header('Location: tarefas.php');
