<?php

namespace ZfcTwig\Twig\TokenParser;

use Twig_NodeInterface;
use Twig_TokenParser;
use Twig_Token;

class ViewHelper extends Twig_TokenParser
{
    /**
     * Parses a token and returns a node.
     *
     * @param Twig_Token $token A Twig_Token instance
     *
     * @return Twig_NodeInterface A Twig_NodeInterface instance
     */
    function parse(Twig_Token $token)
    {
        // TODO: Implement parse() method.
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string The tag name
     */
    function getTag()
    {
        return 'zf';
    }
}