<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.3.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.3.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-GETapi-sanpham">
                                <a href="#endpoints-GETapi-sanpham">GET api/sanpham</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-sanpham--sanpham_masp-">
                                <a href="#endpoints-GETapi-sanpham--sanpham_masp-">GET api/sanpham/{sanpham_masp}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-register">
                                <a href="#endpoints-POSTapi-register">POST api/register</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-login">
                                <a href="#endpoints-POSTapi-login">POST api/login</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-logout">
                                <a href="#endpoints-POSTapi-logout">POST api/logout</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: October 14, 2025</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://localhost</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-GETapi-sanpham">GET api/sanpham</h2>

<p>
</p>



<span id="example-requests-GETapi-sanpham">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/sanpham" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/sanpham"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-sanpham">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">[
    {
        &quot;masp&quot;: 11,
        &quot;tensp&quot;: &quot;MacBook Air M2 2022&quot;,
        &quot;anhdaidien&quot;: &quot;Air-M2.jpg&quot;,
        &quot;chuyenmuc&quot;: &quot;CM1&quot;,
        &quot;mota&quot;: &quot;Loại card đồ họa : 8 nh&acirc;n GPU, 16 nh&acirc;n Neural Engine. |   \r\nDung lượng RAM : 8GB.|\r\nỔ cứng : 256GB. |\r\nHệ điều h&agrave;nh : MacOS. |\r\nLoại CPU : Apple M2. |\r\nTrọng lượng : 1.27 kg. |\r\nK&iacute;ch thước m&agrave;n h&igrave;nh : 13.6 inches.&quot;,
        &quot;hinhanhkhac1&quot;: &quot;Air-M2.jpg&quot;,
        &quot;giamoi&quot;: &quot;22.290.000&quot;,
        &quot;giacu&quot;: &quot;29.990.000&quot;,
        &quot;trangthai&quot;: 1
    },
    {
        &quot;masp&quot;: 5,
        &quot;tensp&quot;: &quot;GIGABYTE G5 KF5-53VN353SH&quot;,
        &quot;anhdaidien&quot;: &quot;gigabyte-g5.jpg&quot;,
        &quot;chuyenmuc&quot;: &quot;CM4&quot;,
        &quot;mota&quot;: &quot;&quot;,
        &quot;hinhanhkhac1&quot;: &quot;gigabyte-g5.jpg&quot;,
        &quot;giamoi&quot;: &quot;25.400.000&quot;,
        &quot;giacu&quot;: &quot;27.990.000&quot;,
        &quot;trangthai&quot;: 1
    },
    {
        &quot;masp&quot;: 6,
        &quot;tensp&quot;: &quot;Dell Gaming G15 5515&quot;,
        &quot;anhdaidien&quot;: &quot;dell-g15.jpg&quot;,
        &quot;chuyenmuc&quot;: &quot;CM1&quot;,
        &quot;mota&quot;: &quot;Loại card đồ họa : NVIDIA&reg; GeForce RTX&trade; 3050 4GB GDDR6 + AMD Radeon Graphics. |\r\nLoại CPU : AMD Ryzen 7 5800H. |\r\nDung lượng RAM : 8GB. |\r\nỔ cứng : 256GB. |\r\nTrọng lượng : 2.57 kg. |\r\nHệ điều h&agrave;nh : Windows. |\r\nK&iacute;ch thước m&agrave;n h&igrave;nh : 15.6 inches.&quot;,
        &quot;hinhanhkhac1&quot;: &quot;dell-g15.jpg&quot;,
        &quot;giamoi&quot;: &quot;18.990.000&quot;,
        &quot;giacu&quot;: &quot;20.990.000&quot;,
        &quot;trangthai&quot;: 1
    },
    {
        &quot;masp&quot;: 7,
        &quot;tensp&quot;: &quot;Acer Nitro V ANV15&quot;,
        &quot;anhdaidien&quot;: &quot;nitro-v.jpg&quot;,
        &quot;chuyenmuc&quot;: &quot;CM1&quot;,
        &quot;mota&quot;: &quot;Loại card đồ họa : NVIDIA GeForce RTX 4050 6GB GDDR6 VRAM. |\r\nLoại CPU : Intel Core i7-13700H. |\r\nRAM : 16GB. |\r\nỔ cứng : 512GB. |\r\nK&iacute;ch thước m&agrave;n h&igrave;nh : 15.6 inches.|\r\nHệ điều h&agrave;nh : Windows. |\r\nTrọng lượng : 2.1 kg.&quot;,
        &quot;hinhanhkhac1&quot;: &quot;nitro-v.jpg&quot;,
        &quot;giamoi&quot;: &quot;27.390.000&quot;,
        &quot;giacu&quot;: &quot;30.990.000&quot;,
        &quot;trangthai&quot;: 1
    },
    {
        &quot;masp&quot;: 8,
        &quot;tensp&quot;: &quot;HP VICTUS 16-d0294TX&quot;,
        &quot;anhdaidien&quot;: &quot;HP-VICTUS-16.jpg&quot;,
        &quot;chuyenmuc&quot;: &quot;CM1&quot;,
        &quot;mota&quot;: &quot;Loại card đồ họa : NVIDIA GeForce RTX 3050 4GB GDDR6. |\nDung lượng RAM : 8GB. |\nỔ cứng : 512GB. |\nLoại CPU : Intel Core i7-12700H. |\nHệ điều h&agrave;nh : Windows. |\nTrọng lượng : 2.46 kg. |\nK&iacute;ch thước m&agrave;n h&igrave;nh : 16.1 inches.\n&quot;,
        &quot;hinhanhkhac1&quot;: &quot;HP-VICTUS-16.jpg&quot;,
        &quot;giamoi&quot;: &quot;21.990.000&quot;,
        &quot;giacu&quot;: &quot;28.990.000&quot;,
        &quot;trangthai&quot;: 1
    },
    {
        &quot;masp&quot;: 9,
        &quot;tensp&quot;: &quot;MSI Stealth 17 GS77&quot;,
        &quot;anhdaidien&quot;: &quot;MSI-Stealth-17.jpg&quot;,
        &quot;chuyenmuc&quot;: &quot;CM1&quot;,
        &quot;mota&quot;: &quot;Intel Core i7-13700HX&quot;,
        &quot;hinhanhkhac1&quot;: &quot;MSI-Stealth-17.jpg&quot;,
        &quot;giamoi&quot;: &quot;56.690.000&quot;,
        &quot;giacu&quot;: &quot;59.490.000&quot;,
        &quot;trangthai&quot;: 1
    },
    {
        &quot;masp&quot;: 10,
        &quot;tensp&quot;: &quot;Acer Predator Triton 500&quot;,
        &quot;anhdaidien&quot;: &quot;Acer-Predator-Triton.jpg&quot;,
        &quot;chuyenmuc&quot;: &quot;CM4&quot;,
        &quot;mota&quot;: &quot;Intel Core i7-13700HX&quot;,
        &quot;hinhanhkhac1&quot;: &quot;Acer-Predator-Triton.jpg&quot;,
        &quot;giamoi&quot;: &quot;54.970.000&quot;,
        &quot;giacu&quot;: &quot;56.780.000&quot;,
        &quot;trangthai&quot;: 1
    },
    {
        &quot;masp&quot;: 4,
        &quot;tensp&quot;: &quot;HP 15-DW3033DX 405F6UA&quot;,
        &quot;anhdaidien&quot;: &quot;hp15s.jpg&quot;,
        &quot;chuyenmuc&quot;: &quot;CM3&quot;,
        &quot;mota&quot;: &quot;Intel Core i5-1135G7.&quot;,
        &quot;hinhanhkhac1&quot;: &quot;hp15s.jpg&quot;,
        &quot;giamoi&quot;: &quot;8.990.000&quot;,
        &quot;giacu&quot;: &quot;11.400.000&quot;,
        &quot;trangthai&quot;: 1
    },
    {
        &quot;masp&quot;: 3,
        &quot;tensp&quot;: &quot;HP 14-EP0112TU&quot;,
        &quot;anhdaidien&quot;: &quot;hp14s.jpg&quot;,
        &quot;chuyenmuc&quot;: &quot;CM2&quot;,
        &quot;mota&quot;: &quot;Intel Core i5-1135G7.&quot;,
        &quot;hinhanhkhac1&quot;: &quot;hp14s.jpg&quot;,
        &quot;giamoi&quot;: &quot;16.990.000&quot;,
        &quot;giacu&quot;: &quot;19.590.000&quot;,
        &quot;trangthai&quot;: 1
    },
    {
        &quot;masp&quot;: 1,
        &quot;tensp&quot;: &quot; Asus ROG Strix Scar 18&quot;,
        &quot;anhdaidien&quot;: &quot;rog-scar.jpg&quot;,
        &quot;chuyenmuc&quot;: &quot;CM2&quot;,
        &quot;mota&quot;: &quot;AMD Ryzen 9 7945HX&quot;,
        &quot;hinhanhkhac1&quot;: &quot;rog-scar.jpg&quot;,
        &quot;giamoi&quot;: &quot;35.990.000&quot;,
        &quot;giacu&quot;: &quot;39.500.000&quot;,
        &quot;trangthai&quot;: 1
    },
    {
        &quot;masp&quot;: 2,
        &quot;tensp&quot;: &quot;Asus TUF Gaming FX507ZC4&quot;,
        &quot;anhdaidien&quot;: &quot;TUFGM2.jpg&quot;,
        &quot;chuyenmuc&quot;: &quot;CM3&quot;,
        &quot;mota&quot;: &quot;&quot;,
        &quot;hinhanhkhac1&quot;: &quot;TUFGM2.jpg&quot;,
        &quot;giamoi&quot;: &quot;19.290.000&quot;,
        &quot;giacu&quot;: &quot;25.590.000&quot;,
        &quot;trangthai&quot;: 1
    }
]</code>
 </pre>
    </span>
<span id="execution-results-GETapi-sanpham" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-sanpham"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-sanpham"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-sanpham" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-sanpham">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-sanpham" data-method="GET"
      data-path="api/sanpham"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-sanpham', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-sanpham"
                    onclick="tryItOut('GETapi-sanpham');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-sanpham"
                    onclick="cancelTryOut('GETapi-sanpham');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-sanpham"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/sanpham</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-sanpham"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-sanpham"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-sanpham--sanpham_masp-">GET api/sanpham/{sanpham_masp}</h2>

<p>
</p>



<span id="example-requests-GETapi-sanpham--sanpham_masp-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/sanpham/11" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/sanpham/11"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-sanpham--sanpham_masp-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;masp&quot;: 11,
    &quot;tensp&quot;: &quot;MacBook Air M2 2022&quot;,
    &quot;anhdaidien&quot;: &quot;Air-M2.jpg&quot;,
    &quot;chuyenmuc&quot;: &quot;CM1&quot;,
    &quot;mota&quot;: &quot;Loại card đồ họa : 8 nh&acirc;n GPU, 16 nh&acirc;n Neural Engine. |   \r\nDung lượng RAM : 8GB.|\r\nỔ cứng : 256GB. |\r\nHệ điều h&agrave;nh : MacOS. |\r\nLoại CPU : Apple M2. |\r\nTrọng lượng : 1.27 kg. |\r\nK&iacute;ch thước m&agrave;n h&igrave;nh : 13.6 inches.&quot;,
    &quot;hinhanhkhac1&quot;: &quot;Air-M2.jpg&quot;,
    &quot;giamoi&quot;: &quot;22.290.000&quot;,
    &quot;giacu&quot;: &quot;29.990.000&quot;,
    &quot;trangthai&quot;: 1
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-sanpham--sanpham_masp-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-sanpham--sanpham_masp-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-sanpham--sanpham_masp-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-sanpham--sanpham_masp-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-sanpham--sanpham_masp-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-sanpham--sanpham_masp-" data-method="GET"
      data-path="api/sanpham/{sanpham_masp}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-sanpham--sanpham_masp-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-sanpham--sanpham_masp-"
                    onclick="tryItOut('GETapi-sanpham--sanpham_masp-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-sanpham--sanpham_masp-"
                    onclick="cancelTryOut('GETapi-sanpham--sanpham_masp-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-sanpham--sanpham_masp-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/sanpham/{sanpham_masp}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-sanpham--sanpham_masp-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-sanpham--sanpham_masp-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sanpham_masp</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="sanpham_masp"                data-endpoint="GETapi-sanpham--sanpham_masp-"
               value="11"
               data-component="url">
    <br>
<p>Example: <code>11</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-register">POST api/register</h2>

<p>
</p>



<span id="example-requests-POSTapi-register">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/register" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"username\": \"consequatur\",
    \"password\": \"[2UZ5ij-e\\/dl4\",
    \"fullname\": \"consequatur\",
    \"email\": \"carolyne.luettgen@example.org\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/register"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "username": "consequatur",
    "password": "[2UZ5ij-e\/dl4",
    "fullname": "consequatur",
    "email": "carolyne.luettgen@example.org"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-register">
</span>
<span id="execution-results-POSTapi-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-register"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-register">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-register" data-method="POST"
      data-path="api/register"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-register"
                    onclick="tryItOut('POSTapi-register');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-register"
                    onclick="cancelTryOut('POSTapi-register');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-register"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/register</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>username</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="username"                data-endpoint="POSTapi-register"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-register"
               value="[2UZ5ij-e/dl4"
               data-component="body">
    <br>
<p>Must be at least 3 characters. Example: <code>[2UZ5ij-e/dl4</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>fullname</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="fullname"                data-endpoint="POSTapi-register"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-register"
               value="carolyne.luettgen@example.org"
               data-component="body">
    <br>
<p>Must be a valid email address. Example: <code>carolyne.luettgen@example.org</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-login">POST api/login</h2>

<p>
</p>



<span id="example-requests-POSTapi-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"username\": \"consequatur\",
    \"password\": \"consequatur\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "username": "consequatur",
    "password": "consequatur"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-login">
</span>
<span id="execution-results-POSTapi-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-login" data-method="POST"
      data-path="api/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-login"
                    onclick="tryItOut('POSTapi-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-login"
                    onclick="cancelTryOut('POSTapi-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>username</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="username"                data-endpoint="POSTapi-login"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-login"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-logout">POST api/logout</h2>

<p>
</p>



<span id="example-requests-POSTapi-logout">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/logout" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/logout"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-logout">
</span>
<span id="execution-results-POSTapi-logout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-logout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-logout"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-logout">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-logout" data-method="POST"
      data-path="api/logout"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-logout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-logout"
                    onclick="tryItOut('POSTapi-logout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-logout"
                    onclick="cancelTryOut('POSTapi-logout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-logout"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/logout</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
