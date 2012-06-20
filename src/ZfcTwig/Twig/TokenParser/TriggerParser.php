<?php
namespace ZfcTwig\Twig\TokenParser;
use ZfcTwig\Twig\Node\Trigger as TwiggerNode,
    Twig_TokenParser,
    Twig_Token,
    Twig_Node_Expression_Array,
    Twig_Node_Expression_Constant;

class TriggerParser extends Twig_TokenParser
{
    /**
     * Parses a token and returns a node.
     *
     * @param \Twig_Token $token A Twig_Token instance
     *
     * @return \Twig_NodeInterface A Twig_NodeInterface instance
     */
    function parse(Twig_Token $token)
    {
        $expr = $this->parser->getExpressionParser()->parseExpression();

        // target
        if ($this->parser->getStream()->test(Twig_Token::NAME_TYPE, 'on')) {
            $this->parser->getStream()->next();
            $target = $this->parser->getExpressionParser()->parseExpression();
        } else {
            $target = new Twig_Node_Expression_Constant(null, $token->getLine());
        }

        // attributes
        if ($this->parser->getStream()->test(Twig_Token::NAME_TYPE, 'with')) {
            $this->parser->getStream()->next();
            $attributes = $this->parser->getExpressionParser()->parseExpression();
        } else {
            $attributes = new Twig_Node_Expression_Array(array(), $token->getLine());
        }

        $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);
        return new TwiggerNode($expr, $target, $attributes, $token->getLine(), $this->getTag());
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string The tag name
     */
    function getTag()
    {
        return 'trigger';
    }

}