<?php
//
//function getJsonObject(): string
//{
//    return '{
//        "fields": {
//        "project":{"key": "RML"},
//        "summary": "REST ye merry gentlemen.",
//        "description": {
//        "version": 1,
//        "type": "doc",
//        "content": [
//    {
//      "type": "paragraph",
//      "content": [
//        {
//          "type": "text",
//          "text": "Hello "
//        },
//        {
//          "type": "text",
//          "text": "world",
//          "marks": [
//            {
//              "type": "strong"
//            }
//          ]
//        }
//      ]
//    }
//  ]
//},
//       "issuetype": {
//          "name": "Bug"
//       }
//   }
//}';
//}
//function PostRequest(): string
//{
//    $newUri = "https://jsonplaceholder.typicode.com/albums/1";
//    $headers  = new Headers();
//    $headers->addHeaderLine('Content-Type', 'application/json');
//
//    $newUri = "https://tartous.atlassian.net/rest/api/3/issue";
//    $body = $this->getJsonObject();
//    //var_dump($body);
//    $this->setUri($newUri);
//    $this->setAdapter(Curl::class);
//    $this->setMethod(Request::METHOD_POST);
//    $this->setOptions([CURLOPT_FOLLOWLOCATION => true]);
//    $this->setAuth('dev.toumeh@gmail.com', '5UPAq0o9cjK0YDvAlHxWE9DF');
//    $this->setRawBody($body);
//    $this->setHeaders($headers);
//    $this->send();
//    //var_dump($this->response->getStatusCode());
//    return $this->getResponse()->getBody();
//}


// Get "message" from the query parameters.
// In production code, it's a good idea to sanitize user input.
//$message = $this->params()->fromQuery('message', 'hello');
//$requestPost = new TestRequestController();
//$data = $requestPost->PostRequest();
//$data = [1,2];//$requestPost->absenceRequest();
//$handler = new HandleResponse($data);
//$data = file_get_contents('https://jsonplaceholder.typicode.com/albums/1');
// Pass variables to the view.



//<form METHOD="POST">
//    <div class="mb-3">
//        <label for="name" class="form-label">JIRA Username</label>
//        <input type="text" class="form-control" id="name" placeholder="max.musterman">
//        <div id="emailHelp" class="form-text">Please write your JIRA Login Username</div>
//    </div>
//    <div class="mb-3">
//        <label for="JiraPassword" class="form-label">JIRA Password</label>
//        <input type="password" class="form-control" id="JiraPassword">
//    </div>
//    <div class="mb-3">
//        <label for="hawkID" class="form-label">Absence Hawk ID</label>
//        <input type="text" class="form-control" id="hawkID" placeholder="5ebb30c62933ac32298kcfd4">
//        <div id="emailHelp" class="form-text">Please write your Absence Hawk ID</div>
//    </div>
//    <div class="mb-3">
//        <label for="HawkAuthKey" class="form-label">Hawk Auth Key</label>
//        <input type="password" class="form-control" id="HawkAuthKey">
//    </div>
//    <div class="mb-3 form-check">
//        <input type="checkbox" class="form-check-input" id="exampleCheck1">
//        <label class="form-check-label" for="exampleCheck1">Check me out</label>
//    </div>
//    <button type="submit" class="btn btn-primary">Submit</button>
//</form>