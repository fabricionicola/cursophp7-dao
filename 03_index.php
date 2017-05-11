<?php

require_once("02_config.php");

//Com o require do config ele consegue encontrar as classes dentro dos arquivos. Então ele precisa encontrar a classe Sql, 
//Estou comentando a próxima linha, pois ela se encontra na classe e no arquivo Usuario, na linha 48. 
//$sql = new Sql();

//Encontrando a classe, eu vou mandar executar um comando no banco de dados. 
//Quero listar tudo que têm na tabela usuários
// Vou dizer que tudo isso faz parte de outra variável $sql->select("SELECT * FROM tb_usuarios")

//AQUI NÓS TINHAMOS UM SELECT SIMPLES DE TODOS OS DADOS
//$usuarios = $sql->select("SELECT * FROM tb_usuarios"); 

//Vou fazer um echo 
//echo json_encode($usuarios);

//AGORA EU SÓ VOU USAR A CLASSE USUÁRIO
//Estou usando uma referência que já existe no banco de dados. Um usuário que já existe.
$user2 = new Usuario();

//Vou chamar o método que a gente criou o loadById. Dentro do método eu coloco o ID do usuário que eu estou chamando, que no caso é "6"
$user2->loadById(6);

//Agora eu vou exibir o usuário na tela. 
//Como é um objeto, vai gerar um __toString e vai gerar um json, que foi o estabelecido no arquivo da classe Usuario
echo $user2;
?>