<?php

require_once("./config.php");
/*
$sql = new Sql();

$usuarios = $sql->select("SELECT * FROM tb_usuarios");

echo json_encode( $usuarios );
//var_dump($usuarios);
*/

/* Carrega um usuario
$root = new Usuario();
$root->loadById(4);
echo $root;
 */

/* Carrega uma lista de usuarios 
$lista = Usuario::getList();
echo json_encode($lista);
 */

/* Carrega uma lista de usuarios pelo login 
$search = Usuario::search("o");
echo json_encode($search);
 */

/* Carrega um usuario usando login e senha */
$usuario = new Usuario();
$usuario->login("josé", "asdf");
echo $usuario;

?>
