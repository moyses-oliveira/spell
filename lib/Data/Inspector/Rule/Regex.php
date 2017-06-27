<?php

namespace Spell\Data\Inspector\Rule;

/**
 * Regular Expression Rule
 *
 * @author moysesoliveira
 */
class Regex extends AbstractRule {

    /**
     *  Regular Expression
     * 
     * @var string 
     */
    private $expression = null;

    public function __construct(string $error, string $expression)
    {
        $this->setError($error);
        $this->expression = $expression;
    }

    /**
     * validate expression
     * 
     * @param string $entry
     * @return bool
     */
    public function validate(?string $entry): bool
    {
        return $this->regex($entry, $this->expression);
    }

}
