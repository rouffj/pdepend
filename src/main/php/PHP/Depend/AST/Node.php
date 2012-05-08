<?php
/**
 *
 */
interface PHP_Depend_AST_Node
{
    /**
     *
     * @return string
     */
    public function getId();

    /**
     *
     * @return PHP_Depend_AST_Namespace
     */
    public function getNamespace();
}