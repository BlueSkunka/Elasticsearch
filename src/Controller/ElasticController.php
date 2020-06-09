<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Elasticsearch\ClientBuilder;
use App\Form\ElasticType;
use App\Form\ElasticSearchType;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ElasticService;

class ElasticController extends AbstractController
{

    public function index(Request $request, ElasticService $elasticService)
    {
        $params = ['index' => 'personnalite'];

        $form = $this->createForm(ElasticType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $datas = $form->getData();

            if ($elasticService->isFormFilled($datas))
                $params = $elasticService->generateSearchParams($datas);
        }
    
        $client = ClientBuilder::create()->build();

        $response = $client->search($params);

        return $this->render('elastic/index.html.twig', [
            'personnalites' => $response['hits']['hits'],
            'form' => $form->createView()
        ]);
    }

    public function new(Request $request, ElasticService $elasticService)
    {
        $form = $this->createForm(ElasticType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $datas = $form->getData();

            $client = ClientBuilder::create()->build();
            
            $params = $elasticService->generateParams($datas);

            $response =  $client->index($params);

            return $this->redirect($this->generateUrl('elastic_show', ["id" => $response["_id"]]));
        }

        return $this->render('elastic/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function show($id)
    {
        $client = ClientBuilder::create()->build();

        $params = [
            'index' => 'personnalite',
            'id' => $id
        ];

        $response = $client->getSource($params);

        return $this->render('elastic/show.html.twig', [
            'personnalite' => $response
        ]);
    }

    public function edit()
    {
        return $this->render('elastic/index.html.twig', [
            'controller_name' => 'ElasticController',
        ]);
    }

    public function delete(string $id)
    {
        $client = ClientBuilder::create()->build();

        $params = [
            'index' => 'personnalite',
            'id' => $id
        ];

        $client->delete($params);

        return $this->redirect($this->generateUrl('elastic_index'));
    }

    public function info()
    {
        $client = ClientBuilder::create()->build();

        $params = [
            'index' => 'my_index',
            'body'  => [
                'query' => [
                    'match' => [
                        'testField' => 'abc'
                    ]
                ]
            ]
        ];
        
        $response = $client->search($params);

        return $this->render('elastic/info.html.twig', [
            'response' => $response
        ]);
    }
}
