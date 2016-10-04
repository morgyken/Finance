<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Finance\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;

/**
 * Description of SidebarExtender
 *
 * @author Samuel Dervis <samueldervis@gmail.com>
 */
class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender {

    public function extendWith(\Maatwebsite\Sidebar\Menu $menu) {
        $menu->group('Dashboard', function (Group $group) {
            $group->item('Finance', function (Item $item) {
                $item->weight(4);
                $item->icon('fa fa-money');
                /*
                 * @todo Patients account not ready
                 *
                 */
                /* $item->item('Patient Accounts', function (Item $item) {
                  $item->icon('fa fa-usd');
                  $item->route('finance.patient_accounts');
                  }); */


                $item->item('Receive Payments', function (Item $item) {
                    $item->icon('fa fa-euro');
                    $item->route('finance.receive_payments');
                });
                $item->item('Workbench', function (Item $item) {
                    $item->icon('fa fa-coffee');
                    $item->route('finance.workbench');
                });

                /*
                 * @todo  Add support for insurance
                 */
                /* $item->item('Insurance', function (Item $item) {
                  $item->icon('fa fa-institution');
                  $item->route('finance.insurance');
                  });
                  $item->item('Deposits', function (Item $item) {
                  $item->icon('fa fa-gbp');
                  $item->route('finance.deposits');
                  }); */
                $item->item('General Ledger', function (Item $item) {
                    $item->weight(5);
                    $item->icon('fa fa-credit-card-alt');

                    $item->item('Account Types', function(Item $item) {
                        $item->icon('fa fa-industry');
                        $item->route('finance.gl.account_types');
                    });
                    $item->item('Account Groups', function(Item $item) {
                        $item->icon('fa fa-toggle-up');
                        $item->route('finance.gl.account_groups');
                    });
                    $item->item('Accounts', function(Item $item) {
                        $item->icon('fa fa-spoon');
                        $item->route('finance.gl.accounts');
                    });


                    $item->item('Banking', function(Item $item) {
                        $item->icon('fa fa-university');

                        $item->item('Banking', function(Item $item) {
                            $item->icon('fa fa-money');
                            $item->route('finance.gl.banking');
                        });

                        $item->item('Bank Accounts', function(Item $item) {
                            $item->icon('fa fa-credit-card');
                            $item->route('finance.gl.bank.accounts');
                        });

                        $item->item('Banks', function(Item $item) {
                            $item->icon('fa fa-bitcoin');
                            $item->route('finance.gl.banks');
                        });
                    });

                    $item->item('Petty Cash', function(Item $item) {
                        $item->icon('fa fa-paypal');
                        $item->route('finance.gl.pettycash');
                    });

                    $item->item('Payments(Invoice)', function(Item $item) {
                        $item->icon('fa fa-money');
                        $item->route('finance.gl.inv.payments');
                    });
                });
            });
        });
        return $menu;
    }

}
