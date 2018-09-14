<?php

namespace MichaelDouglas\MService\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

/**
 * Helper para abstração das transações do framework
 * Class TransactionHelper
 * @package App\Http
 */
class TransactionHelper
{
    private $connection;

    public function begin($model = null)
    {
        $this->setConnection($model);
        DB::connection($this->connection)->beginTransaction();
    }

    public function commit($model = null)
    {
        $this->setConnection($model);
        DB::connection($this->connection)->commit();
    }

    public function rollback($model = null)
    {
        $this->setConnection($model);
        DB::connection($this->connection)->rollback();
    }

    /**
     * quando se trabalha com um Model onde a conexão é feita com outro banco é preciso configurar a transaction
     * para funcionar com a outra conexao
     * @param $model
     */
    private function setConnection($model)
    {
        if($model && is_string($model))
            $model = app()->make($model);

        if($model instanceof \Illuminate\Database\Eloquent\Builder)
            $model = $model->getModel();

        $this->connection = $model != null ? $model->getConnectionName() : Config::get('database.default');
    }



}