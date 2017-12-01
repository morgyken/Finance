<?php

namespace Ignite\Finance\Console;

use Ignite\Finance\Repositories\Jambo;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class JambopayCron extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'finance:jambopay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process jambopay in background.';
    /**
     * @var Jambo
     */
    private $repository;

    /**
     * Create a new command instance.
     *
     * @param Jambo $jambo
     */
    public function __construct(Jambo $jambo)
    {
        parent::__construct();
        $this->repository = $jambo;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->repository->checkPayments();
    }
}
