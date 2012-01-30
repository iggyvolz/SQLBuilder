<?php

class ExpressionTest extends PHPUnit_Framework_TestCase
{

    public function createExpr()
    {
        $expr = new SQLBuilder\Expression;
        $expr->driver = new SQLBuilder\Driver;
        return $expr;
    }

    public function testOpIs()
    {
        $expr = $this->createExpr();
        $expr->is( 'a' , 'null' )->is( 'b' , 'null' );
        is( 'a is null AND b is null', $expr->inflate() );
    }

    public function testOpAnd()
    {
        $expr = $this->createExpr();
        $expr->is( 'a' , 'null' )
            ->and()->is( 'b', 'null' );
        is( 'a is null AND b is null', $expr->inflate() );
    }

    public function testOpOr()
    {
        $expr = $this->createExpr();
        $expr->is( 'a' , 'null' )
            ->or()->is( 'b', 'null' );
        is( 'a is null OR b is null', $expr->inflate() );
    }

    public function testOpEqual()
    {
        $expr = $this->createExpr();
        $expr->equal( 'a' , 'foo' )
            ->or()->equal( 'b', 'bar' );
        is( "a = 'foo' OR b = 'bar'", $expr->inflate() );
    }

    public function testOpWithSqlFunction()
    {
        $expr = $this->createExpr();
        $expr->equal( 'a' , array("format('2011-12-11')") )
            ->or()->equal( 'b', 'bar' );
        is( "a = format('2011-12-11') OR b = 'bar'", $expr->inflate() );
    }

    public function testLike()
    {
        $expr = $this->createExpr();
        $expr->like( 'content' , '%aaa%' );
        is( "content like '%aaa%'", $expr->inflate() );
    }

    public function testGroup()
    {
        $expr = $this->createExpr();
        $expr->like( 'content' , '%aaa%' );
        $expr->group()
            ->equal( 'a' , 'b' )
            ->equal( 'c' , 'd' )
            ->ungroup()
                ->and()->is( 'name' , 'null' );
        is( "content like '%aaa%' AND (a = 'b' AND name is null)", $expr->inflate() );
    }

    public function testGreater()
    {
        $expr = $this->createExpr();
        $expr->greater( 'a', 123 );
        is( "a > 123", $expr->inflate() );
    }

    public function testGreaterWithString()
    {
        $expr = $this->createExpr();
        $expr->greater( 'date', '2011-01-01' );
        is( "date > '2011-01-01'", $expr->inflate() );
    }

    public function testGreaterWithSqlFunction()
    {
        $expr = $this->createExpr();
        $expr->greater( 'date', array("format('2011-01-01')") );
        is( "date > format('2011-01-01')", $expr->inflate() );
    }


}

