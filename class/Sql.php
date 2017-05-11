<?php

//Lembrando que em uma classe, sempre usamos a primeira letra em maiúscula. Por convenção.

// Essa é uma classe que nos auxiliará a organizar o fluxo de informações que serão direcionados para e do banco

//Esta classe que iremos criar, ela vai extender de PDO, que é uma classe nativa do PHP
//Então, tudo que o PDO já faz, essa classe vai fazer também! BindinParam, execute, prepare....
class Sql extends PDO{

//Vamos deixar a conexão no escopo principal da classe
	private $conn;

//Quando eu construir esse objeto, fazer uma instancia da classe Sql, eu quero que ele conecte automaticamente no banco de dados. 
	//Para isso, eu vou fazer um método construtor:

	public function __construct(){

		//Vou colocar na minha variável/atributo "conn", as informações para a conexão ao banco de dados
		$this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");
//O nome do host, o nome do banco, usuário e senha, poderiam ter sido escrito na forma de parâmetros e passados pelo método construtor. E, quando eu chamasse a classe new Sql, eu já passaria esses parâmetros para ele conectar. ISSO NO SERIA BOM NO CASO DE TER 2 SERVIDORES, OU MAIS BANCO DE DADOS OU OUTROS USUÁRIOS.
	}

//Para cada parâmetro, nós precisamos fazer o bindParam para associar os valores adquiridos com a chave que se encontra no banco. Para tornar o código dinâmico, estamos criando um método só para fazer esse bindParam.
	//Ele precisa receber o meu statemet e os meus dados, os parameters que é um array por padrão
	private function setParams($statement, $parameters = array()){
		
		foreach ($parameters as $key => $value) {
			//Para cada parâmetro, nós precisamos fazer o bindParam para associar.
			//Como eu quero o código mais dinâmico, eu criei um novo método para fazer o set dos dados. O método abaixo. enão vou comentar esse código:
			//$statement->bindParam($key, $value);
		//E, aqui vai o setParam, que é o método que eu criei:
			$this->setParam($statement, $key, $value);
		}

	}

//Aqui vamos passar apenas um bindParam 
	//Nesse casa eu não preciso passar todos os dados, pois é apenas um. 
	//Então, eu posso receber direto a minha chave e o meu valor
	private function setParam($statement, $key, $value){

		$statement->bindParam($key, $value);
	}

//Aqui vamos prepara para executar parâmetros dentro do banco de dados:
//Vamos receber 2 parâmetros. A $rawQuery (que é o dado bruto, que receberá tratamento), e $params (que serão os dados), esse últim em forma de array. 
	public function query($rawQuery, $params = array()){

		//Aqui criamos o statement. Ela só funciona dentro desse método.
		//Vamos conectar, preparar o banco e passar o dado bruto.
		$stmt = $this->conn->prepare($rawQuery);

		//Aqui, vamos associar os parâmetros a esse comando
		//foreach ($params as $key => $value) {
			//Para cada parâmetro, nós precisamos fazer o bindParam para associar.
			//$stmt->bindParam($key, $value);
//Imagine que teremos outros métodos que também precisarão fazer isso daqui. Então, eu posso criar um outro método para que eu possa reutilizá-lo depois. Por isso criamos o método setParams.POR ISSO QUE ESSE FOREACH CÓDIGO ESTÁ COMENTADO. ELE FOI REDIRECIONADO PARA O MÉDODO ACIMA.

		//Depois de criar todos os métodos acima, agora ele reconhece o setParam, que vai fazer o set de cada parametro
		//Aqui eu passo o $stmt, que é o escopo deste método, e como segunda variável, $params 
		$this->setParams($stmt, $params);

		//Agora é só executar
		$stmt->execute();

		return $stmt;
//Esse método só faz a query, a execução da função lá no banco de dados.
//Podemos fazer um outro mpetodo apenas para fazer uma função específica, por exemplo o select....
		}

//VAMOS CRIAR UM MÉTODO SÓ PARA O SELECT:
		//Podemos passar os valores, como valore brutos($rawQuery) e os parâmetros como array
		public function select($rawQuery, $params = array()):array{
			//Agora para conectar, setar e executar uma função dentro do banco é só chamar o método query
			$stmt = $this->query($rawQuery, $params);

//Aqui, precisamos fazer o fetchAll, e para isso, precisamos o $stmt, pois o fetchAll está dentro dele 
			return $stmt->fetchAll(PDO::FETCH_ASSOC);


		}


}




?>