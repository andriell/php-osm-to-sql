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
    private $encoding = 'UTF-8';
    // Last opened tag
    private $openedTag = '';

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
        $parser = xml_parser_create($this->encoding);
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 1);
        xml_parser_set_option($parser, XML_OPTION_SKIP_TAGSTART, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 0);
        xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, $this->encoding);
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

    protected function startTag($parser, $name, $attr)
    {
        $this->openedTag = $name;
        if ($name == 'OSM' && isset($attr['VERSION']) && $attr['VERSION'] != '0.6') {
            throw new Exception('Unknown version "' . $attr['VERSION'] . '"');
        }
        $i = 0;
    }

    protected function endTag($parser, $name)
    {
        $i = 0;
    }
}