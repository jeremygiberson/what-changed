<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/29/15 3:37 PM
 */

namespace Application\Command;


class QueueRefreshCommandHandler
{
    public function __invoke(QueueRefreshCommand $command)
    {
        $fp = fopen(__DIR__ . '/../../../../../data/queue.log', 'w+');
        fwrite($fp, sprintf("Queuing refresh of %s", $command->getUrl()));
        fclose($fp);
    }
}