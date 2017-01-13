<ul class="ComponentControl" ComponentControl>
	{foreach $componentLibraryComponent->getStates() as $stateName => $stateValues}
		<li class="ComponentControl_field">
			<div class="ComponentControl_fieldName">
				{$stateName}
			</div>
			<ul class="ComponentControl_values">
				{foreach $stateValues as $stateValue}
					<li class="ComponentControl_value {if $stateValue['active']}ComponentControl_value-active{/if}">
						<a href="{[
						'controller' => 'componentLibrary',
						'action' => 'view',
						'componentName' => $componentLibraryComponent->name
						]|route}?fields={$stateValue['fields']|json_encode|urlencode}"
						   class="ComponentControl_valueLink"
						>
							{$stateValue['name']|json_encode|htmlentities}
						</a>
					</li>
				{/foreach}
			</ul>
		</li>
	{/foreach}
</ul>

<script type="application/javascript">
	window.addEventListener('keydown', function(event){
		if(event.keyCode == 32) {
			var componentControl = document.querySelectorAll('[ComponentControl]');
			[].map.call(componentControl, function(element) {
				element.classList.toggle('ComponentControl-hidden');
			});
		}
	});
</script>