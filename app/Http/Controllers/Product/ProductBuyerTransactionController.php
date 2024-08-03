<?php

namespace App\Http\Controllers\Product;

use App\Events\ProductOutOfStockEvent;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Transaction\TransactionStoreRequest;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Buyer;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Transaction;
use App\Models\User;
use App\Transformers\Transaction\TransactionTransformer;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProductBuyerTransactionController extends ApiController
{
    public function __constructor() {
        $this->middleware('transform.input:'. TransactionTransformer::class)->only(['store']);
    }
    public function store(TransactionStoreRequest $request, Product $product, Buyer $buyer)
    {
        $data = $request->validated();

        $this->checkQuantity($product, $data['quantity']);

        $this->checkBuyerVerified($buyer, $product->seller);

        $this->checkBuyer($product, $buyer);

        $data['buyer_id'] = $buyer->id;
        $data['product_id']  = $product->id;

        return DB::transaction(function () use ($data, $product) {
            $product->quantity -= $data['quantity'];
            $product->save();
            $transaction = Transaction::create([
                'quantity' => $data['quantity'],
                'product_id' => $product->id,
                'buyer_id' => $data['buyer_id']
            ]);
            event(new ProductOutOfStockEvent($product));

            $transaction = new TransactionResource($transaction);
            return $this->showOne($transaction, 201);
        });
    }

    protected function checkBuyer(Product $product, User $user) {
        if ($product->seller_id == $user->id) {
            throw new HttpException(409, 'The buyer cannot purchase his own product');
        }
    }

    protected function checkQuantity(Product $product, $quantity) {
        if ($product->quantity < $quantity) {
            throw new HttpException(409, 'The product does not have enough units');
        }
    }

    protected function checkBuyerVerified(Buyer $buyer, Seller $seller) {
        if (!$buyer->isVerified()) {
            throw new HttpException(409, 'The buyer must be a verified user');
        }

        if (!$seller->isVerified()) {
            throw new HttpException(409, 'The seller must be a verified user');
        }
    }
}
