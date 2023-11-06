<h1>Tarefa: <?php echo $tarefa['nome']; ?></h1>

<p><strong>Concluida: </strong> <?php echo traduz_concluida($tarefa['concluida']); ?> </p>

<p><strong>Descrição:</strong> <?php echo nl2br($tarefa['descricao']); ?> </p>

<P><strong>Prazo:</strong> <?php echo traduz_data_para_exibir($tarefa['prazo']); ?> </P>

<p><strong>Prioridade:</strong> <?php echo traduz_prioridade($tarefa['prioridade']); ?> </p>

<?php  $anexos = array();

if(count($anexos) > 0) : ?>
	<p><strong>Atenção!</strong> Esta tarefa contem anexos! </p>

	<?php endif; ?>