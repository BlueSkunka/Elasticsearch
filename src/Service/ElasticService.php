<?php 

namespace App\Service;

class ElasticService {

    public function generateParams(Array $datas) {
        return $params = [
            'index' => 'personnalite',
            'body' => [
                'nom' => (is_null($datas['nom']) ? "" : $datas['nom']),
                'prenom' => (is_null($datas['prenom']) ? "" : $datas['prenom']),
                'presentation' => (is_null($datas['presentation']) ? "" : $datas['presentation']),
                'categorie' => (is_null($datas['categorie']) ? "" : $datas['categorie'])
            ]
        ]; 
    }

    public function generateSearchParams(Array $datas) {
        $matches = [];
        
        if (!is_null($datas['nom']))
            $matches[] =  ['match' => ['nom' => $datas['nom']]];

        if (!is_null($datas['prenom']))
            $matches[] =  ['match' => ['prenom' => $datas['prenom']]];

        if (!is_null($datas['presentation']))
            $matches[] =  ['match' => ['presentation' => $datas['presentation']]];

        if (!is_null($datas['categorie']))
            $matches[] =  ['match' => ['categorie' => $datas['categorie']]];


        return $params = [
            'index' => 'personnalite',
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => $matches
                    ]
                ]
            ]
        ];
    }

    public function isFormFilled($datas) {
        if (!is_null($datas['nom']) || !is_null($datas['prenom']) || !is_null($datas['presentation']) || !is_null($datas['categorie']))
            return true;
        else
            return false;
    }
}
