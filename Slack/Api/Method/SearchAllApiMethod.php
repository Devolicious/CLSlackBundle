<?php

/*
 * This file is part of the CLSlackBundle.
 *
 * (c) Cas Leentfaar <info@casleentfaar.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CL\Bundle\SlackBundle\Slack\Api\Method;

use CL\Bundle\SlackBundle\Slack\Api\Method\Response\SearchAllApiMethodResponse;
use Guzzle\Http\Message\Response;

/**
 * @author Cas Leentfaar <info@casleentfaar.com>
 */
class SearchAllApiMethod extends AbstractSearchApiMethod
{
    /**
     * {@inheritdoc}
     */
    public function createResponse(Response $response)
    {
        return new SearchAllApiMethodResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSlug()
    {
        return 'search.all';
    }
}
