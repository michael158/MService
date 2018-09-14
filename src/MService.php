<?php

namespace MichaelDouglas\MService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use MichaelDouglas\MService\MInterface\MServiceInterface;

abstract class MService implements MServiceInterface
{

    protected $model;
    protected $validators;
    protected $paginatorLimit = 10;
    protected $toSelectParams = ['id', 'name'];
    protected $order = ['id', 'DESC'];
    protected $searchFields;
    protected $request;
    protected $where;
    protected $foreignIntegrity;
    private   $ignoreValidator = false;
    protected $id;

    /**
     * Inicializa a validação de campos para o service
     * MService constructor.
     */
    public function __construct()
    {
        $this->validators();
        $this->searchFields();
        $this->request = Request::capture();
    }

    public function index($filters = null)
    {
        $query = $this->model->orderBy($this->order[0], $this->order[1]);

        $this->prepareFilters($filters);
        $this->applyFilters($filters, $query);

        $paginator = $query->paginate($this->paginatorLimit);
        $paginator->appends($this->request->query->all());

        return $paginator;
    }

    public function show($id)
    {
        try {
            $data = $this->model->find($id);
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
        return $data;
    }

    public function create(array $data)
    {
        Transaction()->begin($this->model);
        try {
            $this->checkValidators($data);
            $data = $this->model->create($data);

        } catch (\Exception $e) {
            Transaction()->rollback($this->model);
            throw $e;
        }
        Transaction()->commit($this->model);

        return $data;
    }

    public function update($id, array $data)
    {
        $this->id = $id;
        $this->updateValidators();

        Transaction()->begin($this->model);
        try {
            $this->checkValidators($data);
            $service = $this->model->find($id);
            $service->update($data);
            $update = $service->save();
        } catch (\Exception $e) {
            Transaction()->rollback($this->model);
            throw $e;
        }
        Transaction()->commit($this->model);

        return $service;
    }

    public function delete($id)
    {
        Transaction()->begin($this->model);
        try {
            $service = $this->model->find($id);
            $service->delete();
        } catch (\Exception $e) {
            Transaction()->rollback($this->model);
            throw $e;
        }

        Transaction()->commit($this->model);

        return $service;
    }

    /**
     * Retorna todos os registros
     * @return mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    public function toSelect()
    {
        return $this->model->select($this->toSelectParams)->get();
    }


    protected function checkValidators($data)
    {
        if (!$this->ignoreValidator) {
            $validator = Validator::make($data, $this->validators);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        }

        return true;
    }

    public function ignoreValidator()
    {
        $this->ignoreValidator = true;
    }

    public function getForeignIntegrity()
    {
        return $this->foreignIntegrity;
    }

    public function getModel()
    {
        return $this->model;
    }

    protected function prepareFilters(&$filters)
    {

    }

    /**
     * Aplica filtros em uma query
     * @param $filters
     * @param $query
     */
    protected function applyFilters($filters, &$query)
    {
        $this->beforeFilters($filters, $query);
        if ($filters) {
            if (isset($filters['where']))
                $this->applyWhere($filters['where'], $query);

            if (isset($filters['search']))
                $this->applySearch($filters['search'], $query);

        }
        $this->customFilters($filters, $query);
    }

    protected function applySearch($keyword, &$query)
    {
        if ($this->searchFields) {
            $query->where(function ($query) use ($keyword) {
                foreach ($this->searchFields as $key => $field) {
                    $query->orWhere($field, 'LIKE', "%{$keyword}%");
                }
            });
        }
    }

    /**
     * Metodo chamado para se aplicar filtros antes dos filtros padroes
     * @param $filters
     * @param $query
     */
    protected function beforeFilters($filters, &$query)
    {

    }

    /**
     * Metodo criado para adicionar filtros personalizados
     * @param $filters
     */
    protected function customFilters($filters, &$query)
    {

    }

    protected function searchFields()
    {

    }

    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * Aplica filtro do tipo where
     * @param $where
     * @param $query
     */
    private function applyWhere($where, &$query)
    {
        if (isMultidimensionalArray($where)) {
            foreach ($where as $condition) {
                $key = $condition[0];
                $operator = '=';
                $value = $condition[1];

                if(count($condition) == 3){
                    $operator = $condition[1];
                    $value = $condition[2];
                }

                if (!is_null($value))
                    $query->where($key, $operator,$value);
            }
        } else {
            $key = $where[0];
            $operator = '=';
            $value = $where[1];

            if(count($where) == 3){
                $operator = $where[1];
                $value = $where[2];
            }

            if (!is_null($value))
                $query->where($key, $operator ,$value);
        }
    }


}