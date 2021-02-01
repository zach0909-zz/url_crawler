<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Link;
use DB;

class LinkController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links = Link::all();
        return view('results')->with('links', $links);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('links')->truncate(); 
        $url = $request->input('url');
        $all_links = self::getUrls($url);

        foreach ($all_links as $link) 
        {
           self::store_one_url($link);
        }

        return redirect('/links');
    }

    private function store_one_url($link)
    {
        $new_entry = new Link;
        $new_entry->url = $link;
        $new_entry->save();
    }

    public function getUrls ($link) 
    {
        include(app_path() . '\functions\simple_html_dom.php');
        
        $html = file_get_html($link);
        $anchor_tags = $html->find('a');
        $links_to_store = [];
        foreach ($anchor_tags as $anchor_tag) {
            if (isset($anchor_tag->href) && !in_array($anchor_tag->href, $links_to_store)) {
                
                $temp_link = $anchor_tag->href[0] === '/' ? $link . $anchor_tag->href : $anchor_tag->href;
                
                $good_link = self::validateUrl($temp_link);

                if ($good_link) {
                    $links[] = $anchor_tag->href;
                }

            }
        }
        return $links;
    } 

    private static function validateUrl ($url) 
    {
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_HEADER, true);
        curl_setopt($handle, CURLOPT_NOBODY, true);
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_exec($handle);
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);

        return $code === 200;
    }
}

