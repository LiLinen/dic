<?php

namespace LiLinen\Dic;

use LiLinen\Dic\Exception\ContainerException;
use LiLinen\Dic\Exception\NotFoundException;
use Psr\Container\ContainerInterface;
use Throwable;

class Container implements ContainerInterface
{
    /**
     * @var array
     */
    protected $dependencies = [];

    /**
     * @inheritDoc
     */
    public function get($id)
    {
        if ($this->has($id) === false) {
            throw new NotFoundException($id);
        }

        try {
            return $this->dependencies[$id]($this);
        } catch (Throwable $t) {
            throw new ContainerException($id);
        }
    }

    /**
     * @inheritDoc
     */
    public function has($id): bool
    {
        return isset($this->dependencies[$id]);
    }

    /**
     * @param string $key
     * @param callable $value
     *
     * @return $this
     */
    public function set(string $key, callable $value): self
    {
        $this->dependencies[$key] = $value;

        return $this;
    }
}
