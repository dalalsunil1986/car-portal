<?php
namespace App\Http\Controllers;

class DealersController extends Controller
{

    public function __construct()
    {
    }

    /**
     * @return mixed
     * Find All the Favorites for the user
     */
    public function index()
    {
        return view('module.dealers.index');
    }

    public function show($id)
    {
        return view('module.dealers.view');
    }

}