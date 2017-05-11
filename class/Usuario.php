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
			//Crio uma variável para pegar os resultados da linha 0
			$row = $results[0];

			//Vou pegar os dados que me voltou via associativo e mandar para os setters. 
			$this->setIdusuario($row['idusuario']);
			$this->setDeslogin($row['deslogin']);
			$this->setDessenha($row['dessenha']);
			//Para o php já colocar no padrão data e hora, vamos instanciar a classe nativa DateTime.
			$this->setDtcadastro(new DateTime($row['dtcadastro']));
		}
		
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