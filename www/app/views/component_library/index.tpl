<ul>
	{foreach $components as $component}
		<li>
			<a href="{[
				'controller' => 'componentLibrary',
				'action' => 'view',
				'componentName' => $component->name
			]|route}">
				{$component->name}
			</a>
		</li>
	{/foreach}
</ul>
