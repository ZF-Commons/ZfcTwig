<?php

namespace ZfcTwig\Twig\TokenParser;

use Twig_Token;
use Twig_TokenParser;
use ZfcTwig\Twig\Node\ViewHelper;
use ZfcTwig\Twig\Node\ViewHelperExpression;

class ViewHelperParser extends Twig_TokenParser
{
    /**
     * {@inheritDoc}
     */
    public function parse(Twig_Token $token)
    {
        $arguments = $this->parser->getExpressionParser()->parseArguments();

        $exprNode = new ViewHelperExpression(
            array('arguments' => $arguments),
            array('helperName' => $token->getValue()),
            $token->getLine(), $this->getTag()
        );

        $exprNode = $this->parser->getExpressionParser()->parsePostfixExpression($exprNode);

        $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

        return new ViewHelper(array('expression' => $exprNode), array(), $token->getLine(), $this->getTag());
    }

    /**
     * {@inheritDoc}
     */
    public function getTag()
    {
        return 'ZendViewHelper';
    }
}