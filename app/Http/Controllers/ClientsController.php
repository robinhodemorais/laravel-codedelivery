<?php

namespace CodeDelivery\Http\Controllers;


use CodeDelivery\Http\Requests\AdminClientRequest;
use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\ClientRepository;

class ClientsController extends Controller
{
    /**
     * @var ClientRepository
     */

    private $repository;

    public function __construct(ClientRepository $repository){
        $this->repository = $repository;
    }

    public function index(){

        $clients = $this->repository->paginate();

        return view('admin.clients.index',compact('clients'));

    }

    public function create(){
        return view('admin.clients.create');
    }

    public function store(AdminClientRequest $request){

        $data = $request->all();
        $this->repository->create($data);

        return redirect()->route('admin.clients.index');
    }

    public function edit($id){
        $clients = $this->repository->find($id);

        return view('admin.clients.edit',compact('clients'));
    }

    public function update(AdminClientRequest $request, $id){

        $data = $request->all();
        $this->repository->update($data,$id);

        return redirect()->route('admin.clients.index');

    }


    public function destroy($id){
        $this->repository->delete($id);

        return redirect()->route('admin.clients.index');
    }
}
