# Outgoing webhooks (creating your own responses)

To respond to an outgoing wehook, you must first create one in the Slack Administration pages of your team.
Slack will assign a webhook-token to it which you must then add to your project's configuration.
Instructions for this are found in the previous chapter (mentioning 'outgoing_webhook_tokens').

An example webhook response would look like this:

```php
<?php

namespace Acme\DemoBundle\Controller;

use CL\Bundle\SlackBundle\Slack\OutgoingWebhook\Request\OutgoingWebhookRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OutgoingWebhookDemoController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function webhookAction(Request $request)
    {
        $webhookRequest = $this->get('cl_slack.outgoing_webhook.request_factory')->create($request->query->all());
        $triggerWord    = $webhookRequest->getTriggerWord();
        switch ($triggerWord) {
            case 'ask':
                $text = $this->ask($webhookRequest);
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Unknown trigger-word: %s', $triggerWord));
        }

        $jsonData = [
            'text' => $text
        ];

        return new JsonResponse($jsonData);
    }

    /**
     * @param OutgoingWebhookRequest $request
     *
     * @return string
     */
    public function ask(OutgoingWebhookRequest $request)
    {
        // i.e. "What is the answer to 2 + 2?"
        $question = $request->getText();
        $answer   = '4';

        return $answer;
    }
}
```

This controller contains an example of an action you could have in your project that will
get called by an outgoing webhook from Slack.

The example is about a quiz that you can start from within a channel in Slack by merely sending a
message starting with ``ask``, followed by a question like "What is the answer to 2 + 2?"

Slack would then send a request to the webhookAction, which we can then answer back to the user's channel in Slack.


## Security concerns

As long as you use the OutgoingWebhookRequestFactory as indicated below to convert the incoming Symfony request
into a OutgoingWebhookRequest instance, you should be fine as far as safety is concerned since,
during the process of making that instance, the token from the original request is verified against the one
you have configured in your app/config. An InvalidTokenException is thrown otherwise.


## Exception handling

As long as you use the default (Symfony) implementation for handling exceptions,
any exceptions you throw will just cause a response to be returned that does not
have status code 200; this is enough for Slack to know something went wrong.

To learn more about what Slack does when a outgoing webhook fails, check out their documentation:
https://<yourteamhere>.slack.com/services/new/outgoing-webhook


# Got it?

Check out the next chapter about using the [API commands](api-commands.md).
