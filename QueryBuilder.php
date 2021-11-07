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

    public function create($table, $data) {
        $keys = implode(', ', array_keys($data));
        $tags = ':'. implode(', :', array_keys($data));

        $sql = "INSERT INTO {$table}({$keys}) VALUES ($tags)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
    }

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

    public function delete($table, $id) {
        $sql = "DELETE FROM post WHERE id=:id";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'id'=>$id
        ]);
    }

    public function selectAll($table)
    {
       $this->qs .= "SELECT * FROM {$table}".' ';
       return $this;
    }

    public function select($column = [], $table)
    {
        $this->qs .= "SELECT $column FROM {$table}".' ';
        return $this;
    }

    public function where($column, $sign, $condition=null)
    {
        if (!$condition) {
            $this->qs .= "WHERE {$column}".' ';
        } else {$this->qs .= "WHERE {$column} {$sign} '{$condition}'".' ';}
        return $this;
    }

    public function orderBy($column, $direction = 0)
    {
        if (!$direction) {
            $this->qs .= "ORDER BY {$column}";
        } else {$this->qs .= "ORDER BY {$column} DESC".' ';}
        return $this;
    }

    public function groupBy($column)
    {
        $this->qs .= "GROUP BY {$column}".' '   ;
        return $this;
    }

    public function between($min, $max)
    {
        $this->qs .= "BETWEEN CAST('{$min}' AS DATE) AND CAST('{$max}' AS DATE);".' '   ;
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

//    public function getOne($table, $id) {
//    $sql = "SELECT * FROM post WHERE id=:id";
//
//    $statement = $this->pdo->prepare($sql);
//    $statement->bindValue(':id', $id);
//    $statement->execute();
//    $result = $statement->fetch(PDO::FETCH_ASSOC);
//    return $result;
//}

//    public function getAll ($table) {
//        $sql = "SELECT * FROM {$table}";
//        $statement = $this->pdo->prepare($sql);
//        $statement->execute();
//        return $statement->fetchAll(PDO::FETCH_ASSOC);
//    }