<?php

require_once('02_config.php');

//Com o require do config ele consegue encontrar as classes dentro dos arquivos. Então ele precisa encontrar a classe Sql, 
$sql = new Sql();

//Encontrando a classe, eu vou mandar executar um comando no banco de dados. 
//Quero listar tudo que têm na tabela usuários
// Vou dizer que tudo isso faz parte de outra variável $sql->select("SELECT * FROM tb_usuarios")

$usuarios = $sql->select("SELECT * FROM tb_usuarios"); 

//Vou fazer um echo 
echo json_encode($usuarios);

?>