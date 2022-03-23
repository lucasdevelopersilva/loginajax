<?php


//**Configurações do sites##############
date_default_timezone_set("America/Recife");
setlocale(LC_ALL, 'pt_BR');        
/**
 * DATABASE
 */ 
define("HOST", "localhost");
define("USER", "root");
define("PASS", ""); 
define("DBSA", "testephp");

function FullAutoLoad($arquivo) {
    $cDir = ['Conn', 'Helpers', 'Models', 'system', 'Checkout', "Controller"];
    $iDir = null;
    foreach ($cDir as $dirName):
        if (!$iDir && file_exists(__DIR__ . "//{$dirName}//{$arquivo}.class.php") && !is_dir(__DIR__ . "//{$dirName}//{$arquivo}.class.php")):
            require_once (__DIR__ . "//{$dirName}//{$arquivo}.class.php");
            $iDir = true;
        elseif (!$iDir && file_exists(__DIR__ . "//{$dirName}//{$arquivo}.php") && !is_dir(__DIR__ . "//{$dirName}//{$arquivo}.php")):
            require_once (__DIR__ . "//{$dirName}//{$arquivo}.php");
            $iDir = true;
        endif;
    endforeach;
    
    if (!$iDir):
        trigger_error("Arquivo " . __DIR__ . "\\{$dirName}\\{$arquivo}.class.php não encontrado", E_USER_ERROR);
        die;
    endif;
}   

spl_autoload_register("FullAutoLoad");
 
//Tratamento de Erros  ###########
//Css costantes :: Menssage de Erros  ###

define('LWC_ACCEPT', 'callout-success');
define('LWC_INFO', 'callout-info');
define('LWC_WANI', 'callout-warning');
define('LWC_DANGER', 'callout-danger');
//define os alertas da function LDWErro
define("LDW_ACCEPT", "alert-success");
define("LDW_INFOR", "alert-info");
define("LDW_ALERT", "alert-warning");
define("LDW_ERROR", "alert-danger");

/**
 * Exibe alertas sem o fechamanto do mesmo atraves do botão fecha
 * @param type $ErrMsg Mensagem de erro que será exibida
 * @param type $ErrNo Tipo de erro para a exibição da mensagem, Pode ser callout-success, callout-danger, callout-info, callout-warning
 */
function LDWCallOut($ErrMsg, $ErrNo) {
    $CssClass = $ErrNo;
    echo "<div class='callout " . $CssClass . "'>";
    switch ($CssClass):
        case 'callout-success' : $type = "fa-check";
            $TypeErro = "Sucesso !";
            break;
        case 'callout-warning' : $type = "fa-warning";
            $TypeErro = "Alerta !";
            break;
        case 'callout-info' : $type = "fa-info";
            $TypeErro = "Informação !";
            break;
        case 'callout-danger' : $type = "fa-ban";
            $TypeErro = "Erro !";
            break;
    endswitch;
    echo '<h4><i class="icon fa ' . $type . '"></i> ';
    echo $TypeErro . ' </h4>' . $ErrMsg . '</div>';
}

/**
 * LDWErro é para exbir mensagems de alertas com o botão facha para não exibir a mensage
 * @param type $ErrMsg Mensagem de erro que será exibida
 * @param type $ErrNo Tipo de erro para exibição pode ser do tipo alert-success, alert-danger, alert-info, alert-warning
 * @param type $ErrDie se form true causa um die() e a execução do php para depois da mensage. por padão e false;
 */
function LDWErro($ErrMsg, $ErrNo, $ErrDie = null) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? LDW_INFOR : ($ErrNo == E_USER_WARNING ? LDW_ALERT : ($ErrNo == E_USER_ERROR ? LDW_ERROR : $ErrNo)));
    echo '<div class="alert ' . $CssClass . ' alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    switch ($CssClass):
        case 'alert-success' : $type = "fa-check";
            $TypeErro = "Sucesso !";
            break;
        case 'alert-warning' : $type = "fa-warning";
            $TypeErro = "Alerta !";
            break;
        case 'alert-info' : $type = "fa-info";
            $TypeErro = "Informação !";
            break;
        case 'alert-danger' : $type = "fa-ban";
            $TypeErro = "Erro !";
            break;
    endswitch;
    echo '<h4><i class="icon fa ' . $type . '"></i>';
    echo $TypeErro . '</h4>' . $ErrMsg . '</div>';
    if ($ErrDie):
        die;
    endif;
}

/**
 * Despara um catilho de erro do php para uma alerta personalozado com mensamge mais claras  de se exibir
 * @param type $ErrNo Tipo de erro a ser informado, pode ser 
 * @param type $ErrMsg Mensagem para exibição 
 * @param type $ErrFile arquivo onde esta o erro 
 * @param type $ErrLine Linha onde esta o erro no php
 */
function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {
        
    $CssClass = ($ErrNo == E_USER_NOTICE ? "alert-info" : ($ErrNo == E_USER_WARNING ? "alert-warning" : ($ErrNo == E_USER_ERROR ? "alert-error" : "alert-info")));
    echo "<p class='alert " . $CssClass . "'>";
    echo "<b>Erro na linha: {$ErrLine} :: </b> {$ErrMsg} <br>";
    echo "<small>{$ErrFile}</small>";
    if ($ErrNo == E_USER_ERROR):
        die();
    endif;
}

set_error_handler('PHPErro');


