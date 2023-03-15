<?php

    class UserColor extends Connection{
        private $user_id;
        private $color_id;

        public function __construct($user_id = null, $color_id = null){
            $this->user_id = $user_id;
            $this->color_id = $color_id;
        }

        //Getters e setter
        public function getUserId(){
            return $this->user_id;
        }

        public function setUserId($user_id){
            $this->user_id = $user_id;
        }

        public function getColorId(){
            return $this->color_id;
        }

        public function setColorId($color_id){
            $this->color_id = $color_id;
        }

        /** -------------------------------------------------------- DAO -------------------------------------------------------- */
        public function insert(){
            $sql = "
                INSERT INTO user_colors(user_id, color_id) 
                VALUES(?, ?)
            ";

            try{
                $pdo = $this->getConexao();
                $prepare = $pdo->prepare($sql);

                $pdo->beginTransaction();
                $result = $prepare->execute(array($this->user_id, $this->color_id));
                $pdo->commit();

                return $result;

            }catch(Exception $e){
                $pdo->rollBack();
                return ['msg' => "Linha ".__LINE__." ".__FILE__.": ".$e->__toString()];
                die();
            }
        }

        public function delete(){
            $sql = "
                DELETE FROM user_colors
                WHERE user_id = ? AND color_id = ?
            ";

            try{
                $pdo =  $this->getConexao();
                $prepare = $pdo->prepare($sql); 

                $prepare->bindValue(1, $this->user_id);
                $prepare->bindValue(2, $this->color_id);
            
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
                FROM user_colors
            ";

            $pdo = $this->getConexao();
            $prepare = $pdo->prepare($sql);
            $prepare->execute();
            
            $array = [];
            $arrayResultado = $prepare->fetchAll();

            if(!empty($arrayResultado)){
                foreach($arrayResultado as $valor){
                    $objRetorno = new UserColor($valor['user_id'], $valor['color_id']);
                    $array[] = $objRetorno;
                }
            }

            return $array;
        }

        public function deleteByUserId($userId){
            $sql = "
                DELETE FROM user_colors
                WHERE user_id = ? 
            ";

            try{
                $pdo =  $this->getConexao();
                $prepare = $pdo->prepare($sql);

                $prepare->bindValue(1, $userId);
            
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

    }
?>