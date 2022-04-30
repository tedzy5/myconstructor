<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Customers;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $categories = Categories::all();

        return view('welcome', compact('categories'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function dashboard()
    {
        $categories = Categories::all();
        $customers = Customers::all();
        $deletes = Customers::onlyTrashed()->get();

        return view('dashboard', compact('categories', 'customers', 'deletes'));
    }
}
