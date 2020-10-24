<?php

declare(strict_types=1);

namespace WJS\Mutagen\Core\Delegation;

/**
 * @package WJS\Mutagen\Core\Delegation
 */
final class DelegatedMethod
{
    /**
     * @var string
     */
    private string $visibility = "";

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $returnType = "";

    /**
     * @param string $name
     * @param string $visibility
     * @param string $returnType
     */
    public function __construct(string $name, string $visibility, string $returnType)
    {
        $this->name = $name;
        $this->visibility = $visibility;
        $this->returnType = $returnType;
    }

    /**
     * @return string
     */
    public function getVisibility(): string
    {
        return $this->visibility;
    }

    /**
     * @param string $visibility
     * @return DelegatedMethod
     */
    public function setVisibility(string $visibility): DelegatedMethod
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return DelegatedMethod
     */
    public function setName(string $name): DelegatedMethod
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getReturnType(): string
    {
        return $this->returnType;
    }

    /**
     * @param string $returnType
     * @return DelegatedMethod
     */
    public function setReturnType(string $returnType): DelegatedMethod
    {
        $this->returnType = $returnType;

        return $this;
    }
}
