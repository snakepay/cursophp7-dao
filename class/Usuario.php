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
            $row = $result[0];            
            $this->setIdusuarios ( $row['idusuario'] );
            $this->setDeslogin   ( $row['deslogin'] );
            $this->setDessenha   ( $row['dessenha'] );
            $this->setDtcadastro ( new DateTime( $row['dtcadastro'] ) );
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
            $row = $result[0];            
            $this->setIdusuarios ( $row['idusuario'] );
            $this->setDeslogin   ( $row['deslogin'] );
            $this->setDessenha   ( $row['dessenha'] );
            $this->setDtcadastro ( new DateTime( $row['dtcadastro'] ) );
        } else {
            throw new Exception("Login ou senha inválidos");
        }
        
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