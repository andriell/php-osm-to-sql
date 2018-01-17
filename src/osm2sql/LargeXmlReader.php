<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 11:00
 */

namespace osm2sql;


use osm2sql\entity\Bounds;
use osm2sql\entity\Entity;
use osm2sql\entity\EntityHaveId;
use osm2sql\entity\EntityHaveNode;
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

    private $stack;

    /** @var XmlReaderListener */
    private $listener;
    /** @var callable */
    private $progressListener;

    /**
     * LargeXmlReader constructor.
     */
    public function __construct()
    {
        $this->stack = new Stack();
    }

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
        $totalSize = filesize($this->filePath);
        $readSize = 0;
        while (!($isFinal = feof($fh))) {
            if (is_callable($this->progressListener)) {
                call_user_func($this->progressListener, $readSize, $totalSize);
            }
            $data = fread($fh, $this->bufferSize);
            xml_parse($parser, $data, $isFinal);
            $readSize += $this->bufferSize;
        }
        $this->listener->end();
        if (is_callable($this->progressListener)) {
            call_user_func($this->progressListener, $totalSize, $totalSize);
        }

        fclose($fh);
    }

    protected function startTag($parser, $name, $attr)
    {
        $entity = null;
        if ($name == 'NODE') {
            $entity = new Node($attr);
            $this->listener->node($entity);
        } elseif ($name == 'TAG') {
            if ($this->stack->top() instanceof Node) {
                $entity = new NodeTag($this->getParentId(), $attr);
                $this->listener->nodeTag($entity);
            } elseif ($this->stack->top() instanceof Way) {
                $entity = new WayTag($this->getParentId(), $attr);
                $this->listener->wayTag($entity);
            } elseif ($this->stack->top() instanceof Relation) {
                $entity = new RelationTag($this->getParentId(), $attr);
                $this->listener->relationTag($entity);
            }
        } elseif ($name == 'ND') {
            $entity = new WayNode($this->getParentId(), $attr);
            $entity->setSort($this->nextSort());
            $this->listener->wayNode($entity);
        } elseif ($name == 'MEMBER') {
            $entity = new RelationMember($this->getParentId(), $attr);
            $entity->setSort($this->nextSort());
            $this->listener->relationMember($entity);
        } elseif ($name == 'WAY') {
            $entity = new Way($attr);
            $this->listener->way($entity);
        } elseif ($name == 'RELATION') {
            $entity = new Relation($attr);
            $this->listener->relation($entity);
        } elseif ($name == 'OSM') {
            $entity = new Osm($attr);
            $this->listener->osm($entity);
        } elseif ($name == 'BOUNDS') {
            $entity = new Bounds($attr);
            $this->listener->bounds($entity);
        } else {
            $entity = new Entity($name, $attr);
        }

        $this->stack->push($entity);
    }

    private function getParentId()
    {
        $entity = $this->stack->top();
        if ($entity instanceof EntityHaveId) {
            return $entity->getId();
        }
        throw new Exception('Parent not have id');
    }

    private function nextSort()
    {
        $entity = $this->stack->top();
        if ($entity instanceof EntityHaveNode) {
            return $entity->nextSort();
        }
        throw new Exception('Parent not have nextSort');
    }

    protected function endTag($parser, $name)
    {
        $this->stack->pop();
    }

    /**
     * @return callable
     */
    public function getProgressListener()
    {
        return $this->progressListener;
    }

    /**
     * @param callable $progressListener
     */
    public function setProgressListener($progressListener)
    {
        $this->progressListener = $progressListener;
    }
}