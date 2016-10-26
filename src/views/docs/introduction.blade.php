<a href="#" class="waypoint" name="introduction"></a>
<h1>Introduction</h1>
<p>This RESTful JSON API uses HTTP GET, POST Requests to communicate with the System.</p>

<p>For Authorization, set header <i>Authorization</i> key of every request with API token:</p>
<pre class="prettyprint linenums">
    header: {
        "Authorization" : "Bearer <?php echo $user->api_token ?>"
    }
</pre>

<p>For Relations Endpoint 'with[{relation_string}]', you can provider these parameters as example:
<pre class="prettyprint linenums">
    {
        with[{relation_string}] : {
            "limit"             :   3,
            "offset"            :   0,
            "order_by"          :   "id",
            "order_direction"   :   "ASC"
        }
    }
</pre>