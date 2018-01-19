# Convert OSM XML file to SQL for MySQL


## Quick start

### Example 1
Convert OSM to SQL file
1. Create database tables from file resources/mysql.sql

2. Convert OSM to SQL inserts

        ini_set('memory_limit', '10M');
        // This class read big osm file
        $largeXmlReader = new LargeXmlReader();
        $largeXmlReader->setFilePath('/path/to/very/big/osm/xml/file.osm');
        
        // This class listens reader class and write data into file
        $listener = new FileReaderListener('/path/to/new/sql/file.sql');
        
        // Insert 500 rows in one operation
        $listener->setInsertSize(500);
        // Use INSERT IGNORE ...
        $listener->setInsertIgnore(true);
        $largeXmlReader->setListener($listener);
        $largeXmlReader->setProgressListener(function($readSize, $totalSize) use ($progress) {
            echo 'Completed ' . $readSize . ' Mb of ' . $totalSize . " Mb\n";
        });
        // Start parsing
        $largeXmlReader->parse();

3. Import sql file in to database

        mysql -u username -p database_name < /path/to/new/sql/file.sql

### Example 2
You can create your ReaderListener and write data directly to the database

    class DbReaderListener extends AbstractReaderListener
    {
        // ...
        protected function write($table, $sql)
        {
            $this->myDbConnection->query($sql);
        }
    }
    
    // ...
    $largeXmlReader->setListener(new DbReaderListener());
    // ...

### Example 3
Write data directly to the database and calculate building, highway, place tables

    ini_set('memory_limit', '100M');
    
    include 'vendor/autoload.php';
    
    $file = '/path/to/very/big/osm/xml/file.osm';
    
    // This class read big osm file
    $largeXmlReader = new \osm2sql\LargeXmlReader();
    
    // This class listens reader class and write data into database
    $listener = new \osm2sql\mysql\PdoDbBuilder('mysql:host=localhost;dbname=osm;port=3306', 'user', 'password');
    // Insert 100 rows in one operation
    $listener->setInsertSize(100);
    // Use INSERT IGNORE ...
    $listener->setInsertIgnore(true);
    $listener->setProgressListener(function ($size, $total) {
        echo 'Update DB ' . $size . ' row of ' . $total . " rows\n";
    });
    $listener->setExceptionListener(function($e, $sqlStr) {
        echo $sqlStr . "\n";
        echo $e . "\n";
    });
    // Delete all relations, way, node in database
    $listener->deleteRelation();
    $listener->deleteWay();
    $listener->deleteNode();
    
    $largeXmlReader->setFilePath($file);
    $largeXmlReader->setListener($listener);
    $largeXmlReader->setProgressListener(function($readSize, $totalSize) {
        echo  'Read file ' . $readSize . ' Mb of ' . $totalSize . " Mb\n";
    });
    // Insert new relations, way, node from osm file to database
    $largeXmlReader->parse();
    
    // Clear and calculate highway, building, place
    $listener->deleteHighway();
    $listener->calculateHighway();
    $listener->deleteBuilding();
    $listener->calculateBuilding();
    $listener->deletePlace();
    $listener->calculatePlace();
    
    echo 'Done';

You can create your DbBuilder class and use database connection in your framework

    class MyDbBuilder extends \osm2sql\mysql\AbstractDbBuilder
    {
        // ...
        protected function querySelect($sqlStr)
        {
            $rows = $this->myDbConnection->query($sqlStr);
            $r = [];
            foreach ($rows as $row) {
                $r[] = (array) $row;
            }
            return $r;
        }
    
        protected function queryUpdate($sqlStr)
        {
            return (int) $this->myDbConnection->exec($sqlStr);
        }
    }