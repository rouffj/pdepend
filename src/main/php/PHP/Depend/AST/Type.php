<?php
interface PHP_Depend_AST_Type extends PHP_Depend_AST_Node
{
    /**
     *
     * @return PHP_Depend_AST_Namespace
     */
    public function getNamespace();
}