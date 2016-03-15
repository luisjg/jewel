@extends('layouts.masterdocs')

@section('title') Documentation @stop

@section('content')
	<div class="container">
		<div id="sidebar" class="col-md-3 col-sm-12">
		
			<a href="#firstHeading" class="h5 item item-1">Menu Item 1</a>
			<ul>
				<li><a href="#firstMenuItem" class="item item-2">Submenu Item 1.1</a></li>
				<li><a href="#secMenuItem" class="item item-3">Submenu Item 1.2</a></li>
			</ul>
			<a href="#secHeading" class="h5 item item-4">Menu Item 2</a>
			<ul>
				<li><a href="#thirdMenuItem" class="item item-5">Submenu Item 2.1</a></li>
				<li><a href="#fourthMenuItem" class="item item-6">Submenu Item 2.2</a></li>
			</ul>
		</div>
		<div class="docs-content col-md-9 col-sm-12">
			<div class="types">
				<div class="col-sm-12">
					<h2 class="page-header" id="firstHeading">Menu Item 1</h2>
					<p><span class="label label-lg label-secondary">$code</span> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam hic vitae doloremque sunt, officia expedita, sequi, eveniet eligendi vel debitis corrupti dolor cumque aliquid quas, nostrum necessitatibus soluta id nulla!</p>

					<h3 id="firstMenuItem">Submenu Item 1.1</h3>
					<ul>
						<li>Type: Boolean</li>
						<li>Default: false</li>
						<li>Usage: </li>
					</ul>
					<pre class="language-json">
						<code class="language-json">
							<span class="token operator">$code = true;</span>
						</code>
					</pre>
					<p>Aliquid numquam ad illum. Minus distinctio magnam, quasi odio nesciunt doloremque officia sit omnis, facilis eum cumque, impedit cum adipisci tempore libero.</p>
					<div class="well">
						<p>	The subcollection URI allows the consumer to obtain a list of courses or classes that are
		either part of a single program or Class Name.</p>
					</div> 
					<h3 id="secMenuItem">Submenu Item 1.2</h3>
					<ul>
						<li>Arguments</li>
						<ul>
							<li><span class="label label-lg label-secondary">{Objects} options</span></li>
						</ul>
						<li>
							Usage:
							<p>Aspernatur id, nihil aperiam ducimus sed praesentium magni inventore a eligendi, fugiat nisi possimus in provident, aliquid <span class="label label-lg label-secondary">quis</span> temporibus, animi! Quasi, labore.</p>
							<pre class="language-html">
								<code class="language-html">
									<span class="token tag"><span class="token punctuation">&lt;</span>div id="mount-point"<span class="token punctuation">&gt;</span><span class="token punctuation">&lt;</span>/div<span class="token punctuation">&gt;</span></span>
								</code>
							</pre>
						</li>
					</ul>
				</div>
			</div>
			<div class="types">
				<div class="col-sm-12">
					<h2 class="page-header" id="secHeading">Menu Item 2</h2>
					<p><span class="label label-lg label-secondary">$code</span> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam hic vitae doloremque sunt, officia expedita, sequi, eveniet eligendi vel debitis corrupti dolor cumque aliquid quas, nostrum necessitatibus soluta id nulla!</p>

					<h3 id="thirdMenuItem">Submenu Item 2.1</h3>
					<ul>
						<li>Type: Boolean</li>
						<li>Default: false</li>
						<li>Usage: </li>
					</ul>
					<pre class="language-json">
						<code class="language-json">
							<span class="token operator">$code = true;</span>
						</code>
					</pre>
					<p>Aliquid numquam ad illum. Minus distinctio magnam, quasi odio nesciunt doloremque officia sit omnis, facilis eum cumque, impedit cum adipisci tempore libero.</p>
					<div class="well">
						<p>	The subcollection URI allows the consumer to obtain a list of courses or classes that are
		either part of a single program or Class Name.</p>
					</div> 
					<h3 id="fourthMenuItem">Submenu Item 2.2</h3>
					<ul>
						<li>Arguments</li>
						<ul>
							<li><span class="label label-lg label-secondary">{Objects} options</span></li>
						</ul>
						<li>
							Usage:
							<p>Aspernatur id, nihil aperiam ducimus sed praesentium magni inventore a eligendi, fugiat nisi possimus in provident, aliquid <span class="label label-lg label-secondary">quis</span> temporibus, animi! Quasi, labore.</p>
							<pre class="language-html">
								<code class="language-html">
									<span class="token tag"><span class="token punctuation">&lt;</span>div id="mount-point"<span class="token punctuation">&gt;</span><span class="token punctuation">&lt;</span>/div<span class="token punctuation">&gt;</span></span>
								</code>
							</pre>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../public/js/sidebar.js"></script>	
@stop