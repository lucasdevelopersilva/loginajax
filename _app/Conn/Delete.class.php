<?php

/*
 * Delete.class [ Consultas ] 
 * Classe responsavel por a apagar resultados no  no banco de dados.
 */

/**
 * @copyright (c) 2015, LDW soluções para web
 *
 * @author Lucas oliveira 
 */
class Delete{
    
       private $Tabela;
       private $Termos;
       private $Places;
       private $Result;
       
       /** @var PDOStatement **/
       private $Delete;
       
       /** @var PDO **/
       private $Conn;
       
       /**
        * <b>ExeDelete</b> Executa uma operação pra excluir o registro desejado no banco de dados
        * bastando apenas informar o id do registro desejano em 
        * 
        * @param string $Tabela = Informe o nome da tabela no Banco;
        * @param array $Dados = Informe um WHERE nome da coluna=:identificador'
        * @param   $ParseString É informado um conjndo de dados para ser usado na verificaão do registro a ser apagado
        */
       
       public function ExeDelete($Tabela ,$Termos, $ParseString) {
           $this->Tabela = $Tabela;
           $this->Termos = $Termos;
           
           parse_str($ParseString,  $this->Places);
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
        * 
        * @return retorna o numero de linhas afetadas pela execução da query
        */
       public function getRowCount() {
           return $this->Delete->rowCount();
           
       }
      /**
       * 
       * @param type $ParseString  Pega separadamemte uma o valor a ser consultado e apagado 
       */
       public function setPlaces($ParseString) {
           parse_str($ParseString,  $this->Places);
           $this->getSyntax();
           $this->Execute();
       }
       
       /** 
        * ****************************************
        * *********** PRIVATE METODOS ************
        * ****************************************
        */
       /**
        * function Connect res ponsavem por realizar a conecção atribuir valores para a query
        */
       private function Connect() {
           $this->Conn = Conn::getConn();
           $this->Delete = $this->Conn->prepare($this->Delete);
           
           
       }
       /**
        *  Cria os parametros requisitados pela query para ser executada de maneira correta
        * 
        */
       private function getSyntax() {
           $this->Delete ="DELETE FROM {$this->Tabela} {$this->Termos}";
        
       }
       /**
        * Função responssavel por Execultar a query e trazer os resultados da excução; 
        */
       private function Execute() {
           $this->Connect();
           try{
                
               $this->Delete->execute($this->Places);
               $this->Result = true;
           } catch (PDOException $e) {
               echo $this->Result= null;
                PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
               
           }
           
        
           
       }
       
       
       
}
