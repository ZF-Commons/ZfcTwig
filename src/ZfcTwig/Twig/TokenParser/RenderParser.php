<?php

namespace ZfcTwig\Twig\TokenParser;

use ZfcTwig\Twig\Node\Render as RenderNode;
use Twig_TokenParser;
use Twig_Token;
use Twig_Node_Expression_Array;

class RenderParser extends Twig_TokenParser
{
    /**
     * {@inheritDoc}
     */
    public function parse(Twig_Token $token)
    {
        $expr = $this->parser->getExpressionParser()->parseExpression();
        // attributes
        if ($this->parser->getStream()->test(Twig_Token::NAME_TYPE, 'with')) {
            $this->parser->getStream()->next();
            $attributes = $this->parser->getExpressionParser()->parseExpression();
        } else {
            $attributes = new Twig_Node_Expression_Array(array(), $token->getLine());
        }
        $options = new Twig_Node_Expression_Array(array(), $token->getLine());
        $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

        return new RenderNode($expr, $attributes, $options, $token->getLine(), $this->getTag());
    }

    /**
     * {@inheritDoc}
     */
    public function getTag()
    {
        return 'render';
    }
}