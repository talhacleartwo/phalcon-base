<div id="Actionbar">
	<?php if(isset($ActionBarControls)) : ?>
		<?php
			if(isset($ActionBarControls->actions))
			{
				foreach($ActionBarControls->actions as $abc)
				{
					$method = isset($abc->method) ? 'data-action="'. $abc->method .'" ' : '';
					$route = isset($abc->route) ? 'data-route="' . $abc->route . '" ' : '';
					$redir = isset($abc->redir) ? 'data-redir="'.$abc->redir.'" ' : '';
					$modal = isset($abc->modal) ? 'data-modal="'.$abc->modal.'" ' : '';
					$conf = isset($abc->confirm) ? 'data-confirm="'.$abc->confirm.'" ' : '';
					
					echo '<button type="button" class="action" ' . $method . $route . $redir . $modal . $conf . '>';
						if($abc->icon){echo '<i class="'.$abc->icon.'"></i>';}
						echo $abc->text;
					echo '</button>';
				}
			}
			if(isset($ActionBarControls->bulkactions))
			{
				foreach($ActionBarControls->bulkactions as $abc)
				{
					$method = isset($abc->method) ? 'data-action="'. $abc->method .'" ' : '';
					$route = isset($abc->route) ? 'data-route="' . $abc->route . '" ' : '';
					
					echo '<button type="button" class="bulkaction" '. $route . $method . '>';
						if($abc->icon){echo '<i class="'.$abc->icon.'"></i>';}
						echo $abc->text;
					echo '</button>';
				}
			}
		?>
	<?php endif; ?>
</div>