<?php

namespace App\Model;

use App\Model\Produit;
use \PDO;

/**
 * filtre les element de la liste selectif
 */
class Filter {

    /**
     * permet de filtre les model,type et marque d'un produit
     * @return type Array
     */
    public static function filter() {
        $res = Produit::getDB()->getPDO()->
                query('SELECT DISTINCT marque,type 
				FROM produit ORDER BY type,marque');
        $file = fopen('static/js/filter.js', 'w');
        fclose($file);
        //liste des tyepes filtrés
        $list = [];
        //filtrage des type
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $list[$row['type']][] = $row['marque'];
        }

        $file = fopen('static/js/filter.js', 'w+');

        $chaine = '';
        $type = '';
        $chaine_type = '';

        fwrite($file, "function getMarque(type){\r\n");
        fwrite($file, "\r\n\tvar chaine_type = '';\n\r");
        fwrite($file, "\r\n\tswitch(type){\n\r");
        foreach ($list as $key => $value) {
            fwrite($file, "\t\tcase'$key':\n\r");
            fwrite($file, "\t\t\tchaine_type = '" . implode('|', $value) . "';\n\r");
            fwrite($file, "\t\t\tbreak;\n\r");
        }
        fwrite($file, "\t}\r\n");
        fwrite($file, "\treturn chaine_type;\n\r");
        fwrite($file, "}\r\n");


        $res = Produit::getDB()->getPDO()->
                query('SELECT DISTINCT model,marque FROM produit ORDER BY marque,model');
        //liste des marques triées
        $list1 = [];
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $list1[$row['marque']][] = $row['model'];
        }

        fwrite($file, "function getModel(marque){\r\n");
        fwrite($file, "\r\n\tvar chaine_marque = '';\n\r");
        fwrite($file, "\r\n\tswitch(marque){\n\r");
        foreach ($list1 as $key => $value) {
            fwrite($file, "\t\tcase'$key':\n\r");
            fwrite($file, "\t\t\tchaine_marque = '" . implode('|', $value) . "';\n\r");
            fwrite($file, "\t\t\tbreak;\n\r");
        }
        fwrite($file, "\t}\r\n");
        fwrite($file, "\treturn chaine_marque;\n\r");
        fwrite($file, "}\r\n");
        fclose($file);

        $res = Produit::getDB()->getPDO()->
                query('SELECT DISTINCT model FROM produit');
        //liste des model triés
        $list3 = [];
        //filtrage des des models
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $list3[] = $row['model'];
        }

        return ['filtreType' => $list, 'filtreMarque' => $list1, 'filtreModel' => $list3];
    }

    public static function error($error) {
    
        $file = fopen('static/js/errors.js', 'w');
        fclose($file);
    
        $file = fopen('static/js/errors.js', 'w+');
        fwrite($file, "function getError(error){\r\n");
        foreach ($error as $key => $value) {
            fwrite($file, "\tif(error=='$key')\n");
            fwrite($file, "\t\treturn '" .$value. "';\n");
        }
        fwrite($file, "\treturn '';\n\r");
        fwrite($file, "}\r\n");
    }

}
