<?php

/*
 * Create.class [ Consultas ] 
 * Classe responsavel pora realizar consultas no banco de dados.
 */

/**
 * @copyright (c) 2015, LDW soluções para web
 *
 * @author Lucas oliveira 
 */
class Read{
    
       private $Select;
       private $Places;
       private $Result;
       
       /** @var PDOStatement **/
       private $Read;
       
       /** @var PDO **/
       private $Conn;
       
       /**
        * <b>ExeRead</b> Execulta consultas simplificado no banco de dados ultilizando prepared statements.
        * Basta informa o nome da tabela e um array atribuitivo como o nome da coluna e o valor;
        * 
        * @param string $Tabela = Informe o nome da tabela no Banco;
        * @param array $termos = os termos a sser consultado. "WHERE campo2=:valor2 and campo1>=:valor1 LIMIT :limit";
        * @param string $ParseString = Informe os valores rquisitados pelos termos definidos . "valor2=valor&valor1=valor&limit=valor"
        */
       
       public function ExeRead($Tabela,$termos = NULL , $ParseString = NULL) {
           if(!empty($ParseString)):
               parse_str($ParseString,  $this->Places);         
           endif;
           
           $this->Select = "SELECT * FROM {$Tabela} {$termos}";
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
     * @return Retorn o resultado da query;
     */
    public function getAll() {
        return $this->Result;
    }

    /**
     * 
     * @return Retorn o resultado da query;
     */
    public function getUnique() {
        return (!empty($this->Result) ? $this->Result[0] : false);
    }
        /**
        * 
        * @return retorna o numero de linhas afetadas pela execução da query
        */
       public function getRowCount() {
           return $this->Read->rowCount();
           
       }
       /**
        * Função responsavel por realizar uma query manualmente 
        * Bastando informa a query  e no $parseString o valores a ser passados 
        * @param type $Query  informe aqui as query completa da busca a set feita .Exemplo: ("SELECT * FROM tabela");
        * @param type $ParseString informe aqui os valores a ser consultado . Exemplo : 
        */
       public function FullRead($Query,$ParseString = null) {
           $this->Select = (string) $Query;
           
            if(!empty($ParseString)):
               parse_str($ParseString,  $this->Places);
         
           endif;
           $this->Execute();
       }
        /**
       * 
       * @param type $ParseString  Pega separadamemte uma o valor a ser consultado e apagado 
       */
       public function setPlaces($ParseString) {
           parse_str($ParseString,  $this->Places);
           $this->Execute();
       }
       
       /** 
        * ****************************************
        * *********** PRIVATE METODOS ************
        * ****************************************
        */
        /**
        * function Connect res ponsavem por realizar a conexão atribuir valores para a query
        */
       private function Connect() {
           $this->Conn = Conn::getConn();
           $this->Read = $this->Conn->prepare($this->Select);
           $this->Read->setFetchMode(PDO::FETCH_ASSOC);
           
           
       }
       /**
        *  Cria os parametros requisitados pela query para ser executada de maneira correta
        * 
        */
       private function getSyntax() {
           if($this->Places):
               foreach($this->Places as $vinculo => $valor):
                    if($vinculo == 'limit' || $vinculo == 'offset'):
                       $valor = (int) $valor; 
                    endif;  
                    $this->Read->bindValue(":{$vinculo}", $valor,(is_int($valor)? PDO::PARAM_INT : PDO::PARAM_STR));
               endforeach;
           endif;
           
         
       }
        /**
        * Função responssavel por Execultar a query e trazer os resultados da excução; 
        */
       private function Execute() {
           $this->Connect();
           try{
               $this->getSyntax();
               $this->Read->execute();
               $this->Result = $this->Read->fetchAll();
               
           } catch (PDOException $e) {
               echo $this->Result= null;
                PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
           }
           
        
           
       }
       
       
       
}
