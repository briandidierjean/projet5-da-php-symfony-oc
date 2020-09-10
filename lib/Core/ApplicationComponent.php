<?php
namespace Core;

abstract class ApplicationComponent
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->$app = $app;
    }

    /**
     * This method returns the app attribute.
     * 
     * @return Application
     */
    public function getApp()
    {
        return $this->app;
    }
}