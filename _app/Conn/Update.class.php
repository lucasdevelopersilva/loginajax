<?php

/*
 * Update.class [ Consultas ] 
 * Classe responsavel pora realizar atualizações no banco de dados.
 */

/**
 * @copyright (c) 2015, LDW soluções para web
 *
 * @author Lucas oliveira 
 */
class Update{
    
       private $Tabela;
       private $Dados;
       private $Termos;
       private $Places;
       private $Result;
       
       /** @var PDOStatement **/
       private $Update;
       
       /** @var PDO **/
       private $Conn;
       
       /**
        * <b>ExeUpdate</b> Execulta consultas simplificado no banco de dados ultilizando prepared statements.
        * Basta informa o nome da tabela e um array atribuitivo como o nome da coluna e o valor;
        * 
        * @param string $Tabela = Informe o nome da tabela no Banco;
        * @param array $Dados = Informe um array atribuitivo. Exemplo [nome da columa =>valor];
        */
       
       public function ExeUpdate($Tabela,array $Dados ,$Termos, $ParseString) {
           $this->Tabela = (string)$Tabela;
           $this->Dados = $Dados;
           $this->Termos = $Termos;
           
           parse_str($ParseString,  $this->Places);
           $this->getSyntax();
           $this->Execute(); 
          
      
       }
       
       public function FullUpdate($query) { 
         $this->Update = $query;
         $this->Connect();
         try{                
           $this->Update->execute();
           $this->Result = true;
         } catch (PDOException $e) {
           echo $this->Result= null;
           PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());

         }         

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
           return $this->Update->rowCount();
           
       }
      /**
       * 
       * @param type $ParseString  Pega separadamemte uma o valor a ser consultado
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
       private function Connect() {
           $this->Conn = Conn::getConn();
           $this->Update = $this->Conn->prepare($this->Update);
           
           
       }
       /**
        *  Cria os parametros requisitados pela query para ser executada de maneira correta
        * 
        */
        /**
        * function Connect res ponsavem por realizar a conecção atribuir valores para a query
        */
       private function getSyntax() {
               foreach($this->Dados as $key => $valor):
                   
                       $Places[] = $key .'=:'.$key; 
                   
               endforeach;
                    $Places = implode(',', $Places);
                    $this->Update = "UPDATE {$this->Tabela} SET {$Places} {$this->Termos}";
           
         
       }
        /**
        * Função responssavel por Execultar a query e trazer os resultados da excução; 
        */
       private function Execute() {
           $this->Connect();
           try{
                
               $this->Update->execute(array_merge($this->Dados,  $this->Places));
               $this->Result = true;
           } catch (PDOException $e) {
               echo $this->Result= null;
                PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
               
           }
           
        
           
       }
       
       
       
}
