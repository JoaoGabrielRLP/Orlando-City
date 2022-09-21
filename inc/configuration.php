<?php

class Sql {
    /*Variável pública responsável por fazer a conexão do banco de dados*/
    public $conn;

    /*Método mágico do php que irá inicializar algo*/
    public function __construct(){
        return $this->conn = mysqli_connect("localhost", "root", "", "hcode_shop");
        /*Assim que a conexão funcionar, vai retornar um objeto, que é colocada na variável conn que está dentro do nosso objeto*/
    }

    public function query($string_query){
        /*Classe responsável por armazenar os comandos query do banco*/
        return mysqli_query($this->conn, $string_query); /*Ao chamar esta classe estamos estabelecendo uma conexão com o banco de dados e abrindo espaço para usarmos uma query de banco de dados, ou seja:Passo1 - conecte ao banco. Passo2 - realize uma query*/
    }

    /*Método mágico do php que irá finalizar algo*/
    public function __destruct(){
        /**Método que fecha a conexão msqli tendo como parâmetro a variável do objeto que definimos acima */
        mysqli_close($this->conn);
    }



}




?>