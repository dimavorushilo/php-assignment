<?php

namespace Statistics\Dto;

/**
 * Interface StatisticsTo
 *
 * @package Statistics\Dto
 */
class StatisticsTo implements Extractable
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $value;

    /**
     * @var string
     */
    private $units;

    /**
     * @var string|null
     */
    private $label;

    /**
     * @var StatisticsTo[]
     */
    private $children = [];

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return float|null
     */
    public function getValue(): ?float
    {
        return $this->value;
    }

    /**
     * @return StatisticsTo[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param float $value
     *
     * @return $this
     */
    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param StatisticsTo $child
     *
     * @return $this
     */
    public function addChild(StatisticsTo $child): self
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUnits(): ?string
    {
        return $this->units;
    }

    /**
     * @param string|null $units
     *
     * @return $this
     */
    public function setUnits(?string $units): self
    {
        $this->units = $units;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string $label
     *
     * @return $this
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'name'  => $this->getName(),
            'label' => $this->getLabel(),
            'value' => $this->getValue(),
            'units' => $this->getUnits(),
            'children' => $this->childrenToArray()
        ];
    }

    private function childrenToArray(): ?array
    {
        if (count($this->getChildren())) {
            return array_map(static function (StatisticsTo $item) {
                return $item->toArray();
            }, $this->getChildren());
        }

        return null;
    }
}