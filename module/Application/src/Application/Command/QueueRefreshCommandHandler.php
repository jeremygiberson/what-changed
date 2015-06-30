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
        $fp = fopen(__DIR__ . '/../../../../../data/queue.log', 'a+');
        fwrite($fp, sprintf("Queuing refresh of %s\n", $command->getUrl()));
        fclose($fp);

        // TODO use a queue to accomplish async processing
        $shell_command = sprintf("php public/index.php refresh %s &> /dev/null &", $command->getUrl());

        `$shell_command`;
    }
}