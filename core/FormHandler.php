<?php
namespace Core;

abstract class FormHandler
{
    protected $httpRequest;
    protected $httpResponse;
    protected $form;
 
    public function __construct(
        HTTPRequest $httpRequest,
        HTTPResponse $httpResponse,
        Form $form
    ) {
        $this->httpRequest = $httpRequest;
        $this->httpResponse = $httpResponse;
        $this->form = $form;
    }

    /**
     * Process the form
     *
     * @return bool
     */
    abstract public function process();
}
