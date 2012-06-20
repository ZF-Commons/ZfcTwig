<?php
namespace ZfcTwig\Twig\TokenParser;
use ZfcTwig\Twig\Node\Render as RenderNode,
    Twig_TokenParser,
    Twig_Token,
    Twig_Node_Expression_Array;

class RenderParser extends Twig_TokenParser
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
     * Gets the tag name associated with this token parser.
     *
     * @return string The tag name
     */
    function getTag()
    {
        return 'render';
    }

}