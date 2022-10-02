<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\HeaderUtils;

class OrderToCsvApiController extends AbstractController
{

    public function index(): Response
    {
        if (isset($_POST["csv"])) {
            // récupération du contacts
            $contact = HttpClient::create();
            $requestContact = $contact->request('GET', 'https://ba14b687-40fe-4f56-b4a8-a6fefb6b236d.mock.pstmn.io/contacts', [
                'headers' => [
                    'Content-Type' => 'text/html',
                    'x-api-key' => 'PMAK-6337088f2610b34181ee45cb-45497a0435e22329d226f6fe4740e3d781'
                ],
            ]);
            $responseDataContact = json_decode($requestContact->getContent(), true, 512, JSON_THROW_ON_ERROR);

            //mettre les contacts dans un tableau personnalisé
            $contacts = [];
            $i = 0;
            foreach ($responseDataContact as $dt) {
                foreach ($dt as $sd) {
                    $contacts[$i]['id'] = $sd['ID'];
                    $contacts[$i]['nom'] = $sd['AccountName'];
                    $contacts[$i]['adresse1'] = $sd['AddressLine1'];
                    $contacts[$i]['adresse2'] = $sd['AddressLine2'];
                    $contacts[$i]['ville'] = $sd['City'];
                    $contacts[$i]['nomContact'] = $sd['ContactName'];
                    $contacts[$i]['pays'] = $sd['Country'];
                    $contacts[$i]['zipCode'] = $sd['ZipCode'];
                    $i++;
                }
            }
        }

        // récupération du commandes
        $client = HttpClient::create();
        $request = $client->request('GET', 'https://ba14b687-40fe-4f56-b4a8-a6fefb6b236d.mock.pstmn.io/orders', [
            'headers' => [
                'Content-Type' => 'text/html',
                'x-api-key' => 'PMAK-6337088f2610b34181ee45cb-45497a0435e22329d226f6fe4740e3d781'
            ],
        ]);
        $responseData = json_decode($request->getContent(), false, 512, JSON_THROW_ON_ERROR);

        //traitement du données et les mettre dans un tableau
        $j = 1;
        $comm = ["item_index,order,delivery_name,delivery_address,delivery_country,delivery_zipcode,delivery_city,items_count,item_id,item_quantity,line_price_excl_vat,line_price_incl_vat"];
        foreach ($responseData as $data) {
            $commandeCsv = "";
            foreach ($data as $dts) {
                foreach ($dts->SalesOrderLines as $mics) {
                    foreach ($mics as $mic) {
                        $quantity = count($mics) - 1;
                        $amountNoTva = $mic->Amount - $mic->VATAmount;
                        $searchName = array_search($dts->DeliverTo, array_column($contacts, 'id'));
                        array_push($comm, $j . "," . $dts->OrderID . "," . $contacts[$searchName]['nom'] . "," . $contacts[$searchName]['adresse1'] . "," . $contacts[$searchName]['pays'] . "," . $contacts[$searchName]['zipCode'] . "," . $contacts[$searchName]['ville'] . "," . $quantity.",".$mic->Item.",".$mic->Quantity.",".$amountNoTva.",".$mic->Amount);
                        $j++;
                    }
                }
                $i++;
            }
        }
        
        // convertir les données en fichier CSV
        $fileContent =  implode(PHP_EOL, $comm);
        $response = new Response($fileContent);
        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            'commandes.csv'
        );
        $response->headers->set('Content-Disposition', $disposition);
        return $response;
    }
}
