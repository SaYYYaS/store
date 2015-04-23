<?php

namespace Store\BackendBundle\Doctrine\Extensions;

use \Doctrine\ORM\Query\AST\Functions\FunctionNode;
use \Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

 /**
 *
 * @uses FunctionNode
 */
class Month extends FunctionNode
{

    /**
    * holds the date of the MONTH statement
    * @var mixed
    */
    protected $dateExpression;

    /**
     * getSql
     * Parse le DQL en SQL, l'inverse de la fonction parse
     *
     * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
     * @access public
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        //Je retourne la fonction en SQL MONTH()qui
        //va prendre en argument ce que j'ai saisi en expression
        return 'MONTH(' .
        $sqlWalker->walkArithmeticExpression($this->dateExpression) .
        ')';
    }

    /**
     * parse va utiliser le parser de Doctrine pour parser ma fonction
     *
     * @param \Doctrine\ORM\Query\Parser $parser
     * @access public
     * @return void
     */
    public function parse(Parser $parser)
    {
        // Identifie la fonction que l'on va utiliser: MONTH
        $parser->match(Lexer::T_IDENTIFIER);
        // Identifie la parenthèse ouvrante: (
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        // Identifie l'expression que l'on va donner dans la fonction MONTH()
        $this->dateExpression = $parser->ArithmeticExpression();
        // Identifie la parenthèse fermante
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}