# Convert OSM XML file to SQL for MySQL


## Quick start

### Example 1
Convert OSM to SQL file
1. Create database tables from file resources/mysql.sql

2. Convert OSM to SQL inserts

        ini_set('memory_limit', '10M');
        $largeXmlReader = new LargeXmlReader();
        $largeXmlReader->setFilePath('/path/to/very/big/osm/xml/file.osm');
        $listener = new FileReaderListener('/path/to/new/sql/file.sql');
        $listener->setInsertSize(500);
        $listener->setInsertIgnore(true);
        $largeXmlReader->setListener($listener);
        $largeXmlReader->setProgressListener(function($readSize, $totalSize) use ($progress) {
            echo 'Completed: ' . $readSize . ' / ' . $totalSize . " b\n";
        });
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
