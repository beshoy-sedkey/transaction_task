<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransactionRequest;
use App\Http\Resources\TransactionsResource;
use App\Models\Transaction;
use App\Repository\TransactionService;
use App\Traits\GeneralReturn;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate as FacadesGate;

class TransactionController extends Controller
{
    use GeneralReturn;

    /**
     * @var TransacrionService
     */
    protected $transacrionService;

    public function __construct(TransactionService $transacrionService)
    {
        $this->transacrionService = $transacrionService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('manageTransactions');
        $data = $this->transacrionService->all();
        return TransactionsResource::collection($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTransactionRequest $request)
    {
        $this->authorize('manageTransactions');
        $this->transacrionService->insert($request->all());
        return $this->Success201('Transaction');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction, Request $request)
    {
        $this->authorize('manageTransactions');
        $data = $this->transacrionService->show($transaction, $request->all());
        return $this->Success200($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * showUserTransaction
     * @return GeneralReturn
     */
    public function showUserTransaction()
    {
        $transaction = $this->transacrionService->showUserTransaction();
        return $this->Success200($transaction);
    }
    /**
     * createTransactionDetails
     * @param Transaction $transaction
     * @param Request $request
     *
     * @return [type]
     */
    public function createTransactionDetails(Transaction $transaction , Request $request){
        $this->transacrionService->createTransactionDetails($transaction , $request->all());
        return $this->Success202();

    }
}
