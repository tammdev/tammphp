<?php

namespace Tamm\Core\Utilities;

class Collection implements \Iterator
{
    private $items;
    private $position;
    private string $type;

    public function __construct(object $type)
    {
        $this->items = [];
        $this->position = 0;
        $this->type = $this->getFullyQualifiedName($type);
    }

    private function isInstanceOfType($object): bool
    {
        return $object instanceof $this->type;
    }

    private function getFullyQualifiedName($object): string
    {
        $reflection = new \ReflectionClass($object);
        return $reflection->getName();
    }

    public function add($item): void
    {
        if($this->isInstanceOfType($item)){
            $this->items[] = $item;
        }else{
            // TODO give a message and a code of this exception.
            throw new \Exception("",0); 
        }
    }

    public function remove($item): void
    {
        $index = array_search($item, $this->items);
        if ($index !== false) {
            array_splice($this->items, $index, 1);
        }
    }

    public function contains($item): bool
    {
        return in_array($item, $this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function get(int $index)
    {
        return $this->items[$index] ?? null;
    }

    public function clear(): void
    {
        $this->items = [];
        $this->position = 0;
    }

    // Iterator interface methods

    public function current() : mixed
    {
        return $this->items[$this->position];
    }

    public function key() : mixed
    {
        return $this->position;
    }

    public function next() : void
    {
        ++$this->position;
    }

    public function rewind() : void
    {
        $this->position = 0;
    }

    public function valid() : bool
    {
        return isset($this->items[$this->position]);
    }
}