@extends('layouts.masterdocs')

@section('title') Documentation @stop

@section('content')
		<div class="container">
			<div class="col-sm-2" id="sidebar">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">Heading</div>
					</div>
					<ul class="list-group">
						<li class="list-group-item"><a href="#text">Text elements</a></li>
						<li class="list-group-item"><a href="#well">Well</a></li>
						<li class="list-group-item"><a href="#code">Display Code</a></li>
					</ul>
				</div>
			</div>
			<div class="col-sm-9 col-sm-offset-3">
				<div class="types">
					<h3 id="text" class="target">Text Elements</h3>
					<h1>Heading 1</h1>
					<h2>Heading 2</h2>
					<h3>Heading 3</h3>
					<h4>Heading 4</h4>
					<h5>Heading 5</h5>
					<h3 class="highlight">Highlight</h3>
					<hr>
					<h4>Numbered List</h4>
					<div class="number-list">
						<span class="number-list--type">1</span>
						<span class="number-list--title">Numbered list item</span>
						<p class="number-list--content">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
						<span class="number-list--type">2</span>
						<span class="number-list--title">Numbered list item</span>
						<p class="number-list--content">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
						<span class="number-list--type">3</span>
						<span class="number-list--title">Numbered list item</span>
						<p class="number-list--content">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
					</div>
					<hr>
					<h4>URL's</h4>
					<p class="url"><a href="#">http://www.url.com</a></p>
					<p class="url"><a href="#">http://www.url.com</a></p>
					<p class="url"><a href="#">http://www.url.com</a></p>
					<hr>
					<h4>Descriptions</h4>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem delectus saepe, quo, reiciendis nihil reprehenderit vero sit eius veniam quibusdam quasi ipsum aperiam dolores officiis perferendis! Obcaecati quam molestias amet.</p>
				</div>
				<div class="types">
					<h3 id="well" class="target">Wells</h3>
					<div class="well">
						<p>	The subcollection URI allows the consumer to obtain a list of courses or classes that are
			either part of a single program or Class Name.</p>
					</div>
				</div>
				<div class="types">
					<h3 id="code" class="target">Display Code</h3>
					<p>Use <a href="http://www.prismjs.com" target="blank">Prism.js</a> to display code.</p>
					<pre class="language-json">
					<code class="language-json">
						<span class="token operator">{</span>
							<span class="token string">"glossary"</span><span class="token operator">: </span><span class="token operator">{</span>
							<span class="token string">"title"</span><span class="token operator">: </span><span class="token string">"example gloassary"</span><span class="token operator">, </span>
							<span class="token string">"GlossDiv"</span><span class="token operator">: </span><span class="token operator">{</span>
									<span class="token string">"title"</span><span class="token operator">: </span><span class="token string">"S"</span><span class="token operator">, </span>
									<span class="token string">"GlossList"</span><span class="token operator">: </span><span class="token operator">{</span>
										<span class="token string">"GlossEntry"</span><span class="token operator">: </span><span class="token operator">{</span>
											<span class="token string">"ID"</span><span class="token operator">: </span><span class="token string">"SMGL"</span><span class="token operator">, </span>
											<span class="token string">"SortAs"</span><span class="token operator">: </span><span class="token string">"SMGL"</span><span class="token operator">, </span>
											<span class="token string">"GlossTerm"</span><span class="token operator">: </span><span class="token string">"Standard Generalized Markup language"</span><span class="token operator">, </span>
											<span class="token string">"Acronym"</span><span class="token operator">: </span><span class="token string">"SMGL"</span><span class="token operator">, </span>
											<span class="token string">"Abbrev"</span><span class="token operator">: </span><span class="token string">"ISO 8879:1986"</span><span class="token operator">, </span>
											<span class="token string">"GlossDef"</span><span class="token operator">: </span><span class="token operator">{</span>
												<span class="token string">"para"</span><span class="token operator">: </span><span class="token string">"A meta-markup language, used to create markup languages such as DocBook."</span><span class="token operator">, </span>
												<span class="token string">"GlossSeeAlso"</span><span class="token operator">: </span><span class="token array">["GML", "XML"]</span>
											<span class="token operator">}</span><span class="token operator">, </span>
											<span class="token string">"GlossSee"</span><span class="token operator">: </span><span class="token string">"markup"</span>
										<span class="token operator">}</span>
									<span class="token operator">}</span>
								<span class="token operator">}</span>
							<span class="token operator">}</span>
						<span class="token operator">}</span>
					</code>
					</pre>
				</div>
			</div>
		</div>
@stop