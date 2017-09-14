<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 11:00
 */

namespace osm2sql;


use osm2sql\entity\Bounds;
use osm2sql\entity\Node;
use osm2sql\entity\NodeTag;
use osm2sql\entity\Osm;
use osm2sql\entity\Relation;
use osm2sql\entity\RelationMember;
use osm2sql\entity\RelationTag;
use osm2sql\entity\Way;
use osm2sql\entity\WayNode;
use osm2sql\entity\WayTag;

class LargeXmlReader
{
    private $filePath;
    private $bufferSize = 1048576;
    private $encoding = 'UTF-8';
    // Last opened tag
    private $openedTag = '';
    private $openedTagId = '';

    /** @var XmlReaderListener */
    private $listener;

    /**
     * @return mixed
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @param mixed $filePath
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return int
     */
    public function getBufferSize()
    {
        return $this->bufferSize;
    }

    /**
     * @param int $bufferSize
     */
    public function setBufferSize($bufferSize)
    {
        $this->bufferSize = $bufferSize;
    }

    /**
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * @param string $encoding
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    }

    /**
     * @return XmlReaderListener
     */
    public function getListener()
    {
        return $this->listener;
    }

    /**
     * @param XmlReaderListener $listener
     */
    public function setListener($listener)
    {
        $this->listener = $listener;
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
        $this->listener->end();

        fclose($fh);
    }

    protected function startTag($parser, $name, $attr)
    {
        if ($name == 'NODE') {
            $this->listener->node(new Node($attr));
        } elseif ($name == 'TAG') {
            if ($this->openedTag == 'NODE') {
                $this->listener->nodeTag(new NodeTag($this->openedTagId, $attr));
            } elseif ($this->openedTag == 'WAY') {
                $this->listener->wayTag(new WayTag($this->openedTagId, $attr));
            } elseif ($this->openedTag == 'RELATION') {
                $this->listener->relationTag(new RelationTag($this->openedTagId, $attr));
            }
        } elseif ($this->openedTag == 'ND') {
            $this->listener->wayNode(new WayNode($this->openedTagId, $attr));
        } elseif ($this->openedTag == 'MEMBER') {
            $this->listener->relationMember(new RelationMember($this->openedTagId, $attr));
        } elseif ($name == 'WAY') {
            $this->listener->way(new Way($attr));
        } elseif ($name == 'RELATION') {
            $this->listener->relation(new Relation($attr));
        } elseif ($name == 'OSM') {
            $this->listener->osm(new Osm($attr));
        } elseif ($name == 'BOUNDS') {
            $this->listener->bounds(new Bounds($attr));
        }

        $this->openedTag = $name;
        $this->openedTagId = isset($attr['ID']) ? $attr['ID'] : '';
    }

    protected function endTag($parser, $name)
    {
        $this->openedTag = '';
        $this->openedTagId = '';
    }
}