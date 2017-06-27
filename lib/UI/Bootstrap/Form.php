<?php

namespace Spell\UI\Bootstrap;

use Spell\UI\HTML\Tag;

/**
 * Bootstrap form Style
 *
 * @author moysesoliveira
 */
class Form extends \Spell\UI\Data\Form {

    public function warnings(): Tag
    {
        $element = Tag::mk('div')->addClass('callout callout-danger hide global-form-warnings')
            ->appendChild(Tag::mk('h4')->setContent('Warning!'))
            ->appendChild(Tag::mk('p'));
        $this->addChild('warnings', $element);
        return $element;
    }

    public function success(string $message): Tag
    {
        $element = Tag::mk('div')
            ->addClass('alert alert-success')
            ->appendChild(Tag::mk('p')->addClass('text-center')->setContent($message));
        $this->addChild('success', $element);
        return $element;
    }

}
