<?php

namespace ZfcTwig\Twig\TokenParser;

use Twig_ParserInterface;
use Twig_TokenParserBroker;
use ZfcTwig\Twig\Environment;
use ZfcTwig\Twig\TokenParser\ViewHelperParser;

class ViewHelperBroker extends Twig_TokenParserBroker
{
    /**
     * @var ViewHelperParser
     */
    protected $parser;

    /**
     * @var Environment
     */
    protected $environment;

    /**
     * @var ViewHelperParser
     */
    protected $viewHelperParser;

    public function __construct(Environment $environment, ViewHelperParser $viewHelperParser)
    {
        $this->environment      = $environment;
        $this->viewHelperParser = $viewHelperParser;
    }

    /**
     * Gets a TokenParser suitable for a tag.
     *
     * @param string $tag A tag name
     *
     * @return null|\Twig_TokenParserInterface A Twig_TokenParserInterface or null if no suitable TokenParser was found
     */
    public function getTokenParser($tag)
    {
        if ($this->environment->getFunction($tag)) {
            return $this->viewHelperParser;
        }
        return null;
    }

    /**
     * Calls Twig_TokenParserInterface::setParser on all parsers the implementation knows of.
     *
     * @param Twig_ParserInterface $parser A Twig_ParserInterface interface
     */
    public function setParser(Twig_ParserInterface $parser)
    {
        $this->viewHelperParser->setParser($parser);
        return $this;
    }

    /**
     * Gets the Twig_ParserInterface.
     *
     * @return null|ViewHelperParser A Twig_ParserInterface instance or null
     */
    public function getParser()
    {
        return $this->parser;
    }
}