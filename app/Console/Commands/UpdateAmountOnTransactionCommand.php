<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Models\TransactionDetails;
use Illuminate\Console\Command;

class UpdateAmountOnTransactionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction-amount:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $transactionIds = Transaction::pluck('id');
        $transactionDetailsSums = TransactionDetails::whereIn('transaction_id', $transactionIds)
            ->where('is_deducted', 0)
            ->groupBy('transaction_id')
            ->selectRaw('transaction_id, sum(paid_amount) as sum')
            ->get()
            ->keyBy('transaction_id');

        $transactions = Transaction::whereIn('id', $transactionIds)->get();

        foreach ($transactions as $transaction) {
            $sumOfPaidAmount = $transactionDetailsSums[$transaction->id]->sum ?? 0;
            $remainingAmount = $transaction->amount - $sumOfPaidAmount;
            $this->info("For transaction ID {$transaction->id}, the remaining amount is {$remainingAmount}.");

            $transaction->where('id', $transaction->id)->update([
                'amount' => $remainingAmount,
            ]);
            $transaction->transactionDetails()->update([
                'is_deducted' => 1
            ]);
        }
    }
}
