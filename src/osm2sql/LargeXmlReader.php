<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 11:00
 */

namespace osm2sql;


class LargeXmlReader
{
    private $filePath;
    private $bufferSize = 1048576;

    /**
     * LargeXmlReader constructor.
     * @param $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }


    public function parse()
    {
        $parser = xml_parser_create('UTF-8');
        xml_set_object($parser, $this);
        xml_set_element_handler($parser, 'startTag', 'endTag');

        $fh = fopen($this->filePath, 'r');
        if (empty($fh)) {
            throw new Exception('Can not open file "' . $this->filePath . '"');
        }

        while (!($isFinal = feof($fh))) {
            $data = fread($fh, $this->bufferSize);
            xml_parse($parser, $data, $isFinal);
        }

        fclose($fh);
    }

    protected function startTag($parser, $name, $attribs)
    {
        if ($name == 'OSM' && isset($attribs['VERSION']) && $attribs['VERSION'] != '0.6') {
            throw new Exception('Unknown version "' . $attribs['VERSION'] . '"');
        }
        $i = 0;
    }

    protected function endTag($parser, $name)
    {
        $i = 0;
    }
}