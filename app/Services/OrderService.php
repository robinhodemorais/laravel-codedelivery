<?php
/**
 * Created by PhpStorm.
 * User: Robinho
 * Date: 25/10/2015
 * Time: 22:39
 */

namespace CodeDelivery\Services;



use CodeDelivery\Repositories\CupomRepository;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;

class OrderService
{

    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var CupomRepository
     */
    private $cupomRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(OrderRepository $orderRepository,
                                CupomRepository $cupomRepository,
                                ProductRepository $productRepository){


        $this->orderRepository = $orderRepository;
        $this->cupomRepository = $cupomRepository;
        $this->productRepository = $productRepository;
    }



    public function create(array $data){

        //inicia todas as transções
        //isso é para não utilizar a conexão com o banco a todo o momento
        //porém dessa maneira cria um acoplamento, mas pode ser utilizado no construct
        //passando a instacia do BD
        \DB::beginTransaction();

        try{

            //forçamos o pedido para sempre ter o status 0 quando criado
            $data['status'] = 0;

            //checagem para verificar se existe cupom de desconto
            if(isset($data['cupom_code'])) {
                // ??
                $cupom = $this->cupomRepository->findByField('code', $data['cupom_code'])->first();
                //determinamos que o cupom_id é igual ao o id do cupom
                $data['cupom_id'] = $cupom->id;
                $cupom->used = 1;
                //para salvar no banco de dados
                $cupom->save();
                //para não tentar persistir os dados quando colocar o data no array
                unset($data['cupom_code']);

            }

            //prepara os dados do item para isenrir no banco
            $items = $data['items'];
            //
            unset($data['items']);

            $order = $this->orderRepository->create($data);
            $total = 0;

            foreach($items as $item){
                //buscamos o product_id do formulario e consulta no banco o preço
                $item['price'] = $this->productRepository->find($item['product_id'])->price;
                //adiciona o item na ordem de serviço
                $order->items()->create($item);
                //gravamos o valor final
                $total += $item['price'] * $item['qtd'];
            }

            $order->total = $total;

            //se utilizar um cupom de desconto
            if(isset($cupom)) {
                //pegamos o total e subrtraiomos o valor de desconto do cupom
                $order->total = $total - $cupom->value;
            }

            //salva os dados
            $order->save();
            //comita para gravar
            \DB::commit();

            //caso não deu certo
        } catch(\Exception $e) {
            //não grava os dados
           \DB::roolback();
            throw $e;
        }
    }
}