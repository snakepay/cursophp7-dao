<?php

class Usuario {
    
    private $idusuarios;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;
    
    public function getIdusuarios() {
        return $this->idusuarios;
    }

    public function getDeslogin() {
        return $this->deslogin;
    }

    public function getDessenha() {
        return $this->dessenha;
    }

    public function getDtcadastro() {
        return $this->dtcadastro;
    }

    public function setIdusuarios($idusuarios) {
        $this->idusuarios = $idusuarios;
    }

    public function setDeslogin($deslogin) {
        $this->deslogin = $deslogin;
    }

    public function setDessenha($dessenha) {
        $this->dessenha = $dessenha;
    }

    public function setDtcadastro($dtcadastro) {
        $this->dtcadastro = $dtcadastro;
    }
    
    public function loadById ( $id ){
        
        $sql = new Sql();
        
        $result = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
            ":ID"=>$id                
        ));
        
        if( isset( $result[0] ) ) {
            $this->setData($result[0]);
        }
        
    }
    
    public static function getList() {
        
        $sql = new Sql();
        
        return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
        
    }
    
    public static function search( $login ) {
        
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
            ':SEARCH' => "%" . $login . "%"
        ));
        
    }

    public function login ( $login, $senha ) {
        
        $sql = new Sql();
        
        $result = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :SENHA", array(
            ":LOGIN" => $login,
            ":SENHA" => $senha
        ));
        
        if( isset( $result[0] ) ) {            
            $this->setData($result[0]);
        } else {
            throw new Exception("Login ou senha inválidos");
        }
        
    }   
    
    public function setData( $data ) {
        
        $this->setIdusuarios ( $data['idusuario'] );
        $this->setDeslogin   ( $data['deslogin'] );
        $this->setDessenha   ( $data['dessenha'] );
        $this->setDtcadastro ( new DateTime( $data['dtcadastro'] ) );
        
    }


    public function insert() {
        
        $sql = new Sql();
        
        $results = $sql->select("CALL sp_usuarios_insert( :LOGIN, :SENHA )", array(
            ":LOGIN" => $this->getDeslogin(),
            ":SENHA" => $this->getDessenha()
        ));
        
        if( isset( $results[0] ) ) {           
            $this->setData( $results[0] );
        }
    }
    
    public function update( $login, $senha) {
        
        $this->setDeslogin($login);
        $this->setDessenha($senha);
        
        $sql = new Sql();
        $sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :SENHA WHERE idusuario = :ID", array(
            ":LOGIN" => $this->getDeslogin(),
            ":SENHA" => $this->getDessenha(),
            ":ID"    => $this->getIdusuarios()
        ));
        
    }

    public function __construct( $login = "", $senha = "" ) {        
        $this->setDeslogin($login);
        $this->setDessenha($senha);        
    }

        public function __toString() {
        
        return json_encode([
            "idusuario"  => $this->getIdusuarios(),
            "deslogin"   => $this->getDeslogin(),
            "dessenha"   => $this->getDessenha(),
            "dtcadastro" => $this->getDtcadastro()->format("d/m/Y H:i:s")
            ]);
        
    }
    
}

?>