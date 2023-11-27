<?php

namespace App\Repository;

use App\Models\Transaction;
use App\Models\TransactionDetails;
use Carbon\Carbon;

class TransactionService extends Service
{
    protected const OUTSTANDING = 'outstanding';
    protected const OVERDUE = 'overdue';
    protected $transactionDetails;


    /**
     * setModel
     * @return void
     */
    public function setModel(): void
    {
        $this->model = new Transaction;
        $this->transactionDetails = new TransactionDetails;
    }

    public function all(){
        try {
            $transactions = $this->model->paginate(50);
            return $transactions;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * insert
     * @param array $data
     *
     * @return bool
     */
    public function insert(array $data)
    {
        try {
            $data['payment_status'] = self::calculateStatus($data['due_on'], now());
            $this->model->create($data);
            return true;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function showUserTransaction(){
        try {
            $user = auth()->user();
            $transactions = $this->model->where('payer' , $user->id)->get();
            return $transactions;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /**
     * show
     * @param mixed $id
     *
     * @return [type]
     */
    public function show($id, array $data)
    {
        $transaction = $this->model->find($id)->first();
        if ($transaction) {
            $data = [];
            $data['payment_status'] = self::calculateStatus($transaction->due_on, now());
            $data['updated_at'] = now();
            $transaction->update($data);
        }

        return $transaction;
    }

    /**
     * createTransactionDetails
     * @param Transaction $transaction
     * @param array $data
     *
     * @return [type]
     */
    public function createTransactionDetails(Transaction $transaction ,array $data){
        try {
         return $this->transactionDetails->create([
                'transaction_id' => $transaction->id,
                'paid_amount' => $data['paid_amount'],
                'paid_on' => $data['paid_on'],
                'details' => $data['details']
            ]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

    }

    /**
     * calculateStatus
     * @param mixed $date
     * @param mixed $created_at
     *
     * @return [type]
     */
    private static function calculateStatus($dueDate, $created_at)
    {
        $dueDate = new Carbon($dueDate);
        $after = $dueDate->isAfter($created_at);
        $before = $dueDate->isBefore($created_at);
        $status = '';
        if ($after) {
            $status = self::OUTSTANDING;
        } elseif ($before || $created_at) {
            $status = self::OVERDUE;
        }
        return $status;
    }


}
