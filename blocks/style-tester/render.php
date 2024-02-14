<?php
// Create id attribute allowing for custom "anchor" value.
$id = $block['id'];
$block_slug = str_replace( 'psmeats/', '', $block['name'] );
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
				<input id="text" name="text" type="text" class="input" placeholder="text" />
				<label for="text">Text</label>
				<div class="helper-text">Helper text</div>
			</div>

			<div class="form-group form-group--validate">
				<input id="text-required" name="text" type="text" class="input required" placeholder="text" required />
				<label for="text-required">Required Text</label>
				<div class="helper-text">This field is required</div>
			</div>

			<div class="form-group form-group--validate">
				<input id="email" name="email" type="email" class="input invalid" placeholder="email address" />
				<label for="email">Email address</label>
				<div class="helper-text">Must be a valid email address</div>
			</div>

			<div class="form-group">
				<label for="search-test">Search</label>
				<input id="search-test" name="search" type="search" class="input" placeholder="search" />
			</div>

			<div class="form-group">
				<label for="textarea">Textarea</label>
				<textarea name="textarea" id="textarea" class="input" placeholder="Textarea"></textarea>
			</div>

			<div class="form-group">
				<label for="select">Select</label>
				<select id="select" class="input">
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
				<input id="text-inline" name="text" type="text" class="input" placeholder="text" />

				<div class="form-check">
					<label for="checkbox-inline">Checkbox 1</label>
					<input type="checkbox" id="checkbox-inline" name="checkbox-inline" value="checkbox-inline" checked />
				</div>

				<input name="submit" type="submit" value="Submit" class="btn" />
			</div>
		</form>

		<hr />

		<h4>Button Classes:</h4>

		<p><button class="btn">button</button></p>

		<p><button class="btn btn--l">btn--l</button></p>

		<p><button class="btn btn--s">btn--s</button></p>

		<p><button class="btn btn--xs">btn--xs</button></p>

		<p><button class="btn disabled">btn--disabled</button></p>

		<p><button class="btn btn--secondary">btn--secondary</button></p>

		<p><button class="btn btn--success">btn--success</button></p>

		<p><button class="btn btn--warning">btn--warning</button></p>

		<p><button class="btn btn--danger">btn--danger</button></p>

		<p><button class="btn btn--info">btn--info</button></p>

		<p><button class="btn btn--outline">btn--outline</button></p>

		<p><button class="btn btn--trans">btn--trans</button></p>

		<p><button class="btn btn--block">btn--block</button></p>

		<p><a class="btn">Link button</a> next to a <button class="btn">&lt;button&gt;</button> next to a <input name="submit" class="btn" type="submit" value="&lt;Submit&gt;"></p>

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
			<p>Lorem ipsum dolor sit amet, <a href="#">consectetur adipisicing elit</a>, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

			<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			<cite>&mdash;Some Latin Dude</cite>
		</blockquote>

		<h4>Pullquote:</h4>
		<blockquote class="pullquote">
			<p>Lorem ipsum dolor sit amet, <a href="#">consectetur adipisicing elit</a>, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
			<cite>&mdash;Some Latin Dude</cite>
		</blockquote>

		<hr />

		<h4>Lede:</h4>

		<div class="lede">
		<p>Lorem ipsum dolor sit amet, <a href="#">consectetur adipisicing elit</a>, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
		<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		</div>
	</div>
</div>
