<h1>JSM&#039;s Force HTTP to HTTPS / SSL - Simple, Fast and Reliable</h1>

<table>
<tr><th align="right" valign="top" nowrap>Plugin Name</th><td>JSM&#039;s Force HTTP to HTTPS</td></tr>
<tr><th align="right" valign="top" nowrap>Summary</th><td>No setup required - simply activate to force HTTP URLs to HTTPS using native WordPress filters and permanent redirects for best SEO.</td></tr>
<tr><th align="right" valign="top" nowrap>Stable Version</th><td>3.4.1</td></tr>
<tr><th align="right" valign="top" nowrap>Requires PHP</th><td>7.2 or newer</td></tr>
<tr><th align="right" valign="top" nowrap>Requires WordPress</th><td>5.2 or newer</td></tr>
<tr><th align="right" valign="top" nowrap>Tested Up To WordPress</th><td>5.9.3</td></tr>
<tr><th align="right" valign="top" nowrap>Contributors</th><td>jsmoriss</td></tr>
<tr><th align="right" valign="top" nowrap>License</th><td><a href="https://www.gnu.org/licenses/gpl.txt">GPLv3</a></td></tr>
<tr><th align="right" valign="top" nowrap>Tags / Keywords</th><td>https, ssl, mixed content, insecure content, force ssl, simple, secure, upload, proxy, load balancing, cache</td></tr>
</table>

<h2>Description</h2>

<p><strong>A simple, safe, and reliable way to force HTTP URLs to HTTPS dynamically:</strong></p>

<p>No setup required - simply activate the plugin to force HTTP URLs to HTTPS.</p>

<p>There are no plugin settings to adjust, and no changes are made to your WordPress configuration.</p>

<p><strong>SIGNIFICANTLY FASTER than other popular plugins of this type:</strong></p>

<p>Other well known plugins use <a href="https://secure.php.net/manual/en/function.ob-start.php">PHP's output buffer</a> to search &amp; replace URLs in the rendered HTML, which is a technique that is error prone and <em>negatively affects caching performance</em> (as changes are not cached).</p>

<p>This plugin uses standard WordPress filters instead of PHP's output buffer for maximum reliability, performance, caching compatibility, and uses 301 permanent redirects for best SEO results (<a href="https://en.wikipedia.org/wiki/HTTP_301">301 redirects are considered best for SEO when moving from HTTP to HTTPS</a>).</p>

<p><strong>Supports advanced proxy / load-balancing HTTP headers:</strong></p>

<ul>
<li><code>X-Forwarded-Proto</code> (aka <code>HTTP_X_FORWARDED_PROTO</code> server value)</li>
<li><code>X-Forwarded-Ssl</code> (aka <code>HTTP_X_FORWARDED_SSL</code> server value)</li>
</ul>

<p>See <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Forwarded-Proto">Web technology for developers &gt; HTTP &gt; HTTP headers &gt; X-Forwarded-Proto</a> for more details.</p>

<h4>Plugin Requirements</h4>

<p>Your web server must already be configured with an SSL certificate and able to handle HTTPS request. ;-)</p>

