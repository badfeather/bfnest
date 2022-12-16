<?php
	// Create id attribute allowing for custom "anchor" value.
	$id = $block['id'];
	$block_slug = str_replace( 'acf/', '', $block['name'] );
	$align = $block['align'];
	$classes = array( 'block', 'block--' . $block_slug );
	if ( $align ) {
		$classes[] = 'align' . $align;
	}
?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo join( ' ', $classes ); ?>">
	<div class="style-tester">
		<h4>Headings:</h4>

		<h1>Heading 1</h1>

		<h2>Heading 2</h2>

		<h3>Heading 3</h3>

		<h4>Heading 4</h4>

		<h5>Heading 5</h5>

		<h6>Heading 6</h6>

		<hr />

		<h4>Paragraphs and inline elements:</h4>
		<p>Lorem ipsum dolor sit amet, <a title="test link" href="#">test link</a> adipiscing elit. <strong>This is strong.</strong> Nullam dignissim convallis est. Quisque aliquam. <em>This is emphasized.</em> Donec faucibus. Nunc iaculis suscipit dui. 5<sup>3</sup> = 125. Water is H<sub>2</sub>O. Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. <cite>The New York Times</cite> (That&#8217;s a citation). <span style="text-decoration:underline;">Underline.</span> Maecenas ornare tortor. Donec sed tellus eget sapien fringilla nonummy. Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus.</p>

		<p><abbr title="Hyper Text Markup Language">HTML</abbr> and <abbr title="Cascading Style Sheets">CSS</abbr> are our tools. Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. To copy a file type <code>COPY <var>filename</var></code>. <del>Dinner&#8217;s at 5:00.</del> <ins>Let&#8217;s make that 7.</ins> This <span style="text-decoration:line-through;">text</span> has been struck.</p>

		<hr />

		<h4>Tables:</h4>
		<table>
			<tr>
				<th>Table Header 1</th>
				<th>Table Header 2</th>
				<th>Table Header 3</th>
			</tr>
			<tr>
				<td>Division 1</td>
				<td>Division 2</td>
				<td>Division 3</td>
			</tr>
			<tr>
				<td>Division 1</td>
				<td>Division 2</td>
				<td>Division 3</td>
			</tr>
			<tr>
				<td>Division 1</td>
				<td>Division 2</td>
				<td>Division 3</td>
			</tr>
		</table>

		<hr />

		<h4>Preformatted Text:</h4>

		<pre>&ldquo;Beware the Jabberwock, my son!
The jaws that bite, the claws that catch!
Beware the Jubjub bird, and shun
The frumious Bandersnatch!&rdquo;</pre>

		<hr />

		<h4>Code:</h4>
		<p>Code can be presented inline, like <code>&lt;?php bloginfo('stylesheet_url'); ?&gt;</code>, or within a <code>&lt;pre&gt;</code> block. Because we have more specific typographic needs for code, we&#8217;ll specify Consolas and Monaco ahead of the browser-defined monospace font.</p>

		<pre><code>#container {
	float: left;
	margin: 0 -240px 0 0;
	width: 100%;
}</code></pre>

		<hr />

		<h4>Form Elements:</h4>

		<form>
			<div class="form-group form-group--validate">
				<input id="text" name="text" type="text" class="form-control" placeholder="text" />
				<label for="text">Text</label>
				<div class="helper-text">Helper text</div>
			</div>

			<div class="form-group form-group--validate">
				<input id="text-required" name="text" type="text" class="form-control required" placeholder="text" required />
				<label for="text-required">Required Text</label>
				<div class="helper-text">This field is required</div>
			</div>

			<div class="form-group form-group--validate">
				<input id="email" name="email" type="email" class="form-control invalid" placeholder="email address" />
				<label for="email">Email address</label>
				<div class="helper-text">Must be a valid email address</div>
			</div>

			<div class="form-group">
				<label for="search-test">Search</label>
				<input id="search-test" name="search" type="search" class="form-control" placeholder="search" />
			</div>

			<div class="form-group">
				<label for="textarea">Textarea</label>
				<textarea name="textarea" id="textarea" class="form-control" placeholder="Textarea"></textarea>
			</div>

			<div class="form-group">
				<label for="select">Select</label>
				<select id="select" class="form-control">
					<option selected>- select an option -</option>
					<option value="1">One</option>
					<option value="2">Two</option>
					<option value="3">Three</option>
				</select>
			</div>

			<fieldset class="form-group">
				<legend>Radio</legend>

				<div class="form-check">
					<input type="radio" id="radio-1" name="radio-1" value="radio-1" checked>
					<label for="radio-1">Radio 1</label>
				</div>

				<div class="form-check">
					<input type="radio" id="radio-2" name="radio-2" value="radio-2">
					<label for="radio-2">Radio 2</label>
				</div>

				<div class="form-check">
					<input type="radio" id="radio-3" name="radio-3" value="radio-3">
					<label for="radio-3">Radio 3</label>
				</div>
			</fieldset>

			<fieldset class="form-group">
				<legend>Choose some monster features</legend>

				<div class="form-check">
					<input type="checkbox" id="checkbox-1" name="checkbox-1" value="checkbox-1" checked />
					<label for="checkbox-1">Checkbox 1</label>
				</div>

				<div class="form-check">
					<input type="checkbox" id="checkbox-2" name="checkbox-2" value="checkbox-2" />
					<label for="checkbox-2">Checkbox 2</label>
				</div>

				<div class="form-check">
					<input type="checkbox" id="checkbox-3" name="checkbox-3" value="checkbox-3" />
					<label for="checkbox-3">Checkbox 3</label>
				</div>

			</fieldset>

			<fieldset class="form-group form-row form-row--inline">
				<legend>Radio</legend>

				<div class="form-check">
					<input type="radio" id="inline-radio-1" name="inline-radio-1" value="inline-radio-1" checked>
					<label for="radio-1">Radio 1</label>
				</div>

				<div class="form-check">
					<input type="radio" id="inline-radio-2" name="inline-radio-2" value="inline-radio-2">
					<label for="radio-2">Radio 2</label>
				</div>

				<div class="form-check">
					<input type="radio" id="inline-radio-3" name="inline-radio-3" value="inline-radio-3">
					<label for="radio-3">Radio 3</label>
				</div>
			</fieldset>

			<fieldset class="form-group form-row form-row--inline">
				<legend>Choose some monster features</legend>

				<div class="form-check">
					<input type="checkbox" id="inline-checkbox-1" name="inline-checkbox-1" value="inline-checkbox-1" checked />
					<label for="checkbox-1">Checkbox 1</label>
				</div>

				<div class="form-check">
					<input type="checkbox" id="inline-checkbox-2" name="inline-checkbox-2" value="inline-checkbox-2" />
					<label for="checkbox-2">Checkbox 2</label>
				</div>

				<div class="form-check">
					<input type="checkbox" id="inline-checkbox-3" name="inline-checkbox-3" value="inline-checkbox-3" />
					<label for="checkbox-3">Checkbox 3</label>
				</div>
			</fieldset>

			<input name="submit" type="submit" value="Submit" class="btn" />

		</form>

		<h4>Inline form</h4>
		<form>
			<div class="form-row--inline">
				<label for="text-inline">Text</label>
				<input id="text-inline" name="text" type="text" class="form-control" placeholder="text" />

				<div class="form-check">
					<label for="checkbox-inline">Checkbox 1</label>
					<input type="checkbox" id="checkbox-inline" name="checkbox-inline" value="checkbox-inline" checked />
				</div>

				<input name="submit" type="submit" value="Submit" class="btn" />
			</div>
		</form>

		<hr />

		<h4>Button Classes:</h4>

		<p><button>button</button></p>

		<p><button class="btn--l">btn--l</button></p>

		<p><button class="btn--s">btn--s</button></p>

		<p><button class="btn--xs">btn--xs</button></p>

		<p><button class="disabled">btn--disabled</button></p>

		<p><button class="btn--secondary">btn--secondary</button></p>

		<p><button class="btn--success">btn--success</button></p>

		<p><button class="btn--warning">btn--warning</button></p>

		<p><button class="btn--danger">btn--danger</button></p>

		<p><button class="btn--info">btn--info</button></p>

		<p><button class="btn--outline">btn--outline</button></p>

		<p><button class="btn--trans">btn--trans</button></p>

		<p><button class="btn--block">btn--block</button></p>

		<p><a class="btn">Link button</a> next to a <button>&lt;button&gt;</button> next to a <input name="submit" class="btn" type="submit" value="&lt;Submit&gt;"></p>

		<hr />

		<h4>Unordered List:</h4>

		<ul>
			<li>List item</li>
			<li>List item
				<ul>
					<li>List item</li>
					<li>List item</li>
					<li>List item</li>
				</ul>
			</li>
			<li>List item</li>
		</ul>

		<hr />

		<h4>Ordered List:</h4>
		<ol>
			<li>List item</li>
			<li>List item
				<ol>
					<li>List item</li>
					<li>List item</li>
					<li>List item</li>
				</ol>
			</li>
			<li>List item</li>
		</ol>

		<hr />

		<h4>Definition List:</h4>

		<dl>
			<dt><dfn>Definition List Title</dfn></dt>
			<dd>This is a definition list division.</dd>
			<dt><dfn>Definition</dfn></dt>
			<dd>An exact statement or description of the nature, scope, or meaning of something: <em>our definition of what constitutes poetry.</em></dd>
		</dl>

		<hr />

		<h4>Blockquote:</h4>
		<blockquote>
		Lorem ipsum dolor sit amet, <a href="#">consectetur adipisicing elit</a>, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.

		Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		<cite>&mdash;Some Latin Dude</cite>
		</blockquote>

		<hr />

		<h4>Lede:</h4>

		<div class="lede">
		<p>Lorem ipsum dolor sit amet, <a href="#">consectetur adipisicing elit</a>, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
		<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		</div>

		<h4>Grid:</h4>
		<div class="row grid-test">
			<div class="cols-4">
				<div class="box">4</div>
			</div>
			<div class="cols-4">
				<div class="box">4</div>
			</div>
			<div class="cols-4">
				<div class="box">4</div>
			</div>
			<div class="cols-2">
				<div class="box">2</div>
			</div>
			<div class="cols-2">
				<div class="box">2</div>
			</div>
			<div class="cols-2">
				<div class="box">2</div>
			</div>
			<div class="cols-2">
				<div class="box">2 with longer content to break to more lines.</div>
			</div>
			<div class="cols-2">
				<div class="box">2</div>
			</div>
			<div class="cols-2">
				<div class="box">2</div>
			</div>
			<div class="cols-2 push-2">
				<div class="box">2 push 2</div>
			</div>
			<div class="cols-4">
				<div class="box">4</div>
			</div>
			<div class="cols-4">
				<div class="box">4</div>
			</div>
		</div>

		<h4>Colors</h4>
		<h5>grays</h5>
		<div class="grid-test color-test" style="display: flex;">
			<div class="box" style="background-color: var(--gray-5)">05</div>
			<div class="box" style="background-color: var(--gray-10)">10</div>
			<div class="box" style="background-color: var(--gray-20)">20</div>
			<div class="box" style="background-color: var(--gray-30)">30</div>
			<div class="box" style="background-color: var(--gray-40)">40</div>
			<div class="box" style="background-color: var(--gray-50)">50</div>
			<div class="box" style="background-color: var(--gray-60); color: #fff;">60</div>
			<div class="box" style="background-color: var(--gray-70); color: #fff;">70</div>
			<div class="box" style="background-color: var(--gray-80); color: #fff;">80</div>
			<div class="box" style="background-color: var(--gray-90); color: #fff;">90</div>
		</div>

		<h5>reds</h5>
		<div class="grid-test color-test" style="display: flex;">
			<div class="box" style="background-color: var(--red-5)">05</div>
			<div class="box" style="background-color: var(--red-10)">10</div>
			<div class="box" style="background-color: var(--red-20)">20</div>
			<div class="box" style="background-color: var(--red-30)">30</div>
			<div class="box" style="background-color: var(--red-40)">40</div>
			<div class="box" style="background-color: var(--red-50)">50</div>
			<div class="box" style="background-color: var(--red-60); color: #fff;">60</div>
			<div class="box" style="background-color: var(--red-70); color: #fff;">70</div>
			<div class="box" style="background-color: var(--red-80); color: #fff;">80</div>
			<div class="box" style="background-color: var(--red-90); color: #fff;">90</div>
		</div>

		<h5>oranges</h5>
		<div class="grid-test color-test" style="display: flex;">
			<div class="box" style="background-color: var(--orange-5)">05</div>
			<div class="box" style="background-color: var(--orange-10)">10</div>
			<div class="box" style="background-color: var(--orange-20)">20</div>
			<div class="box" style="background-color: var(--orange-30)">30</div>
			<div class="box" style="background-color: var(--orange-40)">40</div>
			<div class="box" style="background-color: var(--orange-50)">50</div>
			<div class="box" style="background-color: var(--orange-60); color: #fff;">60</div>
			<div class="box" style="background-color: var(--orange-70); color: #fff;">70</div>
			<div class="box" style="background-color: var(--orange-80); color: #fff;">80</div>
			<div class="box" style="background-color: var(--orange-90); color: #fff;">90</div>
		</div>

		<h5>yellows</h5>
		<div class="grid-test color-test" style="display: flex;">
			<div class="box" style="background-color: var(--yellow-5)">05</div>
			<div class="box" style="background-color: var(--yellow-10)">10</div>
			<div class="box" style="background-color: var(--yellow-20)">20</div>
			<div class="box" style="background-color: var(--yellow-30)">30</div>
			<div class="box" style="background-color: var(--yellow-40)">40</div>
			<div class="box" style="background-color: var(--yellow-50)">50</div>
			<div class="box" style="background-color: var(--yellow-60); color: #fff;">60</div>
			<div class="box" style="background-color: var(--yellow-70); color: #fff;">70</div>
			<div class="box" style="background-color: var(--yellow-80); color: #fff;">80</div>
			<div class="box" style="background-color: var(--yellow-90); color: #fff;">90</div>
		</div>

		<h5>limes</h5>
		<div class="grid-test color-test" style="display: flex;">
			<div class="box" style="background-color: var(--lime-5)">05</div>
			<div class="box" style="background-color: var(--lime-10)">10</div>
			<div class="box" style="background-color: var(--lime-20)">20</div>
			<div class="box" style="background-color: var(--lime-30)">30</div>
			<div class="box" style="background-color: var(--lime-40)">40</div>
			<div class="box" style="background-color: var(--lime-50)">50</div>
			<div class="box" style="background-color: var(--lime-60); color: #fff;">60</div>
			<div class="box" style="background-color: var(--lime-70); color: #fff;">70</div>
			<div class="box" style="background-color: var(--lime-80); color: #fff;">80</div>
			<div class="box" style="background-color: var(--lime-90); color: #fff;">90</div>
		</div>

		<h5>greens</h5>
		<div class="grid-test color-test" style="display: flex;">
			<div class="box" style="background-color: var(--green-5)">05</div>
			<div class="box" style="background-color: var(--green-10)">10</div>
			<div class="box" style="background-color: var(--green-20)">20</div>
			<div class="box" style="background-color: var(--green-30)">30</div>
			<div class="box" style="background-color: var(--green-40)">40</div>
			<div class="box" style="background-color: var(--green-50)">50</div>
			<div class="box" style="background-color: var(--green-60); color: #fff;">60</div>
			<div class="box" style="background-color: var(--green-70); color: #fff;">70</div>
			<div class="box" style="background-color: var(--green-80); color: #fff;">80</div>
			<div class="box" style="background-color: var(--green-90); color: #fff;">90</div>
		</div>

		<h5>springs</h5>
		<div class="grid-test color-test" style="display: flex;">
			<div class="box" style="background-color: var(--spring-5)">05</div>
			<div class="box" style="background-color: var(--spring-10)">10</div>
			<div class="box" style="background-color: var(--spring-20)">20</div>
			<div class="box" style="background-color: var(--spring-30)">30</div>
			<div class="box" style="background-color: var(--spring-40)">40</div>
			<div class="box" style="background-color: var(--spring-50)">50</div>
			<div class="box" style="background-color: var(--spring-60); color: #fff;">60</div>
			<div class="box" style="background-color: var(--spring-70); color: #fff;">70</div>
			<div class="box" style="background-color: var(--spring-80); color: #fff;">80</div>
			<div class="box" style="background-color: var(--spring-90); color: #fff;">90</div>
		</div>

		<h5>cyans</h5>
		<div class="grid-test color-test" style="display: flex;">
			<div class="box" style="background-color: var(--cyan-5)">05</div>
			<div class="box" style="background-color: var(--cyan-10)">10</div>
			<div class="box" style="background-color: var(--cyan-20)">20</div>
			<div class="box" style="background-color: var(--cyan-30)">30</div>
			<div class="box" style="background-color: var(--cyan-40)">40</div>
			<div class="box" style="background-color: var(--cyan-50)">50</div>
			<div class="box" style="background-color: var(--cyan-60); color: #fff;">60</div>
			<div class="box" style="background-color: var(--cyan-70); color: #fff;">70</div>
			<div class="box" style="background-color: var(--cyan-80); color: #fff;">80</div>
			<div class="box" style="background-color: var(--cyan-90); color: #fff;">90</div>
		</div>

		<h5>azures</h5>
		<div class="grid-test color-test" style="display: flex;">
			<div class="box" style="background-color: var(--azure-5)">05</div>
			<div class="box" style="background-color: var(--azure-10)">10</div>
			<div class="box" style="background-color: var(--azure-20)">20</div>
			<div class="box" style="background-color: var(--azure-30)">30</div>
			<div class="box" style="background-color: var(--azure-40)">40</div>
			<div class="box" style="background-color: var(--azure-50)">50</div>
			<div class="box" style="background-color: var(--azure-60); color: #fff;">60</div>
			<div class="box" style="background-color: var(--azure-70); color: #fff;">70</div>
			<div class="box" style="background-color: var(--azure-80); color: #fff;">80</div>
			<div class="box" style="background-color: var(--azure-90); color: #fff;">90</div>
		</div>

		<h5>blues</h5>
		<div class="grid-test color-test" style="display: flex;">
			<div class="box" style="background-color: var(--blue-5)">05</div>
			<div class="box" style="background-color: var(--blue-10)">10</div>
			<div class="box" style="background-color: var(--blue-20)">20</div>
			<div class="box" style="background-color: var(--blue-30)">30</div>
			<div class="box" style="background-color: var(--blue-40)">40</div>
			<div class="box" style="background-color: var(--blue-50)">50</div>
			<div class="box" style="background-color: var(--blue-60); color: #fff;">60</div>
			<div class="box" style="background-color: var(--blue-70); color: #fff;">70</div>
			<div class="box" style="background-color: var(--blue-80); color: #fff;">80</div>
			<div class="box" style="background-color: var(--blue-90); color: #fff;">90</div>
		</div>

		<h5>violets</h5>
		<div class="grid-test color-test" style="display: flex;">
			<div class="box" style="background-color: var(--violet-5)">05</div>
			<div class="box" style="background-color: var(--violet-10)">10</div>
			<div class="box" style="background-color: var(--violet-20)">20</div>
			<div class="box" style="background-color: var(--violet-30)">30</div>
			<div class="box" style="background-color: var(--violet-40)">40</div>
			<div class="box" style="background-color: var(--violet-50)">50</div>
			<div class="box" style="background-color: var(--violet-60); color: #fff;">60</div>
			<div class="box" style="background-color: var(--violet-70); color: #fff;">70</div>
			<div class="box" style="background-color: var(--violet-80); color: #fff;">80</div>
			<div class="box" style="background-color: var(--violet-90); color: #fff;">90</div>
		</div>

		<h5>magentas</h5>
		<div class="grid-test color-test" style="display: flex;">
			<div class="box" style="background-color: var(--magenta-5)">05</div>
			<div class="box" style="background-color: var(--magenta-10)">10</div>
			<div class="box" style="background-color: var(--magenta-20)">20</div>
			<div class="box" style="background-color: var(--magenta-30)">30</div>
			<div class="box" style="background-color: var(--magenta-40)">40</div>
			<div class="box" style="background-color: var(--magenta-50)">50</div>
			<div class="box" style="background-color: var(--magenta-60); color: #fff;">60</div>
			<div class="box" style="background-color: var(--magenta-70); color: #fff;">70</div>
			<div class="box" style="background-color: var(--magenta-80); color: #fff;">80</div>
			<div class="box" style="background-color: var(--magenta-90); color: #fff;">90</div>
		</div>

		<h5>pinks</h5>
		<div class="grid-test color-test" style="display: flex;">
			<div class="box" style="background-color: var(--pink-5)">05</div>
			<div class="box" style="background-color: var(--pink-10)">10</div>
			<div class="box" style="background-color: var(--pink-20)">20</div>
			<div class="box" style="background-color: var(--pink-30)">30</div>
			<div class="box" style="background-color: var(--pink-40)">40</div>
			<div class="box" style="background-color: var(--pink-50)">50</div>
			<div class="box" style="background-color: var(--pink-60); color: #fff;">60</div>
			<div class="box" style="background-color: var(--pink-70); color: #fff;">70</div>
			<div class="box" style="background-color: var(--pink-80); color: #fff;">80</div>
			<div class="box" style="background-color: var(--pink-90); color: #fff;">90</div>
		</div>
	</div>
</div>
