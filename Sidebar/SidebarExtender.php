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

use Ignite\Core\Contracts\Authentication;
use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;

/**
 * Description of SidebarExtender
 *
 * @author Samuel Dervis <samueldervis@gmail.com>
 */
class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender
{

    protected $auth;

    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function extendWith(Menu $menu)
    {
        $menu->group('Dashboard', function (Group $group) {
            $group->item('Finance', function (Item $item) {
                $item->weight(4);
                $item->icon('fa fa-money');
                $item->authorize($this->auth->hasAccess('finance.*'));

                $item->item('Receive Payment', function (Item $item) {
                    $item->icon('fa fa-euro');
                    $item->route('finance.evaluation.pay');
                });
                $item->item('Receive Payment (POS)', function (Item $item) {
                    $item->icon('fa fa-btc');
                    $item->route('finance.pos_cash');
                });
                $item->item('Patient Accounts', function (Item $item) {
                    $item->icon('fa fa-list');
                    $item->route('finance.account.list');
                });

                $item->item('Patient Invoices', function (Item $item) {
                    $item->icon('fa fa-folder-open');
                    $item->route('finance.evaluation.patient_invoices');
                });

                $item->item('Payment Summary', function (Item $item) {
                    $item->icon('fa fa-yelp');
                    $item->route('finance.evaluation.summary');
                });

                $item->item('Insurance Workbench', function (Item $item) {
                    $item->icon('fa fa-coffee');
                    $item->route('finance.evaluation.pending');
                });

                $item->item('Cash Bills', function (Item $item) {
                    $item->icon('fa fa-folder-open');
                    $item->route('finance.evaluation.cash_bills');
                });
            });
        });
        return $menu;
    }

}
