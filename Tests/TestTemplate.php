<?php

namespace Ext\DirectBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Ext\DirectBundle\Router\Rule;

/**
 * Class TestTemplate
 *
 * @package Ext\DirectBundle\Tests
 *
 * @author  Semyon Velichko <semyon@velichko.net>
 */
class TestTemplate extends WebTestCase
{

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
    }

    /**
     * @param string $alias
     *
     * @return object
     */
    public function get($alias)
    {
        return static::$kernel->getContainer()->get($alias);
    }

    /**
     * @return array
     */
    public function getReaderParams()
    {
        return array(
            array('type' => 'json', 'root' => null, 'successProperty' => 'success', 'totalProperty' => 'total'),
            array('type' => 'xml', 'root' => 'result',
                'successProperty' => 'successProperty', 'totalProperty' => 'totalProperty'),
            array('type' => 'xml', 'root' => null, 'successProperty' => 'success', 'totalProperty' => 'total'),
            array('type' => 'json', 'root' => null, 'successProperty' => 'success', 'totalProperty' => 'total')
        );
    }

    /**
     * @return array
     */
    public function getWriterParams()
    {
        return array(
            array('type' => 'xml', 'root' => 'write'),
            array('type' => 'yaml'),
            array('root' => 'root'),
            array()
        );
    }

    /**
     * @return array
     */
    public function getRules()
    {
        $rules = array(
            array(new Rule('formHandler', 'ExtDirectBundle:Test:formHandler', true, true)),
            array(new Rule('formHandlerWithoutParams', 'ExtDirectBundle:Test:formHandler2', true, false)),
            array(new Rule('withParams', 'ExtDirectBundle:Test:withParams', true, false)),
            array(new Rule('withoutParams', 'ExtDirectBundle:Test:withoutParams', false, false)),
            array(new Rule('actionInOtherController', 'ExtDirectBundle:Other:action', false, false))
        );

        foreach ($rules as $rule) {
            $rule = $rule[0];
            $readerParams = $this->getReaderParams();
            foreach ($readerParams[0] as $key => $value) {
                $rule->setReaderParam($key, $value);
            }

            $writerParams = $this->getWriterParams();
            foreach ($writerParams[0] as $key => $value) {
                $rule->setWriterParam($key, $value);
            }
        }

        return $rules;
    }

}
