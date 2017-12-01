<?php
namespace Ignite\Finance\Repositories;

use Ignite\Finance\Entities\EvaluationPayments;

use Auth;

class PaymentsRepository
{
    protected $payment;

    /*
    * Save an evaluation payment into the database
    */
    public function save($details)
    {
        $details['user'] = Auth::id();

        $details['receipt'] = str_random(10);

        $details['amount'] = $this->total();

        $details['deposit'] = true;

        return EvaluationPayments::create($details);
    }

    /*
    * Get a payment by using the id
    */
    public function find($id)
    {
        $this->payment = EvaluationPayments::findOrFail($id);

        return $this->payment;
    }

    /*
    * Goes through a payment and groups all the payment modes that were made
    */
    public function getModes()
    {
        return collect([
            'cash'  => $this->payment->cash, 
            'card'  => $this->payment->card, 
            'cheque'=> $this->payment->cheque, 
            'mpesa' => $this->payment->mpesa
        ]);
    }

    /*
    * Return the modes in a view friendly way
    */
    public function modes()
    {
        return $this->getModes()->filter(function($mode){
            
            return !is_null($mode);

        });
    }

    /*
    * Get the total amunt paid for in one transaction
    */
    public function total()
    {
        $total = 0;

        $this->modes()->each(function($mode) use(&$total){

            $total += $mode->amount;

        });

        return $total;
    }
}