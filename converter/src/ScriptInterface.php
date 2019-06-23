<?php


namespace App;


interface ScriptInterface
{
    public function setUp();

    public function execute();

    public function cleanUp();
}