<?php

class DefaultView{

    public function output($orgs){
        #$list = array( 'FOO', 'BAR', 'BAZ' );
        #$tableau = '<p>' . var_dump($orgs['organizations'][0]) . '</p>';
        $tableau = $this->make_tableau($orgs);

        $forms = '<b>Si vous souhaitez supprimer une organisation ou un utilisateur :</b>
<p>( Pour supprimer un utilisateur il faut fournir aussi l\'organisation dont il fait partie )</p>
<form action="delete" methods="get">
  <label for="name">Name:</label><br>
  <input type="text" id="name" name="name"><br>
  <label for="uname">User name:</label><br>
  <input type="text" id="uname" name="uname"><br>
  <input type="submit" value="Supprimer">  
</form>
<br><br>
<b>Si vous souhaitez modifier ou ajouter une organisation :</b>
<p>( pour modifier une organisation il suffit d\'ecrire un nom déjà existant ) </p>
<p>( c\'est pareil pour les utilisateurs. Si vous voulez les modifier il suffit d\'ecrire le nom d\'un utilisateur déjà existant. Sinon mettez un nouveau nom ) </p>
<form action="modify" method="get">
  <label for="name">Name:</label><br>
  <input type="text" id="name" name="name"><br>
  <label for="description">Description:</label><br>
  <input type="text" id="description" name="description"><br><br>
  <label for="uname">User name:</label><br>
  <input type="text" id="uname" name="uname"><br>
    <label for="urole">User role (séparer par espace s\'il y a plusieurs) :</label><br>
  <input type="text" id="urole" name="urole"><br>
    <label for="upass">User password:</label><br>
  <input type="text" id="upass" name="upass"><br>
  <input type="submit" value="Envoyer">
</form>';

        $style = 'td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}';

        return '<!DOCTYPE html> <html><style>' . $style . '</style><body>' . $tableau . '<p></p><p></p><h2>Modifier :</h2>' . $forms . '</body></html>';
    }

    public function make_tableau($parameters){
        $orgs = $parameters['organizations'];
        $table_beggining = '<table style="font-family:arial;width:100%;border-collapse:collapse;">
  <tr>
    <th>Name</th>
    <th>Description</th>
  </tr>';

        $fill = '';
        for($i = 0; $i < sizeof($orgs); $i++){
            $fill .= '<tr><td>' . $orgs[$i]['name'] . '</td><td>' . $orgs[$i]['description'] . '</td>';
        }

        return $table_beggining . $fill . '</table>';

    }
}
