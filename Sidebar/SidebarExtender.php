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

    protected $auth;

    public function __construct(\Ignite\Core\Contracts\Authentication $auth) {
        $this->auth = $auth;
    }

    public function extendWith(\Maatwebsite\Sidebar\Menu $menu) {
        $menu->group('Dashboard', function (Group $group) {
            $group->item('Finance', function (Item $item) {
                $item->weight(4);
                $item->icon('fa fa-money');
                $item->authorize($this->auth->hasAccess('finance.Access Finance Menu'));
                $item->item('Payments Overview', function (Item $item) {
                    $item->icon('fa fa fa-files-o');
                    $item->route('inventory.sales.receipts');
                    $item->authorize($this->auth->hasAccess('finance.Payments Overview'));
                });

                $item->item('Receive Payments', function (Item $item) {
                    $item->icon('fa fa-euro');
                    $item->route('finance.receive_payments');
                    $item->authorize($this->auth->hasAccess('finance.Receive Payments'));
                });
                $item->item('Workbench', function (Item $item) {
                    $item->icon('fa fa-coffee');
                    $item->route('finance.workbench');
                    $item->authorize($this->auth->hasAccess('finance.Workbench'));
                });


                $item->item('Billing', function(Item $item) {
                    $item->icon('fa fa-unsorted');

                    $item->item('Billing Workbench', function(Item $item) {
                        $item->icon('fa fa-yelp');
                        $item->route('finance.billing');
                        $item->authorize($this->auth->hasAccess('finance.Billing'));
                    });
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
            });
            $group->item('General Ledger', function (Item $item) {
                $item->weight(5);
                $item->icon('fa fa-credit-card-alt');
                $item->authorize($this->auth->hasAccess('finance.General Ledger.Access GL Menu'));
                $item->item('Account Types', function(Item $item) {
                    $item->icon('fa fa-industry');
                    $item->route('finance.gl.account_types');
                    $item->authorize($this->auth->hasAccess('finance.General Ledger.Manage Account Types'));
                });
                $item->item('Account Groups', function(Item $item) {
                    $item->icon('fa fa-toggle-up');
                    $item->route('finance.gl.account_groups');
                    $item->authorize($this->auth->hasAccess('finance.General Ledger.Manage Account Groups'));
                });
                $item->item('Accounts', function(Item $item) {
                    $item->icon('fa fa-spoon');
                    $item->route('finance.gl.accounts');
                    $item->authorize($this->auth->hasAccess('finance.General Ledger.Manage GL Accounts'));
                });


                $item->item('Banking', function(Item $item) {
                    $item->icon('fa fa-university');
                    $item->authorize($this->auth->hasAccess('finance.General Ledger.Manage Bankings'));
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
                    $item->authorize($this->auth->hasAccess('finance.General Ledger.Manage Petty Cash'));
                });

                $item->item('Payments(Invoice)', function(Item $item) {
                    $item->icon('fa fa-money');
                    $item->route('finance.gl.inv.payments');
                    $item->authorize($this->auth->hasAccess('finance.General Ledger.View Invoice Payments'));
                });
            });
        });
        return $menu;
    }

}
