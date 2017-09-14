# Convert OSM XML file to SQL for MySQL


## Quick start

### Example 1
Convert OSM to SQL file
1. Create database tables from file resources/mysql.sql

2. Convert OSM to SQL inserts

        $largeXmlReader = new LargeXmlReader();
        $largeXmlReader->setFilePath('/path/to/osm/xml/file.osm');
        $listener = new FileReaderListener('/path/to/new/sql/file.sql');
        $listener->setInsertSize(500);
        $listener->setInsertIgnore(true);
        $largeXmlReader->setListener($listener);
        $largeXmlReader->parse();

3. Import sql file in to database

        mysql -u username -p database_name < /path/to/new/sql/file.sql

