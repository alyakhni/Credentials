# API Credentials

Credentials API based on Laravel (passport)

# Clients

First, developers building applications that need to interact with your application&#39;s API will need to register their application with yours by creating a &quot;client&quot;. Typically, this consists of providing the name of their application and a URL that your application can redirect to after users approve their request for authorization.

**To create a Client you have to do the following:**

- Register a user on the api credentials web site.
- Login
- Press Create new Client

# Requesting Tokens

## Redirecting For Authorization

Once a client has been created, developers may use their client ID and secret to request an authorization code and access token from your application. First, the consuming application should make a redirect request to your application&#39;s /oauth/authorize route like so:

Laravel way:

Route::get(&#39;/redirect&#39;,function(){

    $query=http\_build\_query([

        &#39;client\_id&#39;=&gt;&#39;client-id&#39;,

        &#39;redirect\_uri&#39;=&gt;&#39;http://example.com/callback&#39;,

        &#39;response\_type&#39;=&gt;&#39;code&#39;,

        &#39;scope&#39;=&gt;&#39;&#39;,

    ]);

    returnredirect(&#39;http://localhost:8000.com/oauth/authorize?&#39; . $query);

});

Or simply call this url:

[http://localhost:8000.com/oauth/authorize?client\_id=id&amp;response\_type=code&amp;redirect\_uri=http://example.com/callback](http://localhost:8000.com/oauth/authorize?client_id=id&amp;response_type=code&amp;redirect_uri=http://example.com/callback)

## Approving The Request

When receiving authorization requests, Passport will automatically display a template to the user allowing them to approve or deny the authorization request. If they approve the request, they will be redirected back to the redirect\_uri  that was specified by the consuming application. The redirect\_uri  must match the redirect URL that was specified when the client was created.

## Converting Authorization Codes To Access Tokens

If the user approves the authorization request, they will be redirected back to the consuming application. The consumer should then issue a POST request to your application to request an access token. The request should include the authorization code that was issued by your application when the user approved the authorization request. In this example, we&#39;ll use the Guzzle HTTP library to make the POST request:

Route::get(&#39;/callback&#39;,function(Request $request){

    $http=new GuzzleHttp\Client;

    $response=$http-&gt;post(&#39;http://your-app.com/oauth/token&#39;,[

        &#39;form\_params&#39;=&gt;[

            &#39;grant\_type&#39;=&gt;&#39;authorization\_code&#39;,

            &#39;client\_id&#39;=&gt;&#39;client-id&#39;,

            &#39;client\_secret&#39;=&gt;&#39;client-secret&#39;,

            &#39;redirect\_uri&#39;=&gt;&#39;http://example.com/callback&#39;,

            &#39;code&#39;=&gt;$request-&gt;code,

        ],

    ]);

    returnjson\_decode((string)$response-&gt;getBody(),true);

});

This /oauth/token route will return a JSON response containing access\_token, refresh\_token, and expires\_in attributes. The expires\_in attribute contains the number of seconds until the access token expires.

After this request new block (Authorized Applications) shown in the dashboard. You can at any time revoke an app (client). When a client has revoked, all of her access\_token  will not work.

Note: _code_is the _code_that was generated when you approve a client authorization request.

## Verify token

To verify the access token get&#39;s in the previews request you have to call /api/user  with the bearer token in the header like the follow ajax call.

| $.ajax({ |
| --- |
|      url:&quot;http://your-app:8080/api/user&quot;, |
|      type:&#39;GET&#39;,     type:&#39;application/json&#39;, |
|      success:function(user, status) { |
|          returnconsole.log(&quot;The returned user&quot;, user); |
|      }, |
|      beforeSend:function(xhr, settings) {              xhr.setRequestHeader(&#39;Authorization&#39;,&#39;Bearer &#39;+ tokenString );      } //set tokenString before send |
| });_This request return the user (id, name, username, created\_at, updated\_at)_  |

## Refreshing Tokens

If your application issues short-lived access tokens, users will need to refresh their access tokens via the refresh token that was provided to them when the access token was issued. In this example, we&#39;ll use the Guzzle HTTP library to refresh the token:

$http=newGuzzleHttp\Client;

$response=$http-&gt;post(&#39;http://your-app.com/oauth/token&#39;,[

    &#39;form\_params&#39;=&gt;[

        &#39;grant\_type&#39;=&gt;&#39;refresh\_token&#39;,

        &#39;refresh\_token&#39;=&gt;&#39;the-refresh-token&#39;,

        &#39;client\_id&#39;=&gt;&#39;client-id&#39;,

        &#39;client\_secret&#39;=&gt;&#39;client-secret&#39;,

        &#39;scope&#39;=&gt;&#39;&#39;,

    ],

]);

returnjson\_decode((string)$response-&gt;getBody(),true);

This /oauth/token route will return a JSON response containing access\_token, refresh\_token, and expires\_in attributes. The expires\_in attribute contains the number of seconds until the access token expires.