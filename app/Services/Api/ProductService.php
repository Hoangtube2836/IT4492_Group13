<?php


namespace App\Services\Api;


use App\Contracts\Services\Api\ProductServiceInterface;
use App\Repositories\ProductRepository;
use App\Services\AbstractService;
use http\Env\Request;
use http\Exception\InvalidArgumentException;


class ProductService extends AbstractService implements ProductServiceInterface
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll(){
        return $this->productRepository->getAll();
    }

    public function store($data)
    {
        $validated = $data->validate([
            'id' => 'required',
            'name' => 'required',
            'size' => 'required',
            'quantity' => 'required',
            'warehouse_id' => 'required',
            'source' => 'required',
            'price' => 'required',
        ]);

        if(!$validated){
            throw new InvalidArgumentException($validated->errors()->first());
        }

        $userRequest = $data->toArray();

        return $this->productRepository->store($userRequest);
    }

}