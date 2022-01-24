<?php

namespace JBBCode;

require_once 'CodeDefinition.php';
require_once 'CodeDefinitionBuilder.php';
require_once 'CodeDefinitionSet.php';
require_once 'validators/CssColorValidator.php';
require_once 'validators/UrlValidator.php';

/**
 * Provides a default set of common bbcode definitions.
 *
 * @author jbowens
 */
class DefaultCodeDefinitionSet implements CodeDefinitionSet
{

    /* The default code definitions in this set. */
    protected $definitions = array();

    /**
     * Constructs the default code definitions.
     */
    public function __construct()
    {
        /* [b] bold tag */
        $builder = new CodeDefinitionBuilder('b', '<strong>{param}</strong>');
        array_push($this->definitions, $builder->build());

        /* [i] italics tag */
        $builder = new CodeDefinitionBuilder('i', '<em>{param}</em>');
        array_push($this->definitions, $builder->build());

        /* [u] italics tag */
        $builder = new CodeDefinitionBuilder('u', '<u>{param}</u>');
        array_push($this->definitions, $builder->build());

        /* [s] strikethrough */
		$builder = new CodeDefinitionBuilder('s', '<strike>{param}</strike>');
        array_push($this->definitions, $builder->build());
        $urlValidator = new \JBBCode\validators\UrlValidator();

        /* [url] link tag */
        $builder = new CodeDefinitionBuilder('url', '<a href="{param}">{param}</a>');
        $builder->setParseContent(false)->setBodyValidator($urlValidator);
        array_push($this->definitions, $builder->build());

        /* [url=http://example.com] link tag */
        $builder = new CodeDefinitionBuilder('url', '<a href="{option}">{param}</a>');
        $builder->setUseOption(true)->setParseContent(true)->setOptionValidator($urlValidator);
        array_push($this->definitions, $builder->build());

        /* [img] image tag */
        $builder = new CodeDefinitionBuilder('img', '<img src="{param}" />');
        $builder->setUseOption(false)->setParseContent(false)->setBodyValidator($urlValidator);
        array_push($this->definitions, $builder->build());

        /* [img=alt text] image tag */
        $builder = new CodeDefinitionBuilder('img', '<img src="{param}" alt="{option}" />');
        $builder->setUseOption(true);
        array_push($this->definitions, $builder->build());

        /* [color] color tag */
        $builder = new CodeDefinitionBuilder('color', '<span style="color: {option}">{param}</span>');
        $builder->setUseOption(true)->setOptionValidator(new \JBBCode\validators\CssColorValidator());
        array_push($this->definitions, $builder->build());
        
        /* [size] tag*/
		$builder = new CodeDefinitionBuilder('size', '<span style="font-size: {option}pt">{param}</span>');
		$builder->setUseOption(true);
		array_push($this->definitions, $builder->build());
		
		/* [code] tag */
		$builder = new CodeDefinitionBuilder('code', '{param}');
		$builder->setUseOption(true);
		$builder->setSyntax(true);
		array_push($this->definitions, $builder->build());
		
		/* [quote] tag */
		$builder = new CodeDefinitionBuilder('quote', '<blockquote cite="{option}">{param}</blockquote>');
		$builder->setUseOption(true);
		array_push($this->definitions, $builder->build());
		
		/* [ulist] */
		$builder = new CodeDefinitionBuilder('ulist', '<ul>{param}</ul>');
		array_push($this->definitions, $builder->build());
		
		/* [olist] */
		$builder = new CodeDefinitionBuilder('olist', '<ol>{param}</ol>');
		array_push($this->definitions, $builder->build());
		
		/* [li] */
		$builder = new CodeDefinitionBuilder('li', '<li>{param}</li>');
		array_push($this->definitions, $builder->build());
		
		/* [table] */
		$builder = new CodeDefinitionBuilder('table', '<table>{param}</table>');
		array_push($this->definitions, $builder->build());
		
		/* [tr] */
		$builder = new CodeDefinitionBuilder('tr', '<tr>{param}</tr>');
		array_push($this->definitions, $builder->build());
		
		/* [td] */
		$builder = new CodeDefinitionBuilder('td', '<td>{param}</td>');
		array_push($this->definitions, $builder->build());
		
		/* Headers [h=1-6]*/
		$builder = new CodeDefinitionBuilder('h', '<h{option}>{param}</h{option}>');
		$builder->setUseOption(true);
		array_push($this->definitions, $builder->build());
		
		/* youtube */
		$builder = new CodeDefinitionBuilder('yt', '<iframe class="youtube-video" src="https://www.youtube.com/embed/{param}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>');
		array_push($this->definitions, $builder->build());
    }

    /**
     * Returns an array of the default code definitions.
     */
    public function getCodeDefinitions()
    {
        return $this->definitions;
    }

}
