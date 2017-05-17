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

/* O LOADBYID TRAZ UM USUÁRIO, COM REFERÊNCAI O ID
//Estou usando uma referência que já existe no banco de dados. Um usuário que já existe.
$user2 = new Usuario();

//Vou chamar o método que a gente criou o loadById. Dentro do método eu coloco o ID do usuário que eu estou chamando, que no caso é "6"
$user2->loadById(6);

//Agora eu vou exibir o usuário na tela. 
//Como é um objeto, vai gerar um __toString e vai gerar um json, que foi o estabelecido no arquivo da classe Usuario
echo $user2;
*/

//AQUI EU VOU USAR O GETLIST DA CLASSE USUARIO
//O getList vai trazer uma lista de usuários
//Como o método está como static, eu não preciso instanciar.
//$lista = Usuario::getList();
//echo json_encode($lista);

//NESSE PRÓXIO, ELE CARREGA UMA LISTA DE USUÁRIOS, BUSCANDO PELO LOGIN
//Esse método é o search, que está na classe Usuario
//Dentro dos parênteses vai o que queremos buscar, que é pelo login
//Vou dizer para ele me retornar todos os usuários que comecem com "us"
//$search = Usuario::search("us");
//echo json_encode($search);

//NESTE, CARREGA O USUÁRIO USANDO O LOGIN E A SENHA
//Estamos chamando o método login que está na classe Usuario
//$usuario = new Usuario();
//Ele espera o login e a senha. É isso que vai dentro do parênteses
//$usuario->login("user2", "&%!@123");
//Fazendo um echo do $usuário, ele executa um __toString e retorna um json na tela
//echo $usuario;

//AQUI VAMOS FAZER UM INSERT DE UM USUARIO NOVO
//$aluno = new Usuario();
//Vou dizer que o login é aluno 
//$aluno->setDeslogin("aluno");
//$aluno->setDessenha("@lun0");
//Para enviar para o banco de dados
//Preciamos chamar o método INSERT que criamos, se não ele fica só no objeto
//Ele vai mostrar o ID e o DTCADASTRO porque nós pedimos para que ele fizesse isso via procedure (no banco de dados), que está la no método insert
//$aluno->insert();
//Aqui vamos jogar as informações do banco na tela via json
//echo $aluno;

//AQUI VAMOS FAZER UM INSERT DE UM USUARIO NOVO - VIA MÉTODO CONSTRUTOR
//O login e a senha do aluno vem dentro do método construtor
//$aluno = new Usuario("aluno", "@lun0");

//$aluno->insert();
//Aqui vamos jogar as informações do banco na tela via json
//echo $aluno;
//Quando usar esse método contrutor, você DEVE PASSAR o usuário e a senha TODA VEZ que vc instanciar o objeto Usuario.

//AQUI VAMOS FAZER UM UPDATE
$usuario = new Usuario();
//Precisamos carregar antes. Se nós queremos atualizar, é preciso existir esse registro.
$usuario->loadById(8);
//Carregamos o usuario 8, agora vamos atualizar. Preciso passar o login e a senha
$usuario->update("Professor","12893473");

echo $usuario;

?>