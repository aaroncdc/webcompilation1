<?php
require_once "Parser.php";
/**
 * Implements a [list] code definition that provides the following syntax:
 *
 * [list]
 *   [*] first item
 *   [*] second item
 *   [*] third item
 * [/list]
 *
 */
class ListCodeDefinition extends \JBBCode\CodeDefinition
{
    public function __construct()
    {
        $this->parseContent = true;
        $this->useOption = false;
        $this->setTagName('list');
        $this->nestLimit = -1;
    }
    public function asHtml(\JBBCode\ElementNode $el)
    {
        $bodyHtml = '';
        foreach ($el->getChildren() as $child) {
            $bodyHtml .= $child->getAsHTML();
        }
        $listPieces = explode('[*]', $bodyHtml);
        unset($listPieces[0]);
        $listPieces = array_map(function($li) { return '<li>'.$li.'</li>' . "\n"; }, $listPieces);
        return '<ul>'.implode('', $listPieces).'</ul>';
    }
}
