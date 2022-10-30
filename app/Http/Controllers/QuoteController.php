<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;


class QuoteController extends Controller
{
    public function getQuotes()
    {
        // start at page 1
        $index = 1;
        //While loop, that will get the pages
        while($index <= 5){

            //For loop to get data from all pages
            for ( $i = 1;$i <= 5;$i++)
            {
                $client = new Client();
                $url = "http://quotes.toscrape.com/page/$index";
                $page = $client->request('GET', $url);
        
                // echo "<pre>";
                // print_r($page);
        
                //echo $page->filter(".text")->text();
                
                //get specific data to create the Array | ["KEY: "VALUE"]
                $page->filter('.quote')->each(function ($item)
                    {
                        $this->results[$item->filter('.author')->text()] = $item->filter('.text')->text();
                    }
                );
        
                //Add the results to a variable
                $data = $this->results;
                //return $this->results;
    
                $index++;
            }
            return view('index', compact('data'));
        }
    }
}
