<?php

namespace CodeDelivery\Http\Controllers;


use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use CodeDelivery\Services\OrdertService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var OrderService
     */
    private $service;

    public function __construct(OrderRepository $repository,
                                UserRepository $userRepository,
                                ProductRepository $productRepository,
                                OrderService $service){
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->orderService = $service;
    }


    public function index(){
        $clientId = $this   ->userRepository->find(Auth::user()->id)->client->id;
        //Quando cria o scopeQuery, recebemos o proprio objeto para continuar
        // a consulta e assim conseguimos utilizar o where
        $orders = $this->repository->scopeQuery(function($query) use($clientId){
            return $query->where('client_id','=',$clientId);
        })->paginate();

        return view('customer.order.index', compact('orders'));
    }

    public function create(){
        $products = $this->productRepository->lists();
        return view('customer.order.create', compact('products'));
    }

    public function store(Request $request){
        $data = $request->all();
        $clientId = $this->userRepository->find(Auth::user()->id)->client->id;
        $data['client_id'] = $clientId;
        $this->service->create($data);

        return redirect()->route('customer.order.index');
    }

}
