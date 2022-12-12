<?php

namespace App\Handler;

use App\Commands\CreateProductCommand;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CreateProductCommandHandler
{
    public function __invoke(CreateProductCommand $command)
    {
        $product = new Product();
        $product->name = $command->getName();
        $product->price = $command->getPrice();
        Log::info("Name" . $product->name);
        Log::info("Price" . $product->price);
    }
}
