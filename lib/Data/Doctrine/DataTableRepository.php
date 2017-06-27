<?php

namespace Spell\Data\Doctrine;

use Doctrine\ORM\QueryBuilder;

/**
 * DataTableRepository
 *
 * @author moysesoliveira
 */
abstract class DataTableRepository extends AbstractRepository {

    /**
     * Return an array with required information for populate "datatables"
     * 
     * @param array $request
     * @return array
     */
    public function loadData($request)
    {
        $results = new \stdClass();
        $qb = $this->queryBuilder($request);
        $results->data = $this->getAll($qb, $request);
        $total = $this->getTotal($qb);
        $results->recordsFiltered = $total;
        $results->recordsTotal = $results->recordsFiltered;
        return (array) $results;
    }

    /**
     * 
     */
    abstract public function queryBuilder(array $request): QueryBuilder;

    /**
     * 
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param array $request
     * @return array
     */
    public function getAll(\Doctrine\ORM\QueryBuilder $qb, $request)
    {
        $dtr = $this->dataTableRequest($request);
        list($start, $limit) = [(int) $dtr['start'], (int) $dtr['limit']];
        return $qb->setFirstResult($start)->setMaxResults($limit)->getQuery()->getResult();
    }

    /**
     * 
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @return int
     */
    public function getTotal(\Doctrine\ORM\QueryBuilder $qb)
    {
        $result = $qb->select(['count(t) as total'])->setFirstResult(0)->setMaxResults(1)->getQuery()->getOneOrNullResult();
        return !!$result ? current($result) : 0;
    }

    /**
     * Prepare query with params to statement query string and set \PDO::prepare
     *
     * @param string $query
     * @param array $params
     * @see \PDO::prepare()
     * @return \PDOStatement
     * @throws Exception
     */
    protected function exec($query, $params = [])
    {
        try {
            $prepare = $this->pdo->prepare($query);
            if(!$this->isAssoc($params)):
                $prepare->execute($params);
                return $prepare;
            endif;
            $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

            foreach($params as $k => $v)
                $this->bindStatementKeyValue($prepare, $k, $v);

            $prepare->execute();
            return $prepare;
        } catch(\PDOException $e) {
            echo $e->getMessage() . '<br/>' . $e->getTraceAsString() . '<br/>' . $e->getCode();
            die;
        }
    }

    /**
     * Get default parameters from request send by datatable plugin
     * 
     * @param array $request
     * @return array
     */
    protected function dataTableRequest($request)
    {
        $start = $request['start'];
        $limit = $request['length'];
        $order = current($request['order'])['column'];
        $dir = strtoupper(current($request['order'])['dir']) == 'ASC' ? 'ASC' : 'DESC';
        $search = $request['search']['value'];
        return compact('start', 'limit', 'order', 'dir', 'search');
    }

    /**
     * 
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEm()
    {
        return $this->_em;
    }

    protected function beginTransaction()
    {
        $this->_em->getConnection()->beginTransaction();
    }

    protected function commit()
    {
        $this->_em->getConnection()->commit();
    }

    protected function rollBack()
    {
        $this->_em->getConnection()->rollBack();
    }

    protected function execSQL(string $query, $params = [], $update = false)
    {
        $conn = $this->_em->getConnection();
        $pdo = $conn->getWrappedConnection();
        $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(\PDO::MYSQL_ATTR_DIRECT_QUERY, false);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        if($update)
            return $conn->executeUpdate($query, $params);
        
        $statement = $conn->prepare($query);
        foreach($params as $key => $value)
            $statement->bindParam(':' . $key, $value);

        $statement->execute($params);
        return $statement->fetchAll();
    }

}
