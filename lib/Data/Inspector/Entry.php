<?php

namespace Spell\Data\Inspector;

use Spell\Data\Inspector\Rule\RuleInterface;

/**
 * Application other type data entry
 *
 * @author moysesoliveira
 */
class Entry implements EntryInterface {

    /**
     *
     * @var string 
     */
    protected $name = '';

    /**
     *
     * @var array 
     */
    protected $rules = [];

    /**
     *
     * @var string|null 
     */
    private $value = null;

    /**
     *
     * @var string|null 
     */
    private $error = null;

    /**
     *
     * @var bool 
     */
    private $required = false;

    /**
     * 
     * @param string $name
     * @param int $length
     * @param string|null $value
     */
    public function __construct(string $name, int $length, ?string $value = null)
    {
        $this->setName($name)->setValue($value)->length($length);
    }

    /**
     * 
     * @param string $name
     */
    public function setName(string $name): EntryInterface
    {
        $this->name = $name;
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * 
     * @param string|null $value
     * @return \Spell\Data\Inspector\EntryInterface
     */
    public function setValue(?string $value): EntryInterface
    {
        $this->value = $value;
        return $this;
    }

    /**
     * 
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * 
     * @param array $rules
     * @return $this
     */
    public function setRules(array $rules): EntryInterface
    {
        foreach($rules as $rule)
            $this->addRule($rule);

        return $this;
    }

    /**
     * 
     * @param RuleInterface $rule
     * @return \Spell\Data\Inspector\EntryInterface
     */
    public function addRule(RuleInterface $rule): EntryInterface
    {
        if(!in_array($rule, $this->rules))
            $this->rules[] = $rule;

        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * Entry max length
     * 
     * @param int $length
     * @return \Spell\Data\Inspector\EntryInterface
     */
    public function length(int $length): EntryInterface
    {
        $this->addRule(new Rule\Length($length));
        return $this;
    }

    /**
     * Is required
     * 
     * @return \Spell\Data\Inspector\EntryInterface
     */
    public function isRequired(): EntryInterface
    {
        $this->required = true;
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function hasError(): bool
    {
        return !empty($this->error);
    }

    /**
     * 
     * @return string
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * 
     * @param string $error
     */
    public function setError(string $error)
    {
        $this->error = $error;
    }

    /**
     * 
     * @return bool
     */
    public function validate(): bool
    {
        $requiredRule = new Rule\Required();
        
        // Ignore validate if is not required
        if(!$requiredRule->validate($this->getValue())):
            if($this->required)
                $this->setError($requiredRule->getError());
                
            return !$this->required;
        endif;

        foreach($this->getRules() as $rule)
            if(!$this->checkRule($rule))
                return false;

        return true;
    }

    /**
     * 
     * @param RuleInterface $rule
     */
    public function checkRule(RuleInterface $rule): bool
    {
        if($rule->validate($this->getValue()))
            return true;

        $this->setError($rule->getError());
        return false;
    }

}
