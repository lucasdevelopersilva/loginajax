<?php

/*
 * Conn.class [ Conexão ] 
 * Classe abstrata de conexão. padrão Singleton.
 * Retorna um objeto PDO pelo metodo estatico getConn();
 */

/**
 * @copyright (c) 2015, LDW soluções para web
 *
 * @author Lucas oliveira 
 */
class Conn {

    //put your code here
    private static $Host = HOST;
    private static $User = USER;
    private static $Pass = PASS;
    private static $Dbsa = DBSA;
    //** @var PDO */
    private static $Connectar = null;

    /**
     * Conecta com o banco de dados com o pattern singleton.
     * Retorna um objeto PDO!
     */
    private static function Conectar() {
        try {

            if (self::$Connectar == null):
                $dsn = 'mysql:host=' . self::$Host . ';dbname=' . self::$Dbsa;
                $options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8', PDO::ATTR_PERSISTENT => false];
                self::$Connectar = new PDO($dsn, self::$User, self::$Pass, $options);
                self::$Connectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            endif;
        } catch (PDOException $exc) {
            PHPErro($exc->getCode(), $exc->getMessage(), $exc->getFile(), $exc->getLine());
            die();
        }

        return self::$Connectar;
    }

    /** retorna um objeto PDO singleton Pattern, */
    public static function getConn() {
        return self::Conectar();
    }

    /**
     * Construtor do tipo protegido previne que uma nova instância da
     * Classe seja criada atravês do operador `new` de fora dessa classe.
     */
    private function __construct() {
        
    }

    /**
     * Método clone do tipo privado previne a clonagem dessa instância
     * da classe
     *
     * @return void
     */
    private function __clone() {
        
    }

    /**
     * Método unserialize do tipo privado para previnir que desserialização
     * da instância dessa classe.
     *
     * @return void
     */
    private function __wakeup() {
        
    }

}
