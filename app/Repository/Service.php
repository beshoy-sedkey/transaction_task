<?php

namespace App\Repository;

abstract class Service
{
    #region [properties]
    /**
     * model property on class instances
     * @var object
     */
    protected $model;
    /**
     * set return columns name
     * @var array
     */
    protected $columns = array('*');
    #endregion

    #region [abstract functions]
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract function setModel(): void;
    #endregion


    #region [logic]
    /**
     * Repository constructor.
     * Constructor to bind model to repo
     *
     * @param Model $model
     */
    public function __construct()
    {
        $this->setModel();
    }
    /**
     * Create a new record
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * insert multiple rows from a single query.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function insert(array $data)
    {
        return $this->model->insert($data);
    }

    /**
     * Update a record
     *
     * @param array $data
     * @param $id
     *
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id")
    {
        return $this->model->where($attribute, $id)->update($data);
    }

    /**
     * Delete a record
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * Get record by it’s primary key
     *
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = null)
    {
        return $this->model->find($id);
    }

    /**
     * check and set data in columus array
     *
     * @param array $columns
     *
     * @return array
     */
    private function setColumns($columns)
    {
        if ($columns == null)
            return $columns = $this->columns;
        else
            return $columns;
    }
}
