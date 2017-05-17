<?php
//Nós já fizemos um arquivo para conversar com o banco de dados..

//Neste arquivo, nós vamos CONVERSAR COM OS USUÁRIOS.

//Aqui nós vamos criar uma classe Usuário e vamos colocas as colunas que temos lá no banco de dados.

class Usuario {

//Sou obrigado a colocar os campos do banco de dados, com os mesmos nomes aqui? Não, é só para ficar mais fácil para eu me achar.
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;
//Depois que eu criei todos os atributos private, eu tenho que fazer todos os getters and setters de cada um.

	public function getIdusuario(){
		return $this->idusuario;
	}
	public function setIdusuario($value){
		$this->idusuario = $value;
	}

	public function getDeslogin(){
		return $this->deslogin;
	}
	public function setDeslogin($value){
		$this->deslogin = $value;
	}

	public function getDessenha(){
		return $this->dessenha;
	}
	public function setDessenha($value){
		$this->dessenha = $value;
	}

	public function getDtcadastro(){
		return $this->dtcadastro;
	}
	public function setDtcadastro($value){
		$this->dtcadastro = $value;
	}

//Aqui nós vamos fazer o SELECT
	public function loadById($id){
//Para fazer um Select simples, precisamos instanciar a classe Sql, para conectar, preparar o banco de dados; que é isso que a classe que criamos e está lá no aruivo sql faz.
		$sql = new Sql();

//Agora sim, podemos fazer o Select, mas antes, temos que tratar criando a variável results e igualando ao select. 

//Dentro do array nós vamos ter os parâmetros ou os PARAMETERS que a gente colocou dentro da classe Sql
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(":ID"=>$id));

//Agora vamos validar o resultado. Porque pode ser que ele busque por um ID que o banco da dados não possui. Então, Se $results, isset(existe), no índice 0 ele tem um resultdo. Ou pode ser feito como a próxim linha comentada:
		//if (isset($results[0]))
		if (count($results)>0){

			//Quando obtemos o registro, nós vamos chamar o método setData, passando o results com índex 0
			//Crio uma variável para pegar os resultados da linha 0
			$this->setData($results[0]);
		}
		
	}

//AQUI VAMOS APRENDER A LISTAR DADOS. Eu posso trazer todos os dados de uma tabela ou um usuário por uma determinada condição.
//Esse é um EXEMPLO de como listar dados. Mais um método.
	//Vou colocar ele como estático para que eu não precise instanciar esse método no index. É só mais um exercício.
	public static function getList(){
		//Precisamos instanciar a classe Sql
		$sql = new Sql();

		//Agora vamos fazer um return do select
		return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
//Então, o loadById vai trazer um usuário (o usuário daquele ID), o getList vai trazer uma lista de usuários. 

	}

//AQUI VAMOS FAZER UM SEARCH, DE FORMA ESTÁTICA, vamos buscar um usuário
//Como parâmetro que será 
	public static function search($login){
		$sql = new Sql();

//O %% aqui quer dizer que não importa se o login começa, termina ou contenha letras.
//Como é um bindParam, precisamos colocar um Id para ele, que no caso aqui é ":SEARCH"
		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
//Então, ele vai pegar o parâmetro login e colocar os % e enviar para o parametro que foi preparado, para evitar o sql injection, vai ser a nossa classe que irá inserir as aspas simples.
			':SEARCH'=>"%".$login."%"

			));
	}

//AQUI VAMOS FAZER UM MÉTODO PARA OBTER OS DADOS DO USUÁRIO AUTENTICADO.
//Nós vamos ter que passar o login e a senha para o sistema autenticar, e ai ele vai carregar os dados do usuário
	//Aqui não pode ser estático.
	//Esse método irá receber o login e a senha
	public function login($login, $password){
		
		$sql = new Sql();

//Dentro do array nós vamos ter os parâmetros ou os PARAMETERS que a gente colocou dentro da classe Sql
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(":LOGIN"=>$login, ":PASSWORD"=>$password));

//Se trouxer um usuário de fato, ele entra no IF e executa os setters
//Se não trouxer um usuário, ele cai no else
		if (count($results)>0){

			//Quando obtemos o registro, nós vamos chamar o mpetod setData, passando o results com índex 0
			//Crio uma variável para pegar os resultados da linha 0
			$this->setData($results[0]);
			
		
		} else {
			throw new Exception("Login e/ou Senha Inválido(s).");
		}

	}
//FUNÇÃO PARA SETAR OS DADOS - ELA RECEBE OS DADOS DO USUÁRIO
	//Para não ficar repetindo essas linhas de código dentro dos métodos, estamos criando esse método, para simplificar
//O setData vai receber o $data
	public function setData($data){

		$this->setIdusuario($data['idusuario']);
		$this->setDeslogin($data['deslogin']);
		$this->setDessenha($data['dessenha']);
		$this->setDtcadastro(new DateTime($data['dtcadastro']));

	}

//AQUI VAMOS FAZER UM MÉTODO PARA INSERIR UM DADO NO BANCO DE DADOS - O MÉTODO INSERT
	public function insert(){
		$sql = new Sql();

//Vamos fazer um select. O select vai trazer um resultado, por isso a variável results
	//Aqui será criado uma procedure dentro do mysql. sp (storage procedure) usuarios(usuarios) insert (inserir)
		//Ai vamos passar dois parâmetros: o login e a senha, pq o id ele vai gerar automático e a data é o padrão do sistema.
		//Essa procedure vai ter que ser criada dentro do banco de dados, mais detalhes no bloco de notas desta pasta.
		$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
			//Aqui especificamos da onde vem cada parâmetro
			//O LOGIN vem do getDeslogin
			':LOGIN'=>$this->getDeslogin(),
			':PASSWORD'=>$this->getDessenha()
//Pq estamos fazendo com o SELECT? Pq n final ela vai executar uma função que nos retorna com o ID gerado na tabela. Então, nós conseguimos trazer esses dados e colocar no nosso objeto.
			));
		if (count($results) > 0 ){
			//Quando obtemos o registro, nós vamos chamar o mpetod setData, passando o results com índex 0
			//Crio uma variável para pegar os resultados da linha 0
			$this->setData($results[0]);
		}

	}

//VAMOS INSERIR INFORMAÇÕES NO BANCO DE DADOS VIA MÉTODO CONSTRUTOR
	//Estamos passando igualando o login e senha com "" para que não se torne obrigatório o login e senha a toda vez que o OBJETO usuario for instanciadao, pois se não houver login e senha, ele vai alimentar com um campo vazio 
	public function __construct($login = "", $password = ""){
		//Aqui vou chamar o setDeslogin e passar o $login e o mesmo para a senha.
		$this->setDeslogin($login);
		$this->setDessenha($password);

	}

//AQUI VAMOS CRIAR UM MÉTODO PARA UPDATE - ATUALIZAR
	//Vamos passar como parametro o $login e $password, pois só são esses campos que quero alterar. 
	public function update($login, $password){
//Ele joga na memória, dentro dos atributos, em cima da classe, pega dos atributos e coloca dentro da query
		$this->setDeslogin($login);
		$this->setDessenha($password);

		$sql = new Sql();
//Aqui nés vamos fazer direto o Query, para executar direto no banco de dados.
		//Vamos passar os parâmetros via array
		$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
			':LOGIN'=>$this->getDeslogin(),
			':PASSWORD'=>$this->getDessenha(),
			':ID'=>$this->getIdusuario()
			));

	}



//ATÉ AGORA NÓS SÓ CARREGAMOS OS DADOS DO BANCO PARA O OBJETO.
//Agora nós queremos vizualizar. Para isso, nós vamos usar um método mágico chamado tostring, que ao inves de mostrar a estrutura do objeto, ele executa o que tem dentro do método chamado __tostring.
//Então, vamos escrever um método __tostring e vamos dizer para ele executar um json por exemplo
	public function __toString(){

		return json_encode(array(
			//Nós usamos os setters para alimentar. Agora vamos usar os getters para trazer a informação.
			"idusuario"=>$this->getIdusuario(),
			"deslogin"=>$this->getDeslogin(),
			"dessenha"=>$this->getDessenha(),
			//Aqui vamos inserir um format, para mostratr a data da forma como eu quero
			"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
			));
	}

}



?>