<?php

namespace App\Http\Controllers;

use Goutte;

use Illuminate\Http\Request;

class ListingsController extends Controller
{
    public function index(Request $request)
    {
        $pageNumber = 1;
        $expose_links = array();

        $crawler = Goutte::request('GET', 'https://www.immobilienscout24.de/Suche/de/wohnung-mieten?pagenumber=' . $pageNumber);

        // Filter all expose links
        $crawler->filter('a')->each(function ($node) use (&$expose_links) {
            if (strpos(strval($node->attr("href")), "/expose/") !== false) {
                $expose_links[] = strval($node->attr("href"));
            }
        });

        // Loop through all expose links and extract data
        foreach ($expose_links as $expose_link) {
            $crawler = Goutte::request('GET', 'https://www.immobilienscout24.de' . $expose_link);

            // extract expose step by step

            // expose title
            $title = $crawler->filter('#expose-title')->first()->text();

            // adress (from script)
            $script = json_decode($crawler->filter('s24-ad-targeting')->first()->text());

            // price 
            $price = $script->obj_purchasePrice;

            // location
            $state = $script->obj_regio1;
            $municipality_district = $script->obj_regio2;
            $municipality = $script->obj_regio3;
            // check if city district is in address block to specify location further since not all data is in script, basically
            // regio4 is missing
            // @TODO: Filter out regio4
            $address_block = $crawler->filter('.address-block')->first()->text();
            $zipCode = $script->obj_zipCode;
            $street = $script->obj_street;
            $houseNumber = $script->obj_houseNumber;

            // service charge
            $serviceCharge = $script->obj_serviceCharge;
            dd($serviceCharge);




            // area/spaces


        }

        // If arrived at last page break
        if (sizeof($expose_links) > 0) {
            $pageNumber++;
            dd('next page');
        } else {
            dd('no next page');
        }
        // $crawler->filter('s24-ad-targeting')->each(function ($node) {
        //     dump(json_decode($node->text()));
        // });
        return view('listings');
    }
}