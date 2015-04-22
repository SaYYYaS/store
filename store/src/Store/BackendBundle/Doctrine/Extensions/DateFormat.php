<?php

namespace Store\BackendBundle\Doctrine\Extensions;

use \Doctrine\ORM\Query\AST\Functions\FunctionNode;
use \Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * MysqlRand
 *
 * @uses FunctionNode
 * @author Simone Fumagalli - www.iliveinperego.com
 */
class DateFormat extends FunctionNode
{

    /*
    * holds the date of the DATE_FORMAT statement
    * @var mixed
    */
    protected $dateExpression;

    /**
     * holds the '%format' parameter of the DATE_FORMAT statement
     * @var string
     */
    protected $formatChar;

    /**
     * getSql
     *
     * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
     * @access public
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'DATE_FORMAT(' .
        $sqlWalker->walkArithmeticExpression($this->dateExpression) .
        ','.
        $sqlWalker->walkStringPrimary($this->formatChar) .
        ')';
    }

    /**
     * parse
     *
     * @param \Doctrine\ORM\Query\Parser $parser
     * @access public
     * @return void
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->dateExpression = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->formatChar = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}