<?php


use PHPMailer\PHPMailer\PHPMailer;


function tem_post()
{
    if (count($_POST) > 0) {
        return true;
    }

    return false;
}

function tratar_anexo($anexo) {
    $padrao = '/^.+(\.pdf$|\.zip$)$/';
    $resultado = preg_match($padrao, $anexo['name']);

    if (! $resultado) {
        return false;
    }

    move_uploaded_file($anexo['tmp_name'], "anexos/{$anexo['name']}");

    return true;
}

function validar_data($data)
{
    $padrao = '/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/';
    $resultado = preg_match($padrao, $data);

    if (! $resultado) {
        return false;
    }

    $dados = explode('/', $data);

    $dia = $dados[0];
    $mes = $dados[1];
    $ano = $dados[2];

    $resultado = checkdate($mes, $dia, $ano);

    return $resultado;
}

function traduz_concluida($concluida)
{
    if ($concluida == 1) {
        return 'Sim';
    }

    return 'Não';
}

function traduz_prioridade($codigo)
{
    $prioridade = '';
    switch ($codigo) {
        case 1:
            $prioridade = 'Baixa';
            break;
        case 2:
            $prioridade = 'Média';
            break;
        case 3:
            $prioridade = 'Alta';
            break;
    }

    return $prioridade;
}

function traduz_data_para_banco($data)
{
    if ($data == "") {
        return "";
    }

    $dados = explode("/", $data);

    if (count($dados) != 3) {
        return $data;
    }

    $data_mysql = "{$dados[2]}-{$dados[1]}-{$dados[0]}";

    return $data_mysql;
}

function traduz_data_para_exibir($data)
{
    if ($data == "" OR $data == "0000-00-00") {
        return "";
    }

    $dados = explode("-", $data);

    if (count($dados) != 3) {
        return $data;
    }

    $data_exibir = "{$dados[2]}/{$dados[1]}/{$dados[0]}";

    return $data_exibir;
}


function enviar_email($tarefa, $anexos = array())

{
include "bibliotecas/PHPMailer/inc.php";

$corpo = preparar_corpo_email($tarefa, $anexo);

$email = new PHPMailer();

$email-> isSMTP();
$email->Host = "smpt.gmail.com";
$email->Port = 587;
$email->SMTPSecure = 'tls';
$email->SMTPAuth = true;
$email->Username = "andreiaunoesc2023@gmail.com";
$email->Password = "minhasenha";
$email->setFrom("andreiaunoesc2023@gmail.com", "Avisador de tarefas");
$email->addAddress(EMAIL_NOTIFICACAO);
$email->Subject = "Aviso de tarefa: {$tarefa['nome']}";
$email->msgHTML($corpo);

foreach ($anexos as $anexo){
     $email->addAttchment("anexos/{$anexos['arquivo']}");

} 

$email->send();
}


function preparar_corpo_email($tarefa, $anexos) {

ob_start();
include "template_email.php";

$corpo = ob_get_contents();

ob_end_clean();
return $corpo;



}

function montar_email() {
    $tem_erros = '';

    if (count($anexos) > 0) {

        $tem_erros = "<p><strong>Atenção!</strong> Esta tarefa contem anexos! </p>";
    }


    $corpo = "
        <html>
        <head>
        <meta charset=\"utf-8\" />
        <title> Gerenciador de tarefas</title>
        <link rel=\"stylesheet\" href=\"tarefas.css\" type=\"text/css\" />
        </head>

        <body>

        <h1> Tarefa: {$tarefa['nome']}</h1>

        <p><strong>Concluida:</strong> " . traduz_concluida($tarefa['concluida']) . "</p>

        <p><strong>Descrição:</strong> " . ($tarefa['descricao']) . "</p>

<p><strong>Prazo:</strong> " . traduz_data_para_exibir($tarefa['prazo']) . "</p>
<p><strong>Priioridade:</strong> " . traduz_prioridade($tarefa['prioridade']) . "</p>



        {$tem_erros}

</body>

</html>
";




}