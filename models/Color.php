<?php

    class Color extends Connection{
        private $id;
        private $name;

        public function __construct($id = null, $name = null){
            $this->id = $id;
            $this->name = $name;
        }

        //Getters e setter
        public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
        }

        public function getName(){
            return $this->name;
        }

        public function setName($name){
            $this->name = $name;
        }

        /** -------------------------------------------------------- DAO -------------------------------------------------------- */
        public function insert(){
            if($this->validaDados()){
                $sql = "
                    INSERT INTO colors(name) 
                    VALUES(?)
                ";

                try{
                    $pdo = $this->getConexao();
                    $prepare = $pdo->prepare($sql);

                    $pdo->beginTransaction();
                    $result = $prepare->execute(array($this->name));
                    $pdo->commit();

                    return $result;

                }catch(Exception $e){
                    $pdo->rollBack();
                    return ['msg' => "Linha ".__LINE__." ".__FILE__.": ".$e->__toString()];
                    die();
                }
            } else{
                return 0;
            }
        }

        public function update(){
            if($this->validaDados()){
                $sql = "
                    UPDATE colors 
                    SET name = ?
                    WHERE id = ?
                ";

                try{
                    $pdo =  $this->getConexao();
                    $prepare = $pdo->prepare($sql); 

                    $pdo->beginTransaction();        
                    $result = $prepare->execute(array($this->name, $this->id));
                    $pdo->commit();

                    return $result;

                }catch(Exception $e){
                    $pdo->rollBack();
                    echo "Linha ".__LINE__." ".__FILE__.": ".$e->__toString();            
                    die();
                }
            } else{
                return 0;
            } 
        }

        public function delete(){
            $sql = "
                DELETE FROM colors
                WHERE id = ?
            ";

            try{
                $pdo =  $this->getConexao();
                $prepare = $pdo->prepare($sql); 

                $prepare->bindValue(1, $this->id);
            
                $pdo->beginTransaction();        
                $result = $prepare->execute();
                $pdo->commit();

                return $result;
            }catch(Exception $e){
                $pdo->rollBack();
                echo "Linha ".__LINE__." ".__FILE__.": ".$e->__toString();            
                die();
            }
        }

        public function list(){
            $sql = "
                SELECT *
                FROM colors
            ";

            $pdo = $this->getConexao();
            $prepare = $pdo->prepare($sql);
            $prepare->execute();
            
            $array = [];
            $arrayResultado = $prepare->fetchAll();

            if(!empty($arrayResultado)){
                foreach($arrayResultado as $valor){
                    $objRetorno = new Color($valor['id'], $valor['name']);
                    $array[$valor['id']] = $objRetorno;
                }
            }

            return $array;

        }

        public function load(){
            $sql = "
                SELECT *
                FROM colors
                WHERE id = ?
            ";

            $prepare = $this->getConexao()->prepare($sql);
            $prepare->bindValue(1, $this->id);        

            $prepare->execute();
            $resultado = $prepare->fetch();

            if(!empty($resultado)){
                $this->name = $resultado['name'];

                return true;
            }

            return false;
        }

        private function validaDados(){
            $validacao = true;
            
            // ano
            if($validacao){
                if(!empty($this->name)){
                    $validacao = true;
                }else{
                    $validacao = false;
                    echo '<script>alert("Digite o nome da cor!")</script>';
                    exit();
                }
            }

            return $validacao;
        }

        /** SQL Especfício */
        public function listByUserId(){
            $sql = "
                SELECT  uc.user_id,
                        c.*
                FROM colors c
                INNER JOIN user_colors uc
                    ON uc.color_id = c.id
            ";

            $pdo = $this->getConexao();
            $prepare = $pdo->prepare($sql);
            $prepare->execute();
            
            $array = [];
            $arrayResultado = $prepare->fetchAll();

            if(!empty($arrayResultado)){
                foreach($arrayResultado as $valor){
                    $objRetorno = new Color($valor['id'], $valor['name']);
                    $array[$valor['user_id']][$valor['id']] = $objRetorno;
                }
            }

            return $array;
        }

        public function findByUserId($userId){
            $sql = "
                SELECT c.*
                FROM colors c
                INNER JOIN user_colors uc
                    ON uc.color_id = c.id
                WHERE uc.user_id = ?
            ";

            $pdo = $this->getConexao();
            $prepare = $pdo->prepare($sql);
            $prepare->execute(array($userId));
            
            $array = [];
            $arrayResultado = $prepare->fetchAll();

            if(!empty($arrayResultado)){
                foreach($arrayResultado as $valor){
                    $objRetorno = new Color($valor['id'], $valor['name']);
                    $array[$valor['id']] = $objRetorno;
                }
            }

            return $array;
        }

    }
?>