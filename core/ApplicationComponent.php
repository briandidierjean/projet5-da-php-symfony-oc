<?php
namespace Core;

abstract class ApplicationComponent
{
    protected $app;
  
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
  
    public function getApp()
    {
        return $this->app;
    }
}
