<?php
$placement = $_REQUEST['PLACEMENT'];
$placementOptions = isset($_REQUEST['PLACEMENT_OPTIONS']) ? json_decode($_REQUEST['PLACEMENT_OPTIONS'], true) : array();
$handler = ($_SERVER['SERVER_PORT'] === '443' ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];

if(!is_array($placementOptions))
{
	$placementOptions = array();
}

if($placement === 'DEFAULT')
{
	$placementOptions['MODE'] = 'edit';
}
?>
<!DOCTYPE html>
<html>
<head>
	<script src="//api.bitrix24.com/api/v1/dev/"></script>
</head>
<body style="margin: 0; padding: 0; background-color: <?=$placementOptions['MODE'] === 'edit' ? '#fff' : '#f9fafb'?>;">
<div class="workarea">
<?
if(true || $placement === 'DEFAULT'):
?>
	<ul>
		<li><a href="javascript:void(0)" onclick="test.add()">userfieldtype.add</a></li>
		
	</ul>
	<pre id="debug" style="border: solid 1px #aaa; padding: 10px; background-color: #eee">&nbsp;</pre>
	<script>

		var test = {
			call: function(method, param)
			{
				BX24.callMethod(method, param, test.debug);
			},

			debug: function(result)
			{
				var s = '';

				s += '<b>' + result.query.method + '</b>\n';
				s += JSON.stringify(result.query.data, null, '  ') + '\n\n';

				if(result.error())
				{
					s += '<span style="color: red">Error! ' + result.error().getStatus() + ': ' + result.error().toString() + '</span>\n';
				}
				else
				{
					s += '<span>' + JSON.stringify(result.data(), null, '  ') + '</span>\n';
				}

				document.getElementById('debug').innerHTML = s;
			},

			add: function()
			{
				//company_50_details_timeline_sms
				document.getElementById('company_50_details_timeline_sms').innerHTML = "-------------------------";
			},

			list: function()
			{
				test.call('userfieldtype.list', {});
			},

			update: function()
			{
				test.call('userfieldtype.update', {
					USER_TYPE_ID: 'mytext',
					DESCRIPTION: 'Small unit-test for userfield type. ' + (new Date()).toString()
				});
			},

			del: function()
			{
				test.call('userfieldtype.delete', {
					USER_TYPE_ID: 'mytext'
				});
			}
		}
	</script>
<?
elseif($placement === 'USERFIELD_TYPE'):
	if($placementOptions['MODE'] === 'edit')
	{
		if($placementOptions['MULTIPLE'] === 'N')
		{
?>
	<input type="text" style="width: 90%;" value="<?=htmlspecialchars($placementOptions['VALUE'])?>" onkeyup="setValue(this.value)">
	<script>
		function setValue(value)
		{
			BX24.placement.call('setValue', value);
		}
	</script>
<?
		}
		else
		{
?>
	<textarea style="width: 90%; height: 100px;" onkeyup="setValue(this.value)"><?=htmlspecialchars(implode("\n", $placementOptions['VALUE']))?></textarea>
	<script>
		function setValue(value)
		{
			BX24.placement.call('setValue', value.split('\n'));
		}
	</script>
	<?
		}
	}
	else
	{

		if(is_array($placementOptions['VALUE']))
		{
			foreach($placementOptions['VALUE'] as $value)
			{
				echo '<li>'.htmlspecialchars($value).'</li>';
			}
		}
		else
		{
			echo '<i>'.htmlspecialchars($placementOptions['VALUE']).'</i>';
		}

	}

endif;
?>
</div>
<script>
	BX24.ready(function()
	{
		BX24.init(function()
		{
			BX24.resizeWindow(document.body.clientWidth,
				document.getElementsByClassName("workarea")[0].clientHeight);
		})
	});
</script>

</body>
</html>
