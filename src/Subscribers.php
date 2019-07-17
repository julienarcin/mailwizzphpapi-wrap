<?php

$app->group('/subscribers', function() use ($app){

    $app->post('/user/add', function() use ($app) {

        $endpoint = new MailWizzApi_Endpoint_ListSubscribers();

        $post = $app->request->post();

        if(!$post['email'] || !$post['list'] )
        {
            echo json_encode(array('status' => 'error', 'result' => 'Some parameters are missing'));
            $app->stop();
        }

        $rebuildPost = [];
        foreach($post as $key => $value) {
            $rebuildPost[strtoupper($key)] = $value;
        }

        $response = $endpoint->createUpdate($post['list'], $rebuildPost);
        echo MailWizzApi_Json::encode($response->body);
    });

    $app->post('/user/unsubscribe', function() use ($app) {

        $endpoint = new MailWizzApi_Endpoint_ListSubscribers();

        $post = $app->request->post();

        if(!$post['email'] || !$post['list'] )
        {
            echo json_encode(array('status' => 'error', 'result' => 'Some parameters are missing'));
            $app->stop();
        }

        $response = $endpoint->unsubscribeByEmail($post['list'], $post['email']);
        echo MailWizzApi_Json::encode($response->body);
    });
    
    $app->post('/user/delete', function() use ($app) {

        $endpoint = new MailWizzApi_Endpoint_ListSubscribers();

        $post = $app->request->post();

        if(!$post['email'] || !$post['list'] )
        {
            echo json_encode(array('status' => 'error', 'result' => 'Some parameters are missing'));
            $app->stop();
        }

        $response = $endpoint->deleteByEmail($post['list'], $post['email']);
        echo MailWizzApi_Json::encode($response->body);
    });

});
