The Eventbrite class is designed to allow you to get any of the data you need from the Eventbrite API through method and property chaining. For example:

<pre><code class="code">$eb = <span class="function">new Eventbrite</span>(XYZABC, [], true);

<span class="comment">// GET /system/regions/</span>
$regions = $eb->regions;

<span class="comment">// GET /users/me/owned_events/</span>
$myEvents = $eb->user->owned_events;
</code></pre>
