<?php


class QueryBuilder
{
    protected $pdo;
    private $qs; //querystring $string
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->qs = "";
    }

    /**
     * @param $table string
     * @param $data array
     * insert $data in $table data base
     */
    public function create($table, $data) {
        $keys = implode(', ', array_keys($data));
        $tags = ':'. implode(', :', array_keys($data));

        $sql = "INSERT INTO {$table}({$keys}) VALUES ($tags)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
    }

    /**
     * @param $table string
     * @param $data array
     * @param $id string
     * update $table $data where id=$id
     */
    public function update($table, $data, $id) {
        $keys = array_keys($data);

        $string = '';

        foreach ($keys as $key) {
            $string .= $key . '=:' . $key.',';
        }

        $keys = rtrim($string, ',');

        $data['id'] = $id;

        $sql = "UPDATE {$table} SET $keys WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
    }

    /**
     * @param $table string
     * @param $id string
     * delete row where id=$id in $table data base
     */
    public function delete($table, $id) {
        $sql = "DELETE FROM post WHERE id=:id";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'id'=>$id
        ]);
    }

    /**
     * @param $table string
     * @return $this string
     * return select all rows from $table
     */
    public function selectAll($table)
    {
       $this->qs .= "SELECT * FROM {$table}".' ';
       return $this;
    }

    /**
     * @param array $column
     * @param $table string
     * @return $this string
     * return select $column from $table
     */
    public function select($column = [], $table)
    {
        $this->qs .= "SELECT $column FROM {$table}".' ';
        return $this;
    }

    /**
     * @param $column string
     * @param $sign string
     * @param null $condition string
     * @return $this string
     */
    public function where($column, $sign, $condition=null)
    {
        if (!$condition) {
            $this->qs .= "WHERE {$column}".' ';
        } else {$this->qs .= "WHERE {$column} {$sign} '{$condition}'".' ';}
        return $this;
    }

    /**
     * @param $column string
     * @param int $direction
     * @return $this string
     *
     */
    public function orderBy($column, $direction = 0)
    {
        if (!$direction) {
            $this->qs .= "ORDER BY {$column}";
        } else {$this->qs .= "ORDER BY {$column} DESC".' ';}
        return $this;
    }

    /**
     * @param $column string
     * @return $this string
     */
    public function groupBy($column)
    {
        $this->qs .= "GROUP BY {$column}".' '   ;
        return $this;
    }

    /**
     * @param $min string (date formate yyyy-mm-dd)
     * @param $max string (date formate yyyy-mm-dd)
     * @return $this string
     */
    public function betweendate($mindate, $maxdate)
    {
        $this->qs .= "BETWEEN CAST('{$mindate}' AS DATE) AND CAST('{$maxdate}' AS DATE)".' ';
        return $this;
    }

    /**
     * @param $minvalue string, int
     * @param $maxvalue string, int
     * @return $this
     */
    public function between($minvalue, $maxvalue)
    {
        $this->qs .= "BETWEEN {$minvalue} AND {$maxvalue}".' ';
        return $this;
    }

    public function andwhere($column, $condition=null)
    {
        if (!$condition) {
            $this->qs .= "AND {$column}".' ';
        } else {$this->qs .= "AND {$column}='{$condition}'".' ';}
        return $this;
    }

    public function orwhere($column, $condition=null)
    {
        if (!$condition) {
            $this->qs .= "OR {$column}".' ';
        } else {$this->qs .= "OR {$column}='{$condition}'".' ';}
        return $this;
    }

    public function limit($int)
    {
        $this->qs .= "LIMIT {$int}".' '   ;
        return $this;
    }

    public function like($condition)
    {
        $this->qs .= "LIKE '%{$condition}%'".' ';
        return $this;
    }

    public function join($table1, $column1, $table2, $column2)
    {
        $this->qs .= "INNER JOIN {$table2} ON {$table1}.{$column1}={$table2}.{$column2}".' ';
        return $this;
    }

    public function ljoin($table1, $column1, $table2, $column2)
    {
        $this->qs .= "LEFT JOIN {$table2} ON {$table1}.{$column1}={$table2}.{$column2}".' ';
        return $this;
    }

    public function rjoin($table1, $column1, $table2, $column2)
    {
        $this->qs .= "RIGHT JOIN {$table2} ON {$table1}.{$column1}={$table2}.{$column2}".' ';
        return $this;
    }

    public function union()
    {
        $this->qs .= "UNION".' ';
        return $this;
    }

    public function raw($string)
    {
        $this->qs .= "{$string}";
        return $this;
    }

    public function get() {
        $sql = $this->qs;
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    public function dd() {
        $sql = $this->qs;
        var_dump($sql);
        die;
           }
}