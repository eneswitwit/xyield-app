<?php

namespace App\Console\Commands;


use App\Ad;

use Goutte;

use Illuminate\Console\Command;

class ScrapeImmoScout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:immoscout {immo_type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape Immobilienscout24';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pageNumber = 1;
        $expose_links = array();
        $scraping = true;
        $baseUrl = 'https://www.immobilienscout24.de/Suche/de/' . $this->argument('immo_type') . '?pagenumber=';

        while ($scraping) {

            $this->info($this->argument('immo_type') . ' ' . $pageNumber);

            $crawler = Goutte::request('GET', $baseUrl . $pageNumber);

            // Filter all expose links
            $crawler->filter('a')->each(function ($node) use (&$expose_links) {
                if (strpos(strval($node->attr("href")), "/expose/") !== false) {
                    $expose_links[] = strval($node->attr("href"));
                }
            });

            // Loop through all expose links and extract data
            foreach (array_unique($expose_links) as $expose_link) {

                // skip if already scraped - check if price has changed and still active 
                $crawler = Goutte::request('GET', 'https://www.immobilienscout24.de' . $expose_link);
                $script = json_decode($crawler->filter('s24-ad-targeting')->first()->text());
                $ad = Ad::find($script->obj_scoutId);

                if ($ad === null) {
                    // extract expose step by step (only information not included in script)
                    // expose title
                    $crawler_expose_title = $crawler->filter('#expose-title');
                    $expose_title = "";
                    if ($crawler_expose_title->count() > 0) {
                        $expose_title = $crawler_expose_title->first()->text();
                    }
                    $script->expose_title = $expose_title;

                    // adress block unter expose titel
                    $crawler_expose_address_block = $crawler->filter('.address-block');
                    $expose_address_block = "";
                    if ($crawler_expose_address_block->count() > 0) {
                        $expose_address_block = $crawler_expose_address_block->first()->text();
                    }
                    $script->expose_address_block = $expose_address_block;

                    // tags above first data block
                    // gäste toilette
                    $crawler_expose_guests_toilet = $crawler->filter('.is24qa-gaeste-wc-label');
                    $expose_guests_toilet = "";
                    if ($crawler_expose_guests_toilet->count() > 0) {
                        $expose_guests_toilet = "y";
                    }
                    $script->expose_guests_toilet = $expose_guests_toilet;
                    // einliegerwohnung
                    $crawler_expose_granny_flat = $crawler->filter('.is24qa-einliegerwohnung-label');
                    $expose_granny_flat = "";
                    if ($crawler_expose_granny_flat->count() > 0) {
                        $expose_granny_flat = "y";
                    }
                    $script->expose_granny_flat = $expose_granny_flat;

                    // first data block - kerndaten
                    // schlafzimmer
                    $crawler_expose_bedrooms = $crawler->filter('.is24qa-schlafzimmer');
                    $expose_bedrooms = "";
                    if ($crawler_expose_bedrooms->count() > 0) {
                        $expose_bedrooms = $crawler_expose_bedrooms->first()->text();
                    }
                    $script->expose_bedrooms = $expose_bedrooms;

                    // badezimmer
                    $crawler_expose_bathrooms = $crawler->filter('.is24qa-badezimmer');
                    $expose_bathrooms = "";
                    if ($crawler_expose_bathrooms->count() > 0) {
                        $expose_bathrooms = $crawler_expose_bathrooms->first()->text();
                    }
                    $script->expose_bathrooms = $expose_bathrooms;

                    // bezugsfrei ab
                    $crawler_expose_vacant_from = $crawler->filter('.is24qa-bezugsfrei-ab');
                    $expose_vacant_from = "";
                    if ($crawler_expose_vacant_from->count() > 0) {
                        $expose_vacant_from = $crawler_expose_vacant_from->first()->text();
                    }
                    $script->expose_vacant_from = $expose_vacant_from;

                    // second data block - Kosten
                    // maklergebuehr
                    $crawler_realtor_commission_percentage = $crawler->filter('.is24qa-provision');
                    $expose_realtor_commission_percentage = "";
                    if ($crawler_realtor_commission_percentage->count() > 0) {
                        $expose_realtor_commission_percentage = (float) filter_var(str_replace(',', '.', $crawler_realtor_commission_percentage->first()->text()), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    }
                    $script->expose_realtor_commission_percentage = $expose_realtor_commission_percentage;


                    // third data block - bausubstanz und energieausweis
                    // denkmalschutz
                    $crawler_expose_monument_protection = $crawler->filter('.is24qa-denkmalschutzobjekt');
                    $expose_monument_protection = "";
                    if ($crawler_expose_monument_protection->count() > 0) {
                        $expose_monument_protection = $crawler_expose_monument_protection->first()->text();
                    }
                    $script->expose_monument_protection = $expose_monument_protection;
                    // energieausweis
                    $crawler_expose_energy_certificate = $crawler->filter('.is24qa-energieausweis');
                    $expose_energy_certificate = "";
                    if ($crawler_expose_energy_certificate->count() > 0) {
                        $expose_energy_certificate = $crawler_expose_energy_certificate->first()->text();
                    }
                    $script->expose_energy_certificate = $expose_energy_certificate;

                    // objektbeschreibung
                    $crawler_expose_property_description = $crawler->filter('.is24qa-objektbeschreibung');
                    $expose_property_description = "";
                    if ($crawler_expose_property_description->count() > 0) {
                        $expose_property_description = $crawler_expose_property_description->first()->text();
                    }
                    $script->expose_property_description = $expose_property_description;

                    // ausstattung
                    $crawler_expose_property_equipment = $crawler->filter('.is24qa-ausstattung');
                    $expose_property_equipment = "";
                    if ($crawler_expose_property_equipment->count() > 0) {
                        $expose_property_equipment = $crawler_expose_property_equipment->first()->text();
                    }
                    $script->expose_property_equipment = $expose_property_equipment;

                    // lage
                    $crawler_expose_location_text = $crawler->filter('.is24qa-lage');
                    $expose_location_text = "";
                    if ($crawler_expose_location_text->count() > 0) {
                        $expose_location_text = $crawler_expose_location_text->first()->text();
                    }
                    $script->expose_location_text = $expose_location_text;

                    // sonstiges
                    $crawler_expose_misc_text = $crawler->filter('.is24qa-sonstiges');
                    $expose_misc_text = "";
                    if ($crawler_expose_misc_text->count() > 0) {
                        $expose_misc_text = $crawler_expose_misc_text->first()->text();
                    }
                    $script->expose_misc_text = $expose_misc_text;

                    $ad = new Ad();
                    $ad->fill((array) $script);
                    $ad->save();
                } else {
                    // @TODO: do price updates and so on
                }
            }

            // If arrived at last page break 
            if (sizeof($expose_links) > 0) {
                $pageNumber++;
            } else {
                $scraping = false;
            }
        }
    }
}