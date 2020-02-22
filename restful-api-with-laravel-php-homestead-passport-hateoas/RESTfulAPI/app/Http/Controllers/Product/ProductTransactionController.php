<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductTransactionController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Product $product)
    {
        $transactions = $product->transactions()->get();

        return $this->showAll($transactions);
    }

}
