<?php

use Symfony\Component\Yaml\Yaml;

class DefaultModel{
    public $information;

    public function __construct(){
        $this->information = Yaml::parseFile(realpath("../src/Model/organizations.yaml"));
        #'C:/Users/Igor/alban_project/src/Model/organizations.yaml'
    }

    public function update_information_file(){
        $yaml = Yaml::dump($this->information);
        file_put_contents('C:/Users/Igor/alban_project/src/Model/organizations.yaml', $yaml);
    }

    public function delete($name, $user = false){
        $status = false;
        if($user){
            for($i = 0; $i < sizeof($this->information['organizations']); $i++){
                if($name == $this->information['organizations'][$i]['name']){
                    for($j = 0; $j < sizeof($this->information['organizations'][$i]['users']); $j++) {
                        if ($user == $this->information['organizations'][$i]['users'][$j]['name']) {
                            array_splice($this->information['organizations'][$i]['users'], $j, 1);
                            $status = true;
                            break;
                        }
                    }
                    break;
                }
            }
        }else{
            for($i = 0; $i < sizeof($this->information['organizations']); $i++){
                if($name == $this->information['organizations'][$i]['name']){
                    array_splice($this->information['organizations'], $i, 1);
                    $status = true;
                    break;
                }
            }
        }

        $this->update_information_file();
        return $status;
    }

    public function modify_organisation($name, $description, $users){
        $status = false;

        # Il faut voir si l'organisation existe déjà
        for($i = 0; $i < sizeof($this->information['organizations']); $i++){
            if($name == $this->information['organizations'][$i]['name']){
                if($description){$this->information['organizations'][$i]['description'] = $description;}

                if($users){
                    $exist = false;
                    for($j = 0; $j < sizeof($this->information['organizations'][$i]['users']); $j++){
                        if($users['name'] == $this->information['organizations'][$i]['users'][$j]['name']){
                            $this->information['organizations'][$i]['users'][$j]['role'] = $users['role'];
                            $this->information['organizations'][$i]['users'][$j]['password'] = $users['password'];
                            $exist = true;
                            break;
                        }
                    }
                    if(!$exist){
                        array_push($this->information['organizations'][$i]['users'], $users);
                    }
                }

                $status = true;
                break;
            }
        }

        # Sinon on l'ajoute au fichier comme une nouvelle organisation
        if(!$status){
            if($users){
                array_push($this->information['organizations'], array("name"=>$name,"description"=>$description,"users"=>[$users]));
            }else{
                array_push($this->information['organizations'], array("name"=>$name,"description"=>$description,"users"=>[]));
            }
        }

        $this->update_information_file();
        return $status;
    }

}
