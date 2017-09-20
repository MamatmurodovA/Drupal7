<table border="1" cellpadding="1" cellspacing="1" style="line-height:20.8px">
	<thead>
		<tr>
			<th class="rtecenter" scope="col">&numero;</th>
			<th scope="col"><?php print t('Identification number  of Open data (code)');?></th>
			<th class="rtecenter" scope="col"><?php print t('Open data collection name');?></th>
			<th class="rtecenter" scope="col"><?php print t('Open data format');?></th>
			<th class="rtecenter" scope="col"><?php print t('Open data update frequency');?></th>
		</tr>
	</thead>
	<tbody>
		<?php if($result):?>
			<?php foreach ($result as $key => $item): ?>
				<tr>
					<td class="rteright"><?php print $key + 1; ?></td>
					<td><?php print $item->id; ?></td>
					<td><a href="<?php print $remote_server;?><?php print $lang;?>/datasets/download/<?php print $item->id; ?>/csv">
							<?php print $item->title; ?>
						</a>
					</td>
					<td class="rtecenter">csv</td>
					<td class="rtecenter"><?php print t('Quarterly');?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
