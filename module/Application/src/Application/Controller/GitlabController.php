<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/29/15 2:36 PM
 */

namespace Application\Controller;


use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;

class GitlabController extends AbstractActionController
{
    public function hookAction()
    {
        file_put_contents(__DIR__ . '/../../../../../data/hook.request', $this->getRequest()->getContent());
        return new Response();
    }
}
