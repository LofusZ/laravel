<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /*
     * Display all the static pages when authenticated
     *
     * @param string $page
     * @return \Illuminate\View\View
     */
    public function index(string $page)
    {
        if (view()->exists("pages.{$page}")) {
            return view("pages.{$page}");
        }else{
            
            echo "404 désolé";
            return;
        }

    }


}
