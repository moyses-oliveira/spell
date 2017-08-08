<?php

namespace Spell\UI\Data;

use Spell\UI\HTML\Tag;

/**
 * Description of Input
 *
 * @author moysesoliveira
 */
abstract class Input extends Field {

    /**
     * <input type="text" />
     */
    const TEXT = 'text';

    /**
     * <input type="password" />
     */
    const PASS = 'password';

    /**
     * <input type="email" />
     */
    const EMAIL = 'email';

    /**
     * 
     * @param string $name
     * @param string $type
     * @param type $label
     * @param string|null $value
     */
    public function __construct(string $name, string $type, $label = null, ?string $value = null)
    {
        $this->setName($name);
        $this->setField('input')->getField()->setAttributes(compact('name', 'value', 'type'));
        $uid = $this->uid();
        $nameid = str_replace(['[]', '[', ']'], [$uid, '-', '-'], $name);
        $this->box = Tag::mk('div');
        if($label)
            $this->setLabel($label);

        $this->setId(implode('-', ['input', $type, $nameid]));
        $this->box->appendChild($this->field);
    }

}
