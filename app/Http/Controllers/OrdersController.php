<?php

namespace CodeDelivery\Http\Controllers;


use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Http\Requests;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function __construct(OrderRepository $repository){
        $this->repository = $repository;
    }

    public function index(){

        $orders = $this->repository->paginate();

        return view('admin.orders.index',compact('orders'));

    }


    public function edit($id, UserRepository $userRepository){

        $list_status = [0 => 'Pendente', 1 => 'A Caminho', 2 => 'Entregue', 3 => 'Cancelado'];
        $order = $this->repository->find($id);

        $deliveryman = $userRepository->getDeliveryman();

        return view('admin.orders.edit',compact('order','list_status','deliveryman'));

    }

    public function update(Request $request,$id ){
        $all = $request->all();

        $this->repository->update($all,$id);

        return redirect()->route('admin.orders.index');
    }

}