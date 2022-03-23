<?php

/*
 * Create.class [ Conexão ] 
 * Classe responsavel pora realizar cadastros no banco de dados.
 */

/**
 * @copyright (c) 2015, LDW soluções para web
 *
 * @author Lucas oliveira 
 */
class Create{
    
       private $Tabela;
       private $Dados;
       private $Result;
       
       /** @var PDOStatement **/
       private $Create;
       
       /** @var PDO **/
       private $Conn;
       
       /**
        * <b>ExeCCreate</b> Execulta um cadastro simplificado no banco de dados ultilizando prepared statements.
        * Basta informa o nome da tabela e um array atribuitivo como o nome da coluna e o valor;
        * 
        * @param string $Tabela = Informe o nome da tabela no Banco;
        * @param array $Dados = Informe um array atribuitivo. Exemplo [nome da columa =>valor];
        */
       
       public function ExeCreate($Tabela,array $Dados) {
           $this->Tabela = (string) $Tabela;
           $this->Dados  = $Dados;
           
           $this->getSyntax();
           $this->Execute();
       }
       /**
        * 
        * @return Retorn o resultado da query;
        */
       public function getResult() {
           return $this->Result;
           
       }
       
       /** 
        * ****************************************
        * *********** PRIVATE METODOS ************
        * ****************************************
        */
       private function Connect() {
           $this->Conn = Conn::getConn();
           $this->Create = $this->Conn->prepare($this->Create);
           
       }
       /**
        *  Cria os parametros requisitados pela query para ser executada de maneira correta
        * 
        */
        /**
        * function Connect res ponsavem por realizar a conecção atribuir valores para a query
        */
       private function getSyntax() {
           $Colunas = implode(',', array_keys($this->Dados));
           $Values = ':'. implode(', :', array_keys($this->Dados));
           $this->Create = "INSERT INTO {$this->Tabela} ({$Colunas}) VALUES ({$Values})";
           
           
       }
        /**
        * Função responssavel por Execultar a query e trazer os resultados da excução; 
        */
       private function Execute() {
           $this->Connect();
           try{
               $this->Create->execute($this->Dados);
               $this->Result = $this->Conn->lastInsertId();
           } catch (PDOException $e) {
               $this->Result = null;
               PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());

           }
           
           
       }
       
       
       
}
