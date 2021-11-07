# qb - Query Builder

# Description
simple Query Builder library for create main data base query's mySQL (based on PDO)

# Install
Step 1. Copy file from this reposytory in your project folder (don't rename file)
<br>
Step 2. In config.php make preferences for connect data base.
<br>
Step 3. In your index file or where your will be use qb your must connect file start.php. To do this, specify the full path to the start.php file.
It is recommended to put the full path in a variable for easier query building. Example: $db = include  '/../example/example/start.php';

# Examples
$db->selectAll('users')->get(); equals "SELECT * FROM users;"

<table>
  <th>method</th>
  <th>description</th>
  <th>example</th>
    <tr>
    <td>public function create($table, $data)</td>
    <td>$table(string) - table name,
        <br>$data(array) - data for insert to data base</td>
    <td>$db->create('users', ['name'=>'John', 'email'=>'John@example.com'])</td>
  </tr>
    <tr>
        <td>public function update($table, $data, $id)</td>
        <td>$table(string) - table name,
            <br>$data(array) - data for insert to data base
            <br>$id(int) - id number of the record to be updated
        </td>
        <td>$db->update('users', ['name'=>'John', 'email'=>'John@example.com'], 2)</td>
    </tr>
    <tr>
        <td>public function delete($table, $id)</td>
        <td>$table(string) - table name,
            <br>$id(int) - id number of the record to be deleted
        </td>
        <td>$db->delete('users', 2)</td>
    </tr>
    <tr>
        <td>public function selectAll($table)</td>
        <td>$table(string) - table name
            <br>This method returns all records from the specified table. At the end of the chain, you must pass the get method
        </td>
        <td>$db->selectAll('users')->get()</td>
    </tr>
    <tr>
        <td>public function select($column = [], $table)</td>
        <td>$column(array) - the columns of the table to be displayed
            <br>$table(string) - table name
            <br>This method returns the specified columns from the table
        </td>
        <td>$db->select('name, email','users')->get()</td>
    </tr>
    <tr>
        <td>public function where($column, $sign=null, $condition=null)</td>
        <td>$column(string) - the columns of the table
            <br>$sign(string) - any sign =, <, > etc., optional parameter
            <br>$condition(string, int) - any condition for filtering results, optional parameter
            <br>this method is used to filter the results called in the chain after the select() or selectAll() method
        </td>
        <td>$db->select('name, email','users')->where('id'=1)->get()</td>
    </tr>
    <tr>
        <td>public function andwhere($column, $sign=null, $condition=null)</td>
        <td>$column(string) - the columns of the table
            <br>$sign(string) - any sign =, <, > etc., optional parameter
            <br>$condition(string, int) - any condition for filtering results, optional parameter
            <br>this method is used to filter the results called in the chain after the where() method
        </td>
        <td>$db->select('name, email','users')->where('id'=1)->andwhere('name', '=', 'John')->get()</td>
    </tr>
    <tr>
        <td>public function orwhere($column, $sign=null, $condition=null)</td>
        <td>$column(string) - the columns of the table
            <br>$sign(string) - any sign =, <, > etc., optional parameter
            <br>$condition(string, int) - any condition for filtering results, optional parameter
            <br>this method is used to filter the results called in the chain after the where() method
        </td>
        <td>$db->select('name, email','users')->where('id'=1)->orwhere('name', '=', 'John')->get()</td>
    </tr>
    <tr>
        <td>public function orderBy($column, $direction = 0)</td>
        <td>$column(string) - the columns of the table
            <br>$direction(int) - optional parameter, if the parameter is not passed the sorting will occur in ascending order, if 1 is passed, sorting will occur in descending order
            <br>this method sorts the query results by the specified parameters
        </td>
        <td>$db->select('name, email','users')->orderBy('name', 1)->get()</td>
    </tr>
    <tr>
        <td>public function groupBy($column)</td>
        <td>$column(string) - the columns of the table
            <br>this method groups query results by specified parameters, used in chaining with where() method
        </td>
        <td>$db->select('name, age','users')->where('age', '=', 20)->groupBy('name')->get()</td>
    </tr>
    <tr>
        <td>public function groupBy($column)</td>
        <td>$column(string) - the columns of the table
            <br>this method groups query results by specified parameters, used in chaining with where() method
        </td>
        <td>$db->select('product','order_details')->where('category', '=', 'produce')->groupBy('product')->get()</td>
    </tr>
    <tr>
        <td>public function between($minvalue, $maxvalue)</td>
        <td>$minvalue(string, int) - first string or minimal integer value
        <br>$maxvalue(string, int) - second string or maximal integer value
            <br>this method used to get values within a range, used in chaining with where() method
        </td>
        <td>$db->select('product, price','order_details')->where('price')->between(100, 200)->get()</td>
    </tr>
    <tr>
        <td>public function betweendate($mindate, $maxdate)</td>
        <td>$mindate(string) - minimal date value format yyyy-mm-dd
        <br>$maxdate(string, int) - maximal date value format yyyy-mm-dd
            <br>this method used to get values within a range, used in chaining with where() method
        </td>
        <td>$db->select('product, price, date_sale','order_details')->where('date_sale')->between('2021-01-01', '2021-12-31')->get()</td>
    </tr>
    <tr>
        <td>public function limit($int)</td>
        <td>$int(int) - integer value for the limit
            <br>This method is used to retrieve a specified number of records from a table in a chain with the select () or select () method
        </td>
        <td>$db->select('product, price, date_sale','order_details')->limit(10)->get()</td>
    </tr>
    <tr>
        <td>public function like($condition)</td>
        <td>$condition(string) - any string value
            <br>This method allows you to use templates in the select() or selectAll() method chain along with the where() methods
        </td>
        <td>$db->select('name, age','users')->where('name')->like('Jo')->get()
            <br>as a result, all names including the specified letters will be displayed
        </td>
    </tr>
    <tr>
        <td>public function join($table1, $column1, $table2, $column2)</td>
        <td>$table1(string) - name first table<br>
            $column1(string) - name first column<br>
            $table2(string) - name second table<br>
            $column2(string) - name second column<br>
            <br>This method returns all rows from multiple tables where join conditions are met
        </td>
        <td>$db->select('name, age, orders.order_date','users')->join('users', 'id', 'orders', 'users_id')->get()
        </td>
    </tr>
    <tr>
        <td>public function ljoin($table1, $column1, $table2, $column2)</td>
        <td>$table1(string) - name first table<br>
            $column1(string) - name first column<br>
            $table2(string) - name second table<br>
            $column2(string) - name second column<br>
            <br>This method returns all rows from the first table, and only those rows from another table where the fields to be joined are equal
        </td>
        <td>$db->select('name, age, orders.order_date','users')->join('users', 'id', 'orders', 'users_id')->get()
        </td>
    </tr>
    <tr>
        <td>public function rjoin($table1, $column1, $table2, $column2)</td>
        <td>$table1(string) - name first table<br>
            $column1(string) - name first column<br>
            $table2(string) - name second table<br>
            $column2(string) - name second column<br>
            <br>This method returns all rows from the second table, and only those rows from the first table where the fields to be joined are equal
        </td>
        <td>$db->select('name, age, orders.order_date','users')->join('users', 'id', 'orders', 'users_id')->get()
        </td>
    </tr>
    <tr>
        <td>public function union()</td>
        <td>
            <br>This method is used to combine result sets of 2 or more select () methods. The number of columns in the first and second select() methods must match
        </td>
        <td>$db->select('name, age', 'users')->union->select('date_sale', 'product', 'orders')->get()
        </td>
    </tr>
    <tr>
    <td>public function raw($string)</td>
    <td>
        <br>This method accepts any request as a string
    </td>
    <td>$db->raw('SELECT department, MIN(salary) AS "Lowest salary"
        FROM employees
        GROUP BY department
        HAVING MIN(salary) < 50000')->union->select('date_sale', 'product', 'orders')->get()
    </td>
</tr>
    <tr>
        <td>public function get()</td>
        <td>This is the main method that should end any chain of request with the select() or selectall() method</td>
        <td>$db->select('name, email','users')->get()</td>
    </tr>
</table>
