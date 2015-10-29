<?php
/**
 * Created by PhpStorm.
 * User: Robinho
 * Date: 25/10/2015
 * Time: 22:39
 */

namespace CodeDelivery\Services;


use CodeDelivery\Repositories\ClientRepository;
use CodeDelivery\Repositories\UserRepository;

class ClientService
{

    /**
     * @var ClientRepository
     */
    private $clientRepository;


    /**
     * @var ClientRepository
     */
    private $userRepository;

    public function __construct(ClientRepository $clientRepository, UserRepository $userRepository){


        $this->clientRepository = $clientRepository;
        $this->userRepository   = $userRepository;
    }

    public function update(array $data, $id){
        $this->clientRepository->update($data, $id);

        //pega o id do usuário
        $userId = $this->clientRepository->find($id,['user_id'])->user_id;


        $this->userRepository->update($data['user'], $userId);
    }

    public function create(array $data){

        //quando criar um cliente, vai criar o usuário e com a senha
        $data['user']['password'] = bcrypt(123456);

        //quando criar o usuário vai retornar o id dele, para passar no array
        $user = $this->userRepository->create($data['user']);

        //pegar o id do usuário e passa no array para criar o client
        $data['user_id'] = $user->id;
       // dd($data['user_id']);
        $this->clientRepository->create($data);
    }
}