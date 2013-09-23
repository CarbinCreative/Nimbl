<h1>{{title}}</h1>

{{entries?}}

	{{#entries}}
		<hr />

		<div id="post-{{cursor}}">

			<h3>{{entries.title}}</h3>

			<p>{{entries.body}}</p>

		</div>
	{{@entries}}
	{{!entries}}
		<p>No entries.</p>
{{/entries}}