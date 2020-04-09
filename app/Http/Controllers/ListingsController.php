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
            $crawler = Goutte::request('GET', 'https://www.immobilienscout24.de/expose/93354736');

            // extract expose step by step (only information not included in script)

            // expose title
            $expose_title = $crawler->filter('#expose-title')->first()->text();
            $expose_address_block = $crawler->filter('.address-block')->first()->text();
            // realtor courtage
            $broker_commission_percentage = (float) filter_var(str_replace(',', '.', $crawler->filter('.is24qa-provision')->first()->text()), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $broker_commission_value = 0;
            $land_transfer_percentage = 0;
            $land_transfer_value = 0;
            // Filter all expose links
            $node_text = array();
            $crawler->filter('#is24-content > .grid-item > .is24-ex-details > span')->each(function ($node) use (&$node_text, &$broker_commission_percentage, &$broker_commission_value, &$land_transfer_percentage, &$land_transfer_value) {
                $node_text[] = $node->text();
                if (strpos(strval($node->attr("class")), "broker-commission-value") !== false) {
                    dd('yes');
                    $broker_commission_value = (float) $node->text();
                    dd($broker_commission_value);
                }
            });
            dd($node_text);


            //$broker_commission_value = (float) filter_var(str_replace(',', '.', $crawler->filter('.finance-cost-offers-widget > .cost-container')->first()->text()), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            // land transfer (grunderwerbsteuer)
            $land_transfer_percentage = (float) filter_var(str_replace(',', '.', $crawler->filter('.land-transfer-percentage')->first()->text()), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $land_transfer_value = (float) filter_var(str_replace(',', '.', $crawler->filter('.land-transfer-value')->first()->text()), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

            // adress (from script)
            $script = json_decode($crawler->filter('s24-ad-targeting')->first()->text());
            dd($script);





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