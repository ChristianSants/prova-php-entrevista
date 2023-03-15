<?php

    class User extends Connection{
        private $id;
        private $name;
        private $email;
        private $colors;

        public function __construct($id = null, $name = null, $email = null){
            $this->id = $id;
            $this->name = $name;
            $this->email = $email;
            $this->colors = [];
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

        public function getEmail(){
            return $this->email;
        }

        public function setEmail($email){
            $this->email = $email;
        }

        public function getColors(){
            return $this->colors;
        }

        public function setColors($arrayColors){
            $this->colors = $arrayColors;
        }

        public function addColor($color){
            array_push($this->colors, $color);
        }

        /** -------------------------------------------------------- DAO -------------------------------------------------------- */
        public function insert(){
            if($this->validaDados()){
                $sql = "
                    INSERT INTO users(name, email) 
                    VALUES(?, ?)
                ";

                try{
                    $pdo = $this->getConexao();
                    $prepare = $pdo->prepare($sql);

                    $pdo->beginTransaction();
                    $prepare->execute(array($this->name, $this->email));
                    $result = $pdo->lastInsertId();
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
                    UPDATE users 
                    SET name = ?,
                        email = ?
                    WHERE id = ?
                ";

                try{
                    $pdo =  $this->getConexao();
                    $prepare = $pdo->prepare($sql); 

                    $pdo->beginTransaction();        
                    $result = $prepare->execute(array($this->name, $this->email, $this->id));
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
                DELETE FROM users
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
                FROM users
            ";

            $pdo = $this->getConexao();
            $prepare = $pdo->prepare($sql);
            $prepare->execute();
            
            $array = [];
            $arrayResultado = $prepare->fetchAll();

            if(!empty($arrayResultado)){
                $objColor = new Color();
                $arrayColorsUser = $objColor->listByUserId();

                foreach($arrayResultado as $valor){
                    $objRetorno = new User($valor['id'], $valor['name'], $valor['email']);

                    if(!empty($arrayColorsUser[$valor['id']])){ // adicionando cores
                        $objRetorno->setColors($arrayColorsUser[$valor['id']]);
                    }

                    $array[$valor['id']] = $objRetorno;
                }
            }

            return $array;

        }

        public function load(){
            $sql = "
                SELECT *
                FROM users u 
                WHERE id = ?
            ";

            $prepare = $this->getConexao()->prepare($sql);
            $prepare->bindValue(1, $this->id);        

            $prepare->execute();
            $resultado = $prepare->fetch();

            if(!empty($resultado)){
                $objColor = new Color();

                $this->name = $resultado['name'];
                $this->email = $resultado['email'];
                $this->colors = $objColor->findByUserId($this->id);

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
                    echo '<script>alert("Digite o nome do Usuário!")</script>';
                    exit();
                }
            }

            // valor
            if($validacao){
                if(!empty($this->email)){
                    $validacao = true;
                }else{
                    $validacao = false;
                    echo '<script>alert("Digite o email corretamente!")</script>';
                    exit();
                }
            }

            return $validacao;
        }

    }
?>