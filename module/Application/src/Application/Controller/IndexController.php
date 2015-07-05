<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Model\Mapper\CommitMapperAwareInterface;
use Application\Model\Mapper\CommitMapperAwareTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController implements CommitMapperAwareInterface
{
    use CommitMapperAwareTrait;

    public function indexAction()
    {
        $page = $this->params()->fromRoute('page', 1);

        $list = $this->getCommitMapper()->getList();
        $list->setCurrentPageNumber($page);

        return new ViewModel(['items' => $list]);
    }
}
