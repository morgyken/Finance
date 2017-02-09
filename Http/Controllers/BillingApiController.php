<?php

namespace Ignite\Finance\Http\Controllers;

use Ignite\Finance\Entities\InsuranceInvoice;
use Ignite\Finance\Entities\DispatchDetails;
use Illuminate\Http\Request;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Finance\Entities\InsuranceInvoicePayment;

class BillingApiController extends \Illuminate\Routing\Controller {

    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function fetchInvoices() {
        $mode = $this->request->mode;
        $patient = $this->request->patient ? $this->request->patient : NULL;
        $date1 = $this->request->date1 ? $this->request->date1 : NULL;
        $date2 = $this->request->date2 ? $this->request->date2 : NULL;

        $n = 0;
        $billed = InsuranceInvoice::where('visit', '>', 0)->whereHas('visits', function($query) {
                    $query->whereHas('patient_scheme', function($query) {
                        $query->whereHas('schemes', function ($query) {
                            $query->whereCompany($this->request->firm);
                        });
                    });
                })
                ->get();

        if ($mode == 'pending') {
            $pending = Visit::wherePaymentMode('insurance')->whereHas('patient_scheme', function($query) {
                        $query->whereHas('schemes', function ($query) {
                            //$query->whereCompany($this->request->firm);
                        });
                    })
                    ->whereNull('status')
                    ->get();
            foreach ($pending as $visit) {
                ?>
                <tr>
                    <td><?php echo$n+=1 ?></td>
                    <td>
                        <input type="checkbox" name="visit[]" value="<?php echo $visit->id ?>">
                        <input type="hidden" name="amount[]" value="<?php echo $visit->unpaid_amount ?>"
                    </td>
                    <td><?php echo$visit->id ?></td>
                    <td><?php echo$visit->patients->full_name ?></td>
                    <td><?php echo(new \Date($visit->created_at))->format('dS M y g:i a') ?> - Clinic <?php echo$visit->clinics->name ?></td>
                    <td><?php echo$visit->patient_scheme->schemes->companies->name ?></td>
                    <td><?php echo$visit->patient_scheme->schemes->name ?></td>
                    <td><?php echo$visit->unpaid_amount ?></td>
                    <td>
                        <?php if ($visit->unpaid_amount > 0) { ?>
                            <a href="<?php echo route('finance.evaluation.bill', $visit->id) ?>" class="btn btn-xs btn-primary disabled">
                                <i class="fa fa-usd"></i> Bill</a>
                        <?php } else { ?>
                            <a href="<?php echo route('finance.evaluation.bill', $visit->id) ?>" class="btn btn-xs btn-primary disabled">
                                <i class="fa fa-usd"></i> Bill</a>
                        <?php } ?>
                    </td>
                </tr>
                <?php
            }
            //Billing
        } elseif ($mode == 'billing') {
            ?>
            <input type="hidden" name="company" value="<?php echo $this->request->firm ?>" >
            <?php
            foreach ($billed as $item) {
                ?>
                <tr>
                    <td><?php echo $n+=1 ?></td>
                    <td>
                        <?php if ($item->status == 0) { ?>
                            <input onclick="updateAmount(<?php echo $item->payment ?>, <?php echo $item->id ?>)" id="check<?php echo $item->id ?>" type="checkbox"
                                   name="bill[]" value="<?php echo $item->id ?>">
                               <?php } else { ?>
                            <i class="fa fa-check" aria-hidden="true"></i>
                        <?php } ?>
                    </td>
                    <td>
                        <?php echo $item->invoice_no ?>
                    </td>
                    <td><?php echo $item->visits->patients->full_name ?></td>
                    <td><?php echo $item->visits->patient_scheme->schemes->name ?>::<?php echo $item->visits->patient_scheme->schemes->companies->name ?></td>
                    <td>
                        <?php echo $item->payment ?>
                        <input type="hidden" name="amount[]" value="<?php echo $item->payment ?>">
                    </td>
                    <td>

                        <?php if ($item->status == 0) { ?>
                            <!--billed-->
                            <span class = "btn-default btn-xs">
                                <small>
                                    <i class = "fa fa-hourglass-start" aria-hidden = "true"></i>
                                    billed
                                </small></span>
                        <?php } elseif ($item->status == 1) { ?>
                            <!--dispatched -->
                            <span class = "btn-info btn-xs">
                                <small>
                                    <i class = "fa fa-hourglass-start" aria-hidden = "true"></i>
                                    dispatched
                                </small>
                            </span>
                        <?php } elseif ($item->status == 2) { ?>
                            <!--paid in part-->
                            <span class = "btn-primary btn-xs">
                                <small>
                                    <i class = "fa fa-hourglass-half" aria-hidden = "true"></i>
                                    partially paid
                                </small>
                            </span>
                        <?php } elseif ($item->status == 3) { ?>
                            <!--fully paid -->
                            <span class = "btn-success btn-xs">
                                <small>
                                    <i class = "fa fa-hourglass" aria-hidden = "true"></i>
                                    fully paid
                                </small>
                            </span>
                        <?php } elseif ($item->status == 4) { ?>
                            <!--overpaid paid -->
                            <span class = "btn-warning btn-xs">
                                <small>
                                    <i class = "fa fa-info-circle" aria-hidden = "true"></i>
                                    overpaid
                                </small>
                            </span>
                        <?php } elseif ($item->status == 5) { ?>
                            <!--canceled -->
                            <span class = "btn-default btn-xs">
                                <small><i style = "color:red" class = "fa fa-trash"></i>cancelled</small></span>
                        <?php } ?>

                    </td>
                    <td>
                        <small>
                            <a href="<?php echo route('finance.evaluation.cancel', $item->id) ?>" class="btn btn-xs btn-primary">
                                <i class="fa fa-print"></i> Print</a>
                            <a href="<?php echo route('finance.evaluation.cancel', $item->id) ?>" class="btn btn-xs btn-danger">
                                <i class="fa fa-times"></i> Cancel</a>
                        </small>
                    </td>
                </tr>
                <?php
            }

            //Cancelled
        } elseif ($mode == 'cancelled') {
            $canceled = Visit::wherePaymentMode('insurance')
                    ->whereHas('patient_scheme', function($query) {
                        $query->whereHas('schemes', function ($query) {
                            $query->whereCompany($this->request->firm);
                        });
                    })
                    ->whereStatus('canceled')
                    ->get();
            foreach ($canceled as $visit) {
                ?>
                <tr>
                    <td><?php echo $visit->id ?></td>
                    <td><?php echo $visit->patients->full_name ?></td>
                    <td><?php echo (new \Date($visit->created_at))->format('dS M y g:i a') ?> - Clinic <?php echo $visit->clinics->name ?></td>
                    <td><?php echo $visit->patient_scheme->schemes->companies->name ?></td>
                    <td><?php echo $visit->patient_scheme->schemes->name ?></td>
                    <td><?php echo $visit->unpaid_amount ?></td>
                    <td><a href="" class="btn btn-xs btn-primary"><i class="fa fa-undo"></i>Undo</a></td>
                </tr>
                <?php
            }
            //Disptched
        } elseif ($mode == 'dispatched') {
            $dispatched = DispatchDetails::whereHas('invoice', function($query) {
                        $query->whereHas('visits', function($query) {
                            $query->whereHas('patient_scheme', function($query) {
                                $query->whereHas('schemes', function ($query) {
                                    $query->whereCompany($this->request->firm);
                                });
                            });
                        });
                    })
                    ->get();
            foreach ($dispatched as $item) {
                ?>
                <tr>
                    <td><?php echo $n+=1 ?></td>
                    <td><?php echo (new \Date($item->created_at))->format('dS M y g:i a') ?></td>
                    <td><?php echo '00' . $item->id ?></td>
                    <td>
                        <?php echo $item->invoice->visits->patient_scheme->schemes->companies->name ?>::
                        <?php echo $item->invoice->visits->patient_scheme->schemes->name ?>
                    </td>
                    <td><?php echo $item->amount ?></td>
                    <td>
                        <a href="<?php echo route('finance.evaluation.insurance.payment.specific', $item->id) ?>" class="btn btn-xs btn-primary">
                            <i class="fa fa-money"></i> Receive Payment</a>

                        <a href="<?php echo route('finance.evaluation.ins.pay', $item->id) ?>" class="btn btn-xs btn-warning">
                            <i class="fa fa-print"></i>Print</a>

                        <a href="<?php echo route('finance.evaluation.ins.pay', $item->id) ?>" class="btn btn-xs btn-danger">
                            <i class="fa fa-trash"></i> Cancel Dispatch</a>
                    </td>
                </tr>
                <?php
            }
            //Payment
        } elseif ($mode == 'payment') {
            $t = 0;
            ?>
            <input type="hidden" name="company" value="<?php echo $this->request->firm ?>" >
            <?php
            foreach ($billed as $inv) {
                $bal = $inv->payment - $inv->paid;
                ?>
                <?php $t+= $inv->visits->unpaid_amount ?>
                <tr>
                    <td><?php echo $n+=1 ?></td>
                    <td>
                        <input onclick="updateAmount(<?php echo $bal ?>, <?php echo $inv->id; ?>)" id="pay_check<?php echo $inv->id; ?>" type="checkbox" name="invoice[]" value="<?php echo $inv->id; ?>">
                        <?php echo $inv->invoice_no ?>
                    </td>
                    <td><?php echo $inv->visits->patients->full_name ?></td>
                    <td><?php echo (new \Date($inv->visits->created_at))->format('dS M y') ?> </td>
                    <td><?php echo $inv->visits->patient_scheme->schemes->companies->name ?>:
                        <?php echo $inv->visits->patient_scheme->schemes->name ?></td>
                    <td><?php echo $inv->payment ?></td>
                    <td><?php echo $inv->paid ?></td>
                    <td>
                        <input type="text" size="5" name="amount<?php echo $inv->id ?>" id="amount<?php echo $inv->id ?>" value="<?php echo $inv->payment ?>">
                        <input type="hidden" name="patient" value="<?php echo $inv->visits->patients->id ?>">
                    </td>
                </tr>
                <?php
            }
            //Paid
        } elseif ($mode == 'paid') {
            $paid = InsuranceInvoice::where('visit', '>', 0)->whereHas('visits', function($query) {
                        $query->whereHas('patient_scheme', function($query) {
                            $query->whereHas('schemes', function ($query) {
                                $query->whereCompany($this->request->firm);
                            });
                        });
                    })
                    ->whereStatus(3)
                    ->get();

            foreach ($paid as $item) {
                ?>
                <tr>
                    <td><?php echo $item->visits->id ?></td>
                    <td><?php echo $item->visits->patients->full_name ?></td>
                    <td><?php echo (new \Date($item->created_at))->format('dS M y g:i a') ?></td>
                    <td><?php echo $item->visits->patient_scheme->schemes->companies->name ?></td>
                    <td><?php echo $item->visits->patient_scheme->schemes->name ?></td>
                    <td><?php echo $item->visits->unpaid_amount ?></td>
                    <td></td>
                </tr>
                <?php
            }
        } elseif ($mode == 'stmt_mode') {

            $thirty = \Carbon\Carbon::now()->subWeeks(4);
            $sixty = \Carbon\Carbon::now()->subWeeks(8);
            $ninety = \Carbon\Carbon::now()->subWeeks(12);

            $scurrent = 0;
            $sthirty1_to_60 = 0;
            $ssix1_to_90 = 0;
            $sninety_plus = 0;
            $sAMOUNT = 0;

            $payment = InsuranceInvoicePayment::whereHas('invoice', function($query) {
                        $query->whereHas('visits', function($query) {
                            $query->whereHas('patient_scheme', function($query) {
                                $query->whereHas('schemes', function ($query) {
                                    $query->whereCompany($this->request->firm);
                                });
                            });
                        });
                    })->get();

            foreach ($payment as $item) {
                $sAMOUNT+=$item->amount;
                if ($item->created_at >= $thirty) {
                    $scurrent+=$item->amount;
                } elseif ($item->created_at < $thirty && $item->created_at >= $sixty) {
                    $sthirty1_to_60+=$item->amount;
                } elseif ($item->created_at < $sixty && $item->created_at >= $ninety) {
                    $ssix1_to_90 += $item->amount;
                } else {
                    $sninety_plus += $item->amount;
                }
                ?>
                <tr>
                    <td><?php echo $n+=1 ?></td>
                    <td><?php echo $item->created_at ?></td>
                    <td><?php echo $item->invoice->invoice_no ?></td>
                    <td><?php echo $item->invoice->visits->patient_scheme->schemes->companies->name ?></td>
                    <td><?php echo $item->invoice->visits->patient_scheme->schemes->name ?></td>
                    <td><?php echo $item->invoice->visits->patients->full_name ?></td>
                    <td style="text-align: center"><?php echo $item->amount ?>
                        <i class="fa fa-sort-asc" style="color: green" aria-hidden="true"></i>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="7"><h3>Summary:</h3></td>
            </tr>
            <tr>
                <td></td>
                <td><strong>90+ Days Old</strong></td>
                <td><strong>61-90 Days Old</strong></td>
                <td><strong>31-60 Days Old</strong></td>
                <td><strong>Current</strong></td>
                <td><strong>Total</strong></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo$sninety_plus ?></td>
                <td><?php echo$ssix1_to_90 ?></td>
                <td><?php echo$sthirty1_to_60 ?></td>
                <td><?php echo$scurrent ?></td>
                <td colspan="2"><?php echo$sAMOUNT ?></td>
            </tr>
            <?php
        }//endif
    }

}
