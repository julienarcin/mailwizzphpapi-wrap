<?php

$app->group('/campaigns', function() use ($app) {

    $app->get('/get', function() use ($app) {
        $endpoint = new MailWizzApi_Endpoint_Campaigns();
        $response = $endpoint->getCampaigns();
        echo MailWizzApi_Json::encode($response->body);
    });

    $app->get('/show', function() use ($app) {

        $endpoint = new MailWizzApi_Endpoint_Campaigns();

        if(!$app->request()->get('campaign'))
        {
            echo json_encode(array('status' => 'error', 'result' => 'Parameter [campaign] is missing'));
            $app->stop();
        }

        $response = $endpoint->getCampaign($app->request()->get('campaign'));
        echo MailWizzApi_Json::encode($response->body);

    });

    $app->post('/create', function() use ($app) {

        $endpoint = new MailWizzApi_Endpoint_Campaigns();

        $post = $app->request->post();

        if(!$post['name'] )
        {
            echo json_encode(array('status' => 'error', 'result' => 'Parameter [name] is missing'));
            $app->stop();
        }

        if(!$post['subject'] )
        {
            echo json_encode(array('status' => 'error', 'result' => 'Parameter [subject] is missing'));
            $app->stop();
        }

        if(!$post['content'] )
        {
            echo json_encode(array('status' => 'error', 'result' => 'Parameter [content] is missing'));
            $app->stop();
        }

        if(!$post['list_uid'] )
        {
            echo json_encode(array('status' => 'error', 'result' => 'Parameter [list_uid] is missing'));
            $app->stop();
        }

        if(!isset($post['from_name']))
        {
            echo json_encode(array('status' => 'error', 'result' => 'Parameter [from_name] is missing'));
            $app->stop();
        }

        if(!isset($post['from_email']))
        {
            echo json_encode(array('status' => 'error', 'result' => 'Parameter [from_email] is missing'));
            $app->stop();
        }

        if(!isset($post['reply_to']))
        {
            $post['reply_to'] = $post['from_email'];
        }

        if(!isset($post['send_at']))
        {
            $post['send_at'] = date('Y-m-d H:i:s');
        }

        if(!isset($post['segment_uid']))
        {
            $post['segment_uid'] = '';
        }

        $response = $endpoint->create(array(
            'name'          => $post['name'], // required
            'type'          => 'regular', // optional: regular or autoresponder
            'from_name'     => $post['from_name'], // required
            'from_email'    => $post['from_email'], // required
            'subject'       => $post['subject'], // required
            'reply_to'      => $post['reply_to'], // required
            'send_at'       => $post['send_at'], // required, this will use the timezone which customer selected
            'list_uid'      => $post['list_uid'], // required
            'segment_uid'   => $post['segment_uid'],// optional, only to narrow down

            // optional block, defaults are shown
            'options' => array(
                'url_tracking'      => 'yes', // yes | no
                'json_feed'         => 'yes', // yes | no
                'xml_feed'          => 'yes', // yes | no
                'plain_text_email'  => 'yes',// yes | no
                'email_stats'       => null, // a valid email address where we should send the stats after campaign done

                // - if autoresponder uncomment bellow:
                //'autoresponder_event'            => 'AFTER-SUBSCRIBE', // AFTER-SUBSCRIBE or AFTER-CAMPAIGN-OPEN
                //'autoresponder_time_unit'        => 'hour', // minute, hour, day, week, month, year
                //'autoresponder_time_value'       => 1, // 1 hour after event
                //'autoresponder_open_campaign_id' => 1, // INT id of campaign, only if event is AFTER-CAMPAIGN-OPEN,

                // - if this campaign is advanced recurring, you can set a cron job style frequency.
                // - please note that this applies only for regular campaigns.
                //'cronjob'         => '0 0 * * *', // once a day
                //'cronjob_enabled' => 1, // 1 or 0
            ),

            // required block, archive or template_uid or content => required.
            'template' => array(
                //'archive'         => file_get_contents(dirname(__FILE__) . '/template-example.zip'),
                //'template_uid'    => $post['template_uid'],
                'content'           => $post['content'], //file_get_contents(dirname(__FILE__) . '/template-example.html'),
                'inline_css'        => 'no', // yes | no
                'plain_text'        => null, // leave empty to auto generate
                'auto_plain_text'   => 'yes', // yes | no
            ),
        ));
        echo MailWizzApi_Json::encode($response->body);
    });

    $app->post('/update', function() use ($app) {

        $endpoint = new MailWizzApi_Endpoint_Campaigns();

        $post = $app->request->post();

        if(!$post['campaign'] )
        {
            echo json_encode(array('status' => 'error', 'result' => 'Parameter [campaign] is missing'));
            $app->stop();
        }

        if(!$post['name'] )
        {
            echo json_encode(array('status' => 'error', 'result' => 'Parameter [name] is missing'));
            $app->stop();
        }

        if(!$post['subject'] )
        {
            echo json_encode(array('status' => 'error', 'result' => 'Parameter [subject] is missing'));
            $app->stop();
        }

        if(!$post['content'] )
        {
            echo json_encode(array('status' => 'error', 'result' => 'Parameter [content] is missing'));
            $app->stop();
        }

        if(!$post['list_uid'] )
        {
            echo json_encode(array('status' => 'error', 'result' => 'Parameter [list_uid] is missing'));
            $app->stop();
        }

        if(!isset($post['from_name']))
        {
            echo json_encode(array('status' => 'error', 'result' => 'Parameter [from_name] is missing'));
            $app->stop();
        }

        if(!isset($post['from_email']))
        {
            echo json_encode(array('status' => 'error', 'result' => 'Parameter [from_email] is missing'));
            $app->stop();
        }

        if(!isset($post['reply_to']))
        {
            $post['reply_to'] = $post['from_email'];
        }

        if(!isset($post['send_at']))
        {
            $post['send_at'] = date('Y-m-d H:i:s');
        }

        if(!isset($post['segment_uid']))
        {
            $post['segment_uid'] = '';
        }

        $response = $endpoint->update($post['campaign'],array(
            'name'          => $post['name'], // required
            'type'          => 'regular', // optional: regular or autoresponder
            'from_name'     => $post['from_name'], // required
            'from_email'    => $post['from_email'], // required
            'subject'       => $post['subject'], // required
            'reply_to'      => $post['reply_to'], // required
            'send_at'       => $post['send_at'], // required, this will use the timezone which customer selected
            'list_uid'      => $post['list_uid'], // required
            'segment_uid'   => $post['segment_uid'],// optional, only to narrow down

            // optional block, defaults are shown
            'options' => array(
                'url_tracking'      => 'yes', // yes | no
                'json_feed'         => 'yes', // yes | no
                'xml_feed'          => 'yes', // yes | no
                'plain_text_email'  => 'yes',// yes | no
                'email_stats'       => null, // a valid email address where we should send the stats after campaign done

                // - if autoresponder uncomment bellow:
                //'autoresponder_event'            => 'AFTER-SUBSCRIBE', // AFTER-SUBSCRIBE or AFTER-CAMPAIGN-OPEN
                //'autoresponder_time_unit'        => 'hour', // minute, hour, day, week, month, year
                //'autoresponder_time_value'       => 1, // 1 hour after event
                //'autoresponder_open_campaign_id' => 1, // INT id of campaign, only if event is AFTER-CAMPAIGN-OPEN,

                // - if this campaign is advanced recurring, you can set a cron job style frequency.
                // - please note that this applies only for regular campaigns.
                //'cronjob'         => '0 0 * * *', // once a day
                //'cronjob_enabled' => 1, // 1 or 0
            ),

            // required block, archive or template_uid or content => required.
            'template' => array(
                //'archive'         => file_get_contents(dirname(__FILE__) . '/template-example.zip'),
                //'template_uid'    => $post['template_uid'],
                'content'           => $post['content'], //file_get_contents(dirname(__FILE__) . '/template-example.html'),
                'inline_css'        => 'no', // yes | no
                'plain_text'        => null, // leave empty to auto generate
                'auto_plain_text'   => 'yes', // yes | no
            ),
        ));
        echo MailWizzApi_Json::encode($response->body);
    });

    $app->post('/delete', function() use ($app) {

        $endpoint = new MailWizzApi_Endpoint_Campaigns();

        $post = $app->request->post();

        if(!$post['campaign'] )
        {
            echo json_encode(array('status' => 'error', 'result' => 'Parameter [campaign] is missing'));
            $app->stop();
        }

        $response = $endpoint->delete($post['campaign']);
        echo MailWizzApi_Json::encode($response->body);
    });

});